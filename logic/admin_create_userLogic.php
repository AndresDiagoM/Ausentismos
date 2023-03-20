<?php
    /*
    *   Codigo para crear un usuario
    */

    // Conexion a la base de datos
    require '../conexion.php';

    //====================================================================
    //=====================  BUSCAR CEDULA  ==============================
    //if $_POST have cedula, then consult the database for the funcionario
    if(isset($_POST['BuscarCedula'])){
        $cedula = $_POST['BuscarCedula'];
        $consulta = "SELECT * FROM funcionarios WHERE Cedula='$cedula'";
        $resultado = $conectar->query($consulta);
        if(mysqli_num_rows($resultado)>0){
            $json = array();
            while($row = mysqli_fetch_array($resultado)){
                $json[] = array(
                    'nombre' => $row['Nombre'],
                    'cargo' => $row['Cargo'],
                    'correo' => $row['Correo'],
                    'dependencia' => $row['Dependencia'],
                    'genero' => $row['Genero'],
                    'salario' => $row['Salario']
                );
            }
            $jsonstring = json_encode($json[0]);
            echo $jsonstring;
        }else{
            echo json_encode("error");
        }
        exit;
    }
    //print_r($query_values); exit;

    //receive the data from POST to an array and validate if nombre is empty
    $query_values = $_POST;
    //convert all values to uppercase
    $query_values = array_map('strtoupper', $query_values);

    //Si el usuario existe en la tabla de funcionarios, asignar el nombre y correo
    if(!isset($query_values['nombre'])){
        $query_values['nombre'] = $query_values['nombreB'];
    }    
    if(!isset($query_values['correo'])){
        $query_values['correo'] = $query_values['correoB'];
    }

    //Guardar valores del formulario en variables
    $nombre_usuario  =   $query_values['nombre'];
    $numero_id       =   $query_values['cedula'];
    $correo        =     $query_values['correo'];
    $dependencia   =     $query_values['dependencia'];
    $tipo_us       =     $query_values['tipo_us'];
    $login         =     $query_values['login'];
    $pasw          =     $query_values['pasw'];

    // Verificacion de campos vacios
    if($numero_id==''){
        echo json_encode("error1");
    } else if($dependencia==''){
        //SI EL USUARIO A REGISTRAR ES UN ADMIN/COMSULTA, SE ASIGNA LA DEPENDENCIA 13
        $dependencia = '13';
        //echo $dependencia; exit();
    } 

    // Verificacion de ID NO repetido
    $consulta_id = "SELECT * FROM usuarios WHERE Cedula_U='$numero_id'";
    $verificar_id = $conectar->query($consulta_id);
    if(mysqli_num_rows($verificar_id)>0){
        //echo "<script>alert('Registro Incorrecto. El ID ya se encuentra registrado');location.href = '../pages/admin_create_user.php';</script>";
        echo json_encode("error2");
        exit();
    }

    //ENCRIPTAR CONTRASEÑA CON MD5
    $pasw = md5($pasw);
    //print_r($query_values); exit;

    //verificar que ese id exista en la tabla funcionarios
    /*$consulta_id = "SELECT * FROM funcionarios WHERE Cedula='$numero_id'";
    $verificar_id = $conectar->query($consulta_id);
    if(mysqli_num_rows($verificar_id)==0){
        //echo "<script>alert('Registro Incorrecto. El ID no se encuentra registrado en la tabla funcionarios');location.href = '../pages/admin_create_user.php';</script>";
        echo json_encode("error6");
        exit();
    }*/

    // Verificacion de correo
    $consulta_correo = "SELECT * FROM usuarios WHERE Correo='$correo'";
    $verificar_correo = $conectar->query($consulta_correo);
    if(mysqli_num_rows($verificar_correo)>0){

        //echo "<script>alert('Registro Incorrecto. El correo ya se encuentra registrado');location.href = '../pages/admin_create_user.php';</script>";
        echo json_encode("error3");
        // Cierre de conexion
        exit();
    }

    // Verificacion de login
    $consulta_login = "SELECT * FROM usuarios WHERE Login='$login'";
    $verificar_login = $conectar->query($consulta_login);
    if(mysqli_num_rows($verificar_login)>0){
        echo json_encode("error4");
        // Cierre de conexion
        exit();
    }


    // ===========================================
    //              REGISTRO EXITOSO
    // ===========================================
    try {
        $registrar = "INSERT INTO usuarios (Cedula_U, Nombre_U, Correo, Dependencia, TipoUsuario, Login, Contrasena, Estado) 
                            VALUES ('$numero_id','$nombre_usuario', '$correo', '$dependencia', '$tipo_us', '$login', '$pasw', 'ACTIVO')";
        $prueba = $conectar->query($registrar);
        
        if($prueba){
            //echo "<script> alert('Registro existoso');location.href = '../pages/admin_create_user.php';</script>";
            echo json_encode("success");
            exit();
        } else{
            //echo "<script> alert('Registro incorrecto');location.href = '../pages/admin_create_user.php';</script>";
            echo json_encode("error5");
            exit();
        }
    } catch (mysqli_sql_exception $e) {
        $error_message = $e->getMessage();
        // handle the error, such as displaying an error message to the user
        echo json_encode("error".$error_message);
        exit();
    }
?>