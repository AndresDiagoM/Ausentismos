
<?php
    include "../conexion.php";

    session_start();
    $bandera = false;
    $autentication  = $_SESSION['TIPO_USUARIO'];
    $tipo_cliente   = $_SESSION['TIPO_USUARIO'];

    if ($autentication == 'Admin' || $autentication == 'Consulta' ){
        $bandera = true;
    }
    else{
        header('Location: ../pages/inicio_sesion.php?message=3');
    }


    $mysqli = $conectar;
    $salida     = "";
    $query      = "SELECT * FROM usuarios ORDER BY Cedula";

    if (isset($_POST['consulta'])){

        $q      = $mysqli->real_escape_string($_POST['consulta']);
        $query  =  "SELECT * FROM usuarios WHERE Cedula LIKE '%".$q."%'";
    }
    $resultado = $mysqli->query($query);
    if($resultado->num_rows > 0){

            $salida.="<table class='users_table2'>

                            <tr>
                                <th>CEDULA        </th>
                                <th>NOMBRE        </th>
                                <th>CORREO        </th>
                                <th>DEPENDENCIA   </th>
                                <th>TIPO USUARIO  </th>
                                <th>LOGIN         </th>
                                <th>ELIMINAR    </th>
                            </tr>";

        while($fila = $resultado ->fetch_assoc()){
            $Id_fila = $fila['Cedula'];
            $salida.="<tr>
                        <td>".$fila['Cedula']."      </td>
                        <td>".$fila['Nombre']."      </td>
                        <td>".$fila['Correo']."      </td>
                        <td>".$fila['Dependencia']."       </td>
                        <td>".$fila['TipoUsuario']."       </td>
                        <td>".$fila['login']."        </td>
                        <td><a href='../logic/confirmationDeleteLogic.php?ID=$Id_fila' class='btn-delete'><img src='../images/delete.png'></a></td>
                    </tr>";
        }
        $salida.="</table>";
    }else{
        $salida.="No se encontraron datos";
    }

    echo $salida;
    $mysqli->close();
?>
<script src="../js/confirmation.js"></script>
