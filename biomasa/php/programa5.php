<?php
include "conexion.php";  // Conexión tiene la información sobre la conexión de la base de datos.

$ID_TARJ=$_GET["ID_TARJ"];

$mysqli = new mysqli($host, $user, $pw, $db); // Aquí se hace la conexión a la base de datos.

// CONSULTA BASE DE DATOS
    $sql1 = "SELECT * from datos_maximos where ID_BIODIGESTOR='$ID_TARJ'"; 
    // la siguiente línea ejecuta la consulta guardada en la variable sql, con ayuda del objeto de conexión a la base de datos mysqli
    $result1 = $mysqli->query($sql1);
    $row1 = $result1->fetch_array(MYSQLI_NUM);
    
// CONSULTA TEMPERATURA MAXIMA
    $temp_max = $row1[2];
    $temp_min = $row1[3];
    
    $long_temp_max= strlen($temp_max);
    $long_temp_min= strlen($temp_min);
    for ($i=$long_temp_max;$i<2;$i++)
      {
        $temp_max = "0".$temp_max;
      }
    for ($i=$long_temp_min;$i<2;$i++)
      {
        $temp_min = "0".$temp_min;
      }

// CONSULTA HUMEDAD MAXIMA

    $hum_max = $row1[4];  
    $hum_min = $row1[5]; 
    
    $long_hum_max= strlen($hum_max);
    for ($i=$long_hum_max;$i<2;$i++)
      {
        $hum_max = "0".$hum_max;
        //$hum_max = 666;
      }
    $long_hum_min= strlen($hum_min);
    for ($i=$long_hum_min;$i<2;$i++)
      {
        $hum_min = "0".$hum_min;
        //$hum_max = 666;
      }

//CONSULTAR BOTON RELE
    $sql3 = "SELECT * from estado_rele where id='$ID_TARJ'"; 
    // la siguiente línea ejecuta la consulta guardada en la variable sql, con ayuda del objeto de conexión a la base de datos mysqli
    $result3 = $mysqli->query($sql3);
    $row3 = $result3->fetch_array(MYSQLI_NUM);
    $rele = $row3[1];  
   
    $long_rele= strlen($rele);
    for ($i=$long_rele;$i<1;$i++)
      {
        $rele = "0".$rele;
        //$hum_max = 666;
      }
//COMPARAR HORA
date_default_timezone_set('America/Bogota'); 
$fecha = date("Y-m-d");
$hora = date("H:i:s");

echo "hora: ".$hora;
echo "rele: ".$rele;

$h1 = "07:00:00";
$h2 = "07:05:00";
$h3 = "15:00:00";
$h4 = "15:05:00";

if ((($h1 <= $hora && $hora <= $h2) or ($h3 <= $hora && $hora <= $h4)) && ($rele == "0")){
    echo "\n entro";
    $rele = "1";
    $sql3 = "UPDATE estado_rele SET estado='$rele' WHERE id='$ID_TARJ'";
}


//Enviar datos a ESP32
echo $temp_max.$hum_max.$temp_min.$hum_min.$rele; // Si result es 1, quiere decir que el ingreso a la base de datos fue correcto.
?>