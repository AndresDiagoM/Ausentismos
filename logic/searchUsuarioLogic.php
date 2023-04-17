<?php
/**
 * Gestion de Usuarios
 * Archivo para hacer la busqueda de los usuarios y mostrarlos en la tabla de la interfaz
 * en admin_edition_client.php
 */
    include "../conexion.php";
    $mysqli=$conectar;

    session_start();
    $bandera = false;
    $autentication  = $_SESSION['TIPO_USUARIO'];
    $tipo_cliente   = $_SESSION['TIPO_USUARIO'];

    //Verificar que la consulta la realice un usuario con permisos
    if (strtoupper($autentication) == 'ADMIN' || strtoupper($autentication) == 'CONSULTA' || strtoupper($autentication) == 'ROOT' ){
        $bandera = true;
    }
    else{
        header('Location: ../pages/inicio_sesion.php?message=3');
    }


    // Sentencia para hacer la búsqueda de usuarios
    $query      = "SELECT * FROM usuarios 
                    INNER JOIN dependencias ON usuarios.Dependencia=dependencias.ID
                    ORDER BY Cedula_U";

    // Si se ha enviado el formulario de búsqueda de cédula
    if (isset($_POST['consulta'])){
        $buscarCedula = $mysqli->real_escape_string($_POST['consulta']);
        $query  =  "SELECT * FROM usuarios 
                    INNER JOIN dependencias ON usuarios.Dependencia=dependencias.ID
                    WHERE Cedula_U LIKE '%".$buscarCedula."%' ORDER BY ID ";
    }
    $resultado = $mysqli->query($query);
    $salida     = "";  
    if($resultado->num_rows > 0){

            $salida.="<table class='table table-striped table-bordered table-hover table-condensed'>
                        <thead class='header-table thead-light table-active'>
                            <tr>
                                <th scope='col'>CEDULA        </th>
                                <th scope='col'>NOMBRE        </th>
                                <th scope='col'>CORREO        </th>
                                <th scope='col'>DEPENDENCIA   </th>
                                <th scope='col'>ROL  </th>
                                <th scope='col'>LOGIN         </th>
                                <th scope='col'>CONTRASEÑA    </th>
                                <th scope='col'>ESTADO    </th>
                                <th scope='col'>EDITAR    </th>
                                <th scope='col'>ELIMINAR    </th>
                            </tr>
                        </thead>";

        while($fila = $resultado ->fetch_assoc()){
            $Id_fila = $fila['Cedula_U'];

            $salida.="<tr>
                        <td scope='row'>".$fila['Cedula_U']."      </td>
                        <td>".$fila['Nombre_U']."      </td>
                        <td>".$fila['Correo_U']."      </td>
                        <td>".$fila['Departamento']." - ". $fila['Facultad']  ."       </td>
                        <td>".$fila['TipoUsuario']."       </td>
                        <td>".$fila['Login']."        </td>
                        <td> *****  </td>
                        <td>".$fila['Estado']."   </td>
                        <td><a href='../pages/admin_form_edition.php?ID=$Id_fila' class='btn-edit'><img src='../assets/images/edit2.png' class='img-edit'  style='width: 2rem;'></a></td>
                        <td><a  onclick = 'eliminarUsuario($Id_fila)' class='btn-delete'><img src='../assets/images/delete.png'></a></td>
                    </tr>";
        }
        $salida.="</table>";
    }else{
        $salida.="No se encontraron datos";
    }

    echo $salida;
    $mysqli->close();
?>
<!-- <script src="../js/confirmation.js"></script> -->