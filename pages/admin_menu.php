<?php
    include("../template/cabecera.php");
?>

    <!-- Contenerdor del contenido de la página-->
    <div class="mx-auto">

    
    <div id="content">

        <!-- Contenerdor de bienvenida y boton de reporte-->
        <section class="py-3">
            <!-- py-3 es padding en y, como <br> -->
            <div class="container-fluid">
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
            <div class="container-fluid">
            
                <div class="card rounded-0 mx-auto">
                    <div class="d-flex card-header bg-light">
                        <h4 class="font-weight-bold mb-0 me-3"> Ausentismos por tipo, año: </h4>
                        <select class="" id="statsOptions">
                            
                        </select>
                        <div class="d-flex ms-auto">
                            <h5 class="text-right font-weight-bold mb-0 " id="costoTotal">  </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row" id="estadisticas">
                        
                        </div>
                        
                        <!-- <div class='col-lg-1 col-md-4 d-flex stat my-2'>
                            <div class='mx-auto'>
                                
                                <h6 class='text-muted'> Costo Total </h6>
                                <h6 class="font-weight-bold mb-0" id="costoTotal">  </h6>
                            </div>
                        </div> -->

                    </div>
                </div>
            
            </div>
        </section>

        <!-- Contenerdor de graficos -->
        <section class="bg-gray">

            <div class="container-fluid">
                <div class="row">

                    <!-- grafico 1: Años -->                    
                    <div class="col-lg-6 col-md-12 my-3">
                        <div class="card rounded-0 ">
                            <div class="d-flex card-header bg-light">
                                <h6 class="font-weight-bold mb-0 me-2">Numero de ausentismos por mes, tipo: </h6>
                                <select class="form-select form-select-sm" id="tiposMonthsOptions">
                                    
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
                                <h6 class="font-weight-bold mb-0 me-2">Ausentismos por tipo en el mes: </h6>                                
                                <select class="form-select form-select-sm" id="tiposChartOptions">
                                    
                                </select>
                            </div>
                            <div class="card-body">
                                <canvas id="tiposChart" height="400"></canvas>
                                
                            </div>
                        </div>
                    </div>

                    <!-- grafico 3: Dependencias -->
                    <div class="col-lg-6 col-md-12 my-3">
                        <div class="card rounded-0 ">

                            <div class="d-flex card-header bg-light">
                                <h6 class="font-weight mb-0 me-2"> Ausentismos por Dependencia </h6>

                                <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="tiposDepenOptions">
                                
                                </select>
                            </div>

                            <div class="card-body">
                                <canvas id="funcChart"  height="440"></canvas>
                            </div>

                        </div>
                    </div>

                    <!-- grafico 4: Indicador -->
                    <div class="col-lg-6 col-md-12 my-3">
                        <div class="card rounded-0 ">

                            <div class="d-flex card-header bg-light">
                                <h6 class="font-weight-bold mb-0 me-2"> Indicador de costo </h6>
                                <select class="form-select form-select-sm" id="costoChartOptions">
                                    
                                </select>
                            </div>

                            <div class="card-body">
                                <canvas id="costoChart" height="400"></canvas>
                            </div>

                            <div class="card-footer bg-light">
                                <h5 class="font-weight-bold mb-0" id="costoTotal1">  </h5>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </section>

    </div></div>



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
    <script src="../chart.js-3.9.1/package/dist/chartjs-plugin-datalabels.min.js"></script>

    <script src="../js/graficasCharts.js"></script>

</body>
</html>