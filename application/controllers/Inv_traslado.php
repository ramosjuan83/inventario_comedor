<?php
require_once APPPATH.'controllers/Controlador_padre.php';
class Inv_traslado extends Controlador_padre {
    
    function __construct(){
        parent::__construct();
        $this->load->library('Session');
        $this->load->model('Conf_bitacora_model');
        $this->load->model('Conf_usuarios_model');
        $this->load->model('Inv_traslado_model');
        $this->load->model('Inv_articulo_model');
        $this->load->model('Inv_almacen_model');
        $this->load->model('Personal_ivic_model');
    }

    public function listar($memoria = 'false'){

        $logged = $this->Conf_usuarios_model->isLogged();
        $id_conf_roles_es_5 = $this->session->userdata('id_conf_roles_es_5');
        if($logged == TRUE && $id_conf_roles_es_5 == true){ 

                if($memoria == 'limpiar'){
                    $this->session->unset_userdata('inv_traslado_b_texto');
                }
                
                if (	isset ($_POST['b_texto'])	){
                        $b_texto = $_POST['b_texto'];
                        $s_busquedad = array(
                                'inv_traslado_b_texto' => $b_texto
                        );
                        $this->session->set_userdata($s_busquedad);
                }else{
                        $b_texto = "";
                        if( strlen($this->session->userdata('inv_traslado_b_texto')) > 0  ){
                            $b_texto = $this->session->userdata('inv_traslado_b_texto');
                        }
                }
                $b_texto = str_replace("'", "", $b_texto);
                
                if($memoria == 'cargo_ultima_pagina'){
                        $pagina_actual = $this->session->userdata('inv_traslado_ultima_pagina');    
                        $segmento = $pagina_actual;                    
                }else{
                        $pagina_actual = "";
                        $pieces = explode("/", $_SERVER['PHP_SELF']);
                        for($i = 0; $i < count($pieces); $i++) {
                            if($pieces[$i] == 'pagina'){
                                $i_mas1 = $i + 1;
                                if(isset($pieces[$i_mas1])){
                                    $pagina_actual = $pieces[$i_mas1];                            
                                }
                            }
                        }
                        $s_lista = array(
                            'inv_traslado_ultima_pagina' => $pagina_actual
                        );
                        $this->session->set_userdata($s_lista);                    
                        $segmento = $this->uri->segment(4);                    
                }

                $this->load->helper('form');
                $this->load->library('pagination');
                $pages = 8; //Número de registros mostrados por páginas
                $config['base_url'] = base_url().'index.php/inv_traslado/listar/pagina'; // parametro base de la aplicación, si tenemos un .htaccess nos evitamos el index.php
                $total_rows = $this->Inv_traslado_model->inv_traslado_num_reg($b_texto);
                $config['total_rows'] = $total_rows;
                $config['per_page'] = $pages; //Número de registros mostrados por páginas
                $config['uri_segment'] = 4;
                $config['num_links'] = 5; //Número de links mostrados en la paginación
                $config['cur_tag_open'] = '<li class="paginate_button page-item active"><a class="page-link" href="#">';
                $config['cur_tag_close'] = '</a></li>';
                $config['num_tag_open'] = '<li class="paginate_button page-item">';
                $config['num_tag_close'] = '</li>';
                $config['last_link'] = FALSE;
                $config['first_link'] = FALSE;
                $config['next_link'] = '&raquo;';
                $config['next_tag_open'] = '<li class="paginate_button page-item">';
                $config['next_tag_close'] = '</li>';
                $config['prev_link'] = '&laquo;';
                $config['prev_tag_open'] = '<li class="paginate_button page-item">';
                $config['prev_tag_close'] = '</li>';
                $config["cur_page"] = $pagina_actual;
                //$segmento = $this->uri->segment(4);
                if($segmento > 0){}else{$segmento = 0;} //echo "segmento *".$segmento."*";
                $this->pagination->initialize($config); //inicializamos la paginación
                $dat_list = $this->Inv_traslado_model->inv_traslado_buscar($b_texto, $config['per_page'],$segmento);
//echo "<br>dat_list *<pre>"; print_r($dat_list); echo "</pre>*";                
                
                if($dat_list != false){
                    for($i = 0; $i < count($dat_list); $i++){
                        // $traslado_id = $dat_list[$i]->id;  //echo "gerencias_id *".$gerencias_id."*";
                        // unset($matriz_comensales);                        
                        // $matriz_personal_ivic = $this->Personal_ivic_model->personal_ivic_buscar_9($traslado_id);
                        // if($matriz_personal_ivic == false){
                        //     $dat_list[$i]->esta_asociado_en_personal_ivic = false;
                        // }else{
                        //     $dat_list[$i]->esta_asociado_en_personal_ivic = true;
                        // }
                        $dat_list[$i]->esta_asociado_en_personal_ivic = false;   
                    }       
                              
                } 
//echo "<br>dat_list *<pre>"; print_r($dat_list); echo "</pre>*";
                
                
                //Busco los campos de paginacion
                $data['pag_desde'] = 0;
                $data['pag_hasta'] = 0;
                if($dat_list != false){
                    $data['pag_desde']   = $segmento + 1;
                    $data['pag_hasta']   = ($segmento) + count($dat_list);                    
                }
                $data['pag_totales'] = $total_rows;
                //Fin de Busco los campos de paginacion                
                $dat_list['dat_list'] = $dat_list;
                $dat_list['b_texto']  = $b_texto;
                
                //$data['matriz_conf_configuracion'] = $this->Conf_configuracion_model->conf_configuracion_buscar_2();
                $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos2.php";
                $this->load->view('plantilla/header', $data);
                $this->load->view('plantilla/menu');
                $this->load->view('inv_traslado/v_inv_traslado_listar', $dat_list);
                $this->load->view('plantilla/footer');

        }else{
            $this->session->sess_destroy('username');
            //$data['matriz_conf_configuracion'] = $this->Conf_configuracion_model->conf_configuracion_buscar_2();
            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos2.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('login/v_login_1');
            $this->load->view('plantilla/footer');
        }

    }

