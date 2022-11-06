<?php
    include '../conexion.php';

    $query_values = $_POST;
    //print_r($query_values); //exit; // Array( [mes] => Febrero [value] => 2, cuandoo esta vacio Array ( )
    //echo $query_values['mes']; exit;
    $extra_query = " WHERE 1 "; //"WHERE Cancelled = 0";
    $Year="";
    if(empty($query_values)){
        $mesSQL=1;

        //=======================   FECHA ACTUAL   =======================
        $todayDate = new DateTime();
        $todayYear = $todayDate->format('Y');
        $var = $todayDate->format('d-m-Y');
        //echo 'Fecha Hoy: '.$today->format('d-m-Y').'<br>';
        //imprimir año de la fecha
        //echo 'Año:'.$today->format('Y').'<br>';
        $sqlYears = "SELECT DISTINCT YEAR(Fecha_Inicio) AS year FROM ausentismos";
        $resultYears = $conectar->query($sqlYears);
        $statsOptions ="";
        while($row = mysqli_fetch_array($resultYears)){  //para id="statsOptions"
            if($row['year'] == $todayYear){
                $statsOptions.= "<option value='".$row['year']."' selected='selected'>".$row['year']."</option>";
            }else{
                $statsOptions.= "<option value='".$row['year']."'>".$row['year']."</option>";
            }
        }

        $estadisticas = getEstadisticas($conectar, $todayYear);
        $grafica1 = getDatosGrafico1($conectar, $todayYear,'');
        $grafica2 = getDatosGrafico2($conectar, $mesSQL, $todayYear);
        $grafica3 = getDatosGrafico3($conectar, $todayYear);
        $grafica4 = getDatosGrafico4($conectar, $todayYear);
        echo json_encode(array(
            'statsOptions' => $statsOptions, 
            'estadisticas' => $estadisticas, 
            'grafica1' => $grafica1, 
            'grafica2' => $grafica2, 
            'grafica3' => $grafica3, 
            'grafica4' => $grafica4));
        exit;

    }elseif (isset($query_values['mes'])) {
        $mesSQL = $query_values['value'];
        $Year = $query_values['anio'];
        //print_r($query_values); //exit;

        $datos3 = getDatosGrafico2($conectar, $mesSQL, $Year);
        echo json_encode($datos3); exit;

    }elseif(isset($query_values['anio'])){
        $Year = $query_values['value'];
        $mesSQL=1;
        $estadisticas = getEstadisticas($conectar, $Year);
        $grafica1 = getDatosGrafico1($conectar, $Year,'%');
        $grafica2 = getDatosGrafico2($conectar, $mesSQL, $Year);
        echo json_encode(array('estadisticas' => $estadisticas, 'grafica1' => $grafica1, 'grafica2' => $grafica2));
        exit;

    }elseif(isset($query_values['tipo'])){
        $Year = $query_values['anioTipo'];
        $tipo = $query_values['value'];
        //print_r($query_values); exit;
        $grafica1 = getDatosGrafico1($conectar, $Year,$tipo);
        echo json_encode( $grafica1);
        exit;
    }

    
    
    //=======================   FUNCIONES DE ESTADISTICAS   =======================
    // ESTADISTICAS: Obtener numero de ausentismos de cada tipo para el año actual
    function getEstadisticas($conectar, $todayYear){
        $sqli = "SELECT Tipo_Ausentismo, COUNT(*) as numeros, TipoAusentismo
        FROM ausentismos 
        INNER JOIN tipoausentismo ON ausentismos.Tipo_Ausentismo = tipoausentismo.ID
        WHERE YEAR(Fecha_Inicio) = $todayYear AND Tipo_Ausentismo=tipoausentismo.ID
        GROUP BY Tipo_Ausentismo;"; //YEAR(CURDATE())
        //echo $sqli; exit;
        //$sqli = "SELECT Tipo_Ausentismo, COUNT(*) FROM ausentismos GROUP BY Tipo_Ausentismo ORDER BY COUNT(*) DESC;";
        $result = $conectar->query($sqli);
            $suma = 0;
            $data = array();
            while($row = mysqli_fetch_array($result)){
                $suma = $suma + $row['numeros'];
                $data[] = $row;
            }
            $div ="";
            foreach($data as $row){
                $div .= "
                        <div class='col-lg-3 col-md-6 d-flex stat my-3'>
                            <div class='mx-auto'>
                                <!-- para centrar el texto junto con d-flex-->";
                $div .= "       <h6 class='text-muted'>" .$row['TipoAusentismo']. "</h6>";
                $div .= "       <h3 class='font-wight-bold'>".  $row['numeros'] ."</h3>";
                $div .= "       <h6 class='text-success'><i class='icon ion-md-arrow-dropup-circle'></i>".  round(($row['numeros']/$suma)*100, 2) ."%</h6>";
                $div .= "
                            </div>
                        </div>";
            }
        //echo $div;
        //print_r($datos);
        //echo $datos[0]['numeros']; exit;
        return ($div); // para id="estadisticas"
    }
    

    // =======================   GRAFICO 1   =======================
    // 1.GRAFICO 1 : Obtener numero de ausentismos por mes del año, con nombre de mes y numero de ausentismos, PARA EL AÑO ACTUAL
    function getDatosGrafico1($conectar, $todayYear, $tipo){ //SELECT MONTHNAME(Fecha_Inicio) da el nombre del mes en ingles
        $sqli2 = "SELECT MONTH(Fecha_Inicio) AS Mes, COUNT(*) AS Ausentismos FROM ausentismos 
                    WHERE YEAR(Fecha_Inicio) = $todayYear AND ausentismos.Tipo_Ausentismo LIKE '%".$tipo."%'
                    GROUP BY MONTH(Fecha_Inicio) 
                    ORDER BY MONTH(Fecha_Inicio) ASC;";
        //echo $sqli2; exit;
        $numeros2 = $conectar->query($sqli2);  //print_r($numeros2);

        $NombreMeses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
        $meses = [];        
        $monthsArray = array();
        while ($numero2 = $numeros2->fetch_assoc()) {
            //echo "['".$numero['Tipo_Ausentismo']."',".$numero['COUNT(*)']."],";
            $monthsArray[] = $numero2;
            $meses[$numero2['Mes']] = $numero2['Mes'];   
        }
        //pasar los numeros del arreglo $meses a nombre con array $NombreMeses
        foreach ($meses as $mes) {
            $meses[$mes] = $NombreMeses[$mes-1];
        }
        //print_r( $meses); exit;
        //echo $mesesN;

        //LLenar el slide con los meses
        $options = "";
        foreach((array) $meses as $key => $mes){        
            $options.= "<option value='$key'>  $mes </option>";  //para id="tiposChartOptions"
        }

        //consulta parallenar slide con los tipos de ausentismo, que estan en la tabla ausentismos para el año $todayYear
        $sqli3 = "SELECT DISTINCT Tipo_Ausentismo, TipoAusentismo FROM ausentismos 
                    INNER JOIN tipoausentismo ON ausentismos.Tipo_Ausentismo = tipoausentismo.ID
                    WHERE YEAR(Fecha_Inicio) = $todayYear AND Tipo_Ausentismo=tipoausentismo.ID
                    ORDER BY Tipo_Ausentismo ASC;";
        $numeros3 = $conectar->query($sqli3);  //print_r($numeros2);
        $optionsTipo = "<option value='%'> TODOS </option>";   //para id="tiposMonthsOptions"
        while ($numero3 = $numeros3->fetch_assoc()) {
            //echo "['".$numero['Tipo_Ausentismo']."',".$numero['COUNT(*)']."],";
            $optionsTipo .= "<option value='".$numero3['Tipo_Ausentismo']."'>  ".$numero3['TipoAusentismo']." </option>"; 
        }

        return array('monthsArray'=>$monthsArray, 'options'=>$options, 'optionsTipo'=>$optionsTipo); 
    }
    
    // =======================   GRAFICO 2   =======================
    // 2.GRAFICO 2 : Obtener numero de ausentismo de cada tipo de ausentismo del mes de marzo  para el año actual    
    //$sqli3 = "SELECT Tipo_Ausentismo, COUNT(*) FROM ausentismos WHERE MONTH(Fecha_Inicio) = 3 GROUP BY Tipo_Ausentismo;";
    function getDatosGrafico2($conectar, $mesSQL, $todayYear){
        $sqli3 = "SELECT Tipo_Ausentismo, COUNT(*) as numeros, TipoAusentismo
        FROM ausentismos 
        INNER JOIN tipoausentismo ON ausentismos.Tipo_Ausentismo = tipoausentismo.ID
        WHERE MONTH(Fecha_Inicio) = '$mesSQL' AND Tipo_Ausentismo=tipoausentismo.ID AND YEAR(Fecha_Inicio) = $todayYear
        GROUP BY Tipo_Ausentismo;"; //YEAR(CURDATE())
        //echo $sqli3; exit;
        $numeros3 = $conectar->query($sqli3);  //print_r($numeros3);
        $datos3 = array();
        foreach ($numeros3 as $row) {
            $datos3[] = $row;
        }
        //print_r($datos);
        //echo $datos[0]['numeros']; exit;
        return ($datos3);
    }

    // =======================   GRAFICO 3   =======================
    // 3.GRAFICO 3 : Obtener numero de ausentismo por genero de funcionario en cada mes del año actual
    function getDatosGrafico3($conectar, $todayYear){
        $sqli4 = "SELECT MONTH(Fecha_Inicio) AS Mes, COUNT(*) AS Ausentismos, Genero FROM ausentismos 
                INNER JOIN funcionarios ON ausentismos.Cedula_F = funcionarios.Cedula
                WHERE YEAR(Fecha_Inicio) = $todayYear
                GROUP BY MONTH(Fecha_Inicio), Genero 
                ORDER BY MONTH(Fecha_Inicio) ASC;";
        //echo $sqli4; exit;
        $numeros4 = $conectar->query($sqli4);  //print_r($numeros4);
        $datos4 = array();
        foreach ($numeros4 as $row) {
            $datos4[] = $row;
        }
        //print_r($datos4);
        //echo $datos[0]['numeros']; exit;
        return ($datos4);
        /* ESTRUCTURA DE LOS DATOS:
            Mes	Ausentismos	Genero	
            1        43     FEM
            1        32     MAS
        */
    }

    // =======================   GRAFICO 4   =======================
    // 4.GRAFICO 4 : Obtener costo de ausentismo de los funcionarios en cada mes del año actual, el costo con 2 decimales
    function getDatosGrafico4($conectar, $todayYear){
        $sqli5 = "SELECT MONTH(Fecha_Inicio) AS Mes, SUM(ausentismos.Seguridad_Trabajo) AS Costo FROM ausentismos 
                WHERE YEAR(Fecha_Inicio) = $todayYear
                GROUP BY MONTH(Fecha_Inicio) 
                ORDER BY MONTH(Fecha_Inicio) ASC;";
        //echo $sqli5; exit;
        $numeros5 = $conectar->query($sqli5);  //print_r($numeros5);
        $datos5 = array();
        foreach ($numeros5 as $row) {
            $datos5[] = $row;
        }
        
        
        $datos5 = array_map(function($item) {
            $item['Costo'] = number_format($item['Costo'], 2, '.', '');
            return $item;
        }, $datos5);
        //print_r($datos5); exit;

        return ($datos5);
        /* ESTRUCTURA DE LOS DATOS:
            Mes	     Costo	
            1        36330410.1     
            2        83219591.3     
        */
    }
?>