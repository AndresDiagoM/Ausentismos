<?php
    session_set_cookie_params(0);
    session_start();
    $bandera = false;
    $autentication  = $_SESSION['TIPO_USUARIO'];
    $tipo_cliente   = $_SESSION['TIPO_USUARIO'];

    if ($autentication == 'Admin' || $autentication == 'Consulta' ){
        $bandera = true;
    }
    else{
        header('Location: ../pages/inicio_sesion.php?message=3');
    }



    $username = strtoupper($_POST['username']);
    $password = strtoupper($_POST['password']);



    //session_start();

    include '../conexion.php';
    $mysqli = new mysqli($host, $user, $pw, $db);

    $sql = "SELECT * FROM usuarios WHERE login = '$username'";
    $result1 = $mysqli->query($sql);
    $row1 = $result1->fetch_array(MYSQLI_NUM);
    $numero_filas = $result1->num_rows;

    if($numero_filas > 0){


        $passw_bd = $row1[6];

        if($passw_bd == $password){


            $id_usuario     = $row1[0];
            $nom_usuario    = $row1[1];
            $tipo_usuario   = $row1[4];
            $_SESSION['ID_USUARIO']     = $id_usuario;
            $_SESSION['NOM_USUARIO']    = $nom_usuario;
            $_SESSION['TIPO_USUARIO']   = $tipo_usuario;

            // VALIDACION SI EL USUARIO ES ADMINISTRADOR
            if($tipo_usuario == 'Admin'){
                header('Location: ../pages/admin_menu.php');
            }
            // VALIDACION SI EL USUARIO ES CLIENTE
            elseif($tipo_usuario == 'Cliente'){
                header('Location: ../pages/client_menu.php');
            }
            else{
            // VALIDACION SI EL USUARIO NO TIENE UN ROL DEFINIDO
                header('Location: ../pages/inicio_sesion.php?message=1');
            }



        }
            // VALIDACION SI SE INGRESA UN ID REGISTRADO PERO SIN CONTRASEÑA
        else{
            header("Location: ../pages/inicio_sesion.php?message=1");
        }

    }
    else{
        header('Location: ../pages/inicio_sesion.php?message=2');
    }

?>