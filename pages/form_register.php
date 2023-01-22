<?php
    include "../conexion.php";
    require "../logic/validate_sessionLogic.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/icon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../bootstrap-5.2.2-dist/css/bootstrap.min.css" /> 

    <!-- CSS -->
    <link href="../css/estilo.css" rel="stylesheet" integrity="" crossorigin="anonymous">

    <!-- ICONOS en https://ionic.io/ionicons/v4/usage#md-pricetag -->
    <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">

    <title>Admin</title>
</head>

<body>
    <div class="d-flex">

    <!-- SIDE BAR - menu lateral -->
    <div id="sidebar-container" class="bg-primary">
        <div class="logo" >
            <h4 class="text-light font-weight-bold"> GESTION DE AUSENTISMOS </h4>
        </div>

        <div class="menu">
            
        </div>
    </div>

    <div class="container w-100">


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


<!-- CONTENEDOR DE FORMULARIO -->

<div class="row py-3">
    <div class="card mx-auto" style="width: 30rem;">
        <div class="card-header ">
            REGISTRO DE USUARIOS
        </div>
        <div class="card-body">            
            <form action="../logic/form_registerLogic.php" method="POST" class="form" name="formulario" onsubmit="return comprobarPSW()">
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

                <!-- INPUT DEL CORREO-->
                <div class="form-floating mb-3">
                    <input type="email" name="correo" class="form-control" placeholder="Correo" required>
                    <label class="col-form-label" for="correo"> Correo </label>
                </div>

                <!-- INPUT DE LA DEPENDENCIA -->
                <div class="form-floating mb-3">
                    <select class="form-control" name="dependencia">
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
                    <label class="col-form-label" for="dependencia"> Dependencia </label>
                </div>

                <!-- SELECT DEL TIPO DE USUARIO -->
                <div class="form-floating mb-3">
                    <select class="form-control" name="tipo_us">
                        <option value="">Seleccione</option>
                        <option value="CONSULTA">CONSULTA</option>
                        <option value="ADMIN">ADMINISTRADOR</option>
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

</body>
</html>