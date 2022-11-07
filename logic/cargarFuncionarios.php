<?php
    include "../conexion.php";

    require '../vendor/autoload.php';
    //require 'conexion.php';
    //$mysqli = new mysqli('localhost', 'root','','ausentismos_v1');

    /*if($mysqli->connect_errno){
        echo 'Fallo la conexion'. $mysqli->connect_error;
        die();
    } */

    use PhpOffice\PhpSpreadsheet\{Spreadsheet, IOFactory};
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx; //Csv, Xls
    use PhpOffice\PhpSpreadsheet\Cell\Coordinate; //para pasar de letra a número
    use PhpOffice\PhpSpreadsheet\Calculation\Functions;


    //recibir el archivo excel
    $nombreArchivo = '';
    if(isset($_FILES['excelFile']['name'])){
        //echo $_FILES['excelFile']['name'];

        $excelFile=(isset($_FILES['excelFile']['name']))?$_FILES['excelFile']['name']:"";

        $fecha = new DateTime();
        $nombreArchivo = ($excelFile!="")?$fecha->format("d-m-Y")."_".$_FILES["excelFile"]["name"]:"excel.xlsx"; //añadir fecha y hora al nombre del excel

        $tmpFile=$_FILES["excelFile"]["tmp_name"];

        //echo $nombreArchivo;
        //html input type file that just allows excel files
        $allowed =  array('xls','xlsx','XLSX','XLS');
        $ext = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
        if(!in_array($ext,$allowed) ) {
            //echo 'error';
            //show alert that the file is not an excel file
            echo "<script>alert('El archivo no es un archivo de Excel');
                    window.location= '../pages/admin_cargar.php'
                </script>";
        }else{
            $destino = "../excel/".$nombreArchivo;
            if(move_uploaded_file($tmpFile,$destino)){
                //echo "Archivo Cargado";
                //show alert that the file was uploaded
                //echo "<script>alert('Archivo Cargado');</script>";
            }else{
                echo "<script>alert('Error al Cargar el Archivo');
                            window.location.href='../pages/admin_cargar.php';
                    </script>";
                //header("Location: ../pages/admin_cargar.php");
                exit;
            }
        }
    }else{
        //echo "No se ha cargado el archivo";
        //show alert that the file was not uploaded
        //echo "<script>alert('No se ha cargado el archivo');</script>";
        exit;
    }

    //cargar archivo de la carpeta excel
    $documento = IOFactory::load('../excel/'.$nombreArchivo);
    $totalHojas = $documento->getSheetCount();
    
    $hojaActual = $documento->getSheet(0); //cambiar 0 por $indiceHoja

    //leer fila por fila del excel
    $numeroFilas = $hojaActual->getHighestDataRow();
    $columna = $hojaActual->getHighestColumn();
    $numeroLetra = Coordinate::columnIndexFromString($columna); /* deberia dar 18, pero entrega 1000+ */
    //$numeroLetra = 18; //por ahora lo hago así

    $sheetData = $documento->getActiveSheet()->toArray();
    
    //eliminar filas vacias
    foreach($sheetData as $key => $value){
        if($value[0]==null){
            unset($sheetData[$key]);
        }
    }
    //unset($sheetData[0]);
    //print_r($sheetData);
    

    //read the headers of the excel file, to get the column names and number, to save them in an array
    $headers = $sheetData[0];    
    //print_r($headers);
    //print_r($sheetData);exit;

    //for each array in $sheetData, change the keys for the values in $headers
    $data = array();
    foreach ($sheetData as $t) {
        // process element here;
        // access column by index
            //echo $i."---".$t[0].",".$t[1]." <br>";
            //$i++;
        $data[] = array_combine($headers, $t);
    }
    $data = array_slice($data, 1); //elimina la primera fila, que son los encabezados
    //print_r($data);

    //==========================================================================
    //=================== INSERTAR DATOS EN LA BASE DE DATOS ===================
    //=========================================================================
    $funcionariosExistentes=[];
    $funcionariosInsertados=[];
    $funcionariosNoInsertados=[];
    foreach($data as $key => $value){

        //COMPROBAR QUE EL FUNCIONARIO NO EXISTA en la base de datos
        $sql = "SELECT * FROM funcionarios WHERE Cedula = '".$value['CEDULA']."'"; //AND Nombre = '".$value['NOMBRE']."' AND Apellido = '".$value['APELLIDO']."'";
        $result = $conectar->query($sql);
        $rows = $result->num_rows;
        if($rows > 0){
            //echo "El funcionario ".$value['NOMBRE']." ya existe en la base de datos\n";
            //GUARDAR LOS FUNCIONARIOS QUE EXISTEN PARA MOSTRARLOS EN UNA TABLA 
            $funcionariosExistentes[] = $value;
        }else{
            //insertar funcionario
            $sql1 = "INSERT INTO funcionarios (Cedula, Nombre, Cargo, Departamento, Facultad, Genero, Salario, Estado) 
                    VALUES ('".$value['CEDULA']."', '".$value['NOMBRE']."', '".$value['NOMBRE_DEL_CARGO']."', '".$value['DEPARTAMENTO']."', '".$value['FACULTAD']."', '".$value['GENERO']."', '".$value['SALARIO']."', 'ACT')";
            $resultado = $conectar->query($sql1);
            if($result){
                //echo "El funcionario ".$value['NOMBRE']." se ha insertado correctamente";
                //GUARDAR LOS FUNCIONARIOS QUE SE INSERTARON PARA MOSTRARLOS EN UNA TABLA
            $funcionariosInsertados[] = $value;
            }else{
                //echo "Error al insertar el funcionario ".$value['NOMBRE'];
                //GUARDAR LOS FUNCIONARIOS QUE NO SE INSERTARON PARA MOSTRARLOS EN UNA TABLA
                $funcionariosNoInsertados[] = $value;
            }
            
        }
    }
    //eliminar el archivo de la carpeta excel
    unlink('../excel/'.$nombreArchivo);
?>