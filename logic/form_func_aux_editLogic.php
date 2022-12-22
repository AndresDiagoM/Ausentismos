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
    $row = mysqli_fetch_assoc($result);


    // SENTENCIAS SQL PARA LA CONSULTA DE la dependencia, donde el departamento es igual al departamento y la facultad es igual a la facultad 
    $sql2 = "SELECT * FROM dependencias WHERE ID LIKE "."'".$query_values['dependencia_func_edt']."'";
    //print_r($sql2); exit;
    $result2 = $conectar->query($sql2); 
    //si no hay resultados, mostrar una alerta de que no hay resultados
    if($result2->num_rows == 0){
        //echo "<script>alert('No existe la dependencia seleccionada.'); location.href = '../pages/admin_aux_table_edition.php?ID=$numero_id'; </script>"; exit;
        echo json_encode("error1"); exit;
    }else{
        //si hay resultados, guardar el resultado 
        $row2 = mysqli_fetch_assoc($result2);
    }

    // verificar que ningun campo de $query_values esté vacio
    foreach($query_values as $key => $value){
        if(empty($value)){
            //echo "<script>alert('Complete todos los campos.'); location.href = '../pages/admin_aux_table_edition.php?ID=$numero_id'; </script>"; exit;
            echo json_encode("error2"); exit;
        }
    }

    //ACTUALIZAR DATOS DEL FUNCIONARIO
    if($query_values['nombre_func_edt'] != $row['Nombre']){
        $nombre_edt = $query_values['nombre_func_edt'];
        $actualizar = "UPDATE func_auxiliar SET Nombre = '$nombre_edt' WHERE Cedula = $numero_id";
        $sqli1          = $conectar->query($actualizar);
    }
    if($query_values['cargo_func_edt'] != $row['Cargo']){
        $cargo_edt = $query_values['cargo_func_edt'];
        $actualizar = "UPDATE func_auxiliar SET Cargo = '$cargo_edt' WHERE Cedula = $numero_id";
        $sqli1          = $conectar->query($actualizar);
    }
    if($row2['ID'] != $row['Dependencia']){
        $depen_edt = $row2['ID'];
        $actualizar = "UPDATE func_auxiliar SET Dependencia = '$depen_edt' WHERE Cedula = $numero_id";
        $sqli1          = $conectar->query($actualizar);
    }
    //actualizar correo
    if($query_values['correo_func_edt'] != $row['Correo']){
        $correo_edt = $query_values['correo_func_edt'];
        $actualizar = "UPDATE func_auxiliar SET Correo = '$correo_edt' WHERE Cedula = $numero_id";
        $sqli1          = $conectar->query($actualizar);
    }
    //actualizar Genero
    if($query_values['genero_func_edt'] != $row['Genero']){
        $genero_edt = $query_values['genero_func_edt'];
        $actualizar = "UPDATE func_auxiliar SET Genero = '$genero_edt' WHERE Cedula = $numero_id";
        $sqli1          = $conectar->query($actualizar);
    }
    //actualizar Salario
    if($query_values['salario_func_edt'] != $row['Salario']){
        $salario_edt = $query_values['salario_func_edt'];
        $actualizar = "UPDATE func_auxiliar SET Salario = '$salario_edt' WHERE Cedula = $numero_id";
        $sqli1          = $conectar->query($actualizar);
    }
    //actualizar estado
    if($query_values['estado_func_edt'] != $row['Estado']){
        $estado_edt = $query_values['estado_func_edt'];
        $actualizar = "UPDATE func_auxiliar SET Estado = '$estado_edt' WHERE Cedula = $numero_id";
        $sqli1          = $conectar->query($actualizar);
    }

    if($query_values['cedula_func_edt'] != $row['Cedula']){
        $cedula_edt = $query_values['cedula_func_edt'];
        $actualizar = "UPDATE func_auxiliar SET Cedula = '$cedula_edt' WHERE Cedula = $numero_id";
        $sqli1          = $conectar->query($actualizar);
    }

    //=================================================================================
    //if Estado is ACT or INACTIVO, AND  Genero is MAS or FEM, then update Error to N/A
    // CONSULTA DE DATOS DEL FUNCIONARIO ALMACENADOS EN LA BASE DE DATOS
    $sql = "SELECT * FROM func_auxiliar WHERE Cedula = '$numero_id'";
    $result = $conectar->query($sql);
    $row = mysqli_fetch_assoc($result);
    if($row['Estado'] == 'ACTIVO' || $row['Estado'] == 'INACTIVO' AND $row['Genero'] == 'MAS' || $row['Genero'] == 'FEM'){
        $actualizar = "UPDATE func_auxiliar SET Error = 'N/A' WHERE Cedula = $numero_id";
        $sqli1          = $conectar->query($actualizar);
    }

    //if $row['Dependencia'] is diferent to N/A, AND Estado is ACT or INACTIVO, AND  Genero is MAS or FEM, then update Error to N/A
    if($row['Dependencia'] != 'N/A' AND $row['Estado'] == 'ACTIVO' || $row['Estado'] == 'INACTIVO' AND $row['Genero'] == 'MAS' || $row['Genero'] == 'FEM'){
        $actualizar = "UPDATE func_auxiliar SET Error = 'N/A' WHERE Cedula = $numero_id";
        $sqli1          = $conectar->query($actualizar);
    }

    //echo "<script>alert('Datos Actualizados Correctamtne');location.href='../pages/admin_cargar.php';</script>";
    echo json_encode("success"); exit;
?>