<?php
//MENU DEL ADMINISTRADOR, CON DASHBOARD
include "../conexion.php";
include "../logic/admin_securityLogic.php"; // Verifica que el usuario sea administrador

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
    <link rel="stylesheet" href="../css/estilo.css" type="text/css" > <!-- integrity="" crossorigin="anonymous" -->
    <link href="../js/sweetalert2-11.6.15/package/dist/sweetalert2.min.css" rel="stylesheet" integrity="" crossorigin="anonymous">

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
            <ul>
                <li class="list" id="admin_menu">
                    <a href="../pages/admin_menu.php" class="p-3 text-light d-block text-decoration-none">
                        <i class="icon ion-md-apps mr-2 lead"></i>
                        <span class="text">MENU</span>
                    </a>
                </li>
                <li class="list" id="admin_cargar">
                    <a href="../pages/admin_cargar.php" class="p-3 text-light d-block text-decoration-none">
                        <!-- <span class="icon"> <ion-icon name="person-outline"></ion-icon> </span> -->
                        <i class="icon ion-md-cloud mr-2 lead"></i>
                        <span class="text">CARGAR DATOS</span>
                    </a>
                </li>
                <li class="list" id="admin_agregar">
                    <a href="../pages/admin_agregar.php" class="p-3 text-light d-block text-decoration-none">
                        <i class="icon ion-md-add-circle mr-2 lead"></i>
                        <span class="text">AGREGAR REGISTRO</span>
                    </a>
                </li>
                <li class="list" id="admin_consultar">
                    <a href="../pages/admin_consultar.php" class="p-3 text-light d-block text-decoration-none">
                        <i class="icon ion-md-search mr-2 lead"> </i>
                        <span class="text">CONSULTAR</span>
                    </a>
                </li>
                <li class="list" id="admin_edition_client">
                    <a href="../pages/admin_edition_client.php" class="p-3 text-light d-block text-decoration-none">
                        <i class="icon ion-md-people mr-2 lead"></i>
                        <span class="text">GESTIONAR USUARIO</span>
                    </a>
                </li>
                <li class="list" id="cerrar_sesion">
                    <a href="../logic/cerrar_sesion.php" class="p-3 text-light d-block text-decoration-none">
                        <i class="icon ion-md-log-out mr-2 lead"></i>
                        <span class="text">CERRAR CESION</span>
                    </a>
                </li>
                <div class="indicator"></div>
            </ul>
        </div>

        <div class="sideBar_foot" >
            <img src="../images/lema.png" class="img-fluid me-2" width="40" height="40" alt="Sample image">
            <img src="../images/logosIcontec2020.png" class="img-fluid" width="100" height="100" alt="Sample image">
        </div>
    </div>

    <div class="w-100">

        <!-- NAV BAR - menu en la parte superior -->
        <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="../pages/admin_menu.php"> <i class="icon ion-md-home me-2 lead"></i> </a>
            
            <button class="navbar-toggler menu-btn" type="button">
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
                            <a class="dropdown-item" href=<?php echo '../pages/admin_form_edition.php?ID='.$id_admin.''; ?>>Mi perfil </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="../logic/cerrar_sesion.php">Cerrar Sesion</a>
                        </div>
                    </li>
                </ul>
            </div>

        </div>
        </nav>