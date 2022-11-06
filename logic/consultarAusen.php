<?php
    session_start();
    require("../conexion.php");    

        //print_r($_POST); exit; //para observar en el navegador con inspeccionar elemento

        $query_values = $_POST;
        $extra_query = " WHERE 1 "; //"WHERE Cancelled = 0";

        if($query_values)
        {
            $extra_query.= " AND ";
            $values = [];
            $queries = [];

            foreach($query_values as $field_name => $field_value)
            {
                foreach((array) $field_value as $value)
                {
                    if($field_name=="Cedula_F"){  //Cedula_F LIKE '%5%'--> '%".$VAR."%'"
                        $values[$field_name][] = " {$field_name} LIKE '%".$value."%' ";

                    }elseif($field_name=="Nombre"){
                        //convert $value to uppercase
                        $value = strtoupper($value);
                        //change spaces in $value to % for LIKE query
                        $value = str_replace(" ", "%", $value);
                        $values[$field_name][] = " {$field_name} LIKE '%".$value."%' ";

                    }elseif($field_name=="Fecha_Inicio"){
                        $values[$field_name][] = " {$field_name} > '{$value}'";

                    }elseif($field_name=="Pagina"){
                        if($value==""){
                            $pag = 1;
                        }else{
                            $pag = $value;
                        }
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

        //PAGINACIÓN de resultados
        $limit=100;
        //$pag = 1;
        /*if(isset($_GET['pag'])) {
            $pag = $_GET['pag'];
        } else {
            // set proper default value if it was not set
            $pag = 1;
        }
        if($pag<0){
            $pag=1;
        }*/
        $offset=($pag-1)*$limit;

        $sqliTotal = "SELECT * FROM ausentismos INNER JOIN funcionarios ON ausentismos.Cedula_F=funcionarios.Cedula 
        INNER JOIN usuarios ON usuarios.Cedula_U = ausentismos.ID_Usuario ".$extra_query." ORDER BY Fecha_Inicio DESC";
        //print_r($sqliTotal); exit;
        $busquedaTotal = $conectar->query($sqliTotal); 
        $total=$busquedaTotal->num_rows;

        //$sqli = "SELECT * FROM ausentismos INNER JOIN funcionarios ON ausentismos.Cedula_F=funcionarios.Cedula ".$extra_query;
        $sqli = "SELECT * FROM ausentismos INNER JOIN funcionarios ON ausentismos.Cedula_F=funcionarios.Cedula 
        INNER JOIN usuarios ON usuarios.Cedula_U = ausentismos.ID_Usuario ".$extra_query;
        $sqli .= " ORDER BY Fecha_Inicio DESC LIMIT $offset, $limit";
        $ausentismos = $conectar->query($sqli);  //print_r($sqli); exit;
        //SELECT * FROM ausentismos INNER JOIN funcionarios ON ausentismos.Cedula_F=funcionarios.Cedula INNER JOIN usuarios ON usuarios.Cedula_U = ausentismos.ID_Usuario WHERE 1 AND ( Cedula_F LIKE '%%' ) 
        //AND ( Fecha_Inicio > '2019-07-22') LIMIT 0, 100 //que muestre los primeros 100 registros

        $ausen_list = [];
        $data = array();
        while($ausentismo = $ausentismos->fetch_assoc()){
            $ausen_list[$ausentismo["ID"]]=$ausentismo;

            //Cambiar el numero de tipo ausen por el nombre
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
        
        //print_r($ausen_list); exit;
        $json = array();
        $json['tabla'] = $ausen_list;//array_values($ausen_list); //$data
        $json['total'] = $total;
        //print_r($json); exit;

        //print_r($ausen_list);  //en chrome hacer CTRL+U para ver mejor el arreglo

        //Agregar links de las páginas
        /*$botones = '';//'<tr><td class="text-center" colspan="10">';
        $totalpag = ceil($total/$limit); //ceil redondea el numero
        $links = array(); //creamos un array para guardar los links de las páginas
        for($i=1; $i<=$totalpag; $i++){
            //$links[] = '<a  href="admin_consultar.php?pag='.$i.'" class="btn btn-primary">'.$i.'</a>';
            //style="border:solid 1px blue; padding-left:.6%; padding-right:.6%; padding-top:.25%; padding-bottom:.25%;"
            $links[] = '<li><input type="button" style="margin-top:1rem"  value="'.$i.'" class="btn btn-primary mr-3 "></li>';
        }
        $botones .= implode(" ", $links);
        //$botones .= ' </td> </tr>';
        $json['botones'] = $botones; */


        //Slider para no mostrar todos los botones de las páginas
        $totalpag = ceil($total/$limit); //ceil redondea el numero
        $slider = '<li class="page-item">';
        if ($pag == "1") {
            //$_GET["pag"] == "0";
            //echo  "";
        } else {
            if ($pag > 1)
                $ant = $pag - 1;
            if($pag != "2"){
                $slider.= "<input type='button' class='btn btn-primary mr-3' aria-label='Previous' value='1'>  </input>";
            }            
            $slider.= "<li class='page-item '><input type='button' class='btn btn-primary mr-3' value='" . ($pag - 1) . "' >  </input></li>";
        }
        $slider.= "<li class='page-item active'><input type='button' class='btn btn-primary mr-3' value='$pag' >  </input></li>";
        $sigui = $pag + 1;
        $ultima = $total / $limit;
        if ($ultima == $pag + 1) {
            $ultima == "";
        }
        if ($pag < $totalpag && $totalpag > 1)
            $slider.= "<li class='page-item'><input type='button' class='btn btn-primary mr-3' value='" . ($pag + 1) . "'> </input></li>";
        if ($pag < $totalpag && $totalpag > 1 && ceil($ultima) != $pag + 1) 
            $slider.= "<li class='page-item'>
                            <input type='button' class='btn btn-primary mr-3' aria-label='Next' value='" . ceil($ultima) . "'>
                                
                            </input>
                        </li>";
        $json['slider'] = $slider;
        
        $_SESSION['ausen_list'] = $sqli; //Para guardar el SQL query y usarlo con el boton de reporte para generar archivo excel 
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($json);
?>