<?php
    include "../conexion.php"; //conexión a la base de datos

    require '../vendor/autoload.php'; //librería para leer archivos excel
    //require 'conexion.php';

    //funciones de la librería PhpSpreadsheet
    use PhpOffice\PhpSpreadsheet\{Spreadsheet, IOFactory}; 
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx; //Csv, Xls
    use PhpOffice\PhpSpreadsheet\Cell\Coordinate; //para pasar de letra a número
    use PhpOffice\PhpSpreadsheet\Calculation\Functions;


    //recibir el archivo excel
    $nombreArchivo = '';
    $tmpFile = '';
    if(isset($_FILES['excelFile']['name'])){ //comprobar si se ha cargado el archivo excel desde el formulario de la página admin_cargar.php
        //echo $_FILES['excelFile']['name'];
        //si se cargó el archivo excel, se guarda el nombre del archivo y el archivo temporalmente
        $excelFile=(isset($_FILES['excelFile']['name']))?$_FILES['excelFile']['name']:""; 

        //añadir fecha y hora al nombre del excel
        $fecha = new DateTime();
        $nombreArchivo = ($excelFile!="")?$fecha->format("d-m-Y")."_".$_FILES["excelFile"]["name"]:"excel.xlsx"; 

        //guardar archivo temporalmente
        $tmpFile=$_FILES["excelFile"]["tmp_name"];

        //echo $nombreArchivo;
        //html input type file that just allows excel files
        $allowed =  array('xls','xlsx','XLSX','XLS');
        $ext = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
        if(!in_array($ext,$allowed) ) {
            //Error: El archivo no es un archivo de Excel
            echo json_encode("error1");
            exit;
        }

    }elseif(isset($_POST['aceptar'])){ //Cuando se da click en el boton de aceptar en la página admin_cargar.php
        
        insertarDatos($conectar); //función para insertar los datos en la base de datos
        exit;

    }else{
        //No se ha cargado el archivo excel
        echo json_encode("error");
        exit;
    }

    //cargar archivo temporal excel
    $documento = IOFactory::load($tmpFile); 
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

    //Leer los encabezados de la hoja de excel
    if(!isset($sheetData[0])){
        //Error: El archivo no tiene encabezados
        echo json_encode("error2");
        exit;
    }

    //Verificar encabezados: CEDULA, NOMBRE, GENERO, NOMBRE_DEL_CARGO, C_COSTO, DEPARTAMENTO, FACULTAD, salario y estado, eps, arp
    $headers = $sheetData[0];   
    $requiredHeaders = array("CEDULA", "NOMBRE", "EMAIL", "GENERO", "NOMBRE_DEL_CARGO", "C_COSTO", "DEPARTAMENTO", "FACULTAD", "SALARIO", "ESTADO", "EPS", "ARP");
    $missingHeaders = array_diff($requiredHeaders, $headers);
    if (!empty($missingHeaders)) {
        //Error: El archivo no tiene los encabezados requeridos
        echo json_encode("error2");
        exit;
    }
    
    //print_r($headers); exit;
    //print_r($sheetData);exit;

    //orgaizar los datos en un array con los encabezados como KEYS y los datos como VALUES
    $data = array();
    foreach ($sheetData as $t) {
        // process element here;
        // access column by index
            //echo $i."---".$t[0].",".$t[1]." <br>";
            //$i++;
        $data[] = array_combine($headers, $t);
    }
    $data = array_slice($data, 1); //elimina la primera fila, que son los encabezados
    //print_r($data); exit;
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
                    [EMAIL] => dmitri@unicauca.edu.co
                )
        )
    */


    //==========================================================================
    //=================== COMPROBAR QUE LOS DATOS SEAN CONSISTENTES ============
    function validateField($fieldValue) {
        return !preg_match('/[\'^£$%&*()}{@#~?><>,|=+¬]/', $fieldValue);
    }
    foreach($data as $key => $value){
        //echo $value['CEDULA']."<br>";
        $data[$key]['DEPENDENCIA'] = "N/A";
        $data[$key]['ERROR'] = "";

        //comprobar que el campo cedula y salario sea int.
        if(!is_numeric($value['CEDULA']) || !validateField($value['CEDULA'])){
            //comprobar si el campo Error ya tiene un error, si ya tienen entonces agregar otro y separarlo con comas
            if(empty($data[$key]['ERROR'])){
                $data[$key]['ERROR'] = "Cedula"; //error2: Cedula y Salario deben ser int
            }else{
                $data[$key]['ERROR'] .= ",Cedula";
            }

            //Si tiene caracteres especiales entonces quitarlos
            if(!validateField($value['CEDULA'])){
                $data[$key]['CEDULA'] = preg_replace('/[^A-Za-z0-9\-]/', '', $value['CEDULA']);
            }
        }

        //Comprobar que el nombre sea string y sin caracteres especiales
        if(!validateField($value['NOMBRE']) || !is_string($value['NOMBRE'])){
            //comprobar si el campo Error ya tiene un error, si ya tienen entonces agregar otro y separarlo con comas
            if(empty($data[$key]['ERROR'])){
                $data[$key]['ERROR'] = "Nombre"; 
            }else{
                $data[$key]['ERROR'] .= ",Nombre";
            }
        }

        //Comprobar que el cargo sea string y sin caracteres especiales
        if(!preg_replace('/[\'^£$%&*()}{@#~?><>,|=_+¬]/', '', $value['NOMBRE_DEL_CARGO']) || !is_string($value['NOMBRE_DEL_CARGO'])){
            //comprobar si el campo Error ya tiene un error, si ya tienen entonces agregar otro y separarlo con comas
            if(empty($data[$key]['ERROR'])){
                $data[$key]['ERROR'] = "Cargo"; 
            }else{
                $data[$key]['ERROR'] .= ",Cargo";
            }
        }

        //comprobar que el salario sea int.
        if(!is_numeric($value['SALARIO']) || !validateField($value['SALARIO'])){
            //comprobar si el campo Error ya tiene un error, si ya tienen entonces agregar otro y separarlo con comas
            if(empty($data[$key]['ERROR'])){
                $data[$key]['ERROR'] = "Salario"; 
            }else{
                $data[$key]['ERROR'] .= ",Salario";
            }

            //Si tiene caracteres especiales entonces quitarlos
            if(!validateField($value['SALARIO'])){
                $data[$key]['SALARIO'] = preg_replace('/[^A-Za-z0-9\-]/', '', $value['SALARIO']);
            }
        }

        //comprobar que el campo estado sea ACTIVO o INACTIVO
        if($value['ESTADO']!="ACTIVO" && $value['ESTADO']!="INACTIVO" && $value['ESTADO']!="VACACIONES" || !validateField($value['ESTADO'])){
            //comprobar si el campo Error ya tiene un error, si ya tienen entonces agregar otro y separarlo con comas
            if(empty($data[$key]['ERROR'])){
                $data[$key]['ERROR'] = "Estado"; // Estado ACTIVO o INACTIVO
            }else{
                $data[$key]['ERROR'] .= ",Estado";
            }
        }

        //comprobar que el campo genero sea MAS o FEM
        if($value['GENERO']!="MAS" && $value['GENERO']!="FEM" || !validateField($value['GENERO'])){
            //comprobar si el campo Error ya tiene un error, si ya tienen entonces agregar otro y separarlo con comas
            if(empty($data[$key]['ERROR'])){
                $data[$key]['ERROR'] = "Genero"; // Genero debe ser MAS o FEM
            }else{
                $data[$key]['ERROR'] .= ",Genero";
            }
        }

        //si el correo no tiene "@" o no tiene "." entonces ERROR es "Correo con formato incorrecto"
        if(!strpos($value['EMAIL'], "@") || !strpos($value['EMAIL'], ".") || preg_match('/[\'^£$%&*()}{#~?><>,|=+¬]/', $value['EMAIL'])){
            //comprobar si el campo Error ya tiene un error, si ya tienen entonces agregar otro y separarlo con comas
            if($value['EMAIL'] == "" || empty($value['EMAIL'])) {
                $value['EMAIL'] = "N/A";
                continue;
            }
            if(empty($data[$key]['ERROR'])){
                $data[$key]['ERROR'] = "Correo"; // Correo con formato incorrecto
            }else{
                $data[$key]['ERROR'] .= ",Correo";
            }
        }

        //Comprobar que la eps y arp sea string y sin caracteres especiales
        if(!validateField($value['EPS']) || !is_string($value['EPS'])){
            //comprobar si el campo Error ya tiene un error, si ya tienen entonces agregar otro y separarlo con comas
            if(empty($data[$key]['ERROR'])){
                $data[$key]['ERROR'] = "EPS"; 
            }else{
                $data[$key]['ERROR'] .= ",EPS";
            }
        }

        //Comprobar que la arp sea string y sin caracteres especiales, y que no este vacio
        if(!validateField($value['ARP']) || !is_string($value['ARP']) || empty($value['ARP']) || $value['ARP']==""){
            //comprobar si el campo Error ya tiene un error, si ya tienen entonces agregar otro y separarlo con comas
            if(empty($data[$key]['ERROR'])){
                $data[$key]['ERROR'] = "ARP"; 
            }else{
                $data[$key]['ERROR'] .= ",ARP";
            }
        }

        //si el campo error esta vacio, igualar a N/A
        if(empty($data[$key]['ERROR'])){
            $data[$key]['ERROR'] = "N/A";
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

        //Si se encuentra el c_costo en la base de datos, se agrega el id
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $data[$key]['DEPENDENCIA'] = $row['ID'];
        }else{
            //comprobar si el campo Error ya tiene un error, si ya tienen entonces agregar otro y separarlo con comas
            if(empty($data[$key]['ERROR'])){
                $data[$key]['ERROR'] = "Dependencia"; 
            }else{
                $data[$key]['ERROR'] .= ",Dependencia";
            }
        }
    }

    //print_r($funcionariosNoInsertados); exit;

    //===============================================================================
    //insertar todos los datos del array $data en la base de datos, en la tabla func_auxiliar

    foreach($data as $key => $value){
        //consultar si el funcionario ya está en la tabla, si existe, no insertar
        $sql = "SELECT * FROM func_auxiliar WHERE Cedula = '".$value['CEDULA']."'";
        $result = $conectar->query($sql);
        //numero de filas que devuelve la consulta
        $numRows = $result->num_rows;
        if($numRows>0){
            continue;
        }else{
            $sql1 = "INSERT INTO func_auxiliar (Cedula, Nombre, Cargo, Correo, Dependencia, Genero, Salario, Estado, EPS, ARP, Error) 
            VALUES ('".$value['CEDULA']."', '".$value['NOMBRE']."', '".$value['NOMBRE_DEL_CARGO']."', '".$value['EMAIL']."', '".$value['DEPENDENCIA']."', '".$value['GENERO']."', '".$value['SALARIO']."', '".$value['ESTADO']."', '".$value['EPS']."' , '".$value['ARP']."' , '".$value['ERROR']."')";
            $result = $conectar->query($sql1);
            //echo $sql1."<br>";
            
            //echo $result."<br>";
            if($result){
                //echo json_encode("error2");
            }else{
                //echo json_encode("error2");
            }
        }
    }

    //Envuar mensaje de exito al cargar datos
    $json = array();
    $json['alert'] = "success_aux";
    //$json['table'] = $tablaAux;
    //$json['button'] = $buttonAcept;
    echo json_encode($json);
    exit;



    //==========================================================================
    //=================== INSERTAR DATOS EN LA BASE DE DATOS ===================
    //==========================================================================
    function insertarDatos($conectar){

        //consultar los datos de la tabla auxiliar y guardar en un array
        $sql = "SELECT * FROM func_auxiliar WHERE Error = 'N/A'";
        $result = $conectar->query($sql);
        $rows = $result->num_rows;
        $data = array();
        if($rows > 0){
            while($row = $result->fetch_assoc()){
                $data[] = $row;
            }
        }else{
            exit;
        }

        //foreach $data as $key => $value update if Salario 
        foreach($data as $key => $value){
            //COMPROBAR QUE EL FUNCIONARIO NO EXISTA en la base de datos
            $sql = "SELECT * FROM funcionarios WHERE Cedula = '".$value['Cedula']."'"; //AND Nombre = '".$value['Nombre']."' AND Apellido = '".$value['Apellido']."'";
            $result = $conectar->query($sql);
            $rows = $result->num_rows;

            if($rows > 0){ //si el funcionario ya existe en la base de datos, comprobar si se va a actualizar o no
                $result = $result->fetch_assoc();

                //ACTUALIZAR LOS DATOS DE UN FUNCIONARIO SEGUN LA CEDULA, SI EL SALARIO ES DIFERENTE. si no, actualizar el estado
                if($value['Salario']!=$result['Salario'] ){
                    $sql1 = "UPDATE funcionarios SET Salario = '".$value['Salario']."' WHERE Cedula = '".$value['Cedula']."'";
                    $result = $conectar->query($sql1);
                    
                }elseif($value['Estado']!=$result['Estado']){
                    $sql1 = "UPDATE funcionarios SET Estado = '".$value['Estado']."' WHERE Cedula = '".$value['Cedula']."'";
                    $result = $conectar->query($sql1);
                }

                //Actulizar los datos de un funcionario de eps y arp
                if($value['EPS']!=$result['EPS'] || $value['ARP']!=$result['ARP']){
                    $sql1 = "UPDATE funcionarios SET EPS = '".$value['EPS']."', ARP = '".$value['ARP']."' WHERE Cedula = '".$value['Cedula']."'";
                    $result = $conectar->query($sql1);
                }

            }else{ //si el funcionario no existe en la base de datos, insertar NUEVO funcionario
                $sql1 = "INSERT INTO funcionarios (Cedula, Nombre, Cargo, Correo, Dependencia, Genero, Salario, Estado, EPS, ARP) 
                    VALUES ('".$value['Cedula']."', '".$value['Nombre']."', '".$value['Cargo']."', '".$value['Correo']."', '".$value['Dependencia']."', '".$value['Genero']."', '".$value['Salario']."', 'ACTIVO', '".$value['EPS']."' , '".$value['ARP']."')";
               $result = $conectar->query($sql1);
                //echo $sql1."<br>";
            }
        }

        //cuando termine de actualizar e insertar, eliminar los datos de la tabla auxiliar 
        $sql = "DELETE FROM func_auxiliar";
        $result = $conectar->query($sql);

        //if the query is successful, then return true, else return try empty with truncate
        if($result){
            //if the query is successful, show alert and redirect to admin_cargar.php
            //echo "<script>//alert('Datos cargados correctamente'); window.location.href='../pages/admin_cargar.php?ALERT=success';</script>";
            echo json_encode("success1");
            exit;
        }else{
            $sql = "TRUNCATE TABLE func_auxiliar";
            $result = $conectar->query($sql);
        }
        //echo "<script>//alert('Datos cargados correctamente'); window.location.href='../pages/admin_cargar.php?ALERT=success';</script>";
        echo json_encode("success1");
        exit;
    }
    //eliminar el archivo de la carpeta excel
    //unlink('../excel/'.$nombreArchivo);
?>