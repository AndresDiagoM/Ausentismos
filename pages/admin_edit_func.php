<?php
include "../template/cabecera.php";
?>

        <!-- CONTENEDORES DE BUSQUEDAS -->
        <div class="container row col-3 py-2">
            <form class="row" id="auto_llenar">
                <div class="form-floating mb-3">
                        <input class="form-control" type="text" name="caja_busqueda" id="caja_busqueda" size="50" placeholder="Ingrese el ID que desea buscar">
                        <label class="col-form-label" for="caja_busqueda">Buscar: </label>
                </div>
            </form>
        </div>

        <!-- Contenedor de la tabla de funcionarios -->
        <div class="container py-4" style="overflow-y: auto; height:65vh;" id="datos">

        </div>

        <!-- Contener de paginador y boton de reporte -->
        <div class="container offset-md-0 col-md-7">
            <section>
                <!-- Contenedor de los botones del paginador de las consultas -->
                <div class="offset-md-8 col-md-6 text-center py-2">
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
    <script src="../bootstrap-5.2.2-dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="../bootstrap-5.2.2-dist/js/bootstrap.min.js"></script> -->
    <script src="../bootstrap-5.2.2-dist/js/popper.min.js"></script>

    <!-- APP JS CONTIENE  FUNCIONES PARA LOS GRÁFICOS -->
    <script src="../js/app1.js"></script>
    <!-- INSTALACION DE JQUERY -->
    <script src="../js/jquery.min.js"></script> 

<!--    JAVASCRIPT QUE REALIZA LA BUSQUEDA DINAMICA -->
<script>
    $(function()
    {
        busqueda()
        
        $(document).on('keyup', '#caja_busqueda', function(){ //añadir el evento keyup a la caja de busqueda de cedula

            var valor = $(this).val();
        
            if(valor != ""){
                busqueda(valor, "cedula");
        
            }else{
                busqueda();
            }
        });

        $(document).on('click', '#myPager input', function() //añadir el evento click a los botones del paginador
        {
            var valor = $(this).val();
            busqueda(valor, "pagina");
        });
    });

    function busqueda(consulta, param){
        let enviar = Array();
        //let form2=enviar.serializeArray();
        //enviar.push({name: "Pagina", value: pagina});

        //si param es "cedula", entonces se realiza una busqueda por cedula. Si es "pagina", se realiza una busqueda por pagina
        if(param=="cedula"){
            enviar.push({name: "Cedula", value: consulta});
        }else if(param=="pagina"){
            enviar.push({name: "Pagina", value: consulta});
        }
        //console.log(enviar);

        $("#myPager").html(""); //se limpia el paginador
        $("#total_resultados").html("");

        //se realiza la busqueda por ajax
        $.ajax({
            url:        '../logic/searchFuncLogic.php',
            type:       'POST',
            dataType:   'html',
            data:       enviar, //{consulta:consulta},

        })
        .done(function(respuesta){
            const obj = JSON.parse(respuesta);
            //console.log(obj.tabla);
            $("#datos").html(obj.tabla); //se muestra la tabla con los datos de la busqueda
            $("#myPager").append(obj.slider); //se muestra el paginador
            $("#total_resultados").append(obj.total);

        })
        .fail(function(){
            console.log("Fail");

        })

    }
</script>


<?php
    include("../template/pie.php");
?>