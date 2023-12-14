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
                    FROM personal_ivic
                    WHERE (personal_ivic.imagen_nombre = ''
                        OR personal_ivic.imagen_nombre IS NULL
                        )
                    ORDER BY personal_ivic.cedula ASC
                    "; //echo "consulta *".$consulta."*";
	$resultado = mysqli_query( $conexion, $consulta ) or die ( "Algo ha ido mal en la consulta a la base de datos");
	
        //echo "resultado <pre>"; print_r($resultado); echo "</pre>";
        
        unset($matriz); $x = 0;
	while ($columna = mysqli_fetch_array( $resultado ))
	{
            $matriz[$x] = $columna;
            $x++;
	}
	//echo "matriz <pre>"; print_r($matriz); echo "</pre>";
        unset($matriz_productos_sin_montos);
        for($i = 0; $i < count($matriz); $i++) {
            $i_mas_1 = $i + 1;
           
            //echo "<br>";
            //echo " ".$i_mas_1;
            //echo " (".$matriz[$i]['personal_ivic_cedula'].")";
            //echo " ".$matriz[$i]['personal_ivic_nombres'];
            //echo " ".$matriz[$i]['personal_ivic_apellidos'];
            //echo " ".$matriz[$i]['personal_ivic_imagen_nombre'];                
            $imagen_nombre = $matriz[$i]['personal_ivic_cedula'].".jpg";
            $consulta = "
                UPDATE 
                    personal_ivic
                SET imagen_nombre = '".$imagen_nombre."'
                WHERE personal_ivic.id = '".$matriz[$i]['personal_ivic_id']."'
                ";  echo "<hr> ".$i_mas_1." consulta *".$consulta."*";
                $resultado = mysqli_query( $conexion, $consulta ) or die ( "Algo ha ido mal en la consulta a la base de datos");
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