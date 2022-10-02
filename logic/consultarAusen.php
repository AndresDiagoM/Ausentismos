<?php
    require("../conexion.php");

        $sqli = "SELECT * FROM ausentismos";
        $ausentismos = $conectar->query($sqli);  //print_r($ausentismos);

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
        echo json_encode($ausen_list);
?>