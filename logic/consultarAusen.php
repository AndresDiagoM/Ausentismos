<?php
    session_start();
    require("../conexion.php");

        //print_r($_POST); exit; para observar en el navegador con inspeccionar elemento

        $query_values = $_POST;
        $extra_query = " WHERE 1 "; //"WHERE Cancelled = 0";

        if($query_values)
        {
            $extra_query.= " AND ";
            $values = [];
            $queries = [];

            foreach($query_values as $field_name => $field_value)
            {
                foreach($field_value as $value)
                {
                    if($field_name=="Cedula_F"){  //Cedula_F LIKE '%5%'--> '%".$VAR."%'"
                        $values[$field_name][] = " {$field_name} LIKE '%".$value."%' ";
                    }elseif($field_name=="Fecha_Inicio"){
                        $values[$field_name][] = " {$field_name} > '{$value}'";
                    }else{
                        $values[$field_name][] = " {$field_name} = '{$value}'";
                    }                     
                }
            }
            //print_r($values); //exit;
            foreach($values as $field_name => $field_values)
            {
                $queries[$field_name] = "(".implode(" OR ", $field_values).")";
            }

            $extra_query.= " ".implode( " AND ", $queries );

            //print_r($extra_query); exit;
        }


        $sqli = "SELECT * FROM ausentismos INNER JOIN funcionarios ON ausentismos.Cedula_F=funcionarios.Cedula ".$extra_query;
        $sqli = "SELECT * FROM ausentismos INNER JOIN funcionarios ON ausentismos.Cedula_F=funcionarios.Cedula 
        INNER JOIN usuarios ON usuarios.Cedula_U = ausentismos.ID_Usuario ".$extra_query;
        $ausentismos = $conectar->query($sqli);  //print_r($sqli); exit;

        $ausen_list = [];

        while($ausentismo = $ausentismos->fetch_assoc()){
            $ausen_list[$ausentismo["ID"]]=$ausentismo;
            
            

            if($ausentismo["Tipo_Ausentismo"]==1){
                $replacement = array("Tipo_Ausentismo" => "INCAPACIDAD");

            }elseif($ausentismo["Tipo_Ausentismo"]==2){
                $replacement = array("Tipo_Ausentismo" => "COMPENSATORIO");

            }elseif($ausentismo["Tipo_Ausentismo"]==3){
                $replacement = array("Tipo_Ausentismo" => "PERMISO");

            }else{
                $replacement = array("Tipo_Ausentismo" => "LICENCIA");
            }

            $ausen_list[$ausentismo["ID"]] = array_replace($ausen_list[$ausentismo["ID"]], $replacement);
        }

        //print_r($ausen_list);  //en chrome hacer CTRL+U para ver mejor el arreglo
        
        $_SESSION['ausen_list'] = $sqli; //Para guardar el SQL query y usarlo con el boton de reporte para generar archivo excel 
        echo json_encode($ausen_list);
?>