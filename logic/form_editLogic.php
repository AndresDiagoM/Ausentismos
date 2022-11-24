
<?php
    require '../conexion.php';

    //$nombre_edt         =   strtoupper($_POST['nombre_usuario_edt']);
    $query_values = $_POST;
    //print_r($query_values); exit;

    $numero_id = $_GET['ID'];
    //print_r($numero_id); exit;



    // CONSULTA DE DATOS DEL USUARIO ALMACENADOS EN LA BASE DE DATOS
    $sql = "SELECT * FROM usuarios WHERE Cedula_U = '$numero_id'";
    $result = $conectar->query($sql);
    $row = mysqli_fetch_assoc($result);


    // SENTENCIAS SQL PARA LA CONSULTA DE la dependencia, donde el departamento es igual al departamento y la facultad es igual a la facultad 
    $sql2 = "SELECT * FROM dependencias WHERE Departamento LIKE "."'".$query_values['departamento_usuario_edt']."'"." AND Facultad LIKE "."'".$query_values['facultad_usuario_edt']."'";
    //print_r($sql2); exit;
    $result2 = $conectar->query($sql2); 
    //si no hay resultados, mostrar una alerta de que no hay resultados
    if($result2->num_rows == 0){
        echo "<script>alert('No existe la dependencia seleccionada.'); location.href = '../pages/admin_form_edition.php'; </script>"; exit;
    }else{
        //si hay resultados, guardar el resultado 
        $row2 = mysqli_fetch_assoc($result2);
    }


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
    if($row2['ID'] != $row['Dependencia']){
        $depen_edt = $row2['ID'];
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
        $actualizar = "UPDATE usuarios SET Contrasena = '$contrasena_edt' WHERE Cedula_U = $numero_id";
        $sqli1          = $conectar->query($actualizar);
    }
    if($query_values['cedula_usuario_edt'] != $row['Cedula_U']){
        $cedula_edt = $query_values['cedula_usuario_edt'];
        $actualizar_nom = "UPDATE usuarios SET Cedula_U = '$cedula_edt' WHERE Cedula_U = $numero_id";
        $sqli1          = $conectar->query($actualizar_nom);
    }


    echo "<script>
        alert('Datos Actualizados Correctamtne');
        location.href='../pages/admin_edition_client.php';
    </script>"

?>