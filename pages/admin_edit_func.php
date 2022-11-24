<?php
include "../template/cabecera.php";
?>

        <!-- CONTENEDORES DE BUSQUEDAS -->
        <div class="container row col-3 py-3">
            <form class="row" id="auto_llenar">
                <div class="form-floating mb-3">
                        <input class="form-control" type="text" name="caja_busqueda" id="caja_busqueda" size="50" placeholder="Ingrese el ID que desea buscar">
                        <label class="col-form-label" for="caja_busqueda">Buscar: </label>
                </div>
            </form>
        </div>

        <div class="container py-4" style="overflow-y: auto; height:75vh;" id="datos">

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
        
        $(document).on('keyup', '#caja_busqueda', function(){

            var valor = $(this).val();
        
            if(valor != ""){
                busqueda(valor);
        
            }else{
                busqueda();
            }
        });
    });

    function busqueda(consulta){

        $.ajax({
            url:        '../logic/searchFuncLogic.php',
            type:       'POST',
            dataType:   'html',
            data:       {consulta: consulta},

        })
        .done(function(respuesta){
            $("#datos").html(respuesta);
        })
        .fail(function(){
            console.log("Fail");
        })

    }
</script>


</body>
</html>