<?php
        include '../conexion.php';

        //Obtener numero de ausentismos por mes del año, con nombre de mes y numero de ausentismos
        $sqli2 = "SELECT MONTH(Fecha_Inicio) AS Mes, COUNT(*) AS Ausentismos FROM ausentismos GROUP BY MONTH(Fecha_Inicio) ORDER BY MONTH(Fecha_Inicio) ASC;";
        $numeros2 = $conectar->query($sqli2);  //print_r($numeros2);

        $enero = 0;
        $febrero = 0;
        $marzo = 0;
        $abril = 0;
        $mayo = 0;
        $junio = 0;
        $julio = 0;
        $agosto = 0;
        $septiembre = 0;
        $octubre = 0;
        $noviembre = 0;
        $diciembre = 0;
        $meses = "";
        $mesesN = "";
        while ($numero2 = $numeros2->fetch_assoc()) {
            //echo "['".$numero['Tipo_Ausentismo']."',".$numero['COUNT(*)']."],";
            if ($numero2['Mes'] == 1) {
                $enero = $numero2['Ausentismos'];
                $meses = $meses."'Enero',";
                $mesesN = $mesesN.$enero.",";
            } elseif ($numero2['Mes'] == 2) {
                $febrero = $numero2['Ausentismos'];
                $meses = $meses."'Febrero',";
                $mesesN = $mesesN.$febrero.",";
            } elseif ($numero2['Mes'] == 3) {
                $marzo = $numero2['Ausentismos'];
                $meses = $meses."'Marzo',";
                $mesesN = $mesesN.$marzo.",";
            } elseif ($numero2['Mes'] == 4) {
                $abril = $numero2['Ausentismos'];
                $meses = $meses."'Abril',";
                $mesesN = $mesesN.$abril.",";
            } elseif ($numero2['Mes'] == 5) {
                $mayo = $numero2['Ausentismos'];
                $meses = $meses."'Mayo',";
                $mesesN = $mesesN.$mayo.",";
            } elseif ($numero2['Mes'] == 6) {
                $junio = $numero2['Ausentismos'];
                $meses = $meses."'Junio',";
                $mesesN = $mesesN.$junio.",";
            } elseif ($numero2['Mes'] == 7) {
                $julio = $numero2['Ausentismos'];
                $meses = $meses."'Julio',";
                $mesesN = $mesesN.$julio.",";
            } elseif ($numero2['Mes'] == 8) {
                $agosto = $numero2['Ausentismos'];
                $meses = $meses."'Agosto',";
                $mesesN = $mesesN.$agosto.",";
            } elseif ($numero2['Mes'] == 9) {
                $septiembre = $numero2['Ausentismos'];
                $meses = $meses."'Septiembre',";
                $mesesN = $mesesN.$septiembre.",";
            } elseif ($numero2['Mes'] == 10) {
                $octubre = $numero2['Ausentismos'];
                $meses = $meses."'Octubre',";
                $mesesN = $mesesN.$octubre.",";
            } elseif ($numero2['Mes'] == 11) {
                $noviembre = $numero2['Ausentismos'];
                $meses = $meses."'Noviembre',";
                $mesesN = $mesesN.$noviembre.",";
            } elseif ($numero2['Mes'] == 12) {
                $diciembre = $numero2['Ausentismos'];
                $meses = $meses."'Diciembre',";
                $mesesN = $mesesN.$diciembre.",";
            }
        }
        //echo $meses;
        //echo $mesesN;
?>
<script>
        const labels = [
            /*'January', 'February', 'March', 'April', 'May', 'June',*/
            <?php echo $meses; ?>
        ];

        const data = {
            labels: labels,
            datasets: [{
            label: 'Ausentismos',
            backgroundColor: [  //un color para todos es backgroundColor: 'rgb(255, 99, 132)',
                'rgb(255, 99, 132)',
                /*'rgb(255, 159, 64)',
                'rgb(255, 205, 86)',
                'rgb(75, 192, 192)',
                'rgb(54, 162, 235)',
                'rgb(153, 102, 255)',
                'rgb(201, 203, 207)'*/
            ],
            maxBarThickness: 30, //ancho de la barra
            borderColor: 'rgb(255, 99, 132)',
            data: <?php echo '['.$mesesN.']'; ?>,/*[5, 10, 5, 2, 20, 30, 45],*/
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