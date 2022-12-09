<?php
    require '../conexion.php';

    //$nombre_edt         =   strtoupper($_POST['nombre_usuario_edt']);
    $query_values = $_POST;
    //print_r($query_values); exit;

    $numero_id = $_GET['ID'];
    //print_r($numero_id); exit;
    //verify anti sql injection 
    $numero_id =  $conectar->real_escape_string($numero_id);


    // CONSULTA DE DATOS DEL AUSENTISMO ALMACENADOS EN LA BASE DE DATOS
    $sqli   = "SELECT ausentismos.*, funcionarios.*, dependencias.ID as ID_depen, dependencias.C_costo as C_costo, dependencias.Departamento as Departamento, dependencias.Facultad as Facultad
                FROM ausentismos 
                INNER JOIN funcionarios On funcionarios.Cedula=ausentismos.Cedula_F
                INNER JOIN dependencias ON funcionarios.Dependencia=dependencias.ID
                WHERE ausentismos.ID = $numero_id";
    $result = $conectar->query($sqli);
    $row = mysqli_fetch_assoc($result);


    // verificar que ningun campo de $query_values esté vacio
    foreach($query_values as $key => $value){
        if(empty($value)){
            echo "<script>alert('Complete todos los campos.'); location.href = '../pages/admin_edit_ausen.php?ID=$numero_id'; </script>"; exit;
        }
    }

    //ACTUALIZAR DATOS DEL AUSENTISMO
    if($query_values['fechaI_ausen_edt'] != $row['Fecha_Inicio']){
        $fecha_edt = $query_values['fechaI_ausen_edt'];
        $actualizar = "UPDATE ausentismo SET Fecha_Inicio = '$fecha_edt' WHERE ID = $numero_id";
        $sqli1          = $conectar->query($actualizar);
    }

    if($query_values['fechaF_ausen_edt'] != $row['Fecha_Fin']){
        $fecha_edt = $query_values['fechaF_ausen_edt'];
        $actualizar = "UPDATE ausentismo SET Fecha_Fin = '$fecha_edt' WHERE ID = $numero_id";
        $sqli1          = $conectar->query($actualizar);
    }

    //update tiempo
    if($query_values['tiempo_ausen_edt'] != $row['Tiempo']){
        $tiempo_edt = $query_values['tiempo_ausen_edt'];
        $actualizar = "UPDATE ausentismo SET Tiempo = '$tiempo_edt' WHERE ID = $numero_id";
        $sqli1          = $conectar->query($actualizar);
    }

    //update unidad
    if($query_values['unidad_ausen_edt'] != $row['Unidad']){
        $unidad_edt = $query_values['unidad_ausen_edt'];
        $actualizar = "UPDATE ausentismo SET Unidad = '$unidad_edt' WHERE ID = $numero_id";
        $sqli1          = $conectar->query($actualizar);
    }

    //update observacion
    if($query_values['obser_ausen_edt'] != $row['Observacion']){
        $observacion_edt = $query_values['obser_ausen_edt'];
        $actualizar = "UPDATE ausentismo SET Observacion = '$observacion_edt' WHERE ID = $numero_id";
        $sqli1          = $conectar->query($actualizar);
    }

    //update costo
    if($query_values['costo_ausen_edt'] != $row['Seguridad_Trabajo']){
        $costo_edt = $query_values['costo_ausen_edt'];
        $actualizar = "UPDATE ausentismo SET Seguridad_Trabajo = '$costo_edt' WHERE ID = $numero_id";
        $sqli1          = $conectar->query($actualizar);
    }

    //update tipo
    if($query_values['tipo_ausen_edt'] != $row['Tipo_Ausentismo']){
        $tipo_edt = $query_values['tipo_ausen_edt'];
        $actualizar = "UPDATE ausentismo SET Tipo_Ausentismo = '$tipo_edt' WHERE ID = $numero_id";
        $sqli1          = $conectar->query($actualizar);
    }



    echo "<script>
        alert('Datos Actualizados Correctamtne');
        location.href='../pages/admin_consultar.php';
    </script>"

?>