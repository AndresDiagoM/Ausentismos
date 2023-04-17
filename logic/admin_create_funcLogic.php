<?php
    require '../conexion.php';

    //receive the data from the POST method
    $query_values = $_POST;

    //====================================================================
    //=====================  BUSCAR CEDULA  ==============================
    //if $_POST have cedula, then consult the database for the funcionario
    if(isset($_POST['cedula'])){
        $cedula = $_POST['cedula'];
        $consulta = "SELECT * FROM funcionarios WHERE Cedula='$cedula'";
        $resultado = $conectar->query($consulta);
        if(mysqli_num_rows($resultado)>0){
            $json = array();
            while($row = mysqli_fetch_array($resultado)){
                $json[] = array(
                    'nombre' => $row['Nombre'],
                    'cargo' => $row['Cargo'],
                    'dependencia' => $row['Dependencia'],
                    'genero' => $row['Genero'],
                    'salario' => $row['Salario'],
                    'eps' => $row['EPS'],
                    'arp' => $row['ARP'],
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

    $nombre_func    =   strtoupper($_POST['nomb_func']);
    $numero_id          =   strtoupper($_POST['numero_id']);
    $cargo       =   strtoupper($_POST['cargo']);
    $correo       =   strtoupper($_POST['correo']);
    $dependencia          =   strtoupper($_POST['dependencia']);
    $genero       =   strtoupper($_POST['genero']);
    $salario          =   strtoupper($_POST['salario']);
    $EPS      =   strtoupper($_POST['eps_func']);
    $ARP       =   strtoupper($_POST['arp_func']);

    //comprobar que ningun campo este vacio
    if(empty($nombre_func) || empty($numero_id) || empty($cargo) || empty($correo) || empty($dependencia) || empty($genero) || empty($salario) || empty($EPS) || empty($ARP)){
        //echo "<script> alert('Complete todos los campos');  location.href = '../pages/admin_create_func.php'; </script>";
        echo json_encode("error1");
        exit;
    }

    //verify anti sql injection for every variable
    $nombre_func =  $conectar->real_escape_string($nombre_func);
    $numero_id =  $conectar->real_escape_string($numero_id);
    $cargo =  $conectar->real_escape_string($cargo);
    $correo =  $conectar->real_escape_string($correo);
    $dependencia =  $conectar->real_escape_string($dependencia);
    $genero =  $conectar->real_escape_string($genero);
    $salario =  $conectar->real_escape_string($salario);
    $EPS =  $conectar->real_escape_string($EPS);
    $ARP =  $conectar->real_escape_string($ARP);

    // Verificacion de ID NO repetido
    $consulta_id = "SELECT * FROM funcionarios WHERE Cedula='$numero_id'";
    $verificar_id = $conectar->query($consulta_id);
    if(mysqli_num_rows($verificar_id)>0){

        //echo "<script> alert('Registro Incorrecto. La cedula ya se encuentra registrado'); location.href = '../pages/admin_create_func.php'; </script>";
        echo json_encode("error2");
        // Cierre de conexion
        exit();
    }


    // ===========================================
    //              REGISTRO EXITOSO
    // ===========================================

    $registrar = "INSERT INTO funcionarios (Cedula, Nombre, Cargo, Correo, Dependencia, Genero, Salario, Estado, EPS, ARP)) 
                        VALUES ('$numero_id', '$nombre_func', '$cargo', '$correo', '$dependencia', '$genero', '$salario', 'ACTIVO', '$EPS', '$ARP')";
    $prueba = mysqli_query($conectar, $registrar);
    if($prueba){
        //echo "<script> alert('Registro existoso'); location.href = '../pages/admin_create_func.php'; </script>";
        echo json_encode("success");
    }
    else{
        //echo "<script> alert('Registro incorrecto'); location.href = '../pages/admin_create_func.php'; </script>";
        echo json_encode("error3");
    }
    // Cierre de conexion
    $conectar->close();
    exit;
?>