    public function agregar(){
        $logged = $this->Conf_usuarios_model->isLogged();
        $id_conf_roles_es_5 = $this->session->userdata('id_conf_roles_es_5');

        $matriz_articulos   = $this->Inv_articulo_model->inv_articulo_buscar_1();
        $matriz_almacenes                     = $this->Inv_almacen_model->inv_almacen_buscar_3();

        $data['matriz_articulos']             = $matriz_articulos;
        $data['matriz_almacenes']             = $matriz_almacenes;
       

        if($logged == TRUE && $id_conf_roles_es_5 == true){
            $data['oper'] = "agregar";
            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos2.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('plantilla/menu');
            $this->load->view('inv_traslado/v_inv_traslado_frm', $data);
            $this->load->view('plantilla/footer');                
        }else{
            $this->session->sess_destroy('username');
            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos2.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('login/v_login_1');
            $this->load->view('plantilla/footer');
        }
    }

    public function agregar_guardar(){
        $logged = $this->Conf_usuarios_model->isLogged();
        if($logged == TRUE){            
            $valor = "nombre";          if ( isset($_POST[$valor])              ){	$nombre = ucfirst( $_POST[$valor] );	}else{	$nombre	= "";	}

            $nombre        = $this->convierte_texto($nombre);

            $valor = "id_articulo";          if ( isset($_POST[$valor])              ){	$id_articulo = ucfirst( $_POST[$valor] );	}else{	$id_articulo	= "";	}
            $valor = "fecha";          if ( isset($_POST[$valor])              ){	$fecha = ucfirst( $_POST[$valor] );	}else{	$fecha	= "";	}
            $valor = "id_almacen_origen";          if ( isset($_POST[$valor])              ){	$id_almacen_origen = ucfirst( $_POST[$valor] );	}else{	$id_almacen_origen	= "";	}
            $valor = "id_almacen_destino";          if ( isset($_POST[$valor])              ){	$id_almacen_destino = ucfirst( $_POST[$valor] );	}else{	$id_almacen_destino	= "";	}
            $valor = "cantidad";          if ( isset($_POST[$valor])              ){	$cantidad = ucfirst( $_POST[$valor] );	}else{	$cantidad	= "";	}
            $valor = "capacidad_almacen";          if ( isset($_POST[$valor])              ){	$capacidad_almacen = ucfirst( $_POST[$valor] );	}else{	$capacidad_almacen	= "";	}

            if(strlen($fecha) > 2){     $fecha = $this->ordena_fecha_3($fecha);    }   
            ////Valida reg existente
            //$valido = false;
            //$gerencias_num_reg = $this->Gerencias_model->gerencias_num_reg_2($parametros['nombre']); //echo "cli_clientes_num_reg *".$gerencias_num_reg."*";
            //if($gerencias_num_reg == 0){ $valido = true; }
            //else{
            //        echo "<script language='javascript'>";
            //        echo "alert('El registro no fue incluido, el nombre ya se encuentra en el sistema')";
            //        echo "</script>";
            //        echo "<script language='javascript'>";
            //        echo "window.history.go(-1)";
            //        echo "</script>";
            //}
            ////FIN de Valida reg
            // VALIDACION ORIGEN
            $validoOrigen = true;
            $resultadosOrigen = $this->Inv_movimiento_inventario_model->inv_movimiento_saldo_actual($id_articulo,$id_almacen_origen);
            $arrDatoO=json_encode($resultadosOrigen);

            if($arrDatoO==false){
                $saldoOrigen=0;
            }else{
                if (is_array($resultadosOrigen) || is_object($resultadosOrigen)){
                    foreach ($resultadosOrigen as $value)
                    {
                            $saldoOrigen=$value['saldo_final'];
                    }
                }else{
                    $saldoOrigen=0;
                }
            }

            $disponibleOrigen=floatval($saldoOrigen);
            if($cantidad > $disponibleOrigen){
                $validoOrigen = false;
            }else{
                $validoOrigen = true;
            }

             // VALIDACION DESTINO
            //  $validoDestino = true;
            //  $resultadosDestino = $this->Inv_movimiento_inventario_model->inv_movimiento_saldo_actual($id_articulo,$id_almacen_destino);
            //  $arrDatoO=json_encode($resultadosDestino);
 
            //  if($arrDatoO==false){
            //      $saldoDestino=0;
            //  }else{
            //      if (is_array($resultadosDestino) || is_object($resultadosDestino)){
            //          foreach ($resultadosDestino as $value)
            //          {
            //                  $saldoDestino=$value['saldo_final'];
            //          }
            //      }else{
            //          $saldoDestino=0;
            //      }
            //  }
 
            //  $disponibleDestino=floatval($capacidad_almacen)-floatval($saldoDestino);
            //  if($cantidad > $disponibleDestino){
            //      $validoDestino = false;
            //  }else{
            //      $validoDestino = true;
            //  }

            if($validoOrigen == true){
                    $id = $this->Inv_traslado_model->inv_traslado_insertar($nombre,$id_articulo,$fecha,$id_almacen_origen,$id_almacen_destino,$cantidad);
                    if ($id > 0){
                        $mensaje = "Inserto el traslado con id ".$id;
                        $mensaje_2 = "Inserto el traslado ".$nombre;
                        $s_mensaje = array(
                                'inv_traslado_mensaje_tipo'         => 'alert-success',
                                'inv_traslado_mensaje_contenido'    => 'Registros insertado exitosamente, '.$mensaje_2
                        );
                        $this->session->set_userdata($s_mensaje);
                        $this->insertar_bitacora_2("inv_traslado", $mensaje, $mensaje_2);
                        redirect('inv_traslado/listar/cargo_ultima_pagina');
                    }else{
                        redirect('inv_traslado/agregar');
                    }                    
            }else{

                if($validoOrigen==false){
                    $mensaje_2 = "El Traslado ";
                    $s_mensaje = array(
                    'inv_traslado_mensaje_tipo'         => 'alert-danger',
                    'inv_traslado_mensaje_contenido'    => 'La cantidad es superior a la disponibilidad de almacen Origen, '." ".$disponibleOrigen." ".$mensaje_2);
                    $this->session->set_userdata($s_mensaje);
                    redirect('Inv_traslado/agregar');
                }else{
                    if($validoDestino==false){
                        $mensaje_2 = "El Traslado ";
                        $s_mensaje = array(
                        'inv_traslado_mensaje_tipo'         => 'alert-danger',
                        'inv_traslado_mensaje_contenido'    => 'La cantidad es superior a la disponibilidad de almacen Destino, '." ".$disponibleDestino." ".$mensaje_2);
                        $this->session->set_userdata($s_mensaje);
                        redirect('Inv_traslado/agregar');
                    }
                }
                
            }
        }else{
                    $this->session->sess_destroy('username');
                    $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos2.php";
                    $this->load->view('plantilla/header', $data);
                    $this->load->view('login/v_login_1');
                    $this->load->view('plantilla/footer');
        }
    }

