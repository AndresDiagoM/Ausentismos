<?php
    /*  Hacer el registro de en MySQL de la ausencia del funcionario
        * Se realiza validaciones de los inputs del formulario
    */
    //session_start();
    require("../conexion.php");

    $query_values = $_POST; 
    //print_r($_POST); exit; // Array ( [Nombre] => Array ( [0] => SALINAS BALCAZAR CESAR ANDRES ) [Cedula_F] => Array ( [0] => 4615890 ) [Cargo] => Array ( [0] => PROFESIONAL UNIVERSITARIO ) [Departamento] => 
    //  Array ( [0] => DECANATURA ) [Facultad] => Array ( [0] => FAC. DE CIENCIAS HUMANAS Y SOC ) [Fecha_Inicio] => Array ( [0] => 2022-10-16 ) [Fecha_Fin] => Array ( [0] => 2022-10-16 ) [Tiempo] => Array ( [0] => 20 ) [Observacion] => Array ( [0] => medico ) [Tipo_Ausentimo] => Array ( [0] => 1 ) [ID_Usuario] => Array ( [0] => 34327997 ) )
    

    if($query_values)
    {
            $values = [];
            $queries = [];

            foreach($query_values as $field_name => $field_value)
            {
                foreach((array) $field_value as $value)
                {
                    if ($field_name == "Cedula_F") {  

                        $sqli = "SELECT * FROM funcionarios WHERE Cedula='$value' ";
                        $funcionarios = $conectar->query($sqli);  //print_r($sqli); exit;
                        $var = mysqli_num_rows($funcionarios);                        
                        
                        if($var<=0){
                            echo "<script> alert('No existe la cedula del funcionario'); location.href = '../pages/admin_agregar.php';  </script>";          
                            exit; 
                        }

                    } elseif ($field_name == "Tipo_Ausentismo") {

                        if($value==""){
                            echo "<script> alert('Debe seleccionar el tipo de ausentismo'); location.href = '../pages/admin_agregar.php';  </script>";          
                            exit;              
                        }

                    }  

                }                   
            }            
    }

    // ===========================================
    //              REGISTRO MySQL
    // ===========================================

    $registrar ="INSERT INTO ausentismos (Cedula_F, Fecha_Inicio, Fecha_Fin, Tiempo, Observacion, Tipo_Ausentismo, ID_Usuario, Seguridad_Trabajo) VALUES 
    ('".$query_values['Cedula_F'][0]."', '".$query_values['Fecha_Inicio'][0]."', '".$query_values['Fecha_Fin'][0]."', '".$query_values['Tiempo'][0]."', '".$query_values['Observacion'][0]."', '".$query_values['Tipo_Ausentismo'][0]."', '".$query_values['ID_Usuario'][0]."', 0)";
    //print_r($registrar); exit;

    $prueba = mysqli_query($conectar, $registrar);
    if($prueba){
        //echo "<script> alert('Registro existoso');   location.href = '../pages/admin_agregar.php'; </script>";
        header("Location: ../pages/admin_agregar.php");
    }
    else{
        echo "<script> alert('Registro incorrecto');
        location.href = '../pages/admin_agregar.php';
        </script>";
    }
?>