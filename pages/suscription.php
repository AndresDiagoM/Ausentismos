<?php
    include "../conexion.php";

    session_start();
    error_reporting(0);
    $bandera = false;
    $autentication  = $_SESSION['TIPO_USUARIO'];
    $nombre_cliente = strtoupper($_SESSION['NOM_USUARIO']);
    $nombre_admin = strtoupper($_SESSION['NOM_USUARIO']);
    $id_cliente     = strtoupper($_SESSION['ID_USUARIO']);
    $id_admin     = strtoupper($_SESSION['ID_USUARIO']);

    if($autentication == 'Admin' || $autentication == 'Cliente'){
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
    <link rel="stylesheet"  href="../css/style.css">
    <link rel="stylesheet" href="../css/style_suscription.css">
    <link rel="stylesheet" href="../css/style_collapsed_menu.css">
    <link rel="icon" href="../images/icon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IM+Fell+French+Canon+SC&family=Kanit:ital,wght@0,400;1,400;1,500;1,900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/b50f20f4b1.js" crossorigin="anonymous"></script>

    <title>Suscripción</title>
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

                // LA BANDERA VERIFICA SI SE TIENE UNA SESION ACTIVA
                if ($bandera == false){

                    // CABECERA SIN LA INFORMACION DEL CLIENTE
            ?>

                <div class="contenedor_frase">
                    <span>Controla y monitoriza tu biodigestor al alcance de unos pocos clicks </span>
                </div>


                <div class="contenedor_botones">
                    <div class="contenedor_botton_inicio">
                        <a href="inicio_sesion.php"><button type="" class="btn-inicio-sesion">Inicio de Sesión</button></a>
                    </div>
                    <div class="contenedor_botton_registro">
                        <a href="form_register.php"><button type="" class="btn-inicio-sesion">Registrarse</button></a>
                    </div>
                </div>

            <?php
                }
                else{

                    // CABECERA CON LA INFORMACION DEL CLIENTE
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
                        <a href="../index.php">
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
                <a href="../index.php"><li class="btn-inicio-go_home">Menú Principal</li></a>
                <li>Suscripciones <i class="fa fa-angle-down"></i>
                    <ul>
                        <a href="compras.php?suscp=Prem"><li> Premiun</li></a>
                        <a href="compras.php?suscp=Basic"><li> Básico</li></a>
                    </ul>
                </li>
                    <a href="quienes_somos.php"><li class="btn-inicio-go_catalogo">¿Quiénes somos?</li></a>
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

    <!-- TIPOS DE PLANES -->
    <div class="contenedor_planes">
        <div class="contendor_basic">
            <!-- CONTENEDOR IMAGEN -->
            <div class="img_plan">
                <img src="../images/basic.png" alt="Error al cargar la imagen">
            </div>
            <!-- CONTENEDOR TITULO "BASIC" -->
            <div class="contenedor_letras">
                BASIC
            </div>
            <!-- CONTENEDOR PRECIOS BASIC -->
            <div class="contenedor_precio">

                <span>$ 365.000 /</span> Pago Inicial
                <br>
                    Mensualidades de $35.000
            </div>
            <!-- CONTENEDOR CARACTERISTICAS BASIC -->
            <div class="contenedor_caracteristicas">
                <ul>
                    <li>3 meses de uso de la aplicación</li>
                    <li>Mantenimiento periódico</li>
                </ul>
            </div>
            <!-- CONTENEDOR BOTON COMPRAR BASIC-->
            <div class="contenedor_compras">
                <a href="compras.php?suscp=Basic"><button>COMPRAR</button></a>
            </div>
        </div>
        <div class="contenedor_premium">
             <!-- CONTENEDOR IMAGEN -->
            <div class="img_plan">
                <img src="../images/premium.png" alt="" >
            </div>
            <!-- CONTENEDOR TITULO "PREMIUM" -->
            <div class="contenedor_letras">
                PREMIUM
            </div>
            <!-- CONTENEDOR PRECIOS -->
            <div class="contenedor_precio">

                <span>$ 356.000 /</span> Pago Inicial
                <br>
                    Mensualidades de $20.000
            </div>
            <!-- CONTENEDOR CARACTERISTICAS -->
            <div class="contenedor_caracteristicas">
                <ul>
                    <li>12 meses de uso de la aplicación</li>
                    <li>30% de descuento en la instalación</li>
                    <li>Mantenimiento periódico</li>

                </ul>
            </div>
            <!-- CONTENEDOR BOTON COMPRAR -->
            <div class="contenedor_compras">
                <a href="compras.php?suscp=Prem"><button>COMPRAR</button></a>
            </div>
        </div>

    </div>


    </div>
    <!-- Insercion de particulas -->
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