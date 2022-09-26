<?php
    include "../conexion.php";
    include "../logic/admin_securityLogic.php";

     // Inicio o reanudacion de una sesion
    $nombre_admin   = $_SESSION['NOM_USUARIO'];
    $id_admin       = $_SESSION['ID_USUARIO'];
    $tipo_usuario   = $_SESSION['TIPO_USUARIO'];
    $id_usuario     = $_GET['ID'];

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
    <link rel="stylesheet" href="../css/style_admin_form.css">
    <title>Eliminar Usuario</title>

    <!-- CONEXION CON AJAX -->
    <script type="text/javascript">

        function mostrarSelect(str){
            var conexion;

            if(str==""){

                document.getElementById("txtHint").innerHTML="";
                return;
            }

            if(window.XMLHttpRequest){
                conexion = new XMLHttpRequest();

            }

            conexion.onreadystatechange = function(){
                if(conexion.readyState == 4 && conexion.status == 200){
                    document.getElementById("div").innerHTML = conexion.responseText;
                }
            }

            conexion.open("GET", "../logic/municipiosLogic.php?c="+str,true);
            conexion.send();
        }

    </script>
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
            <span>FORMULARIO DE EDICIÓN</span>
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
                <a href="#">
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
            <a href="../index.php"><li class="btn-inicio-go_home">Menú Principal</li></a>
            <a href="suscription.php"><li>Suscripciones<i class="fa fa-angle-down"></i></a>
                <ul>
                    <a href="compras.php?suscp=Prem"><li> Premiun</li></a>
                    <a href="compras.php?suscp=Basic"><li> Básico</li></a>
                </ul>
            </li>
            <a href="quienes_somos.php"><li class="btn-inicio-go_catalogo">¿Quiénes somos?</li></a>
            <a href="admin_menu.php"><li class="btn-dashboard">Menú del Usuario</li></a>
    </div>
</div>
<div class="contenedor_formularios">
    <div class="contenedor_formulario1">
        <div class="encabezado">
            DATOS ACTUALES
        </div>
        <div class="contenedor_info">
        <?php
            $sqli   = "SELECT * FROM users WHERE ID = '$id_usuario'";
            $result = mysqli_query($conectar, $sqli);
            while($mostrar = mysqli_fetch_array($result)){

                $Id_editar = $mostrar['ID'];


        ?>
        <div class="contenedor_perfil">
            <img src="../images/profile2.png" alt="Error al cargar la imagen">
        </div>
            <div class="contenedor_datos">
                <div class="contenedor_datos_col1">
                    <p>ID:</p>
                    <p>NOMBRE:</p>
                    <p>FECHA DE NACIMIENTO:</p>
                    <p>TIPO DE IDENTIFICACIÓN:</p>
                    <p>DIRECCIÓN:</p>
                    <p>DEPARTAMENTO:</p>
                    <p>MUNICIPIO:</p>
                    <p>CELULAR:</p>
                    <p>TIPO DE USUARIO:</p>
                </div>
                <div class="contenedor_datos_col2">
                    <p> <?php echo $mostrar['ID']           ?></p>
                    <p> <?php echo $mostrar['NAME_LASTNAME']?></p>
                    <p> <?php echo $mostrar['DATE']         ?></p>
                    <p> <?php echo $mostrar['TYPE_ID']      ?></p>
                    <p> <?php echo $mostrar['ADDRESS']      ?></p>
                    <p> <?php echo $mostrar['DEPARTAMENTO'] ?></p>
                    <p> <?php echo $mostrar['MUNICIPIO']    ?></p>
                    <p> <?php echo $mostrar['CELLPHONE']    ?></p>
                    <p> <?php echo $mostrar['TIPO_USUARIO'] ?></p>
                </div>
            </div>



        <?php
            }
        ?>
        </div>
    </div>
    <div class="contenedor_formulario2">
        <div class="encabezado">
            MODIFICACIÓN DE DATOS
        </div>
        <div class="contenedor_perfil">
            <img src="../images/profile2.png" alt="Error al cargar la imagen">
        </div>

        <div class="contenedor_formulario">

            <form action="../logic/form_editLogic.php?ID=<?php echo $Id_editar ?>" method="POST">

                <!-- INPUT DE NOMBRE Y APELLIDOS -->
                <div class="form_container">
                    <div class="form_group">
                        <label for="nombre_usuario_edt">NOMBRE Y APELLIDOS</label>
                        <input type="text" name="nombre_usuario_edt" class="input_decor" min="4" max="40" placeholder="nombres y apellidos" required>
                        <span class="form_line"></span>
                    </div>
                </div>
                <!-- INPUT DE FECHA DE NACIMIENTO -->
                <div class="form_container">
                    <div class="form_group">
                        <label for="fecha_nac_edt">FECHA DE NACIMIENTO</label>
                        <input type="date" name="fecha_nac_edt" class="input_decor" min="1950-01-01" max="2004-12-31"  required>
                        <span class="form_line"></span>
                    </div>
                </div>
                <!-- INPUT DE TIPO DE DOCUMENTO -->
                <div class="form_container">
                    <div class="form_group">
                        <label for="tipo_doc_edt"> TIPO DE DOCUMENTO </label>
                        <select class="input_decor" name="tipo_doc_edt">
                            <option value="">Seleccione</option>
                            <option value="CC">CEDULA DE CIUDADANIA</option>
                            <option value="PST">PASAPORTE</option>
                        </select>
                        <span class="form_line"></span>
                    </div>
                </div>
                <!-- INPUT DE LA DIRECCION  -->
                <div class="form_container">
                    <div class="form_group">
                        <label for="direccion_edt"> DIRECCIÓN </label>
                        <input type="text" name="direccion_edt" class="input_decor" placeholder="Número de dirección">
                        <span class="form_line"></span>
                    </div>
                </div>
                <!-- SELECT DE DEPARTAMENTO -->
                <div class="form_container">
                    <div class="form_group">
                        <label for="depart"> DEPARTAMENTO </label>
                        <select class="input_decor" name="depart" onclick="mostrarSelect(this.value)">
                            <!-- <option >Departamento</option> -->

                            <?php
                                include "../logic/departamentosLogic.php";
                            ?>

                        </select>
                        <span class="form_line"></span>
                    </div>
                </div>
                <!-- SELECT DE MUNICIPIO -->
                <div class="form_container">
                    <div class="form_group" id="div">
                        <label for="munic"> MUNICIPIO </label>
                        <select class="input_decor" name="munic">
                            <option>MUNICIPIO</option>
                        </select>
                        <span class="form_line"></span>
                    </div>
                </div>
                <div class="contenedor_guardar">
                   <button type="submit" class="btn_guardar">GUARDAR</button>
                </div>

            </form>



        </div>





    </div>
</div>





<!-- SCRIPTS DE PARTICULAS Y DEL MENU LATERAL -->
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
