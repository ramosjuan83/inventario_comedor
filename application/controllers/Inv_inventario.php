<?php
require_once APPPATH.'controllers/Controlador_padre.php';
class Inv_inventario extends Controlador_padre {
    
    function __construct(){
        parent::__construct();
        $this->load->library('Session');
        $this->load->model('Conf_bitacora_model');
        $this->load->model('Conf_usuarios_model');
        $this->load->model('Inv_inventario_model');
        $this->load->model('Inv_movimiento_inventario_model');
        $this->load->model('Inv_articulo_model');
        $this->load->model('Inv_tipo_articulo_model');
        $this->load->model('Inv_almacen_model');
        $this->load->model('Personal_ivic_model');
        $this->load->model('Comedor_comida_tipo_model');
        $this->load->model('Personal_visitante_tipo_model');
        $this->load->model('Estados_model');

    }

    public function listar($memoria = 'false'){

        $logged = $this->Conf_usuarios_model->isLogged();
        $id_conf_roles_es_5 = $this->session->userdata('id_conf_roles_es_5');
        if($logged == TRUE && $id_conf_roles_es_5 == true){ 

                if($memoria == 'limpiar'){
                    $this->session->unset_userdata('inv_inventario_b_texto');
                }
                
    
                if (	isset ($_POST['b_texto'])	){
                        $b_texto = $_POST['b_texto'];
                        $s_busquedad = array(
                                'inv_inventario_b_texto' => $b_texto
                        );
                        $this->session->set_userdata($s_busquedad);
                }else{
                        $b_texto = "";
                        if( strlen($this->session->userdata('inv_inventario_b_texto')) > 0  ){
                            $b_texto = $this->session->userdata('inv_inventario_b_texto');
                        }
                }
                $b_texto = str_replace("'", "", $b_texto);
                
                if($memoria == 'cargo_ultima_pagina'){
                        $pagina_actual = $this->session->userdata('inv_inventario_ultima_pagina');    
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
                            'inv_inventario_ultima_pagina' => $pagina_actual
                        );
                        $this->session->set_userdata($s_lista);                    
                        $segmento = $this->uri->segment(4);                    
                }

                $this->load->helper('form');
                $this->load->library('pagination');
                $pages = 8; //Número de registros mostrados por páginas
                $config['base_url'] = base_url().'index.php/inv_inventario/listar/pagina'; // parametro base de la aplicación, si tenemos un .htaccess nos evitamos el index.php
                $total_rows = $this->Inv_inventario_model->inv_inventario_num_reg($b_texto);
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
                $dat_list = $this->Inv_inventario_model->inv_inventario_buscar($b_texto, $config['per_page'],$segmento);
//echo "<br>dat_list *<pre>"; print_r($dat_list); echo "</pre>*";                
                
                if($dat_list != false){
                    for($i = 0; $i < count($dat_list); $i++){
                        // $inventario_id = $dat_list[$i]->id;  //echo "gerencias_id *".$gerencias_id."*";
                        // unset($matriz_comensales);                        
                        // $matriz_personal_ivic = $this->Personal_ivic_model->personal_ivic_buscar_9($inventario_id);
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
                $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
                $this->load->view('plantilla/header', $data);
                $this->load->view('plantilla/menu');
                $this->load->view('inv_inventario/v_inv_inventario_listar', $dat_list);
                $this->load->view('plantilla/footer');

        }else{
            $this->session->sess_destroy('username');
            //$data['matriz_conf_configuracion'] = $this->Conf_configuracion_model->conf_configuracion_buscar_2();
            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('login/v_login_1');
            $this->load->view('plantilla/footer');
        }

    }


    public function listar_inventario($memoria = 'false'){


        $logged = $this->Conf_usuarios_model->isLogged();
        $id_conf_roles_es_5 = $this->session->userdata('id_conf_roles_es_5');
        if($logged == TRUE && $id_conf_roles_es_5 == true){ 

                if($memoria == 'limpiar'){
                    $this->session->unset_userdata('inv_inventario_b_texto');
                }
                
                if (	isset ($_POST['b_texto'])	){
                        $b_texto = $_POST['b_texto'];
                        $s_busquedad = array(
                                'inv_inventario_b_texto' => $b_texto
                        );
                        $this->session->set_userdata($s_busquedad);
                }else{
                        $b_texto = "";
                        if( strlen($this->session->userdata('inv_inventario_b_texto')) > 0  ){
                            $b_texto = $this->session->userdata('inv_inventario_b_texto');
                        }
                }
                $b_texto = str_replace("'", "", $b_texto);
                
                if($memoria == 'cargo_ultima_pagina'){
                        $pagina_actual = $this->session->userdata('inv_inventario_ultima_pagina');    
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
                            'inv_inventario_ultima_pagina' => $pagina_actual
                        );
                        $this->session->set_userdata($s_lista);                    
                        $segmento = $this->uri->segment(4);                    
                }

                $this->load->helper('form');
                $this->load->library('pagination');
                $pages = 8; //Número de registros mostrados por páginas
                $config['base_url'] = base_url().'index.php/inv_inventario/listar/pagina'; // parametro base de la aplicación, si tenemos un .htaccess nos evitamos el index.php
                $total_rows = $this->Inv_inventario_model->inv_inventario_num_reg($b_texto);
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
                
                $almacen=isset($_POST['id_almacen'])?$_POST['id_almacen']:'';
                $fecha=isset($_POST['fecha_aux'])?$this->ordena_fecha_3($_POST['fecha_aux']):$this->ordena_fecha_4(date("Y-m-d"));

                

                $dat_list = $this->Inv_inventario_model->inv_inventario_buscar_almacen($almacen,$fecha,$config['per_page'],$segmento);
                if(!isset($_POST['id_almacen'])){
                    $dat_list=[];
                }
                $matriz_almacenes                     = $this->Inv_almacen_model->inv_almacen_buscar_3();
                $data['matriz_almacenes']=$matriz_almacenes;

                
//echo "<br>dat_list *<pre>"; print_r($dat_list); echo "</pre>*";                
                //echo "dat_list".$dat_list;
                if($dat_list != false){
                    for($i = 0; $i < count($dat_list); $i++){
                        // $inventario_id = $dat_list[$i]->id;  //echo "gerencias_id *".$gerencias_id."*";
                        // unset($matriz_comensales);                        
                        // $matriz_personal_ivic = $this->Personal_ivic_model->personal_ivic_buscar_9($inventario_id);
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
                $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
                $this->load->view('plantilla/header', $data);
                $this->load->view('plantilla/menu');


                $this->load->view('inv_inventario/v_inv_tomar_inventario_listar', $dat_list);
                $this->load->view('plantilla/footer');

        }else{
            $this->session->sess_destroy('username');
            //$data['matriz_conf_configuracion'] = $this->Conf_configuracion_model->conf_configuracion_buscar_2();
            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
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
            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('plantilla/menu');
            $this->load->view('inv_inventario/v_inv_inventario_frm', $data);
            $this->load->view('plantilla/footer');                
        }else{
            $this->session->sess_destroy('username');
            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
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
            $valor = "id_almacen";          if ( isset($_POST[$valor])              ){	$id_almacen = ucfirst( $_POST[$valor] );	}else{	$id_almacen	= "";	}
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
            ////FIN de Valida reg existente
            $valido = true;
            if($valido == true){
                    $id = $this->Inv_inventario_model->inv_inventario_insertar($id_articulo,$id_almacen,$capacidad_almacen);
                    if ($id > 0){
                        $mensaje = "Inserto el inventario con id ".$id;
                        $mensaje_2 = "Inserto el inventario ".$capacidad_almacen;
                        $s_mensaje = array(
                                'inv_inventario_mensaje_tipo'         => 'alert-success',
                                'inv_inventario_mensaje_contenido'    => 'Registros insertado exitosamente, '.$mensaje_2
                        );
                        $this->session->set_userdata($s_mensaje);
                        $this->insertar_bitacora_2("inv_inventario", $mensaje, $mensaje_2);
                        redirect('inv_inventario/listar/cargo_ultima_pagina');
                    }else{
                        redirect('inv_inventario/agregar');
                    }                    
            }
        }else{
                    $this->session->sess_destroy('username');
                    $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
                    $this->load->view('plantilla/header', $data);
                    $this->load->view('login/v_login_1');
                    $this->load->view('plantilla/footer');
        }
    }

    public function guardar_inventario_ajuste(){
        $logged = $this->Conf_usuarios_model->isLogged();
        $detalle_ajuste= array();
        $ajuste=0;

        foreach ($_POST as $key => $value){
           
            // if($value!='Guardar'){
            //     echo "key: ".$key." valor: ".$value;
            // }
            switch($key){
                case 'almacen_aux':
                    $almacen=$value;
                    break;
                case 'fecha':
                    $fecha=$value;
                    $fecha=$this->ordena_fecha_3($fecha);
                    break;
                case 'observacion':
                        $observacion=$value;
                        break; 
                default:
                    $arr=explode("_",$key);
                    //echo $arr[0];
                    if($arr[0]=='ajuste'){
                        $ajuste=$value;
                    }elseif($arr[0]=='disponible'){

                        array_push($detalle_ajuste, $key."_".$ajuste."_".$value);
                    }

                break;                  
            }
        }



        //phpinfo();


        if($logged == TRUE){            
            // $valor = "nombre";          if ( isset($_POST[$valor])              ){	$nombre = ucfirst( $_POST[$valor] );	}else{	$nombre	= "";	}

            // $nombre        = $this->convierte_texto($nombre);

            // $valor = "id_articulo";          if ( isset($_POST[$valor])              ){	$id_articulo = ucfirst( $_POST[$valor] );	}else{	$id_articulo	= "";	}
            // $valor = "id_almacen";          if ( isset($_POST[$valor])              ){	$id_almacen = ucfirst( $_POST[$valor] );	}else{	$id_almacen	= "";	}
            // $valor = "capacidad_almacen";          if ( isset($_POST[$valor])              ){	$capacidad_almacen = ucfirst( $_POST[$valor] );	}else{	$capacidad_almacen	= "";	}

            // if(strlen($fecha) > 2){     $fecha = $this->ordena_fecha_3($fecha);    }   
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

          

            $resul=$this->Inv_inventario_model->inv_inventario_existe_ajuste($almacen,$fecha);

            ////FIN de Valida reg existente
            $valido = true;
            if($valido == true){


                    $id = $this->Inv_inventario_model->inv_inventario_insertar_ajuste($almacen,$fecha,$observacion);
                    if ($id > 0){

                        foreach($detalle_ajuste as $key => $value){

                            $arr=explode("_",$value);
                            $id_articulo=$arr[1];
                            $monto_ajuste=$arr[2];
                            $monto_disponible=$arr[3];
                            $monto_diferencia=$monto_disponible-$monto_ajuste;
                            
                            $idDetalle = $this->Inv_inventario_model->inv_inventario_insertar_ajuste_detalle($id,$id_articulo,$monto_ajuste,$monto_disponible,$monto_diferencia);
                            
                            if($monto_diferencia <> 0){

                                    // generar movimiento
                                    if($monto_diferencia < 0){
                                        $tipo_documento="aumento";
                                        $monto_diferencia=($monto_diferencia*-1);
                                    }elseif($monto_diferencia > 0){
                                        $tipo_documento="disminucion";
                                    }

                                    $this->Inv_movimiento_inventario_model->inv_movimiento_inventario_insertar($id_articulo,$almacen,$fecha,$monto_diferencia,$id,$tipo_documento,$observacion);
                            }
                        }



                        $mensaje = "Inserto el ajuste de inventario con id ".$id;
                        $mensaje_2 = "Inserto el ajuste detalle de inventario ".$idDetalle;
                        $s_mensaje = array(
                                'inv_inventario_mensaje_tipo'         => 'alert-success',
                                'inv_inventario_mensaje_contenido'    => 'Registros insertado exitosamente, '.$mensaje_2
                        );
                        $this->session->set_userdata($s_mensaje);
                        $this->insertar_bitacora_2("inv_inventario", $mensaje, $mensaje_2);
                        redirect('inv_inventario/listar_inventario/cargo_ultima_pagina');
                    }else{
                        redirect('inv_inventario/listar_inventario');
                    }                    
            }
        }else{
                    $this->session->sess_destroy('username');
                    $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
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

            
            $fila_reg = $this->Inv_inventario_model->inv_inventario_buscar_2($id);   //echo "<pre>"; print_r($fila_reg); echo "</pre>";
            $data['fila_registro'] = $fila_reg[0]; 

            $data['oper'] = "editar";

            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('plantilla/menu');
            $this->load->view('inv_inventario/v_inv_inventario_frm', $data);
            $this->load->view('plantilla/footer');
        }else{
            $this->session->sess_destroy('username');
            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
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
            $valor = "id_almacen";          if ( isset($_POST[$valor])              ){	$id_almacen = ucfirst( $_POST[$valor] );	}else{	$id_almacen	= "";	}
            $valor = "capacidad_almacen";          if ( isset($_POST[$valor])              ){	$capacidad_almacen = ucfirst( $_POST[$valor] );	}else{	$capacidad_almacen	= "";	}  

            $nombre        = $this->convierte_texto($nombre);
            
            $valido = true;
            if($valido == true){
                $oper_realizada = $this->Inv_inventario_model->inv_inventario_editar($id,$id_articulo,$id_almacen,$capacidad_almacen);
                //echo "oper_realizada *".$oper_realizada."*";
                if ($oper_realizada){
                    $mensaje = "Actualizó la unidad medida con id ".$id;
                    $mensaje_2 = "Actualizó la unidad medida ".$nombre;
                    $s_mensaje = array(
                            'inv_inventario_mensaje_tipo'  => 'alert-success',
                            'inv_inventario_mensaje_contenido'    => 'Registros actualizado exitosamente, '.$mensaje_2
                    );
                    $this->session->set_userdata($s_mensaje);
                    $this->insertar_bitacora_2("inv_inventario", $mensaje, $mensaje_2);

                    redirect('inv_inventario/listar/cargo_ultima_pagina');
                }else{
                    redirect('inv_inventario/editar');
                }
            }
        }else{
            $this->session->sess_destroy('username');
            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('login/v_login_1');
            $this->load->view('plantilla/footer');            
        }
    }

    public function eliminar($id){
            $logged = $this->Conf_usuarios_model->isLogged();
            $id_conf_roles_es_5 = $this->session->userdata('id_conf_roles_es_5');
            if($logged == TRUE && $id_conf_roles_es_5 == true){
                
                $matriz_inventario = $this->Inv_inventario_model->inv_inventario_buscar_2($id);
                $inventario_nombre = $matriz_inventario[0]->nombres;
                
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
                    $oper_realizada = $this->Inv_inventario_model->inv_inventario_eliminar($id);
                    if ($oper_realizada){
                            $mensaje = "Eliminó el unidad medida con id ".$id;
                            $mensaje_2 = "Eliminó el unidad medida ".$inventario_nombre;
                            $s_mensaje = array(
                                    'inv_inventario_mensaje_tipo'         => 'alert-success',
                                    'inv_inventario_mensaje_contenido'    => 'Registros eliminado exitosamente, '.$mensaje_2
                            );
                            $this->session->set_userdata($s_mensaje);
                            $this->insertar_bitacora_2("inv_inventario", $mensaje, $mensaje_2);
                    }                
                }
                redirect('inv_inventario/listar/cargo_ultima_pagina');                
            }else{
                redirect('Login/v_login_mensaje_1');
            }
    }

    public function get_inv_movimiento_saldo_actual(){
        $almacen     = $this->input->post('almacen');
        $articulo     = $this->input->post('articulo');

        $resultados = $this->Inv_movimiento_inventario_model->inv_movimiento_saldo_actual($articulo,$almacen); //echo "resultados *"; print_r($resultados); echo "*";

        echo json_encode($resultados);
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
    
    public function get_inv_inventario_buscar_5(){
            $nombre     = $this->input->post('nombre');
            $id         = $this->input->post('id');
            $resultados     = $this->Inv_inventario_model->inv_inventario_buscar_5($nombre, $id); //echo "resultados *"; print_r($resultados); echo "*";
            echo json_encode($resultados);
    }

    public function get_inv_inventario_buscar_6(){
            $nombre     = $this->input->post('nombre');
            $resultados = $this->Inv_inventario_model->inv_inventario_buscar_6($nombre); //echo "resultados *"; print_r($resultados); echo "*";
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

    


    public function reporte_form(){

        $logged = $this->Conf_usuarios_model->isLogged();
        $id_conf_roles_es_5 = $this->session->userdata('id_conf_roles_es_5');
        $id_conf_roles_es_3 = $this->session->userdata('id_conf_roles_es_3');
        $logged = $this->Conf_usuarios_model->isLogged();
        if($logged == TRUE && ($id_conf_roles_es_3 == true OR $id_conf_roles_es_5 == true)){

            $matriz_articulos   = $this->Inv_articulo_model->inv_articulo_buscar_1();
            $matriz_almacenes   = $this->Inv_almacen_model->inv_almacen_buscar_3();
    
            $data['matriz_articulos']             = $matriz_articulos;
            $data['matriz_almacenes']             = $matriz_almacenes;
            
            $data['oper'] = "reporte_form";
            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('plantilla/menu');
            $this->load->view('reporte_estadistica/v_estadistica_frm_2', $data);
            $this->load->view('plantilla/footer');
        }else{
                    $this->session->sess_destroy('username');
                    $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
                    $this->load->view('plantilla/header', $data);
                    $this->load->view('login/v_login_1');
                    $this->load->view('plantilla/footer');
        }
    } 


    public function llama_reporte_form($id_articulo,$id_almacen,$formato){
        $logged = $this->Conf_usuarios_model->isLogged();
        if($logged == TRUE){


            $matriz_movimientos   = $this->Inv_movimiento_inventario_model->inv_inventario_estadistica($id_articulo,$id_almacen);
            
            //echo "id_articulo".$id_articulo." id_almacen".$id_almacen;

             if($id_articulo!=null && $id_articulo!='null'){
                $resulArt = $this->Inv_articulo_model->inv_articulo_buscar_2($id_articulo);
                $nombre_articulo=$resulArt[0]->nombre;
                
             }else{
                $nombre_articulo="null";
             }

             if($id_almacen!=null && $id_almacen!='null'){
                $resulAlm = $this->Inv_almacen_model->inv_almacen_buscar_2($id_almacen);
                $nombre_almacen=$resulAlm[0]->nombre;

            }else{
               $nombre_almacen="null";
            }
           
           // phpinfo();
            //filtros
            $data['nombre_articulo']=$nombre_articulo;
            $data['nombre_almacen']=$nombre_almacen;

            //detalles
            $data['matriz_estadisticas']  = $matriz_movimientos;

            if($formato == "pdf"){
                $this->load->view('reporte_estadistica/reporte_estadisticas.php', $data);        
            }
            if($formato == "excel"){
                $this->load->view('reporte_estadistica/reporte_estadistica_excel.php', $data);
            }
        }    
    }    

        
    public function reporte_general_form(){

        $logged = $this->Conf_usuarios_model->isLogged();
        $id_conf_roles_es_5 = $this->session->userdata('id_conf_roles_es_5');
        $id_conf_roles_es_3 = $this->session->userdata('id_conf_roles_es_3');
        $logged = $this->Conf_usuarios_model->isLogged();
        if($logged == TRUE && ($id_conf_roles_es_3 == true OR $id_conf_roles_es_5 == true)){

            $matriz_articulos   = $this->Inv_articulo_model->inv_articulo_buscar_1();
            $matriz_almacenes   = $this->Inv_almacen_model->inv_almacen_buscar_3();
            $matriz_tipo_articulos   = $this->Inv_tipo_articulo_model->inv_tipo_articulo_buscar_3();

            $data['matriz_articulos']             = $matriz_articulos;
            $data['matriz_almacenes']             = $matriz_almacenes;
            $data['matriz_tipo_articulos']             = $matriz_tipo_articulos;

            
            $data['oper'] = "reporte_form";
            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('plantilla/menu');
            $this->load->view('reporte_general/v_general_frm_2', $data);
            $this->load->view('plantilla/footer');
        }else{
                    $this->session->sess_destroy('username');
                    $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
                    $this->load->view('plantilla/header', $data);
                    $this->load->view('login/v_login_1');
                    $this->load->view('plantilla/footer');
        }
    } 


    public function llama_reporte_general_form($id_articulo,$id_almacen,$fecha_desde,$fecha_hasta,$formato){

        // echo "id_articulo".$id_articulo."id_almacen".$id_almacen."fecha_desde".$fecha_desde."fecha_hasta".$fecha_hasta."fomato".$formato;
        // phpinfo();
        $logged = $this->Conf_usuarios_model->isLogged();
        if($logged == TRUE){


            //$matriz_movimientos   = $this->Inv_articulo_model->inv_reporte_articulo($id_articulo,$id_almacen,$fecha_desde,$fecha_hasta,$id_tipo_articulo);
            $matriz_movimientos   = $this->Inv_inventario_model->inv_inventario_general($id_articulo,$id_almacen,$fecha_desde,$fecha_hasta);
            
            //echo "id_articulo".$id_articulo." id_almacen".$id_almacen;

             if($id_articulo!=null && $id_articulo!='null'){
                $resulArt = $this->Inv_articulo_model->inv_articulo_buscar_2($id_articulo);
                $nombre_articulo=$resulArt[0]->nombre;
                
             }else{
                $nombre_articulo="null";
             }

             if($id_almacen!=null && $id_almacen!='null'){
                $resulAlm = $this->Inv_almacen_model->inv_almacen_buscar_2($id_almacen);
                $nombre_almacen=$resulAlm[0]->nombre;

            }else{
               $nombre_almacen="null";
            }
           
            // if($id_tipo_articulo!=null && $id_tipo_articulo!='null'){
            //     $resulArt = $this->Inv_tipo_articulo_model->inv_tipo_articulo_buscar_2($id_tipo_articulo);
            //     $nombre_tipo_articulo=$resulArt[0]->nombre;
                
            //  }else{
            //     $nombre_tipo_articulo="null";
            //  }
           // phpinfo();
            //filtros
            $data['nombre_articulo']=$nombre_articulo;
            $data['nombre_almacen']=$nombre_almacen;
            $data['fecha_desde']=$fecha_desde;
            $data['fecha_hasta']=$fecha_hasta;
            //$data['nombre_tipo_articulo']=$nombre_tipo_articulo;


            //detalles
            $data['matriz_generales']  = $matriz_movimientos;

            if($formato == "pdf"){
                $this->load->view('reporte_general/reporte_generales.php', $data);        
            }
            if($formato == "excel"){
                $this->load->view('reporte_general/reporte_general_excel.php', $data);
            }
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

            $matriz_inventarios = $this->Inv_inventario_model->inv_inventario_buscar($b_texto, "", ""); 

            $data['matriz_inventarios'] = $matriz_inventarios;   
            
            $this->load->view('inv_inventario/reporte_pdf_lista', $data); 
        }        
    }
    
    public function ver_pdf_lista_toma_inventario($b_texto){


        $arr=explode('_',$b_texto);
        $b_texto=$arr[0];
        $fecha=$arr[3]."-".$arr[2]."-".$arr[1];
        
        $logged = $this->Conf_usuarios_model->isLogged();
        if($logged == TRUE){


            $data['matriz_inventarios']=[];

            // if($b_estado == "NULL"){         $b_estado = "";          }
            // $data['b_estado'] = $b_estado;            
            
            if($b_texto == "NULL"){         $b_texto = "";          }
            $b_texto = str_replace("'", "", $b_texto);
            $b_texto_2 = preg_replace('/^0+/', '', $b_texto); //QUITO LOS CEROS A LA IZQUIERDA
            $b_texto = str_replace("%20", " ", $b_texto); //LE QUITO EL FORMATO DE LOS ESPACIOS ENTRE PALABRAS
            $data['b_texto'] = $b_texto;

            $matriz_inventarios = $this->Inv_inventario_model->inv_inventario_buscar_almacen($b_texto,$fecha ,"", ""); 

            $data['matriz_inventarios'] = $matriz_inventarios;   
            
            $this->load->view('inv_inventario/reporte_pdf_lista_ajuste', $data); 
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

            $matriz_inventarios = $this->Inv_inventario_model->inv_inventario_buscar($b_texto,"", "", ""); 
            //echo "<br>matriz_personal_visitante *<pre>"; print_r($matriz_personal_visitante); echo "</pre>*";

            $data['matriz_inventarios'] = $matriz_inventarios;
            
            $this->load->view('inv_inventario/reporte_excel_lista.php', $data);
 
        }        
    }        

    // public function reporte_general_form(){

    //     $logged = $this->Conf_usuarios_model->isLogged();
    //     $id_conf_roles_es_5 = $this->session->userdata('id_conf_roles_es_5');
    //     $id_conf_roles_es_3 = $this->session->userdata('id_conf_roles_es_3');
    //     $logged = $this->Conf_usuarios_model->isLogged();
    //     if($logged == TRUE && ($id_conf_roles_es_3 == true OR $id_conf_roles_es_5 == true)){

    //         $matriz_articulos   = $this->Inv_articulo_model->inv_articulo_buscar_1();
    //         $matriz_almacenes   = $this->Inv_almacen_model->inv_almacen_buscar_3();

    //         $data['matriz_articulos']             = $matriz_articulos;
    //         $data['matriz_almacenes']             = $matriz_almacenes;


            
    //         $data['oper'] = "reporte_form";
    //         $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
    //         $this->load->view('plantilla/header', $data);
    //         $this->load->view('plantilla/menu');
    //         $this->load->view('reporte_general/v_general_frm_2', $data);
    //         $this->load->view('plantilla/footer');
    //     }else{
    //                 $this->session->sess_destroy('username');
    //                 $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
    //                 $this->load->view('plantilla/header', $data);
    //                 $this->load->view('login/v_login_1');
    //                 $this->load->view('plantilla/footer');
    //     }
    // } 


    // public function llama_reporte_general_form($id_articulo,$id_almacen,$fecha_desde,$fecha_hasta,$formato){

    //     // echo "id_articulo".$id_articulo."id_almacen".$id_almacen."fecha_desde".$fecha_desde."fecha_hasta".$fecha_hasta."fomato".$formato;
    //     // phpinfo();
    //     $logged = $this->Conf_usuarios_model->isLogged();
    //     if($logged == TRUE){


    //         $matriz_movimientos   = $this->Inv_inventario_model->inv_inventario_general($id_articulo,$id_almacen,$fecha_desde,$fecha_hasta);
            
    //         //echo "id_articulo".$id_articulo." id_almacen".$id_almacen;

    //          if($id_articulo!=null && $id_articulo!='null'){
    //             $resulArt = $this->Inv_articulo_model->inv_articulo_buscar_2($id_articulo);
    //             $nombre_articulo=$resulArt[0]->nombre;
                
    //          }else{
    //             $nombre_articulo="null";
    //          }

    //          if($id_almacen!=null && $id_almacen!='null'){
    //             $resulAlm = $this->Inv_almacen_model->inv_almacen_buscar_2($id_almacen);
    //             $nombre_almacen=$resulAlm[0]->nombre;

    //         }else{
    //            $nombre_almacen="null";
    //         }
           
    //         // if($id_tipo_articulo!=null && $id_tipo_articulo!='null'){
    //         //     $resulArt = $this->Inv_tipo_articulo_model->inv_tipo_articulo_buscar_2($id_tipo_articulo);
    //         //     $nombre_tipo_articulo=$resulArt[0]->nombre;
                
    //         //  }else{
    //         //     $nombre_tipo_articulo="null";
    //         //  }
    //        // phpinfo();
    //         //filtros
    //         $data['nombre_articulo']=$nombre_articulo;
    //         $data['nombre_almacen']=$nombre_almacen;
    //         $data['fecha_desde']=$fecha_desde;
    //         $data['fecha_hasta']=$fecha_hasta;



    //         //detalles
    //         $data['matriz_generales']  = $matriz_movimientos;

    //         if($formato == "pdf"){
    //             $this->load->view('reporte_general/reporte_generales.php', $data);        
    //         }
    //         if($formato == "excel"){
    //             $this->load->view('reporte_general/reporte_general_excel.php', $data);
    //         }
    //     }    
    // }    

}
