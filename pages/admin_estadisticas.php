<?php

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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,400;1,400;1,500;1,900&family=Lobster&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/b50f20f4b1.js" crossorigin="anonymous"></script>
    <link rel="icon" href="../images/icon.png">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/style_admin.css">
    <link rel="stylesheet" href="../css/style_collapsed_menu.css">
    <link rel="stylesheet" href="../css/style_admin_grafico.css">
    <script src="../js/jquery.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/variable-pie.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>


    <title>Estado de Usuarios</title>
</head>
<body>

<div id="particles-js"></div>
<!-- CABECERA DE TRABAJO -->
<header>

    <div class="contenedor_principal">
        <div class="contenedor_logo">
            <a href="../index.php"><img id="imagen_logo" src="../images/logo.png" alt="Error al cargar la imagen"></a>
        </div>
        <div class="contenedor_nombre_adm">
            <span> ESTADÍSTICAS DE USUARIOS </span>

        </div>
        <div class="contenedor_admin">
            Nombre de usuario:
            <span class="info_admin">
                <?php
                    echo " $nombre_admin";
                ?>
            </span><br>
            <span>
                ID usuario:
            </span>
            <span class="info_admin">
                <?php
                    echo " $id_admin";
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
            <div id="name"><span>Nombre: <?php echo $nombre_admin ?></span></div>
            <div id="name"><span>Id: <?php echo $id_admin ?></span></div>
        </div>

        <!-- ITEMS -->
        <div id="menu-items">

            <div class="item">
                <a href="../index.php">
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
                <a href="#">
                    <div class="icon"><img src="../images/users_admin.png" alt=""></div>
                    <div class="title"><span>Gestion de usuarios</span></div>

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

<!-- BARRA DE NAVEGACION -->
<div class="contenedor_menu">

    <div class="contenedor_listas">
        <ul>
            <a href="../index.php"><li class="btn-inicio-go_home">Menu Principal</li></a>
            <a href="suscription.php"><li>Suscripciones<i class="fa fa-angle-down"></i></a>
                <ul>
                    <a href="compras.php?suscp=Prem"><li> Premiun</li></a>
                    <a href="compras.php?suscp=Basic"><li> Basico</li></a>
                </ul>
            </li>
            <a href="quienes_somos.php"><li class="btn-inicio-go_catalogo">¿Quienes somos?</li></a>

        </ul>
    </div>
</div>

<div class="contenedor_grafico">
    <div id="container"></div>
</div>
            <!-- CONSULTA PARA EL LLENADO DE LA GRAFICA -->
            <?php
                    $sql = "SELECT COUNT(*)total_adm FROM users WHERE TIPO_USUARIO = 'Admin'";
                    $result = mysqli_query($conectar, $sql);
                    $total_adm = mysqli_fetch_array($result);

                    $sql2 = "SELECT COUNT(*)total_cli FROM users WHERE TIPO_USUARIO = 'Cliente'";
                    $result2 = mysqli_query($conectar, $sql2);
                    $total_cli = mysqli_fetch_array($result2);

                    $sql3 = "SELECT COUNT(*)total_asev FROM users WHERE TIPO_USUARIO = 'Asesor de ventas'";
                    $result3 = mysqli_query($conectar, $sql3);
                    $total_asev = mysqli_fetch_array($result3);

                    $sql4 = "SELECT COUNT(*)total_asetec FROM users WHERE TIPO_USUARIO = 'Asesor Técnico'";
                    $result4 = mysqli_query($conectar, $sql4);
                    $total_asetec = mysqli_fetch_array($result4);

                    $sql5 = "SELECT COUNT(*)total_us FROM users";
                    $result5 = mysqli_query($conectar, $sql5);
                    $total_us = mysqli_fetch_array($result5);

                    $porc_adm       = ($total_adm['total_adm'] * 100) / $total_us['total_us'];
                    $porc_cli       = ($total_cli['total_cli'] * 100) / $total_us['total_us'];
                    $porc_asev      = ($total_asev['total_asev'] * 100) / $total_us['total_us'];
                    $porc_asetec    = ($total_asetec['total_asetec']) * 100 / $total_us['total_us'];


            ?>

<div class="contenedor_tabla2">
<table class="users_table2">
    <tr>
        <th>TIPO DE USUARIO</th>
        <th>CANTIDAD</th>
        <th>PORCENTAJE</th>
    </tr>
    <tr>
        <td>Administrador</td>
        <td><?php echo $total_adm['total_adm']      ?></td>
        <td><?php echo $porc_adm.'%'                    ?></td>
    </tr>
    <tr>
        <td>Clientes</td>
        <td><?php echo $total_cli['total_cli']      ?></td>
        <td><?php echo $porc_cli.'%'                    ?></td>
    </tr>
    <tr>
        <td>Asesores de Ventas</td>
        <td><?php echo $total_asev['total_asev']      ?></td>
        <td><?php echo $porc_asev.'%'                     ?></td>
    </tr>
    <tr>
        <td>Asesores Técnicos</td>
        <td><?php echo $total_asetec['total_asetec']  ?></td>
        <td><?php echo $porc_asetec.'%'                   ?></td>
    </tr>

</table>

</div>



<script>
Highcharts.chart('container', {
    chart: {
        type: 'variablepie'
    },
    title: {
        text: 'Estadísticas del total de usuarios'
    },
    tooltip: {
        headerFormat: '',
        pointFormat: '<span style="color:{point.color}">\u25CF</span> <b> {point.name}</b><br/>' +
            'Cantidad de usuarios: <b>{point.y}</b><br/>' +
            'Porcentaje (Total de usaurios): <b>{point.z} % </b><br/>'
    },
    series: [{
        minPointSize: 10,
        innerSize: '20%',
        zMin: 0,
        name: 'Gestion de Usuarios',
        data: [{
            name: 'Administradores',
            y: <?php echo $total_adm['total_adm'] ?>,
            z: <?php echo $porc_adm ?>
        }, {
            name: 'Clientes',
            y: <?php echo $total_cli['total_cli'] ?>,
            z: <?php echo $porc_cli ?>
        }, {
            name: 'Asesores de Ventas',
            y: <?php echo $total_asev['total_asev'] ?>,
            z: <?php echo $porc_asev ?>
        }, {
            name: 'Asesores Técnicos',
            y: <?php echo $total_asetec['total_asetec']?>,
            z: <?php echo $porc_asetec?>
        }]
    }]
});
</script>





<!-- SCRIPT DE PARTICULAS -->
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