<?php
        //Generar un archivo excel con la tabla de ausentismos
        require '../vendor/autoload.php';
        //use PhpOffice\PhpSpreadsheet\{SpreadSheet, IOFactory};
        use PhpOffice\PhpSpreadsheet\Spreadsheet;
        use PhpOffice\PhpSpreadsheet\IOFactory;
        use PhpOffice\PhpSpreadsheet\Writer\Xlsx; //Csv, Xls

        require("../conexion.php");

        session_start();
        $sqli = $_SESSION['ausen_list'];

        $nombre_admin   = $_SESSION['NOM_USUARIO'];
        $id_admin       = $_SESSION['ID_USUARIO'];
        $tipo_usuario   = $_SESSION['TIPO_USUARIO'];



        //CREAR ARCHIVO EXCEL
        $excel = new SpreadSheet();
        $excel->getProperties()->setCreator($nombre_admin)->setTitle("Mi excel"); //metadatos
        $excel->setActiveSheetIndex(0);  //trabajar con la primera hoja del excel
        $hojaActiva = $excel->getActiveSheet();
        $hojaActiva->setTitle("Funcionarios");

        //Añadir informacion al archivo, CABECERAS:
        $hojaActiva->setCellValue('A1', 'Cedula_Funcionario');
        $hojaActiva->getColumnDimension('A')->setWidth(15);
        $hojaActiva->setCellValue('B1', 'Fecha_Inicio');
        $hojaActiva->getColumnDimension('B')->setWidth(15);
        $hojaActiva->setCellValue('C1', 'Fecha_Fin');
        $hojaActiva->getColumnDimension('C')->setWidth(15);
        $hojaActiva->setCellValue('D1', 'Tiempo');
        $hojaActiva->setCellValue('E1', 'Observación');
        $hojaActiva->getColumnDimension('E')->setWidth(20);
        $hojaActiva->setCellValue('F1', 'Seguridad_Trabajo');
        $hojaActiva->getColumnDimension('F')->setWidth(15);
        $hojaActiva->setCellValue('G1', 'ID_Usuario');
        $hojaActiva->getColumnDimension('G')->setWidth(15);
        $hojaActiva->setCellValue('H1', 'Tipo_Ausentismo');
        $hojaActiva->getColumnDimension('H')->setWidth(15);


        $ausentismos = $conectar->query($sqli);
        //TRAER INFORMACIÓN DE LAS CONSULTAS SQL:
        $fila = 2; //empezar en fila 2. La fila 1 es cabecera
        while ($ausentismo = $ausentismos->fetch_assoc()) {
                $hojaActiva->setCellValue('A' . $fila, $ausentismo['Cedula_F']);
                $hojaActiva->setCellValue('B' . $fila, $ausentismo['Fecha_Inicio']);
                $hojaActiva->setCellValue('C' . $fila, $ausentismo['Fecha_Fin']);
                $hojaActiva->setCellValue('D' . $fila, $ausentismo['Tiempo']);
                $hojaActiva->setCellValue('E' . $fila, $ausentismo['Observacion']);
                $hojaActiva->setCellValue('F' . $fila, $ausentismo['Seguridad_Trabajo']);
                $hojaActiva->setCellValue('G' . $fila, $ausentismo['ID_Usuario']);

                if ($ausentismo['Tipo_Ausentismo'] == 1) {
                        $hojaActiva->setCellValue('H' . $fila, 'INCAPACIDAD');
                } elseif ($ausentismo['Tipo_Ausentismo'] == 2) {
                        $hojaActiva->setCellValue('H' . $fila, 'COMPENSATORIO');
                } elseif ($ausentismo['Tipo_Ausentismo'] == 3) {
                        $hojaActiva->setCellValue('H' . $fila, 'PERMISO');
                } elseif ($ausentismo['Tipo_Ausentismo'] == 4) {
                        $hojaActiva->setCellValue('H' . $fila, 'LICENCIA');
                }

                $fila++;
        }

        //Guardar archivo excel
        //----------boton para descargar excel----------//
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Reporte.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = IOFactory::createWriter($excel, 'Xlsx');
        $writer->save('php://output');
        exit;
?>