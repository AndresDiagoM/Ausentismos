<?php
    include "../logic/admin_securityLogic.php"; // Verifica que el usuario sea administrador
    include "../template/cabecera.php";
    $id_usuario     = $_GET['ID'];
    //if there is no id redirect to admin_edit_func.php
    if(!isset($id_usuario) || empty($id_usuario)){
        header("Location: ./admin_edit_func.php");
    }

    //Consultar datos del usuario seleccionado
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


<!-- INICIO DE CONTENEDOR DE FUNCIONARIO SELECCIONADO -->
<div class="container py-2">

    <div class="card mx-auto" style="width: 30rem; overflow-y: auto; height:auto;">
        <div class="card-header">
            MODIFICACIÓN DE DATOS
        </div>
        <div class="card-body">
            <h5 class="card-title">Nombre: <?php echo $mostrar['Nombre'] ?></h5>

            <form id="form_func_edit" action="" method="POST">

                <input type="hidden" name="cedula_f" id="cedula_f" value="<?php echo $mostrar['Cedula'];?>">
                
                <!-- INPUT DE LA CEDULA -->
                <div class="form-floating mb-2">
                    <input type="text" name="cedula_func_edt" class="form-control" pattern="[0-9]{3,15}" title="La identifiación solo debe contener carácteres numéricos." value="<?php echo $mostrar['Cedula'];?>" placeholder="Digite su cedula"  required>
                    <label class="col-form-label" for="cedula_func_edt"> Cedula </label>
                </div>

                <!-- INPUT DEL NOMBRE -->
                <div class="form-floating mb-2">
                    <input type="text" name="nombre_func_edt" class="form-control" min="4" max="40" placeholder="Nombre" title="El nombre solo puede tener letras." value="<?php echo $mostrar['Nombre'];?>" required>
                    <label class="col-form-label" for="nombre_func_edt"> Nombre </label>
                </div>

                <!-- INPUT DEL CARGO -->
                <div class="form-floating mb-2">
                    <input type="text" name="cargo_func_edt" class="form-control" min="4" max="40" placeholder="Cargo"  value="<?php echo $mostrar['Cargo'];?>" required>
                    <label class="col-form-label" for="cargo_func_edt"> Cargo </label>
                </div>

                <!-- INPUT DE LA DEPENDENCIA -->
                <div class="form-floating mb-2">
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
                    <label class="col-form-label" for="dependencia_ausen_edt"> Dependencia </label>
                </div>

                <!-- INPUT DEL Genero -->
                <div class="form-floating mb-2">
                    <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="genero_func_edt" required>
                            <option value="">Seleccione</option>
                            <option value="MAS" <?php if($mostrar['Genero'] == 'MAS'){echo 'selected';}?> > Masculino </option>
                            <option value="FEM" <?php if($mostrar['Genero'] == 'FEM'){echo 'selected';}?> > Femenino </option>
                    </select>
                    <label class="col-form-label" for="genero_func_edt"> Genero </label>
                </div>

                <!-- INPUT DEL Salario -->
                <div class="form-floating mb-2">
                    <input type="text" name="salario_func_edt" class="form-control" min="1" max="100000000" pattern="[0-9]{1,9}" title="Solo números" placeholder="salario" value="<?php echo $mostrar['Salario'];?>" required>
                    <label class="col-form-label" for="salario_func_edt"> Salario </label>
                </div>

                <!-- INPUT DEL Estado -->
                <div class="form-floating mb-2">
                    <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="estado_func_edt" required>
                            <option value="">Seleccione</option>
                            <option value="ACTIVO" <?php if($mostrar['Estado'] == 'ACTIVO'){echo 'selected';}?> > ACTIVO </option>
                            <option value="INACTIVO" <?php if($mostrar['Estado'] == 'INACTIVO'){echo 'selected';}?> > INACTIVO </option>
                    </select>
                    <label class="col-form-label" for="estado_func_edt"> Estado </label>
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
    <script src="../assets/bootstrap-5.2.2-dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="../bootstrap-5.2.2-dist/js/bootstrap.min.js"></script> -->
    <script src="../assets/bootstrap-5.2.2-dist/js/popper.min.js"></script>

    <!-- APP JS CONTIENE  FUNCIONES PARA LOS GRÁFICOS 
    <script src="../js/app1.js"></script> -->

    <!-- INSTALACION DE JQUERY -->
    <script src="../js/jquery.min.js"></script> 
    
    <!-- INSTALACION DE SWEETALERT2 -->
    <script src="../js/sweetalert2-11.6.15/package/dist/sweetalert2.min.js"></script>
    <script src="../js/sweet_alert.js"></script>

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
                        show_alert_redirect('success', 'Funcionario modificado con éxito', "./admin_edit_func.php");

                    }else if(resp == 'error1'){
                        show_alert('error', 'No existe la dependencia seleccionada');

                    }else if(resp == 'error2'){
                        show_alert('error', 'Complete todos los campos!');

                    }else{
                        show_alert('error', 'Error al modificar funcionario');

                    }
                }
                
            });
        });
    });
</script> 


<?php
    include("../template/pie.php");
?>