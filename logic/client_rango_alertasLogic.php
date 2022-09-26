<?php

    require "../conexion.php";
    session_start();

    $id_usuario         = $_SESSION['ID_USUARIO'];
    $temp_max           = strtoupper($_POST['temp_max']);
    $temp_min           = strtoupper($_POST['temp_min']);
    $hum_max            = strtoupper($_POST['hum_max']);
    $hum_min            = strtoupper($_POST['hum_min']);
    $id_biodigestor     = strtoupper($_POST['select_biodigestor']);

    $sql = "UPDATE datos_maximos
    INNER JOIN biodigestor
    ON datos_maximos.ID_BIODIGESTOR = biodigestor.ID_BIODIGESTOR
    SET datos_maximos.TEMP_MAX = $temp_max, datos_maximos.TEMP_MIN = $temp_min,
    datos_maximos.HUMEDAD_MAX = $hum_max, datos_maximos.HUMEDAD_MIN = $hum_min
    WHERE biodigestor.ID_USUARIO = '$id_usuario' AND  biodigestor.ID_BIODIGESTOR = '$id_biodigestor'";
    $result = mysqli_query($conectar, $sql);

    if($result){
        echo "<script>
            alert('Rango de datos almacenado CORRECTAMENTE');
            location.href = '../pages/client_menu.php';
        </script>";
    }else{
        echo "<script>
            alert('Se ha presentado un ERROR al almacenar los rangos de datos');
            location.href = '../pages/client_menu.php';
        </script>";
    }

?>