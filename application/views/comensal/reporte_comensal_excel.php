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
if($matriz_comensales != false){
    $registros_totales = count($matriz_comensales);
}
$tiene_filtro = false;  $titulo2 = "";
if( strlen($b_fecha_desde) > 0    ){
    $titulo2 .= "\n Fecha desde = '".$b_fecha_desde."'"; 
    $titulo2 .= " Hasta = '".$b_fecha_hasta."'"; 
    $tiene_filtro = true;
}
if($cedula > 0){
    $titulo2 .= " Cedula = '".$cedula."'"; 
    $tiene_filtro = true;
}
if($tipo_personal == 1){
    $titulo2 .= " Personal IVIC"; 
    $tiene_filtro = true;
}
//--------------------------------------------------
if($tipo_personal == 2){
    $titulo2 .= " Personal EXTERNO"; 
    $tiene_filtro = true;
}
if($id_personal_visitante_tipo > 0){
    $titulo2 .= " Tipo = '".$personal_visitante_tipo_nombre."'"; 
    $tiene_filtro = true;
}
//--------------------------------------------------
if($id_comedor_comida_tipo > 0){
    $titulo2 .= " Tipo de Comida  = '".$comedor_comida_tipo_nombre."'"; 
    $tiene_filtro = true;
}
if( strlen($estados_nombre) > 0    ){
    $titulo2 .= " Estado Temporal = '".$estados_nombre."'"; 
    $tiene_filtro = true;
}
//FIN DE PARA AJUSTAR AL TITULO ----------------------------------------

//AJUSTO EL ANCHO DE LAS COLUMNAS--------------------------------------- 
$spread->getActiveSheet()->getColumnDimension('A')->setWidth(20);
$spread->getActiveSheet()->getColumnDimension('B')->setWidth(12); 
$spread->getActiveSheet()->getColumnDimension('C')->setWidth(50);
$spread->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$spread->getActiveSheet()->getColumnDimension('E')->setWidth(15);
$spread->getActiveSheet()->getColumnDimension('F')->setWidth(30); 
$spread->getActiveSheet()->getColumnDimension('G')->setWidth(60); 
//FIN DE AJUSTO EL ANCHO DE LAS COLUMNAS--------------------------------

$hoja = $spread->getActiveSheet();

//IMPRIME LOS TITULOS
$fila = 1;
$sheet->setCellValue("A".$fila, ajuste_texto("COMENSALES"));
$hoja->getStyle('A'.$fila.':G'.$fila)->getFont()->setBold(true)->setSize(12);
$fila++;

$titulo = "Registros Totales ".$registros_totales;
$sheet->setCellValue("A".$fila, ajuste_texto($titulo));
$hoja->getStyle('A'.$fila.':G'.$fila)->getFont()->setBold(false)->setSize(12);
$fila++;

$titulo = trim($titulo2);
$sheet->setCellValue("A".$fila, ajuste_texto($titulo));
$hoja->getStyle('A'.$fila.':G'.$fila)->getFont()->setBold(false)->setSize(12);
$fila++;

$sheet->setCellValue("A".$fila, "FECHA / HORA");
$sheet->setCellValue("B".$fila, "CEDULA");
$sheet->setCellValue("C".$fila, "PERSONAL");
$sheet->setCellValue("D".$fila, "TIPO DE COMIDA");
$sheet->setCellValue("E".$fila, "IVIC / EXTERNO");
$sheet->setCellValue("F".$fila, "TIPO");
$sheet->setCellValue("G".$fila, "ESTADO TEMPORAL");


$hoja->getStyle('A'.$fila.':G'.$fila)->getFont()->setBold(false)->setSize(12);
$hoja->getStyle('A'.$fila)->getAlignment()->setHorizontal('center');        
$hoja->getStyle('B'.$fila)->getAlignment()->setHorizontal('center');        
$hoja->getStyle('C'.$fila)->getAlignment()->setHorizontal('center');        
$hoja->getStyle('D'.$fila)->getAlignment()->setHorizontal('center');        
$hoja->getStyle('D'.$fila)->getAlignment()->setHorizontal('left');        
$hoja->getStyle('A'.$fila.':G'.$fila)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('1F74AF');
$hoja->getStyle('A'.$fila.':G'.$fila)->getFont()->getColor()->setRGB('FFFFFF');
$fila++;
//FIN DE IMPRIME LOS TITULOS

//IMPRIME LOS DETALLES ------------------------------------------
if($matriz_comensales != false){
    for($i = 0; $i < count($matriz_comensales); $i++){
        
        $id          = $matriz_comensales[$i]->comensales_id;
        $fecha_hora  = $matriz_comensales[$i]->comensales_fecha_con_formato." ".$matriz_comensales[$i]->comensales_hora;

        //echo "matriz_comensales <br />*<pre>"; print_r($matriz_comensales); echo "</pre>*";

        $personal_cedula = $matriz_comensales[$i]->personal_cedula;
        $personal = $matriz_comensales[$i]->personal;

        $tipo_personal = "";
        if($matriz_comensales[$i]->comensales_id_personal_ivic > 0){
                $tipo_personal = "IVIC";
        }
        if($matriz_comensales[$i]->comensales_id_personal_visitante > 0){
                $tipo_personal = "EXTERNO";
        }            

        $comida_tipo = $matriz_comensales[$i]->comedor_comida_tipo_nombre;

        $personal_visitante_tipo_nombre = $matriz_comensales[$i]->personal_visitante_tipo_nombre;        
        
        
        $sheet->setCellValue("A".$fila, ajuste_texto($fecha_hora));
        $sheet->setCellValue("B".$fila, ajuste_texto($personal_cedula));
        $sheet->setCellValue("C".$fila, ajuste_texto($personal));
        $sheet->setCellValue("D".$fila, ajuste_texto($comida_tipo));
        $sheet->setCellValue("E".$fila, ajuste_texto($tipo_personal));
        $sheet->setCellValue("F".$fila, ajuste_texto($personal_visitante_tipo_nombre));
        $sheet->setCellValue("G".$fila, ajuste_texto($matriz_comensales[$i]->estado_temporal));

        $hoja->getStyle('A'.$fila.':F'.$fila)->getFont()->setBold(false)->setSize(12);
        $hoja->getStyle('A'.$fila.':F'.$fila)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFBFE');
        $hoja->getStyle('A'.$fila)->getAlignment()->setHorizontal('left');
        $hoja->getStyle('B'.$fila)->getAlignment()->setHorizontal('right');
        $hoja->getStyle('C'.$fila)->getAlignment()->setHorizontal('left');        
        $hoja->getStyle('D'.$fila)->getAlignment()->setHorizontal('center');        
        $hoja->getStyle('E'.$fila)->getAlignment()->setHorizontal('center');        
        $hoja->getStyle('F'.$fila)->getAlignment()->setHorizontal('left');        
        $hoja->getStyle('G'.$fila)->getAlignment()->setHorizontal('left');        
        
        $fila++;
    }
}
//FIN DE IMPRIME LOS DETALLES ------------------------------------------

$fileName="Comensales.xlsx";
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

		