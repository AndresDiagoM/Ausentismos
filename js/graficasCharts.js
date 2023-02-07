//Hace el llamado a graficos.php, donde se hace la consulta a la base de datos

let var1 = {};
$.ajax({
    method: "POST",
    url: "../logic/graficos.php",
    data: $.param(var1) ,
    success: function (response) {            
        const Data = JSON.parse(response);
        //console.log(Data);
        const statsOptions = Data.statsOptions;
        //console.log(statsOptions);
        document.getElementById('statsOptions').innerHTML = statsOptions;

        const estadisticas = Data.estadisticas;
        document.getElementById('estadisticas').innerHTML = estadisticas;

        const grafica1 = Data.grafica1;
        const grafica2 = Data.grafica2;
        const grafica3 = Data.grafica3;
        const grafica4 = Data.grafica4;


        Chart.defaults.color = '#000000'; //Color de las letras para todos los charts black color: #000000
        Chart.register(ChartDataLabels);
        //Chart.defaults.height = 1500; //Alto de los charts


        const printCharts = () => {

            //console.log(monthsArray)
            renderMonthsChart(grafica1)
            renderTiposChart(grafica2)  //daugnut
            renderFuncChart(grafica3)
            renderCostoChart(grafica4)

            //para manejar los eventos de los botones de los charts
            enableEventHandlers()
        }

        printCharts()
    }
}) 

/*
    * Funciones para pintar los gráficos
    * Se utilizan funciones auxiliares definidas en app.js
*/
const renderMonthsChart = (grafica1) => {

    document.getElementById('tiposChartOptions').innerHTML = grafica1.options;
    document.getElementById('tiposMonthsOptions').innerHTML = grafica1.optionsTipo;
    
    //pasar los meses de numeros a nombres
    const monthsArray = grafica1.monthsArray;
    var meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
    //del array monthsArray cambiar los numeros de los meses por los nombres usando la var meses
    for (var i = 0; i < monthsArray.length; i++) {
        monthsArray[i].Mes = meses[monthsArray[i].Mes - 1];
    }

    const monthsValues = monthsArray.map(months => months.Ausentismos)        
    //mapear el valor Mes del monthsArray al mes correspondiente usando el arreglo meses
    const monthsLabels = monthsArray.map(months => months.Mes)
    //console.log(monthsLabels)

    const data = {
        labels: monthsLabels, //[?php echo $meses; ?>], /*'January', 'February', 'March', 'April', 'May', 'June',*/
        datasets: [{
            data: monthsValues, // <php echo '[' . $mesesN . ']'; ?>, /*[5, 10, 5, 2, 20, 30, 45],*/
            borderColor: getDataColors(), //['#7448c2', '#21c0d7', '#d99e2b', '#cd3a81', '#9c99cc', '#e14eca'],
            backgroundColor: getDataColors(80),
            barThickness: 30,
            //barPercentage: 0.5,
            maxBarThickness: 100,
        }]
    }
    const options = {
        plugins: { //para que no se vea la leyenda
            legend: {
                display: false
            },
            datalabels: {
                display: false,
            },
        },
        maintainAspectRatio: false,
        responsive: true,
    }

    /**
     * @param {string} id
     * @param {string} type
     * @param {object} data
     * @param {object} options
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
    //console.table(array1)

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
        maintainAspectRatio: false,
        responsive: true,
    }

    new Chart('tiposChart', {
        type: 'doughnut',
        data,
        options
    })
}

const renderFuncChart = array1 => {
    /* ESTRUCTURA DE LOS DATOS:
    array1['dependencias'] = (<div class="col-12 col-md-6 col-lg-4">)
    array1['funcArray'] = (
        Cedula | Numeros | Nombre      | Dependencia | Departamento | Facultad	
        252525 | 1       | Juan Perez  | 20          | fiet         | ELECTRONICA
    */
    //console.table(array1)
    //obtener dependencias y llenar el select id="tiposDepenOptions"
    document.getElementById('tiposDepenOptions').innerHTML = array1.dependencias;

    //obtener funcArray y llenar el chart
    const funcArray = array1.funcArray; //console.table(funcArray)
    const funcValues = funcArray.map(func => func.Numeros)
    const funcLabels = funcArray.map(func => func.Nombre)
    //console.log(funcLabels)
    //console.log(funcValues)

    //if array1.funcArray.length > 0 then create the label 
    var depen = '';
    if (array1.funcArray.length > 0) {	
        depen = funcArray[0].Departamento + ' - ' + funcArray[0].Facultad
    }else{
        depen = 'No hay datos';
    }

    const data = {
        labels: funcLabels,
        datasets: [{
            data: funcValues,
            label: depen,
            borderColor: getDataColors(),
            backgroundColor: getDataColors(70),
        }]
    }

    const options = {
        plugins: {
            legend: {
                display: true,
            },
            datalabels: {
                display: false,
            },
        },
        maintainAspectRatio: false,
        responsive: true,
    }

    new Chart('funcChart', {
        type: 'bar',
        data,
        options
    })
}

const renderCostoChart = array => {
    /* ESTRUCTURA DE LOS DATOS:
        Mes	      Costo	
        1         36330410.05859375
        2         83219591.328125
    */

        //lenar slider de la grafica de costo
    document.getElementById('costoChartOptions').innerHTML = array.optionsCosto;

    const array1 = array.costoArray;
    const costoLabels = array1.map(valor => valor.Mes) //['1', '2', '3', '4', '5', '6', '7', '8', '9']
        var meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
        //cambiar numeros de los meses por los nombres usando el arreglo meses
        costoLabels.forEach((valor, indice) => {
            costoLabels[indice] = meses[valor - 1];
        })
        //console.log(costoLabels)

    const costoValues = array1.map(valor => valor.Costo) //[43, 32, 43, 32, 43, 32, 43, 32, 43]
    //mostrar el total de los costos, sumando los valores de costoValues, mostrar el valor en formato de moneda
    const costo = 'Costo total: '+costoValues.map(valor => parseInt(valor)).reduce((acumulador, valor) => acumulador + valor).toLocaleString('en-US', {style: 'currency', currency: 'USD'})
    document.getElementById('costoTotal').innerHTML = costo;
    document.getElementById('costoTotal1').innerHTML = costo;

    const data = {
        labels: costoLabels,
        datasets: [{
            data: costoValues,
            
            borderColor: getDataColors(0),
            backgroundColor: getDataColors(70),
            barThickness: 30,
        }]
    }

    const options = {
        plugins: {
            legend: {
                display: false,
            },
            datalabels: {
                display: false,
            },
        },
        maintainAspectRatio: false,
        responsive: true,
    }

    new Chart('costoChart', {
        type: 'bar',
        data,
        options
    })

}