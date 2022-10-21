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

    <!-- CSS -->
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/style_admin.css">
    <link rel="stylesheet" href="../css/style_collapsed_menu.css">
    <link rel="stylesheet" href="../css/style_create_user.css">
    <link rel="stylesheet" href="../css/style_form.css">
    <title>Creación de usuario</title>
</head>
<body>

<div id="particles-js"></div>
<!-- CABECERA DE TRABAJO -->
<header>

    <div class="contenedor_principal">
        <div class="contenedor_logo">
            <a href="admin_menu.php"><img id="imagen_logo" src="../images/logo.png" alt="Error al cargar la imagen"></a>
        </div>
        <div class="contenedor_nombre_adm">
            <span> CREACIÓN DE USUARIOS</span>
        </div>
    </div>
</header>

<!-- INCLUSION DE PARTICULAS -->
<div id="particles-js"></div>

<!-- SCRIPT PARA LA VERFICACION DE CONTRASEÑAS -->
<script>
    function comprobarPSW(){
        var passw1 = document.formulario.pasw.value;
        var passw2 = document.formulario.re_pasw.value;

        if(passw1 != passw2){
            alert('Las contraseñas NO coinciden');
            document.getElementById("passw").value="";
            document.getElementById("passw_conf").value="";
            return false;
        }
    }
</script>

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


<!-- INICIO DE SLIDE MENU -->
<div class = "contenedor_pr_menu">
    <div id="slide-menu" class="menu-collapsed">

        <!-- HEADER 
        <div id="header">

            <div id="menu-btn">
                <div class="btn-logo"></div>
                <div class="btn-logo"></div>
                <div class="btn-logo"></div>
            </div>
            <div id="title"><span>PERFIL</span></div>

        </div> -->

        <!-- PROFILE -->
        <div id="profile">
            <div id="photo"><img src="../images/profile2.png" alt=""></div>
            <div id="name"><span>Nombre: <?php echo $nombre_admin ?></span></div>
            <div id="name"><span>Id: <?php echo $id_admin ?></span></div>
        </div>

        <!-- ITEMS -->
        <div id="menu-items">

            <div class="item">
                <a href="admin_menu.php">
                    <div class="icon"><img src="../images/home.png" alt=""></div>
                    <div class="title"><span>Menú Principal</span></div>

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

<!-- BARRA DE NAVEGACION 
<div class="contenedor_menu">

    <div class="contenedor_listas">
        <ul>
            <a href="../index.php"><li class="btn-inicio-go_home">Menú Principal</li></a>
            
            <a href="quienes_somos.php"><li class="btn-inicio-go_catalogo">¿Quiénes somos?</li></a>
            <a href="admin_menu.php"><li class="btn-dashboard">Menú del Usuario</li></a>
    </div>
</div> -->

<!-- CONTENEDOR DE FORMULARIO -->
<div class="contenedor_form2">
    <h2>REGISTRO DE USUARIOS</h2>
    <h5>(CONSULTA Y ADMINISTRADOR)</h5>
    <form action="../logic/admin_create_userLogic.php" method="POST" class="form" name="formulario" onsubmit="return comprobarPSW()">
        <!-- INPUT DE NOMBRES DE USUARIO -->
        <div class="form_container">
            <label for="nomb_usuario">Nombres y Apellidos </label>
            <input type="text" name="nomb_usuario" class="input_decor" placeholder="Digite los nombres y apellidos" required>
            <span class="form_line"></span>

        </div>
        
        <!-- INPUT DEL NUMERO DE IDENTIFICACION -->
        <div class="form_container">
            <div class="form_group">
                <label for="numero_id"> Número de identificación </label>
                <input type="text" name="numero_id" class="input_decor" placeholder="Número de identificación" pattern="[0-9]{8,10}" title="La identifiación solo debe contener carácteres numéricos y debe cumplir con el formato nacional" required>
                <span class="form_line"></span>
            </div>
        </div>

        <!-- INPUT DEL CORREO 
        <div class="form_container">
            <div class="form_group">
                <label for="correo"> Correo </label>
                <input type="text" name="correo" class="input_decor" placeholder="Digite su correo"  required>
                <span class="form_line"></span>
            </div>
        </div> -->


        <!-- INPUT DEL CORREO -->
        <div class="form_container">
            <div class="form_group">
                <label for="dependencia"> Dependencia </label>
                <input type="text" name="dependencia" class="input_decor" placeholder="Digite su dependencia"  required>
                <span class="form_line"></span>
            </div>
        </div>
        <!-- SELECT DEL TIPO DE USUARIO -->
        <div class="form_container">
            <div class="form_group">
                <label for="tipo_us"> Tipo de usuario</label>
                <select class="input_decor" name="tipo_us">
                    <option value="">Seleccione</option>
                    <option value="CON">CONSULTA</option>
                    <option value="ADM">ADMINISTRADOR</option>
                </select>
                <span class="form_line"></span>
        </div>
        
        <!-- INPUT DEL LOGIN -->
        <div class="form_container">
            <div class="form_group">
                <label for="login"> Login </label>
                <input type="text" name="login" class="input_decor" placeholder="Digite su login"  required>
                <span class="form_line"></span>
            </div>
        </div>

        <!-- INPUT DE LA CONTRASEÑA -->
        <div class="form_container">
            <div class="form_group">
                <label for="pasw"> Contraseña </label>
                <input type="password" name="pasw" class="input_decor" placeholder="Digite una contraseña" id="passw" required>
                <span class="form_line"></span>
            </div>
        </div>
        <!-- INPUT DE REP CONTRASEÑA -->
        <div class="form_container">
            <div class="form_group">
                <label for="re_pasw">Repita la contraseña </label>
                <input type="password" name="re_pasw" class="input_decor" placeholder="Repita la contraseña" id="passw_conf" required>
                <span class="form_line"></span>
            </div>
        </div>
        <div class="contenedor_guardar">
            <button type="submit" class="btn_registrar">REGISTRAR</button>
        </div>

    </form>
</div>


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
<script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
<script src="../js/app.js"></script>
</body>
</html>

