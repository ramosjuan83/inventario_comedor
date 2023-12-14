<?php
//ini_set("display_errors", 0); 	//EVITA MOSTRAR ERRORE DE ALVERTENCIA EN LOS REPORTES
//header( 'Content-Type: text/html;charset=utf-8' ); 
//require_once(APPPATH.'libraries/fpdf181/fpdf.php');
require_once(APPPATH.'libraries/mc_table/mc_table.php');
//class PDF extends FPDF
class PDF extends PDF_MC_Table
{
        private $matris_conf_empresa;
        private $titulo;
        private $registros_totales;
        private $tiene_filtro;
        private $titulo2;

        public function carga_las_variables($matris_conf_empresa, $titulo, $tiene_filtro, $titulo2, $registros_totales){
            $this->matris_conf_empresa      = $matris_conf_empresa;
            $this->titulo                   = $titulo;
            $this->registros_totales        = $registros_totales;
            $this->tiene_filtro             = $tiene_filtro;
            $this->titulo2                  = $titulo2;
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
                $this->Cell(20, 4, $this->ajuste_texto("ID"), 0, 0, 'L', true);
                $this->Cell(20, 4, $this->ajuste_texto("FECHA"), 0, 0, 'L', true);                
                $this->Cell(15, 4, $this->ajuste_texto("HORA"), 0, 0, 'L', true);
                $this->Cell(25, 4, $this->ajuste_texto("IP"), 0, 0, 'L', true);
                $this->Cell(65, 4, $this->ajuste_texto("USUARIO"), 0, 0, 'L', true);
                $this->Cell(115, 4, $this->ajuste_texto("ACCIÓN"), 0, 0, 'L', true);
                $this->Ln();                
	}
        function Footer() //pie de pagina
        {
                $pintar = false;
                $this->SetY(-15);	//Posici?n: en cm del final
                $PosicionX = $this->GetX();		$PosicionY = $this->GetY();
                $this->SetFont('Arial','',8);
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
        // ORDENAR EL FORMATO DE LA FECHA
        //  RECIBE LA FECHA EN FORMATO "2010-07-13" Y LA REGRESA EN "dd-mm-YYYY"
        //Y RECIBE LA FECHA EN FORMATO "dd-mm-YYYY" Y LA REGRESA EN "YYYY-mm-dd"
        public function ordena_fecha($fecha){
                $fecha = explode("-", $fecha);
                $dia = $fecha[2];	$mes = $fecha[1];	$anno = $fecha[0];
                return $dia."-".$mes."-".$anno;
        }        
}

//$html = 'Ahora puede imprimir f&aacute;cilmente texto mezclando diferentes estilos: <b>negrita</b>, <i>itálica</i>, <u>subrayado</u>, o ¡ <b><i><u>todos a la vez</u></i></b>!<br><br>También puede incluir enlaces en el texto, como <a href="http://www.fpdf.org">www.fpdf.org</a>, o en una imagen: pulse en el logotipo.';
//$pdf=new PDF('P','mm','Letter');
//$pdf=new PDF('L','mm','Letter'); //A LO ANCHO
//$pdf=new PDF($matris_conf_empresa);
$pdf=new PDF('L','mm','Letter');
$pdf->SetTitle('Reporte');
$pdf->AliasNbPages();
$pdf->SetMargins(9, 10, 7);
$pdf->SetAutoPageBreak(true,10); //MARGEN INFERIOR

$titulo = "BITACORA";

$tiene_filtro = false;  $titulo2 = "";

if( strlen($b_fecha_desde) > 0      ){ $titulo2 .= ", Fecha desde = ".$b_fecha_desde.""; $tiene_filtro = true; }
if( strlen($b_fecha_hasta) > 0      ){ $titulo2 .= ", Fecha hasta = ".$b_fecha_hasta.""; $tiene_filtro = true; }
if( $b_id_usuario > 0               ){ $titulo2 .= ", Usuario = ".$b_usuario.""; $tiene_filtro = true; }
if( strlen($b_texto) > 0            ){ $titulo2 .= ", Buscar = '".$b_texto."'"; $tiene_filtro = true; }
//if($tiene_filtro == true){ 
//    $titulo .= $titulo2;
//}

$matris_conf_empresa = false;

$registros_totales = 0;
if($matriz_bitacora != false){
    $registros_totales = count($matriz_bitacora);
}
//$titulo2 = $titulo2." ".$titulo2." ";
$pdf->carga_las_variables($matris_conf_empresa, $titulo, $tiene_filtro, $titulo2, $registros_totales);

$pdf->AddPage();
	
//$pdf->Ln();
$pdf->SetFillColor(198,213,235);			
$pdf->SetFont('Arial','',8);
$pintar = false;

/*
                $this->Cell(20, 4, $this->ajuste_texto("ID"), 0, 0, 'L', true);
                $this->Cell(20, 4, $this->ajuste_texto("FECHA"), 0, 0, 'L', true);                
                $this->Cell(20, 4, $this->ajuste_texto("HORA"), 0, 0, 'L', true);
                $this->Cell(20, 4, $this->ajuste_texto("IP"), 0, 0, 'L', true);
                $this->Cell(50, 4, $this->ajuste_texto("USUARIO"), 0, 0, 'L', true);
                $this->Cell(50, 4, $this->ajuste_texto("TABLA"), 0, 0, 'L', true);
                $this->Cell(80, 4, $this->ajuste_texto("ACCIÓN"), 0, 0, 'L', true);
*/
//echo "matriz_bitacora *<pre>"; print_r($matriz_bitacora); echo "</pre>*";
//    [0] => stdClass Object
//        (
//            [conf_bitacora_id] => 3614
//            [conf_bitacora_id_usuario] => 2
//            [conf_bitacora_fecha] => 2020-10-19
//            [conf_bitacora_hora] => 11:16:01
//            [conf_bitacora_tabla_nombre] => 
//            [conf_bitacora_accion] => Inicio session el usuario
//            [conf_bitacora_ip_usuario] => 127.0.0.1
//            [conf_usuarios_ci_usu] => 12345678
//            [conf_usuarios_nombre_usu] => Admin
//            [conf_usuarios_apellido_usu] => Libresofx
//        )
if($matriz_bitacora != false){
    //$pdf->Setcon_borde(false);
    for($i = 0; $i < count($matriz_bitacora); $i++){

            $matriz_bitacora[$i]->conf_bitacora_fecha = $pdf->ordena_fecha($matriz_bitacora[$i]->conf_bitacora_fecha);
        
            $usuario = "(".$matriz_bitacora[$i]->conf_usuarios_ci_usu.") ".$matriz_bitacora[$i]->conf_usuarios_nombre_usu." ".$matriz_bitacora[$i]->conf_usuarios_apellido_usu;
        
            $pdf->SetDrawColor(255,255,255);
            $pdf->SetWidths(array(20,20,15,25,65,115));
            $pdf->SetAligns(array('L','L','L','L','L','L','J'));
            $pdf->Row(array(
                    $pdf->ajuste_texto($matriz_bitacora[$i]->conf_bitacora_id)
                ,   $pdf->ajuste_texto($matriz_bitacora[$i]->conf_bitacora_fecha)
                ,   $pdf->ajuste_texto($matriz_bitacora[$i]->conf_bitacora_hora)
                ,   $pdf->ajuste_texto($matriz_bitacora[$i]->conf_bitacora_ip_usuario)
                ,   $pdf->ajuste_texto($usuario)
                ,   $pdf->ajuste_texto($matriz_bitacora[$i]->conf_bitacora_accion_2)
            ));
            //$pdf->Ln(5);            
    }    
}

$pdf->Output("Bitacora_listado","I");
?>