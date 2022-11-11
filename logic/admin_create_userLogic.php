<?php
    require '../conexion.php';

    $nombre_usuario     =   strtoupper($_POST['nomb_usuario']);
    $numero_id          =   strtoupper($_POST['numero_id']);
    $correo       =   strtoupper($_POST['correo']);
    $dependencia          =   strtoupper($_POST['dependencia']);
    $tipo_us       =   strtoupper($_POST['tipo_us']);
    $login          =   strtoupper($_POST['login']);
    $pasw           =   strtoupper($_POST['pasw']);

    if($numero_id==''){
        header('Location: ../pages/admin_create_user.php');
    }

    if($tipo_usuario == 'CONSULTA'){
        $tipo_usuario = 'CONSULTA';
    }else{
        $tipo_usuario = 'ADMIN';
    }

    // Verificacion de ID NO repetido
    $consulta_id = "SELECT * FROM usuarios WHERE Cedula_U='$numero_id'";
    $verificar_id = mysqli_query($conectar, $consulta_id);
    if(mysqli_num_rows($verificar_id)>0){

        echo "<script>
            alert('Registro Incorrecto. El ID ya se encuentra registrado');
            location.href = '../pages/admin_create_user.php';
        </script>";

        // Cierre de conexion
        exit();
    }

    // Verificacion de correo
    $consulta_correo = "SELECT * FROM usuarios WHERE Correo='$correo'";
    $verificar_correo = mysqli_query($conectar, $consulta_correo);
    if(mysqli_num_rows($verificar_correo)>0){

        echo "<script>
            alert('Registro Incorrecto. El correo ya se encuentra registrado');
            location.href = '../pages/admin_create_user.php';
        </script>";

        // Cierre de conexion
        exit();
    }


    // ===========================================
    //              REGISTRO EXITOSO
    // ===========================================

    $registrar = "INSERT INTO usuarios (Cedula_U, Nombre_U, Correo, Dependencia, TipoUsuario, Login, Contrasena, Estado) 
                        VALUES ('$numero_id','$nombre_usuario', '$correo', '$dependencia', '$tipo_us', '$login', '$pasw', 'ACT')";
    $prueba = mysqli_query($conectar, $registrar);
    if($prueba){
        echo "<script> alert('Registro existoso');
        location.href = '../pages/admin_create_user.php';
        </script>";
    }
    else{
        echo "<script> alert('Registro incorrecto');
        location.href = '../pages/admin_create_user.php';
        </script>";
    }


?>