<?php
    /*  Para buscar el funcionario de forma dinámica cuando se escribe la cedula o nombre
        * registrarAusen.php es llamado por registrar.js, donde se detecta el evento keyup
    */
    //session_start();
    require("../conexion.php");

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
                        $values[$field_name][] = " {$field_name} LIKE '%".$value."%' ";
                    }elseif($field_name=="Nombre"){
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
                INNER JOIN dependencias ON funcionarios.Dependencia = dependencias.ID ".$extra_query." LIMIT 1 ";
        $funcionarios = $conectar->query($sqli);  //print_r($sqli); exit;

        $func_list = [];

        while($funcionario = $funcionarios->fetch_assoc()){

            $func_list[$funcionario["Cedula"]]=$funcionario;
        }

        //print_r($func_list);  //en chrome hacer CTRL+U para ver mejor el arreglo
        
        //$_SESSION['func_list'] = $sqli; //Para guardar el SQL query y usarlo con el boton de reporte para generar archivo excel 
        echo json_encode($func_list);
?>