<?php
    include "../template/cabecera.php";
?>

<!-- CONTENEDOR CON TABLA DE AUSENTISMOS -->
<!--  <div class="table table-bordered table-hover">  PARA USAR CON BOOSTRAP 4-->
<div class="container offset-md-2 col-md-8">

    <section class="py-3">
            <!-- py-3 es padding en y, como <br> -->
            <div class="container">
                <div class="row">
                    <!-- con 2 columnas -->

                    <div class="col-lg-9">
                        <h3 class="font-weight-bold mb-0">Resultados</h3> <!-- mb-0 es sin margen inferior -->
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
    <section>
        <!-- Contenedor de los botones del paginador de las consultas -->
        <div class="col-md-12 text-center">
            <ul class="pagination pagination-lg pager" style="margin-left:25rem" id="myPager">

            </ul>
            <!-- <ul class="pagination pg-dark justify-content-center pb-5 pt-5 mb-0" style="float: none;" id="myPager">
                    <li class="page-item">

                    </li>
            </ul> -->
        </div>
    </section>
</div>
<div class="table-responsive w-100" style="overflow-y: auto; height:75vh;">
    <table class="table table-bordered table-hover table-condensed">
        <thead class="thead-light table-active">
        <tr>
            <form class="row" id="multi-filters">

            <th scope="col">
                    <ul class="navbar-nav ml-auto">                    
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            CEDULA
                            </a>
                            <div class="dropdown-menu">
                                <input type="text" class="form-input" id="cedula" name="Cedula_F[]" size="20" placeholder="Ingrese la cédula">
                            </div>
                        </li>
                    </ul>
            </th>
            <th scope="col">
                    <ul class="navbar-nav ml-auto">                    
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            NOMBRE
                            </a>
                            <div class="dropdown-menu">
                                <input type="text" class="form-input" id="nombre" name="Nombre[]" size="20" placeholder="Ingrese el nombre">
                            </div>
                        </li>
                    </ul>
            </th>
            <th scope="col">
                    <ul class="navbar-nav ml-auto">                    
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            FECHA INICIO
                            </a>
                            <div class="dropdown-menu">
                                <input type="date" class="form-date" id="fecha_inicio"  name="Fecha_Inicio[]" value="" min="2018-01-01"> <!-- //value="2019-07-22" -->
                            </div>
                        </li>
                    </ul>
            </th>
            <th scope="col">FECHA FIN</th>
            <th scope="col">TIEMPO</th>
            <th scope="col">UNIDAD</th>
            
            <th scope="col">COSTO</th>
            
            <th scope="col">CODIGO</th>
            <th scope="col">
                    <ul class="navbar-nav ml-auto">                    
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                DIAGNOSTICO
                            </a>
                            <div class="dropdown-menu">
                                <input type="text" class="form-input" id="diagnostico" name="Diagnostico[]" size="20" placeholder="Ingrese el diagnostico">
                            </div>
                        </li>
                    </ul>
            </th>
            <th scope="col">ENTIDAD</th>

            </form>
        </tr>
        </thead>
        
        <tbody id="filters-result" class="bg-white">
                <!-- Aquí se inserta los datos desde el script ../js/consultar.js -->
        </tbody>
    </table>
    
</div>

</div> <!-- fin de la clase w-100-->
</div> <!-- fin de la clase d-flex -->

    <!-- Bootstrap core JavaScript -->
    <script src="../bootstrap-5.2.2-dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="../bootstrap-5.2.2-dist/js/bootstrap.min.js"></script> -->
    <script src="../bootstrap-5.2.2-dist/js/popper.min.js"></script>

    <!-- APP JS CONTIENE  FUNCIONES PARA LOS GRÁFICOS -->
    <script src="../js/app1.js"></script>
    <!-- INSTALACION DE JQUERY -->
    <script src="../js/jquery.min.js"></script> 
    
<!-- Script que hace las consultas SQL -->
<script src="../js/consultar2.js"></script>

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