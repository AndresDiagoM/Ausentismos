<?php

    include '../conexion.php';
    include '../logic/client_securityLogic.php';

    // Validacion de inicio de session
    $nombre_cliente     = $_SESSION['NOM_USUARIO'];
    $id_cliente         = $_SESSION['ID_USUARIO'];
    $tipo_usuario       = $_SESSION['TIPO_USUARIO'];
    $tipo_plan          = $_SESSION['TIPO_PLAN'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/icon.png">
    <link rel="stylesheet" href="../css/style_client.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/style_collapsed_menu.css">
    <link rel="stylesheet" href="../css/style_client_suscription.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,400;1,400;1,500;1,900&family=Lobster&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/b50f20f4b1.js" crossorigin="anonymous"></script>
    <title>Suscripciones</title>
</head>
<body>

<!-- CONTENEDOR DE PARTICULAS -->
<div id="particles-js"></div>

<!-- CABECERA DE TRABAJO -->
<header>

    <div class="contenedor_principal">
        <div class="contenedor_logo">
            <a href="../index.php"><img id="imagen_logo" src="../images/logo.png" alt="Error al cargar la imagen"></a>
        </div>
        <div class="contenedor_nombre_clt">
            <span> MODICAR RANGOS DE ALERTAS </span>

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
            <span class="info_clt">
                <?php
                    echo " $id_cliente";
                ?>
            </span><br>
                Tipo de usuario:
            <span>
                <?php
                    echo $tipo_usuario;
                ?>
            </span>


            <div class="contenedor_cerrar_sesion" >
                <a href="../logic/cerrar_sesion.php"><button class="btn-cierre-sesion">Cerrar Sesion</button></a>
            </div>
        </div>
    </div>
</header>
<!-- INICIO DE SLIDE MENU -->
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
                <a href="#">
                    <div class="icon"><img src="../images/home.png" alt=""></div>
                    <div class="title"><span>Menu Principal</span></div>

                </a>
            </div>

                <!-- SEPARADOR -->
                <div class="item separator">
                </div>

            <div class="item">
                <a href="#">
                    <div class="icon"><img src="../images/stadistics.png" alt=""></div>
                    <div class="title"><span>Estadisticas</span></div>

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
                    <div class="title"><span>Rango de Alertas</span></div>

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



 <!-- BARRA DE NAVEGACION -->
    <div class="contenedor_menu">

        <div class="contenedor_listas">
            <ul>
                <a href="../index.php"><li class="btn-inicio-go_home">Menu Principal</li></a>
                <a href="suscription.php"><li>Suscripciones</a><i class="fa fa-angle-down"></i>
                    <ul>
                        <a href="compras.php?suscp=Prem"><li> Premiun</li></a>
                        <a href="compras.php?suscp=Basic"><li> Basico</li></a>
                    </ul>
                </li>
                <a href="quienes_somos.php"><li class="btn-inicio-go_catalogo">¿Quienes somos?</li></a>

                <?php
                    if($autentication == 'Cliente'){


                ?>
                    <a href="client_menu.php"><li class="btn-dashboard">Menu del Usuario</li></a>
                <?php
                    }

                    elseif($autentication == 'Admin'){
                ?>
                    <a href="admin_menu.php"><li class="btn-dashboard">Menu del Usuario</li></a>
                <?php
                    }

                ?>

            </ul>
        </div>
    </div>
<div style = 'margin-top: 110px'>
<!-- RANGO ALERTAS DE SENSORES -->
<?php  include "rango_alertas.php";  ?>
    
</div>

<!-- AGREGAR PARTICULAS -->
<script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
<script src="../js/app.js"></script>

<!-- SCRIPT MENU LATERAL-->
<script>
    const btn = document.querySelector('#menu-btn');
    const menu = document.querySelector('#slide-menu');

    btn.addEventListener('click', e => {
       menu.classList.toggle("menu-expanded");
       menu.classList.toggle("menu-collapsed");

    });
</script>

</body>
</html>