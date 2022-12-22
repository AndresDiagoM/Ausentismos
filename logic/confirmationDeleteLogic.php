<?php
    include '../conexion.php';
    $id_eliminar    = $_GET['ID'];
    //$eliminar   = "DELETE FROM users WHERE ID = '$id_eliminar'";
    $eliminar   = "UPDATE usuarios SET Estado='INACTIVO' WHERE Cedula_U = '$id_eliminar'";
    $resultado  = $conectar->query($eliminar);

    if($resultado){
        //echo "<script>window.location.href='../pages/admin_edition_client.php?ALERT=success';</script>";
        echo json_encode("success");
    }
    else{
        //echo "<script>//alert('No se pudo realizar la eliminacion');window.location.href='../pages/admin_edition_client.php?ALERT=error';</script>";
        echo json_encode("error1");
    }
?>