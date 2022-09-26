<?php
      session_start();
      $bandera = false;
      $autentication  = $_SESSION['TIPO_USUARIO'];
      $tipo_cliente   = $_SESSION['TIPO_USUARIO'];




    $host = "localhost";
    $user = "u715763332_admin";
    $pw   = "Lab4unicauca";
    $db   = "u715763332_db_biodigester";

    $conectar = mysqli_connect($host, $user, $pw, $db);

    if(!$conectar){
        echo "Error en la conexion con el servidor";
    }

    $consulta = "SELECT * FROM departamentos";
    $ejecutarConsulta = mysqli_query($conectar, $consulta);

    #Selecciona los datos de la tabla departamentos
    while($fila = mysqli_fetch_array($ejecutarConsulta)){
        echo "<option value='".$fila['ID_Depart']."' >".$fila['Departamento']."</option>";
    }

?>
