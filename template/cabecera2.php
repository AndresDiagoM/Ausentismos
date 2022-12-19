<?php
include "../conexion.php";

session_start();
$autentication = $_SESSION['TIPO_USUARIO'];
if($autentication == '' || $autentication == null || $autentication == 'CONSULTA'){
    //header('Location: ../pages/inicio_sesion.php?message=3');
    echo "<script> alert('Sin permisos'); location.href = '../pages/inicio_sesion.php?message=3';  </script>";    
}

// Inicio o reanudacion de una sesion
$nombre_admin   = $_SESSION['NOM_USUARIO'];
$id_admin       = $_SESSION['ID_USUARIO'];
$tipo_usuario   = $_SESSION['TIPO_USUARIO'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/icon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../bootstrap-5.2.2-dist/css/bootstrap.min.css" /> 

    <!-- CSS -->
    <link href="../css/estilo.css" rel="stylesheet" integrity="" crossorigin="anonymous">

    <!-- ICONOS en https://ionic.io/ionicons/v4/usage#md-pricetag -->
    <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">

    <title>Admin</title>
</head>

<body>
    <div class="d-flex">

    <!-- SIDE BAR - menu lateral -->
    <div id="sidebar-container" class="bg-primary">
        <div class="logo" >
            <h4 class="text-light font-weight-bold"> GESTION DE AUSENTISMOS </h4>
        </div>

        <div class="menu">
            
            <!-- <a href="../pages/facultad_edition_client.php" class="p-3 text-light d-block text-decoration-none"> 
                <i class="icon ion-md-people mr-2 lead"></i> GESTIONAR USUARIO</a> -->
            <a href="../logic/cerrar_sesion.php" class="p-3 text-light d-block text-decoration-none"> 
                <i class="icon ion-md-log-out mr-2 lead"></i> CERRAR CESION</a>

            <div class="sideBar_foot" >
                <img src="../images/lema.png" class="img-fluid me-2" width="40" height="40" alt="Sample image">
                <img src="../images/logosIcontec2020.png" class="img-fluid" width="100" height="100" alt="Sample image">
            </div>
        </div>
    </div>

    <div class="w-100">

        <!-- NAV BAR - menu en la parte superior -->
        <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="../pages/facultad_agregar.php"> <i class="icon ion-md-home me-2 lead"></i> </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="d-flex justify-content-end " id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="../images/user_profile.png" class="img-fluid rounded-circle avatar mr-2" />
                            <?php //echo de las 2 primeras palabras del nombre
                                $nombre = explode(" ", $nombre_admin);
                                //si tiene mas de 2 palabras, imprime las 2 primeras
                                if (count($nombre) > 1) {
                                    echo $nombre[0] . " " . $nombre[1];
                                } elseif(count($nombre) == 1) {
                                    echo $nombre[0];
                                }else{
                                    echo "Usuario";
                                }
                                //echo $nombre[0]." ".$nombre[2];
                            ?>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">Mi perfil </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="../logic/cerrar_sesion.php">Cerrar Sesion</a>
                        </div>
                    </li>
                </ul>
            </div>

        </div>
        </nav>