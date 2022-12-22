<?php
header('Content-Type: application/json');

//obtener el valor del tipo de usuario enviado en peticion POST
$tipo_usuario = $_POST['tipo_usuario'];

//Comprobrar que tipo de usuario es para descargar el archivo que corresponda
$file = '';
if($tipo_usuario == 'ADMIN'){
    $file = '../documents/ayudaAdmin.pdf';
}else if($tipo_usuario == 'CONSULTA'){
    $file = '../documents/ayudaConsulta.pdf';
}else if($tipo_usuario == 'FACULTAD'){
    $file = '../documents/ayudaFacultad.pdf';
}else{
    exit;
}

//si el archivo existe
if (file_exists($file)) {
    //obtenemos la ruta del archivo
    $file_path = realpath($file);
    //si la ruta es valida
    if ($file_path !== false) {
        //codificamos el archivo en base64
        $data = base64_encode(file_get_contents($file_path));
        //establecemos la respuesta en formato JSON
        $response = [
            'status' => 'success',
            'file_name' => basename($file_path),
            'file_data' => $data
        ];
    } else {
        //archivo no encontrado
        $response = [
            'status' => 'error',
            'message' => 'archivo no encontrado'
        ];
    }
} else {
    //archivo no encontrado
    $response = [
        'status' => 'error',
        'message' => 'archivo no encontrado'
    ];
}

//devolvemos la respuesta en formato JSON
echo json_encode($response);

?>