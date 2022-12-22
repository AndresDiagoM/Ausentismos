
<?php
    require '../conexion.php';

    //$nombre_edt         =   strtoupper($_POST['nombre_usuario_edt']);
    $query_values = $_POST;
    //print_r($query_values); exit;

    $numero_id = $_POST['cedula_u'];
    //print_r($numero_id); exit;

    // CONSULTA DE DATOS DEL USUARIO ALMACENADOS EN LA BASE DE DATOS
    $sql = "SELECT * FROM usuarios WHERE Cedula_U = '$numero_id'";
    $result = $conectar->query($sql);
    $row = mysqli_fetch_assoc($result);

    // if there is no result, show an alert and redirect to the form
    if($result->num_rows == 0){
        echo json_encode("error"); exit;
    }


    /*// SENTENCIAS SQL PARA LA CONSULTA DE la dependencia, donde el departamento es igual al departamento y la facultad es igual a la facultad 
    $sql2 = "SELECT * FROM dependencias WHERE Departamento LIKE "."'".$query_values['departamento_usuario_edt']."'"." AND Facultad LIKE "."'".$query_values['facultad_usuario_edt']."'";
    //print_r($sql2); exit;
    $result2 = $conectar->query($sql2); 
    //si no hay resultados, mostrar una alerta de que no hay resultados
    if($result2->num_rows == 0){
        echo "<script>alert('No existe la dependencia seleccionada.'); location.href = '../pages/admin_form_edition.php'; </script>"; exit;
    }else{
        //si hay resultados, guardar el resultado 
        $row2 = mysqli_fetch_assoc($result2);
    }*/

    // verificar que ningun campo de $query_values esté vacio
    foreach($query_values as $key => $value){
        if(empty($value)){
            //echo "<script>alert('Complete todos los campos.'); location.href = '../pages/admin_func_form_edition.php?ID=$numero_id'; </script>"; exit;
            echo json_encode("error2");
        }
    }

    // convertir los campos de Nombre y login a mayusculas
    $query_values['nombre_usuario_edt'] = strtoupper($query_values['nombre_usuario_edt']);
    $query_values['login_usuario_edt'] = strtoupper($query_values['login_usuario_edt']);


    if($query_values['nombre_usuario_edt'] != $row['Nombre_U']){
        $nombre_edt = $query_values['nombre_usuario_edt'];
        $actualizar = "UPDATE usuarios SET Nombre_U = '$nombre_edt' WHERE Cedula_U = $numero_id";
        $sqli1          = $conectar->query($actualizar);
    }
    if($query_values['correo_usuario_edt'] != $row['Correo']){
        $correo_edt = $query_values['correo_usuario_edt'];
        $actualizar = "UPDATE usuarios SET Correo = '$correo_edt' WHERE Cedula_U = $numero_id";
        $sqli1          = $conectar->query($actualizar);
    }
    if($query_values['dependencia_usuario_edt'] != $row['Dependencia']){
        $depen_edt = $query_values['dependencia_usuario_edt'];
        $actualizar = "UPDATE usuarios SET Dependencia = '$depen_edt' WHERE Cedula_U = $numero_id";
        $sqli1          = $conectar->query($actualizar);
    }
    //actualizar tipo_usuario
    if($query_values['tipo_usuario_edt'] != $row['TipoUsuario']){
        $tipo_edt = $query_values['tipo_usuario_edt'];
        $actualizar = "UPDATE usuarios SET TipoUsuario = '$tipo_edt' WHERE Cedula_U = $numero_id";
        $sqli1          = $conectar->query($actualizar);
    }
    //actualizar login
    if($query_values['login_usuario_edt'] != $row['Login']){
        $login_edt = $query_values['login_usuario_edt'];
        $actualizar = "UPDATE usuarios SET Login = '$login_edt' WHERE Cedula_U = $numero_id";
        $sqli1          = $conectar->query($actualizar);
    }
    //actualizar contraseña
    if($query_values['contrasena_usuario_edt'] != $row['Contrasena']){
        $contrasena_edt = $query_values['contrasena_usuario_edt'];
        //PASAR CONTRASEÑA A MD5
        $contrasena_edt = md5($contrasena_edt);
        $actualizar = "UPDATE usuarios SET Contrasena = '$contrasena_edt' WHERE Cedula_U = $numero_id";
        $sqli1          = $conectar->query($actualizar);
    }
    //actualizar estado
    if($query_values['estado_usuario_edt'] != $row['Estado']){
        $estado_edt = $query_values['estado_usuario_edt'];
        $actualizar = "UPDATE usuarios SET Estado = '$estado_edt' WHERE Cedula_U = $numero_id";
        $sqli1          = $conectar->query($actualizar);
    }
    if($query_values['cedula_usuario_edt'] != $row['Cedula_U']){
        $cedula_edt = $query_values['cedula_usuario_edt'];
        $actualizar_nom = "UPDATE usuarios SET Cedula_U = '$cedula_edt' WHERE Cedula_U = $numero_id";
        $sqli1          = $conectar->query($actualizar_nom);
    }

    //echo "<script>alert('Datos Actualizados Correctamtne');location.href='../pages/admin_edition_client.php';</script>"
    echo json_encode("success");
?>