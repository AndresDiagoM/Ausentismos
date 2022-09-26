<?php
    include '../conexion.php';
    session_start();
    $id_db_eliminar        = $_GET['ID_BIODIGESTOR'];
    $tipo_plan          = $_GET['PLAN'];
    $id_plan            = '';


    $actualizar_plan    = "DELETE FROM biodigestor WHERE ID_BIODIGESTOR = $id_db_eliminar";
    $prueba             = mysqli_query($conectar,$actualizar_plan);
    if($prueba){

        $_SESSION['TIPO_PLAN'] = '';
        echo "<script>
            alert('Suscripcion eliminada CORRECTAMENTE');
            location.href='../pages/client_suscription.php';
        </script>";
    }
    else{
        echo"<script>
            alert('NO se ha podido eliminar la suscripcion');
            location.href='../pages/client_suscription.php';
        </script>";
    }


?>