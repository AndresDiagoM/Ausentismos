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
    
    <!-- Bootstrap - STILE FOR CHECKBOXES -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

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

<!-- CONTENEDOR DE CHECKBOXES PARA LOS FILTROS -->
<div class="container offset-md-2 col-md-8">
    <br>
    <header class="main-header">
        <h4>
            <span class="icon-title">
                <i class="fas fa-filter"></i>
            </span>
            Filtros M&uacute;ltiples con Checkboxes
        </h4>
    </header>
    <br>


    <form class="row" id="multi-filters">
        <div class="col-3">
            <h6>Tipo Ausentismo</h6>
            <?php
                $sqli = "SELECT * FROM tipoausentismo";
                $tipoAusentismos = $conectar->query($sqli);  //print_r($ausentismos);
        
                $ausen_list = [];
        
                while($tipo = $tipoAusentismos->fetch_assoc()){
                    $ausen_list[$tipo["ID"]]=$tipo;
                    $ID = $tipo["ID"];
                    $Nombre=$tipo["TipoAusentismo"];
                    /*<?php echo "\""."type_".$ID."\""; ?> --> "type_1"  */
            ?>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id=<?php echo "\""."type_".$ID."\""; ?>  name="Tipo_Ausentismno[]" value=<?php echo "\"$Nombre\""; ?> >
                <label class="form-check-label" for=<?php echo "\""."type_".$ID."\""; ?> > <?php echo $Nombre; ?> </label>
            </div>
            <?php
                }
            ?>
            <!-- <div class="form-check">
                <input type="checkbox" class="form-check-input" id="type_2" name="Tipo_Ausentismno[]" value="Licencia">
                <label class="form-check-label" for="type_2">Licencia</label>
            </div> -->
        </div>


        <div class="col-3">
            <h6>Dependencia</h6>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="country_1" name="UserCountry[]" value="México">
                <label class="form-check-label" for="country_1">M&eacute;xico</label>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="country_2" name="UserCountry[]" value="Venezuela">
                <label class="form-check-label" for="country_2">Venezuela</label>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="country_3" name="UserCountry[]" value="España">
                <label class="form-check-label" for="country_3">España</label>
            </div>
        </div>

        <div class="col-3">
            <h6>G&eacute;nero</h6>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="gender_1" name="UserGender[]" value="Hombre">
                <label class="form-check-label" for="gender_1">Hombre</label>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="gender_2" name="UserGender[]" value="Mujer">
                <label class="form-check-label" for="gender_2">Mujer</label>
            </div>
        </div>

        <div class="col-3">
            <h6>C&eacute;dula</h6>
            <div class="form-input">
                <input type="text" class="form-input" id="caja_busqueda" name="Cedula[]" size="20" placeholder="Ingrese la cédula">
            </div>
        </div>
        
        
        <div class="col-3">
            <h6>Fecha Inicio</h6>
            <div class="form-date">
                <input type="date" class="form-check-input" id="fecha_inicio" name="Fecha_Inicio[]" value="2018-07-22" min="2018-01-01">
            </div>
        </div>

    </form>
    <br><br>
</div>

<!-- CONTENEDOR CON TABLA DE AUSENTISMOS -->
<div class="table table-bordered table-hover">
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
    <tbody id="filters-result" class="bg-white">
            <!-- Aquí se inserta los datos desde el script ../js/consultar.js -->
    </tbody>

</table>
</div>


<!-- SCRIPT DE PARTICULAS -->
<script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
<script src="../js/app.js"></script>
<!-- INSTALACION DE JQUERY -->
<script src="../js/jquery.min.js"></script>


<!-- bootstrap -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

<script src="../js/consultar.js"></script>

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