    public function editar($id){

        
        $logged = $this->Conf_usuarios_model->isLogged();
        $id_conf_roles_es_5 = $this->session->userdata('id_conf_roles_es_5');

        $matriz_articulos   = $this->Inv_articulo_model->inv_articulo_buscar_1();
        $matriz_almacenes                     = $this->Inv_almacen_model->inv_almacen_buscar_3();

        $data['matriz_articulos']             = $matriz_articulos;
        $data['matriz_almacenes']             = $matriz_almacenes;

      

        
        if($logged == TRUE && $id_conf_roles_es_5 == true){

            $fila_reg = $this->Inv_traslado_model->inv_traslado_buscar_2($id);   //echo "<pre>"; print_r($fila_reg); echo "</pre>";
            
            $data['fila_registro'] = $fila_reg[0]; 

            if(strlen($fila_reg[0]->fecha_traslado) > 2){
                $fila_reg[0]->fecha_traslado = $this->ordena_fecha_4($fila_reg[0]->fecha_traslado);    
            }
            $data['oper'] = "editar";

            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos2.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('plantilla/menu');
            $this->load->view('inv_traslado/v_inv_traslado_frm', $data);
            $this->load->view('plantilla/footer');
        }else{
            $this->session->sess_destroy('username');
            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos2.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('login/v_login_1');
            $this->load->view('plantilla/footer');
        }
    }

