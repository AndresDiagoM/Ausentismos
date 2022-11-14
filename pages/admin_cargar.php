<?php

include "../template/cabecera.php";


$tabla1 ="";
$tabla2 ="";
$tabla3 ="";
$tabla4 ="";
//Cuando se presiona el boton de cargar
if(isset($_POST['accion']) and isset($_FILES['excelFile'])){
    //echo 'BOTON: '.$_POST['accion'];
    //echo ($_FILES['excelFile']['name']!="");
    include "../logic/cargarFuncionarios.php";

    //mostrar una tabla si los arreglos no están vacios
    $tabla1 ="";
    $tabla2 ="";
    $tabla3 ="";
    $tabla4 ="";
    if($funcionariosExistentes!=null){
        $tabla1 .= "<table class='table table-striped table-bordered table-hover table-condensed'>
                    <thead class='thead-light'>
                        <tr>
                            <th scope='col'  colspan='3' class='table-active'>Funcionarios que ya existen</th>
                        </tr>
                        <tr>
                            <th scope='col'>Cedula</th>
                            <th scope='col'>Nombre</th>
                            <th scope='col'>Cargo</th>
                        </tr>
                    </thead>
                    <tbody>";
        foreach($funcionariosExistentes as $funcionario){
            $tabla1 .= "<tr>
                            <th scope='row'>".$funcionario['CEDULA']."</th>
                            <td>".$funcionario['NOMBRE']."</td>
                            <td>".$funcionario['NOMBRE_DEL_CARGO']."</td>
                        </tr>";
        }
        $tabla1 .= "</tbody>
                </table>";
    }
    if($funcionariosInsertados!=null){
        $tabla2 .= "<table class='table table-striped table-bordered table-hover table-condensed'>
                    <thead class='thead-light'>
                        <tr>
                            <th scope='col' class='table-active' colspan='3'>Funcionarios que se insertaron</th>
                        </tr>
                        <tr>
                            <th scope='col'>Cedula</th>
                            <th scope='col'>Nombre</th>
                            <th scope='col'>Cargo</th>
                        </tr>
                    </thead>
                    <tbody>";
        foreach($funcionariosInsertados as $funcionario){
            $tabla2 .= "<tr>
                            <th scope='row'>".$funcionario['CEDULA']."</th>
                            <td>".$funcionario['NOMBRE']."</td>
                            <td>".$funcionario['NOMBRE_DEL_CARGO']."</td>
                        </tr>";
        }
        $tabla2 .= "</tbody>
                </table>";
    }
    if($funcionariosNoInsertados!=null){
        $tabla3 .= "<table class='table table-striped table-bordered table-hover table-condensed'>
                    <thead class='thead-light'>
                        <tr>
                            <th scope='col' class='table-active' colspan='3'>Funcionarios que no se insertaron</th>
                        </tr>
                        <tr>
                            <th scope='col'>Cedula</th>
                            <th scope='col'>Nombre</th>
                            <th scope='col'>Cargo</th>
                        </tr>
                    </thead>
                    <tbody>";
        foreach($funcionariosNoInsertados as $funcionario){
            $tabla3 .= "<tr>
                            <th scope='row'>".$funcionario['CEDULA']."</th>
                            <td>".$funcionario['NOMBRE']."</td>
                            <td>".$funcionario['NOMBRE_DEL_CARGO']."</td>
                        </tr>";
        }
        $tabla3 .= "</tbody>
                </table>";
    }
    if($funcionariosActualizados!=null){
        $tabla4 .= "<table class='table table-striped table-bordered table-hover table-condensed'>
                    <thead class='thead-light'>
                        <tr>
                            <th scope='col' class='table-active' colspan='3'>Funcionarios Actualizados</th>
                        </tr>
                        <tr>
                            <th scope='col'>Cedula</th>
                            <th scope='col'>Nombre</th>
                            <th scope='col'>Salario</th>
                            <th scope='col'>Estado</th>
                        </tr>
                    </thead>
                    <tbody>";
        foreach($funcionariosActualizados as $funcionario){
            $tabla4 .= "<tr>
                            <th scope='row'>".$funcionario['CEDULA']."</th>
                            <td>".$funcionario['NOMBRE']."</td>
                            <td>".$funcionario['NOMBRE_DEL_CARGO']."</td>
                            <td>".$funcionario['SALARIO']."</td>
                            <td>".$funcionario['ESTADO']."</td>
                        </tr>";
        }
        $tabla4 .= "</tbody>
                </table>";
    }
}
?>


    <!-- Contenerdor del contenido de la página-->
    <div class="content" >
        <!-- Contenerdor de cards-->
        <section class="bg-gray">

            <div class="container">
                <div class="row">
                    
                    <div class="py-1">
                        
                        <!-- CARD DE CARGAR FUNCIONARIOS -->    
                        <div class="card rounded-0 mx-auto" style="width: 40vw;">
                            <div class="d-flex card-header bg-light ">
                                <h6 class="font-weight-bold mb-0 mr-3">Cargar Funcionarios </h6>                                
                            </div>
                            
                            <div class="card-body">
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <input type="file" class="form-control mb-3" name="excelFile" required id="excelFile" placeholder="Imagen">
                                    <!--- input type file that just allows excel files -->

                                    <div class="btn-group" role="group" aria-label="">
                                        <button type="submit" name="accion"  value="CARGAR" class="btn btn-success">CARGAR</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>

        </section>
    
        <?php
        if($tabla1 != null){          
        ?>
        <section>
            <!-- Contenedor de tabla -->
            <div class="container " style="overflow-y:scroll; height:32vw; position:relative">
                <?php 
                    if($tabla4 != null){
                        echo $tabla4;
                    }
                    if($tabla2 != null){
                        echo $tabla2;
                    }
                    if($tabla3 != null){
                        echo $tabla3;
                    }
                    if($tabla1 != null){
                        echo $tabla1;
                    }
                ?>
            </div>
        </section>
        <?php
        }
        ?>
    </div>

    </div> <!-- fin de la clase w-100-->
    </div> <!-- fin de la clase d-flex -->

    <!-- SCRIPT DE PARTICULAS -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script> -->
    <script src="../js/particles.min.js"></script>
    <script src="../js/app.js"></script>

    <!-- CDN: Libreria de chart.js para las gráficas -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js" integrity="sha256-+8RZJua0aEWg+QVVKg4LEzEEm/8RFez5Tb4JBNiV5xA=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- INSTALACION DE JQUERY -->
    <script src="../js/jquery.min.js"></script> 

    <!-- LOCAL: JQuery, AJAX, Bootstrap 
    <script src="../bootstrap-4.4.1-dist/js/jquery-3.6.1.min.js"></script> -->     
    <script src="../bootstrap-4.4.1-dist/js/bootstrap.min.js"></script>

</body>
</html>