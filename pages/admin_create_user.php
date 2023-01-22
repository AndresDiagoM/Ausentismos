<?php
include "../logic/admin_securityLogic.php"; // Verifica que el usuario sea administrador
include "../template/cabecera.php";
?>

<!-- CONTENEDOR DE FORMULARIO -->
<div class="content">
    <div class="row py-3">   

        <div class="card mx-auto" style="width: 30rem; overflow-y: auto; height:85vh;">
            <div class="card-header">
            REGISTRO DE USUARIOS
            </div>
            <div class="card-body">            
                <form action="" method="POST" class="form" name="formulario" onsubmit="comprobarPSW()">

                    <!-- INPUT DEL NUMERO DE IDENTIFICACION -->
                    <div class="form-floating mb-3">
                        <input type="text" name="numero_id" id="cedula" class="form-control" placeholder="Número de identificación" pattern="[0-9]{5,15}" title="La identifiación solo debe contener carácteres numéricos. Entre 5 a 15 dígitos." required>
                        <label class="col-form-label" for="numero_id"> Número de identificación </label>
                    </div>

                    <!-- INPUT DE NOMBRES DE USUARIO -->
                    <div class="form-floating mb-3">
                        <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Digite los nombres y apellidos" required>
                        <input type="hidden" name="nombreB" id="nombreB">
                        <label class="col-form-label" for="nombre">Nombres y Apellidos </label>
                    </div>

                    <!-- INPUT DEL CORREO-->
                    <div class="form-floating mb-3">
                        <input type="email" name="correo" id="correo" class="form-control" placeholder="Correo" required>
                        <input type="hidden" name="correoB" id="correoB">
                        <label class="col-form-label" for="correo"> Correo </label>
                    </div>

                    <!-- INPUT DE LA DEPENDENCIA -->
                    <div class="form-floating mb-3">
                        <select class="form-select" name="dependencia" id="dependencia">
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
                                    }
                                }
                            ?>
                        </select>
                        <label class="col-form-label" for="dependencia"> Dependencia a consultar </label>
                    </div>

                    <!-- SELECT DEL TIPO DE USUARIO -->
                    <div class="form-floating mb-3">
                        <select class="form-select" name="tipo_us" id="tipo_us">
                            <option value="">Seleccione</option>
                            <option value="CONSULTA">CONSULTA</option>
                            <option value="ADMIN">ADMINISTRADOR</option>
                            <option value="FACULTAD">FACULTAD</option>
                        </select>
                        <label class="col-form-label" for="tipo_us"> Tipo de usuario</label>
                    </div>
                    
                    <!-- INPUT DEL LOGIN -->
                    <div class="form-floating mb-3">
                        <input type="text" name="login" class="form-control" placeholder="Digite su login"  required>
                        <label class="col-form-label" for="login"> Login </label>
                    </div>

                    <!-- INPUT DE LA CONTRASEÑA -->
                    <div class="form-floating mb-3">
                        <input type="password" name="pasw" class="form-control" pattern="[A-Za-z0-9]{5,30}"  min="5" max="30" placeholder="Digite una contraseña" id="passw" title="Debe tener de 5 a 30 caracteres." required>
                        <label class="col-form-label" for="pasw"> Contraseña </label>
                    </div>

                    <!-- INPUT DE REP CONTRASEÑA -->
                    <div class="form-floating mb-3">
                        <input type="password" name="re_pasw" class="form-control" pattern="[A-Za-z0-9]{5,30}"  min="5" max="30" placeholder="Repita la contraseña" id="passw_conf" title="Debe tener de 5 a 30 caracteres." required>
                        <label class="col-form-label" for="re_pasw">Repita la contraseña </label>
                    </div>

                    <div class="container">
                        <button type="submit" class="btn btn-success">REGISTRAR</button>
                    </div>

                </form>
            </div>
            
        </div>
    </div>
</div>


</div> <!-- fin de la clase w-100-->
</div> <!-- fin de la clase d-flex -->

    <!-- Bootstrap core JavaScript -->
    <script src="../assets/bootstrap-5.2.2-dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="../bootstrap-5.2.2-dist/js/bootstrap.min.js"></script> -->
    <script src="../assets/bootstrap-5.2.2-dist/js/popper.min.js"></script>

    <!-- APP JS CONTIENE  FUNCIONES PARA LOS GRÁFICOS -->
    <script src="../js/app1.js"></script>
    <!-- INSTALACION DE JQUERY -->
    <script src="../js/jquery.min.js"></script> 
    <script src="../js/sweetalert2-11.6.15/package/dist/sweetalert2.min.js"></script>
    <script src="../js/sweet_alert.js"></script>

    <!-- FUNCIONES PARA EL REGISTRO DE USUARIOS -->
    <script src="../js/registrarUser.js"></script>

<!-- SCRIPT PARA LA VERFICACION DE CONTRASEÑAS -->
<script>

    //if the password in the password field doesn't match the password in the confirm password field then dont send the form and show an alert
    var password = document.getElementById("passw")
    , confirm_password = document.getElementById("passw_conf"); 

    function validatePassword(){
        if(password.value != confirm_password.value) {
            confirm_password.setCustomValidity("Las contraseñas no coinciden");
        } else {
            confirm_password.setCustomValidity('');
        }
    }

    password.onchange = validatePassword;
    confirm_password.onkeyup = validatePassword;

    function comprobarPSW(){
        var passw1 = document.formulario.pasw.value;
        var passw2 = document.formulario.re_pasw.value;

        if(passw1 != passw2){
            show_alert('error', 'Las contraseñas NO coinciden!');
            //console.log('Las contraseñas NO coinciden!');
            document.getElementById("passw").value="";
            document.getElementById("passw_conf").value="";
            //return false;
        }
    }

</script>


<?php
    include("../template/pie.php");
?>