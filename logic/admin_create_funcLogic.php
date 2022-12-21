<?php
    require '../conexion.php';

    //receive the data from the POST method
    $query_values = $_POST;

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
                    'salario' => $row['Salario']
                );
            }
            $jsonstring = json_encode($json[0]);
            echo $jsonstring;
        }else{
            echo "error";
        }
        exit;
    }
    //print_r($query_values); exit;

    $nombre_func    =   strtoupper($_POST['nomb_func']);
    $numero_id          =   strtoupper($_POST['numero_id']);
    $cargo       =   strtoupper($_POST['cargo']);
    $dependencia          =   strtoupper($_POST['dependencia']);
    $genero       =   strtoupper($_POST['genero']);
    $salario          =   strtoupper($_POST['salario']);

    //comprobar que ningun campo este vacio
    if(empty($nombre_func) || empty($numero_id) || empty($cargo) || empty($dependencia) || empty($genero) || empty($salario)){
        //echo "<script> alert('Complete todos los campos');  location.href = '../pages/admin_create_func.php'; </script>";
        echo "error1";
        exit;
    }

    //verify anti sql injection for every variable
    $nombre_func =  $conectar->real_escape_string($nombre_func);
    $numero_id =  $conectar->real_escape_string($numero_id);
    $cargo =  $conectar->real_escape_string($cargo);
    $dependencia =  $conectar->real_escape_string($dependencia);
    $genero =  $conectar->real_escape_string($genero);
    $salario =  $conectar->real_escape_string($salario);
    

    // Verificacion de ID NO repetido
    $consulta_id = "SELECT * FROM funcionarios WHERE Cedula='$numero_id'";
    $verificar_id = $conectar->query($consulta_id);
    if(mysqli_num_rows($verificar_id)>0){

        //echo "<script> alert('Registro Incorrecto. La cedula ya se encuentra registrado'); location.href = '../pages/admin_create_func.php'; </script>";
        echo "error2";
        // Cierre de conexion
        exit();
    }


    // ===========================================
    //              REGISTRO EXITOSO
    // ===========================================

    $registrar = "INSERT INTO funcionarios (Cedula, Nombre, Cargo, Dependencia, Genero, Salario, Estado) 
                        VALUES ('$numero_id', '$nombre_func', '$cargo', '$dependencia', '$genero', '$salario', 'ACTIVO')";
    $prueba = mysqli_query($conectar, $registrar);
    if($prueba){
        //echo "<script> alert('Registro existoso'); location.href = '../pages/admin_create_func.php'; </script>";
        echo "success1";
    }
    else{
        //echo "<script> alert('Registro incorrecto'); location.href = '../pages/admin_create_func.php'; </script>";
        echo "error3";
    }
    // Cierre de conexion
    $conectar->close();
    exit;
?>