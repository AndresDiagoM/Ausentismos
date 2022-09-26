<?php
    $host = "localhost";
    $user = "u715763332_admin";
    $pw   = "Lab4unicauca";
    $db   = "u715763332_db_biodigester";

    $conectar = mysqli_connect($host, $user, $pw, $db);

    if(!$conectar){
        echo "Error en la conexion con el servidor";
    }

    $consulta = "SELECT * FROM municipios";
    $ejecutarConsulta = mysqli_query($conectar, $consulta);


    #Selecciona los datos de la tabla municipios
    echo '<label for="muni"> Municipio </label>';
    echo '<select class="input_decor" name="munic">';
    echo '<option>Municipio</option>';
    while($fila = mysqli_fetch_array($ejecutarConsulta)){
        if($fila['ID_Departamento']==$_GET['c']){
            echo "<option value = '".$fila['Municipio']."' >".$fila['Municipio']."</option>";
        }
    }
    echo '</select>';
?>