<?php
    include "../conexion.php";

    session_start();
    $bandera = false;
    $autentication  = $_SESSION['TIPO_USUARIO'];
    $tipo_cliente   = $_SESSION['TIPO_USUARIO'];

    if (strtoupper($autentication) == 'ADMIN' || strtoupper($autentication) == 'CONSULTA' ){
        $bandera = true;
    }
    else{
        header('Location: ../pages/inicio_sesion.php?message=3');
    }


    $query_values = $_POST;
    $extra_query = " WHERE 1 "; //"WHERE Cancelled = 0";
    $pag=1;

    if($query_values)
    {
        $values = [];
        $queries = [];

        foreach($query_values as $field_name => $field_value)
        {
            foreach((array) $field_value as $value)
            {
                if($field_name=="Pagina"){
                    if($value=="" || $value=="<<"){
                        $pag = 1;
                    }else{
                        $pag = $value;
                    }
                }elseif($field_name=="Cedula"){
                    //convert $value to uppercase
                    $value = strtoupper($value);
                    //change spaces in $value to % for LIKE query
                    $value = str_replace(" ", "%", $value);
                    $values[$field_name][] = " {$field_name} LIKE '%".$value."%' ";
                } 
            }
        }
        //print_r($values); //exit;
        foreach($values as $field_name => $field_values)
        {
            $queries[$field_name] = "(".implode(" OR ", $field_values).")";
        }

        //si hay mas de un query, se concatenan con AND
        if(sizeof($queries) >= 1)
        {
            $extra_query .= " AND ".implode(" AND ", $queries);
        }else{
            $extra_query.= implode(" AND ", $queries);
        }


        //echo sizeof($queries);
        //print_r($extra_query); exit;
    }

    //PAGINACIÓN de resultados
    $limit=100;
    $offset=($pag-1)*$limit;

    $salida     = "";
    $queryTotal = "SELECT * FROM funcionarios 
                    INNER JOIN dependencias ON funcionarios.Dependencia=dependencias.ID ".$extra_query." ORDER BY Cedula ASC";
    //echo $queryTotal; exit;
    $resultadoTotal  = $conectar->query($queryTotal);  
    $total  = $resultadoTotal->num_rows;

    $sqli = "SELECT * FROM funcionarios 
        INNER JOIN dependencias ON funcionarios.Dependencia=dependencias.ID ".$extra_query;
    $sqli .= " ORDER BY Cedula ASC LIMIT $offset, $limit";  //echo $sqli; exit;
    $funcionarios = $conectar->query($sqli); 

    if($funcionarios->num_rows > 0){

            $salida.="<table class='table table-striped table-bordered table-hover table-condensed'>
                            <thead class='header-table thead-light'>
                                <tr>
                                    <th scope='col'>CEDULA        </th>
                                    <th scope='col'>NOMBRE        </th>
                                    <th scope='col'>CARGO        </th>
                                    <th scope='col'>DEPARTAMENTO    </th>
                                    <th scope='col'>FACULTAD    </th>
                                    <th scope='col'>GENERO  </th>
                                    <th scope='col'>SALARIO         </th>
                                    <th scope='col'>ESTADO         </th>
                                    <th scope='col'>EDITAR    </th>
                                </tr>
                            </thead>";

        while($fila = $funcionarios ->fetch_assoc()){
            $Id_fila = $fila['Cedula'];
            $salida.="<tr>
                        <td scope='row'>".$fila['Cedula']."      </td>
                        <td>".$fila['Nombre']."      </td>
                        <td>".$fila['Cargo']."      </td>
                        <td>".$fila['Departamento']."       </td>
                        <td>".$fila['Facultad']."       </td>
                        <td>".$fila['Genero']."       </td>
                        <td>".$fila['Salario']."        </td>
                        <td>".$fila['Estado']."        </td>
                        <td><a href='../pages/admin_func_form_edition.php?ID=$Id_fila' class='btn-edit'><img src='../images/edit2.png' class='img-edit'  style='width: 2rem;'></a></td>
                    </tr>";
        }
        $salida.="</table>";
    }else{
        $salida.="No se encontraron datos";
    }

    $json = array();
    $json['tabla'] = $salida;//array_values($ausen_list); //$data
    $json['total'] = $total;

    //Slider para no mostrar todos los botones de las páginas
    $totalpag = ceil($total/$limit); //ceil redondea el numero
    $slider = '<li class="page-item">';    
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

    echo json_encode($json);
    $conectar->close();
?>