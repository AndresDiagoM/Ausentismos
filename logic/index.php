<?php
    session_start();
    error_reporting(0);
    
    $autentication = $_SESSION['TIPO_USUARIO'];

    if ($autentication == 'CONSULTA' || $autentication == 'ADMIN'){
        echo    "<script>
                    location.href='../pages/admin_menu.php';
                </script>";
    }elseif($autentication == 'FACULTAD'){
        echo    "<script>
                    location.href='../pages/facultad_agregar.php';
                </script>";
    }else {
        echo    "<script>
                    location.href='../pages/inicio_sesion.php';
                </script>";
    }
?>