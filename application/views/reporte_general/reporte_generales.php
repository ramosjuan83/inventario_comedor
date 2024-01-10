<?php
//ini_set("display_errors", 0); 	//EVITA MOSTRAR ERRORE DE ALVERTENCIA EN LOS REPORTES
//header( 'Content-Type: text/html;charset=utf-8' ); 
//require_once(APPPATH.'libraries/fpdf181/fpdf.php');
require_once(APPPATH.'libraries/mc_table/mc_table.php');
//class PDF extends FPDF
class PDF extends PDF_MC_Table
{
        //private $matris_conf_empresa;
        private $titulo;
        private $titulo2;
        private $registros_totales;
        
        public function carga_las_variables($titulo, $titulo2, $registros_totales){
            //$this->matris_conf_empresa          = $matris_conf_empresa;
            $this->titulo                       = $titulo;
            $this->titulo2                       = $titulo2;
            $this->registros_totales                       = $registros_totales;
        }        

	function Header()
	{
                $PosicionX = $this->GetX();		$PosicionY = $this->GetY();						

                $anchoFoto = 20;
                $alto = 20;
                $imagen1_ruta = "/images/logo_ivic_2.png";
		$this->Image(base_url($imagen1_ruta), $PosicionX, $PosicionY, $anchoFoto, $alto); // IMPRIME LA FOTO


                
                $this->SetFont('Arial','B',14);
                $this->SetDrawColor(210,210,210);
                $this->SetTextColor(57, 62, 83);  // Establece el color del texto                 
                $this->Cell(260, 19, $this->titulo, 1, 0, 'C');
                $this->Ln(4);  
 
                $ancho_col_1 = 35; $ancho_col_2 = 125; 
                
                $altura = 3;


                //$this->SetFont('Arial','B',8);
                //$this->Ln();
                //$this->Cell(260, $altura, $this->ajuste_texto($this->titulo), 0, 0, 'C');
                $this->SetFont('Arial','',8);
                $titulo3 = "Registros Totales ".$this->registros_totales;
                $this->Ln();
                $this->Cell(260, $altura, $this->ajuste_texto($titulo3), 0, 0, 'C');                
                $this->SetFont('Arial','',8);
                $this->Ln();
                $this->MultiCell(260, $altura, $this->ajuste_texto($this->titulo2), 0, 'C');
                $this->Ln();

                $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
                $this->SetFillColor(31, 116, 175);  // Establece el color del fondo de la celda                
                $this->SetFont('Arial','B',8);
                //$this->Cell(8, 4, $this->ajuste_texto("ID"), 0, 0, 'L', true);
                // $this->Cell(50, 4, $this->ajuste_texto("Almacén"), 0, 0, 'C', true);                
                // $this->Cell(40, 4, $this->ajuste_texto("Nombre de artículo"), 0, 0, 'C', true);
                // $this->Cell(40, 4, $this->ajuste_texto("Despachado"), 0, 0, 'C', true);
                // $this->Cell(40, 4, $this->ajuste_texto("Despachado Traslado"), 0, 0, 'C', true);
                // $this->Cell(40, 4, $this->ajuste_texto("Recibido"), 0, 0, 'C', true);
                // $this->Cell(40, 4, $this->ajuste_texto("Recibido Traslado"), 0, 0, 'C', true);
                // $this->Cell(40, 4, $this->ajuste_texto("Merma"), 0, 0, 'C', true);
                // $this->Ln();
	}
        function Footer() //pie de pagina
        {
                $pintar = false;
                $this->SetY(-15);	//Posici?n: en cm del final
                //$this->SetY(-30);	//Posici?n: en cm del final

                //$this->SetFillColor(1,1,1);
                //$this->SetFont('Arial','',10);                
                //$this->Cell(0, 4, "________________________", 0,0, 'C');
                //$this->Ln();
                //
                //$this->Cell(0, 4, "Firma del profesor", 0, 0, 'C');
                //$this->Ln();
                
                
                
                $PosicionX = $this->GetX();		$PosicionY = $this->GetY();                
                $this->SetFont('Arial','',8);                
                $this->SetTextColor(57, 62, 83);  // Establece el color del texto            
                $ls_fecha_corta=date("d/m/Y H:i");
               // $this->Cell(0, 14, $this->ajuste_texto("Tamaño carta"),0,0,'L', $pintar);
                $this->SetXY($PosicionX, $PosicionY);
                $this->Cell(0, 14, $ls_fecha_corta,0,0,'C', $pintar);
                $this->SetXY($PosicionX, $PosicionY);
                $this->Cell(0, 14, $this->ajuste_texto('Página ').$this->PageNo().' DE {nb}',0,0,'R', $pintar);
        }
        function ajuste_texto($texto){
            $texto = str_replace("ñ", "Ñ", $texto);
            $texto = strtoupper($texto);
            $texto = str_replace("á", "Á", $texto);
            $texto = str_replace("é", "É", $texto);
            $texto = str_replace("í", "Í", $texto);
            $texto = str_replace("ó", "Ó", $texto);
            $texto = str_replace("ú", "Ú", $texto);
            $texto = utf8_decode($texto);
            //echo "texto *".$texto."*";
            return $texto;
        }        
        function zerofill($entero, $largo){
            // Limpiamos por si se encontraran errores de tipo en las variables
            $entero = (int)$entero; //SI SE QUIERE USAR UN CARACTER COMENTAR ESTA LINEA Y COLOCARLE "trim()" AL VALOR ENTRANTE
            $largo = (int)$largo;

            $relleno = '';

            /**
             * Determinamos la cantidad de caracteres utilizados por $entero
             * Si este valor es mayor o igual que $largo, devolvemos el $entero
             * De lo contrario, rellenamos con ceros a la izquierda del número
             **/
            if (strlen($entero) < $largo) {
                $relleno = str_repeat('0', $largo - strlen($entero));
            }
            return $relleno . $entero;
        }        
}

