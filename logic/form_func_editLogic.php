
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
    $sql = "SELECT * FROM funcionarios WHERE Cedula = '$numero_id'";
    $result = $conectar->query($sql);
    $row = mysqli_fetch_assoc($result);


    // SENTENCIAS SQL PARA LA CONSULTA DE la dependencia, donde el departamento es igual al departamento y la facultad es igual a la facultad 
    $sql2 = "SELECT * FROM dependencias WHERE ID LIKE "."'".$query_values['dependencia_ausen_edt']."'";
    //print_r($sql2); exit;
    $result2 = $conectar->query($sql2); 
    //si no hay resultados, mostrar una alerta de que no hay resultados
    if($result2->num_rows == 0){
        //echo "<script>alert('No existe la dependencia seleccionada.'); location.href = '../pages/admin_func_form_edition.php?ID=$numero_id'; </script>"; exit;
        echo json_encode("error1");
    }else{
        //si hay resultados, guardar el resultado 
        $row2 = mysqli_fetch_assoc($result2);
    }

    // verificar que ningun campo de $query_values esté vacio
    foreach($query_values as $key => $value){
        if(empty($value)){
            //echo "<script>alert('Complete todos los campos.'); location.href = '../pages/admin_func_form_edition.php?ID=$numero_id'; </script>"; exit;
            echo json_encode("error2");
        }
    }

    // Actualizar nombre
    if($query_values['nombre_func_edt'] != $row['Nombre']){
        $nombre_edt = $query_values['nombre_func_edt'];
        $actualizar = "UPDATE funcionarios SET Nombre = '$nombre_edt' WHERE Cedula = $numero_id";
        $sqli1          = $conectar->query($actualizar);
    }
    //actualizar correo
    if($query_values['correo_func_edt'] != $row['Correo']){
        $correo_edt = $query_values['correo_func_edt'];
        $actualizar = "UPDATE funcionarios SET Correo = '$correo_edt' WHERE Cedula = $numero_id";
        $sqli1          = $conectar->query($actualizar);
    }
    if($row2['ID'] != $row['Dependencia']){
        $depen_edt = $row2['ID'];
        $actualizar = "UPDATE funcionarios SET Dependencia = '$depen_edt' WHERE Cedula = $numero_id";
        $sqli1          = $conectar->query($actualizar);
    }
    //actualizar Genero
    if($query_values['genero_func_edt'] != $row['Genero']){
        $genero_edt = $query_values['genero_func_edt'];
        $actualizar = "UPDATE funcionarios SET Genero = '$genero_edt' WHERE Cedula = $numero_id";
        $sqli1          = $conectar->query($actualizar);
    }
    //actualizar Salario
    if($query_values['salario_func_edt'] != $row['Salario']){
        $salario_edt = $query_values['salario_func_edt'];
        $actualizar = "UPDATE funcionarios SET Salario = '$salario_edt' WHERE Cedula = $numero_id";
        $sqli1          = $conectar->query($actualizar);
    }
    //actualizar estado
    if($query_values['estado_func_edt'] != $row['Estado']){
        $estado_edt = $query_values['estado_func_edt'];
        $actualizar = "UPDATE funcionarios SET Estado = '$estado_edt' WHERE Cedula = $numero_id";
        $sqli1          = $conectar->query($actualizar);
    }
    //actualizar eps
    if($query_values['eps_func_edt'] != $row['EPS']){
        $eps_edt = $query_values['eps_func_edt'];
        $actualizar = "UPDATE funcionarios SET EPS = '$eps_edt' WHERE Cedula = $numero_id";
        $sqli1          = $conectar->query($actualizar);
    }
    //actualizar arp
    if($query_values['arp_func_edt'] != $row['ARP']){
        $arp_edt = $query_values['arp_func_edt'];
        $actualizar = "UPDATE funcionarios SET ARP = '$arp_edt' WHERE Cedula = $numero_id";
        $sqli1          = $conectar->query($actualizar);
    }

    if($query_values['cedula_func_edt'] != $row['Cedula']){
        $cedula_edt = $query_values['cedula_func_edt'];
        $actualizar = "UPDATE funcionarios SET Cedula = '$cedula_edt' WHERE Cedula = $numero_id";
        $sqli1          = $conectar->query($actualizar);
    }


    //echo "<script> alert('Datos Actualizados Correctamtne');location.href='../pages/admin_edit_func.php';</script>"
    echo json_encode("success");
?>