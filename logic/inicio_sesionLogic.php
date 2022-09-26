<?php
    session_start();
    $bandera = false;
    $autentication  = $_SESSION['TIPO_USUARIO'];
    $tipo_cliente   = $_SESSION['TIPO_USUARIO'];

    if ($autentication == 'Admin' || $autentication == 'Cliente' ){
        $bandera = true;
    }
    else{
        header('Location: ../pages/inicio_sesion.php?message=3');
    }



    $username = strtoupper($_POST['username']);
    $password = strtoupper($_POST['password']);



    session_start();

    include '../conexion.php';
    $mysqli = new mysqli($host, $user, $pw, $db);

    $sql = "SELECT * FROM users WHERE ID = '$username'";
    $result1 = $mysqli->query($sql);
    $row1 = $result1->fetch_array(MYSQLI_NUM);
    $numero_filas = $result1->num_rows;

    if($numero_filas > 0){


        $passw_bd = $row1[9];

        if($passw_bd == $password){


            $id_usuario     = $row1[1];
            $nom_usuario    = $row1[2];
            $tipo_usuario   = $row1[10];
            $tipo_plan      = $row1[11];
            $_SESSION['ID_USUARIO']     = $id_usuario;
            $_SESSION['NOM_USUARIO']    = $nom_usuario;
            $_SESSION['TIPO_USUARIO']   = $tipo_usuario;
            $_SESSION['TIPO_PLAN']      = $tipo_plan;

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
    //     // VALIDACION SI SE INGRESA UN ID REGISTRADO PERO SIN CONTRASEÑA
        else{
             header("Location: ../pages/inicio_sesion.php?message=1");
        }

    }
    else{
        header('Location: ../pages/inicio_sesion.php?message=2');
    }

?>