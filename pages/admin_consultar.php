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
    <!-- <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,400;1,400;1,500;1,900&family=Lobster&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/b50f20f4b1.js" crossorigin="anonymous"></script> -->
    <link rel="icon" href="../images/icon.png">

    <!-- CSS -->
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/style_admin.css">
    <link rel="stylesheet" href="../css/style_collapsed_menu.css">
    
    <!-- Bootstrap - STILE FOR CHECKBOXES -->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"> -->
    
    <!-- Bootstrap local -->
    <link rel="stylesheet" href="../bootstrap-4.4.1-dist/css/bootstrap.min.css">

    <title>Admin</title>
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
            <span> Consultar Ausentismos </span>            
        </div>
        
    </div>
</header>

<!-- INICIO DE SLIDE MENU -->
<div class = "contenedor_pr_menu">
    <div id="slide-menu" class="menu-expanded">

        <!-- HEADER 
        <div id="header">

            <div id="menu-btn">
                <div class="btn-logo"></div>
                <div class="btn-logo"></div>
                <div class="btn-logo"></div>
            </div>
            <div id="title"><span>PERFIL</span></div>

        </div>  -->

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
                <a href="admin_cargar.php">
                    <div class="icon"><img src="../images/upload.png" alt=""></div>
                    <div class="title"><span>Cargar Datos</span></div>
                </a>
            </div>

                <!-- SEPARADOR -->
                <div class="item separator">
                </div>

            <div class="item">
                <a href="admin_agregar.php">
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

            <!-- SEPARADOR -->
            <div class="item separator">
                </div>

            <div class="item">
                <a href="../logic/cerrar_sesion.php">
                    <div class="icon"><img src="../images/cerrar-sesion.png" alt=""></div>
                    <div class="title"><span>Cerrar Sesión</span></div>
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
            <a href="../index.php"><li class="btn-inicio-go_home">Menu Principal</li></a>
            <a href="quienes_somos.php"><li class="btn-inicio-go_catalogo">¿Quiénes somos?</li></a>
            <a href="admin_menu.php"><li class="btn-dashboard">Menú del Usuario</li></a>

        </ul>
    </div>
</div> -->


<!-- CONTENEDOR CON TABLA DE AUSENTISMOS -->
<!--  <div class="table table-bordered table-hover">  PARA USAR CON BOOSTRAP 4-->
<div class="container offset-md-2 col-md-8">

    <section class="py-3">
            <!-- py-3 es padding en y, como <br> -->
            <div class="container">
                <div class="row">
                    <!-- con 2 columnas -->

                    <div class="col-lg-9">
                        <h1 class="font-weight-bold mb-0">Resultados</h1> <!-- mb-0 es sin margen inferior -->
                        <h1 class="lead " id="total_resultados"> </h1>
                    </div>
                    <div class="col-lg-3 d-flex">
                        <!-- sobreescribir clase btn-primary, para poner color morado.  w-100 es para que ocupe el ancho del div -->
                        
                        <a name="reporte" id="" class="btn btn-primary w-100 align-self-center" href="../logic/ausen_excel.php" role="button"> 
                            Reporte
                        </a>
                        <!-- align-self-center es para centrar el boton, junto con d-flex -->
                    </div>

                </div>
            </div>
    </section>
</div>
<div class="contenedor_tabla">         
    <table class="users_table"> <!-- BOOSTRAP4: table table-bordered -->        
        <tr>
            <form class="row" id="multi-filters">

            <th>
                    <ul class="navbar-nav ml-auto">                    
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                            CEDULA
                            </a>
                            <div class="dropdown-menu">
                                <input type="text" class="form-input" id="cedula" name="Cedula_F[]" size="20" placeholder="Ingrese la cédula">
                            </div>
                        </li>
                    </ul>
            </th>
            <th>
                    <ul class="navbar-nav ml-auto">                    
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                            NOMBRE
                            </a>
                            <div class="dropdown-menu">
                                <input type="text" class="form-input" id="nombre" name="Nombre[]" size="20" placeholder="Ingrese el nombre">
                            </div>
                        </li>
                    </ul>
            </th>
            <th>
                    <ul class="navbar-nav ml-auto">                    
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                            FECHA INICIO
                            </a>
                            <div class="dropdown-menu">
                                <input type="date" class="form-date" id="fecha_inicio"  name="Fecha_Inicio[]" value="" min="2018-01-01"> <!-- //value="2019-07-22" -->
                            </div>
                        </li>
                    </ul>
            </th>
            <th>FECHA FIN</th>
            <th>TIEMPO</th>
            <th>UNIDAD</th>
            <th>OBSERVACIÓN</th>
            <th>COSTO</th>
            <th>NOMBRE USUARIO</th>
            <th>
                    <ul class="navbar-nav ml-auto">                    
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                            
                            TIPO AUSENTISMO
                            </a>
                            <div class="dropdown-menu">
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
                                    <input type="checkbox" class="form-check-input" id=<?php echo "\""."type_".$ID."\""; ?>  name="Tipo_Ausentismo[]" value=<?php echo $ID; ?> >
                                    <label class="form-check-label" for=<?php echo "\""."type_".$ID."\""; ?> > <?php echo $Nombre; ?> </label>
                                </div>
                                <?php
                                    }
                                ?>
                                
                            </div>
                        </li>
                    </ul>
            </th>

            </form>
        </tr>

        <tbody id="filters-result" class="bg-white">
                <!-- Aquí se inserta los datos desde el script ../js/consultar.js -->
        </tbody>
    </table>
        
    <!-- Contenedor de los botones del paginador de las consultas -->
    <div class="col-md-12 text-center">
        <ul class="pagination pagination-lg pager" style="margin-left:25rem" id="myPager">

        </ul>
        <!-- <ul class="pagination pg-dark justify-content-center pb-5 pt-5 mb-0" style="float: none;" id="myPager">
                <li class="page-item">

                </li>
        </ul> -->
    </div>
    
</div>



<!-- SCRIPT DE PARTICULAS -->
<!-- <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>  -->
<script src="../js/particles.min.js"></script>
<script src="../js/app.js"></script>

<!-- INSTALACION DE JQUERY -->
<script src="../js/jquery.min.js"></script>


<!-- JQuery, AJAX, Bootstrap -->
<!-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script> -->
<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script> -->

<!-- LOCAL: JQuery, AJAX, Bootstrap -->
<script src="../bootstrap-4.4.1-dist/js/jquery-3.6.1.min.js"></script>
<script src="../bootstrap-4.4.1-dist/js/popper-1.16.0.min.js"></script>
<script src="../bootstrap-4.4.1-dist/js/bootstrap.min.js"></script>


<!-- Script que hace las consultas SQL -->
<script src="../js/consultar.js"></script>


<!-- SCRIPT MENU LATERAL
<script>
    const btn = document.querySelector('#menu-btn');
    const menu = document.querySelector('#slide-menu');


    btn.addEventListener('click', e => {
        menu.classList.toggle("menu-expanded");
        window.scrollTo(150,150);
        menu.classList.toggle("menu-collapsed");
    });

</script>-->

<script>
    //SCRIPT para colocar en fecha inicial, la fecha con mes actual
    var date = new Date();
    var day = date.getDate();
    var month = date.getMonth() + 1;
    var year = date.getFullYear();
    if (month < 10) month = "0" + month;
    if (day < 10) day = "0" + day;
    //var today = year + "-" + month + "-" + day;
    //var today =  +year + "-" + month + "-" + (day+1-day) ;  
    var today = "2019-07-22";
    document.getElementById("fecha_inicio").value = today; 
</script>



</body>
</html>