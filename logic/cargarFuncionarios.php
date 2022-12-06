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
        }/*else{
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
        }*/
    }else{
        //echo "No se ha cargado el archivo";
        //show alert that the file was not uploaded
        //echo "<script>alert('No se ha cargado el archivo');</script>";
        exit;
    }

    //cargar archivo de la carpeta excel
    $documento = IOFactory::load($tmpFile); //'../excel/'.$nombreArchivo
    $totalHojas = $documento->getSheetCount();
    
    $hojaActual = $documento->getSheet(0); //cambiar 0 por $indiceHoja

    //CONVERTIR LOS DATOS DEL DOCUMENTO A UN ARRAY
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
    //print_r($data); //exit;
    /*  Estructura de los datos del array $data:
        Array
        (
            [0] => Array
                (
                    [CEDULA] => 12345678-9
                    [NOMBRE] => Juan Perez
                    [GENERO] => MAS
                    [NOMBRE_DEL_CARGO] => Ingeniero
                    [C_COSTO] => 123456	
                    [DEPARTAMENTO] => Departamento	
                    [FACULTAD] => Facultad
                    [SALARIO] => 800000
                    [ESTADO] => ACTIVO
                )
        )
    */


    //==========================================================================
    //=================== COMPROBAR QUE LOS DATOS SEAN CONSISTENTES ============
    $funcionariosNoInsertados=[];
    foreach($data as $key => $value){
        //echo $value['CEDULA']."<br>";
        //echo $value['NOMBRE']."<br>";
        //echo $value['GENERO']."<br>";
        //echo $value['NOMBRE_DEL_CARGO']."<br>";
        //echo $value['C_COSTO']."<br>";
        //echo $value['DEPARTAMENTO']."<br>";
        //echo $value['FACULTAD']."<br>";
        //echo $value['SALARIO']."<br>";
        //echo $value['ESTADO']."<br>";
        $data[$key]['DEPENDENCIA'] = "N/A";
        $data[$key]['ERROR'] = "N/A";

        //comprobrar que ningun campo tenga caracteres especiales
        if(preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $value['CEDULA']) || preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $value['NOMBRE']) || preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $value['GENERO']) || preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬]/', $value['NOMBRE_DEL_CARGO']) || preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $value['C_COSTO']) || preg_match('/[\'^£$%&*()}{@#~?><>|=_+¬-]/', $value['DEPARTAMENTO']) || preg_match('/[\'^£$%&*()}{@#~?><>|=_+¬-]/', $value['FACULTAD']) || preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $value['SALARIO']) || preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $value['ESTADO'])){
            //eliminar el registro del array
            $data[$key]['ERROR'] = "Caracteres especiales";
            $funcionariosNoInsertados[] = $data[$key];
            unset($data[$key]);
        }

        //comprobar que el campo cedula y salario sea int.
        if(!is_numeric($value['CEDULA']) || !is_numeric($value['SALARIO'])){
            //eliminar el registro del array
            $data[$key]['ERROR'] = "Cedula y Salario deben ser numeros";
            $funcionariosNoInsertados[] = $data[$key];
            unset($data[$key]);
        }

        //comprobar que el campo estado sea ACTIVO o INACTIVO, y que el campo genero sea MAS o FEM
        if($value['ESTADO']!="ACTIVO" && $value['ESTADO']!="INACTIVO" || $value['GENERO']!="MAS" && $value['GENERO']!="FEM"){
            //eliminar el registro del array
            $data[$key]['ERROR'] = "Estado debe ser ACTIVO o INACTIVO y Genero debe ser MAS o FEM";
            $funcionariosNoInsertados[] = $data[$key];
            unset($data[$key]);
        }

    }
    //print_r($funcionariosNoInsertados); exit;
    //print_r($data); exit;

    //===============================================================================
    //=================== OBTENER DEPENDENCIA SEGUN DEPAR. Y FACULTAD ================
    //consultar el ID de dependencia para cada c_costo del array data
    foreach($data as $key => $value){
        //echo $value['C_COSTO']."<br>";
        $sql = "SELECT * FROM dependencias WHERE C_costo = '".$value['C_COSTO']."'";
        $result = $conectar->query($sql);

        //if the query returns a row, then add the id to the array
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $data[$key]['DEPENDENCIA'] = $row['ID'];
        }else{
            //eliminar el registro del array
            unset($data[$key]);
            $value['ERROR'] = "Dependencia no encontrada";
            $funcionariosNoInsertados[] = $value;
        }
    }

    //print_r($funcionariosNoInsertados); exit;

    //insertar todos los datos del array $data en la base de datos, en la tabla func_auxiliar
    foreach($data as $key => $value){
        $sql1 = "INSERT INTO func_auxiliar (Cedula, Nombre, Cargo, Dependencia, Genero, Salario, Estado, Error) 
        VALUES ('".$value['CEDULA']."', '".$value['NOMBRE']."', '".$value['NOMBRE_DEL_CARGO']."', '".$value['DEPENDENCIA']."', '".$value['GENERO']."', '".$value['SALARIO']."', '".$value['ESTADO']."', '".$value['ERROR']."')";
        $result = $conectar->query($sql1);
        echo $sql1."<br>";
        //IF RESULT IS TRUE, THEN INSERT WAS SUCCESSFUL
        //convert Object of class mysqli_result into string
        $result = json_encode($result);
        echo $result."<br>";

        if($result){
            echo "INSERT SUCCESSFUL"."\n \n";
        }else{
            echo "INSERT FAILED"."\n";
        }
    }
    //insertar todos los datos del array $funcionariosNoInsertados en la base de datos, en la tabla func_auxiliar
    foreach($funcionariosNoInsertados as $key => $value){
        $sql1 = "INSERT INTO func_auxiliar (Cedula, Nombre, Cargo, Dependencia, Genero, Salario, Estado, Error) 
        VALUES ('".$value['CEDULA']."', '".$value['NOMBRE']."', '".$value['NOMBRE_DEL_CARGO']."', '".$value['DEPENDENCIA']."', '".$value['GENERO']."', '".$value['SALARIO']."', '".$value['ESTADO']."', '".$value['ERROR']."')";
        $result = $conectar->query($sql1);
    }


    //==========================================================================
    //=================== INSERTAR DATOS EN LA BASE DE DATOS ===================
    //==========================================================================
    $funcionariosExistentes=[];
    $funcionariosInsertados=[];
    //$funcionariosNoInsertados=[];
    $funcionariosActualizados=[];

    foreach($data as $key => $value){

        //COMPROBAR QUE EL FUNCIONARIO NO EXISTA en la base de datos
        $sql = "SELECT * FROM funcionarios WHERE Cedula = '".$value['CEDULA']."'"; //AND Nombre = '".$value['NOMBRE']."' AND Apellido = '".$value['APELLIDO']."'";
        $result = $conectar->query($sql);
        $rows = $result->num_rows;

        if($rows > 0){
            $result = $result->fetch_assoc();

            //echo "El funcionario ".$value['NOMBRE']." ya existe en la base de datos\n";
            //GUARDAR LOS FUNCIONARIOS QUE EXISTEN PARA MOSTRARLOS EN UNA TABLA 
            $funcionariosExistentes[] = $value;

            //ACTUALIZAR LOS DATOS DE UN FUNCIONARIO SEGUN LA CEDULA, SI EL SALARIO ES DIFERENTE. si no, actualizar el estado
            if($value['SALARIO']!=$result['Salario']){
                $sql = "UPDATE funcionarios SET Cargo = '".$value['NOMBRE_DEL_CARGO']."', Salario = '".$value['SALARIO']."' WHERE Cedula = '".$value['CEDULA']."'";
                $result = $conectar->query($sql);
                if($result){
                    //echo "El funcionario ".$value['NOMBRE']." se actualizó correctamente\n";
                    $funcionariosActualizados[] = $value;
                }else{
                    //echo "Error al actualizar el funcionario ".$value['NOMBRE']."\n";
                }
            }elseif($value['ESTADO']!=$result['Estado']){
                //Actualizar si el estado es igual a ACTIVO o INACTIVO
                if($value['ESTADO']=="ACTIVO" || $value['ESTADO']=="INACTIVO"){
                    $sql = "UPDATE funcionarios SET Estado = '".$value['ESTADO']."' WHERE Cedula = '".$value['CEDULA']."'";
                    $result = $conectar->query($sql);
                    if($result){
                        //echo "El funcionario ".$value['NOMBRE']." se actualizó correctamente\n";
                        $funcionariosActualizados[] = $value;
                    }else{
                        //echo "Error al actualizar el funcionario ".$value['NOMBRE']."\n";
                    }
                }
            }

        }else{
            //insertar funcionario
            $sql1 = "INSERT INTO funcionarios (Cedula, Nombre, Cargo, Dependencia, Genero, Salario, Estado) 
                    VALUES ('".$value['CEDULA']."', '".$value['NOMBRE']."', '".$value['NOMBRE_DEL_CARGO']."', '".$value['DEPENDENCIA']."', '".$value['GENERO']."', '".$value['SALARIO']."', 'ACTIVO')";
            $resultado = $conectar->query($sql1);
            if($result){
                //echo "El funcionario ".$value['NOMBRE']." se ha insertado correctamente";
                //GUARDAR LOS FUNCIONARIOS QUE SE INSERTARON PARA MOSTRARLOS EN UNA TABLA
                $funcionariosInsertados[] = $value;
            }else{
                //echo "Error al insertar el funcionario ".$value['NOMBRE'];
                //GUARDAR LOS FUNCIONARIOS QUE NO SE INSERTARON PARA MOSTRARLOS EN UNA TABLA
                $value['ERROR'] = "Error al insertar el funcionario";
                $funcionariosNoInsertados[] = $value;
            }
            
        }
    }
    //eliminar el archivo de la carpeta excel
    //unlink('../excel/'.$nombreArchivo);
?>