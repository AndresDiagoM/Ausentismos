<?php
    include("../template/cabecera.php");
?>

    <!-- Contenerdor del contenido de la página-->
    <div id="content">

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
                    <div class="col-lg-6 col-md-12 my-3">
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
                    <div class="col-lg-6 col-md-12 my-3">
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
                    <div class="col-lg-6 col-md-12 my-3">
                        <div class="card rounded-0 ">

                            <div class="card-header bg-light">
                                <h6 class="font-weight-bold mb-0"> Ausentismos por Genero </h6>
                            </div>

                            <div class="card-body">
                                <canvas id="genderChart" height="400"></canvas>
                            </div>

                            <div class="d-flex card-footer bg-light">
                                <h5 class="font-weight-bold mb-0 me-2"> Total Ausentismos:  </h5>
                                <h6 class="font-weight-bold mb-0 py-1" id="genderTotal">  </h6>
                            </div>

                        </div>
                    </div>

                    <!-- grafico 4: Indicador -->
                    <div class="col-lg-6 col-md-12 my-3">
                        <div class="card rounded-0 ">

                            <div class="card-header bg-light">
                                <h6 class="font-weight-bold mb-0"> Indicador de costo </h6>
                            </div>

                            <div class="card-body">
                                <canvas id="costoChart" height="400"></canvas>
                            </div>

                            <div class="card-footer bg-light">
                                <h5 class="font-weight-bold mb-0" id="costoTotal">  </h5>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </section>

    </div>



    </div> <!-- fin de la clase w-100-->
    </div> <!-- fin de la clase d-flex -->

<script src="../bootstrap-5.2.2-dist/js/bootstrap.bundle.min.js"></script>
<!-- <script src="../bootstrap-5.2.2-dist/js/bootstrap.min.js"></script> -->
<script src="../bootstrap-5.2.2-dist/js/popper.min.js"></script>


    <!-- APP JS CONTIENE  FUNCIONES PARA LOS GRÁFICOS -->
    <script src="../js/app1.js"></script>

    <!-- INSTALACION DE JQUERY -->
    <script src="../js/jquery.min.js"></script> 

    <!-- CDN: Libreria de chart.js para las gráficas -->
    <script src="../chart.js-3.9.1/package/dist/chart.min.js"></script>
    <script src="../chart.js-3.9.1/package/dist/chart.js"></script>
    <script src="../js/graficasCharts.js"></script>

</body>
</html>