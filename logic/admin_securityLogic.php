<?php
    include "../conexion.php";
    session_start();

    $autentication = $_SESSION['TIPO_USUARIO'];
    if($autentication == '' || $autentication == null || $autentication != 'ADMIN'){
        //header('Location: ../pages/inicio_sesion.php?message=3');
        echo "<script> alert('Sin permisos'); location.href = '../pages/inicio_sesion.php?message=3';  </script>";    
    }
?>