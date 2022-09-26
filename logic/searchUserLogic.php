
<?php

    session_start();
    $bandera = false;
    $autentication  = $_SESSION['TIPO_USUARIO'];
    $tipo_cliente   = $_SESSION['TIPO_USUARIO'];

    if ($autentication == 'Admin' || $autentication == 'Cliente' ){
        $bandera = true;
    }
    else{
        header('Location: ../pages/inicio_sesion.php?message=3');
    }


    $mysqli = new mysqli("localhost", "root", "","db_biodigester");
    $salida     = "";
    $query      = "SELECT * FROM users ORDER BY NUM_REGISTRO";

    if (isset($_POST['consulta'])){

        $q      = $mysqli->real_escape_string($_POST['consulta']);
        $query  =  "SELECT NUM_REGISTRO, ID, NAME_LASTNAME, DATE, TYPE_ID, ADDRESS, DEPARTAMENTO, MUNICIPIO, CELLPHONE, TIPO_USUARIO FROM users WHERE ID LIKE '%".$q."%'";
    }
    $resultado = $mysqli->query($query);
    if($resultado->num_rows > 0){

            $salida.="<table class='users_table2'>

                            <tr>
                                <th>NUM_REGISTRO        </th>
                                <th>ID                  </th>
                                <th>NOMBRE              </th>
                                <th>FECHA NACIMIENTO    </th>
                                <th>TIPO_ID             </th>
                                <th>DIRECCION           </th>
                                <th>DEPARTAMENTO        </th>
                                <th>MUNICIPIO           </th>
                                <th>CELULAR             </th>
                                <th>TIPO USUARIO        </th>
                                <th>ELIMINAR            </th>
                            </tr>";

        while($fila = $resultado ->fetch_assoc()){
            $Id_fila = $fila['ID'];
            $salida.="<tr>
                        <td>".$fila['NUM_REGISTRO']."   </td>
                        <td>".$fila['ID']."             </td>
                        <td>".$fila['NAME_LASTNAME']."  </td>
                        <td>".$fila['DATE']."           </td>
                        <td>".$fila['TYPE_ID']."        </td>
                        <td>".$fila['ADDRESS']."        </td>
                        <td>".$fila['DEPARTAMENTO']."   </td>
                        <td>".$fila['MUNICIPIO']."      </td>
                        <td>".$fila['CELLPHONE']."      </td>
                        <td>".$fila['TIPO_USUARIO']."   </td>
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
