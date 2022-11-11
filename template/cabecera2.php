<?php
//MENU DEL ADMIN, CON DASHBOARD
include "../conexion.php";
include "../logic/admin_securityLogic.php";

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
            <a href="../pages/admin_menu.php" class="p-3 text-light d-block text-decoration-none"> 
                <i class="icon ion-md-apps     mr-2 lead"></i> MENU   </a>
            
                <a href="../pages/admin_cargar.php" class="p-3 text-light d-block text-decoration-none"> 
                <i class="icon ion-md-cloud   me-2 lead"></i> CARGAR DATOS  </a>
            <a href="../pages/admin_agregar.php" class="p-3 text-light d-block text-decoration-none"> 
                <i class="icon ion-md-add-circle me-2 lead"></i> AGREGAR REGISTRO</a>
            <a href="../pages/admin_consultar.php" class="p-3 text-light d-block text-decoration-none"> 
                <i class="icon ion-md-search   me-2 lead"></i> CONSULTAR AUSENTISMO    </a>
            <a href="../pages/admin_edition_client.php" class="p-3 text-light d-block text-decoration-none"> 
                <i class="icon ion-md-people me-2 lead"></i> GESTIONAR USUARIO</a>

            <div class="container">
                <a href="../pages/admin_edition_client.php" class="p-3 text-light d-block text-decoration-none"> 
                    <i class="icon ion-md-create me-2 lead"></i>     Editar      </a>
                <a href="../pages/admin_delete_user.php" class="p-3 text-light d-block text-decoration-none"> 
                    <i class="icon ion-md-trash me-2 lead"></i>     Eliminar      </a>
                <a href="../pages/admin_create_user.php" class="p-3 text-light d-block text-decoration-none"> 
                    <i class="icon ion-md-person-add me-2 lead"></i>     Crear     </a>
            </div>
            
                <a href="../logic/cerrar_sesion.php" class="p-3 text-light d-block text-decoration-none"> 
                <i class="icon ion-md-log-out me-2 lead"></i> CERRAR CESION</a>
        </div>
    </div>

    <div class="w-100">

        <!-- NAV BAR - menu en la parte superior -->
        <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="../pages/admin_menu.php">MENU</a>
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
                                echo $nombre[0]." ".$nombre[2];
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