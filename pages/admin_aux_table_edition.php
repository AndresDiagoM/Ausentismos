<?php
    include "../logic/admin_securityLogic.php"; // Verifica que el usuario sea administrador
    include "../template/cabecera.php";
    $id_func     = $_GET['ID'];
?>


<!-- INICIO DE CONTENEDOR DE FUNCIONARIO SELECCIONADO -->
<div class="container card-group py-2" style="width:auto; overflow-y: auto; height:90vh;">

    <div class="card" >
        <div class="card-header">
            DATOS ACTUALES
        </div>
        <div class="card-body">
            
            <?php
                $sqli   = "SELECT * FROM func_auxiliar 
                            LEFT JOIN dependencias ON dependencias.ID = func_auxiliar.Dependencia WHERE Cedula = '$id_func'";
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
                <!-- LABEL DE Cedula -->
                <div class="form-floating mb-2">
                    <input type="text" readonly disabled  class="form-control" value="<?php echo $mostrar['Cedula'];?>">
                    <label class="col-form-label" for="Cedula"> Cedula </label>
                </div>

                <!-- LABEL DE NOMBRE -->
                <div class="form-floating mb-2">
                    <input type="text" readonly disabled  class="form-control" value="<?php echo $mostrar['Nombre'];?>">
                    <label class="col-form-label" for="Nombre"> Nombre </label>
                </div>

                <!-- LABEL DE Cargo -->
                <div class="form-floating mb-2">
                    <input type="text" readonly disabled  class="form-control" value="<?php echo $mostrar['Cargo'];?>">
                    <label class="col-form-label" for="Cargo"> Cargo </label>
                </div>

                <!-- INPUT DEL Correo -->
                <div class="form-floating mb-2">
                    <input type="text" readonly disabled  class="form-control" value="<?php echo $mostrar['Correo'];?>">
                    <label class="col-form-label" for="Correo"> Correo </label>
                </div>

                <!-- INPUT DE LA DEPENDENCIA -->
                <div class="form-floating mb-3">
                    <select readonly disabled  class="form-select" >
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
                    <label class="col-form-label" for="dependencia"> Dependencia </label>
                </div>

                <!-- INPUT DEL Genero -->
                <div class="form-floating mb-2">
                    <input type="text" readonly disabled  class="form-control" value="<?php echo $mostrar['Genero'];?>">
                    <label class="col-form-label" for="Genero"> Genero </label>
                </div>

                <!-- INPUT DEL Salario -->
                <div class="form-floating mb-2">
                    <input type="text" readonly disabled  class="form-control" value="<?php echo $mostrar['Salario'];?>">
                    <label class="col-form-label" for="Salario"> Salario </label>
                </div>

                <!-- INPUT DEL Estado -->
                <div class="form-floating mb-2">
                    <input type="text" readonly disabled  class="form-control" value="<?php echo $mostrar['Estado'];?>">
                    <label class="col-form-label" for="Estado"> Estado </label>
                </div>
            </form>
            
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            MODIFICACIÓN DE DATOS
        </div>
        <div class="card-body">
            <h5 class="card-title">Nombre: <?php echo $mostrar['Nombre'] ?></h5>

            <form action="" id="form_func_aux_edit"  method="POST">

                <input type="hidden" name="cedula_f" value="<?php echo $Id_editar;?>" >

                <!-- INPUT DE LA CEDULA -->
                <div class="form-floating mb-2">
                    <input type="text" name="cedula_func_edt" class="form-control" pattern="[0-9]{3,15}" title="La identifiación solo debe contener carácteres numéricos." value="<?php echo $mostrar['Cedula'];?>" placeholder="Digite su cedula"  required>
                    <label class="col-form-label" for="cedula_func_edt"> Cedula </label>
                </div>

                <!-- INPUT DEL NOMBRE -->
                <div class="form-floating mb-2">
                    <input type="text" name="nombre_func_edt" class="form-control" placeholder="nombre"  value="<?php echo $mostrar['Nombre'];?>"  required>
                    <label class="col-form-label" for="nombre_func_edt"> Nombre </label>
                </div>

                <!-- INPUT DEL CARGO -->
                <div class="form-floating mb-2">
                    <input type="text" name="cargo_func_edt" class="form-control" placeholder="Cargo"  value="<?php echo $mostrar['Cargo'];?>"  required>
                    <label class="col-form-label" for="cargo_func_edt"> Cargo </label>
                </div>

                <!-- INPUT DEL Correo -->
                <div class="form-floating mb-2">
                    <input type="text" name="correo_func_edt" class="form-control" placeholder="Correo"  value="<?php echo $mostrar['Correo'];?>"  required>
                    <label class="col-form-label" for="correo_func_edt"> Correo </label>
                </div>

                <!-- INPUT DE LA DEPENDENCIA -->
                <div class="form-floating mb-3">
                    <select class="form-select" name="dependencia_func_edt" id="dependencia" required>
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
                    <label class="col-form-label" for="dependencia"> Dependencia </label>
                </div>

                <!-- INPUT DEL GENERO -->
                <div class="form-floating mb-2">
                    <select class="form-select" name="genero_func_edt" required>
                            <option value="">Seleccione</option>
                            <option value="MAS" <?php if($mostrar['Genero'] == 'MAS'){echo 'selected';}?> >Masculino</option>
                            <option value="FEM" <?php if($mostrar['Genero'] == 'FEM'){echo 'selected';}?> >Femenino</option>
                    </select>
                    <label for="genero_func_edt" class="col-form-label">Genero</label>
                </div>

                <!-- INPUT DEL Salario -->
                <div class="form-floating mb-2">
                    <input type="number" name="salario_func_edt" class="form-control" placeholder="Salario" min="1" max="100000000" value="<?php echo $mostrar['Salario'];?>"  required>
                    <label class="col-form-label" for="salario_func_edt"> Salario </label>
                </div>

                <!-- INPUT DEL ESTADO -->
                <div class="form-floating mb-2">
                    <select class="form-select" name="estado_func_edt" required>
                            <option value="">Seleccione</option>
                            <option value="ACTIVO" <?php if($mostrar['Estado'] == 'ACTIVO'){echo 'selected';}?> >ACTIVO</option>
                            <option value="INACTIVO" <?php if($mostrar['Estado'] == 'INACTIVO'){echo 'selected';}?> >INACTIVO</option>
                    </select>
                    <label for="estado_func_edt" class="col-form-label">Estado</label>
                </div>


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

    <!-- APP JS CONTIENE  FUNCIONES PARA LOS GRÁFICOS 
    <script src="../js/app1.js"></script> -->

    <!-- INSTALACION DE JQUERY -->
    <script src="../js/jquery.min.js"></script> 
    <script src="../js/sweetalert2-11.6.15/package/dist/sweetalert2.min.js"></script>
    <script src="../js/sweet_alert.js"></script>

<script>
    //funcion para enviar formulario por ajax a ../logic/form_func_aux_editLogic.php 
    $(document).ready(function(){
        $('#form_func_aux_edit').submit(function(e){
            e.preventDefault();

            //get data and sertilize from form
            var data = $(this).serialize();
            console.log(data);

            $.ajax({
                type: "POST",
                url: "../logic/form_func_aux_editLogic.php",
                data: data,
                success: function(response)
                {
                    //parse response to json
                    response = JSON.parse(response);

                    if(response == "success"){
                        show_alert_redirect('success', 'Modificado con exito.', '../pages/admin_cargar.php');

                    }else if(response == "error1"){
                        show_alert_reload('error', 'No existe la dependencia seleccionada.');

                    }else if(response == "error2"){
                        show_alert_reload('error', 'Complete todos los campos.');

                    }else {
                        show_alert_reload('error', 'Error al modificar.');
                    }
                }
            });
        });
    });
</script>


</body>
</html>