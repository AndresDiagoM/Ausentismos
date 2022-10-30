<?php
    include "../conexion.php";
    include "../logic/validate_sessionLogic.php";
    $mysqli = new mysqli($host, $user, $pw, $db);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/icon.png">
    <link rel="stylesheet" href="../css/style_inicio_sesion.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=IM+Fell+French+Canon+SC&family=Kanit:ital,wght@0,400;1,400;1,500;1,900&display=swap">
    <script src="https://kit.fontawesome.com/b50f20f4b1.js" crossorigin="anonymous"></script>

    <title>Login</title>
</head>
<meta chatset="UTF-8">

<body>

    <!-- CABECERA DE TRABAJO -->
    <header>

        <div class="contenedor_principal">
            <div class="contenedor_logo">
                <a href="../index.php"><img id="imagen_logo" src="../images/logo.png" alt="Error al cargar la imagen"></a>
            </div>
            <div class="contenedor_frase">
                <span>Divisón de Gestión del Talento Humano</span>
            </div>
            <div class="contenedor_botones">
                <div class="contenedor_botton_inicio">

                    <a href="../index.php"><button type="" class="btn-inicio-sesion"> Menú Principal</button></a>

                </div>
                <div class="contenedor_botton_registro">
                    <a href="../pages/form_register.php"><button type="" class="btn-inicio-sesion"> Registrarse </button></a>
                </div>

            </div>
        </div>

    </header>


    <!-- DISEÑO DE INICIO SESION-->

    <div id="particles-js"></div>

    <form action="../logic/inicio_sesionLogic.php" method="POST">
        <div class="login-box">
            <h1>INICIO DE SESIÓN</h1> <!-- El título de Inicio de sesión -->

            <div class="form">
                <div class="item">
                    <!-- parte de nombre de usuario -->
                    <i class="fa fa-user-circle" id="ic_us" aria-hidden="true" class="iconos"></i> <!-- Se utilizará para dibujar el icono delante del nombre de usuario -->
                    <input type="text" placeholder="Identificación" name="username" class="input_decor"> <!-- Entrada de nombre de usuario realizada por cuadro de texto -->
                </div>

                <div class="item">
                    <!-- parte de la contraseña -->

                    <i class="fa fa-key" aria-hidden="true"></i> <!-- Se utilizará para dibujar el icono delante de la contraseña en el futuro -->
                    <input type="password" placeholder="password" name="password"> <!-- Entrada de contraseña usando el cuadro de texto de contraseña-->

                    <p class="label_mensaje">

                        <?php
                        if (isset($_GET["message"])) {
                            $message = $_GET["message"];
                            if ($_GET["message"] != "") {

                        ?>
                                Datos incorrectos:
                                <?php
                                if ($message == 1) {
                                    echo "CONTRASENA INCORRECTA";
                                    // echo "USUARIO O CONTRASEÑA INCORRECTA. INTENTE DE NUEVO.";
                                    session_destroy();
                                } elseif ($message == 2) {
                                    echo "USUARIO NO REGISTRADO.";
                                    session_destroy();
                                } elseif ($message == 3) {
                                    echo "ALERTA DE SEGURIDAD. FAVOR INICIE SESIÓN";
                                    session_destroy();
                                } elseif ($message == 4) {
                                    echo "SESIÓN FINALIZADA. INICIE SESIÓN NUEVAMENTE";
                                    session_destroy();
                                } elseif ($message == 5) {
                                    echo "INICIE SESIÓN PARA REALIZAR UNA COMPRA";
                                }
                                ?>


                    </p>

            <?php
                            }
                        }
            ?>
                </div>

            </div>

            <button type="submit" class="btn-login">ACCEDER</button> <!-- Botón de inicio de sesión implementado con el botón -->
        </div>
    </form>

    <!-- Insercion de particulas -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>  -->
    <script src="../js/particles.min.js"></script>
    <script src="../js/app.js"></script>
</body>

</html>