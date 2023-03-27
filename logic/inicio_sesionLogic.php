<?php
    session_set_cookie_params(0);
    session_start();
    $bandera = false;
    $autentication  = isset($_SESSION['TIPO_USUARIO']) ? $_SESSION['TIPO_USUARIO'] : null;
    $tipo_cliente   = isset($_SESSION['TIPO_CLIENTE']) ? $_SESSION['TIPO_CLIENTE'] : null;

    //
    if (strtoupper($autentication) == 'ADMIN' || strtoupper($autentication) == 'CONSULTA' ){
        $bandera = true;
    }
    else{
        header('Location: ../pages/inicio_sesion.php?message=3');
    }

    $username = strtoupper($_POST['username']);
    $password = strtoupper($_POST['password']);

    //Verificar que los campos de username y password no tengan intyeccion de codigo 
    $username = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
    $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');

    //Si los campos tienen caracteres especiales entonces quitarlos
    $username = preg_replace('/[^A-Za-z0-9]/', '', $username);
    $password = preg_replace('/[^A-Za-z0-9]/', '', $password);

    //echo $username.' pass: '. $password; exit;
    
    // Verificar que los campos de username y password no esten vacios
    if (empty($username) || empty($password)) {
        header('Location: ../pages/inicio_sesion.php?message=2');
    }

    //session_start();

    include '../conexion.php';
    $mysqli = new mysqli($host, $user, $pw, $db);

    //Consultar si el usuario ingresado existe
    $sql = "SELECT * FROM usuarios INNER JOIN dependencias ON dependencias.ID=usuarios.Dependencia WHERE Login = '$username'";
    $result1 = $mysqli->query($sql);
    $row1 = $result1->fetch_assoc();
    $numero_filas = $result1->num_rows;

    if($numero_filas > 0){

        $passw_bd = $row1['Contrasena'];

        //Converitr la contraseña que introduce el usuario a md5
        $password = md5($password);

        if($passw_bd == $password){

            //Si el usuario está inactivo no se le permite el acceso
            if($row1['Estado'] == 'INACTIVO'){
                header('Location: ../pages/inicio_sesion.php?message=4');
                exit;
            }

            $id_usuario     = $row1['Cedula_U'];
            $nom_usuario    = $row1['Nombre_U'];
            $tipo_usuario   = $row1['TipoUsuario'];
            $dependencia  = $row1['C_costo'];
            
            $_SESSION['ID_USUARIO']     = $id_usuario;
            $_SESSION['NOM_USUARIO']    = $nom_usuario;
            $_SESSION['TIPO_USUARIO']   = $tipo_usuario;
            $_SESSION['DEPENDENCIA']   = $dependencia;


            // VALIDACION SI EL USUARIO ES ADMINISTRADOR
            if(strtoupper($tipo_usuario) == 'ADMIN' || strtoupper($tipo_usuario) == 'ROOT'){
                header('Location: ../pages/admin_menu.php');
            }
            // VALIDACION SI EL USUARIO ES CONSULTA
            elseif(strtoupper($tipo_usuario) == 'CONSULTA'){
                header('Location: ../pages/admin_menu.php');
            }
            // VALIDACION SI EL USUARIO ES facultad
            elseif(strtoupper($tipo_usuario) == 'FACULTAD'){
                header('Location: ../pages/facultad_agregar.php');
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