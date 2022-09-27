<?php
    include "../conexion.php";

    session_start();
    error_reporting(0);
    $bandera = false;
    $autentication  = $_SESSION['TIPO_USUARIO'];
    $nombre_cliente = strtoupper($_SESSION['NOM_USUARIO']);
    $nombre_admin   = strtoupper($_SESSION['NOM_USUARIO']);
    $id_cliente     = strtoupper($_SESSION['ID_USUARIO']);
    $id_admin       = strtoupper($_SESSION['ID_USUARIO']);

    if($autentication == 'Cliente' || $autentication == 'Admin'){
        $bandera = true;
    }
    else{
        $bandera = false;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/icon.png">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/style_quienes_somos.css">
    <link rel="stylesheet" href="../css/style_collapsed_menu.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,400;1,400;1,500;1,900&family=Lobster&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/b50f20f4b1.js" crossorigin="anonymous"></script>
    <!-- Estilos del carousel -->
    <title>Quienes Somos</title>
</head>
<body>
    <div id="particles-js"></div>

    <!-- CABECERA DE TRABAJO -->
    <header>
        <div class="contenedor_principal">
            <div class="contenedor_logo">
                <a href="../index.php"><img id="imagen_logo" src="../images/logo.png" alt="Error al cargar la imagen"></a>
            </div>

            <?php
                if ($bandera == false){
            ?>

                <div class="contenedor_frase">
                    <span>Divisón de Gestión del Talento Humano</span>
                </div>
                <div class="contenedor_botones">
                    <div class="contenedor_botton_inicio">
                        <a href="inicio_sesion.php"><button type="" class="btn-inicio-sesion">Inicio de Sesion</button></a>
                    </div>
                    <div class="contenedor_botton_registro">
                        <a href="form_register.php"><button type="" class="btn-inicio-sesion">Registrarse</button></a>
                    </div>
                </div>
            <?php
                }
                else{
            ?>
               <div class="contenedor_nombre_clt">
                    <span> BIENVENIDO </span>
                    <span>
                        <?php
                            echo $nombre_cliente;
                        ?>

                    </span>
                </div>
                <div class="contenedor_clt">
                    Nombre de usuario:
                    <span class="info_clt">
                        <?php
                            echo " $nombre_cliente";
                        ?>
                    </span><br>
                    <span>
                        ID usuario:
                    </span>
                    <span class="info_admin">
                        <?php
                            echo " $id_cliente";
                        ?>
                    </span><br>
                    Tipo de usuario:
                    <span>
                        <?php
                            echo $autentication;
                        ?>
                    </span>


                    <div class="contenedor_cerrar_sesion" >
                        <a href="../logic/cerrar_sesion.php"><button class="btn-cierre-sesion">Cerrar Sesión</button></a>
                    </div>
                </div>
            <?php
                }
            ?>


        </div>
    </header>

     <!-- MENU DESPLEGABLE SI SE ENCUENTRA CON INICIO DE SESION UN CLIENTE O UN ADMIN -->
     <?php
        if($autentication == 'Cliente'){
    ?>
        <!-- INICIO DE SLIDE MENU PARA CLIENTES -->
        <div class = "contenedor_pr_menu">
            <div id="slide-menu" class="menu-collapsed">

                <!-- HEADER -->
                <div id="header">

                    <div id="menu-btn">
                        <div class="btn-logo"></div>
                        <div class="btn-logo"></div>
                        <div class="btn-logo"></div>
                    </div>
                    <div id="title"><span>PERFIL</span></div>

                </div>

                <!-- PROFILE -->
                <div id="profile">
                    <div id="photo"><img src="../images/profile2.png" alt=""></div>
                    <div id="name"><span>Nombre: <?php echo $nombre_cliente ?></span></div>
                    <div id="name"><span>Id: <?php echo $id_cliente ?></span></div>
                </div>

                <!-- ITEMS -->
                <div id="menu-items">

                    <div class="item">
                        <a href="client_menu.php">
                            <div class="icon"><img src="../images/home.png" alt=""></div>
                            <div class="title"><span>Menú Principal</span></div>

                        </a>
                    </div>

                        <!-- SEPARADOR -->
                        <div class="item separator">
                        </div>

                    <div class="item">
                        <a href="client_estadisticas.php">
                            <div class="icon"><img src="../images/stadistics.png" alt=""></div>
                            <div class="title"><span>Estadísticas</span></div>

                        </a>
                    </div>
                        <!-- SEPARADOR -->
                        <div class="item separator">
                        </div>

                    <div class="item">
                        <a href="client_alertas.php">
                            <div class="icon"><img src="../images/alert.png" alt=""></div>
                            <div class="title"><span>Alertas</span></div>

                        </a>
                    </div>

                        <!-- SEPARADOR -->
                        <div class="item separator">
                        </div>

                    <div class="item">
                        <a href="client_suscription.php">
                            <div class="icon"><img src="../images/subscription.png" alt=""></div>
                            <div class="title"><span>Suscripciones</span></div>

                        </a>
                    </div>
                        <!-- SEPARADOR -->
                        <div class="item separator">
                        </div>

                    <div class="item">
                        <a href="client_rango_alertas.php">
                            <div class="icon"><img src="../images/meter.png" alt=""></div>
                            <div class="title"><span>Rangos de medición</span></div>

                        </a>
                    </div>


                </div>

                <!--
                    =================================
                    BOTON DE CARGA SUPERIOR
                    =================================
                -->
                <div class="footer">
                    <a href="#">
                        <div class="btn_carga"><img src="../images/pages_up.png" alt=""></div>
                    </a>
                </div>
            </div>
        </div>
    <?php
        }if($autentication == 'Admin'){
    ?>
        <!-- INICIO DE SLIDE MENU PARA ADMINS-->
        <div class = "contenedor_pr_menu">
            <div id="slide-menu" class="menu-collapsed">

                <!-- HEADER -->
                <div id="header">

                    <div id="menu-btn">
                        <div class="btn-logo"></div>
                        <div class="btn-logo"></div>
                        <div class="btn-logo"></div>
                    </div>
                    <div id="title"><span>PERFIL</span></div>

                </div>

                <!-- PROFILE -->
                <div id="profile">
                    <div id="photo"><img src="../images/profile2.png" alt=""></div>
                    <div id="name"><span>Nombre: <?php echo $nombre_admin ?></span></div>
                    <div id="name"><span>Id: <?php echo $id_admin ?></span></div>
                </div>

                <!-- ITEMS -->
                <div id="menu-items">

                    <div class="item">
                        <a href="../index.php">
                            <div class="icon"><img src="../images/home.png" alt=""></div>
                            <div class="title"><span>Menú Principal</span></div>

                        </a>
                    </div>

                        <!-- SEPARADOR -->
                        <div class="item separator">
                        </div>

                    <div class="item">
                        <a href="admin_estadisticas.php">
                            <div class="icon"><img src="../images/stadistics.png" alt=""></div>
                            <div class="title"><span>Estadísticas</span></div>

                        </a>
                    </div>

                        <!-- SEPARADOR -->
                        <div class="item separator">
                        </div>

                    <div class="item">
                        <a href="#">
                            <div class="icon"><img src="../images/users_admin.png" alt=""></div>
                            <div class="title"><span>Gestión de usuarios</span></div>

                        </a>
                    </div>
                        <!-- SEPARADOR -->
                        <div class="item separator">
                        </div>

                    <div class="item">
                        <a href="admin_edition_client.php">
                            <div class="icon"><img src="../images/edit_user.png" alt=""></div>
                            <div class="title"><span>Editar usuario</span></div>

                        </a>
                    </div>

                        <!-- SEPARADOR -->
                        <div class="item separator">
                        </div>

                    <div class="item">
                        <a href="admin_delete_user.php">
                            <div class="icon"><img src="../images/delete_user.png" alt=""></div>
                            <div class="title"><span>Eliminar usuario</span></div>

                        </a>
                    </div>

                        <!-- SEPARADOR -->
                        <div class="item separator">
                        </div>

                    <div class="item">
                        <a href="admin_create_user.php">
                            <div class="icon"><img src="../images/add-admin.png" alt=""></div>
                            <div class="title"><span>Creación de usuarios</span></div>

                        </a>
                    </div>


                </div>

                <!--
                    =================================
                    BOTON DE CARGA SUPERIOR
                    =================================
                -->
                <div class="footer">
                    <a href="#">
                        <div class="btn_carga"><img src="../images/pages_up.png" alt=""></div>
                    </a>
                </div>
            </div>
        </div>

    <?php
        }
    ?>



    <!-- BARRA DE NAVEGACION -->
    <div class="contenedor_menu">

        <div class="contenedor_listas">
            <ul>
                <a href="../index.php"><li class="btn-inicio-go_home">Menu Principal</li></a>
                <!--<a href="suscription.php"><li>Suscripciones</a><i class="fa fa-angle-down"></i>
                    <ul>
                        <a href="compras.php?suscp=Prem"><li> Premiun</li></a>
                        <a href="compras.php?suscp=Basic"><li> Básico</li></a>
                    </ul>
                </li> -->
                <a href=""><li class="btn-inicio-go_catalogo">¿Quiénes somos?</li></a>

                <?php
                    if($autentication == 'Cliente'){


                ?>
                    <a href="client_menu.php"><li class="btn-dashboard">Menú del Usuario</li></a>
                <?php
                    }

                    elseif($autentication == 'Admin'){
                ?>
                    <a href="admin_menu.php"><li class="btn-dashboard">Menú del Usuario</li></a>
                <?php
                    }

                ?>

            </ul>
        </div>
    </div>

    <!-- CONTENEDORES DE INTEGRANTES -->
    <div class="contenedor_integrantes">
        
        <div class="integrantes_group">
            <div class="contenedor_foto">
                    <img src="../images/icon.png" alt="Error al cargar la imagen">
            </div>
            <div class="contenedor_descripcion">
                División de Gestión del Talento Humano. </br>
                Es una dependencia adscrita a la Vicerrectoría Administrativa, regida mediante el Acuerdo 105 de 1.993, en el cual se fija la Estructura Orgánica de la Universidad del Cauca y se determinan las funciones de sus dependencias.
            </div>
            
        </div>
        

    </div>
    

<script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
<script src="../js/app.js"></script>

<!-- SCRIPT MENU LATERAL-->
<script>
    const btn = document.querySelector('#menu-btn');
    const menu = document.querySelector('#slide-menu');


    btn.addEventListener('click', e => {
        menu.classList.toggle("menu-expanded");
        window.scrollTo(150,150);
        menu.classList.toggle("menu-collapsed");
    });

</script>
</body>
</html>