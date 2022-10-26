<?php
    include("../conexion.php");

    $limit=30;
    //$pag=(int)@$_GET['pag'];
    if(isset($_GET['pag'])) {
        $pag = $_GET['pag'];
    } else {
        // set proper default value if it was not set
        $pag = 1;
    }
    if($pag<0){
        $pag=1;
    }
    $offset=($pag-1)*$limit;

    echo 'BUSQUEDA: '."SELECT * FROM funcionarios LIMIT $offset, $limit".' PAG:'.$pag.' OFFSET:'.$offset.' LIMIT:'.$limit;
    $busqueda = $conectar->query("SELECT * FROM funcionarios LIMIT $offset, $limit"); //limit 50,20 es mostrar 20 registros desde el registro 50
    
    $busquedaTotal = $conectar->query("SELECT * FROM funcionarios");
    $total=$busquedaTotal->num_rows;

    $tabla = '<table class="table table-striped table-hover">
                <thead>
                    <tr class="bg-primary">
                        <th>CEDULA</th>
                        <th>NOMBRE</th>
                        <th>CARGO</th>
                        <th>DEPENDENCIA</th>
                        <th>Facultad</th>
                        <th>Genero</th>
                        <th>Salario</th>
                    </tr>
                </thead>
                <tbody>';
    while($fila = $busqueda->fetch_assoc()){
        $tabla .= '<tr>
                        <td>'.$fila['Cedula'].'</td>
                        <td>'.$fila['Nombre'].'</td>
                        <td>'.$fila['Cargo'].'</td>
                        <td>'.$fila['Departamento'].'</td>
                        <td>'.$fila['Facultad'].'</td>
                        <td>'.$fila['Genero'].'</td>
                        <td>'.$fila['Salario'].'</td>
                    </tr>';
    }
    $tabla .= '<tr><td class="text-center" colspan="4">';
        $totalpag = ceil($total/$limit); //ceil redondea el numero
        $links = array(); //creamos un array para guardar los links de las páginas
        for($i=1; $i<=$totalpag; $i++){
            $links[] = '<a style="border:solid 1px blue; padding-left:.6%; padding-right:.6%; padding-top:.25%; padding-bottom:.25%;" href="?pag='.$i.'" class="btn btn-primary">'.$i.'</a>';
        }

        $tabla .= implode(" ", $links);

    $tabla .= '     </td>
                </tr>
                </tbody>
            </table>';

    
?>