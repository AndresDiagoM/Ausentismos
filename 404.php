<?php
    /*session_start();
    error_reporting(0);
    
    $autentication = isset($_SESSION['TIPO_USUARIO']) ? $_SESSION['TIPO_USUARIO'] : '';

    if ($autentication == 'CONSULTA' || $autentication == 'ADMIN'){
        echo    "<script>
                    location.href='./pages/admin_menu.php';
                </script>";
        echo "<script>console.log('AQUIIII')</script>";
    }elseif($autentication == 'FACULTAD'){
        echo    "<script>
                    location.href='./pages/facultad_agregar.php';
                </script>";
    }else {
        echo    "<script>
                    location.href='./index.php';
                </script>";
    }*/
?>

<html>
    <head>
        <style>
        .error {
            text-align: center;
            font-size: 48px;
            margin-top: 100px;
        }
        .error h1 {
            color: red;
            font-size: 72px;
            margin: 0;
        }
        </style>
    </head>
    <body>
        <div class="error">
            <h1>Error 404</h1>
            <p>Page Not Found</p>
            <p>The page you are looking for could not be found.</p>
        </div>
    </body>
</html>