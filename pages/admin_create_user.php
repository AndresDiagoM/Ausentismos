<?php
include "../template/cabecera2.php";
?>

<!-- SCRIPT PARA LA VERFICACION DE CONTRASEÑAS -->
<script>
    function comprobarPSW(){
        var passw1 = document.formulario.pasw.value;
        var passw2 = document.formulario.re_pasw.value;

        if(passw1 != passw2){
            alert('Las contraseñas NO coinciden');
            document.getElementById("passw").value="";
            document.getElementById("passw_conf").value="";
            return false;
        }
    }
</script>

<!-- CONEXION CON AJAX -->
<script type="text/javascript">
    function mostrarSelect(str){
        var conexion;

        if(str==""){

            document.getElementById("txtHint").innerHTML="";
            return;
        }

        if(window.XMLHttpRequest){
            conexion = new XMLHttpRequest();

        }

        conexion.onreadystatechange = function(){
            if(conexion.readyState == 4 && conexion.status == 200){
                document.getElementById("div").innerHTML = conexion.responseText;
            }
        }

        conexion.open("GET", "../logic/municipiosLogic.php?c="+str,true);
        conexion.send();
    }

</script>


<!-- CONTENEDOR DE FORMULARIO -->
<div class="container py-3">
    <div class="card " style="width: 30rem;">
        <div class="card-header">
        REGISTRO DE USUARIOS
        </div>
        <div class="card-body">            
            <form action="../logic/admin_create_userLogic.php" method="POST" class="form" name="formulario" onsubmit="return comprobarPSW()">
                <!-- INPUT DE NOMBRES DE USUARIO -->
                <div class="form-floating mb-3">
                    <input type="text" name="nomb_usuario" class="form-control" placeholder="Digite los nombres y apellidos" required>
                    <label class="col-form-label" for="nomb_usuario">Nombres y Apellidos </label>
                </div>
                
                <!-- INPUT DEL NUMERO DE IDENTIFICACION -->
                <div class="form-floating mb-3">
                    <input type="text" name="numero_id" class="form-control" placeholder="Número de identificación" pattern="[0-9]{8,10}" title="La identifiación solo debe contener carácteres numéricos y debe cumplir con el formato nacional" required>
                    <label class="col-form-label" for="numero_id"> Número de identificación </label>
                </div>

                <!-- INPUT DEL CORREO -->
                <div class="form-floating mb-3">
                    <input type="text" name="dependencia" class="form-control" placeholder="Digite su dependencia"  required>
                    <label class="col-form-label" for="dependencia"> Dependencia </label>
                </div>

                <!-- SELECT DEL TIPO DE USUARIO -->
                <div class="form-floating mb-3">
                    
                    <select class="form-control" name="tipo_us">
                        <option value="">Seleccione</option>
                        <option value="CON">CONSULTA</option>
                        <option value="ADM">ADMINISTRADOR</option>
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
                    <input type="password" name="pasw" class="form-control" placeholder="Digite una contraseña" id="passw" required>
                    <label class="col-form-label" for="pasw"> Contraseña </label>
                </div>

                <!-- INPUT DE REP CONTRASEÑA -->
                <div class="form-floating mb-3">
                    <input type="password" name="re_pasw" class="form-control" placeholder="Repita la contraseña" id="passw_conf" required>
                    <label class="col-form-label" for="re_pasw">Repita la contraseña </label>
                </div>

                <div class="container">
                    <button type="submit" class="btn btn-primary">REGISTRAR</button>
                </div>

            </form>
        </div>
        
    </div>
</div>


<!-- SCRIPT MENU LATERAL-->
<script>
    const btn = document.querySelector('#menu-btn');
    const menu = document.querySelector('#slide-menu');


    btn.addEventListener('click', e => {
        menu.classList.toggle("menu-expanded");
        window.scrollTo(150,150);
        menu.classList.toggle("menu-collapsed");
    });
</script>

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

</body>
</html>

