<?php
    include "../conexion.php";
    //$mysqli = new mysqli("localhost", "root", "","db_biodigester");
    $mysqli=$conectar;

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


    $salida     = "";
    $query      = "SELECT * FROM usuarios EXCEPT SELECT * FROM usuarios  WHERE TipoUsuario = '%' ORDER BY Cedula";

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
                                <th>CONTRASEÑA    </th>
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
                        <td>".$fila['contraseña']."   </td>
                        <td><a href='../pages/admin_form_edition.php?ID=$Id_fila' class='btn-edit'><img src='../images/edit2.png'></a></td>
                    </tr>";
        }
        $salida.="</table>";
    }else{
        $salida.="No se encontraron datos";
    }

    echo $salida;
    $mysqli->close();
?>
