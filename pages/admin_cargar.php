<?php

include "../logic/admin_securityLogic.php"; // Verifica que el usuario sea administrador
include "../template/cabecera.php";


    //CONSULTAR SI HAY DATOS EN LA TABLA DE CARGAR AUXILIAR
    $query = "SELECT * FROM func_auxiliar ORDER BY Error ASC"; //WHERE Error != 'N/A' ORDER BY Error ASC
    $resultado = $conectar->query($query);
    $num_rows = mysqli_num_rows($resultado);

    //PASAR LOS DATOS A UN ARREGLO PARA MOSTRARLOS EN LA TABLA
    $tabla_auxiliar = array();
    while($row = mysqli_fetch_array($resultado)){
        $tabla_auxiliar[] = $row;
    }
    $tablaAux ="";
    if($tabla_auxiliar!=null){
        $tablaAux .= "<table class='table table-striped table-bordered table-hover table-condensed'>
                    <thead class='thead-light'>
                        <tr>
                            <th scope='col' class='header-table table-active' colspan='9'>Funcionarios a cargar y actualizar: ".$num_rows."</th>
                        </tr>
                        <tr class='header-table'>
                            <th scope='col'>Cedula</th>
                            <th scope='col'>Nombre</th>
                            <th scope='col'>Cargo</th>
                            <th scope='col'>Correo</th>
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

                //Pasar los errores a un array 
                $errores = explode(",", $funcionario['Error']);

                //Pasar los errores a un string que sea entendible por el usuario
                $erroresString = "";
                foreach($errores as $error){
                    if($error == "Cedula"){
                        $erroresString .= "Cedula: Formato incorrecto, ";
                    }
                    if($error == "Nombre"){
                        $erroresString .= "Nombre: Formato incorrecto, ";
                    }
                    if($error == "Cargo"){
                        $erroresString .= "Cargo: Formato incorrecto, ";
                    }
                    if($error == "Salario"){
                        $erroresString .= "Salario: Formato incorrecto, ";
                    }
                    if($error == "Estado"){
                        $erroresString .= "Estado ACTIVO o INACTIVO, ";
                    }
                    if($error == "Genero"){
                        $erroresString .= "Genero MAS o FEM, ";
                    }
                    if($error == "Correo"){
                        $erroresString .= "Correo no valido, ";
                    }
                    if($error == "Dependencia"){
                        $erroresString .= "Dependencia inválida, ";
                    }
                }

                
                $tablaAux .= "<tr>
                                <th scope='row'>".$funcionario['Cedula']."</th>
                                <td>".$funcionario['Nombre']."</td>
                                <td>".$funcionario['Cargo']."</td>
                                <td>".$funcionario['Correo']."</td>
                                <td>".$funcionario['Genero']."</td>
                                <td>".$funcionario['Salario']."</td>
                                <td>".$funcionario['Estado']."</td>
                                <td>".$erroresString."</td>
                                <td><a href='../pages/admin_aux_table_edition.php?ID=$Id_fila' class='btn-edit'><img src='../assets/images/edit2.png' class='img-edit'  style='width: 2rem;'></a></td>
                            </tr>";
            }
        }
        $tablaAux .= "</tbody>
                </table>";
    }

    $buttonAcept =  "<section class='py-3'>
                    <div class='container'>
                        <div class='col-lg-4 d-flex'>
                            <!-- <form action='' method='POST' enctype='multipart/form-data'> -->
                                <button type='button' name='aceptar' onclick = 'Aceptar()'  value='ACEPTAR' class='btn btn-success'>ACEPTAR CAMBIOS</button>
                            <!-- </form> -->
                        </div>
                    </div>
                    </section>";

    //CONSULTAR SI NO HAY FUNCIONARIOS CON ERRORES EN EL CAMPO Error es decir, Error != 'N/A'
    $query = "SELECT * FROM func_auxiliar WHERE Error != 'N/A'"; //WHERE Error != 'N/A' ORDER BY Error ASC
    $resultado = $conectar->query($query);
    $funcionariosConError = mysqli_num_rows($resultado);

?>

    <!-- CONTENEDOR DE FORMULARIO DE CARGA DE DATOS-->
    <div class="content">
        <div class="row py-3">   
                
            <!-- CARD DE CARGAR FUNCIONARIOS -->    
            <div class="card mx-auto" style="width: 40%; overflow-y: auto; height:auto;">
                <div class="d-flex card-header bg-light ">
                    <h6 class="font-weight-bold mb-0 mr-3"> Cargar Funcionarios </h6>                                
                </div>
                
                <div class="card-body">
                    <form name="formulario" action="" method="POST" enctype="multipart/form-data">
                        <input type="file" class="form-control mb-3" name="excelFile" required id="excelFile" placeholder="archivo">
                        <!--- input type file that just allows excel files -->

                        <div class="btn-group" role="group" aria-label="">
                            <button type="submit" name="accion"  value="CARGAR" class="btn btn-success">CARGAR</button>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    </div>

    <!-- CONTENEDOR DE LA TABLA DE CARGA AUXILIAR-->
    <div class="content" id="cargar-content">
        <!-- Contenerdor de cards-->
        <section class="bg-gray">

        </section>
        <?php
            if($tablaAux != ""){
                echo "<section>
                        <!-- Contenedor de tabla -->
                        <div class='container' id='table_func_aux' style='overflow-y:scroll; height:28vw; position:relative'>";
                            
                
                echo $tablaAux;
                echo "      </div>
                    </section>";

                //SI NO HAY ERRORES EN NINGUUN FUNCIONARIO DEL ARREGLO SE MUESTRA EL BOTON DE ACEPTAR. 
                if($funcionariosConError == 0){
                    echo $buttonAcept;
                }
                
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
    <script src="../assets/bootstrap-5.2.2-dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="../bootstrap-5.2.2-dist/js/bootstrap.min.js"></script> -->
    <script src="../assets/bootstrap-5.2.2-dist/js/popper.min.js"></script>
    <script src="../js/sweetalert2-11.6.15/package/dist/sweetalert2.min.js"></script>
    <script src="../js/sweet_alert.js"></script>

    <script src="../js/cargar.js"></script>


<?php
    include("../template/pie.php");
?>