    public function editar_guardar(){
        $logged = $this->Conf_usuarios_model->isLogged();
        if($logged == TRUE){
            $valor = "id";              if ( isset($_POST[$valor]) 	){	$id = $_POST[$valor];                   }else{	$id	= "";	}
            $valor = "nombre";          if ( isset($_POST[$valor])              ){	$nombre = ucfirst( $_POST[$valor] );	}else{	$nombre	= "";	}
           
            $valor = "id_articulo";          if ( isset($_POST[$valor])              ){	$id_articulo = ucfirst( $_POST[$valor] );	}else{	$id_articulo	= "";	}
            $valor = "id_almacen_origen";          if ( isset($_POST[$valor])              ){	$id_almacen_origen = ucfirst( $_POST[$valor] );	}else{	$id_almacen_origen	= "";	}
            $valor = "id_almacen_origen_aux";          if ( isset($_POST[$valor])              ){	$id_almacen_origen_aux = ucfirst( $_POST[$valor] );	}else{	$id_almacen_origen_aux	= "";	}
            $valor = "id_almacen_destino";          if ( isset($_POST[$valor])              ){	$id_almacen_destino = ucfirst( $_POST[$valor] );	}else{	$id_almacen_destino	= "";	}
            $valor = "fecha";          if ( isset($_POST[$valor])              ){	$fecha = ucfirst( $_POST[$valor] );	}else{	$fecha	= "";	}
            $valor = "cantidad";          if ( isset($_POST[$valor])              ){	$cantidad = ucfirst( $_POST[$valor] );	}else{	$cantidad	= "";	}
            $valor = "cantidadAux";          if ( isset($_POST[$valor])              ){	$cantidadAux = ucfirst( $_POST[$valor] );	}else{	$cantidadAux	= "";	}
            $valor = "capacidad_almacen";          if ( isset($_POST[$valor])              ){	$capacidad_almacen = ucfirst( $_POST[$valor] );	}else{	$capacidad_almacen	= "";	}


            // $valor = "aux_almacen_destino";          if ( isset($_POST[$valor])              ){	$aux_almacen_destino = ucfirst( $_POST[$valor] );	}else{	$aux_almacen_destino	= "";	}
            if(strlen($fecha) > 2){     $fecha = $this->ordena_fecha_3($fecha);    }   

            $nombre        = $this->convierte_texto($nombre);

            
            // VALIDACION DE ORIGEN
            $validoOrigen = true;
            $resultadosOrigen = $this->Inv_movimiento_inventario_model->inv_movimiento_saldo_actual($id_articulo,$id_almacen_origen);

            $arrDato=json_encode($resultadosOrigen);
            if($arrDato==false){
                $saldoOrigen=0;
            }else{
                if (is_array($resultadosOrigen) || is_object($resultadosOrigen)){
                    foreach ($resultadosOrigen as $value)
                    {
                            $saldoOrigen=$value['saldo_final'];
                    }
                }else{
                    $saldoOrigen=0;
                }
            }
            // // //echo json_encode($resultados);
            // echo "id_almacen_origen".$id_almacen_origen."id_almacen_origen_aux".$id_almacen_origen_aux;
            // phpinfo();
            
            //if($id_almacen_origen==$id_almacen_origen_aux){
            $disponibleOrigen=$saldoOrigen+$cantidadAux;
            // }else{
            //     $disponibleOrigen=$saldoOrigen;
            // }
            
            if($cantidad > $disponibleOrigen){
                $validoOrigen = false;
            }else{
                $validoOrigen = true;
            }

            // VALIDACION DE DESTINO
            $validoDestino = true;
            $resultadosDestino = $this->Inv_movimiento_inventario_model->inv_movimiento_saldo_actual($id_articulo,$id_almacen_destino);
            $arrDato=json_encode($resultadosDestino);
            if($arrDato==false){
                $saldoDestino=0;
            }else{
                if (is_array($resultadosDestino) || is_object($resultadosDestino)){
                    foreach ($resultadosDestino as $value)
                    {
                            $saldoDestino=$value['saldo_final'];
                    }
                }else{
                    $saldoDestino=0;
                }
            }

            //echo json_encode($resultados);
            $disponibleDestino=floatval($capacidad_almacen)-floatval($saldoDestino)+floatval($cantidadAux);

       
            if($cantidad > $disponibleDestino){
                $validoDestino = false;
            }else{
                $validoDestino = true;
            }

            if($validoOrigen == true && $validoDestino == true){
                if($cantidad != $cantidadAux){
                    $oper_realizada = $this->Inv_traslado_model->inv_traslado_editar($id,$id_articulo,$fecha,$id_almacen_origen,$id_almacen_destino,$cantidad,$nombre,$aux_almacen_origen,$aux_almacen_destino);
                
                
                    //echo "oper_realizada *".$oper_realizada."*";
                    if ($oper_realizada){
                        $mensaje = "Actualizó el traslado con id ".$id;
                        $mensaje_2 = "Actualizó el traslado Nombre".$nombre;
                        $s_mensaje = array(
                                'inv_traslado_mensaje_tipo'  => 'alert-success',
                                'inv_traslado_mensaje_contenido'    => 'Registros actualizado exitosamente, '.$mensaje_2
                        );
                        $this->session->set_userdata($s_mensaje);
                        $this->insertar_bitacora_2("inv_traslado", $mensaje, $mensaje_2);

                        redirect('inv_traslado/listar/cargo_ultima_pagina');
                    }else{
                        redirect('inv_traslado/editar');
                    }

                }else{
                    $mensaje = "Actualizó el traslado con id ".$id;
                        $mensaje_2 = "Actualizó el traslado Nombre".$nombre;
                        $s_mensaje = array(
                                'inv_traslado_mensaje_tipo'  => 'alert-success',
                                'inv_traslado_mensaje_contenido'    => 'Registros actualizado exitosamente, '.$mensaje_2
                        );
                        $this->session->set_userdata($s_mensaje);
                        $this->insertar_bitacora_2("inv_traslado", $mensaje, $mensaje_2);

                        redirect('inv_traslado/listar/cargo_ultima_pagina');
                }
            }else{
                if($validoOrigen == false){
                
                    $mensaje_2 = "El traslado ";
                    $s_mensaje = array(
                    'inv_traslado_mensaje_tipo'         => 'alert-danger',
                    'inv_traslado_mensaje_contenido'    => 'La cantidad es superior a la disponibilidad del almacén origen, '." ".$disponibleOrigen." ".$mensaje_2
                    );
                    $this->session->set_userdata($s_mensaje);
                    redirect('Inv_traslado/editar/'.$id);

                    
                }else{
                    if($validoDestino == false){
                
                        $mensaje_2 = "El traslado ";
                        $s_mensaje = array(
                        'inv_traslado_mensaje_tipo'         => 'alert-danger',
                        'inv_traslado_mensaje_contenido'    => 'La cantidad es superior a la disponibilidad del almacén destino, '." ".$disponibleDestino." ".$mensaje_2
                        );
                        $this->session->set_userdata($s_mensaje);
                        redirect('Inv_traslado/editar/'.$id);
    
                        
                    }
                }
            }
        }else{
            $this->session->sess_destroy('username');
            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos2.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('login/v_login_1');
            $this->load->view('plantilla/footer');            
        }
    }

