<?php
    require '../conexion.php';

    //$nombre_edt         =   strtoupper($_POST['nombre_usuario_edt']);
    $query_values = $_POST;
    //print_r($query_values); exit;

    $numero_id = $_POST['ID']; //obtener el numero de ID del ausentismo
    //print_r($numero_id); exit;
    //verify anti sql injection 
    $numero_id =  $conectar->real_escape_string($numero_id);


    // CONSULTA DE DATOS DEL AUSENTISMO ALMACENADOS EN LA BASE DE DATOS
    $sqli   = "SELECT ausentismos.*, funcionarios.*, dependencias.ID as ID_depen, dependencias.C_costo as C_costo, dependencias.Departamento as Departamento, dependencias.Facultad as Facultad,
                COALESCE(incapacidad.ID, 'N/A') as ID_In, COALESCE(incapacidad.Codigo, 'N/A') as Codigo, COALESCE(incapacidad.Diagnostico, 'N/A') as Diagnostico, 
                COALESCE(incapacidad.Entidad, 'N/A') as Entidad, COALESCE(incapacidad.ID_Ausentismo, 'N/A') as ID_Ausentismo
                FROM ausentismos 
                INNER JOIN funcionarios On funcionarios.Cedula=ausentismos.Cedula_F
                INNER JOIN dependencias ON funcionarios.Dependencia=dependencias.ID
                LEFT JOIN incapacidad ON ausentismos.ID = incapacidad.ID_Ausentismo
                WHERE ausentismos.ID = $numero_id";
    $result = $conectar->query($sqli);
    $row = mysqli_fetch_assoc($result);


    // verificar que ningun campo de $query_values esté vacio
    foreach($query_values as $key => $value){
        if(empty($value)){
            echo json_encode("error1"); exit;
        }
    }

    // verificar que el campo de fecha de inicio no sea mayor a la fecha de fin
    if($query_values['fechaI_ausen_edt'] > $query_values['fechaF_ausen_edt'] ){
        echo json_encode("error2");
        exit;
    }
    // verificar que el campo de tiempo sea igual a la diferencia de fechas
    if($query_values['unidad_ausen_edt']=='dias'){
        $fecha1 = new DateTime($query_values['fechaI_ausen_edt']);
        $fecha2 = new DateTime($query_values['fechaF_ausen_edt']);
        $dias = $fecha1->diff($fecha2);
        $dias = $dias->days + 1;
        if($query_values['tiempo_ausen_edt'] != $dias){
            echo json_encode("error3");
            exit;
        }
    }elseif($query_values['unidad_ausen_edt']=='horas'){
        //comprobar que las fechas sean iguales, si no entonces redirigir a la pagina de edicion
        if($query_values['fechaI_ausen_edt'] != $query_values['fechaF_ausen_edt']){
            echo json_encode("error4");
            exit;
        }
        //comprobar que el tipo sea un ausentismos de PERMISO POR HORAS
        if($query_values['tipo_ausen_edt'] != 5){
            echo json_encode("error5");
            exit;
        }
    }

    //ACTUALIZAR DATOS DEL AUSENTISMO
    if($query_values['fechaI_ausen_edt'] != $row['Fecha_Inicio']){
        $fecha_edt = $query_values['fechaI_ausen_edt'];
        $actualizar = "UPDATE ausentismos SET Fecha_Inicio = '$fecha_edt' WHERE ID = $numero_id";
        $sqli1          = $conectar->query($actualizar);
    }

    if($query_values['fechaF_ausen_edt'] != $row['Fecha_Fin']){
        $fecha_edt = $query_values['fechaF_ausen_edt'];
        $actualizar = "UPDATE ausentismos SET Fecha_Fin = '$fecha_edt' WHERE ID = $numero_id";
        $sqli1          = $conectar->query($actualizar);
    }

    //update tiempo
    if($query_values['tiempo_ausen_edt'] != $row['Tiempo']){
        $tiempo_edt = $query_values['tiempo_ausen_edt'];
        $actualizar = "UPDATE ausentismos SET Tiempo = '$tiempo_edt' WHERE ID = $numero_id";
        $sqli1          = $conectar->query($actualizar);
    }

    //update unidad
    if($query_values['unidad_ausen_edt'] != $row['Unidad']){
        $unidad_edt = $query_values['unidad_ausen_edt'];
        $actualizar = "UPDATE ausentismos SET Unidad = '$unidad_edt' WHERE ID = $numero_id";
        $sqli1          = $conectar->query($actualizar);
    }

    //update observacion
    if($query_values['obser_ausen_edt'] != $row['Observacion']){
        $observacion_edt = $query_values['obser_ausen_edt'];
        $actualizar = "UPDATE ausentismos SET Observacion = '$observacion_edt' WHERE ID = $numero_id";
        $sqli1          = $conectar->query($actualizar);
    }

    //update costo
    if($query_values['costo_ausen_edt'] != $row['Seguridad_Trabajo']){
        $costo_edt = $query_values['costo_ausen_edt'];
        $actualizar = "UPDATE ausentismos SET Seguridad_Trabajo = '$costo_edt' WHERE ID = $numero_id";
        $sqli1          = $conectar->query($actualizar);
    }

    //update tipo, si el ausentismos es de tipo 1 'INCAPACIDAD', y se quiere cambiar a otro tipo, entonces mostrar una alerta y redirigir a la pagina de edicion
    if($query_values['tipo_ausen_edt'] != $row['Tipo_Ausentismo'] ){ //AND $row['Tipo_Ausentismo'] != 1
        $tipo_edt = $query_values['tipo_ausen_edt'];
        $actualizar = "UPDATE ausentismos SET Tipo_Ausentismo = '$tipo_edt' WHERE ID = $numero_id";
        $sqli1          = $conectar->query($actualizar);
    }/*else{
        if( $row['Tipo_Ausentismo'] == 1){
            echo "<script>alert('No se puede cambiar el tipo de ausentismo, porque el ausentismo es de tipo INCAPACIDAD.'); 
                    location.href = '../pages/admin_edit_ausen.php?ID=$numero_id'; 
                </script>"; 
            exit;
        }
    }*/

    //si el Tipo_Ausentismo es 1 'INCAPACIDAD', entonces actualizar los campos de Codigo, Diagnostico y Entidad, en la tabal de incapacidad
    if($row['Tipo_Ausentismo'] == 1){
        $ID_in = $row['ID_In'];

        //update codigo
        if($query_values['codigo_ausen_edt'] != $row['Codigo']){

            //consultar si el codigo a actualizar 'codigo_ausen_edt' existe en la tabal de codigos de incapacidad, si no existe entonces redirigir a la pagina de editar ausentismo
            $codigo_edt = $query_values['codigo_ausen_edt'];
            //elimiar espacios en blanco en cualquier parte de la cadena
            $codigo_edt = preg_replace('/\s+/', '', $codigo_edt);
            $consulta = "SELECT * FROM codigos WHERE Codigo = '$codigo_edt'";
            $sqli1          = $conectar->query($consulta);
            if($sqli1->num_rows == 0){
                echo json_encode("error6");
                exit;
            }

            $actualizar = "UPDATE incapacidad SET Codigo = '$codigo_edt' WHERE ID = $ID_in";
            $sqli1          = $conectar->query($actualizar);
        }

        //update diagnostico
        if($query_values['diag_ausen_edt'] != $row['Diagnostico']){
            $diagnostico_edt = $query_values['diag_ausen_edt'];
            $actualizar = "UPDATE incapacidad SET Diagnostico = '$diagnostico_edt' WHERE ID = $ID_in";
            $sqli1          = $conectar->query($actualizar);
        }

        //update entidad
        if($query_values['entidad_ausen_edt'] != $row['Entidad']){
            $entidad_edt = $query_values['entidad_ausen_edt'];
            $actualizar = "UPDATE incapacidad SET Entidad = '$entidad_edt' WHERE ID = $ID_in";
            $sqli1          = $conectar->query($actualizar);
        }
    }

    echo json_encode("success"); exit();

?>