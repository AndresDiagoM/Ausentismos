<?php
    require '../conexion.php';

    $nombre_func    =   strtoupper($_POST['nomb_func']);
    $numero_id          =   strtoupper($_POST['numero_id']);
    $cargo       =   strtoupper($_POST['cargo']);
    $dependencia          =   strtoupper($_POST['dependencia']);
    $genero       =   strtoupper($_POST['genero']);
    $salario          =   strtoupper($_POST['salario']);

    //comprobar que ningun campo este vacio
    if(empty($nombre_func) || empty($numero_id) || empty($cargo) || empty($dependencia) || empty($genero) || empty($salario)){
        echo "<script> alert('Complete todos los campos');
        location.href = '../pages/admin_create_func.php';
        </script>";
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

        echo "<script>
            alert('Registro Incorrecto. La cedula ya se encuentra registrado');
            location.href = '../pages/admin_create_func.php';
        </script>";

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
        echo "<script> alert('Registro existoso');
        location.href = '../pages/admin_create_func.php';
        </script>";
    }
    else{
        echo "<script> alert('Registro incorrecto');
        location.href = '../pages/admin_create_func.php';
        </script>";
    }

?>