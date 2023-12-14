<?php

require_once(APPPATH.'libraries/vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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

// Set page orientation and size
//$helper->log('Set page orientation and size');
//$spread->getActiveSheet()->getPageSetup()->setOrientation(PageSetup::ORIENTATION_PORTRAIT);
//$spread->getActiveSheet()->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);

/*
$sheet->setCellValueByColumnAndRow(1, 1, "Valor A1");
$sheet->setCellValue("B1", "Valor celda B2");
$sheet->setCellValue("B2", "Valor celda B2");
$sheet->setCellValue("B3", "Valor celda B3"); */

//PARA AJUSTAR AL TITULO ----------------------------------------
$registros_totales = 0;
if($matriz_recepcion != false){
    $registros_totales = count($matriz_recepcion);
}
$tiene_filtro = false;  $titulo2 = "";
if( strlen($b_texto) > 0            ){ $titulo2 .= " Buscar = '".$b_texto."'"; $tiene_filtro = true; }
// if($estado_1 != ""){
//     $titulo2 .= " Estado = '".$estado_1."'"; 
//     $tiene_filtro = true;
// }
//FIN DE PARA AJUSTAR AL TITULO ----------------------------------------

//AJUSTO EL ANCHO DE LAS COLUMNAS--------------------------------------- 
$spread->getActiveSheet()->getColumnDimension('A')->setWidth(20);
$spread->getActiveSheet()->getColumnDimension('B')->setWidth(40);
$spread->getActiveSheet()->getColumnDimension('C')->setWidth(40);
$spread->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$spread->getActiveSheet()->getColumnDimension('E')->setWidth(20);
$spread->getActiveSheet()->getColumnDimension('F')->setWidth(20);
//$spread->getActiveSheet()->getColumnDimension('E')->setWidth(20); 
//FIN DE AJUSTO EL ANCHO DE LAS COLUMNAS--------------------------------

$hoja = $spread->getActiveSheet();

//IMPRIME LOS TITULOS
$fila = 1;
$sheet->setCellValue("A".$fila, ajuste_texto("Recepción"));
$hoja->getStyle('A'.$fila.':F'.$fila)->getFont()->setBold(true)->setSize(12);
$fila++;

$titulo = "Registros Totales ".$registros_totales;
$sheet->setCellValue("A".$fila, ajuste_texto($titulo));
$hoja->getStyle('A'.$fila.':F'.$fila)->getFont()->setBold(false)->setSize(12);
$fila++;

$titulo = $titulo2;
$sheet->setCellValue("A".$fila, ajuste_texto($titulo));
$hoja->getStyle('A'.$fila.':F'.$fila)->getFont()->setBold(false)->setSize(12);
$fila++;

$sheet->setCellValue("A".$fila, "ARTÏCULO");
$sheet->setCellValue("B".$fila, "FECHA INGRESO");
$sheet->setCellValue("C".$fila, "ALMACËN");
$sheet->setCellValue("D".$fila, "CANTIDAD");
$sheet->setCellValue("E".$fila, "FECHA VENCIMIENTO");
$sheet->setCellValue("F".$fila, "OBSERVACIÓN");

$hoja->getStyle('A'.$fila.':F'.$fila)->getFont()->setBold(false)->setSize(12);
$hoja->getStyle('A'.$fila)->getAlignment()->setHorizontal('center');        
$hoja->getStyle('B'.$fila)->getAlignment()->setHorizontal('left');        
$hoja->getStyle('C'.$fila)->getAlignment()->setHorizontal('left');        
$hoja->getStyle('D'.$fila)->getAlignment()->setHorizontal('center');        
$hoja->getStyle('E'.$fila)->getAlignment()->setHorizontal('center');   
$hoja->getStyle('F'.$fila)->getAlignment()->setHorizontal('center');  

$hoja->getStyle('A'.$fila.':F'.$fila)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('1F74AF');
$hoja->getStyle('A'.$fila.':F'.$fila)->getFont()->getColor()->setRGB('FFFFFF');
$fila++;
//FIN DE IMPRIME LOS TITULOS


//IMPRIME LOS DETALLES ------------------------------------------
if($matriz_recepcion != false){
    for($i = 0; $i < count($matriz_recepcion); $i++){
        $sheet->setCellValue("A".$fila, ajuste_texto($matriz_recepcion[$i]->nombre_articulo));
        $sheet->setCellValue("B".$fila, ajuste_texto($matriz_recepcion[$i]->fecha_ingreso_2));
        $sheet->setCellValue("C".$fila, ajuste_texto($matriz_recepcion[$i]->nombre_almacen));
        $sheet->setCellValue("D".$fila, ajuste_texto($matriz_recepcion[$i]->cantidad));
        $sheet->setCellValue("E".$fila, ajuste_texto($matriz_recepcion[$i]->fecha_vencimiento_2));
        $sheet->setCellValue("F".$fila, ajuste_texto($matriz_recepcion[$i]->observacion));


        $hoja->getStyle('A'.$fila.':F'.$fila)->getFont()->setBold(false)->setSize(12);
        $hoja->getStyle('A'.$fila.':F'.$fila)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFBFE');
        $hoja->getStyle('A'.$fila)->getAlignment()->setHorizontal('center');        
        $hoja->getStyle('B'.$fila)->getAlignment()->setHorizontal('left');        
        $hoja->getStyle('C'.$fila)->getAlignment()->setHorizontal('left');        
        $hoja->getStyle('D'.$fila)->getAlignment()->setHorizontal('center');        
        $hoja->getStyle('E'.$fila)->getAlignment()->setHorizontal('center');  
        $hoja->getStyle('F'.$fila)->getAlignment()->setHorizontal('center');  
        
        $fila++;
    }
}
//FIN DE IMPRIME LOS DETALLES ------------------------------------------

$fileName="recepcion.xlsx";
# Crear un "escritor"
$writer = new Xlsx($spread);
# Le pasamos la ruta de guardado

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
$writer->save('php://output');
//exit;


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


/**
 * zerofill()
 *
 * Devuelve el n�mero ingresado con ceros a la izquierda dependiendo del
 * largo deseado de la cadena de salida.
 *
 * @param   int $entero
 * @param   int $largo
 * @return  string numero_formateado_ceros_izquierda
 */
function zerofill($entero, $largo){
    // Limpiamos por si se encontraran errores de tipo en las variables
    //$entero = (int)$entero;
    $largo = (int)$largo;

    $relleno = '';

    /**
     * Determinamos la cantidad de caracteres utilizados por $entero
     * Si este valor es mayor o igual que $largo, devolvemos el $entero
     * De lo contrario, rellenamos con ceros a la izquierda del n�mero
     **/
    if (strlen($entero) < $largo) {
        $relleno = str_repeat('0', $largo - strlen($entero));
    }
    return $relleno . $entero;

}
?>

		