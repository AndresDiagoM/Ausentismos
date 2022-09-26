<?php
    require '../conexion.php';

    $nombre_usuario     =   strtoupper($_POST['nomb_usuario']);
    $fecha_nacimiento   =   strtoupper($_POST['fecha_nac']);
    $tipo_documento     =   strtoupper($_POST['tipo_doc']);
    $numero_id          =   strtoupper($_POST['numero_id']);
    $tipo_usuario       =   strtoupper($_POST['tipo_us']);
    $direccion          =   strtoupper($_POST['direccion']);
    $departamento       =   strtoupper($_POST['depart']);
    $municipio          =   strtoupper($_POST['munic']);
    $telefono           =   strtoupper($_POST['tel']);
    $password           =   strtoupper($_POST['pasw']);

    if($numero_id==''){
        header('Location: ../pages/inicio_sesion.php');
    }

    if($tipo_usuario == 'AS_V'){
        $tipo_usuario = 'Asesor de ventas';
    }
    elseif($tipo_usuario == 'AS_T'){
        $tipo_usuario = 'Asesor Técnico';
    }
    else{
        $tipo_usuario = 'Admin';
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
    $consulta_tel = "SELECT * FROM users WHERE CELLPHONE='$telefono'";
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
    $consulta_depart    = "SELECT * FROM departamentos WHERE ID_Depart = '$departamento'";
    $rslt_depart        = mysqli_query($conectar, $consulta_depart);
    $row1               = $rslt_depart->fetch_array(MYSQLI_NUM);
    $nomb_depart        = $row1[1] ;

    $registrar = "INSERT INTO users (ID, NAME_LASTNAME, DATE, TYPE_ID, ADDRESS, DEPARTAMENTO, MUNICIPIO, CELLPHONE, PASSWORD, TIPO_USUARIO  ) VALUES ('$numero_id','$nombre_usuario', '$fecha_nacimiento', '$tipo_documento', '$direccion', '$nomb_depart', '$municipio', '$telefono', '$password', '$tipo_usuario')";
    $prueba = mysqli_query($conectar, $registrar);
    if($prueba){
        echo "<script> alert('Registro existoso');
        location.href = '../pages/admin_menu.php';
        </script>";
    }
    else{
        echo "<script> alert('Registro incorrecto');
        location.href = '../index.php';
        </script>";
    }


?>