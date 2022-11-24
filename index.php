<?php
    include ("conexion.php");
    //include "./logic/validate_sessionLogic.php";

    session_set_cookie_params(0);
    session_start();
    error_reporting(0);
    $bandera = false;
    $autentication  = $_SESSION['TIPO_USUARIO'];
    $nombre_cliente = strtoupper($_SESSION['NOM_USUARIO']);
    $nombre_admin   = strtoupper($_SESSION['NOM_USUARIO']);
    $id_cliente     = strtoupper($_SESSION['ID_USUARIO']);
    $id_admin       = strtoupper($_SESSION['ID_USUARIO']);

    if($autentication == 'Cliente' || $autentication == 'Admin'){
        $bandera = true;
    }
    else{
        $bandera = false;
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./images/icon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="./bootstrap-5.2.2-dist/css/bootstrap.min.css" /> 

    <!-- CSS -->
    <link href="./css/estilo.css" rel="stylesheet" integrity="" crossorigin="anonymous">

    <!-- ICONOS en https://ionic.io/ionicons/v4/usage#md-pricetag -->
    <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">

    <title>Admin</title>
</head>

<style type="text/css">
    .divider:after, .divider:before {
        content: "";
        flex: 1;
        height: 1px;
        background: #eee;
    }
    .h-custom {
        height: calc(100% - 73px);
    }
    @media (max-width: 450px) {
        .h-custom {
        height: 100%;
        }
    }
</style>

<body>
    
    <div class="mx-auto">
    
    <section class="vh-100">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-9 col-lg-6 col-xl-5">
                <img src="./images/logoU.png"
                class="img-fluid" alt="Sample image">
            </div>
            <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                <form action="./logic/inicio_sesionLogic.php" method="POST">

                <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
                    <p class=""></p>
                </div>

                <p class="text-center lead fw-normal mb-0 me-3">
                    División de Gestión del Talento Humano</p>

                <div class="divider d-flex align-items-center my-4">
                    <!-- <p class="text-center fw-bold mx-3 mb-0">Or</p> -->
                </div>

                <!-- Email input -->
                <div class="form-floating mb-3 col-auto"> 
                    <input type="text" id="form3Example3" name="username" class="form-control"
                    placeholder="Ingrese su usuario" required/>
                    <label class="col-form-label" for="form3Example3">Usuario</label>
                </div>

                <!-- Password input -->
                <div class="form-floating mb-3 col-auto"> 
                    <input type="password" id="form3Example4" name="password" class="form-control form-control-lg"
                    placeholder="Ingrese la contraseña" required/>
                    <label class="form-label" for="form3Example4">Contraseña</label>
                </div>

                <p class="label_mensaje">
                    <?php
                    if (isset($_GET["message"])) {
                        $message = $_GET["message"];
                        if ($_GET["message"] != "") {
                            
                            echo '*';
                            
                            if ($message == 1) {
                                echo 'USUARIO O CONTRASEÑA INCORRECTA';
                                // echo "USUARIO O CONTRASEÑA INCORRECTA. INTENTE DE NUEVO.";
                                session_destroy();
                            } elseif ($message == 2) {
                                echo 'USUARIO NO REGISTRADO.';
                                session_destroy();
                            } elseif ($message == 3) {
                                echo 'ALERTA DE SEGURIDAD. FAVOR INICIE SESIÓN';
                                session_destroy();
                            } elseif ($message == 4) {
                                echo 'SESIÓN FINALIZADA. INICIE SESIÓN NUEVAMENTE';
                                session_destroy();
                            } elseif ($message == 5) {
                                echo 'INICIE SESIÓN PARA UTILIZAR EL SISTEMA';
                            }
                            
                        echo '</p>';
                        }
                    }
                    ?>

                <div class="d-flex justify-content-between align-items-center">
                    <!-- Checkbox -->
                    <div class="form-check mb-0">
                    <!--<input class="form-check-input me-2" type="checkbox" value="" id="form2Example3" />
                    <label class="form-check-label" for="form2Example3">
                        Remember me
                    </label> -->
                    </div>
                    <!-- <a href="#!" class="text-body">Forgot password?</a> -->
                </div>

                <div class="text-center text-lg-start mt-4 pt-2">
                    <button type="submit" class="btn btn-success btn-lg"
                    style="padding-left: 2.5rem; padding-right: 2.5rem;">Iniciar Sesion</button>
                    <!-- <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="./pages/form_register.php"
                        class="link-danger">Register</a></p> -->
                </div>

                </form>
            </div>
            </div>
        </div>

            <div class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between  px-4 px-xl-5 bg-primary">
                <!-- Copyright -->
                <div class="container">
                    <div class="row">
                        
                        <div class="col py-2 ">
                            <img src="./images/lema.png" width="100" height="50" class="img-responsive" alt="Sample image">
                            <img src="./images/logosIcontec2020.png" width="100" height="50" class="img-responsive" alt="Sample image">
                        </div>


                        <div class="col text-white mb-1 mb-md-0 py-4">
                        
                        </div>
                        <div class="col ">
                            
                        </div>
                    </div>
                </div>                
                <!-- Copyright -->

                <!-- Right -->
                <div class="py-4">
                    <a href="#!" class="text-white me-4">
                        <i class="icon ion-logo-facebook"></i>
                    </a>
                    <a href="#!" class="text-white me-4">
                        <i class="icon ion-logo-twitter"></i>
                    </a>
                    <a href="#!" class="text-white">
                        <i class="icon ion-logo-linkedin"></i>
                    </a>
                </div> 
                <!-- Right -->
            </div>
        </section>

    </div>

</body>

</html>