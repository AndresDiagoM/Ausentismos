<?php

    include "../conexion.php";
    session_start();

    $autentication = $_SESSION['TIPO_USUARIO'];
    if($autentication == '' || $autentication == null || $autentication == 'Admin'){
        header('Location: ../pages/inicio_sesion.php?message=3');
    }
?>