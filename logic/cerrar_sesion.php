<?php
    session_start();
    session_destroy();
    header("Location: ../pages/inicio_sesion.php?message=4")
?>