//$html = 'Ahora puede imprimir f&aacute;cilmente texto mezclando diferentes estilos: <b>negrita</b>, <i>itálica</i>, <u>subrayado</u>, o ¡ <b><i><u>todos a la vez</u></i></b>!<br><br>También puede incluir enlaces en el texto, como <a href="http://www.fpdf.org">www.fpdf.org</a>, o en una imagen: pulse en el logotipo.';
//$pdf=new PDF('P','mm','Letter');
//$pdf=new PDF('L','mm','Letter'); //A LO ANCHO
//$pdf=new PDF($matris_conf_empresa);
//$pdf=new PDF('P','mm','Letter');
$pdf=new PDF('L','mm','Letter'); //A LO ANCHO
$pdf->SetTitle('Reporte');
$pdf->AliasNbPages();
$pdf->SetMargins(9, 10, 7);
$pdf->SetAutoPageBreak(true,10); //MARGEN INFERIOR



$arreglo_filtro = array();
$x=0;
$titulo2Aux="";
$sep="";
if($nombre_articulo!='null'){
    $arreglo_filtro[$x++]=$nombre_articulo;
}

if($nombre_almacen!='null'){
    $arreglo_filtro[$x++]=$nombre_almacen;
}

// if($nombre_tipo_articulo!='null'){
//     $arreglo_filtro[$x++]=$nombre_tipo_articulo;
// }

if($fecha_desde!='null'){
    $arreglo_filtro[$x++]=$fecha_desde;
}

if($fecha_hasta!='null'){
    $arreglo_filtro[$x++]=$fecha_hasta;
}



for($i=0; $i < count($arreglo_filtro) ; $i++){

    $titulo2Aux.=$sep.$arreglo_filtro[$i];
    if($sep==""){
        $sep=" - ";
    }    
}

$titulo = "General";
$titulo2="\n".$titulo2Aux;


