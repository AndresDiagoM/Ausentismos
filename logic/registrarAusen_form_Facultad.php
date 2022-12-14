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
                            echo "<script> alert('No existe la cedula del funcionario'); location.href = '../pages/facultad_agregar.php';  </script>";          
                            exit; 
                        }else{
                            $row = mysqli_fetch_array($funcionarios);
                            //convertir el salario a numero int
                            $salario = (int) filter_var($row['Salario'], FILTER_SANITIZE_NUMBER_INT);
                            //$salario = $row['Salario'];
                        }

                    } elseif ($field_name == "Tipo_Ausentismo") {

                        if($value==""){
                            echo "<script> alert('Debe seleccionar el tipo de ausentismo'); location.href = '../pages/facultad_agregar.php';  </script>";          
                            exit;              
                        }

                    }  elseif ($field_name == "Tiempo"){ //pasar tiempo a numero int

                        $tiempo = (int) filter_var($value, FILTER_SANITIZE_NUMBER_INT);

                        //si el tiempo es mayor a 24 horas no se puede registrar
                        if($tiempo>24){
                            echo "<script> alert('El tiempo no puede ser mayor a 24 horas'); location.href = '../pages/facultad_agregar.php';  </script>";          
                            exit; 
                        }
                        
                    } elseif ($field_name == "Unidad") {  //calcular el costo de seguridad en el trabajo
                        if($value=="horas"){
                            $costo = ($salario/30)/24 * $tiempo;
                        }
                    }

                }                   
            }            
    }

    //================================================================================================
    //=========  comprobar que el tiempo de las fechas sea igual a la variable $tiempo
    //================================================================================================
    $fecha_inicio = $query_values['Fecha_Inicio'][0];
    $fecha_fin = $query_values['Fecha_Fin'][0];     
    $fecha1 = new DateTime($fecha_inicio);
    $fecha2 = new DateTime($fecha_fin);
    if($query_values['Unidad'][0]=="dias"){
        $dias = $fecha1->diff($fecha2);
        $dias = $dias->days + 1; //sumar el dia de inicio
        //echo 'Fecha Inicio: '.$fecha1->format("d-m-Y") .'<br>'.'Fecha Fin: '.$fecha2->format("d-m-Y").'<br>'.'DIAS: '.$dias.'<br>'; exit;
        if($dias != $tiempo){
            //echo 'NO IGUALES: dias:'.$dias.' tiempo:'.$tiempo.'<br>';
            //echo 'Fecha Inicio: '.$fecha1->format("d-m-Y") .'<br>'.'Fecha Fin: '.$fecha2->format("d-m-Y").'<br>'.'DIAS: '.$dias.'<br>'; exit;
            echo "<script> alert('El tiempo de las fechas no es igual al tiempo de la ausencia'); location.href = '../pages/facultad_agregar.php';  </script>";          
            exit; 
        }
    }else{
        $dias = $fecha1->diff($fecha2);
        $dias = $dias->days + 1; //sumar el dia de inicio
        if($dias != 1){
            //echo 'NO IGUALES: dias:'.$dias.' tiempo:'.$tiempo.'<br>';
            //echo 'Fecha Inicio: '.$fecha1->format("d-m-Y") .'<br>'.'Fecha Fin: '.$fecha2->format("d-m-Y").'<br>'.'DIAS: '.$dias.'<br>'; exit;
            echo "<script> alert('Las horas deben estar en el mismo d??a'); location.href = '../pages/facultad_agregar.php';  </script>";          
            exit; 
        }
    }

    //================================================================================================
    //=========  comprobar que si se escoge Unidad:horas, el tipo sea "permiso por horas"
    //================================================================================================
    $unidad = $query_values['Unidad'][0];
    $tipo = $query_values['Tipo_Ausentismo'][0];
    if($unidad=="horas" && $tipo!=5){
        echo "<script> alert('Si escoge Unidad: horas, el tipo de ausentismo debe ser permiso por horas'); location.href = '../pages/facultad_agregar.php';  </script>";          
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
        
        echo "<script> alert('Registro existoso.');   location.href = '../pages/facultad_agregar.php'; </script>";
        //header("Location: ../pages/facultad_agregar.php");
        
    }
    else{
        echo "<script> alert('Registro incorrecto');
        location.href = '../pages/facultad_agregar.php';
        </script>";
    }
?>