    public function eliminar($id){
            $logged = $this->Conf_usuarios_model->isLogged();
            $id_conf_roles_es_5 = $this->session->userdata('id_conf_roles_es_5');
            if($logged == TRUE && $id_conf_roles_es_5 == true){
                
                $matriz_traslado = $this->Inv_traslado_model->inv_traslado_buscar_2($id);
                $traslado_nombre = $matriz_traslado[0]->nombres;
                
                //Valida registro relacionado
                $valido = true;
                
                //$num_rows = $this->Pensum_model->pensum_num_reg_4($id);
                //if($num_rows > 0){
                //    $valido = false;
                //    $mensaje = "Error al eliminar, la Carrera con id ".$id." se encuentra asociado con un Pensum";
                //    $mensaje_2 = "Error al eliminar, la Carrera ".$gerencias_nombre." se encuentra asociado con un Pensum";
                //    $s_mensaje = array(
                //            'gerencias_mensaje_tipo'         => 'alert-danger',
                //            'gerencias_mensaje_contenido'    => 'El registro no fue eliminado, '.$mensaje_2
                //    );
                //    $this->session->set_userdata($s_mensaje);
                //    $this->insertar_bitacora_2("gerencias", $mensaje, $mensaje_2);                    
                //}
                //Fin de valida registro relacionado
                if( $valido == true ){
                    $oper_realizada = $this->Inv_traslado_model->inv_traslado_eliminar($id);
                    if ($oper_realizada){
                            $mensaje = "Eliminó el traslado con id ".$id;
                            $mensaje_2 = "Eliminó el traslado ".$traslado_nombre;
                            $s_mensaje = array(
                                    'inv_traslado_mensaje_tipo'         => 'alert-success',
                                    'inv_traslado_mensaje_contenido'    => 'Registros eliminado exitosamente, '.$mensaje_2
                            );
                            $this->session->set_userdata($s_mensaje);
                            $this->insertar_bitacora_2("inv_traslado", $mensaje, $mensaje_2);
                    }                
                }
                redirect('inv_traslado/listar/cargo_ultima_pagina');                
            }else{
                redirect('Login/v_login_mensaje_1');
            }
    }


    
    public function ver_pdf_lista($b_texto){
        $logged = $this->Conf_usuarios_model->isLogged();
        if($logged == TRUE){
            
            // if($b_estado == "NULL"){         $b_estado = "";          }
            // $data['b_estado'] = $b_estado;            
            
            if($b_texto == "NULL"){         $b_texto = "";          }
            $b_texto = str_replace("'", "", $b_texto);
            $b_texto_2 = preg_replace('/^0+/', '', $b_texto); //QUITO LOS CEROS A LA IZQUIERDA
            $b_texto = str_replace("%20", " ", $b_texto); //LE QUITO EL FORMATO DE LOS ESPACIOS ENTRE PALABRAS
            $data['b_texto'] = $b_texto;

            $matriz_traslado = $this->Inv_traslado_model->inv_traslado_buscar($b_texto, "", ""); 

            $data['matriz_traslado'] = $matriz_traslado;   
            
            $this->load->view('inv_traslado/reporte_pdf_lista', $data); 
        }        
    }  

