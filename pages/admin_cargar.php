<?php

include "../conexion.php"; //conexión a la base de datos
include "../template/cabecera.php";



$tablaAux ="";
//Cuando se presiona el boton de cargar, se llama al archivo cargarFuncionarios.php
if(isset($_POST['accion']) and isset($_FILES['excelFile'])){
    //echo 'BOTON: '.$_POST['accion'];
    //echo ($_FILES['excelFile']['name']!="");
    include "../logic/cargarFuncionarios.php";
    
}elseif(isset($_POST['aceptar']) and $_POST['aceptar']=="ACEPTAR"){
    include "../logic/cargarFuncionarios.php";
}

//query for the func_auxiliar table, then show it in a table
$query = "SELECT * FROM func_auxiliar ORDER BY Error ASC"; //WHERE Error != 'N/A' ORDER BY Error ASC
$result = $conectar->query($query);
$num_rows = mysqli_num_rows($result);
$tabla_auxiliar = array();
while($row = mysqli_fetch_array($result)){
    $tabla_auxiliar[] = $row;
}

if($tabla_auxiliar!=null){
    $tablaAux .= "<table class='table table-striped table-bordered table-hover table-condensed'>
                <thead class='thead-light'>
                    <tr>
                        <th scope='col' class='header-table table-active' colspan='8'>Funcionarios a cargar y actualizar: ".$num_rows."</th>
                    </tr>
                    <tr class='header-table'>
                        <th scope='col'>Cedula</th>
                        <th scope='col'>Nombre</th>
                        <th scope='col'>Cargo</th>
                        <th scope='col'>Genero</th>
                        <th scope='col'>Salario</th>
                        <th scope='col'>Estado</th>
                        <th scope='col'>Error</th>
                        <th scope='col'>Editar</th>
                    </tr>
                </thead>
                <tbody>";

    foreach($tabla_auxiliar as $funcionario){
        $Id_fila=$funcionario['Cedula'];
        if($funcionario['Error'] != 'N/A'){
            
            $tablaAux .= "<tr>
                            <th scope='row'>".$funcionario['Cedula']."</th>
                            <td>".$funcionario['Nombre']."</td>
                            <td>".$funcionario['Cargo']."</td>
                            <td>".$funcionario['Genero']."</td>
                            <td>".$funcionario['Salario']."</td>
                            <td>".$funcionario['Estado']."</td>
                            <td>".$funcionario['Error']."</td>
                            <td><a href='../pages/admin_aux_table_edition.php?ID=$Id_fila' class='btn-edit'><img src='../images/edit2.png' class='img-edit'  style='width: 2rem;'></a></td>
                        </tr>";
        }
    }
    $tablaAux .= "</tbody>
            </table>";
}
?>


    <!-- Contenerdor del contenido de la página-->
    <div class="content" >
        <!-- Contenerdor de cards-->
        <section class="bg-gray">

            <div class="container ">
                <div class="row">
                    
                    <div class=" card-group py-1">
                        
                        <!-- CARD DE CARGAR FUNCIONARIOS -->    
                        <div class="card rounded-0 mx-auto" style="width: 30vw;">
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

                        <!-- CARD DE OPCIONES -->
                        <div class="card rounded-0 mx-auto" style="width: 30vw;">
                            <div class="d-flex card-header bg-light ">
                                <h6 class="font-weight-bold mb-0 mr-3"> Opciones Funcionarios: </h6>                                
                            </div>
                            
                            <div class="card-body">
                                <a href="./admin_create_func.php" class="btn btn-success">Agregar</a>
                                <a href="./admin_edit_func.php" class="btn btn-success">Editar</a>
                                <!-- <a href="./admin_delete_func.php" class="btn btn-success">Eliminar</a> -->
                            </div>

                        </div>
                        
                    </div>
                </div>
            </div>

        </section>
    
        <?php
        if($tablaAux!=null){          
        ?>
        <section>
            <!-- Contenedor de tabla -->
            <div class="container " style="overflow-y:scroll; height:30vw; position:relative">
                <?php 
                    if($tablaAux != null){
                        echo $tablaAux;
                    }
                ?>
            </div>
        </section>
        <?php
            echo "<section class='py-3'>
                    <div class='container'>
                        <div class='col-lg-4 d-flex'>
                            <form action='' method='POST' enctype='multipart/form-data'>
                                <button type='submit' name='aceptar'  value='ACEPTAR' class='btn btn-success'>ACEPTAR</button>
                            </form>
                        </div>
                    </div>
                    </section>";
        }
        ?>
    </div>

    </div> <!-- fin de la clase w-100-->
    </div> <!-- fin de la clase d-flex -->

    <!-- SCRIPT DE PARTICULAS -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script> -->
    <!-- <script src="../js/particles.min.js"></script> -->
    <script src="../js/app1.js"></script>

    <!-- INSTALACION DE JQUERY -->
    <script src="../js/jquery.min.js"></script> 

    <!-- LOCAL: JQuery, AJAX, Bootstrap -->
    <script src="../bootstrap-5.2.2-dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="../bootstrap-5.2.2-dist/js/bootstrap.min.js"></script> -->
    <script src="../bootstrap-5.2.2-dist/js/popper.min.js"></script>
    <script src="../js/sweetalert2-11.6.15/package/dist/sweetalert2.min.js"></script>

<?php
//si se recibe la variable por GET ALERT, entonces se muestra el mensaje de alerta
if (isset($_GET["ALERT"])) {
    $alert = $_GET["ALERT"];
    if ($_GET["ALERT"] != "") {
        if ($alert == "success") {
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: '¡Funcionarios cargados y actualizados!',
                    showConfirmButton: true,
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: \"#be3838\",
                    //timer: 2500
                });
            </script>";
        } elseif ($alert == "errorExcel") {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: '¡No es un archivo de excel!',
                    showConfirmButton: true,
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: \"#be3838\",
                    //timer: 1500
                });
            </script>";
        }
    }
}
?>

<?php
    include("../template/pie.php");
?>