<?php
//MENU DEL ADMIN, CON DASHBOARD
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

    <!-- Bootstrap 4 CSS -->
    <!--  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous"> -->

    <!-- Bootstrap local -->
    <link rel="stylesheet" href="../bootstrap-4.4.1-dist/css/bootstrap.min.css">

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
                        <!-- sobreescribir clase btn-primary, para poner color morado.  w-100 es para que ocupe el ancho del div 
                        <button class="btn btn-primary w-100 align-self-center"> Descargar reporte </button> -->
                        <!-- align-self-center es para centrar el boton, junto con d-flex -->
                    </div>

                </div>
            </div>
        </section>

        <!-- Contenerdor de estadisticas-->
        <section class="bg-mix">
            <div class="container">
                <div class="card rounded-0">
                    <div class="d-flex card-header bg-light">
                        <h4 class="font-weight-bold mb-0 mr-3"> Ausentismos por tipo, año: </h4>
                        <select class="" id="statsOptions">
                            
                        </select>
                    </div>
                    <div class="card-body">
                        <div class="row" id="estadisticas">
                            
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contenerdor de graficos -->
        <section class="bg-gray">

            <div class="container">
                <div class="row">

                    <!-- grafico 1: Años -->                    
                    <div class="col-lg-6 my-3">
                        <div class="card rounded-0 ">
                            <div class="d-flex card-header bg-light">
                                <h6 class="font-weight-bold mb-0 mr-3">Numero de ausentismos por mes, tipo: </h6>
                                <select class="" id="tiposMonthsOptions">
                                    
                                </select>
                                
                            </div>
                            <div class="card-body">
                                <canvas id="monthsChart" height="400"></canvas>
                                
                            </div>
                        </div>
                    </div>

                    <!-- grafico 2: Meses -->                    
                    <div class="col-lg-6 my-3">
                        <div class="card rounded-0 ">
                            <div class="d-flex card-header bg-light">
                                <h6 class="font-weight-bold mb-0 mr-3">Ausentismos por tipo en el mes: </h6>                                
                                <select class="" id="tiposChartOptions">
                                    
                                </select>
                            </div>
                            <div class="card-body">
                                <canvas id="tiposChart" height="400"></canvas>
                                
                            </div>
                        </div>
                    </div>

                    <!-- grafico 3: Genero -->
                    <div class="col-lg-6 my-3">
                        <div class="card rounded-0 ">

                            <div class="card-header bg-light">
                                <h6 class="font-weight-bold mb-0"> Ausentismos por Genero </h6>
                            </div>

                            <div class="card-body">
                                <canvas id="genderChart" height="400"></canvas>
                            </div>

                            <div class="d-flex card-footer bg-light">
                                <h5 class="font-weight-bold mb-0 mr-2"> Total Ausentismos:  </h5>
                                <h6 class="font-weight-bold mb-0 py-1" id="genderTotal">  </h6>
                            </div>

                        </div>
                    </div>

                    <!-- grafico 4: Indicador -->
                    <div class="col-lg-6 my-3">
                        <div class="card rounded-0 ">

                            <div class="card-header bg-light">
                                <h6 class="font-weight-bold mb-0"> Indicador de costo </h6>
                            </div>

                            <div class="card-body">
                                <canvas id="costoChart" height="400"></canvas>
                            </div>

                            <div class="card-footer bg-light">
                                <h6 class="font-weight-bold mb-0" id="costoTotal">  </h6>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </section>

    </div>



    <!-- SCRIPT DE PARTICULAS -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script> -->
    <script src="../js/particles.min.js"></script>
    <script src="../js/app.js"></script>

    <!-- CDN: Libreria de chart.js para las gráficas -->
    <script src="../chart.js-3.9.1/package/dist/chart.min.js"></script>
    <script src="../chart.js-3.9.1/package/dist/chart.js"></script>

    <!-- INSTALACION DE JQUERY -->
    <script src="../js/jquery.min.js"></script> 

    <!-- LOCAL: JQuery, AJAX, Bootstrap 
    <script src="../bootstrap-4.4.1-dist/js/jquery-3.6.1.min.js"></script> -->     
    <script src="../bootstrap-4.4.1-dist/js/bootstrap.min.js"></script>


    <?php //include 'grafico1.php'; ?>
    <script src="../js/graficasCharts.js"></script>

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