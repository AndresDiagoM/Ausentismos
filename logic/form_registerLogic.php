 <?php

    // Registro de usuario en la base de datos. Especificamente en la tabla users
    require '../conexion.php';

    // Se reciben los datos del formulario
   $nombre_usuario  =   strtoupper($_POST['nombre_usuario']);
   $fecha_nac       =   strtoupper($_POST['fecha_nac']);
   $tipo_doc        =   strtoupper($_POST['tipo_doc']);
   $numero_id       =   strtoupper($_POST['numero_id']);
   $direccion       =   strtoupper($_POST['direccion']);
   $depart          =   strtoupper($_POST['depart']);
   $munic           =   strtoupper($_POST['munic']);
   $tel             =   strtoupper($_POST['tel']);
   $pasw            =   strtoupper($_POST['pasw']);

    if($numero_id==''){
            header('Location: ../pages/inicio_sesion.php');
    }

    // Verificacion de ID NO repetido
    $consulta_id = "SELECT * FROM users WHERE ID='$numero_id'";
    $verificar_id = mysqli_query($conectar, $consulta_id);
    if(mysqli_num_rows($verificar_id)>0){

        echo "<script>
            alert('Registro Incorrecto. El ID ya se encuentra registrado');
            location.href = '../pages/form_register.php';
        </script>";

        // Cierre de conexion
        exit();
    }

    // Verificacion de telefono
    $consulta_tel = "SELECT * FROM users WHERE CELLPHONE='$tel'";
    $verificar_tel = mysqli_query($conectar, $consulta_tel);
    if(mysqli_num_rows($verificar_tel)>0){

        echo "<script>
            alert('Registro Incorrecto. El numero de telefono ya se encuentra registrado');
            location.href = '../pages/form_register.php';
        </script>";

        // Cierre de conexion
        exit();
    }


    // ===========================================
    //              REGISTRO EXITOSO
    // ===========================================

    // SENTENCIAS SQL PARA LA CONSULTA DEL NOMBRE DEL DEPARTAMENTO
    $consulta_depart    = "SELECT * FROM departamentos WHERE ID_Depart = '$depart'";
    $rslt_depart        = mysqli_query($conectar, $consulta_depart);
    $row1               = $rslt_depart->fetch_array(MYSQLI_NUM);
    $nomb_depart        = $row1[1] ;

    $registrar = "INSERT INTO users (ID, NAME_LASTNAME, DATE, TYPE_ID, ADDRESS, DEPARTAMENTO, MUNICIPIO, CELLPHONE, PASSWORD, TIPO_USUARIO  ) VALUES ('$numero_id','$nombre_usuario', '$fecha_nac', '$tipo_doc', '$direccion', '$nomb_depart', '$munic', '$tel', '$pasw', 'Cliente')";
    $prueba = mysqli_query($conectar, $registrar);
    if($prueba){
        echo "<script> alert('Registro existoso');
        location.href = '../index.php';
        </script>";
    }
    else{
        echo "<script> alert('Registro incorrecto');
        location.href = '../index.php';
        </script>";
    }



?>