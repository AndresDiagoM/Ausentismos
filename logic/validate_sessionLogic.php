<?php
    session_start();
    error_reporting(0);
    
    $autentication = $_SESSION['TIPO_USUARIO'];

    if ($autentication == 'CONSULTA' || $autentication == 'ADMIN' || $autentication=='ROOT'){
        echo    "<script>
                    location.href='../pages/admin_menu.php';
                </script>";
    } else if($autentication == 'FACULTAD'){
        echo    "<script>
                    location.href='../pages/facultad_agregar.php';
                </script>";
    }
?>