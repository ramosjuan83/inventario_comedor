<?php
	// Datos de la base de datos
        //$usuario = "admcomedor";
        //$password = "adm.ysql.ivic2023";
        //$servidor = "190.170.128.163";
	$usuario = "root";
	$password = "linux";
	$servidor = "localhost";        
	$basededatos = "db_ivic_sistema_integral";
        
	// creación de la conexión a la base de datos con mysql_connect()
	$conexion = mysqli_connect( $servidor, $usuario, $password ) or die ("No se ha podido conectar al servidor de Base de datos");
	
	// Selección del a base de datos a utilizar
	$db = mysqli_select_db( $conexion, $basededatos ) or die ( "Upps! Pues va a ser que no se ha podido conectar a la base de datos" );

	// establecer y realizar consulta. guardamos en variable.
        
        //personal_ivic
        //    id
        //    cedula
        //    nombres
        //    apellidos
        //    id_cargo
        //    id_gerencia
        //    estado
        //    imagen_nombre
        //    carnet_codigo
	$consulta = "
                    SELECT 
                          personal_ivic.id  AS personal_ivic_id
                        , personal_ivic.cedula  AS personal_ivic_cedula
                        , personal_ivic.nombres  AS personal_ivic_nombres
                        , personal_ivic.apellidos  AS personal_ivic_apellidos
                        , personal_ivic.imagen_nombre  AS personal_ivic_imagen_nombre
                        , personal_ivic.carnet_codigo  AS personal_ivic_carnet_codigo
                    FROM personal_ivic
                    ORDER BY personal_ivic.cedula ASC
                    ";
	$resultado = mysqli_query( $conexion, $consulta ) or die ( "Algo ha ido mal en la consulta a la base de datos");
	
        //echo "resultado <pre>"; print_r($resultado); echo "</pre>";
        
        unset($matriz); $x = 0;
	while ($columna = mysqli_fetch_array( $resultado ))
	{
            $matriz[$x] = $columna;
            $x++;
	}
	//echo "matriz <pre>"; print_r($matriz); echo "</pre>";
        unset($matriz_productos_sin_montos);    $x = 0;
        
        //________________________________________________________________________________
        //Busco El numero y las personas con fotos faltantes
        echo "<strong>Personal Ivic con Fotos faltantes</strong>";
        $num_fotos_faltantes = 0; //$num_reg_campo_foto_en_blanco = 0;
        $x = 0;
        for($i = 0; $i < count($matriz); $i++) {
            $i_mas_1 = $i + 1;
           
            $tiene_foto_faltante = false;
            
            if($matriz[$i]['personal_ivic_imagen_nombre'] == ""){
                $tiene_foto_faltante = true;
                //$num_reg_campo_foto_en_blanco = $num_reg_campo_foto_en_blanco + 1;
            }
            
            $ruta = "images/personal_ivic/".$matriz[$i]['personal_ivic_imagen_nombre']; //echo "ruta *".$ruta."*";
            if(file_exists($ruta) == true){
            }else{
                $tiene_foto_faltante = true;
            } 
            
            
            if($tiene_foto_faltante == true){
                  $x = $x + 1;
                echo "<br>";
                echo "*".$x."*";
                echo " cedula <strong>".$matriz[$i]['personal_ivic_cedula']."</strong>";
                echo " carnet <strong>".$matriz[$i]['personal_ivic_carnet_codigo']."</strong>";
                echo " ".$matriz[$i]['personal_ivic_nombres'];
                echo " ".$matriz[$i]['personal_ivic_apellidos'];
                
                
                //echo " ".$matriz[$i]['personal_ivic_imagen_nombre'];                
            }
            
        }   
        $num_fotos_faltantes = $x;
        //FIN DE Busco El numero y las personas con fotos faltantes
        //________________________________________________________________________________
        
        
        //________________________________________________________________________________
        //BUSCO LAS IMAGENES REPETIDAS
        /*
        unset($matriz_reg_con_imagenes_repetidas);
        $x = 0;
        for($i = 0; $i < count($matriz); $i++) {
            $tiene_imagen_repetida = false; 
            if($i < count($matriz)){
                for($j = $i + 1; $j < count($matriz); $j++) {
                    if($matriz[$j]['personal_ivic_imagen_nombre'] != ""){
                        if($matriz[$j]['personal_ivic_imagen_nombre'] == $matriz[$i]['personal_ivic_imagen_nombre']){
                            $tiene_imagen_repetida = true;
                        }                        
                    }
                }                
            }
            
            if( $tiene_imagen_repetida == true ){
                $matriz_reg_con_imagenes_repetidas[$x] = $matriz[$i];
                $x = $x + 1;
            }
        } */
        //FIN DE BUSCO LAS IMAGENES REPETIDAS
        //________________________________________________________________________________
        
        
        //________________________________________________________________________________
        //BUSCO LOS ARCHIVOS SOBRANTES $archivos_sin_registros
        $arrFiles = glob('images/personal_ivic/*');
        //echo "<br />arrFiles *<pre>"; print_r($arrFiles); echo "</pre>*";
        //[0] => images/personal_ivic/10038163.jpg
        //[1] => images/personal_ivic/10040537.jpg
        //[2] => images/personal_ivic/10116393.jpg
        //[3] => images/personal_ivic/10172885.jpg        
        unset($archivos_sin_registros);
        $y = 0;
        for($i = 0; $i < count($arrFiles); $i++) {
            $arrFiles[$i] = str_replace("images/personal_ivic/", "", $arrFiles[$i]);
            //echo "<br />".$arrFiles[$i];
            //BUSCO SI TIENE REGISTRO ASCOCIADO
            $tiene_registro_asociado = false;
            if($arrFiles[$i] == "sin_imagen.png"){ $tiene_registro_asociado = true; }
            for($j = 0; $j < count($matriz); $j++) {
                if($matriz[$j]['personal_ivic_imagen_nombre'] == $arrFiles[$i]){
                    $tiene_registro_asociado = true;
                }
            }
            //FIN DE BUSCO SI TIENE REGISTRO ASCOCIADO
            if($tiene_registro_asociado == false){
                //echo "<br />".$arrFiles[$i];
                $archivos_sin_registros[$y]['nombre'] = $arrFiles[$i];
                $y  = $y + 1;
            }
        }
        $fotos_cargadas_totales = count($arrFiles) - 1;
        //________________________________________________________________________________
        
        
        
        
        //$fotos_cargadas = count($matriz) - $x;
        $fotos_cargadas = "";
        echo "<hr><strong>RESUMEN</strong>";        
        echo "<br />";
        echo "<br />Registros Total personal ivic *<strong>".count($matriz)."</strong>*";
        
        echo " <br />Registros sin Fotos asociadas <strong>".$num_fotos_faltantes."</strong>";
        //echo " <br />Registros con campo foto en blanco ".$num_reg_campo_foto_en_blanco;
        
        //echo " <br />";
        //echo " <br />Fotos Cargadas ".$fotos_cargadas;
        //echo " <br />Registros con nombre de imagen repetida ".count($matriz_reg_con_imagenes_repetidas);
