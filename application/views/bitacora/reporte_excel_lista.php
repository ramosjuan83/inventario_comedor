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
if($matriz_bitacora != false){
    $registros_totales = count($matriz_bitacora);
}
$tiene_filtro = false;  $titulo2 = "";
if( strlen($b_fecha_desde) > 0      ){ $titulo2 .= ", Fecha desde = ".$b_fecha_desde.""; $tiene_filtro = true; }
if( strlen($b_fecha_hasta) > 0      ){ $titulo2 .= ", Fecha hasta = ".$b_fecha_hasta.""; $tiene_filtro = true; }
if( $b_id_usuario > 0               ){ $titulo2 .= ", Usuario = ".$b_usuario.""; $tiene_filtro = true; }
if( strlen($b_texto) > 0            ){ $titulo2 .= ", Buscar = '".$b_texto."'"; $tiene_filtro = true; }
$titulo2 = trim($titulo2);
//FIN DE PARA AJUSTAR AL TITULO ----------------------------------------

//AJUSTO EL ANCHO DE LAS COLUMNAS--------------------------------------- 
$spread->getActiveSheet()->getColumnDimension('A')->setWidth(15);
$spread->getActiveSheet()->getColumnDimension('B')->setWidth(15);
$spread->getActiveSheet()->getColumnDimension('C')->setWidth(10);
$spread->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$spread->getActiveSheet()->getColumnDimension('E')->setWidth(40); 
$spread->getActiveSheet()->getColumnDimension('F')->setWidth(200);
//FIN DE AJUSTO EL ANCHO DE LAS COLUMNAS--------------------------------

$hoja = $spread->getActiveSheet();

//IMPRIME LOS TITULOS
$fila = 1;
$sheet->setCellValue("A".$fila, ajuste_texto("Bitacora"));
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

$sheet->setCellValue("A".$fila, "ID");
$sheet->setCellValue("B".$fila, "FECHA");
$sheet->setCellValue("C".$fila, "HORA");
$sheet->setCellValue("D".$fila, "IP");
$sheet->setCellValue("E".$fila, "USUARIO");
$sheet->setCellValue("F".$fila, "ACCIÓN");

$hoja->getStyle('A'.$fila.':F'.$fila)->getFont()->setBold(false)->setSize(12);
$hoja->getStyle('A'.$fila)->getAlignment()->setHorizontal('center');        
$hoja->getStyle('B'.$fila)->getAlignment()->setHorizontal('center');        
$hoja->getStyle('C'.$fila)->getAlignment()->setHorizontal('left');        
$hoja->getStyle('D'.$fila)->getAlignment()->setHorizontal('left');        
$hoja->getStyle('E'.$fila)->getAlignment()->setHorizontal('left');        
$hoja->getStyle('F'.$fila)->getAlignment()->setHorizontal('left');        
$hoja->getStyle('A'.$fila.':F'.$fila)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('1F74AF');
$hoja->getStyle('A'.$fila.':F'.$fila)->getFont()->getColor()->setRGB('FFFFFF');
$fila++;
//FIN DE IMPRIME LOS TITULOS


//IMPRIME LOS DETALLES ------------------------------------------
if($matriz_bitacora != false){
    for($i = 0; $i < count($matriz_bitacora); $i++){
        
        $matriz_bitacora[$i]->conf_bitacora_fecha = ordena_fecha($matriz_bitacora[$i]->conf_bitacora_fecha);
        $usuario = "(".$matriz_bitacora[$i]->conf_usuarios_ci_usu.") ".$matriz_bitacora[$i]->conf_usuarios_nombre_usu." ".$matriz_bitacora[$i]->conf_usuarios_apellido_usu;
        
        $sheet->setCellValue("A".$fila, ajuste_texto($matriz_bitacora[$i]->conf_bitacora_id));
        $sheet->setCellValue("B".$fila, ajuste_texto($matriz_bitacora[$i]->conf_bitacora_fecha));
        $sheet->setCellValue("C".$fila, ajuste_texto($matriz_bitacora[$i]->conf_bitacora_hora));
        $sheet->setCellValue("D".$fila, ajuste_texto($matriz_bitacora[$i]->conf_bitacora_ip_usuario));
        $sheet->setCellValue("E".$fila, ajuste_texto($usuario));
        $sheet->setCellValue("F".$fila, ajuste_texto($matriz_bitacora[$i]->conf_bitacora_accion_2));

        $hoja->getStyle('A'.$fila.':F'.$fila)->getFont()->setBold(false)->setSize(12);
        $hoja->getStyle('A'.$fila.':F'.$fila)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFBFE');
        $hoja->getStyle('A'.$fila)->getAlignment()->setHorizontal('center');        
        $hoja->getStyle('B'.$fila)->getAlignment()->setHorizontal('center');        
        $hoja->getStyle('C'.$fila)->getAlignment()->setHorizontal('left');        
        $hoja->getStyle('D'.$fila)->getAlignment()->setHorizontal('left');        
        $hoja->getStyle('E'.$fila)->getAlignment()->setHorizontal('left');        
        $hoja->getStyle('F'.$fila)->getAlignment()->setHorizontal('left');        
        $fila++;
    }
}
//FIN DE IMPRIME LOS DETALLES ------------------------------------------

$fileName="Bitacora_lista.xlsx";
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

// ORDENAR EL FORMATO DE LA FECHA
//  RECIBE LA FECHA EN FORMATO "2010-07-13" Y LA REGRESA EN "dd-mm-YYYY"
//Y RECIBE LA FECHA EN FORMATO "dd-mm-YYYY" Y LA REGRESA EN "YYYY-mm-dd"
function ordena_fecha($fecha){
        $fecha = explode("-", $fecha);
        $dia = $fecha[2];	$mes = $fecha[1];	$anno = $fecha[0];
        return $dia."-".$mes."-".$anno;
}
?>

		