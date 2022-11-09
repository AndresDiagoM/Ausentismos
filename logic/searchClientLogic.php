<?php
    include "../conexion.php";
    //$mysqli = new mysqli("localhost", "root", "","db_biodigester");
    $mysqli=$conectar;

    session_start();
    $bandera = false;
    $autentication  = $_SESSION['TIPO_USUARIO'];
    $tipo_cliente   = $_SESSION['TIPO_USUARIO'];

    if (strtoupper($autentication) == 'ADMIN' || strtoupper($autentication) == 'CONSULTA' ){
        $bandera = true;
    }
    else{
        header('Location: ../pages/inicio_sesion.php?message=3');
    }


    $salida     = "";
    $query      = "SELECT * FROM usuarios ORDER BY Cedula_U";
    //$query      = "SELECT * FROM usuarios EXCEPT SELECT * FROM usuarios  WHERE TipoUsuario = '%' ORDER BY Cedula_U";

    if (isset($_POST['consulta'])){

        $q      = $mysqli->real_escape_string($_POST['consulta']);
        $query  =  "SELECT * FROM usuarios WHERE Cedula_U LIKE '%".$q."%'";
    }
    $resultado = $mysqli->query($query);
    if($resultado->num_rows > 0){

            $salida.="<table class='table table-striped table-bordered table-hover table-condensed'>
                        <thead class='thead-light'>
                            <tr>
                                <th scope='col'>CEDULA        </th>
                                <th scope='col'>NOMBRE        </th>
                                <th scope='col'>CORREO        </th>
                                <th scope='col'>DEPENDENCIA   </th>
                                <th scope='col'>TIPO USUARIO  </th>
                                <th scope='col'>LOGIN         </th>
                                <th scope='col'>CONTRASEÑA    </th>
                                <th scope='col'>EDITAR    </th>
                            </tr>
                        </thead>";

        while($fila = $resultado ->fetch_assoc()){
            $Id_fila = $fila['Cedula_U'];
            $salida.="<tr>
                        <td scope='row'>".$fila['Cedula_U']."      </td>
                        <td>".$fila['Nombre_U']."      </td>
                        <td>".$fila['Correo']."      </td>
                        <td>".$fila['Dependencia']."       </td>
                        <td>".$fila['TipoUsuario']."       </td>
                        <td>".$fila['Login']."        </td>
                        <td>".$fila['Contrasena']."   </td>
                        <td><a href='../pages/admin_form_edition.php?ID=$Id_fila' class='btn-edit'><img src='../images/edit2.png' class='img-edit'></a></td>
                    </tr>";
        }
        $salida.="</table>";
    }else{
        $salida.="No se encontraron datos";
    }

    echo $salida;
    $mysqli->close();
?>
