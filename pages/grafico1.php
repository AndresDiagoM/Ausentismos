<?php
    include '../conexion.php';

    // 2.GRAFICO 2 : Obtener numero de ausentismo de cada tipo de ausentismo del mes de marzo  
    //$sqli3 = "SELECT Tipo_Ausentismo, COUNT(*) FROM ausentismos WHERE MONTH(Fecha_Inicio) = 3 GROUP BY Tipo_Ausentismo;";
    
    $mesSQL=1;
    $sqli3 = "SELECT Tipo_Ausentismo, COUNT(*) as numeros, TipoAusentismo
        FROM ausentismos 
        INNER JOIN tipoausentismo ON ausentismos.Tipo_Ausentismo = tipoausentismo.ID
        WHERE MONTH(Fecha_Inicio) = '$mesSQL' AND Tipo_Ausentismo=tipoausentismo.ID
        GROUP BY Tipo_Ausentismo;";
    $numeros3 = $conectar->query($sqli3);  //print_r($numeros3);
    $datos3 = array();
    foreach ($numeros3 as $row3) {
        $datos3[] = $row3;
    }
?>
<script>    
    /*
     * Funciones para pintar los gráficos
        * Se utilizan funciones auxiliares definidas en app.js
     */
    Chart.defaults.color = '#000000'; //Color de las letras para todos los charts black color: #000000

    const monthsArray = <?php echo json_encode( $monthsArray); ?>;
    var meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
    //del array monthsArray cambiar los numeros de los meses por los nombres usando la var meses
    for (var i = 0; i < monthsArray.length; i++) {
        monthsArray[i].Mes = meses[monthsArray[i].Mes - 1];
    }
    const tiposArray = <?php echo json_encode( $datos3); ?>;

    const printCharts = () => {

        //console.log(monthsArray)
        renderMonthsChart(monthsArray)
        renderTiposChart(tiposArray)

        //para manejar los eventos de los botones de los charts
        enableEventHandlers()
    }

    const renderMonthsChart = array1 => {
        
        const monthsValues = array1.map(months => months.Ausentismos)        
        //mapear el valor Mes del array1 al mes correspondiente usando el arreglo meses
        const monthsLabels = array1.map(months => months.Mes)
        //console.log(monthsLabels)

        const data = {
            labels: monthsLabels, //[?php echo $meses; ?>], /*'January', 'February', 'March', 'April', 'May', 'June',*/
            datasets: [{
                data: monthsValues, // <php echo '[' . $mesesN . ']'; ?>, /*[5, 10, 5, 2, 20, 30, 45],*/
                borderColor: getDataColors(), //['#7448c2', '#21c0d7', '#d99e2b', '#cd3a81', '#9c99cc', '#e14eca'],
                backgroundColor: getDataColors(80),
                barThickness: 80,
                //barPercentage: 0.5,
                maxBarThickness: 100,
            }]
        }
        const options = {
            plugins: { //para que no se vea la leyenda
                legend: {
                    display: false
                }
            },
        }

        /* PARAMETROS DE Chart()
         *id del canvas donde se renderiza el chart y los datos
         */
        new Chart('monthsChart', {
            type: 'bar',
            data,
            options
        })
    }

    const renderTiposChart = array1 => {
        
        const tiposValues = array1.map(tipos => tipos['numeros'])
        const tiposLabels = array1.map(tipos => tipos.TipoAusentismo)
        //console.log(tiposLabels)

        const data = {
            labels: tiposLabels, 
            datasets: [{
                data: tiposValues, 
                borderColor: getDataColors(), 
                backgroundColor: getDataColors(70),
            }]
        }
        const options = {
            plugins: { 
                legend: {
                    display: true,
                    position: 'right',
                },                
            },            
        }

        new Chart('tiposChart', {
            type: 'doughnut',
            data,
            options
        })
    }


    printCharts()

</script>