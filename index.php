<?php
    include ("conexion.php");

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
    <link rel="icon" href="images/icon.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style_collapsed_menu.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,400;1,400;1,500;1,900&family=Lobster&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/b50f20f4b1.js" crossorigin="anonymous"></script>
    <!-- Estilos del carousel -->
    <title>Ausentismos</title>
</head>
<body>
    <!-- <div id="particles-js"></div> -->

    <!-- CABECERA DE TRABAJO -->
    <header>
        <div class="contenedor_principal">
            <div class="contenedor_logo">
                <a href="index.php"><img id="imagen_logo" src="images/logo.png" alt="Error al cargar la imagen"></a>
            </div>

            <?php
                if ($bandera == false){
            ?>

                <div class="contenedor_frase">
                    <span>Divisón de Gestión del Talento Humano</span>
                </div>
                <div class="contenedor_botones">
                    <div class="contenedor_botton_inicio">
                        <a href="pages/inicio_sesion.php"><button type="" class="btn-inicio-sesion">Inicio de Sesión</button></a>
                    </div>
                    <div class="contenedor_botton_registro">
                        <a href="pages/form_register.php"><button type="" class="btn-inicio-sesion">Registrarse</button></a>
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
                        <a href="logic/cerrar_sesion.php"><button class="btn-cierre-sesion">Cerrar Sesión</button></a>
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
                    <div id="photo"><img src="images/profile2.png" alt=""></div>
                    <div id="name"><span>Nombre: <?php echo $nombre_cliente ?></span></div>
                    <div id="name"><span>Id: <?php echo $id_cliente ?></span></div>
                </div>

                <!-- ITEMS -->
                <div id="menu-items">

                    <div class="item">
                        <a href="pages/client_menu.php">
                            <div class="icon"><img src="images/home.png" alt=""></div>
                            <div class="title"><span>Menú Principal</span></div>

                        </a>
                    </div>

                        <!-- SEPARADOR -->
                        <div class="item separator">
                        </div>

                    <div class="item">
                        <a href="pages/client_estadisticas.php">
                            <div class="icon"><img src="images/stadistics.png" alt=""></div>
                            <div class="title"><span>Estadísticas</span></div>

                        </a>
                    </div>
                        <!-- SEPARADOR -->
                        <div class="item separator">
                        </div>

                    <div class="item">
                        <a href="pages/client_alertas.php">
                            <div class="icon"><img src="images/alert.png" alt=""></div>
                            <div class="title"><span>Alertas</span></div>

                        </a>
                    </div>

                        <!-- SEPARADOR -->
                        <div class="item separator">
                        </div>

                    <div class="item">
                        <a href="pages/client_suscription.php">
                            <div class="icon"><img src="images/subscription.png" alt=""></div>
                            <div class="title"><span>Suscripciones</span></div>

                        </a>
                    </div>
                    
                        <!-- SEPARADOR -->
                        <div class="item separator">
                        </div>

                    <div class="item">
                        <a href="pages/client_rango_alertas.php">
                            <div class="icon"><img src="images/meter.png" alt=""></div>
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
                        <div class="btn_carga"><img src="images/pages_up.png" alt=""></div>
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
                    <div id="photo"><img src="images/profile2.png" alt=""></div>
                    <div id="name"><span>Nombre: <?php echo $nombre_admin ?></span></div>
                    <div id="name"><span>Id: <?php echo $id_admin ?></span></div>
                </div>

                <!-- ITEMS -->
                <div id="menu-items">

                    <div class="item">
                        <a href="#">
                            <div class="icon"><img src="images/home.png" alt=""></div>
                            <div class="title"><span>Menú Principal</span></div>

                        </a>
                    </div>

                        <!-- SEPARADOR -->
                        <div class="item separator">
                        </div>

                    <div class="item">
                        <a href="pages/admin_estadisticas.php">
                            <div class="icon"><img src="images/stadistics.png" alt=""></div>
                            <div class="title"><span>Estadísticas</span></div>

                        </a>
                    </div>

                        <!-- SEPARADOR -->
                        <div class="item separator">
                        </div>

                    <div class="item">
                        <a href="#">
                            <div class="icon"><img src="images/upload.png" alt=""></div>
                            <div class="title"><span>Cargar Datos</span></div>
                        </a>
                    </div>

                        <!-- SEPARADOR -->
                        <div class="item separator">
                        </div>

                    <div class="item">
                        <a href="#">
                            <div class="icon"><img src="images/add.png" alt=""></div>
                            <div class="title"><span>Agregar Registro</span></div>
                        </a>
                    </div>
                        <!-- SEPARADOR -->
                        <div class="item separator">
                        </div>

                    <div class="item">
                        <a href="pages/admin_consultar.php">
                            <div class="icon"><img src="images/stadistics.png" alt=""></div>
                            <div class="title"><span>Consultar Ausentismos</span></div>
                        </a>
                    </div>

                        <!-- SEPARADOR -->
                        <div class="item separator">
                        </div>

                    <div class="item">
                        <a href="pages/admin_edition_client.php">
                            <div class="icon"><img src="images/users_admin.png" alt=""></div>
                            <div class="title"><span>Gestionar Usuario</span></div>
                        </a>
                    </div>

                <!--
                    =================================
                    BOTON DE CARGA SUPERIOR
                    =================================
                -->
                <div class="footer">
                    <a href="#">
                        <div class="btn_carga"><img src="images/pages_up.png" alt=""></div>
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
                <a href="index.php"><li class="btn-inicio-go_home">Menú Principal</li></a>
                 <!--<a href="pages/suscription.php"><li>Suscripciones</a><i class="fa fa-angle-down"></i>
                    <ul>
                        <a href="pages/compras.php?suscp=Prem"><li> Premiun</li></a>
                        <a href="pages/compras.php?suscp=Basic"><li> Básico</li></a>
                    </ul>
                </li> -->
                <a href="pages/quienes_somos.php"><li class="btn-inicio-go_catalogo">¿Quiénes somos?</li></a>

                <?php
                    if($autentication == 'Cliente'){


                ?>
                    <a href="pages/client_menu.php"><li class="btn-dashboard">Menú del Usuario</li></a>
                <?php
                    }

                    elseif($autentication == 'Admin'){
                ?>
                    <a href="pages/admin_menu.php"><li class="btn-dashboard">Menú del Usuario</li></a>
                <?php
                    }

                ?>

            </ul>
        </div>
    </div>

    <!-- CARRUSEL GLIDE -->
    <div class="contenedor_slides">
        <div class="slider">
            <div class="slides">
                <!-- BOTONES  -->
                <input type="radio" name="radio-btn" id="radio1">
                <input type="radio" name="radio-btn" id="radio2">
                <input type="radio" name="radio-btn" id="radio3">
                <input type="radio" name="radio-btn" id="radio4">

                <!-- IMAGENES -->
                <div class="slide first">
                    <img src="images/img_slide1.jpg" alt="">
                </div>
                <div class="slide ">
                    <img src="images/img_slide2.jpg" alt="">
                </div>
                <div class="slide ">
                    <img src="images/img_slide3.jpg" alt="">
                </div>
                <div class="slide ">
                    <img src="images/img_slide4.jpg" alt="">
                </div>

                <!-- NAVEGACION AUTO -->
                <div class="navigation-auto">
                    <div class="auto-btn1"></div>
                    <div class="auto-btn2"></div>
                    <div class="auto-btn3"></div>
                    <div class="auto-btn4"></div>
                </div>
            </div>
                <div class="navigation-manual">
                    <label for="radio1" class="manual-btn"></label>
                    <label for="radio2" class="manual-btn"></label>
                    <label for="radio3" class="manual-btn"></label>
                    <label for="radio4" class="manual-btn"></label>
                </div>
        </div>
    </div>

    <!-- MOVIMIENTO AUTOMATICO EN EL CARROUSEL -->
<script>
    var counter = 1;
    setInterval(function(){
       document.getElementById('radio' + counter).checked =true;
       counter++;

       if(counter > 4){
            counter = 1;
       }
    }, 3500);
</script>

<!-- Insercion de particulas -->
<script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
<script src="js/app.js"></script>

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