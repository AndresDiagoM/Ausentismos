<?php
    require '../conexion.php';

    $query_values = $_POST;
    //print_r($query_values); exit;

    $numero_id = $_POST['eliminar_ausen']; //obtener el numero de ID del ausentismo
    //print_r($numero_id); exit;
    //verify anti sql injection 
    $numero_id =  $conectar->real_escape_string($numero_id);

    // CONSULTA DE DATOS DEL AUSENTISMO ALMACENADOS EN LA BASE DE DATOS
    $sqli   = "SELECT * FROM ausentismos WHERE ausentismos.ID = $numero_id";
    $result = $conectar->query($sqli);
    $ausentismo = mysqli_fetch_assoc($result);

    // Si el ausentismo es una incapacidad, entonces eliminar la incapacidad
    if($ausentismo['Tipo_Ausentismo'] == 1){
        $sqli = "DELETE FROM incapacidad WHERE incapacidad.ID_Ausentismo = $numero_id";
        $result = $conectar->query($sqli);

        //si es exitoso, entonces eliminar el ausentismo
        if($result){
            $sqli = "DELETE FROM ausentismos WHERE ausentismos.ID = $numero_id";
            $result = $conectar->query($sqli);
            if($result){
                echo json_encode("success");
                exit;
            }else{
                echo json_encode("error1");
                exit;
            }
        }else{
            echo json_encode("error2");
            exit;
        }
    }else{
        //si no es una incapacidad, entonces eliminar el ausentismo
        $sqli = "DELETE FROM ausentismos WHERE ausentismos.ID = $numero_id";
        $result = $conectar->query($sqli);
        if($result){
            echo json_encode("success");
            exit;
        }else{
            echo json_encode("error3");
            exit;
        }
    }
?>