<?php
//MENU DEL ADMIN, CON DASHBOARD
include "../conexion.php";
include "../logic/admin_securityLogic.php";

// Inicio o reanudacion de una sesion
$nombre_admin   = $_SESSION['NOM_USUARIO'];
$id_admin       = $_SESSION['ID_USUARIO'];
$tipo_usuario   = $_SESSION['TIPO_USUARIO'];


    $sqli = "SELECT Tipo_Ausentismo, COUNT(*) FROM ausentismos GROUP BY Tipo_Ausentismo ORDER BY COUNT(*) DESC;";
    $numeros = $conectar->query($sqli);  //print_r($numeros);

    $incapacidad = 0;
    $compensatorio = 0;
    $permiso = 0;
    $licencia = 0;
    while ($numero = $numeros->fetch_assoc()) {
        //echo "['".$numero['Tipo_Ausentismo']."',".$numero['COUNT(*)']."],";
        if ($numero['Tipo_Ausentismo'] == 1) {
            $incapacidad = $numero['COUNT(*)'];
        } elseif ($numero['Tipo_Ausentismo'] == 2) {
            $compensatorio = $numero['COUNT(*)'];
        } elseif ($numero['Tipo_Ausentismo'] == 3) {
            $permiso = $numero['COUNT(*)'];
        } elseif ($numero['Tipo_Ausentismo'] == 4) {
            $licencia = $numero['COUNT(*)'];
        }
    }
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

    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <!-- ICONOS en https://ionic.io/ionicons/v4/usage#md-pricetag -->
    <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">
    

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
            
        </div>
    </header>

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



    <!-- INICIO DE SLIDE MENU -->
    <div class="contenedor_pr_menu">
        <div id="slide-menu" class="menu-expanded">

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
                    <a href="#">
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


    <!-- Contenerdor del contenido de la página-->
    <div class="contenedor_tabla2">

        <!-- Contenerdor de bienvenida y boton de reporte-->
        <section class="py-3">
            <!-- py-3 es padding en y, como <br> -->
            <div class="container">
                <div class="row">
                    <!-- con 2 columnas -->

                    <div class="col-lg-9">
                        <h1 class="font-weight-bold mb-0">Estadísticas de Ausentismos</h1> <!-- mb-0 es sin margen inferior -->
                        <p class="lead text-muted">Revisa la última información</p>
                    </div>
                    <div class="col-lg-3 d-flex">
                        <!-- sobreescribir clase btn-primary, para poner color morado.  w-100 es para que ocupe el ancho del div -->
                        <button class="btn btn-primary w-100 align-self-center"> Descargar reporte </button>
                        <!-- align-self-center es para centrar el boton, junto con d-flex -->
                    </div>

                </div>
            </div>
        </section>

        <!-- Contenerdor de estadisticas-->
        <section class="bg-mix">
            <div class="container">
                <div class="card rounded-0">

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 d-flex stat my-3">
                                <div class="mx-auto">
                                    <!-- para centrar el texto junto con d-flex-->
                                    <h6 class="text-muted"> Incapacidades </h6>
                                    <h3 class="font-wight-bold"> <?php echo $incapacidad; ?> </h3>
                                    <h6 class="text-success"> <i class="icon ion-md-arrow-dropup-circle"></i>50.50% </h6>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 d-flex stat my-3">
                                <div class="mx-auto">
                                    <h6 class="text-muted"> Compensatorios </h6>
                                    <h3 class="font-wight-bold"> <?php echo $compensatorio; ?> </h3>
                                    <h6 class="text-success"> <i class="icon ion-md-arrow-dropup-circle"></i>50.50% </h6>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 d-flex stat my-3">
                                <div class="mx-auto">
                                    <h6 class="text-muted"> Permisos </h6>
                                    <h3 class="font-wight-bold"> <?php echo $permiso; ?> </h3>
                                    <h6 class="text-success"> <i class="icon ion-md-arrow-dropup-circle"></i>50.50% </h6>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6 d-flex stat my-3">
                                <div class="mx-auto">
                                    <h6 class="text-muted"> Licencias </h6>
                                    <h3 class="font-wight-bold"> <?php echo $licencia; ?> </h3>
                                    <h6 class="text-success"> <i class="icon ion-md-arrow-dropup-circle"></i>50.50% </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contenerdor de grafico 1 y tabla de promociones -->
        <section class="bg-gray">

            <div class="container">
                <div class="row">

                    <!-- grafico 1 -->
                    <div class="col-lg-8 my-3">
                        <div class="card rounded-0 ">
                            <div class="card-header bg-light">
                                <h6 class="font-weight-bold mb-0">Numero de ausentismos año 2022 </h6>
                            </div>
                            <div class="card-body">
                                <canvas id="myChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- tabla de promociones -->
                    <div class="col-lg-4 my-3">
                        <div class="card rounded-0 ">

                            <div class="card-header bg-light">
                                <h6 class="font-weight-bold mb-0"> Registros recientes </h6>
                            </div>
                            <div class="card-body pt-2">
                                <div class="d-flex border-bottom py-2">
                                    <!-- contenedor del icono de precio, y texto. D-flex hace que el icono y el texto esten en la mism linea -->
                                    <div class="d-flex mr-3">
                                        <h2 class="align-self-center mb-0">
                                            <i class="icon ion-md-pricetag"></i>
                                        </h2>
                                    </div>
                                    <div class="align-self-center">
                                        <h6 class="d-inline-block mb-0">$250</h6> <span class="badge badge-success ml-2"> 10% descuento </span>
                                        <small class="d-block text-muted"> Permiso</small>
                                    </div>
                                </div>

                                <div class="d-flex border-bottom py-2">
                                    <!-- contenedor del icono de precio, y texto. D-flex hace que el icono y el texto esten en la mism linea -->
                                    <div class="d-flex mr-3">
                                        <h2 class="align-self-center mb-0">
                                            <i class="icon ion-md-pricetag"></i>
                                        </h2>
                                    </div>
                                    <div class="align-self-center">
                                        <h6 class="d-inline-block mb-0">$250</h6> <span class="badge badge-success ml-2"> 10% descuento </span>
                                        <small class="d-block text-muted"> Permiso</small>
                                    </div>
                                </div>

                                <div class="d-flex border-bottom py-2 mb-3">
                                    <!-- contenedor del icono de precio, y texto. D-flex hace que el icono y el texto esten en la mism linea -->
                                    <div class="d-flex mr-3">
                                        <h2 class="align-self-center mb-0">
                                            <i class="icon ion-md-pricetag"></i>
                                        </h2>
                                    </div>
                                    <div class="align-self-center">
                                        <h6 class="d-inline-block mb-0">$250</h6> <span class="badge badge-success ml-2"> 10% descuento </span>
                                        <small class="d-block text-muted"> Permiso</small>
                                    </div>
                                </div>
                                <button class="btn btn-primary w-100"> Ver mas </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </section>

    </div>



    <!-- SCRIPT DE PARTICULAS -->
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    <script src="../js/app.js"></script>

    <!-- CDN: Libreria de chart.js para las gráficas -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js" integrity="sha256-+8RZJua0aEWg+QVVKg4LEzEEm/8RFez5Tb4JBNiV5xA=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Gráfico 1 -->    
    <?php include 'grafico1.php'; ?>
    

<!-- SCRIPT MENU LATERAL --> <!--
<script>
    const btn = document.querySelector('#menu-btn');
    const menu = document.querySelector('#slide-menu');


    btn.addEventListener('click', e => {
        menu.classList.toggle("menu-expanded");
        window.scrollTo(150,150);
        menu.classList.toggle("menu-collapsed");
    });

</script>  -->


</body>

</html>