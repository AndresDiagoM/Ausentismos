/**
  * Esta funcion controla los eventos de los sliders de las graficas
*/
const enableEventHandlers = () => {

  // Slider de años de las estadisticas
  document.querySelector('#statsOptions').onchange = e => {

    //obtener 
    const {
        value: number,
        text: label
    } = e.target.selectedOptions[0]
    //console.log(number, label)

    let var1 = {anio: label, value: number}; //anio como año

    $.ajax({
      method: "POST",
      url: "../logic/graficos.php",
      data: $.param(var1),
      success: function (response) {
        const Data = JSON.parse(response);
        //console.log(Data);

        const estadisticas = Data.estadisticas;
        document.getElementById('estadisticas').innerHTML = "";
        document.getElementById('estadisticas').innerHTML = estadisticas;

        const grafica1 = Data.grafica1;
        const grafica2 = Data.grafica2;
        const grafica3 = Data.grafica3;
        const grafica4 = Data.grafica4;

        //Grafica 1
        document.getElementById('tiposChartOptions').innerHTML = grafica1.options;
        //actualizar el slider de meses
        document.getElementById('tiposMonthsOptions').innerHTML = grafica1.optionsTipo;
        const array1 = grafica1.monthsArray;
        var meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
        //del array monthsArray cambiar los numeros de los meses por los nombres usando la var meses
        for (var i = 0; i < array1.length; i++) {
            array1[i].Mes = meses[array1[i].Mes - 1];
        }
        const monthsValues = array1.map(months => months.Ausentismos)        
        //mapear el valor Mes del array1 al mes correspondiente usando el arreglo meses
        const monthsLabels = array1.map(months => months.Mes)
        updateChartDataAndLabels('monthsChart', monthsValues, monthsLabels)

        //Grafica 2
        const newDatos = grafica2.map(valores => valores.numeros); //console.log(newDatos);
        const newLabels = grafica2.map(valores => valores.TipoAusentismo);
        updateChartDataAndLabels('tiposChart', newDatos, newLabels)

        //Grafica 3
        const chart3 = Chart.getChart("funcChart");
        if(chart3 != null){
          chart3.destroy();
        }
        renderFuncChart(grafica3);
        
        //Grafica 4
        const chart4 = Chart.getChart("costoChart");
        if(chart4 != null){
          chart4.destroy();
        }
        renderCostoChart(grafica4)
      }
    })      
    //const newData = coasters.map(coaster => coaster[property])
    //updateChartData('featuresChart', newData, label)
  }

  // Slider de tipo ausen de grafico de barra - GRAFICO 1
  document.querySelector('#tiposMonthsOptions').onchange = e => {
    const {
        value: number,
        text: label
    } = e.target.selectedOptions[0]
    //console.log(number, label)

    let var1 = {tipo: label, value: number};
    //let var2 = array( 'anio' => document.getElementById('statsOptions').value, "mes" => number);
    //array with anio and mes:
    var1.anioTipo = document.getElementById('statsOptions').value;
    //console.log(var1);

    $.ajax({
      method: "POST",
      url: "../logic/graficos.php",
      data: $.param(var1),
      success: function (response) {
        //console.table(response);
        const grafica1 = JSON.parse(response);

        const array1 = grafica1.monthsArray;
        var meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
        //del array monthsArray cambiar los numeros de los meses por los nombres usando la var meses
        for (var i = 0; i < array1.length; i++) {
            array1[i].Mes = meses[array1[i].Mes - 1];
        }
        const monthsValues = array1.map(months => months.Ausentismos)        
        //mapear el valor Mes del array1 al mes correspondiente usando el arreglo meses
        const monthsLabels = array1.map(months => months.Mes)
        updateChartDataAndLabels('monthsChart', monthsValues, monthsLabels)
      }
    })      
    //const newData = coasters.map(coaster => coaster[property])
    //updateChartData('featuresChart', newData, label)
  }

  // Slider de mese de grafico de doughnut - GRAFICO 2
  document.querySelector('#tiposChartOptions').onchange = e => {
      const {
          value: number,
          text: label
      } = e.target.selectedOptions[0]
      //console.log(number, label)

      let var1 = {mes: label, value: number};
      //let var2 = array( 'anio' => document.getElementById('statsOptions').value, "mes" => number);
      //array with anio and mes:
      var1.anio = document.getElementById('statsOptions').value;
      //console.log(var1);

      $.ajax({
        method: "POST",
        url: "../logic/graficos.php",
        data: $.param(var1),
        success: function (response) {
          //console.log(response);
          const newData = JSON.parse(response);
          const newDatos = newData.map(valores => valores.numeros);
          const newLabels = newData.map(valores => valores.TipoAusentismo);
          //console.log(newDatos, newLabels);

          updateChartDataAndLabels('tiposChart', newDatos, newLabels)
        }
      })      
      //const newData = coasters.map(coaster => coaster[property])
      //updateChartData('featuresChart', newData, label)
  }

  // Slider de tipo dependencias de grafico de barra - GRAFICO 3
  document.querySelector('#tiposDepenOptions').onchange = e => {
    const {
        value: number,
        text: label
    } = e.target.selectedOptions[0]
    //console.log(number, label)

    let var1 = {depen: label, value: number};
    //let var2 = array( 'anio' => document.getElementById('statsOptions').value, "mes" => number);
    //array with anio and mes:
    var1.AnioDepen = document.getElementById('statsOptions').value;
    //console.log(var1);


    $.ajax({
      method: "POST",
      url: "../logic/graficos.php",
      data: $.param(var1),
      success: function (response) {
        //console.table(response);
        const grafica3 = JSON.parse(response);

        const funcArray = grafica3.funcArray;
        const funcValues = funcArray.map(func => func.Numeros)
        const funcLabels = funcArray.map(func => func.Nombre)   

        var depen = '';
        if (grafica3.funcArray.length > 0) {	
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

        updateChartDataArray('funcChart', data)
      }
    })      
    //const newData = coasters.map(coaster => coaster[property])
    //updateChartData('featuresChart', newData, label)
  }

  // Slider de tipo ausen de grafico de costo - GRAFICO 4
  document.querySelector('#costoChartOptions').onchange = e => {
    const {
        value: number,
        text: label
    } = e.target.selectedOptions[0]
    //console.log(number, label)

    let var1 = {costo: label, value: number};
    var1.anioCosto = document.getElementById('statsOptions').value;
    //console.log(var1);

    $.ajax({
      method: "POST",
      url: "../logic/graficos.php",
      data: $.param(var1),
      success: function (response) {
        //console.table(response);
        const grafica4 = JSON.parse(response);

        const array1 = grafica4.costoArray;
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
        document.getElementById('costoTotal1').innerHTML = "";
        document.getElementById('costoTotal1').innerHTML = costo;
        
        
        updateChartDataAndLabels('costoChart', costoValues, costoLabels)
      }
    })      
    //const newData = coasters.map(coaster => coaster[property])
    //updateChartData('featuresChart', newData, label)
  }
  
}

/*
* Funciones auxiliares para pintar los gráficos
*/
const getDataColors = opacity => {
  const colors = ['#7448c2', '#21c0d7', '#d99e2b', '#cd3a81', '#9c99cc', '#e14eca', '#3A8F54', '#ff0000', '#d6ff00', '#0038ff']
  return colors.map(color => opacity ? `${color + opacity}` : color)
}

const updateChartData = (chartId, data, label) => {
  const chart = Chart.getChart(chartId)
  chart.data.datasets[0].data = data
  chart.data.datasets[0].label = label
  chart.update()
}

/**
 * Funcion para actualizar gráfica y labels (nombres de ejes x e y)
 * @param {*} chartId 
 * @param {*} data 
 * @param {*} labels 
 */
const updateChartDataAndLabels = (chartId, data, labels) => {
  const chart = Chart.getChart(chartId)
  chart.data.datasets[0].data = data
  chart.data.labels = labels
  chart.update()
}

/**
 * Funcion para actualizar los datos de las gráficas
 * @param {*} chartId 
 * @param {*} data 
 */
const updateChartDataArray = (chartId, data) => {
  const chart = Chart.getChart(chartId)
  chart.data.datasets = data.datasets
  chart.data.labels = data.labels
  chart.update()
}