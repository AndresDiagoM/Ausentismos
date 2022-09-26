<?php
    session_start();
    error_reporting(0);
    $bandera = false;
    $autentication = $_SESSION['TIPO_USUARIO'];

    if ($autentication == 'Cliente'){
        echo    "<script>
                    alert('Ya se ha iniciado sesión previamente.');
                    location.href='../pages/client_menu.php';
                </script>";
    }
    elseif($autentication == 'Admin'){
        echo    "<script>
                    alert('Ya se ha iniciado sesión previamente.');
                    location.href='../pages/admin_menu.php';
                </script>";
    }
?>