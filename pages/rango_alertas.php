<body>
  <table width="80%" align=center cellpadding=5 border=0 bgcolor="#FFFFFF">
    	 
 	     
<?php
$mysqli = new mysqli($host, $user, $pw, $db); // Aquí se hace la conexión a la base de datos.
 if ((isset($_POST["enviado"])))  // Ingresa a este if si el formulario ha sido enviado..., al ingresar actualiza los datos ingresados en el formulario, en la base de datos.
   {
   $enviado = $_POST["enviado"];
   //echo "   BOTON==".$enviado;
   if ("S1" == "S1")//$enviado == "S1"
    {
          $temp_max = $_POST["temp_max"]; 
          $temp_min = $_POST["temp_min"]; 
          $hum_max = $_POST["hum_max"];
          $hum_min = $_POST["hum_min"];
          $ID_BIO = $_POST["ID_BIO"];
          
          // la siguiente linea almacena en una variable denominada sql1, la consulta en lenguaje SQL que quiero realizar a la base de datos. 
          // se actualiza la tabla de valores máximos
          $sql1 = "UPDATE datos_maximos SET TEMP_MAX='$temp_max',TEMP_MIN='$temp_min', HUMEDAD_MAX='$hum_max', HUMEDAD_MIN='$hum_min' WHERE ID_BIODIGESTOR=$enviado";  
          //echo "sql1...".$sql1;
          // la siguiente línea ejecuta la consulta guardada en la variable sql1, con ayuda del objeto de conexión a la base de datos mysqli
          $result1 = $mysqli->query($sql1);

          if ($result1 == 1)
             $mensaje = "Datos actualizados correctamente";
          else
             $mensaje = "Inconveniente actualizando datos";
   
          //header('Location: programa4.php?mensaje='.$mensaje);

    } // FIN DEL IF, si ya se han recibido los datos del formulario
   }  // FIN DEL IF, si la variable enviado existe, que es cuando ya se envío el formulario
  
// AQUI CONSULTA LOS VALORES ACTUALES DE HUMEDAD y TEMPERATURA, PARA PRESENTARLOS EN EL FORMULARIO
//echo "CLIENTE===".$id_cliente;
$sql5 = "SELECT DISTINCT ID_BIODIGESTOR from biodigestor where ID_USUARIO=$id_cliente";
$result5 = mysqli_query($mysqli, $sql5);
while($mostrar5 = mysqli_fetch_array($result5)){

    // CONSULTA TEMPERATURA 
    $sql1 = "SELECT * from datos_maximos where ID_BIODIGESTOR=$mostrar5[0]"; 
    // la siguiente línea ejecuta la consulta guardada en la variable sql, con ayuda del objeto de conexión a la base de datos mysqli
    $result1 = $mysqli->query($sql1);
    $row1 = $result1->fetch_array(MYSQLI_NUM);
    $temp_max = $row1[2]; 
    $temp_min = $row1[3];
    
    // CONSULTA HUMEDAD 
    $hum_max = $row1[4]; 
    $hum_min = $row1[5];
    
    if ((isset($_GET["mensaje"])))
       {
       $mensaje = $_GET["mensaje"];
     	 echo '<tr>	
          		<td bgcolor="#EEEEFF" align=center colspan=2> 
    			   	  <font FACE="arial" SIZE=2 color="#000044"> <b>'.$mensaje.'</b></font>  
    				  </td>	
    	     </tr>';
       }
    
    $sql6 = "SELECT UBICACION from biodigestor where ID_BIODIGESTOR=$mostrar5[0]";
    $result6 = mysqli_query($mysqli, $sql6);
    $mostrar6 = mysqli_fetch_array($result6);
?>    

     <form method=POST action="client_rango_alertas.php">
 	    <!-- <table width="80%" align=center cellpadding=1 border=1 bgcolor="#FFFFFF"> -->
 	        <tr>	
    			<td bgcolor="#FFFFFF" align=center colspan=2> 
    			   <font FACE="arial" SIZE=2 color="#FFFFFF"> <b>---</b></font> 
                </td>	
    	    </tr>
     	     <tr>	
    				<td bgcolor="#EEEEEE" align=center colspan=2> 
    				   <font FACE="arial" SIZE=2 color="#000044"> <b>BIODIGESTOR: <?php echo $mostrar6[0] ?> ( ID: <?php echo $mostrar5[0] ?>)</b></font> 
                    </td>	
    	    </tr>
 	    
     	    <tr>	
          		<td bgcolor="#35A6A0" align=center> 
    			   	  <font FACE="arial" SIZE=2 color="#FFFFFF"> <b>Temperatura Máxima : </b></font>  
    				  </td>	
    				  <td bgcolor="#EEEEEE" align=center> 
    				    <input type="number" name="temp_max" value="<?php echo $temp_max; ?>" required>  
              </td>	
    	     </tr>
     	     <tr>	
          		<td bgcolor="#35A6A0" align=center> 
    			   	  <font FACE="arial" SIZE=2 color="#FFFFFF"> <b>Temperatura Minima : </b></font>  
    				  </td>	
    				  <td bgcolor="#EEEEEE" align=center> 
    				    <input type="number" name="temp_min" value="<?php echo $temp_min; ?>" required>  
              </td>	
    	     </tr>
    	     <tr>	
          		<td bgcolor="#35A6A0" align=center> 
    			   	  <font FACE="arial" SIZE=2 color="#FFFFFF"> <b>Humedad Máxima : </b></font>  
    				  </td>	
    				  <td bgcolor="#EEEEEE" align=center> 
    				    <input type="number" name="hum_max" value="<?php echo $hum_max; ?>" required>  
              </td>	
    	     </tr>
     	     <tr>	
          		<td bgcolor="#35A6A0" align=center> 
    			   	  <font FACE="arial" SIZE=2 color="#FFFFFF"> <b>Humedad Minima: </b></font>  
    				  </td>	
    				  <td bgcolor="#EEEEEE" align=center> 
    				    <input type="number" name="hum_min" value="<?php echo $hum_min; ?>" required>  
              </td>
<?php
$ID_BIO=$mostrar5[0];
?>
    	     </tr>
           <tr>	
    		 <td bgcolor="#EEEEEE" align=center colspan=2> 
    		  <!-- <input type="hidden" name="enviado" value="S1">  -->
    		  <input type="hidden" name="enviado" value="<?php echo $ID_BIO; ?>">
    		  <input type="submit" value="Actualizar" name="Actualizar">  
             </td>	
	     </tr>
	     
 	   <!-- </table>  -->
      </form>	  
      
<?php
}
?>

       </table>
     </body>
   </html>