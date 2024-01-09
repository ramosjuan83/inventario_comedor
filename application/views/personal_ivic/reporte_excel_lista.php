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
if($matriz_personal_ivic != false){
    $registros_totales = count($matriz_personal_ivic);
}
$tiene_filtro = false;  $titulo2 = "";
if( strlen($b_texto) > 0            ){ $titulo2 .= " Buscar = '".$b_texto."'"; $tiene_filtro = true; }
if($estado_1 != ""){
    $titulo2 .= " Estado = '".$estado_1."'"; 
    $tiene_filtro = true;
}
if($b_id_cargo > 0){
    $titulo2 .= " Cargo = '".$b_cargo_nombre."'"; 
    $tiene_filtro = true;
}

if($b_id_gerencia > 0){
    $titulo2 .= " Gerencia = '".$b_gerencia_nombre."'"; 
    $tiene_filtro = true;
}
$titulo2 = trim($titulo2);
//FIN DE PARA AJUSTAR AL TITULO ----------------------------------------

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
$sheet->setCellValue("A".$fila, ajuste_texto("Personal Ivic"));
$hoja->getStyle('A'.$fila.':G'.$fila)->getFont()->setBold(true)->setSize(12);
$fila++;

$titulo = "Registros Totales ".$registros_totales;
$sheet->setCellValue("A".$fila, ajuste_texto($titulo));
$hoja->getStyle('A'.$fila.':G'.$fila)->getFont()->setBold(false)->setSize(12);
$fila++;

$titulo = $titulo2;
$sheet->setCellValue("A".$fila, ajuste_texto($titulo));
$hoja->getStyle('A'.$fila.':G'.$fila)->getFont()->setBold(false)->setSize(12);
$fila++;

$sheet->setCellValue("A".$fila, "CARNET");
$sheet->setCellValue("B".$fila, "CEDULA");
$sheet->setCellValue("C".$fila, "NOMBRES");
$sheet->setCellValue("D".$fila, "APELLIDOS");
$sheet->setCellValue("E".$fila, "CARGO");
$sheet->setCellValue("F".$fila, "GERENCIA");
$sheet->setCellValue("G".$fila, "ESTADO");

$hoja->getStyle('A'.$fila.':G'.$fila)->getFont()->setBold(false)->setSize(12);
$hoja->getStyle('A'.$fila)->getAlignment()->setHorizontal('center');        
$hoja->getStyle('B'.$fila)->getAlignment()->setHorizontal('center');        
$hoja->getStyle('C'.$fila)->getAlignment()->setHorizontal('left');        
$hoja->getStyle('D'.$fila)->getAlignment()->setHorizontal('left');        
$hoja->getStyle('E'.$fila)->getAlignment()->setHorizontal('left');        
$hoja->getStyle('F'.$fila)->getAlignment()->setHorizontal('left');        
$hoja->getStyle('G'.$fila)->getAlignment()->setHorizontal('center');        
$hoja->getStyle('A'.$fila.':G'.$fila)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('1F74AF');
$hoja->getStyle('A'.$fila.':G'.$fila)->getFont()->getColor()->setRGB('FFFFFF');
$fila++;
//FIN DE IMPRIME LOS TITULOS


//IMPRIME LOS DETALLES ------------------------------------------
if($matriz_personal_ivic != false){
    for($i = 0; $i < count($matriz_personal_ivic); $i++){
        $sheet->setCellValue("A".$fila, ajuste_texto($matriz_personal_ivic[$i]->carnet_codigo));
        $sheet->setCellValue("B".$fila, ajuste_texto($matriz_personal_ivic[$i]->cedula));
        $sheet->setCellValue("C".$fila, ajuste_texto($matriz_personal_ivic[$i]->nombres));
        $sheet->setCellValue("D".$fila, ajuste_texto($matriz_personal_ivic[$i]->apellidos));
        $sheet->setCellValue("E".$fila, ajuste_texto($matriz_personal_ivic[$i]->cargo_nombre));
        $sheet->setCellValue("F".$fila, ajuste_texto($matriz_personal_ivic[$i]->gerencia_nombre));
        $sheet->setCellValue("G".$fila, ajuste_texto($matriz_personal_ivic[$i]->estado_nombre));

        $hoja->getStyle('A'.$fila.':G'.$fila)->getFont()->setBold(false)->setSize(12);
        $hoja->getStyle('A'.$fila.':G'.$fila)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFBFE');
        $hoja->getStyle('A'.$fila)->getAlignment()->setHorizontal('center');        
        $hoja->getStyle('B'.$fila)->getAlignment()->setHorizontal('center');        
        $hoja->getStyle('C'.$fila)->getAlignment()->setHorizontal('left');        
        $hoja->getStyle('D'.$fila)->getAlignment()->setHorizontal('left');        
        $hoja->getStyle('E'.$fila)->getAlignment()->setHorizontal('left');        
        $hoja->getStyle('F'.$fila)->getAlignment()->setHorizontal('left');        
        $hoja->getStyle('G'.$fila)->getAlignment()->setHorizontal('center');        
        
        
        
        $fila++;
    }
}
//FIN DE IMPRIME LOS DETALLES ------------------------------------------

$fileName="Personal_Ivic.xlsx";
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

		