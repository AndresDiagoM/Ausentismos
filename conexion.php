<?php
    // Declaración de variables para la conexión a la base de datos
    $host = "localhost"; // Dirección del servidor donde se encuentra la base de datos
    $user = "root"; // Nombre de usuario con permisos para acceder a la base de datos
    $pw   = ""; // Contraseña del usuario
    $db   = "ausentismos_v2"; // Nombre de la base de datos a la que se desea conectar
    
    // Establecer conexión a la base de datos utilizando las variables declaradas anteriormente
    $conectar = mysqli_connect($host, $user, $pw, $db);
?>