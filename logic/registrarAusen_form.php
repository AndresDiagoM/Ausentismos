<?php
    /*  Hacer el registro de en MySQL de la ausencia del funcionario
        * Se realiza validaciones de los inputs del formulario
    */
    //session_start();
    require("../conexion.php");

    $query_values = $_POST; 
    //print_r($_POST); exit; 
    // Array ( [Nombre] => Array ( [0] => SALINAS BALCAZAR CESAR ANDRES ) [Cedula_F] => Array ( [0] => 4615890 ) [Cargo] => Array ( [0] => PROFESIONAL UNIVERSITARIO ) [Departamento] => 
    //  Array ( [0] => DECANATURA ) [Facultad] => Array ( [0] => FAC. DE CIENCIAS HUMANAS Y SOC ) [Fecha_Inicio] => Array ( [0] => 2022-10-16 ) [Fecha_Fin] => Array ( [0] => 2022-10-16 ) [Tiempo] => Array ( [0] => 20 ) [Observacion] => Array ( [0] => medico ) [Tipo_Ausentimo] => Array ( [0] => 1 ) [ID_Usuario] => Array ( [0] => 34327997 ) )
    
    $salario=0;
    $costo=0;
    $tiempo=0;
    $unidad = "";
    if($query_values)
    {
        $values = [];
        $queries = [];

        foreach($query_values as $field_name => $field_value)
        {
            foreach((array) $field_value as $value)
            {
                if ($field_name == "Cedula_F") {   //comprobar si la cedula existe en la tabla funcionarios

                    $sqli = "SELECT * FROM funcionarios WHERE Cedula='$value' ";
                    $funcionarios = $conectar->query($sqli);  //print_r($sqli); exit;
                    $var = mysqli_num_rows($funcionarios);                        
                    
                    if($var<=0){
                        //echo "<script> alert('No existe la cedula del funcionario'); location.href = '../pages/admin_agregar.php';  </script>";     
                        echo json_encode("error1");
                        exit; 
                    }else{
                        $row = mysqli_fetch_array($funcionarios);
                        //convertir el salario a numero int
                        $salario = (int) filter_var($row['Salario'], FILTER_SANITIZE_NUMBER_INT);
                        //$salario = $row['Salario'];
                    }

                } elseif($field_name == "Observacion"){

                    //Sanitizar el campo, eliminar caracteres especiales
                    $value = filter_var($value, FILTER_SANITIZE_STRING);

                    //Guardar el campo en mayusculas 
                    $query_values['Observacion'][0] = strtoupper($value);

                } elseif ($field_name == "Tipo_Ausentismo") {

                    if($value==""){
                        //echo "<script> alert('Debe seleccionar el tipo de ausentismo'); location.href = '../pages/admin_agregar.php';  </script>";
                        echo json_encode("error2");          
                        exit;              
                    }

                }  elseif ($field_name == "Tiempo"){ //pasar tiempo a numero float

                    //si se recibe un numero con coma, se cambia por punto
                    $value = str_replace(",", ".", $value);

                    //$tiempo = (int) filter_var($value, FILTER_SANITIZE_NUMBER_INT);
                    $tiempo = floatval($value);

                    //modificar query_values
                    $query_values['Tiempo'][0] = $tiempo;
                    
                } elseif ($field_name == "Unidad") {  //calcular el costo de seguridad en el trabajo
                    if($value=="dias"){
                        $unidad = "dias";
                    } else {
                        $unidad = "horas";
                    }
                    
                }
            }                   
        }            
    } 

    //Calcular el valor del costo, 
    if($unidad=="dias"){
        //hacer el calculo del costo, si es dias con ($slario/30)*$tiempo
        $costo = ($salario/30) * $tiempo;
        //echo 'salario: '.$salario.'<br>';
        //echo 'costo1: '.$costo.'<br>'.'tiempo: '.$tiempo.'<br>'.$value.'<br>'; 
    } else {
        $costo = ($salario/30)/24 * $tiempo;
    }


    //================================================================================================
    //=========  comprobar que el tiempo de las fechas sea igual o menor a la variable $tiempo
    //================================================================================================
    $fecha_inicio = $query_values['Fecha_Inicio'][0];
    $fecha_fin = $query_values['Fecha_Fin'][0];     
    $fecha1 = new DateTime($fecha_inicio);
    $fecha2 = new DateTime($fecha_fin);

    //calcular los dias entre las fechas
    $dias = $fecha1->diff($fecha2);
    $dias = $dias->days + 1; //sumar el dia de inicio

    //si fecha2 (fechaFin) es menor a fecha1, devolver error
    if($fecha2 < $fecha1){
        echo json_encode("errorTiempo");       
        exit; 
    }

    if($query_values['Unidad'][0]=="dias"){
        //echo 'Fecha Inicio: '.$fecha1->format("d-m-Y") .'<br>'.'Fecha Fin: '.$fecha2->format("d-m-Y").'<br>'.'DIAS: '.$dias.'<br>'; exit;
        if($tiempo > $dias || $tiempo==0){
            //echo 'NO IGUALES: dias:'.$dias.' tiempo:'.$tiempo.'<br>';
            //echo 'Fecha Inicio: '.$fecha1->format("d-m-Y") .'<br>'.'Fecha Fin: '.$fecha2->format("d-m-Y").'<br>'.'DIAS: '.$dias.'<br>'; exit;
            //echo "<script> alert('El tiempo de las fechas no es igual al tiempo de la ausencia'); location.href = '../pages/admin_agregar.php';  </script>";   
            echo json_encode("errorTiempo");       
            exit; 
        }
    }else{
        if($dias != 1){
            //echo 'NO IGUALES: dias:'.$dias.' tiempo:'.$tiempo.'<br>';
            //echo 'Fecha Inicio: '.$fecha1->format("d-m-Y") .'<br>'.'Fecha Fin: '.$fecha2->format("d-m-Y").'<br>'.'DIAS: '.$dias.'<br>'; exit;
            //echo "<script> alert('Las horas deben estar en el mismo día'); location.href = '../pages/admin_agregar.php';  </script>";   
            echo json_encode("error3");        
            exit; 
        }
    }

    //================================================================================================
    //=========  comprobar que si se escoge Unidad:horas, el tipo sea "permiso por horas"
    //================================================================================================
    $unidad = $query_values['Unidad'][0];
    $tipo = $query_values['Tipo_Ausentismo'][0];
    if($unidad=="horas" && $tipo!=5){
        //echo "<script> alert('Si escoge Unidad: horas, el tipo de ausentismo debe ser permiso por horas'); location.href = '../pages/admin_agregar.php';  </script>";    
        echo json_encode("error4");        
        exit; 
    }

    //================================================================================================
    //=========  comprobar que si se escoge el tipo "incapacidad", exista el codigo de incapacidad
    //================================================================================================
    $tipo = $query_values['Tipo_Ausentismo'][0];
    $codigo = $query_values['Codigo'][0];
    if($tipo==1 && $codigo==""){
        //echo "<script> alert('Si escoge el tipo de ausentismo: incapacidad, debe ingresar el codigo de incapacidad'); location.href = '../pages/admin_agregar.php';  </script>";  
        echo json_encode("error5");          
        exit; 
    }else{
        $sqlCodigo = "SELECT * FROM codigos WHERE Codigo='$codigo' ";
        $codigos = $conectar->query($sqlCodigo);  //print_r($sqli); exit;
        $var = mysqli_num_rows($codigos);
        if($tipo==1 && $var<=0){
            //echo "<script> alert('El codigo de incapacidad no existe'); location.href = '../pages/admin_agregar.php';  </script>";
            echo json_encode("error6"); 
            exit; 
        }
    }

    // ===========================================
    //              COMPROBAR QUE NO EXISTA UN REGISTRO DUPLICADO
    // ===========================================
    $sql = "SELECT * FROM ausentismos WHERE Cedula_F='".$query_values['Cedula_F'][0]."' AND Fecha_Inicio='".$query_values['Fecha_Inicio'][0]."' AND Fecha_Fin='".$query_values['Fecha_Fin'][0]."' AND Tiempo='".$query_values['Tiempo'][0]."' AND Unidad='".$query_values['Unidad'][0]."' AND Tipo_Ausentismo='".$query_values['Tipo_Ausentismo'][0]."' ";
    $resultado = $conectar->query($sql);  //print_r($sql); exit;

    //si el resultado es mayor a 0, es porque ya existe un registro con los mismos datos
    if(mysqli_num_rows($resultado)>0){
        //echo "<script> alert('El registro ya existe'); location.href = '../pages/admin_agregar.php';  </script>";
        echo json_encode("error8"); 
        exit; 
    }



    // ===========================================
    //              REGISTRO MySQL
    // ===========================================

    $registrar ="INSERT INTO ausentismos (Cedula_F, Fecha_Inicio, Fecha_Fin, Tiempo, Unidad, Observacion, Tipo_Ausentismo, ID_Usuario, Seguridad_Trabajo) VALUES 
    ('".$query_values['Cedula_F'][0]."', '".$query_values['Fecha_Inicio'][0]."', '".$query_values['Fecha_Fin'][0]."', '".$query_values['Tiempo'][0]."', '".$query_values['Unidad'][0]."', '".$query_values['Observacion'][0]."', '".$query_values['Tipo_Ausentismo'][0]."', '".$query_values['ID_Usuario'][0]."', '".$costo."')";
    //print_r($registrar); exit;

    $prueba = $conectar->query($registrar);
    if($prueba){
        //echo "<script> alert('Registro existoso');   location.href = '../pages/admin_agregar.php'; </script>";

        // ===========================================
        //              Registrar incapacidad
        // ===========================================
        if($tipo==1){
            //consultar el último ausentimso SELECT * FROM ausentismos WHERE ID = (SELECT MAX(ID) FROM ausentismos);
            $sql1 = "SELECT * FROM ausentismos WHERE ID = (SELECT MAX(ID) FROM ausentismos)";
            $resultado = $conectar->query($sql1);
            $rows = mysqli_fetch_array($resultado);

            $registrarIncapacidad ="INSERT INTO incapacidad (Codigo, Diagnostico, Entidad, ID_Ausentismo) VALUES 
            ('".$query_values['Codigo'][0]."', '".$query_values['Diagnostico'][0]."', '".$query_values['Entidad'][0]."', '".$rows['ID']."')";
            //print_r($registrarIncapacidad); exit;
            $pruebaIncapacidad = $conectar->query($registrarIncapacidad);
            if($pruebaIncapacidad){
                echo json_encode("success"); 
            }else{
                //echo "<script> alert('Error al registrar incapacidad');location.href = '../pages/admin_agregar.php';</script>";
                echo json_encode("error"); 
            }
        }else{
            //header("Location: ../pages/admin_agregar.php");
            //echo "<script> //alert('Registro existoso'); location.href = '../pages/admin_agregar.php?ALERT=success'; </script>";
            echo json_encode("success"); 
            exit;
        }
        
    }
    else{
        echo json_encode("error"); 
    }
    
?>