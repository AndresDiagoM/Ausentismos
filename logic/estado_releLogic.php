<?php
    include "../conexion.php";


    $estado_rele = $_GET['estado_rele'];
    $id_biodigestor = $_GET['id_bd'];
    echo $estado_rele;
    echo $id_alarma;

    if($estado_rele == 1){
        $sql = "UPDATE estado_rele SET estado = 1 WHERE id = $id_biodigestor";
        $result = mysqli_query($conectar, $sql);
        echo "<script>
            alert('Se ha ENCENDIDO CORRECTAMENTE el RELE');
            location.href = '../pages/client_alertas.php';
        </script>";
    }
    else{
        $sql2 = "UPDATE estado_rele SET estado = 0 WHERE id = $id_biodigestor";
        $result2 = mysqli_query($conectar, $sql2);
        echo "<script>
            alert('Se ha APAGADO CORRECTAMENTE el RELE');
            location.href = '../pages/client_alertas.php';
        </script>";
    }




?>