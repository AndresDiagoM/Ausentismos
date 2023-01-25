<?php
include "../logic/admin_securityLogic.php"; // Verifica que el usuario sea administrador
include "../template/cabecera.php";
?>

        <!-- CONTENEDORES DE BUSQUEDAS Y BOTON DE CREAR -->
        <div class="row ms-1">

            <!-- CONTENEDORES DE BUSQUEDAS -->
            <div class="container row col-3 py-2">
                <form class="row" id="auto_llenar">
                    <div class="form-floating mb-3">
                            <input class="form-control" type="text" name="caja_busqueda" id="caja_busqueda" pattern="[a-zA-Z0-9\s]+" size="50" placeholder="Ingrese el ID que desea buscar">
                            <label class="col-form-label" for="caja_busqueda">Buscar cedula: </label>
                    </div>
                </form>
            </div>

            <!-- Contenedor del boton de nuevo funcionario -->
            <div class="container row col-2 ms-1 py-3">
                <a href="../pages/admin_create_func.php">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Crear Funcionario
                    </button>
                </a>
            </div>

        </div>

        <!-- Contenedor de la tabla de funcionarios -->
        <div class="container py-4" style="overflow-x: auto; overflow-y: auto; height:65vh; font-size:14px" id="datos">

        </div>

        <!-- Contener de paginador y boton de reporte -->
        <div class="container offset-md-0 col-md-7">
            <section>
                <!-- Contenedor de los botones del paginador de las consultas -->
                <div class="offset-md-8 col-md-6 text-center py-1">
                    <ul class="pagination pagination-lg pager" id="myPager">

                    </ul>
                    <!-- <ul class="pagination pg-dark justify-content-center pb-5 pt-5 mb-0" style="float: none;" id="myPager">
                            <li class="page-item">

                            </li>
                    </ul> -->
                </div>
            </section>

            <section class="py-1">
                    <!-- py-3 es padding en y, como <br> -->
                    <div class="container">
                        <div class="row">
                            <!-- con 2 columnas -->

                            <div class="col-lg-8 d-flex">
                                <h3 class="font-weight-bold mb-0 me-2">Resultados: </h3> <!-- mb-0 es sin margen inferior -->
                                <h3 class="font-weight-bold mb-0 me-2" id="total_resultados"> </h3>
                            </div>

                        </div>
                    </div>
            </section>
        </div>


</div> <!-- fin de la clase w-100-->
</div> <!-- fin de la clase d-flex -->

    <!-- Bootstrap core JavaScript -->
    <script src="../assets/bootstrap-5.2.2-dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="../bootstrap-5.2.2-dist/js/bootstrap.min.js"></script> -->
    <script src="../assets/bootstrap-5.2.2-dist/js/popper.min.js"></script>

    <!-- APP JS CONTIENE  FUNCIONES PARA LOS GRÁFICOS -->
    <script src="../js/app1.js"></script>
    <!-- INSTALACION DE JQUERY -->
    <script src="../js/jquery.min.js"></script> 

    <!-- JAVASCRIPT QUE REALIZA LA BUSQUEDA DINAMICA -->
    <script src="../js/search_func_edit.js"></script>


<?php
    include("../template/pie.php");
?>