//        for($i = 0; $i < count($matriz_reg_con_imagenes_repetidas); $i++) {
//            $i_mas_1 = $i + 1;
//            echo "<br>";
//            echo "*".$i_mas_1."*";
//            echo " (".$matriz_reg_con_imagenes_repetidas[$i]['personal_ivic_cedula'].")";
//            echo " ".$matriz_reg_con_imagenes_repetidas[$i]['personal_ivic_nombres'];
//            echo " ".$matriz_reg_con_imagenes_repetidas[$i]['personal_ivic_apellidos'];
//            echo " *".$matriz_reg_con_imagenes_repetidas[$i]['personal_ivic_imagen_nombre']."*";             
//            
//            //unlink('images/personal_ivic/'.$archivos_sin_registros[$i]['nombre']); 
//        }        
        
        $fotos_con_registro = $fotos_cargadas_totales - count($archivos_sin_registros);
        
        echo " <br />";
        echo " <br />Fotos cargadas TOTALES ".$fotos_cargadas_totales;
        echo " <br />Fotos sin registro ".count($archivos_sin_registros);
        echo " <br />Fotos con registro <strong>".$fotos_con_registro."</strong>";
        
        echo "<br /><hr>";
        echo "<br /><strong>Archivos sin registros</strong>";
        for($i = 0; $i < count($archivos_sin_registros); $i++) {
            $i_mas_1 = $i + 1;
            echo "<br />".$i_mas_1." *".$archivos_sin_registros[$i]['nombre']."*";
            //unlink('images/personal_ivic/'.$archivos_sin_registros[$i]['nombre']); 
        }
        
        
   //echo "matriz <pre>"; print_r($matriz); echo "</pre>";
        
//	echo "</table>"; // Fin de la tabla
        
        
        
        //echo "<hr>termino";
        //echo "<br >****************************************************************************************************";
        

	// cerrar conexión de base de datos
	mysqli_close( $conexion );

    function convertir_tasa_base_a_dolar($monto_tasa_base, $taza_de_dolar_actual){
            //$matriz_conf_sistema = $this->Conf_sistema_model->conf_sistema_buscar_2(3);  //echo "matriz_conf_sistema <pre>"; print_r($matriz_conf_sistema); echo "</pre>";
            //$taza_de_dolar_actual = $matriz_conf_sistema[0]->valor_2;
            //1$    ->  $taza_de_dolar_actual 
            //X     ->  $monto_tasa_base
            $monto_tasa_dolar = $monto_tasa_base / $taza_de_dolar_actual;
            //echo "monto_tasa_dolar *".$monto_tasa_dolar."*";
            return $monto_tasa_dolar;
    }        
        
?>