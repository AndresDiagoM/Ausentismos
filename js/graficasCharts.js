//Hace el llamado a graficos.php, donde se hace la consulta a la base de datos

let var1 = {};
$.ajax({
    method: "POST",
    url: "./graficos.php",
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

        document.getElementById('tiposChartOptions').innerHTML = grafica1.options;
        document.getElementById('tiposMonthsOptions').innerHTML = grafica1.optionsTipo;

        //const newDatos = newData.map(valores => valores.numeros);
        //const newLabels = newData.map(valores => valores.TipoAusentismo);
        //console.log(newDatos, newLabels);

        //updateChartDataAndLabels('tiposChart', Datos, newLabels)

        /*
        * Funciones para pintar los gráficos
            * Se utilizan funciones auxiliares definidas en app.js
        */
        Chart.defaults.color = '#000000'; //Color de las letras para todos los charts black color: #000000
        //Chart.defaults.height = 1500; //Alto de los charts

        const monthsArray = grafica1.monthsArray;
        var meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
        //del array monthsArray cambiar los numeros de los meses por los nombres usando la var meses
        for (var i = 0; i < monthsArray.length; i++) {
            monthsArray[i].Mes = meses[monthsArray[i].Mes - 1];
        }

        const tiposArray = grafica2;
        const genderArray = grafica3;
        const costoArray = grafica4;

        const printCharts = () => {

            //console.log(monthsArray)
            renderMonthsChart(monthsArray)
            renderTiposChart(tiposArray)
            renderGenderChart(genderArray)
            renderCostoChart(costoArray)

            //para manejar los eventos de los botones de los charts
            enableEventHandlers()
        }

        /*
            * Funcion de cada chart
        */
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
                    barThickness: 30,
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
                maintainAspectRatio: false,
                responsive: true,
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
                maintainAspectRatio: false,
                responsive: true,
            }

            new Chart('tiposChart', {
                type: 'doughnut',
                data,
                options
            })
        }

        const renderGenderChart = array1 => {
            /* ESTRUCTURA DE LOS DATOS:
                Mes	Ausentismos	Genero	
                1        43     FEM
                1        32     MAS
            */
            
            const genderLabels = [...new Set(array1.map(valor => valor.Mes))] //['1', '2', '3', '4', '5', '6', '7', '8', '9']
                var meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
                //cambiar numeros de los meses por los nombres usando el arreglo meses
                genderLabels.forEach((valor, indice) => {
                    genderLabels[indice] = meses[valor - 1];
                })
                //console.log(genderLabels)

            //obtener los valores de los meses por separado, array con mes y valor
            const genderValues1 = array1.filter(genero => genero.Genero == 'FEM').map(genero => genero.Ausentismos) //[43, 32, 43, 32, 43, 32, 43, 32, 43]
            const genderValues2 = array1.filter(genero => genero.Genero == 'MAS').map(genero => genero.Ausentismos) //[32, 43, 32, 43, 32, 43, 32, 43, 32]

            //console.table(genderValues1)
            //console.table(genderValues2)

            //obtener en la variable suma1, la suma de los ausentismos de genderValues1, pasando los valores a entero
            const suma1 = genderValues1.map(valor => parseInt(valor)).reduce((acumulador, valor) => acumulador + valor)
            const suma2 = genderValues2.map(valor => parseInt(valor)).reduce((acumulador, valor) => acumulador + valor)
            //console.log(suma1, suma2)
            document.getElementById('genderTotal').innerHTML = 'Masculino: ' + suma2 + '&nbsp; ' + 'Femenino: ' + suma1;

            const dataMale = {
                //mostar label:masculino más el valor de la suma de los ausentismos, pasando el valor de la suma a string
                label: 'Masculino',
                data: genderValues2,
                borderColor: getDataColors(0)[2],
                backgroundColor: getDataColors(70)[2],
                barThickness: 15,
            }
            const dataFemale = {
                label: 'Femenino',
                data: genderValues1,
                borderColor: getDataColors(0)[1],
                backgroundColor: getDataColors(70)[1],
                barThickness: 15,
            }

            const data = {
                labels: genderLabels, 
                datasets: [
                    dataMale,
                    dataFemale,
                ]
            }
            const options = {
                plugins: { 
                    legend: {
                        display: true,
                    },                
                },
                maintainAspectRatio: false,
                responsive: true,
            }

            new Chart('genderChart', {
                type: 'bar',
                data,
                options
            })
        }

        const renderCostoChart = array1 => {
            /* ESTRUCTURA DE LOS DATOS:
                Mes	      Costo	
                1         36330410.05859375
                2         83219591.328125
            */

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


        printCharts()
    }
}) 