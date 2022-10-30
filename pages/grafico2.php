<?php
    include '../conexion.php';

    // 2.GRAFICO 2 : Obtener numero de ausentismo de cada tipo de ausentismo del mes de marzo  
    //$sqli3 = "SELECT Tipo_Ausentismo, COUNT(*) FROM ausentismos WHERE MONTH(Fecha_Inicio) = 3 GROUP BY Tipo_Ausentismo;";
    
    $query_values = $_POST;
    $mesSQL=1;
    if (isset($query_values)) {
        # code...
        $mesSQL = $query_values['value'];
        //print_r($query_values); //exit;
    }    
    
    $sqli3 = "SELECT Tipo_Ausentismo, COUNT(*) as numeros, TipoAusentismo
        FROM ausentismos 
        INNER JOIN tipoausentismo ON ausentismos.Tipo_Ausentismo = tipoausentismo.ID
        WHERE MONTH(Fecha_Inicio) = '$mesSQL' AND Tipo_Ausentismo=tipoausentismo.ID
        GROUP BY Tipo_Ausentismo;";
        //echo $sqli3; exit;
    $numeros3 = $conectar->query($sqli3);  //print_r($numeros3);
    $datos3 = array();
    foreach ($numeros3 as $row3) {
        $datos3[] = $row3;
    }
    echo json_encode($datos3);
?>