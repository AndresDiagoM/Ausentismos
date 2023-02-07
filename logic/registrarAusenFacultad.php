<?php
    /*  Para buscar el funcionario de forma dinámica cuando se escribe la cedula o nombre
        * registrarAusen.php es llamado por registrar.js, donde se detecta el evento keyup
    */
    session_start();
    require("../conexion.php");

    // Inicio o reanudacion de una sesion
    $nombre_admin   = $_SESSION['NOM_USUARIO'];
    $id_admin       = $_SESSION['ID_USUARIO'];
    $tipo_usuario   = $_SESSION['TIPO_USUARIO'];

    //consultar centro de costo del usuario logueado
    $sql = "SELECT * FROM usuarios INNER JOIN dependencias ON usuarios.Dependencia = dependencias.ID
            WHERE Cedula_U = $id_admin";
    $result = $conectar->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $centro_costo = $row['C_costo'];
        //obtener los 3 primeros caracteres del centro de costo
        $centro_costo = substr($centro_costo, 0, 3);
    }else{
        $centro_costo = "N/A";
    }

        //print_r($_POST); exit; // Array( [Nombre] => Array ( [0] => andres) [Cedula] => Array ( [0] => 1 ) ...)
        //para observar en el navegador con inspeccionar elemento

        $query_values = $_POST;  //Array( [Nombre] => Array ( [0] => andres) [Cedula] => Array ( [0] => 1 ) ...)
        $extra_query = " WHERE Estado='ACTIVO' "; //"WHERE Cancelled = 0";

        if($query_values)
        {
            $extra_query.= " AND ";
            $values = [];
            $queries = [];

            foreach($query_values as $field_name => $field_value)
            {
                foreach((array) $field_value as $value)
                {
                    if($field_name=="Cedula"){  //Cedula LIKE '%5%'--> '%".$VAR."%'"


                        //if values is empty or it has spaces then search as like
                        if($value == "" || strpos($value, ' ') !== false){
                            $values[$field_name][] = " {$field_name} LIKE '%".$value."%' "; 
                        }else{
                            $values[$field_name][] = " {$field_name} = '".$value."' ";
                        }
                        //echo $value;

                    }elseif($field_name=="Nombre"){
                        //convert $value to uppercase
                        $value = strtoupper($value);
                        //change spaces in $value to % for LIKE query
                        $value = str_replace(" ", "%", $value);
                        $values[$field_name][] = " {$field_name} LIKE '%".$value."%' ";
                    }else{
                        //$values[$field_name][] = " {$field_name} = '{$value}'";
                    }                     
                }
            }

            //print_r($values); exit;  //Array ( [Nombre] => Array ( [0] => Nombre LIKE '%andres%' ) [Cedula] => Array ( [0] => Cedula LIKE '%56%' )  ...)

            foreach($values as $field_name => $field_values)
            {
                $queries[$field_name] = "(".implode(" OR ", $field_values).")";
            }
            //print_r($queries); exit; //Array ( [Nombre] => ( Nombre LIKE '%andres%' ) [Cedula] => ( Cedula LIKE '%56%' )    ...)

            $extra_query.= " ".implode( " AND ", $queries );

            //print_r($extra_query); exit;   //WHERE 1 AND ( Nombre LIKE '%felipe%' ) AND ( Cedula LIKE '%55%' )
        }


        $sqli = "SELECT * FROM funcionarios 
                INNER JOIN dependencias ON funcionarios.Dependencia = dependencias.ID ".$extra_query." AND C_costo LIKE '%$centro_costo%' LIMIT 1 ";
        //print_r($sqli); exit;
        $funcionarios = $conectar->query($sqli); 

        $func_list = [];

        if($funcionarios->num_rows > 0)
        {
            while($funcionario = $funcionarios->fetch_assoc())
            {
                $func_list[] = $funcionario;
            }
        }else{
            $func_list[] = "N/A";
        }

        //print_r($func_list);  //en chrome hacer CTRL+U para ver mejor el arreglo
        echo json_encode($func_list);
?>