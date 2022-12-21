<?php

include "../conexion.php"; //conexión a la base de datos
include "../template/cabecera.php";


    //query for the func_auxiliar table, then show it in a table
    $query = "SELECT * FROM func_auxiliar ORDER BY Error ASC"; //WHERE Error != 'N/A' ORDER BY Error ASC
    $result = $conectar->query($query);
    $num_rows = mysqli_num_rows($result);
    $tabla_auxiliar = array();
    while($row = mysqli_fetch_array($result)){
        $tabla_auxiliar[] = $row;
    }
    $tablaAux ="";
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

    $buttonAcept =  "<section class='py-3'>
                    <div class='container'>
                        <div class='col-lg-4 d-flex'>
                            <!-- <form action='' method='POST' enctype='multipart/form-data'> -->
                                <button type='button' name='aceptar' onclick = 'Aceptar()'  value='ACEPTAR' class='btn btn-success'>ACEPTAR</button>
                            <!-- </form> -->
                        </div>
                    </div>
                    </section>";

?>


    <!-- Contenerdor del contenido de la página-->
    <div class="content" id="cargar-content">
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
                                <form name="formulario" action="" method="POST" enctype="multipart/form-data">
                                    <input type="file" class="form-control mb-3" name="excelFile" required id="excelFile" placeholder="archivo">
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
            if($tablaAux != ""){
                echo "<section>
                        <!-- Contenedor de tabla -->
                        <div class='container' id='table_func_aux' style='overflow-y:scroll; height:30vw; position:relative'>";
                            
                
                echo $tablaAux;
                echo "      </div>
                    </section>";
                echo $buttonAcept;
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

<script>
    //script para que solo se puedan subir archivos de excel .xlsx y .xls
    $(document).ready(function(){
        $("#excelFile").change(function(){
            var file = this.files[0];
            var fileType = file.type;
            var match = ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
            if(!(fileType == match[0] || fileType == match[1])){
                //use sweetalert2
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Por favor seleccione un archivo de excel válido.',
                    showConfirmButton: true,
                    //timer: 2500
                    allowOutsideClick: false
                });
                $("#excelFile").val('');
                return false;
            }
        });
    });

    //when document is ready, call a function to send the file to the server, when the form is submitted
    $(document).ready(function(){
        //alert("Hola");
        //$("#formulario").submit(function(e){
        $("form[name=formulario]").submit(function(e){
            e.preventDefault();

            //get the file from the form
            var file = $("#excelFile")[0].files[0];

            //send the file to the server with ajax 
            var formData = new FormData();
            formData.append("excelFile", file);

            //ajax call
            $.ajax({
                url: "../logic/cargarFuncionarios.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response){
                    //alert(response);

                    //convert the response from json to an object
                    var obj = JSON.parse(response);
                    //console.log(obj);
                    //console.log(obj.alert);
                    

                    //if obj has the property alert, then show the alert
                    if(obj.alert=="success_aux"){
                        //use sweetalert2, reload the page when the alert dissapears
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Archivo cargado correctamente.',
                            showConfirmButton: true,
                            //timer: 2500
                            allowOutsideClick: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });

                        //reload the page, 
                        //location.reload();

                        //add to the div id="table_func_aux" the table with the data
                        //$("#table_func_aux").html(obj.table);

                        //add to the div id=cargar_conte the section obj.button
                        //$("#cargar_conte").html(obj.button);

                    }else if(obj == "error1"){
                        //use sweetalert2
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'El archivo no es de excel.',
                            showConfirmButton: true,
                            //timer: 1500
                        });
                    }
                    else{
                        //use sweetalert2
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'Error al cargar el archivo.',
                            showConfirmButton: true,
                            //timer: 1500
                        });
                    }
                }
            });
            
        });
    });

    //funcion Aceptar() para el boton aceptar, que envia una peticion ajax al servidor
    function Aceptar(){
        //alert("Hola");
        $.ajax({
            url: "../logic/cargarFuncionarios.php",
            type: "POST",
            data: {aceptar: "aceptar"},
            success: function(response){
                //alert(response);

                //convert the response from json to an object
                var obj = JSON.parse(response);
                console.log(obj);
                //console.log(obj.alert);

                if(obj == "success1"){
                    //use sweetalert2 , reload the page when the alert is closed
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Funcionarios actualizados correctamente!',
                        showConfirmButton: true,
                        //timer: 1500
                        allowOutsideClick: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });

                    //clean the form
                    $("form[name=formulario]").trigger("reset");

                    //reload the page
                    //location.reload();
                
                }
            }
        });
    }

</script>


<?php
    include("../template/pie.php");
?>