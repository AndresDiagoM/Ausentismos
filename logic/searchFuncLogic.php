<?php
    include "../conexion.php";

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


    $mysqli = $conectar;
    $salida     = "";
    $query      = "SELECT * FROM funcionarios 
                    INNER JOIN dependencias ON funcionarios.Dependencia=dependencias.ID
                    ORDER BY Cedula LIMIT 40";

    if (isset($_POST['consulta'])){
        $q      = $mysqli->real_escape_string($_POST['consulta']);
        $query  =  "SELECT * FROM funcionarios INNER JOIN dependencias ON funcionarios.Dependencia=dependencias.ID WHERE Cedula LIKE '%".$q."%' LIMIT 40";
        //echo $query; exit;
    }

    $resultado = $mysqli->query($query);
    if($resultado->num_rows > 0){

            $salida.="<table class='table table-striped table-bordered table-hover table-condensed'>
                            <thead class='thead-light'>
                                <tr>
                                    <th scope='col'>CEDULA        </th>
                                    <th scope='col'>NOMBRE        </th>
                                    <th scope='col'>CARGO        </th>
                                    <th scope='col'>DEPARTAMENTO    </th>
                                    <th scope='col'>FACULTAD    </th>
                                    <th scope='col'>GENERO  </th>
                                    <th scope='col'>SALARIO         </th>
                                    <th scope='col'>ESTADO         </th>
                                    <th scope='col'>EDITAR    </th>
                                </tr>
                            </thead>";

        while($fila = $resultado ->fetch_assoc()){
            $Id_fila = $fila['Cedula'];
            $salida.="<tr>
                        <td scope='row'>".$fila['Cedula']."      </td>
                        <td>".$fila['Nombre']."      </td>
                        <td>".$fila['Cargo']."      </td>
                        <td>".$fila['Departamento']."       </td>
                        <td>".$fila['Facultad']."       </td>
                        <td>".$fila['Genero']."       </td>
                        <td>".$fila['Salario']."        </td>
                        <td>".$fila['Estado']."        </td>
                        <td><a href='../pages/admin_func_form_edition.php?ID=$Id_fila' class='btn-edit'><img src='../images/edit2.png' class='img-edit'  style='width: 2rem;'></a></td>
                    </tr>";
        }
        $salida.="</table>";
    }else{
        $salida.="No se encontraron datos";
    }

    echo $salida;
    $mysqli->close();
?>