    public function ver_excel_lista($b_texto){
        $logged = $this->Conf_usuarios_model->isLogged();
        if($logged == TRUE){
           
            
            if($b_texto == "NULL"){         $b_texto = "";          }
            $b_texto = str_replace("'", "", $b_texto);
            $b_texto_2 = preg_replace('/^0+/', '', $b_texto); //QUITO LOS CEROS A LA IZQUIERDA
            $b_texto = str_replace("%20", " ", $b_texto); //LE QUITO EL FORMATO DE LOS ESPACIOS ENTRE PALABRAS
            $data['b_texto'] = $b_texto;

            $matriz_traslado = $this->Inv_traslado_model->inv_traslado_buscar($b_texto,"", "", ""); 
            //echo "<br>matriz_personal_visitante *<pre>"; print_r($matriz_personal_visitante); echo "</pre>*";

            $data['matriz_traslado'] = $matriz_traslado;
            
            $this->load->view('inv_traslado/reporte_excel_lista.php', $data);
 
        }        
    } 

    //convierte en mayuscula la primera letra de cada palabra, y coloca el resto en minuscula
    public function convierte_texto($texto){
        $pieces = explode(" ", $texto);
        $texto = "";
        for($i = 0; $i < count($pieces); $i++){
            $pieces[$i] = strtolower($pieces[$i]);
            //$pieces[$i] = ucwords($pieces[$i]); //COLOCA EN MAYUSCULA EL PRIMER CARACTER DE CADA PALABRA DENTRO DE LA CADENA 
            $pieces[$i] = strtoupper($pieces[$i]); //Coloca en mayuscula toda la cadena
            if($i > 0){ $texto .= " "; }
            $texto .= $pieces[$i];
        }
        return $texto;
    }    
    
    public function get_inv_traslado_buscar_5(){
            $nombre     = $this->input->post('nombre');
            $id         = $this->input->post('id');
            $resultados     = $this->Inv_traslado_model->inv_traslado_buscar_5($nombre, $id); //echo "resultados *"; print_r($resultados); echo "*";
            echo json_encode($resultados);
    }

    public function get_inv_traslado_buscar_6(){
            $nombre     = $this->input->post('nombre');
            $resultados = $this->Inv_traslado_model->inv_traslado_buscar_6($nombre); //echo "resultados *"; print_r($resultados); echo "*";
            echo json_encode($resultados);
    }  
    
    // RECIBE LA FECHA EN FORMATO "dd/mm/YYYY" Y LA REGRESA EN "YYYY-mm-dd"
    private function ordena_fecha_3($fecha){
        $parte2 = explode("/", $fecha);
        return $parte2[2]."-".$parte2[1]."-".$parte2[0];
    }  
        // RECIBE LA FECHA EN FORMATO "YYYY-mm-dd" Y LA REGRESA EN "dd/mm/YYYY"
    public function ordena_fecha_4($fecha){
            $parte2 = explode("-", $fecha);
            return $parte2[2]."/".$parte2[1]."/".$parte2[0];
    } 

}
