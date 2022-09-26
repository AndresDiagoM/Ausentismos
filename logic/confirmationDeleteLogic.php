<?php

    include '../conexion.php';
    $id_eliminar    = $_GET['ID'];
    $eliminar   = "DELETE FROM users WHERE ID = '$id_eliminar'";
    $resultado  = mysqli_query($conectar, $eliminar);

    if($resultado){
        echo "<script>
                alert('Eliminacion Exitosa')
        </script>";
        header("Location: ../pages/admin_delete_user.php");
    }
    else{
        echo "<script>

            alert('No se pudo realizar la eliminacion');
        </script>";
    }


?>