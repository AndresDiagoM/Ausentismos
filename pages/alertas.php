<meta http-equiv="refresh" content="15" />
<table width="80%" align=center cellpadding=5 border=1 bgcolor="#FFFFFF">
    	 
 	     <tr>
         <td valign="top" align=center width=80% colspan=9 bgcolor="#5BB074">
           <h1> <font color=white>Alertas de Temperatura y Humedad</font></h1>
         </td>
 	     </tr>
    	 <tr>
         <td valign="top" align=center bgcolor="#E1E1E1">
            <b>#</b>
         </td>
         <td valign="top" align=center bgcolor="#E1E1E1">
            <b>Id de la Tarjeta</b>
         </td>
         </td>
           <td valign="top" align=center bgcolor="#E1E1E1">
            <b>Ubicacion</b>
         </td>
         <td valign="top" align=center bgcolor="#E1E1E1">
            <b>Fecha</b>
         </td>
         <td valign="top" align=center bgcolor="#E1E1E1">
            <b>Hora</b>
         </td>
         <td valign="top" align=center bgcolor="#E1E1E1">
            <b>Temperatura</b>
         </td>
         <td valign="top" align=center bgcolor="#E1E1E1">
            <b>Humedad</b>
         </td>
         <td valign="top" align=center bgcolor="#E1E1E1">
            <b>Alerta Temperatura</b>
         </td>
         <td valign="top" align=center bgcolor="#E1E1E1">
            <b>Alerta Humedad</b>
            

 	     </tr>
<?php
// la siguiente linea almacena en una variable denominada sql1, la consulta en lenguaje SQL que quiero realizar a la base de datos. Se consultan los datos de la tarjeta 1, porque en la tabla puede haber datos de diferentes tarjetas.

// CONSULTA TEMPERATURA MAXIMA
    $mysqli = new mysqli($host, $user, $pw, $db); // Aquí se hace la conexión a la base de datos.
    $sql1 = "SELECT * from datos_maximos where id=1"; 
    // la siguiente línea ejecuta la consulta guardada en la variable sql, con ayuda del objeto de conexión a la base de datos mysqli
    $result2 = $mysqli->query($sql1);
    $row2 = $result2->fetch_array(MYSQLI_NUM);
    $temp_max = $row2[3];  

// CONSULTA HUMEDAD MAXIMA
    $sql3 = "SELECT * from datos_maximos where id=2"; 
    // la siguiente línea ejecuta la consulta guardada en la variable sql, con ayuda del objeto de conexión a la base de datos mysqli
    $result3 = $mysqli->query($sql3);
    $row3 = $result3->fetch_array(MYSQLI_NUM);
    $hum_max = $row3[3];  

// ------------------------------------------------
$sql4 = "SELECT * from ubicacion where Id";
$result4 = $mysqli->query($sql4);
while($row4 = $result4->fetch_array(MYSQLI_NUM)){
        $sql1 = "SELECT * from datos_medidos where ID_TARJ=$row4[0] order by id DESC LIMIT 2";
        $result1 = $mysqli->query($sql1);
            $contador = 0;     
            while($row1 = $result1->fetch_array(MYSQLI_NUM))
            {
             $ID_TARJ = $row1[1];
             $temp = $row1[2];
             $hum = $row1[3];
             $fecha = $row1[4];
             $hora = $row1[5];
             $gas = $row1[6];            
             
                $sql2 = "SELECT * from ubicacion where Id=$ID_TARJ"; 
                $result2 = $mysqli->query($sql2);
                $row2 = $result2->fetch_array(MYSQLI_NUM);
                $Ubicacion =$row2[1];
             
             $contador++;
             
             ?>
    	 <tr>
         <td valign="top" align=center>
           <?php echo $contador; ?> 
         </td>
         <td valign="top" align=center>
           <?php echo $ID_TARJ; ?> 
         </td>
         </td>
          <td valign="top" align=center>
           <?php echo $Ubicacion; ?> 
         </td>
         <td valign="top" align=center>
           <?php echo $fecha; ?> 
         </td>
         <td valign="top" align=center>
           <?php echo $hora; ?> 
         </td>
         <td valign="top" align=center>
           <?php echo $temp." *C"; ?> 
         </td>
         <td valign="top" align=center>
           <?php echo $hum." %"; ?> 
         </td>
         <td valign="top" align=center>
           <?php 
           if ($temp > $temp_max)
            {
           ?> 
              <img src="../images/check.png" width=80 height=80>           
           <?php 
            }
           else
            {
            ?> 
              <img src="../images/bad.png" width=80 height=80>           
           <?php 
            }
           ?> 
         </td>
         <td valign="top" align=center>
           <?php 
           if ($hum > $hum_max)
            {
           ?> 
              <img src="../images/bad.png" width=80 height=80>           
           <?php 
            }
           else
            {
            ?> 
              <img src="../images/check.png" width=80 height=80>           
           <?php 
            }
           ?> 

 	     </tr>
<?php
                
            }
//}
// ---------------------------------------------------


}
?>

<!--
<div class="contenedor_tabla">
    <table class="users_table2">
        <tr>
            <th>#</th>
            <th>ID TARJETA</th>
            <th>Ubicación</th>
            <th>FECHA</th>
            <th>HORA</th>
            <th>TEMPERATURA</th>
            <th>HUMEDAD</th>
            <th>GAS</th>
            <th>PRESION</th>
            <th>ESTADO RELE</th>

        </tr>
        <?php
            #$sqli = "SELECT * FROM datos_medidos WHERE ID = '$id_cliente'";
            $sqli = "SELECT * from datos_medidos where ID_TARJ=1 order by id DESC LIMIT 6"; 
            $result = mysqli_query($conectar, $sqli);
            while($mostrar = mysqli_fetch_array($result)){
        ?>

        <tr>
            <td><?php echo $mostrar['id']?></td>
            <td><?php echo $mostrar['ID_TARJ']?></td>
            <td><?php echo $Ubicacion?></td>
            
            <td><?php echo $mostrar['fecha']?></td>
            <td><?php echo $mostrar['hora']?></td>
                <td valign="top" align=center>
                   <?php 
                   if ($temp > $temp_max)
                    {
                   ?> 
                      <img src="../images/check.png" width=60 height=60>           
                   <?php 
                    }
                   else
                    {
                    ?> 
                      <img src="../images/bad.png" width=60 height=60>           
                   <?php 
                    }
                   ?> 
                 </td>
                <td valign="top" align=center>
                   <?php 
                   if ($hum > $hum_max)
                    {
                   ?> 
                      <img src="../images/bad.png" width=80 height=80>           
                   <?php 
                    }
                   else
                    {
                    ?> 
                      <img src="../images/check.png" width=80 height=80>           
                   <?php 
                    }
                   ?> 
                 </td>
            
            <td><?php echo $mostrar['gas']?></td>
            <td><?php echo $mostrar['presion']?></td>
            <td><?php echo $mostrar['rele']?></td>
           
        </tr>

        <?php
            }
        ?>
    </table>
</div> -->