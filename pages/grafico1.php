<?php
        include '../conexion.php';

        $sqli = "SELECT Tipo_Ausentismo, COUNT(*) FROM ausentismos GROUP BY Tipo_Ausentismo ORDER BY COUNT(*) DESC;";
        $numeros = $conectar->query($sqli);  //print_r($numeros);


        while ($numero = $numeros->fetch_assoc()) {
            //echo "['".$numero['Tipo_Ausentismo']."',".$numero['COUNT(*)']."],";
            if($numero['Tipo_Ausentismo'] == 1){
                $incapacidad = $numero['COUNT(*)'];
            }elseif ($numero['Tipo_Ausentismo'] == 2){
                $compensatorio = $numero['COUNT(*)'];
            }elseif ($numero['Tipo_Ausentismo'] == 3){
                $permiso = $numero['COUNT(*)'];
            }elseif ($numero['Tipo_Ausentismo'] == 4){
                $licencia = $numero['COUNT(*)'];
            }
        }
?>
<script>
        const labels = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
        ];

        const data = {
            labels: labels,
            datasets: [{
            label: 'Ausentismos',
            backgroundColor: [  //un color para todos es backgroundColor: 'rgb(255, 99, 132)',
                'rgb(255, 99, 132)',
                'rgb(255, 159, 64)',
                'rgb(255, 205, 86)',
                'rgb(75, 192, 192)',
                'rgb(54, 162, 235)',
                'rgb(153, 102, 255)',
                'rgb(201, 203, 207)'
            ],
            maxBarThickness: 30, //ancho de la barra
            borderColor: 'rgb(255, 99, 132)',
            data: [5, 10, 5, 2, 20, 30, 45],
            }]
        };

        const config = {
            type: 'bar',
            data: data,
            options: {}
        };

        const myChart = new Chart(
            document.getElementById('myChart'),
            config
        );
</script>