/*
  * Para detectar el cambio en el slider de las graficas
*/
const enableEventHandlers = () => {

  document.querySelector('#myChartOptions').onchange = e => {
      const {
          value: number,
          text: label
      } = e.target.selectedOptions[0]
      //console.log(number, label)

      /*let form;
      let form2 = form.serializeArray();
      form.push({name: label, value: number});*/
      let var1 = {name: label, value: number};

      $.ajax({
        method: "POST",
        url: "../pages/grafico2.php",
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
}

/*
* Funciones de ayuda para pintar los gráficos
*/
const getDataColors = opacity => {
  const colors = ['#7448c2', '#21c0d7', '#d99e2b', '#cd3a81', '#9c99cc', '#e14eca', '#ffffff', '#ff0000', '#d6ff00', '#0038ff']
  return colors.map(color => opacity ? `${color + opacity}` : color)
}

/*const fetchCoastersData = (...urls) => {
  const promises = urls.map(url => fetch(url).then(response => response.json()))
  return Promise.all(promises)
}*/

const getCoastersByYear = (coasters, years) => {
  const coastersByYear = years.map(yearsRange => {
      const [from, to] = yearsRange.split('-')
      return coasters.filter(eachCoaster => eachCoaster.year >= from && eachCoaster.year <= to).length
  })
  return coastersByYear
}

const updateChartData = (chartId, data, label) => {
  const chart = Chart.getChart(chartId)
  chart.data.datasets[0].data = data
  chart.data.datasets[0].label = label
  chart.update()
}

const updateChartDataAndLabels = (chartId, data, labels) => {
  const chart = Chart.getChart(chartId)
  chart.data.datasets[0].data = data
  chart.data.labels = labels
  chart.update()
}

/* Configuración de las partículas, es lo mismo del particles-config.json */
particlesJS(
  {
    "particles": {
      "number": {
        "value": 80,
        "density": {
          "enable": true,
          "value_area": 800
        }
      },
      "color": {
        "value": "#524c4c"
      },
      "shape": {
        "type": "circle",
        "stroke": {
          "width": 0,
          "color": "#000000"
        },
        "polygon": {
          "nb_sides": 5
        },
        "image": {
          "src": "img/github.svg",
          "width": 100,
          "height": 100
        }
      },
      "opacity": {
        "value": 0.5,
        "random": false,
        "anim": {
          "enable": false,
          "speed": 1,
          "opacity_min": 0.1,
          "sync": false
        }
      },
      "size": {
        "value": 3,
        "random": true,
        "anim": {
          "enable": false,
          "speed": 40,
          "size_min": 0.1,
          "sync": false
        }
      },
      "line_linked": {
        "enable": true,
        "distance": 150,
        "color": "#555151",
        "opacity": 0.4,
        "width": 1
      },
      "move": {
        "enable": true,
        "speed": 6,
        "direction": "none",
        "random": false,
        "straight": false,
        "out_mode": "out",
        "bounce": false,
        "attract": {
          "enable": false,
          "rotateX": 600,
          "rotateY": 1200
        }
      }
    },
    "interactivity": {
      "detect_on": "canvas",
      "events": {
        "onhover": {
          "enable": false,
          "mode": "repulse"
        },
        "onclick": {
          "enable": true,
          "mode": "push"
        },
        "resize": true
      },
      "modes": {
        "grab": {
          "distance": 400,
          "line_linked": {
            "opacity": 1
          }
        },
        "bubble": {
          "distance": 400,
          "size": 40,
          "duration": 2,
          "opacity": 8,
          "speed": 3
        },
        "repulse": {
          "distance": 200,
          "duration": 0.4
        },
        "push": {
          "particles_nb": 4
        },
        "remove": {
          "particles_nb": 2
        }
      }
    },
    "retina_detect": true
  }
);