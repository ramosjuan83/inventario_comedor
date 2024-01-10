<?php
//require 'vendor/autoload.php';
require_once(APPPATH.'libraries/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
/*
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'Hello World !');

$writer = new Xlsx($spreadsheet);

$writer->save('hola_mundo.xlsx');
*/

$spread = new Spreadsheet();
$spread
->getProperties()
->setCreator("Evert Jose")
->setLastModifiedBy('BaulPHP')
->setTitle('Excel creado con PhpSpreadSheet')
->setSubject('Excel de prueba')
->setDescription('Excel generado como demostración')
->setKeywords('PHPSpreadsheet')
->setCategory('Categoría Excel');

$sheet = $spread->getActiveSheet();
$sheet->setTitle("Hoja 1");

//AJUSTO EL ANCHO DE LAS COLUMNAS--------------------------------------- 
$spread->getActiveSheet()->getColumnDimension('A')->setWidth(20);
$spread->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$spread->getActiveSheet()->getColumnDimension('C')->setWidth(40);
$spread->getActiveSheet()->getColumnDimension('D')->setWidth(40);
$spread->getActiveSheet()->getColumnDimension('E')->setWidth(40); 
$spread->getActiveSheet()->getColumnDimension('F')->setWidth(40);
$spread->getActiveSheet()->getColumnDimension('G')->setWidth(20);
//FIN DE AJUSTO EL ANCHO DE LAS COLUMNAS--------------------------------

$hoja = $spread->getActiveSheet();

//IMPRIME LOS TITULOS
$fila = 1;
$sheet->setCellValue("A".$fila, ajuste_texto("Estadísticas"));
$hoja->getStyle('A'.$fila.':G'.$fila)->getFont()->setBold(true)->setSize(12);
$fila++;

// $titulo = "Registros Totales ".$registros_totales;
// $sheet->setCellValue("A".$fila, ajuste_texto($titulo));
// $hoja->getStyle('A'.$fila.':G'.$fila)->getFont()->setBold(false)->setSize(12);
// $fila++;

// $titulo = $titulo2;
// $sheet->setCellValue("A".$fila, ajuste_texto($titulo));
// $hoja->getStyle('A'.$fila.':G'.$fila)->getFont()->setBold(false)->setSize(12);
// $fila++;

$sheet->setCellValue("A".$fila, "ALMACÉN");
$sheet->setCellValue("B".$fila, "ARTÍCULO");
$sheet->setCellValue("C".$fila, "CAPACIDAD ALMACËN");
$sheet->setCellValue("D".$fila, "DISPONBILIDAD");
$sheet->setCellValue("E".$fila, "MERMA");

$hoja->getStyle('A'.$fila.':G'.$fila)->getFont()->setBold(false)->setSize(12);
$hoja->getStyle('A'.$fila)->getAlignment()->setHorizontal('center');        
$hoja->getStyle('B'.$fila)->getAlignment()->setHorizontal('center');        
$hoja->getStyle('C'.$fila)->getAlignment()->setHorizontal('left');        
$hoja->getStyle('D'.$fila)->getAlignment()->setHorizontal('left');      

//IMPRIME LOS DETALLES ------------------------------------------
if($matriz_estadisticas != false){
    for($i = 0; $i < count($matriz_estadisticas); $i++){

        $fila++; 

        if($matriz_estadisticas[$i]->rowspan==1){

            $sheet->setCellValue("B".$fila, ajuste_texto($matriz_estadisticas[$i]->nombre_almacen));
            $sheet->getStyle('B'.$fila)->getFont()->setBold(true)->setSize(12);
            $fila++;

        }

        $sheet->setCellValue("A".$fila, ajuste_texto($matriz_estadisticas[$i]->nombre_almacen));
        $sheet->setCellValue("B".$fila, ajuste_texto($matriz_estadisticas[$i]->nombre_articulo));
        $sheet->setCellValue("C".$fila, ajuste_texto($matriz_estadisticas[$i]->capacidad_almacen));
        $sheet->setCellValue("D".$fila, ajuste_texto($matriz_estadisticas[$i]->disponible));
        $sheet->setCellValue("E".$fila, ajuste_texto($matriz_estadisticas[$i]->merma));


        $hoja->getStyle('A'.$fila.':G'.$fila)->getFont()->setBold(false)->setSize(12);     
        $hoja->getStyle('B'.$fila)->getAlignment()->setHorizontal('center');        
        $hoja->getStyle('C'.$fila)->getAlignment()->setHorizontal('left');        
        $hoja->getStyle('D'.$fila)->getAlignment()->setHorizontal('left');        
        $hoja->getStyle('E'.$fila)->getAlignment()->setHorizontal('left');        
        
        
       
    }
}
//FIN DE IMPRIME LOS DETALLES ------------------------------------------


// Set page orientation and size
//$helper->log('Set page orientation and size');
//$spread->getActiveSheet()->getPageSetup()->setOrientation(PageSetup::ORIENTATION_PORTRAIT);
//$spread->getActiveSheet()->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);

/*
$sheet->setCellValueByColumnAndRow(1, 1, "Valor A1");
$sheet->setCellValue("B1", "Valor celda B2");
$sheet->setCellValue("B2", "Valor celda B2");
$sheet->setCellValue("B3", "Valor celda B3"); */


function ajuste_texto($texto){
    $texto = str_replace("ñ", "Ñ", $texto);
    $texto = strtoupper($texto);
    $texto = str_replace("á", "Á", $texto);
    $texto = str_replace("é", "É", $texto);
    $texto = str_replace("í", "Í", $texto);
    $texto = str_replace("ó", "Ó", $texto);
    $texto = str_replace("ú", "Ú", $texto);
    //$texto = utf8_decode($texto);
    //echo "texto *".$texto."*";
    return $texto;
}


//FIN DE IMPRIME LOS DETALLES ------------------------------------------

$fileName="reporte_estadisticas.xlsx";
# Crear un "escritor"
$writer = new Xlsx($spread);
# Le pasamos la ruta de guardado

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
$writer->save('php://output');
//exit;



?>

		