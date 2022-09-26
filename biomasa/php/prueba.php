<?php
include "conexion.php";  // Conexi�n tiene la informaci�n sobre la conexi�n de la base de datos.
$mysqli = new mysqli($host, $user, $pw, $db); // Aqu� se hace la conexi�n a la base de datos.

echo 'presion,gas===='."<br>";

$sql3 = 'SELECT * FROM rango_gas';
$result3 = $mysqli->query($sql3);
 $i=0;
while($row3 = $result3->fetch_array(MYSQLI_NUM)){
   $numeros1[$i] = $row3[1];
   $estado1[$i] = $row3[2];
   $i++;
}


$gas=3500;
echo '1000'."<br>";
//echo 'r3='.$row3[0][1];

if($gas<=$numeros1[0]){
    $gas=$estado1[0];
}else if($gas>$numeros1[0] && $gas<=$numeros1[1]){
    $gas=$estado1[1];
}else if($gas>$numeros1[1]){
    $gas=$estado1[2];
}

$sql5 = 'SELECT * FROM rango_presion';
$result5 = $mysqli->query($sql5);

 $i=0;
while($row5 = $result5->fetch_array(MYSQLI_NUM)){
   $numeros2[$i] = $row5[1];
   $estado2[$i] = $row5[2];
   $i++;
}


$presion=3500;


if($presion<=$numeros2[0]){
    $presion=$estado2[0];
}else if($presion>$numeros2[0] && $presion<=$numeros2[1]){
    $presion=$estado2[1];
}else if($presion>$numeros2[1]){
    $presion=$estado2[2];
}

echo "<br>".'presion='.$presion.', gas='.$gas."<br>";

if($hum>0 and $temp>0){
   $sql1 = "INSERT into datos_medidos (ID_BIODIGESTOR, TEMPERATURA, HUMEDAD, FECHA_LECTURA, HORA_LECTURA, NIVEL_GAS, PRESION_GAS, ESTADO_RELE) VALUES ('$ID_TARJ', '$temp', '$hum', '$fecha', '$hora', '$gas','$presion', '$rele')"; // Aqu� se ingresa el valor recibido a la base de datos. 
   echo "sql1...".$sql1; // Se imprime la cadena sql enviada a la base de datos, se utiliza para depurar el programa php, en caso de alg�n error.
}else{
   $result1=0; 
}
$result1=0;


$result1 = $mysqli->query($sql1);
echo "result es...".$result1; // Si result es 1, quiere decir que el ingreso a la base de datos fue correcto.


?>