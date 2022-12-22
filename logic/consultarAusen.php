<?php
    session_start();
    require("../conexion.php");    

    //OBTENER EL TIPO DE USUARIO QUE HACE LA CONSULTA
    $tipo_usuario = isset($_SESSION['TIPO_USUARIO']) ? $_SESSION['TIPO_USUARIO'] : null;
    $dependencia = isset($_SESSION['DEPENDENCIA']) ? $_SESSION['DEPENDENCIA'] : null;

        //print_r($_POST); exit; //para observar en el navegador con inspeccionar elemento

        $query_values = $_POST;
        $BuscarIncapacidad = false;

        //SI EL USUARIO EL FACULTAD, LIMITAR LA BUSQUEDA A LOS AUSENTISMOS DE LA FACULTAD
        if($tipo_usuario=="FACULTAD"){
            // donde las dependencias que tengan los 3 primeros numeros iguales a la dependencia del usuario $dependencia
            $dependencia = substr($dependencia, 0, 3);
            $extra_query = " WHERE dependencias.C_costo LIKE '%".$dependencia."%' ";
        }else{
            $extra_query = " WHERE 1 "; 
        }

        if($query_values)
        {
            $extra_query.= " AND ";
            $BUSCAR_CAMPOS = [];
            $queries = [];

            foreach($query_values as $field_name => $field_value)
            {
                foreach((array) $field_value as $value)
                {
                    if($field_name=="Cedula_F"){  //Cedula_F LIKE '%5%'--> '%".$VAR."%'"
                        $BUSCAR_CAMPOS[$field_name][] = " {$field_name} LIKE '%".$value."%' ";

                    }elseif($field_name=="Nombre"){
                        //convert $value to uppercase
                        $value = strtoupper($value);
                        //change spaces in $value to % for LIKE query
                        $value = str_replace(" ", "%", $value);
                        $BUSCAR_CAMPOS[$field_name][] = " {$field_name} LIKE '%".$value."%' ";

                    }elseif($field_name=="Tiempo"){

                        $BUSCAR_CAMPOS[$field_name][] = " {$field_name} LIKE '%".$value."%' ";

                    }elseif($field_name=="Codigo"){
                        //convert $value to uppercase
                        //$value = strtoupper($value);

                        //if $value is empty, then do not add to query, and delete Diagnostico from $query_values
                        if($value==""){
                            unset($query_values["Codigo"]);
                            //continue;
                        }else{
                            $BUSCAR_CAMPOS[$field_name][] = " {$field_name} LIKE '%".$value."%' ";
                            $BuscarIncapacidad = true;
                        }
                    
                    }elseif($field_name=="Diagnostico"){
                        //convert $value to uppercase
                        //$value = strtoupper($value);

                        //if $value is empty, then do not add to query, and delete Diagnostico from $query_values
                        if($value==""){
                            unset($query_values["Diagnostico"]);
                            //continue;
                        }else{
                            //change spaces in $value to % for LIKE query
                            $value = str_replace(" ", "%", $value);
                            $BUSCAR_CAMPOS[$field_name][] = " {$field_name} LIKE '%".$value."%' ";
                            $BuscarIncapacidad = true;
                        }
                    
                    }elseif($field_name=="Entidad"){
                        //convert $value to uppercase
                        //$value = strtoupper($value);

                        //if $value is empty, then do not add to query, and delete Diagnostico from $query_values
                        if($value==""){
                            unset($query_values["Entidad"]);
                            //continue;
                        }else{
                            //change spaces in $value to % for LIKE query
                            $value = str_replace(" ", "%", $value);
                            $BUSCAR_CAMPOS[$field_name][] = " {$field_name} LIKE '%".$value."%' ";
                            $BuscarIncapacidad = true;
                        }
                    
                    }elseif($field_name=="Fecha_Inicio"){
                        $BUSCAR_CAMPOS[$field_name][] = " {$field_name} > '{$value}'";

                    }elseif($field_name=="Fecha_Fin"){
                        $BUSCAR_CAMPOS[$field_name][] = " {$field_name} <= '{$value}'";

                    }elseif($field_name=="Pagina"){
                        if($value=="" || $value=="<<"){
                            $pag = 1;
                        }else{
                            $pag = $value;
                        }
                    }else{
                        $BUSCAR_CAMPOS[$field_name][] = " {$field_name} = '{$value}'";
                    }                     
                }
            }

            //print_r($values); //exit;
            foreach($BUSCAR_CAMPOS as $field_name => $field_values)
            {
                $queries[$field_name] = "(".implode(" OR ", $field_values).")";
            }

            $extra_query.= " ".implode( " AND ", $queries );

            //print_r($extra_query); exit;
        }

        //PAGINACIÓN DE RESULTADOS
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

        //SI LA BANDERA DE BuscarIncapacidad ES true, BSUCAR LA INCAPACIDAD QUE PERTENECE AL AUSENTIMSO
        if($BuscarIncapacidad==true){
            //consultar el número total de datos para el paginador
            $sqliTotal = "SELECT ausentismos.*, funcionarios.*, dependencias.ID as ID_depen, dependencias.C_costo as C_costo, usuarios.*, incapacidad.ID as ID_in, incapacidad.Codigo as Codigo, incapacidad.Diagnostico as Diagnostico, incapacidad.Entidad as Entidad
                        FROM incapacidad 
                        INNER JOIN ausentismos ON incapacidad.ID_Ausentismo=ausentismos.ID
                        INNER JOIN usuarios ON usuarios.Cedula_U = ausentismos.ID_Usuario
                        INNER JOIN funcionarios ON ausentismos.Cedula_F=funcionarios.Cedula 
                        INNER JOIN dependencias ON dependencias.ID = funcionarios.Dependencia ".$extra_query." ORDER BY Fecha_Inicio DESC";
            //print_r($sqliTotal); exit;
            $busquedaTotal = $conectar->query($sqliTotal); 
            $total=$busquedaTotal->num_rows;

            //Consulta para llenar la tabla de ausentimsos
            $sqli = "SELECT ausentismos.*, funcionarios.*, dependencias.ID as ID_depen, dependencias.C_costo as C_costo, usuarios.*, incapacidad.ID as ID_in, incapacidad.Codigo as Codigo, incapacidad.Diagnostico as Diagnostico, incapacidad.Entidad as Entidad
                    FROM incapacidad 
                    INNER JOIN ausentismos ON incapacidad.ID_Ausentismo=ausentismos.ID
                    INNER JOIN usuarios ON usuarios.Cedula_U = ausentismos.ID_Usuario
                    INNER JOIN funcionarios ON ausentismos.Cedula_F=funcionarios.Cedula 
                    INNER JOIN dependencias ON dependencias.ID = funcionarios.Dependencia ".$extra_query;
            $sqli .= " ORDER BY Fecha_Inicio DESC LIMIT $offset, $limit";
            $ausentismos = $conectar->query($sqli);  //print_r($sqli); exit;
            //SELECT * FROM ausentismos INNER JOIN funcionarios ON ausentismos.Cedula_F=funcionarios.Cedula INNER JOIN usuarios ON usuarios.Cedula_U = ausentismos.ID_Usuario WHERE 1 AND ( Cedula_F LIKE '%%' ) 
            //AND ( Fecha_Inicio > '2019-07-22') LIMIT 0, 100 //que muestre los primeros 100 registros
        }else{
            //consultar el número total de datos para el paginador
            $sqliTotal = "SELECT ausentismos.*, funcionarios.*, dependencias.ID as ID_depen, dependencias.C_costo as C_costo, usuarios.*, 
                COALESCE(incapacidad.ID, 'N/A') as ID_In, COALESCE(incapacidad.Codigo, 'N/A') as Codigo, COALESCE(incapacidad.Diagnostico, 'N/A') as Diagnostico, COALESCE(incapacidad.Entidad, 'N/A') as Entidad, COALESCE(incapacidad.ID_Ausentismo, 'N/A') as ID_Ausentismo
                FROM ausentismos 
                INNER JOIN funcionarios ON ausentismos.Cedula_F=funcionarios.Cedula 
                INNER JOIN dependencias ON dependencias.ID = funcionarios.Dependencia
                INNER JOIN usuarios ON usuarios.Cedula_U = ausentismos.ID_Usuario 
                LEFT JOIN incapacidad ON ausentismos.ID = incapacidad.ID_Ausentismo ".$extra_query." ORDER BY Fecha_Inicio DESC";
            //print_r($sqliTotal); exit;
            $busquedaTotal = $conectar->query($sqliTotal); 
            $total=$busquedaTotal->num_rows;

            //$sqli = "SELECT * FROM ausentismos INNER JOIN funcionarios ON ausentismos.Cedula_F=funcionarios.Cedula ".$extra_query;
            $sqli = "SELECT ausentismos.*, funcionarios.*, dependencias.ID as ID_depen, dependencias.C_costo as C_costo, usuarios.*, 
                COALESCE(incapacidad.ID, 'N/A') as ID_In, COALESCE(incapacidad.Codigo, 'N/A') as Codigo, COALESCE(incapacidad.Diagnostico, 'N/A') as Diagnostico, COALESCE(incapacidad.Entidad, 'N/A') as Entidad, COALESCE(incapacidad.ID_Ausentismo, 'N/A') as ID_Ausentismo
                FROM ausentismos 
                INNER JOIN funcionarios ON ausentismos.Cedula_F=funcionarios.Cedula 
                INNER JOIN dependencias ON dependencias.ID = funcionarios.Dependencia
                INNER JOIN usuarios ON usuarios.Cedula_U = ausentismos.ID_Usuario 
                LEFT JOIN incapacidad ON ausentismos.ID = incapacidad.ID_Ausentismo ".$extra_query;
            $sqli .= " ORDER BY Fecha_Inicio DESC LIMIT $offset, $limit";
            $ausentismos = $conectar->query($sqli);  //print_r($sqli); exit;
            
            //$numerofilas=$ausentismos->num_rows;
            //SELECT * FROM ausentismos INNER JOIN funcionarios ON ausentismos.Cedula_F=funcionarios.Cedula INNER JOIN usuarios ON usuarios.Cedula_U = ausentismos.ID_Usuario WHERE 1 AND ( Cedula_F LIKE '%%' ) 
            //AND ( Fecha_Inicio > '2019-07-22') LIMIT 0, 100 //que muestre los primeros 100 registros
        }

        //Convertir los datos de la cosulta en un array
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

            }elseif($ausentismo["Tipo_Ausentismo"]==4){
                $replacement = array("Tipo_Ausentismo" => "LICENCIA");
            }
            elseif($ausentismo["Tipo_Ausentismo"]==5){
                $replacement = array("Tipo_Ausentismo" => "PERMISO POR HORAS");
            }

            $ausen_list[$ausentismo["ID"]] = array_replace($ausen_list[$ausentismo["ID"]], $replacement);
        }

        //print_r($ausen_list); exit;

        $json = array();
        $json['tabla'] = $ausen_list;//array_values($ausen_list); //$data
        $json['total'] = $total;
        //print_r($json); exit;

        //print_r($ausen_list); exit;

        //Slider de los botones de las páginas
        $totalpag = ceil($total/$limit); //ceil redondea el numero
        $slider = '<li class="page-item">';
        //$slider .= '<input type="button" value="<<" class="btn btn-primary mr-3" id="btnAnterior">';
        //$slider . = "<a class='page-link' aria-label='Previous' href='?pag=1'> <span aria-hidden='true'>&laquo;</span> <span class='sr-only'>Previous</span> </a>";
        if ($pag == "1") {
            //$_GET["pag"] == "0";
            //echo  "";
            $slider.= "<input type='button' class='btn btn-primary mr-3' aria-label='Previous' value='<<'> </input>";
        } else {
            if ($pag > 1){
                $ant = $pag - 1;
                $slider.= "<input type='button' class='btn btn-primary mr-3' aria-label='Previous' value='<<'> </input>";
            }
            
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
        
        $_SESSION['ausen_list'] = $sqliTotal; //Para guardar el SQL query y usarlo con el boton de reporte para generar archivo excel 
        //add $_SESSION['TIPO_USUARIO']; to json if it is defined, else add null
        $json['tipo_usuario'] = $tipo_usuario;

        //Enviar los datos en formato JSON
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($json);
?>