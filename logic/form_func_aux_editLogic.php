<?php
    require '../conexion.php';

    //$nombre_edt         =   strtoupper($_POST['nombre_usuario_edt']);
    $query_values = $_POST;
    //print_r($query_values); exit;

    $numero_id = $_POST['cedula_f'];
    //print_r($numero_id); exit;
    //verify anti sql injection 
    $numero_id =  $conectar->real_escape_string($numero_id);


    // CONSULTA DE DATOS DEL FUNCIONARIO ALMACENADOS EN LA BASE DE DATOS
    $sql = "SELECT * FROM func_auxiliar WHERE Cedula = '$numero_id'";
    $result = $conectar->query($sql);
    $Funcionario_Aux = mysqli_fetch_assoc($result);

    //Pasar los errores a un array 
    $errores = explode(",", $Funcionario_Aux['Error']);


    // verificar que ningun campo de $query_values esté vacio
    foreach($query_values as $key => $value){
        if(empty($value)){
            //echo "<script>alert('Complete todos los campos.'); location.href = '../pages/admin_aux_table_edition.php?ID=$numero_id'; </script>"; exit;
            echo $value;
            echo json_encode("error2"); exit;
        }
    }

    //ACTUALIZAR DATOS DEL FUNCIONARIO
    foreach($query_values as $key => $value){
        if($key != 'cedula_f' && $key != 'Dependencia'){
            //Actualizar si es diferente
            if($value != $Funcionario_Aux[$key]){
                $actualizar = "UPDATE func_auxiliar SET $key = '$value' WHERE Cedula = $numero_id";
                $sqli1          = $conectar->query($actualizar);
            }

        }else if($key == 'Dependencia'){

            // CONSULTA DE la dependencia seleccionada 
            $sql2 = "SELECT * FROM dependencias WHERE ID LIKE '".$query_values['Dependencia']."'";
            //print_r($sql2); exit;
            $result2 = $conectar->query($sql2); 
            //si no hay resultados, mostrar una alerta de que no hay resultados
            if($result2->num_rows == 0){
                //echo "<script>alert('No existe la dependencia seleccionada.'); location.href = '../pages/admin_aux_table_edition.php?ID=$numero_id'; </script>"; exit;
                echo json_encode("error1"); exit;
            }else{
                //si hay resultados, guardar el resultado 
                $Dependencia_BD = mysqli_fetch_assoc($result2);
            }

            //Actualizar si es diferente
            if($Dependencia_BD['ID'] != $Funcionario_Aux['Dependencia']){
                $actualizar = "UPDATE func_auxiliar SET $key = '$Dependencia_BD[ID]' WHERE Cedula = $numero_id";
                $sqli1          = $conectar->query($actualizar);

                //Quitar el error del arreglo de errores
                $errores = array_diff($errores, array('Dependencia'));

                //Actualizar el campo de errores del funcionario de la tabla auxiliar de carga
                $actualizar = "UPDATE func_auxiliar SET Error = '".implode(",", $errores)."' WHERE Cedula = $numero_id";
                $sqli1          = $conectar->query($actualizar);
            }
        }
    }

    //=================================================================================
    //if Estado is ACT or INACTIVO, AND  Genero is MAS or FEM, then update Error to N/A
    // CONSULTA DE DATOS DEL FUNCIONARIO ALMACENADOS EN LA BASE DE DATOS
    $sql = "SELECT * FROM func_auxiliar WHERE Cedula = ".$numero_id;
    $result = $conectar->query($sql);
    $Funcionario_Aux = mysqli_fetch_assoc($result);
    if($Funcionario_Aux['Estado'] == 'ACTIVO' || $Funcionario_Aux['Estado'] == 'INACTIVO' AND $Funcionario_Aux['Genero'] == 'MAS' || $Funcionario_Aux['Genero'] == 'FEM'){
        $actualizar = "UPDATE func_auxiliar SET Error = 'N/A' WHERE Cedula = $numero_id";
        $sqli1          = $conectar->query($actualizar);
    }

    //if $Funcionario_Aux['Dependencia'] is diferent to N/A, AND Estado is ACT or INACTIVO, AND  Genero is MAS or FEM, then update Error to N/A
    if($Funcionario_Aux['Dependencia'] != 'N/A' AND $Funcionario_Aux['Estado'] == 'ACTIVO' || $Funcionario_Aux['Estado'] == 'INACTIVO' AND $Funcionario_Aux['Genero'] == 'MAS' || $Funcionario_Aux['Genero'] == 'FEM'){
        $actualizar = "UPDATE func_auxiliar SET Error = 'N/A' WHERE Cedula = $numero_id";
        $sqli1          = $conectar->query($actualizar);
    }

    //echo "<script>alert('Datos Actualizados Correctamtne');location.href='../pages/admin_cargar.php';</script>";
    echo json_encode("success"); exit;
?>