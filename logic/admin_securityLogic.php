<?php

    include "../conexion.php";
    session_start();

    $autentication = $_SESSION['TIPO_USUARIO'];
    if($autentication == '' || $autentication == null || $autentication == 'Cliente'){
        header('Location: ../pages/inicio_sesion.php?message=3');
    }
?>