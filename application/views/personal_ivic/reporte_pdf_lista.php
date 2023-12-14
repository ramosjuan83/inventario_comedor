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
                $this->Cell(20, 4, $this->ajuste_texto("CARNET"), 0, 0, 'C', true);
                $this->Cell(20, 4, $this->ajuste_texto("CEDULA"), 0, 0, 'C', true);
                $this->Cell(80, 4, $this->ajuste_texto("NOMBRES Y APELLIDOS"), 0, 0, 'L', true);
                $this->Cell(55, 4, $this->ajuste_texto("Cargo"), 0, 0, 'L', true);
                $this->Cell(55, 4, $this->ajuste_texto("Gerencia"), 0, 0, 'L', true);
                $this->Cell(30, 4, $this->ajuste_texto("ESTADO"), 0, 0, 'C', true);
                $this->Ln();
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
                $this->Cell(0, 14, $this->ajuste_texto("Tamaño carta"),0,0,'L', $pintar);
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
$pdf=new PDF('L','mm','Letter'); //A LO ANCHO
//$pdf=new PDF($matris_conf_empresa);
//$pdf=new PDF('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->SetMargins(9, 10, 7);
$pdf->SetAutoPageBreak(true,10); //MARGEN INFERIOR

$titulo = "PERSONAL IVIC";


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

//if($tiene_filtro == true){ 
    //$titulo .= "\n Filtrado por".$titulo2;
//    $titulo2 = "Filtrado por ".$titulo2;
//}
$registros_totales = 0;
if($matriz_personal_ivic != false){
    $registros_totales = count($matriz_personal_ivic);
}

$pdf->carga_las_variables($titulo, $titulo2, $registros_totales);

$pdf->AddPage();

$pdf->SetTitle('Reporte');
//$pdf->Ln();
//$pdf->SetFillColor(0,0,250);
$pdf->SetFont('Arial','',8);

//for($i = 0; $i < 100; $i++){
//    $matriz_estudiante_ficha[] = $matriz_estudiante_ficha[0];
//}

//$this->Cell(20, 4, $this->ajuste_texto("CARNET"), 0, 0, 'L', true);
//$this->Cell(20, 4, $this->ajuste_texto("CEDULA"), 0, 0, 'L', true);
//$this->Cell(116, 4, $this->ajuste_texto("NOMBRES Y APELLIDOS"), 0, 0, 'L', true);
//$this->Cell(40, 4, $this->ajuste_texto("ESTADO"), 0, 0, 'C', true);

if($matriz_personal_ivic != false){
    for($i = 0; $i < count($matriz_personal_ivic); $i++){
        
            $pdf->SetDrawColor(210,210,210);
            $pdf->SetTextColor(57, 62, 83);  // Establece el color del texto            
            //$i_mas_1 = $i + 1;
/*            
            $id          = $matriz_personal_ivic[$i]->comensales_id;
            $fecha_hora  = $matriz_personal_ivic[$i]->comensales_fecha." ".$matriz_personal_ivic[$i]->comensales_hora;
            
            //echo "matriz_comensales <br />*<pre>"; print_r($matriz_personal_ivic); echo "</pre>*";
            
            $personal = $matriz_personal_ivic[$i]->personal;
            
            $tipo_personal = "";
            if($matriz_personal_ivic[$i]->comensales_id_personal_ivic > 0){
                    $tipo_personal = "IVIC";
            }
            if($matriz_personal_ivic[$i]->comensales_id_personal_visitante > 0){
                    $tipo_personal = "EXTERNO";
            }            

            $comida_tipo = $matriz_personal_ivic[$i]->comedor_comida_tipo_nombre;
            
            $personal_visitante_tipo_nombre = $matriz_personal_ivic[$i]->personal_visitante_tipo_nombre;
*/
        
/*
                $this->Cell(20, 4, $this->ajuste_texto("CARNET"), 0, 0, 'C', true);
                $this->Cell(20, 4, $this->ajuste_texto("CEDULA"), 0, 0, 'C', true);
                $this->Cell(80, 4, $this->ajuste_texto("NOMBRES Y APELLIDOS"), 0, 0, 'L', true);
                $this->Cell(55, 4, $this->ajuste_texto("Cargo"), 0, 0, 'C', true);
                $this->Cell(55, 4, $this->ajuste_texto("Gerencia"), 0, 0, 'C', true);
                $this->Cell(30, 4, $this->ajuste_texto("ESTADO"), 0, 0, 'C', true);
 *  */            
            $personal = $matriz_personal_ivic[$i]->nombres." ".$matriz_personal_ivic[$i]->apellidos;       
        
            $pdf->SetWidths(array(20,20,80,55,55,30));
            $pdf->SetAligns(array('C','C','L','L','L','C'));
            $pdf->Row(array(
                    //$id
                    $pdf->ajuste_texto($matriz_personal_ivic[$i]->carnet_codigo)
                ,   $pdf->ajuste_texto($matriz_personal_ivic[$i]->cedula)
                ,   $pdf->ajuste_texto($personal)
                ,   $pdf->ajuste_texto($matriz_personal_ivic[$i]->cargo_nombre)
                ,   $pdf->ajuste_texto($matriz_personal_ivic[$i]->gerencia_nombre)
                ,   $pdf->ajuste_texto($matriz_personal_ivic[$i]->estado_nombre)
            ));
            $pdf->Ln(0);
    }
}

//$pdf->Output();
$nombre = "reporte_personal_ivic.pdf";

$pdf->Output($nombre,"I");
//echo "<script language='javascript'>window.open('ejemplo.pdf','_self','');</script>";

?>