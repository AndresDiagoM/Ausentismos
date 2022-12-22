<?php
    //Incluir archivo de conexión a la base de datos
    include '../conexion.php';

    //se recibe los valores enviados por peticiones ajax
    $query_values = $_POST;
    //print_r($query_values); //exit; // Array( [mes] => Febrero [value] => 2, cuando esta vacio es un Array ( )
    //echo $query_values['mes']; exit;

    $Year="";
    if(empty($query_values)){
        $mesSQL=1;

        //=======================  CONSULTAR AÑO ACTUAL   =======================
        $todayDate = new DateTime();
        $todayYear = $todayDate->format('Y');
        //$var = $todayDate->format('d-m-Y');
        //echo 'Fecha Hoy: '.$today->format('d-m-Y').'<br>';
        //imprimir año de la fecha
        //echo 'Año:'.$today->format('Y').'<br>';

        //=======================  CONSULTAR AÑOS DE LA TABLA AUSENTISMOS   =======================
        $sqlYears = "SELECT DISTINCT YEAR(Fecha_Inicio) AS year FROM ausentismos order by year desc";
        $resultYears = $conectar->query($sqlYears);
        //pasar los años a un array
        $yearsArray = array();
        while($row = mysqli_fetch_array($resultYears)){
            $yearsArray[] = $row['year'];
        }
        //print_r($yearsArray); exit;

        //comprobar que el año actual este en el array de años, si no esta, igualar todayYear al primer año del array
        if(!in_array($todayYear, $yearsArray)){
            $todayYear = $yearsArray[0];
        }

        //Generar slide de años para el select
        $statsOptions ="";
        foreach ($yearsArray as $key => $value) {
            if($value == $todayYear){
                $statsOptions.= "<option value='".$value."' selected='selected'>".$value."</option>";
            }else{
                $statsOptions.= "<option value='".$value."'>".$value."</option>";
            }
        }

        //=======================  CONSULTAR DATOS PARA GRAFICAS   =======================
        $estadisticas = getEstadisticas($conectar, $todayYear);
        $grafica1 = getDatosGrafico1($conectar, $todayYear,'%');
        $grafica2 = getDatosGrafico2($conectar, $mesSQL, $todayYear);
        $grafica3 = getDatosGrafico3($conectar, 1, $todayYear);
        $grafica4 = getDatosGrafico4($conectar, $todayYear, '%');
        echo json_encode(array(
            'statsOptions' => $statsOptions, 
            'estadisticas' => $estadisticas, 
            'grafica1' => $grafica1, 
            'grafica2' => $grafica2, 
            'grafica3' => $grafica3, 
            'grafica4' => $grafica4));
        exit;

    }elseif (isset($query_values['mes'])) { //cuando se selecciona un mes en el select de meses GRAFICA 2
        $mesSQL = $query_values['value'];
        $Year = $query_values['anio'];
        //print_r($query_values); //exit;

        $datos3 = getDatosGrafico2($conectar, $mesSQL, $Year);
        echo json_encode($datos3); exit;

    }elseif(isset($query_values['anio'])){ //cuando se selecciona un año en el select de años
        $Year = $query_values['value'];
        
        $estadisticas = getEstadisticas($conectar, $Year);
        $grafica1 = getDatosGrafico1($conectar, $Year,'%');
        $mesSQL=$grafica1['monthsArray'][0]['Mes'];

        $grafica2 = getDatosGrafico2($conectar, $mesSQL, $Year);
        $grafica3 = getDatosGrafico3($conectar, $mesSQL, $Year);
        $grafica4 = getDatosGrafico4($conectar, $Year, '%');
        echo json_encode(array(
            'estadisticas' => $estadisticas, 
            'grafica1' => $grafica1, 
            'grafica2' => $grafica2, 
            'grafica3' => $grafica3, 
            'grafica4' => $grafica4));
        exit;

    }elseif(isset($query_values['tipo'])){ //cuando se selecciona un tipo de ausentismo en el select de tipos GRAFICA 1
        $Year = $query_values['anioTipo'];
        $tipo = $query_values['value'];
        //print_r($query_values); exit;
        $grafica1 = getDatosGrafico1($conectar, $Year,$tipo);
        echo json_encode( $grafica1);
        exit;

    }elseif(isset($query_values['costo'])){ //cuando se selecciona un tipo de ausentismo en el select de tipos GRAFICA 4
        $Year = $query_values['anioCosto'];
        $tipo = $query_values['value'];
        //print_r($query_values); exit;
        $grafica4 = getDatosGrafico4($conectar, $Year,$tipo);
        echo json_encode( $grafica4);
        exit;
        
    }elseif(isset($query_values['depen'])){ //cuando se selecciona una dependencia en el select de dependencias GRAFICA 3
        $Year = $query_values['AnioDepen'];
        $dependencia = $query_values['value'];
        //print_r($query_values); exit;
        $grafica3 = getDatosGrafico3($conectar, $dependencia, $Year);
        echo json_encode( $grafica3);
        exit;
    }

    
    
    //=======================   FUNCION DE ESTADISTICAS   =======================
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
                        <div class='col-lg-2 col-md-4 d-flex stat my-2'>
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

        //get the number of ausentismos for MAS and FEM for the current year 
        $sqli = "SELECT COUNT(*) as numeros, Genero FROM ausentismos INNER JOIN funcionarios ON ausentismos.Cedula_F = funcionarios.Cedula WHERE YEAR(Fecha_Inicio) = $todayYear GROUP BY Genero;";
        $result = $conectar->query($sqli);
        $data = array();
        while($row = mysqli_fetch_array($result)){
            $data[] = $row;
        }
        foreach($data as $row){
            $div .= "
                    <div class='col-lg-1 col-md-4 d-flex stat my-2'>
                        <div class='mx-auto'>
                            <!-- para centrar el texto junto con d-flex-->";
            $div .= "       <h6 class='text-muted'>". $row['Genero'] ."</h6>";
            $div .= "       <h3 class='font-wight-bold'>".  $row['numeros'] ."</h3>";
            $div .= "       <h6 class='text-success'><i class='icon ion-md-arrow-dropup-circle'></i>".  round(($row['numeros']/$suma)*100, 2) ."%</h6>";
            $div .= "
                        </div>
                    </div>";
        }

        return ($div); // para id="estadisticas"
    }
    

    // =======================   GRAFICO 1   =======================
    // 1.GRAFICO 1 : Obtener numero de ausentismos por mes del año, con nombre de mes y numero de ausentismos, PARA EL AÑO ACTUAL
    function getDatosGrafico1($conectar, $todayYear, $tipo){ //SELECT MONTHNAME(Fecha_Inicio) da el nombre del mes en ingles

        //EJECUTAR LA CONSULTA EN LA BASE DE DATOS
        $consultaSQL = "SELECT MONTH(Fecha_Inicio) AS Mes, COUNT(*) AS Ausentismos FROM ausentismos 
                    WHERE YEAR(Fecha_Inicio) = $todayYear AND ausentismos.Tipo_Ausentismo LIKE '%".$tipo."%'
                    GROUP BY MONTH(Fecha_Inicio) 
                    ORDER BY MONTH(Fecha_Inicio) ASC;";
        //echo $sqli2; exit;
        $resultadoSQL = $conectar->query($consultaSQL);  //print_r($numeros2);

        /**
         * EL RESULTADO ES UNA TABLA ASI:
          *  Mes | Ausentismos
          *  1   |   89
          *  2   |   159
         * Con los mese donde se han registrado ausentismos
         */

        //CREAR EL ARREGLO DE MESES PARA EL SLIDER DEL GRAFICO 2, 
        $meses = [];        
        $monthsArray = array();
        //PASAR LOS DATOS DE LA CONSULTA SQL A UN ARREGLO PARA ENVIAR POR JSON, 
        //LOS DATOS EN EL ARREGLO $monthsArray[] SON LOS DATOS QUE SE MUESTRAN EN LA GRÁFICA 1
        while ($numero2 = $resultadoSQL->fetch_assoc()) {
            //echo "['".$numero['Tipo_Ausentismo']."',".$numero['COUNT(*)']."],";
            $monthsArray[] = $numero2;
            $meses[$numero2['Mes']] = $numero2['Mes'];   
        }

        //pasar los numeros del arreglo $meses a nombres de meses con array $NombreMeses
        $NombreMeses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
        foreach ($meses as $mes) {
            $meses[$mes] = $NombreMeses[$mes-1];
        }
        //print_r( $meses); exit;
        //echo $mesesN;

        //Crear slide HTML para mostrar en la gráfica 2
        $options = "";
        foreach((array) $meses as $key => $mes){        
            $options.= "<option value='$key'>  $mes </option>";  //para id="tiposChartOptions", gráfico doughnut
        }

        //consulta para llenar slide con los tipos de ausentismo DEL GRAFICO 1
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
    function getDatosGrafico2($conectar, $mesSQL, $todayYear){
        $consultaSQL = "SELECT Tipo_Ausentismo, COUNT(*) as numeros, TipoAusentismo
                    FROM ausentismos 
                    INNER JOIN tipoausentismo ON ausentismos.Tipo_Ausentismo = tipoausentismo.ID
                    WHERE MONTH(Fecha_Inicio) = '$mesSQL' AND Tipo_Ausentismo=tipoausentismo.ID AND YEAR(Fecha_Inicio) = $todayYear
                    GROUP BY Tipo_Ausentismo;"; //YEAR(CURDATE())
        //echo $consultaSQL; exit;
        $resultadoSQL = $conectar->query($consultaSQL);  //print_r($resultadoSQL);

        //PASAR LOS DATOS DE LA CONSULTA SQL A UN ARREGLO PARA ENVIAR POR JSON,
        $datos3 = array();
        foreach ($resultadoSQL as $row) {
            $datos3[] = $row;
        }
        //print_r($datos);
        //echo $datos[0]['numeros']; exit;
        return ($datos3);
    }

    // =======================   GRAFICO 3   =======================
    // 3.GRAFICO 3 : Obtener ausentismos de los funcionarios para una dependencia, para el año actual
    function getDatosGrafico3($conectar, $dependencia, $todayYear){
        $consultaSQL = "SELECT Cedula, COUNT(*) as Numeros, Nombre, Dependencia, Departamento, Facultad
                    FROM ausentismos 
                    INNER JOIN funcionarios ON ausentismos.Cedula_F = funcionarios.Cedula
                    INNER JOIN dependencias ON funcionarios.Dependencia = dependencias.ID
                    WHERE funcionarios.Dependencia = $dependencia AND YEAR(Fecha_Inicio) = $todayYear
                    GROUP BY Cedula
                    ORDER BY numeros DESC;"; //YEAR(CURDATE())
        //echo $consultaSQL; exit;
        $resultadoSQL = $conectar->query($consultaSQL);  //print_r($resultadoSQL);
        
        //PASAR LOS DATOS DE LA CONSULTA SQL A UN ARREGLO PARA ENVIAR POR JSON,
        $datos4 = array();
        foreach ($resultadoSQL as $row) {
            $datos4[] = $row;
        }
        //print_r($datos4); exit;
        //echo $datos[0]['numeros']; exit;

        //CONSULTA PARA LLENAR EL SLIDE CON LAS DEPENDENCIAS DEL GRAFICO 3
        $sql = "SELECT * FROM dependencias ORDER BY Departamento";
        $result = $conectar->query($sql);
        $dependencias = "<option class='small'  value='%'> SELECCIONE </option>";
        foreach ($result as $row) {
            //mostrar option con departemnto
            //$dependencias .= "<option class='small' value='".$row['ID']."'>  ".$row['Departamento']." </option>";
            $dependencias .= "<option value='".$row['ID']."'>  ".$row['Departamento']." - ".$row['Facultad']." </option>";
        }

        return (array("funcArray"=>$datos4, "dependencias"=>$dependencias));
    }

    // =======================   GRAFICO 4   =======================
    // 4.GRAFICO 4 : Obtener costo de ausentismo de los funcionarios en cada mes del año actual, el costo con 2 decimales
    function getDatosGrafico4($conectar, $todayYear, $tipo){
        $consultaSQL = "SELECT MONTH(Fecha_Inicio) AS Mes, SUM(ausentismos.Seguridad_Trabajo) AS Costo FROM ausentismos 
                WHERE YEAR(Fecha_Inicio) = $todayYear AND ausentismos.Tipo_Ausentismo LIKE '%".$tipo."%'
                GROUP BY MONTH(Fecha_Inicio) 
                ORDER BY MONTH(Fecha_Inicio) ASC;";
        //echo $consultaSQL; exit;
        $resultadoSQL = $conectar->query($consultaSQL);  //print_r($resultadoSQL);

        //PASAR LOS DATOS DE LA CONSULTA SQL A UN ARREGLO PARA ENVIAR POR JSON,
        $datos5 = array();
        foreach ($resultadoSQL as $row) {
            $datos5[] = $row;
        }
        
        //FORMATEAR LOS DATOS PARA QUE EL COSTO TENGA 2 DECIMALES
        $datos5 = array_map(function($item) {
            $item['Costo'] = number_format($item['Costo'], 2, '.', '');
            return $item;
        }, $datos5);
        //print_r($datos5); exit;
        /* ESTRUCTURA DE LOS DATOS:
            Mes	     Costo	
            1        36330410.1     
            2        83219591.3     
        */

        //consulta para llenar slide con los tipos de ausentismo, que estan en la tabla ausentismos para el año $todayYear
        $sqli3 = "SELECT DISTINCT Tipo_Ausentismo, TipoAusentismo FROM ausentismos 
            INNER JOIN tipoausentismo ON ausentismos.Tipo_Ausentismo = tipoausentismo.ID
            WHERE YEAR(Fecha_Inicio) = $todayYear AND Tipo_Ausentismo=tipoausentismo.ID
            ORDER BY Tipo_Ausentismo ASC;";
        $numeros3 = $conectar->query($sqli3);  //print_r($numeros2);
        $optionsCosto = "<option value='%'> TODOS </option>";   //para id="tiposMonthsOptions"
        while ($numero3 = $numeros3->fetch_assoc()) {
        //echo "['".$numero['Costo_Ausentismo']."',".$numero['COUNT(*)']."],";
        $optionsCosto .= "<option value='".$numero3['Tipo_Ausentismo']."'>  ".$numero3['TipoAusentismo']." </option>"; 
        }

        return (array("costoArray"=>$datos5, "optionsCosto"=>$optionsCosto));
    }
?>