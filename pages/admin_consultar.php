<?php
    //CONSULTAR AUSENTISMOS
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
    <title>Admin</title>
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
            <span> Consultar Ausentismos </span>            
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
                <a href="../logic/cerrar_sesion.php"><button class="btn-cierre-sesion">Cerrar Sesión</button></a>
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
                    <div class="title"><span>Menú Principal</span></div>
                </a>
            </div>

                <!-- SEPARADOR -->
                <div class="item separator">
                </div>

            <div class="item">
                <a href="#">
                    <div class="icon"><img src="../images/upload.png" alt=""></div>
                    <div class="title"><span>Cargar Datos</span></div>
                </a>
            </div>

                <!-- SEPARADOR -->
                <div class="item separator">
                </div>

            <div class="item">
                <a href="#">
                    <div class="icon"><img src="../images/add.png" alt=""></div>
                    <div class="title"><span>Agregar Registro</span></div>
                </a>
            </div>
                <!-- SEPARADOR -->
                <div class="item separator">
                </div>

            <div class="item">
                <a href="admin_consultar.php">
                    <div class="icon"><img src="../images/stadistics.png" alt=""></div>
                    <div class="title"><span>Consultar Ausentismos</span></div>
                </a>
            </div>

                <!-- SEPARADOR -->
                <div class="item separator">
                </div>

            <div class="item">
                <a href="admin_edition_client.php">
                    <div class="icon"><img src="../images/users_admin.png" alt=""></div>
                    <div class="title"><span>Gestionar Usuario</span></div>
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
            <a href="quienes_somos.php"><li class="btn-inicio-go_catalogo">¿Quiénes somos?</li></a>
            <a href="admin_menu.php"><li class="btn-dashboard">Menú del Usuario</li></a>

        </ul>
    </div>
</div>


<!-- CONTENEDOR CON TABLA DE USUARIOS -->
<div class="contenedor_tabla">
<table class="users_table">
    <tr>
        <th>ID</th>
        <th>CEDULA </th>
        <th>FECHA INICIO</th>
        <th>FECHA FIN</th>
        <th>TIEMPO</th>
        <th>OBSERVACIÓN</th>
        <th>Seguridad_Trabajo</th>
        <th>ID_USUARIO</th>
        <th>TIPO AUSENTISMO</th>

    </tr>
    <?php
        $sqli = "SELECT * FROM ausentismos";
        $result = mysqli_query($conectar, $sqli);
        while($mostrar = mysqli_fetch_array($result)){
    ?>
    <tr>

        <td><?php echo $mostrar['ID']?></td>
        <td><?php echo $mostrar['Cedula_F']?></td>
        <td><?php echo $mostrar['Fecha_Inicio']?></td>
        <td><?php echo $mostrar['Fecha_Fin']?></td>
        <td><?php echo $mostrar['Tiempo']?></td>
        <td><?php echo $mostrar['Observacion']?></td>
        <td><?php echo $mostrar['Seguridad_Trabajo']?></td>
        <td><?php echo $mostrar['ID_Usuario']?></td>
        <?php 
            $tipo="";
            if($mostrar['Tipo_Ausentismo']==1){
                $tipo="INCAPACIDAD";
            }elseif($mostrar['Tipo_Ausentismo']==2){
                $tipo="COMPENSATORIO";
            }elseif($mostrar['Tipo_Ausentismo']==3){
                $tipo="PERMISO";
            }else{
                $tipo="LICENCIA";
            }
        ?>
        <td><?php echo $tipo ?></td>


    </tr>
    <?php
        }
    ?>
    </table>
</div>


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


</body>
</html>