// $tiene_filtro = false;  $titulo2 = "";
// if( strlen($b_fecha_desde) > 0    ){
//     $titulo2 .= "\n Fecha desde = '".$b_fecha_desde."'"; 
//     $titulo2 .= " Hasta = '".$b_fecha_hasta."'"; 
//     $tiene_filtro = true;
// }
// if($cedula > 0){
//     $titulo2 .= " Cedula = '".$cedula."'"; 
//     $tiene_filtro = true;
// }
// if($tipo_personal == 1){
//     $titulo2 .= " Personal IVIC"; 
//     $tiene_filtro = true;
// }
// //--------------------------------------------------
// if($tipo_personal == 2){
//     $titulo2 .= " Personal EXTERNO"; 
//     $tiene_filtro = true;
// }
// if($id_personal_visitante_tipo > 0){
//     $titulo2 .= " Tipo = '".$personal_visitante_tipo_nombre."'"; 
//     $tiene_filtro = true;
// }
// //--------------------------------------------------
// if($id_comedor_comida_tipo > 0){
//     $titulo2 .= " Tipo de Comida  = '".$comedor_comida_tipo_nombre."'"; 
//     $tiene_filtro = true;
// }
// if( strlen($estados_nombre) > 0    ){
//     $titulo2 .= " Estado Temporal = '".$estados_nombre."'"; 
//     $tiene_filtro = true;
// }



// //if($tiene_filtro == true){ 
//     //$titulo .= "\n Filtrado por".$titulo2;
// //    $titulo2 = "Filtrado por ".$titulo2;
// //}
$registros_totales = 0;
if($matriz_generales != false){
    $registros_totales = count($matriz_generales);
}

$pdf->carga_las_variables($titulo, $titulo2, $registros_totales);

$pdf->AddPage();

//$pdf->Ln();
//$pdf->SetFillColor(0,0,250);
$pdf->SetFont('Arial','',8);

//echo "matriz_comensales <br />*<pre>"; print_r($matriz_comensales); echo "</pre>*";
/*
                $this->Cell(8, 4, $this->ajuste_texto("ID"), 0, 0, 'L', true);
                $this->Cell(60, 4, $this->ajuste_texto("Fecha / Hora"), 0, 0, 'L', true);                
                $this->Cell(78, 4, $this->ajuste_texto("Personal"), 0, 0, 'L', true);
                $this->Cell(50, 4, $this->ajuste_texto("Tipo de comida"), 0, 0, 'L', true);
 */

