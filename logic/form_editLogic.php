
<?php
    require '../conexion.php';

    //$nombre_edt         =   strtoupper($_POST['nombre_usuario_edt']);
    $query_values = $_POST;
    //print_r($query_values); exit;

    $numero_id = $_POST['cedula_u'];
    //print_r($numero_id); exit;

    // CONSULTA DE DATOS DEL USUARIO ALMACENADOS EN LA BASE DE DATOS
    $sql = "SELECT * FROM usuarios WHERE Cedula_U = '$numero_id'";
    $result = $conectar->query($sql);
    $usuario_bd = mysqli_fetch_assoc($result);

    // if there is no result, show an alert and redirect to the form
    if($result->num_rows == 0){
        echo json_encode("error"); exit;
    }


    /*// SENTENCIAS SQL PARA LA CONSULTA DE la dependencia, donde el departamento es igual al departamento y la facultad es igual a la facultad 
    $sql2 = "SELECT * FROM dependencias WHERE Departamento LIKE "."'".$query_values['departamento_usuario_edt']."'"." AND Facultad LIKE "."'".$query_values['facultad_usuario_edt']."'";
    //print_r($sql2); exit;
    $result2 = $conectar->query($sql2); 
    //si no hay resultados, mostrar una alerta de que no hay resultados
    if($result2->num_rows == 0){
        echo "<script>alert('No existe la dependencia seleccionada.'); location.href = '../pages/admin_form_edition.php'; </script>"; exit;
    }else{
        //si hay resultados, guardar el resultado 
        $row2 = mysqli_fetch_assoc($result2);
    }*/

    // verificar que ningun campo de $query_values esté vacio, y que ningun campo tenga SQL inyection
    foreach($query_values as $key => $value){
        if(empty($value)){
            //echo "<script>alert('No se permiten campos vacios.'); location.href = '../pages/admin_func_form_edition.php?ID=$numero_id'; </script>"; exit;
            echo json_encode("error1"); exit;
        }
        if(!preg_match("/^[a-zA-Z0-9 .@]*$/", $value)){
            //echo "<script>alert('No se permiten caracteres especiales.'); location.href = '../pages/admin_func_form_edition.php?ID=$numero_id'; </script>"; exit;
            echo json_encode("error2"); exit;
        }
        //echo $key . " => " . $value . "<br>";
    }

    // convertir los campos de Nombre y login a mayusculas
    $query_values['Nombre_U'] = strtoupper($query_values['Nombre_U']);
    $query_values['Login'] = strtoupper($query_values['Login']);

    //Comprobar que las contraseñas coincidan
    if($query_values['Contrasena'] != $query_values['Contrasena2']){
        //echo "<script>alert('Las contraseñas no coinciden.'); location.href = '../pages/admin_func_form_edition.php?ID=$numero_id'; </script>"; exit;
        echo json_encode("error3"); exit;
    }

    //Actualizar los datos del usuario cuando sea diferente a los datos almacenados en la base de datos
    foreach ($query_values as $key => $value) {
        //Actualizar los datos del usuario cuando sea diferente a los datos almacenados en la base de datos
        if($key!='Contrasena' && $key!='Contrasena2' && $key!='cedula_u'){
            if($query_values[$key] != $usuario_bd[$key]){
                $actualizar = "UPDATE usuarios SET $key = '".$query_values[$key]."' WHERE Cedula_U = $numero_id";
                $sqli1          = $conectar->query($actualizar);
            }
        } else if($key=='Contrasena'){
            if($query_values[$key] != $usuario_bd[$key]){
                $contrasena_edt = $query_values['Contrasena'];
                //PASAR CONTRASEÑA A MD5
                $contrasena_edt = md5($contrasena_edt);
                $actualizar = "UPDATE usuarios SET $key = '$contrasena_edt' WHERE Cedula_U = $numero_id";
                $sqli1          = $conectar->query($actualizar);
            }
        }
    }


    //echo "<script>alert('Datos Actualizados Correctamtne');location.href='../pages/admin_edition_client.php';</script>"
    echo json_encode("success"); exit;
?>