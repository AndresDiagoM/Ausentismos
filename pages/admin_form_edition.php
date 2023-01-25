<?php
    include "../logic/admin_securityLogic.php"; // Verifica que el usuario sea administrador
    include "../template/cabecera.php";
    $id_usuario     = $_GET['ID'];
    //si la variable $id_usuario esta vacia, o tiene valores que no sean numeros, redireccionar a la pagina de admin_edition
    if(empty($id_usuario) || !is_numeric($id_usuario)){
        if(headers_sent())
            die("<script>location.href='admin_edition_client.php';</script>");
        else
            exit(header("Location: admin_edition_client.php"));
        //header("Location: admin_edition.php");
    }

    //CONSULTAR EL USUARIO SELECCIONADO
    $sqli   = "SELECT * FROM usuarios 
                INNER JOIN dependencias ON usuarios.Dependencia=dependencias.ID 
                WHERE Cedula_U = '$id_usuario'";
    $result = $conectar->query($sqli);
    $num_rows = $result->num_rows;
    //si no encuentra ningun usuario, entonces redirigir admin_edition_client.php
    if($num_rows >0 ){
        $data=[];
        while($row = mysqli_fetch_assoc($result)){
            $Id_editar = $row['Cedula_U'];
            $data[] = $row;
        }
        $mostrar = $data[0];
        //print_r($mostrar);



        
    }else{
        die("<script>location.href='admin_edition_client.php';</script>");
    }
?>


<!-- INICIO DE CONTENEDOR DE USUARIO SELECCIONADO -->
<div class="container py-2">

    <div class="card mx-auto" style="width: 30rem; overflow-y: auto; height:90vh;">
        <div class="card-header">
            MODIFICACIÓN DE DATOS
        </div>
        <div class="card-body">
            <h5 class="card-title">Nombre: <?php echo $mostrar['Nombre_U'] ?></h5>

            <form id="form_edit" action="" method="POST">
                
                <input type="hidden" name="cedula_u"  value="<?php echo $Id_editar;?>" >

                <!-- INPUT DE LA CEDULA -->
                <div class="form-floating mb-2">
                    <input type="text" name="Cedula_U" class="form-control" pattern="[0-9]{3,10}" title="La identifiación solo debe contener carácteres numéricos." value="<?php echo $mostrar['Cedula_U'];?>" placeholder="Digite su cedula"  required>
                    <label class="col-form-label" for="Cedula_U"> Cedula </label>
                </div>

                <!-- INPUT DEL Nombre -->
                <div class="form-floating mb-2">
                    <input type="text" name="Nombre_U" class="form-control" pattern="[a-zA-Z0-9\s]+" min="4" max="45"  value="<?php echo $mostrar['Nombre_U'];?>" placeholder="Digite su nombre"  required>
                    <label class="col-form-label" for="Nombre_U"> Nombre </label>
                </div>

                <!-- INPUT DEL Correo -->
                <div class="form-floating mb-2">
                <input type="email" name="Correo" class="form-control" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" value="<?php echo $mostrar['Correo'];?>" placeholder="Digite su correo"  required>
                    <label class="col-form-label" for="Correo"> Correo </label>
                </div>

                <!-- INPUT DE LA DEPENDENCIA -->
                <div class="form-floating mb-2">
                    <select class="form-select form-select-sm" name="Dependencia">
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
                                    echo '<option value="'.$row['ID'].'">'.$row['Facultad'].' - '.$row['Departamento'].'</option>';
                                    if($row['ID'] == $mostrar['ID']){
                                        echo '<option value="'.$row['ID'].'" selected>'.$row['Facultad'].' - '.$row['Departamento'].'</option>';
                                    }
                                }
                            }
                        ?>
                    </select>
                    <label class="col-form-label" for="Dependencia"> Dependencia </label>
                </div>

                <!-- INPUT DEL TIPO DE USUARIO -->
                <div class="form-floating mb-2">
                    <select class="form-select" name="TipoUsuario" required>
                            <option value="">Seleccione</option>
                            <option value="ADMIN" <?php if($mostrar['TipoUsuario'] == 'ADMIN'){echo 'selected';}?> >ADMINISTRADOR</option>
                            <option value="CONSULTA" <?php if($mostrar['TipoUsuario'] == 'CONSULTA'){echo 'selected';}?> >CONSULTA</option>
                            <option value="FACULTAD" <?php if($mostrar['TipoUsuario'] == 'FACULTAD'){echo 'selected';}?> >FACULTAD</option>
                    </select>
                    <label for="TipoUsuario" class="col-form-label">Tipo Usuario</label>
                </div>

                <!-- INPUT DEL ESTADO -->
                <div class="form-floating mb-2">
                    <select class="form-select" name="Estado" required>
                            <option value="">Seleccione</option>
                            <option value="ACTIVO" <?php if($mostrar['Estado'] == 'ACTIVO'){echo 'selected';}?> >ACTIVO</option>
                            <option value="INACTIVO" <?php if($mostrar['Estado'] == 'INACTIVO'){echo 'selected';}?> >INACTIVO</option>
                    </select>
                    <label for="Estado" class="col-form-label">Estado</label>
                </div>

                <!-- INPUT DEL LOGIN -->
                <div class="form-floating mb-2">
                    <input type="text" name="Login" class="form-control" pattern="[a-zA-Z0-9]+" min="4" max="40" value="<?php echo $mostrar['Login'];?>" placeholder="Digite su login"  required>
                    <label class="col-form-label" for="Login"> Login </label>
                </div>

                <!-- INPUT DE LA Contraseña -->
                <div class="form-floating mb-2">
                    <input type="password" id="contrasena_usuario_edt" name="Contrasena" class="form-control" pattern="[A-Za-z0-9]{5,40}"  min="5" max="30" value="<?php echo $mostrar['Contrasena'];?>" placeholder="Digite su contraseña" title="Debe tener de 5 a 30 caracteres."  required>
                    <label class="col-form-label" for="Contrasena"> Contraseña </label>
                </div>

                <!-- INPUT DE LA Contraseña -->
                <div class="form-floating mb-2">
                    <input type="password" id="contrasena_usuario" name="Contrasena2" class="form-control" pattern="[A-Za-z0-9]{5,40}"  min="5" max="30" value="<?php echo $mostrar['Contrasena'];?>" placeholder="Digite su contraseña" title="Debe tener de 5 a 30 caracteres."  required>
                    <label class="col-form-label" for="Contrasena2"> Repita la Contraseña </label>
                </div>

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

    <script src="../js/sweetalert2-11.6.15/package/dist/sweetalert2.min.js"></script>
    <script src="../js/sweet_alert.js"></script>