//for($i = 0; $i < 100; $i++){
//    $matriz_estudiante_ficha[] = $matriz_estudiante_ficha[0];
//}
if($matriz_generales != false){
    for($i = 0; $i < count($matriz_generales); $i++){
            $pdf->SetDrawColor(210,210,210);
            $pdf->SetTextColor(57, 62, 83);  // Establece el color del texto            
            //$i_mas_1 = $i + 1;
            $nombre_articulo=$matriz_generales[$i]->nombre_articulo;
            $nombre_almacen=$matriz_generales[$i]->nombre_almacen;
            $cantidad_recepcion=$matriz_generales[$i]->cantidad_recepcion;
            $cantidad_recepcion_traslado=$matriz_generales[$i]->cantidad_recepcion_traslado;
            $cantidad_despacho=$matriz_generales[$i]->cantidad_despacho;
            $cantidad_despacho_traslado=$matriz_generales[$i]->cantidad_despacho_traslado;
            $cantidad_merma=$matriz_generales[$i]->cantidad_merma;
            $unidad=$matriz_generales[$i]->nombre_unidad;
            $disponible=$matriz_generales[$i]->disponible;
            $rowspan=$matriz_generales[$i]->rowspan;



            if($rowspan==1){
                $pdf->SetFont('Arial','B',10); 
                $pdf->SetFillColor(192,192,192);
                $pdf->Cell(245, 5,$rowspan==1?$pdf->ajuste_texto($nombre_almacen):'', 1, 1, 'C', true);  

                //$pdf->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
                $pdf->SetFillColor(192, 192, 192);  // Establece el color del fondo de la celda                
                $pdf->SetFont('Arial','B',8);
                // //$this->Cell(8, 4, $this->ajuste_texto("ID"), 0, 0, 'L', true);
                // // $this->Cell(50, 4, $this->ajuste_texto("Almacén"), 0, 0, 'C', true);                
                $pdf->Cell(35, 4, $pdf->ajuste_texto("Nombre de artículo"), 0, 0, 'C', true);
                $pdf->Cell(35, 4, $pdf->ajuste_texto("Despachado"), 0, 0, 'C', true);
                $pdf->Cell(35, 4, $pdf->ajuste_texto("Recibido"), 0, 0, 'C', true);
                $pdf->Cell(35, 4, $pdf->ajuste_texto("Disponibilidad"), 0, 0, 'C', true);
                $pdf->Cell(35, 4, $pdf->ajuste_texto("Despachado Traslado"), 0, 0, 'C', true);
                $pdf->Cell(35, 4, $pdf->ajuste_texto("Recibido Traslado"), 0, 0, 'C', true);
                $pdf->Cell(35, 4, $pdf->ajuste_texto("Merma"), 0, 0, 'C', true);
                $pdf->Ln();
            }

            $pdf->SetFont('Arial','',8);  
            $pdf->SetFillColor(255,255,255);
            $pdf->Cell(35, 4, $pdf->ajuste_texto($nombre_articulo), 1, 0, 'L', true);
            $pdf->Cell(35, 4, $pdf->ajuste_texto(number_format($cantidad_despacho,"2",",",".")." (".$unidad.")"), 1, 0, 'R', true);
            $pdf->Cell(35, 4, $pdf->ajuste_texto(number_format($cantidad_recepcion,"2",",",".")." (".$unidad.")"), 1, 0, 'R', true);
            $pdf->Cell(35, 4, $pdf->ajuste_texto(number_format($disponible,"2",",",".")." (".$unidad.")"), 1, 0, 'R', true);
            $pdf->Cell(35, 4, $pdf->ajuste_texto(number_format($cantidad_despacho_traslado,"2",",",".")." (".$unidad.")"), 1, 0, 'R', true);
            $pdf->Cell(35, 4, $pdf->ajuste_texto(number_format($cantidad_recepcion_traslado,"2",",",".")." (".$unidad.")"), 1, 0, 'R', true);
            $pdf->Cell(35, 4, $pdf->ajuste_texto(number_format($cantidad_merma,"2",",",".")." (".$unidad.")"), 1, 1, 'R', true);

            // $capacidad_almacen=$matriz_generales[$i]->capacidad_almacen;
            // $fecha=$matriz_generales[$i]->fecha;
            // $disponible=$matriz_generales[$i]->disponible;

            /*
                $this->Cell(30, 4, $this->ajuste_texto("Fecha / Hora"), 0, 0, 'L', true);                
                $this->Cell(18, 4, $this->ajuste_texto("Cedula"), 0, 0, 'C', true);
                $this->Cell(75, 4, $this->ajuste_texto("Personal"), 0, 0, 'L', true);
                $this->Cell(30, 4, $this->ajuste_texto("Tipo de comida"), 0, 0, 'C', true);
                $this->Cell(30, 4, $this->ajuste_texto("IVIC / Externo"), 0, 0, 'C', true);
                $this->Cell(30, 4, $this->ajuste_texto("Tipo"), 0, 0, 'C', true);
                $this->Cell(47, 4, $this->ajuste_texto("Estado Temporal"), 0, 0, 'C', true);
            */
            // $pdf->SetWidths(array(50,50,50,50,50));
            // $pdf->SetAligns(array('L','L','R','R','R'));
            // $pdf->Row(array(
            //         //$id
            //         $pdf->ajuste_texto($nombre_almacen)
            //     ,   $pdf->ajuste_texto($nombre_articulo)
            //     ,   $pdf->ajuste_texto(number_format($cantidad_recepcion,"2",",",".")." (".$unidad.")")
            //     ,   $pdf->ajuste_texto(number_format($cantidad_despacho,"2",",",".")." (".$unidad.")")
            //     ,   $pdf->ajuste_texto(number_format($cantidad_merma,"2",",",".")." (".$unidad.")")
            // ));
            $pdf->Ln(0);
    }
}

//$pdf->Output();
$nombre = "reporte_articulos.pdf";

$pdf->Output($nombre,"I");
//echo "<script language='javascript'>window.open('ejemplo.pdf','_self','');</script>";

?>