<?php
    //Terminar la sesión del usuario
    session_start();
    session_destroy();
    //header("Location: ../pages/inicio_sesion.php?message=4");

    //mandar respuesta a la pagina 
    $response = array(
        'status' => 'success',
        'message' => 'Sesión finalizada',
        'url' => '../pages/inicio_sesion.php?message=4'
    );
    echo json_encode($response);
?>