<script>
    //enviar formulario por ajax a '../logic/form_editLogic.php', cuando se presiona el boton Modificar
    $(document).ready(function(){       //../logic/form_editLogic.php?ID=<php echo $Id_editar 
        $('#form_edit').submit(function(e){
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "../logic/form_editLogic.php",
                data: $('#form_edit').serialize(),
                success: function(response)
                {
                    //parse response to json
                    var obj = JSON.parse(response);

                    //if obj is success then show success message, using sweetalert
                    if(obj == 'success'){
                        show_alert_redirect('success', 'Datos Actualizados Correctamente', '../pages/admin_edition_client.php');

                    } else if(obj == 'error1'){
                        show_alert_redirect('error', 'Complete todos los campos', '../pages/admin_edition_client.php');

                    } else if(obj == 'error3'){
                        show_alert_redirect('error', 'Las contraseñas no coinciden', '../pages/admin_edition_client.php');

                    } else{
                        show_alert_redirect('error', 'Error al actualizar', '../pages/admin_edition_client.php');

                    }
                    
                }
            });
        });
    });

    //if the password in the password field doesn't match the password in the confirm password field then dont send the form and show an alert
    var password = document.getElementById("contrasena_usuario_edt")
    , confirm_password = document.getElementById("contrasena_usuario");

    function validatePassword(){
        if(password.value != confirm_password.value) {
            confirm_password.setCustomValidity("Las contraseñas no coinciden");
        } else {
            confirm_password.setCustomValidity('');
        }
    }

    password.onchange = validatePassword;
    confirm_password.onkeyup = validatePassword;

    document.addEventListener('contextmenu', function(e) {
        //e.preventDefault();
    });

</script> 

<?php
    include("../template/pie.php");
?>