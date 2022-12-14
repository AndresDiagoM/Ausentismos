<?php
    include "../template/cabecera.php";
    $id_usuario     = $_GET['ID'];
    //if there is no id redirect to admin_edit_func.php
    if(!isset($id_usuario) || empty($id_usuario)){
        header("Location: ./admin_edit_func.php");
    }
?>


<!-- INICIO DE CONTENEDOR DE FUNCIONARIO SELECCIONADO -->
<div class="container card-group py-2">

    <div class="card">
        <div class="card-header">
            DATOS ACTUALES
        </div>
        <div class="card-body">
            
            <?php
                $sqli   = "SELECT * FROM funcionarios 
                            INNER JOIN dependencias ON funcionarios.Dependencia=dependencias.ID 
                            WHERE Cedula = '$id_usuario'";
                $result = $conectar->query($sqli);
                $data=[];
                while($row = mysqli_fetch_assoc($result)){
                    $Id_editar = $row['Cedula'];
                    $data[] = $row;
                }
                $mostrar = $data[0];
                //print_r($mostrar);
            ?>
            <h5 class="card-title">Nombre: <?php echo $mostrar['Nombre'] ?></h5>
            <form>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Cedula</label>
                    <div class="col-sm-10">
                    <input type="text" readonly disabled class="form-control" id="staticEmail" value=<?php echo $mostrar['Cedula'];?>>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Nombre</label>
                    <div class="col-sm-10">
                    <input type="text"  disabled class="form-control" value=<?php echo '"'.$mostrar['Nombre'].'"';?>>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Cargo</label>
                    <div class="col-sm-10">
                    <input type="text" readonly disabled class="form-control" id="staticEmail" value=<?php echo '"'.$mostrar['Cargo'].'"';?>>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Departamento</label>
                    <div class="col-sm-10">
                    <input type="text" readonly disabled class="form-control" id="staticEmail" value=<?php echo '"'.$mostrar['Departamento'].'"';?>>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Facultad</label>
                    <div class="col-sm-10">
                    <input type="text" readonly disabled class="form-control" id="staticEmail" value=<?php echo '"'.$mostrar['Facultad'].'"';?>>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Genero</label>
                    <div class="col-sm-10">
                    <input type="text" readonly disabled class="form-control" id="staticEmail" value=<?php echo $mostrar['Genero'];?>>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Salario</label>
                    <div class="col-sm-10">
                    <input type="text" readonly disabled class="form-control" id="staticEmail" value=<?php echo '"'.$mostrar['Salario'].'"';?>>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Estado</label>
                    <div class="col-sm-10">
                    <input type="text" readonly disabled class="form-control" id="staticEmail" value=<?php echo '"'.$mostrar['Estado'].'"';?>>
                    </div>
                </div>
            </form>
            
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            MODIFICACI??N DE DATOS
        </div>
        <div class="card-body">
            <h5 class="card-title">Nombre: <?php echo $mostrar['Nombre'] ?></h5>

            <form id="form_func_edit" action="" method="POST">

                <input type="hidden" name="cedula_f" id="cedula_f" value="<?php echo $mostrar['Cedula'];?>">
                    

                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Cedula</label>
                    <div class="col-sm-10">
                    <input type="text" name="cedula_func_edt" class="form-control" placeholder="cedula" pattern="[0-9]{3,15}" title="La identifiaci??n solo debe contener car??cteres num??ricos." value="<?php echo $mostrar['Cedula'];?>" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Nombre</label>
                    <div class="col-sm-10">
                        <input type="text" name="nombre_func_edt" class="form-control" min="4" max="40" placeholder="nombre" value="<?php echo $mostrar['Nombre'];?>" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Cargo</label>
                    <div class="col-sm-10">
                        <input type="text" name="cargo_func_edt" class="form-control"  placeholder="cargo" value="<?php echo $mostrar['Cargo'];?>" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Dependencia</label>
                    <div class="col-sm-10">
                        <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="dependencia_ausen_edt" required>
                            <option value="">Seleccione</option>
                            <?php 
                                //Consultar dependencias de la base de datos, donde la facultad y departamento sean unicos
                                //$sql = "SELECT DISTINCT facultad, departamento FROM dependencias";
                                $sql = "SELECT * FROM dependencias ORDER BY Departamento";
                                $result = $conectar->query($sql);
                                //echo 'ERROR'.$conectar->error;
                                //print_r($result); exit;
                                if($result->num_rows > 0){
                                    while($row = $result->fetch_assoc()){

                                        if ($row['ID'] == $mostrar['Dependencia']) {
                                            echo '<option value="'.$row['ID'].'" selected>'.$row['Facultad'].' - '.$row['Departamento'].'</option>';
                                        }else{
                                            echo '<option value="'.$row['ID'].'">'.$row['Facultad'].' - '.$row['Departamento'].'</option>';
                                        }

                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Genero</label>
                    <div class="col-sm-10">
                        <select class="custom-select" name="genero_func_edt" required>
                                <option value="">Seleccione</option>
                                <option value="MAS" <?php if($mostrar['Genero'] == 'MAS'){echo 'selected';}?> > Masculino </option>
                                <option value="FEM" <?php if($mostrar['Genero'] == 'FEM'){echo 'selected';}?> > Femenino </option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Salario</label>
                    <div class="col-sm-10">
                    <input type="text" name="salario_func_edt" class="form-control" min="1" max="100000000" pattern="[0-9]{1,9}" title="Solo n??meros" placeholder="salario" value="<?php echo $mostrar['Salario'];?>" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Estado</label>
                    <div class="col-sm-10">
                        <select class="custom-select" name="estado_func_edt" required>
                                <option value="">Seleccione</option>
                                <option value="ACTIVO" <?php if($mostrar['Estado'] == 'ACTIVO'){echo 'selected';}?> > ACTIVO </option>
                                <option value="INACTIVO" <?php if($mostrar['Estado'] == 'INACTIVO'){echo 'selected';}?> > INACTIVO </option>
                        </select>
                    </div>
                </div>

                <!-- Boton de enviar formulario para modificar funcionario -->
                <button type="submit" class="btn btn-success">Modificar</button> 
            </form>

        </div>
        
    </div>

</div>


</div> <!-- fin de la clase w-100-->
</div> <!-- fin de la clase d-flex -->

    <!-- Bootstrap core JavaScript -->
    <script src="../bootstrap-5.2.2-dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="../bootstrap-5.2.2-dist/js/bootstrap.min.js"></script> -->
    <script src="../bootstrap-5.2.2-dist/js/popper.min.js"></script>

    <!-- APP JS CONTIENE  FUNCIONES PARA LOS GR??FICOS 
    <script src="../js/app1.js"></script> -->

    <!-- INSTALACION DE JQUERY -->
    <script src="../js/jquery.min.js"></script> 
    
    <!-- INSTALACION DE SWEETALERT2 -->
    <script src="../js/sweetalert2-11.6.15/package/dist/sweetalert2.min.js"></script>

<script>
    //mandar formulario mediante peticion ajax a ../logic/form_func_editLogic.php, cuando se presione el boton Modificar
    $(document).ready(function(){
        $('#form_func_edit').submit(function(e){
            e.preventDefault();
            var datos = $(this).serialize();
            //console.log(datos);


            $.ajax({
                type: "POST",
                url: "../logic/form_func_editLogic.php",
                data: datos,
                success: function(response)
                {
                    //json decode the response
                    var resp = $.parseJSON(response);
                    console.log(resp);

                    if(resp == 'success'){
                        Swal.fire({
                            icon: 'success',
                            title: 'Funcionario modificado con ??xito',
                            showConfirmButton: true,
                            //timer: 1500
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "./admin_edit_func.php";
                            }
                        })
                    }else if(resp == 'error1'){
                        Swal.fire({
                            icon: 'error',
                            title: 'No existe la dependencia seleccionada',
                            showConfirmButton: true,
                            //timer: 1500
                        })
                    }else if(resp == 'error2'){
                        Swal.fire({
                            icon: 'error',
                            title: 'Complete todos los campos!',
                            showConfirmButton: true,
                            //timer: 1500
                        })
                    }
                    else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Error al modificar funcionario',
                            showConfirmButton: true,
                            //timer: 1500
                        })
                    }
                }
            });
        });
    });
</script> 


<?php
    include("../template/pie.php");
?>