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
        header('Location: ../pages/inicio_sesion.php');
    }

    if($tipo_usuario == 'CON'){
        $tipo_usuario = 'Consulta';
    }
    else{
        $tipo_usuario = 'Admin';
    }

    // Verificacion de ID NO repetido
    $consulta_id = "SELECT * FROM usuarios WHERE Cedula='$numero_id'";
    $verificar_id = mysqli_query($conectar, $consulta_id);
    if(mysqli_num_rows($verificar_id)>0){

        echo "<script>
            alert('Registro Incorrecto. El ID ya se encuentra registrado');
            location.href = '../pages/form_register.php';
        </script>";

        // Cierre de conexion
        exit();
    }

    // Verificacion de correo
    $consulta_correo = "SELECT * FROM usuarios WHERE Correo='$correo'";
    $verificar_correo = mysqli_query($conectar, $consulta_correo);
    if(mysqli_num_rows($verificar_correo)>0){

        echo "<script>
            alert('Registro Incorrecto. El numero de correo ya se encuentra registrado');
            location.href = '../pages/form_register.php';
        </script>";

        // Cierre de conexion
        exit();
    }


    // ===========================================
    //              REGISTRO EXITOSO
    // ===========================================

    $registrar = "INSERT INTO usuarios (Cedula, Nombre, Correo, Dependencia, TipoUsuario, login, contraseña) 
                        VALUES ('$numero_id','$nombre_usuario', '$correo', '$dependencia', '$tipo_us', '$login', '$pasw')";
    $prueba = mysqli_query($conectar, $registrar);
    if($prueba){
        echo "<script> alert('Registro existoso');
        location.href = '../pages/admin_menu.php';
        </script>";
    }
    else{
        echo "<script> alert('Registro incorrecto');
        location.href = '../index.php';
        </script>";
    }


?>