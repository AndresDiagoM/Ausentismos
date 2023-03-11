<?php
    include "../conexion.php";

    // Iniciar la sesión
    session_start();

    // Comprobar el tipo de usuario
    $autentication = $_SESSION['TIPO_USUARIO'];
    if($autentication == '' || $autentication == null || !in_array($autentication, array("ADMIN", "CONSULTA"))){
        //header('Location: ../pages/inicio_sesion.php?message=3');
        session_destroy();
        echo "<script> alert('Sin permisos'); location.href = '../pages/inicio_sesion.php?message=3';  </script>";    
    }

    // Establecer la fecha de inicio de la sesión
    if (!isset($_SESSION['fecha']) || !isset($_SESSION['last_request_time'])) {
        $_SESSION['fecha'] = date('Y-m-d');
        $_SESSION['last_request_time'] = time();
    }

    // Comprobar si la fecha actual es mayor que la fecha de inicio de sesión
    if ( date('Y-m-d') > $_SESSION['fecha']) {
        // Cerrar la sesión y redirigir al usuario a la página de inicio de sesión
        session_unset();
        session_destroy();
        header("Location: inicio_sesion.php");
        exit;
    }

    // Comprobar si el usuario ha estado activo por más de 8 horas
    if (time() - $_SESSION['last_request_time'] > 8 * 60 * 60) {
        // Cerrar la sesión y redirigir al usuario a la página de inicio de sesión
        session_unset();
        session_destroy();
        header("Location: inicio_sesion.php");
        exit;
    }

?>