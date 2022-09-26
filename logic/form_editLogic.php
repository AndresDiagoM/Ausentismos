
<?php
    require '../conexion.php';

    $nombre_edt         =   strtoupper($_POST['nombre_usuario_edt']);
    $fecha_nac_edt      =   strtoupper($_POST['fecha_nac_edt']);
    $tipo_doc_edt       =   strtoupper($_POST['tipo_doc_edt']);
    $direccion_edt      =   strtoupper($_POST['direccion_edt']);
    $depart_edt         =   strtoupper($_POST['depart']);
    $munic_edt          =   strtoupper($_POST['munic']);
    $numero_id          =   $_GET['ID'];



    // CONSULTA DE DATOS DEL USUARIO ALMACENADOS EN LA BASE DE DATOS
    $consulta_id    = "SELECT * FROM users WHERE ID='$numero_id'";
    $verificar_id   = mysqli_query($conectar, $consulta_id);
    $row_us         = $verificar_id->fetch_array(MYSQLI_NUM);
    $nombre_bs      = $row_us[2];
    $fecha_nac_bs   = $row_us[3];
    $tipo_doc_bs    = $row_us[4];
    $direccion_bs   = $row_us[5];
    $depart_bs      = $row_us[6];
    $munic_bs       = $row_us[7];

     // SENTENCIAS SQL PARA LA CONSULTA DEL NOMBRE DEL DEPARTAMENTO
    $consulta_depart    = "SELECT * FROM departamentos WHERE ID_Depart = '$depart_edt'";
    $rslt_depart        = mysqli_query($conectar, $consulta_depart);
    $row1               = $rslt_depart->fetch_array(MYSQLI_NUM);
    $nomb_depart        = $row1[1] ;



    if($nombre_bs != $nombre_edt){
        $actualizar_nom = "UPDATE users SET NAME_LASTNAME = '$nombre_edt' WHERE ID = $numero_id";
        $sqli1          = mysqli_query($conectar, $actualizar_nom);
    }
    if($fecha_nac_bs != $fecha_nac_edt){
        $actualizar_fech = "UPDATE users SET DATE = '$fecha_nac_edt' WHERE ID = $numero_id";
        $sqli2          = mysqli_query($conectar, $actualizar_fech);
    }
    if($tipo_doc_bs != $tipo_doc_edt){
        $actualizar_tipo = "UPDATE users SET TYPE_ID = '$tipo_doc_edt' WHERE ID = $numero_id";
        $sqli3          = mysqli_query($conectar, $actualizar_tipo);
    }
    if($direccion_bs != $tipo_doc_edt){
        $actualizar_addr = "UPDATE users SET ADDRESS = '$direccion_edt' WHERE ID = $numero_id";
        $sqli4          = mysqli_query($conectar, $actualizar_addr);
    }
    if($depart_bs != $nomb_depart){
        $actualizar_depart = "UPDATE users SET DEPARTAMENTO = '$nomb_depart' WHERE ID = $numero_id";
        $sqli5          = mysqli_query($conectar, $actualizar_depart);
    }
    if($munic_bs != $munic_edt){
        $actualizar_munc = "UPDATE users SET MUNICIPIO = '$munic_edt' WHERE ID = $numero_id";
        $sqli1          = mysqli_query($conectar, $actualizar_munc);
    }

    echo "<script>
        alert('Datos Actualizados Correctamtne');
        location.href='../pages/admin_edition_client.php';
    </script>"









?>