<?php
require_once APPPATH.'controllers/Controlador_padre.php';
class Comensal extends Controlador_padre {
    
    function __construct(){
        parent::__construct();
        $this->load->library('Session');
        $this->load->model('Conf_bitacora_model');
        $this->load->model('Conf_usuarios_model');
        $this->load->model('Comensal_model');
        $this->load->model('Personal_ivic_model');
        $this->load->model('Cargos_model');
        $this->load->model('Gerencias_model');
        $this->load->model('Comedor_comida_tipo_model');
        $this->load->model('Personal_visitante_model');
        $this->load->model('Personal_visitante_tipo_model');
        $this->load->model('Estados_temporales_model');
        $this->load->model('Tipo_model');
        $this->load->model('Comensales_programacion_model');
        $this->load->model('Comensales_h_estado_temporal_model');
        $this->load->model('Estados_model');
    }

    public function listar($memoria = 'false'){
        $logged = $this->Conf_usuarios_model->isLogged();
        $id_conf_roles_es_3 = $this->session->userdata('id_conf_roles_es_3');
        if($logged == TRUE && $id_conf_roles_es_3 == true){ 

                if($memoria == 'limpiar'){
                    $this->session->unset_userdata('personal_b_texto');
                }
                
                if (	isset ($_POST['b_texto'])	){
                        $b_texto = $_POST['b_texto'];
                        $s_busquedad = array(
                                'personal_b_texto' => $b_texto
                        );
                        $this->session->set_userdata($s_busquedad);
                }else{
                        $b_texto = "";
                        if( strlen($this->session->userdata('personal_b_texto')) > 0  ){
                            $b_texto = $this->session->userdata('personal_b_texto');
                        }
                }
                $b_texto = str_replace("'", "", $b_texto);
                
                if($memoria == 'cargo_ultima_pagina'){
                        $pagina_actual = $this->session->userdata('personal_ultima_pagina');    
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
                            'personal_ultima_pagina' => $pagina_actual
                        );
                        $this->session->set_userdata($s_lista);                    
                        $segmento = $this->uri->segment(4);                    
                }

                $this->load->helper('form');
                $this->load->library('pagination');
                $pages = 8; //Número de registros mostrados por páginas
                $config['base_url'] = base_url().'index.php/Comensal/listar/pagina'; // parametro base de la aplicación, si tenemos un .htaccess nos evitamos el index.php
                $total_rows = $this->Comensal_model->comensales_num_reg($b_texto);
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
                //$dat_list = $this->Cargos_model->cargos_buscar($b_texto, $config['per_page'],$segmento);
                $dat_list = $this->Comensal_model->comensales_buscar($b_texto, $config['per_page'],$segmento);
                //echo "<br>dat_list *<pre>"; print_r($dat_list); echo "</pre>*";                
                //[0] => stdClass Object
                //    (
                //        [comensales_id] => 1096
                //        [comensales_id_personal_ivic] => 258
                //        [comensales_id_personal_visitante] => 
                //        [comensales_fecha] => 2023-06-01
                //        [comensales_hora] => 09:44:24
                //        [comensales_estatus] => 2
                //    )
                
                if($dat_list != false){
                    for($i = 0; $i < count($dat_list); $i++){
                        $dat_list[$i]->carnet = "";
                        $dat_list[$i]->cedula = "";
                        $dat_list[$i]->nombres = "";
                        $dat_list[$i]->apellidos = "";
                        if($dat_list[$i]->comensales_id_personal_ivic > 0){
                            $matriz_personal_ivic = $this->Personal_ivic_model->personal_ivic_buscar_2($dat_list[$i]->comensales_id_personal_ivic);
                            $dat_list[$i]->carnet       = $matriz_personal_ivic[0]->carnet_codigo;
                            $dat_list[$i]->cedula       = $matriz_personal_ivic[0]->cedula;
                            $dat_list[$i]->nombres      = $matriz_personal_ivic[0]->nombres;
                            $dat_list[$i]->apellidos    = $matriz_personal_ivic[0]->apellidos;
                        }
                        if($dat_list[$i]->comensales_id_personal_visitante > 0){
                            $matriz_personal_visitante = $this->Personal_visitante_model->personal_visitante_buscar_2($dat_list[$i]->comensales_id_personal_visitante);
                            $dat_list[$i]->cedula       = $matriz_personal_visitante[0]->cedula;
                            $dat_list[$i]->nombres      = $matriz_personal_visitante[0]->nombres;
                            $dat_list[$i]->apellidos    = $matriz_personal_visitante[0]->apellidos;
                        }   
                        
                        $dat_list[$i]->comensales_fecha = $this->ordena_fecha($dat_list[$i]->comensales_fecha);
                        
                        $matriz_comedor_comida_tipo = $this->Comedor_comida_tipo_model->comedor_comida_tipo_buscar_3($dat_list[$i]->comensales_id_comedor_comida_tipo);
                        $dat_list[$i]->comedor_comida_tipo_nombre = $matriz_comedor_comida_tipo[0]->nombre;
                        
                        //comensales_id_personal_ivic
                        /*
                        $cargos_id = $dat_list[$i]->id;  //echo "cargos_id *".$cargos_id."*";
                        unset($matriz_comensales);                        
                        $matriz_personal_ivic = $this->Personal_ivic_model->personal_ivic_buscar_8($cargos_id);
                        if($matriz_personal_ivic == false){
                            $dat_list[$i]->esta_asociado_en_personal_ivic = false;
                        }else{
                            $dat_list[$i]->esta_asociado_en_personal_ivic = true;
                        } */
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
                $this->load->view('comensal/v_comensal_listar', $dat_list);
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
    
    public function listar_programados($memoria = 'false'){
        $logged = $this->Conf_usuarios_model->isLogged();
        $id_conf_roles_es_3 = $this->session->userdata('id_conf_roles_es_3');
        if($logged == TRUE && $id_conf_roles_es_3 == true){ 

                if($memoria == 'limpiar'){
                    $this->session->unset_userdata('personal_b_texto');
                }
                
                if (	isset ($_POST['b_texto'])	){
                        $b_texto = $_POST['b_texto'];
                        $s_busquedad = array(
                                'personal_b_texto' => $b_texto
                        );
                        $this->session->set_userdata($s_busquedad);
                }else{
                        $b_texto = "";
                        if( strlen($this->session->userdata('personal_b_texto')) > 0  ){
                            $b_texto = $this->session->userdata('personal_b_texto');
                        }
                }
                $b_texto = str_replace("'", "", $b_texto);
                
                if($memoria == 'cargo_ultima_pagina'){
                        $pagina_actual = $this->session->userdata('personal_ultima_pagina');    
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
                            'personal_ultima_pagina' => $pagina_actual
                        );
                        $this->session->set_userdata($s_lista);                    
                        $segmento = $this->uri->segment(4);                    
                }

                $this->load->helper('form');
                $this->load->library('pagination');
                $pages = 8; //Número de registros mostrados por páginas
                $config['base_url'] = base_url().'index.php/Comensal/listar_programados/pagina'; // parametro base de la aplicación, si tenemos un .htaccess nos evitamos el index.php
                $total_rows = $this->Comensales_programacion_model->comensales_programacion_num_reg($b_texto);
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
                //$dat_list = $this->Cargos_model->cargos_buscar($b_texto, $config['per_page'],$segmento);
                $dat_list = $this->Comensales_programacion_model->comensales_programacion_buscar($b_texto, $config['per_page'],$segmento);
                //echo "<br>dat_list *<pre>"; print_r($dat_list); echo "</pre>*";                
                //[0] => stdClass Object
                //    (
                //        [comensales_programacion_id] => 7
                //        [comensales_programacion_id_personal_ivic] => 1
                //        [comensales_programacion_id_personal_visitante] => 
                //        [comensales_programacion_id_comedor_comida_tipo] => 2
                //        [comensales_programacion_fecha] => 2023-06-25
                //        [comensales_programacion_hora] => 11:56:00
                //        [comensales_programacion_estatus] => 1
                //    )
                
                if($dat_list != false){
                    for($i = 0; $i < count($dat_list); $i++){
                        $dat_list[$i]->carnet = "";
                        $dat_list[$i]->cedula = "";
                        $dat_list[$i]->nombres = "";
                        $dat_list[$i]->apellidos = "";
                        if($dat_list[$i]->comensales_programacion_id_personal_ivic > 0){
                            $matriz_personal_ivic = $this->Personal_ivic_model->personal_ivic_buscar_2($dat_list[$i]->comensales_programacion_id_personal_ivic);
                            $dat_list[$i]->carnet       = $matriz_personal_ivic[0]->carnet_codigo;
                            $dat_list[$i]->cedula       = $matriz_personal_ivic[0]->cedula;
                            $dat_list[$i]->nombres      = $matriz_personal_ivic[0]->nombres;
                            $dat_list[$i]->apellidos    = $matriz_personal_ivic[0]->apellidos;
                        }
                        if($dat_list[$i]->comensales_programacion_id_personal_visitante > 0){
                            $matriz_personal_visitante = $this->Personal_visitante_model->personal_visitante_buscar_2($dat_list[$i]->comensales_programacion_id_personal_visitante);
                            $dat_list[$i]->cedula       = $matriz_personal_visitante[0]->cedula;
                            $dat_list[$i]->nombres      = $matriz_personal_visitante[0]->nombres;
                            $dat_list[$i]->apellidos    = $matriz_personal_visitante[0]->apellidos;
                        }   
                        
                        $dat_list[$i]->comensales_programacion_fecha = $this->ordena_fecha($dat_list[$i]->comensales_programacion_fecha);
                        
                        $matriz_comedor_comida_tipo = $this->Comedor_comida_tipo_model->comedor_comida_tipo_buscar_3($dat_list[$i]->comensales_programacion_id_comedor_comida_tipo);
                        $dat_list[$i]->comedor_comida_tipo_nombre = $matriz_comedor_comida_tipo[0]->nombre;
                        
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
                $this->load->view('comensal/v_comensal_listar_2', $dat_list);
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
        $id_conf_roles_es_3 = $this->session->userdata('id_conf_roles_es_3');
        $id_conf_roles_es_4 = $this->session->userdata('id_conf_roles_es_4');
        $logged = $this->Conf_usuarios_model->isLogged();
        if($logged == TRUE && ($id_conf_roles_es_3 == true OR $id_conf_roles_es_4 == true)){

            $valor = "cedula";          if ( isset($_POST[$valor]) 	){	$cedula = $_POST[$valor];               }else{	$cedula	= "";	}
            $valor = "carnet";          if ( isset($_POST[$valor]) 	){	$carnet = $_POST[$valor];               }else{	$carnet	= "";	}
            $valor = "cb_qr";           if ( isset($_POST[$valor]) 	){	$cb_qr  = $_POST[$valor];               }else{	$cb_qr	= "";	}
            
            //$valor = "enfoque_campo";   if ( isset($_POST[$valor]) 	){	$enfoque_campo = $_POST[$valor];        }else{	$enfoque_campo	= "cb_qr";	}
            
            if (	isset ($_POST['enfoque_campo'])	){
                    $enfoque_campo = $_POST['enfoque_campo'];
                    $s_busquedad = array(
                            'comensal_enfoque_campo' => $enfoque_campo
                    );
                    $this->session->set_userdata($s_busquedad);
            }else{
                    $enfoque_campo = "";
                    if( strlen($this->session->userdata('comensal_enfoque_campo')) > 0  ){
                        $enfoque_campo = $this->session->userdata('comensal_enfoque_campo');
                    }
            }            
            $data['enfoque_campo']     = $enfoque_campo;
            
            //echo "cedula *".$cedula." carnet *".$carnet."*";
            
            if(strlen($cb_qr) > 0){
                if(strlen($cb_qr) < 10){ //BUSQUEDA POR CODIGO DE BARRA
                    if($cb_qr > 0){
                        $cedula = $cb_qr;
                        
                        //VERIFICA SI EXISTE POR LA CEDULA, SI NO BUSCA POR FORMATO MAS VIEJO DEL IVIC LELLENDO EL CODIGO DE BARRA
                        unset($matriz_personal_ivic);
                        $matriz_personal_ivic         = $this->Personal_ivic_model->personal_ivic_buscar_7($cedula,"");
                        if($matriz_personal_ivic == false){
                            $cedula = "";
                            $carnet = substr($cb_qr,  2,   5);
                        }
                        //FIN DE VERIFICA SI EXISTE POR LA CEDULA, SI NO BUSCA POR FORMATO MAS VIEJO DEL IVIC LELLENDO EL CODIGO DE BARRA
                        
                    }
                }else{
                    //PERSONAL IVIC CODIGO QR
                    $palabra = substr($cb_qr,  1,   4);
                    if($palabra == "IVIC"){ //FORMATO QR 1
                        $cedula = substr($cb_qr,  65,   8);
                        
                    }
                    
                }
            }
            
            //echo "cedula *".$cedula."* carnet *".$carnet."*";
            

            $hora_fuera_de_horario = false;
            
            $fecha = date("Y-m-d");
            $hora  = date("H:i:s");
            
            $fecha_con_formato = $this->ordena_fecha_5($fecha);
            
            $matriz_comedor_comida_tipo = $this->Comedor_comida_tipo_model->comedor_comida_tipo_buscar_2($hora);
            if($matriz_comedor_comida_tipo != false){

                    //SI LA PERSONA ESTA ACTIVO COMO PERSONAL EXTERNO Y EN EL AREA DE PERSONAL, AQUI LO DESCATIVO EN LA FICHA DE PERSONAL EXTERNO
                    unset($matriz_personal_ivic);
                    $matriz_personal_ivic         = $this->Personal_ivic_model->personal_ivic_buscar_7($cedula, $carnet);
                    unset($matriz_personal_visitante);
                    $matriz_personal_visitante    = $this->Personal_visitante_model->personal_visitante_buscar_4($cedula);
                    if($matriz_personal_ivic != false && $matriz_personal_visitante != false){
                        if($matriz_personal_ivic[0]->estado == 1 
                                && $matriz_personal_visitante[0]->estado == 1){
                            $this->Personal_visitante_model->personal_visitante_editar_2($matriz_personal_visitante[0]->id, "2");
                            $persona = $this->cargo_personal_detalles("", $matriz_personal_visitante[0]->id);
                            $mensaje  = "Al personal externo, ".$persona.", se le ha cambiado de forma automatica el estatus a no activo, porque ya tenia un estatus activo como personal del ivic ";
                            $this->insertar_bitacora_2("personal_visitante", $mensaje, $mensaje);
                        }                        
                    }
                    //FI DE SI LA PERSONA ESTA ACTIVO COMO PERSONAL EXTERNO Y EN EL AREA DE PERSONAL, AQUI LO DESCATIVO EN LA FICHA DE PERSONAL EXTERNO
                
                    //OCULTO EL PERSONAL EXTERNO SI YA ESTA COMO PERSONAL DEL IVIC CON ESTATUS DE ACTIVO
                    $ocultar_personal_visitante = false;
                    if($matriz_personal_ivic != false && $matriz_personal_visitante != false){
                        if($matriz_personal_ivic[0]->estado == 1 ){
                            $ocultar_personal_visitante = true;
                        }
                    }
                    //FIN DE OCULTO EL PERSONAL EXTERNO SI YA ESTA COMO PERSONAL DEL IVIC CON ESTATUS DE ACTIVO
                
                    $id_comedor_comida_tipo = $matriz_comedor_comida_tipo[0]->id;
                    $nombre_comedor_comida_tipo         = $matriz_comedor_comida_tipo[0]->nombre;
                    $data['id_comedor_comida_tipo']     = $id_comedor_comida_tipo;
                    $data['nombre_comedor_comida_tipo'] = $nombre_comedor_comida_tipo;

                    unset($matriz_personal_ivic);
                    $matriz_personal_ivic         = $this->Personal_ivic_model->personal_ivic_buscar_7($cedula, $carnet);
                    unset($matriz_personal_visitante);
                    if($ocultar_personal_visitante == false){
                            $matriz_personal_visitante    = $this->Personal_visitante_model->personal_visitante_buscar_4($cedula);    //echo "matriz_personal_visitante *<pre>"; print_r($matriz_personal_visitante); echo "</pre>*";
                    }else{
                            $matriz_personal_visitante    = false;
                    }

                    $busquedad_no_encontrada = false;
                    if($cedula > 0 or $carnet > 0){
                        if($matriz_personal_ivic == false && $matriz_personal_visitante ==false){
                            $busquedad_no_encontrada = true;
                        }
                    }
                    $data['busquedad_no_encontrada'] = $busquedad_no_encontrada;                

                    if($matriz_personal_ivic != false){
                            if($matriz_personal_ivic[0]->id_cargo > 0){
                                $matriz_cargos = $this->Cargos_model->cargos_buscar_2($matriz_personal_ivic[0]->id_cargo);
                                $matriz_personal_ivic[0]->cargos_nombre = $matriz_cargos[0]->nombre;                        
                            } 
                            if($matriz_personal_ivic[0]->id_gerencia > 0){
                                $matriz_gerencias = $this->Gerencias_model->gerencias_buscar_2($matriz_personal_ivic[0]->id_gerencia);
                                $matriz_personal_ivic[0]->gerencia_nombre = $matriz_gerencias[0]->nombre;                        
                            }                    
                            if($matriz_personal_ivic[0]->estado > 0){
                                    //echo "matriz_personal_ivic[0]->estado *".$matriz_personal_ivic[0]->estado."*";
                                    switch ($matriz_personal_ivic[0]->estado) {
                                        case 1:     $estado_nombre = "Activo";  break;
                                        case 2:     $estado_nombre = "Egresado";  break;
                                        case 3:     $estado_nombre = "Vacaciones";  break;
                                        case 4:     $estado_nombre = "Reposo";  break;
                                        case 5:     $estado_nombre = "Suspendido";  break;
                                    }                    
                                    $matriz_personal_ivic[0]->estado_nombre = $estado_nombre;
                            }

                            //_______________________________________________________________________________________________
                            //A LA MATRIZ LE COLOCO EL NOMBRE DE LA FOTO POR DEFECTO PARA CUANDO NO TENGA FOTO REGISTRADA
                            if($matriz_personal_ivic != false){
                                    for($i = 0; $i < count($matriz_personal_ivic); $i++){
                                        $ruta = "images/personal_ivic/".$matriz_personal_ivic[$i]->imagen_nombre; //echo "ruta *".$ruta."*";
                                        if(file_exists($ruta) == true){
                                        }else{
                                            $matriz_personal_ivic[$i]->imagen_nombre = "sin_imagen.png";

                                        }                                
                                    }                        
                            }
                            //FIN DE A LA MATRIZ LE COLOCO EL NOMBRE DE LA FOTO POR DEFECTO PARA CUANDO NO TENGA FOTO REGISTRADA
                            //_______________________________________________________________________________________________                            

                            //VALIDA SI PUEDE REGISTRAR -----------------------------------------------------------------------
                            for($i = 0; $i < count($matriz_personal_ivic); $i++){
                                    $puede_registrar = true;
                                    $mensaje_de_porque_no_registra = "";
                                    $mensaje_advertencia = "";

                                    //VALIDA QUE NO REPITA
                                    unset($matriz_comensales);
                                    $matriz_comensales = $this->Comensal_model->comensales_buscar_5($matriz_personal_ivic[$i]->id, $id_comedor_comida_tipo, $fecha, 1);
                                    if($matriz_comensales == false){ }else{
                                        
                                        //BUSCO LA PERSONA QUE LO REGISTRO ----------------------------------
                                        $persona_q_registra = "";
                                        $matriz_conf_usuarios = $this->Conf_usuarios_model->conf_usuarios_buscar_2($matriz_comensales[0]->id_usuario);
                                        if($matriz_conf_usuarios != false){
                                            $persona_q_registra = $matriz_conf_usuarios[0]->nombre_usu." ".$matriz_conf_usuarios[0]->apellido_usu;    
                                        }
                                        //FIN DE BUSCO LA PERSONA QUE LO REGISTRO ---------------------------
                                        
                                        $puede_registrar = false;
                                        $mensaje_de_porque_no_registra  = "No puede Registrar nuevamente, EL comensal, ya tiene un registro, <br />en la fecha <b>".$fecha_con_formato." ".$matriz_comensales[0]->hora."</b> con tipo de comida <b>".$nombre_comedor_comida_tipo."</b>";
                                        if($persona_q_registra != ""){
                                            $mensaje_de_porque_no_registra .= ", <br /> fue registrado por <b>".$persona_q_registra."</b>";    
                                        }
                                        
                                        ////GUARDO EN BITACORA ---------------------------------
                                        //$persona = $this->cargo_personal_detalles($matriz_personal_ivic[$i]->id, "");
                                        //$mensaje = "Intento de Repetir, El personal del IVIC ".$persona.", ya tiene un tipo de comida de tipo ".$matriz_comedor_comida_tipo[0]->nombre.", en el dia ".$fecha;
                                        //$this->insertar_bitacora_2("", "", $mensaje);                                    
                                        ////FIN DE GUARDO EN BITACORA ---------------------------------                                                                            
                                    }
                                    //FIN DE VALIDA QUE NO REPITA

                                    //VALIDA EL TIPO DE PERSONAL
                                    if($matriz_personal_ivic[$i]->estado == 1){}
                                    else{
                                        $puede_registrar = false;
                                        $mensaje_de_porque_no_registra = "No puede Registrar, EL comensal, no tiene un Estado de <b>Activo</b>";
                                    }
                                    //FIN DE VALIDA EL TIPO DE PERSONAL

                                    //GUARDO EN BITACORA CUANDO INTENTO REGISTRAR ---------------------------------                                    
                                    if($puede_registrar == false){
                                        $persona = $this->cargo_personal_detalles($matriz_personal_ivic[$i]->id, "");
                                        $mensaje  = "Intento de Repetir, El personal del IVIC ".$persona;
                                        $mensaje .= ", ".$mensaje_de_porque_no_registra;
                                        $this->insertar_bitacora_2("", "", $mensaje);                                    
                                    }
                                    //FIN DE GUARDO EN BITACORA CUANDO INTENTO REGISTRAR ---------------------------------                                    

                                    //VALIDA si el personal tiene un estado temporal
                                    if($puede_registrar == true){
                                        unset($matriz_estados_temporales);
                                        $matriz_estados_temporales = $this->Estados_temporales_model->estados_temporales_buscar_6($matriz_personal_ivic[$i]->id, $fecha);
                                        if($matriz_estados_temporales == false){}
                                        else{
                                            $matriz_estados_temporales[0]->estados_temporales_fecha_desde = $this->ordena_fecha_5($matriz_estados_temporales[0]->estados_temporales_fecha_desde);
                                            $matriz_estados_temporales[0]->estados_temporales_fecha_hasta = $this->ordena_fecha_5($matriz_estados_temporales[0]->estados_temporales_fecha_hasta);
                                            $estado_temporal = "";
                                            $estado_temporal  =     $matriz_estados_temporales[0]->estados_nombre;
                                            $estado_temporal .= " En las fechas Desde ".$matriz_estados_temporales[0]->estados_temporales_fecha_desde;
                                            $estado_temporal .= " Hasta ".$matriz_estados_temporales[0]->estados_temporales_fecha_hasta;
                                            //$puede_registrar = false;
                                            //$mensaje_de_porque_no_registra = "No puede Registrar, EL comensal, tiene un Estado Temporal de <b>".$estado_temporal."</b>";
                                            $mensaje_advertencia = "EL comensal, tiene un Estado Temporal de <b>".$estado_temporal."</b>";
                                        }                                        
                                    }
                                    //Fin de VALIDA si el personal tiene un estado temporal                                    
                                    
                                    $matriz_personal_ivic[$i]->puede_registrar                  = $puede_registrar;
                                    $matriz_personal_ivic[$i]->mensaje_de_porque_no_registra    = $mensaje_de_porque_no_registra;
                                    $matriz_personal_ivic[$i]->mensaje_advertencia              = $mensaje_advertencia;

                            }
                            //FIN DE VALIDA SI PUEDE REGISTRAR ___________________________________________________________

                    }
                    $data['matriz_personal_ivic'] = $matriz_personal_ivic;
                    //echo "matriz_personal_ivic *<pre>"; print_r($matriz_personal_ivic); echo "</pre>*";
                    //[0] => stdClass Object
                    //    (
                    //        [id] => 271
                    //        [cedula] => 18234936
                    //        [nombres] => Maria Fernanda
                    //        [apellidos] => Rivas Perez
                    //        [id_cargo] => 51
                    //        [id_gerencia] => 33
                    //        [id_gerencia_2] => 
                    //        [id_tipo] => 3
                    //        [id_condicion] => 1
                    //        [estado] => 1
                    //        [imagen_nombre] => 18234936.jpg
                    //        [firma_nombre] => 18234936.png
                    //        [carnet_codigo] => 16007
                    //        [id_departamento] => 4
                    //        [id_categoria] => 3
                    //        [fecha_ingreso] => 2023-05-01
                    //        [fecha_no_activo] => 
                    //        [cargos_nombre] => TECNICO I (CONTRATADO)
                    //        [gerencia_nombre] => OFICINA TECNOLOGIAS DE LA INFORMACION Y COMUNICACION
                    //        [estado_nombre] => Activo
                    //        [puede_registrar] => 1
                    //        [mensaje_de_porque_no_registra] => 
                    //        [mensaje_advertencia] => EL comensal, tiene un Estado Temporal de Vacaciones En las fechas Desde 10-08-2023 Hasta 31-08-2023
                    //    )                    
                    
                    //echo "matriz_personal_visitante *<pre>"; print_r($matriz_personal_visitante); echo "</pre>*";
                    //[0] => stdClass Object
                    //    (
                    //        [id] => 84
                    //        [cedula] => 19189811
                    //        [nombres] => Alexa
                    //        [apellidos] => Caraballo
                    //        [imagen_nombre] => 19189811.jpg
                    //        [estado] => 1
                    //        [id_personal_visitante_tipo] => 11
                    //    )         
                    if($matriz_personal_visitante != false){
                            if($matriz_personal_visitante[0]->estado > 0){
                                    switch ($matriz_personal_visitante[0]->estado) {
                                        case 1:     $estado_nombre = "Activo";  break;
                                        case 2:     $estado_nombre = "No Activo";  break;
                                    }                    
                                    $matriz_personal_visitante[0]->estado_nombre = $estado_nombre;
                            }

                            
                            if($matriz_personal_visitante[0]->id_personal_visitante_tipo > 0){
                                $matriz_personal_visitante_tipo = $this->Personal_visitante_tipo_model->personal_visitante_tipo_buscar_2($matriz_personal_visitante[0]->id_personal_visitante_tipo);
                                $matriz_personal_visitante[0]->tipo_nombre = $matriz_personal_visitante_tipo[0]->nombre;
                            }                           
                            
                            //_______________________________________________________________________________________________
                            //A LA MATRIZ LE COLOCO EL NOMBRE DE LA FOTO POR DEFECTO PARA CUANDO NO TENGA FOTO REGISTRADA
                            if($matriz_personal_visitante != false){
                                    for($i = 0; $i < count($matriz_personal_visitante); $i++){
                                        $ruta = "images/personal_visitante/".$matriz_personal_visitante[$i]->imagen_nombre; //echo "ruta *".$ruta."*";
                                        if(file_exists($ruta) == true){
                                        }else{
                                            $matriz_personal_visitante[$i]->imagen_nombre = "sin_imagen.png";
                                        }                                
                                    }                        
                            }
                            //FIN DE A LA MATRIZ LE COLOCO EL NOMBRE DE LA FOTO POR DEFECTO PARA CUANDO NO TENGA FOTO REGISTRADA
                            //_______________________________________________________________________________________________                                                        
                            
                            //VALIDA SI PUEDE REGISTRAR -----------------------------------------------------------------------
                            for($i = 0; $i < count($matriz_personal_visitante); $i++){
                                    $puede_registrar = true;
                                    $mensaje_de_porque_no_registra = "";                                    

                                    //VALIDA QUE NO REPITA
                                    unset($matriz_comensales);
                                    $matriz_comensales = $this->Comensal_model->comensales_buscar_8($matriz_personal_visitante[$i]->id, $id_comedor_comida_tipo, $fecha, 1);
                                    if($matriz_comensales == false){ }else{
                                        
                                        //BUSCO LA PERSONA QUE LO REGISTRO ----------------------------------
                                        $persona_q_registra = "";
                                        $matriz_conf_usuarios = $this->Conf_usuarios_model->conf_usuarios_buscar_2($matriz_comensales[0]->id_usuario);
                                        if($matriz_conf_usuarios != false){
                                            $persona_q_registra = $matriz_conf_usuarios[0]->nombre_usu." ".$matriz_conf_usuarios[0]->apellido_usu;    
                                        }
                                        //FIN DE BUSCO LA PERSONA QUE LO REGISTRO ---------------------------                                        
                                        $puede_registrar = false;
                                        $mensaje_de_porque_no_registra  = "No puede Registrar nuevamente, EL comensal, ya tiene un registro, <br />en la fecha <b>".$fecha_con_formato." ".$matriz_comensales[0]->hora."</b> con tipo de comida <b>".$nombre_comedor_comida_tipo."</b>";
                                        if($persona_q_registra != ""){
                                            $mensaje_de_porque_no_registra .= ", <br /> fue registrado por <b>".$persona_q_registra."</b>";    
                                        }                                        
                                        
                                        //GUARDO EN BITACORA ---------------------------------
                                        $persona = $this->cargo_personal_detalles("", $matriz_personal_visitante[$i]->id);
                                        $mensaje = "Intento de Repetir, El personal Externo".$persona.", ya tiene un tipo de comida de tipo ".$matriz_comedor_comida_tipo[0]->nombre.", en el dia ".$fecha;
                                        $this->insertar_bitacora_2("", "", $mensaje);                                    
                                        //FIN DE GUARDO EN BITACORA ---------------------------------
                                    }
                                    //FIN DE VALIDA QUE NO REPITA

                                    //VALIDA EL Estado DE PERSONAL
                                    if($matriz_personal_visitante[$i]->estado == 1){}
                                    else{
                                        $puede_registrar = false;
                                        $mensaje_de_porque_no_registra = "No puede Registrar, EL comensal, no tiene un Estado de <b>Activo</b>";
                                    }
                                    //FIN DE VALIDA EL Estado DE PERSONAL
                                    
                                    $matriz_personal_visitante[$i]->puede_registrar                  = $puede_registrar;
                                    $matriz_personal_visitante[$i]->mensaje_de_porque_no_registra    = $mensaje_de_porque_no_registra;

                            }
                            //FIN DE VALIDA SI PUEDE REGISTRAR ___________________________________________________________

                    }
                    $data['matriz_personal_visitante'] = $matriz_personal_visitante;
                    //echo "matriz_personal_visitante *<pre>"; print_r($matriz_personal_visitante); echo "</pre>*";
                    //[0] => stdClass Object
                    //    (
                    //        [id] => 2
                    //        [cedula] => 18123456
                    //        [nombres] => Ignasio
                    //        [apellidos] => Vargas
                    //        [imagen_nombre] => 
                    //        [estado] => 1
                    //        [id_personal_visitante_tipo] => 5
                    //        [estado_nombre] => Activo
                    //        [tipo_nombre] => Visitante
                    //        [puede_registrar] => 
                    //        [mensaje_de_porque_no_registra] => No puede Registrar nuevamente, EL comensal, ya tiene un registro, en la fecha 02-03-2023 con tipo de comida Almuerzo
                    //    )                    
                    
                    //CARGA LOS ULTIMOS COMENSALES -----------------------------------------------------------------------
                    unset($matriz_comensales);
                    //if(isset($id_comedor_comida_tipo)){}else{$id_comedor_comida_tipo = "";}
                    //echo "id_comedor_comida_tipo *".$id_comedor_comida_tipo."*";
                    //echo "fecha *".$fecha."*";
                    $matriz_comensales = $this->Comensal_model->comensales_buscar_4($id_comedor_comida_tipo, $fecha, 1);
                    //echo "matriz_comensales *<pre>"; print_r($matriz_comensales); echo "</pre>*";
                    //[0] => stdClass Object
                    //    (
                    //        [id] => 26
                    //        [id_personal_ivic] => 
                    //        [id_personal_visitante] => 1
                    //        [id_comedor_comida_tipo] => 2
                    //        [fecha] => 2023-02-17
                    //        [hora] => 14:00:00
                    //    )

                    if($matriz_comensales != false){            
                        for($i = 0; $i < count($matriz_comensales); $i++){
                            if($matriz_comensales[$i]->id_personal_ivic > 0){
                                unset($matriz_personal_ivic_temp);
                                $matriz_personal_ivic_temp = $this->Personal_ivic_model->personal_ivic_buscar_2($matriz_comensales[$i]->id_personal_ivic);
                                $matriz_comensales[$i]->cedula      = $matriz_personal_ivic_temp[0]->cedula;
                                $matriz_comensales[$i]->nombres     = $matriz_personal_ivic_temp[0]->nombres;
                                $matriz_comensales[$i]->apellidos   = $matriz_personal_ivic_temp[0]->apellidos;
                                
                                $matriz_comensales[$i]->carnet_codigo   = $matriz_personal_ivic_temp[0]->carnet_codigo;
                                
                            }
                            if($matriz_comensales[$i]->id_personal_visitante > 0){
                                unset($matriz_personal_visitante_temp);
                                $matriz_personal_visitante_temp = $this->Personal_visitante_model->personal_visitante_buscar_2($matriz_comensales[$i]->id_personal_visitante);
                                $matriz_comensales[$i]->cedula      = $matriz_personal_visitante_temp[0]->cedula;
                                $matriz_comensales[$i]->nombres     = $matriz_personal_visitante_temp[0]->nombres;
                                $matriz_comensales[$i]->apellidos   = $matriz_personal_visitante_temp[0]->apellidos;
                            }
                            //$matriz_comensales[$i]->personal = $personal;

                            $matriz_comensales[$i]->fecha_con_formato = $this->ordena_fecha($matriz_comensales[$i]->fecha);

                            $comida_tipo = "";
                            unset($matriz_comedor_comida_tipo);
                            $matriz_comedor_comida_tipo = $this->Comedor_comida_tipo_model->comedor_comida_tipo_buscar_3($matriz_comensales[$i]->id_comedor_comida_tipo);
                            $comida_tipo = $matriz_comedor_comida_tipo[0]->nombre;
                            $matriz_comensales[$i]->comida_tipo = $comida_tipo;                    

                        }
                    }
                    $data['matriz_comensales'] = $matriz_comensales;
                    //echo "matriz_comensales *<pre>"; print_r($matriz_comensales); echo "</pre>*";
                    //[0] => stdClass Object
                    //    (
                    //        [id] => 19
                    //        [id_personal_ivic] => 2
                    //        [id_personal_visitante] => 
                    //        [id_comedor_comida_tipo] => 1
                    //        [fecha] => 2023-03-13
                    //        [hora] => 11:30:14
                    //        [cedula] => 6463970
                    //        [nombres] => MIRNA JUDITH
                    //        [apellidos] => PEREZ BLANCO
                    //        [carnet_codigo] => 13096
                    //        [fecha_con_formato] => 13-03-2023
                    //        [comida_tipo] => Desayuno
                    //    )           
                    //FIN DE CARGA LOS ULTIMOS COMENSALES ----------------------------------------------------------------                    

                    //BUSCA LOS COMENSALES DEL DIA -----------------------------------------------------------------------
                    $num_personal_ivic      = 0;
                    $num_personal_visitante = 0;
                    $num_personal_total     = 0;
                    unset($matriz_comensales_2);
                    $matriz_comensales_2 = $this->Comensal_model->comensales_buscar_9($id_comedor_comida_tipo, $fecha, true, false, 1);
                    if($matriz_comensales_2 != false){
                        $num_personal_ivic = count($matriz_comensales_2);
                    }
                    unset($matriz_comensales_2);
                    $matriz_comensales_2 = $this->Comensal_model->comensales_buscar_9($id_comedor_comida_tipo, $fecha, false, true, 1);
                    if($matriz_comensales_2 != false){
                        $num_personal_visitante = count($matriz_comensales_2);
                    }            
                    $data['fecha']                  = $fecha;
                    $data['fecha_con_formato']      = $fecha_con_formato;

                    $data['num_personal_ivic']      = $num_personal_ivic;
                    $data['num_personal_visitante'] = $num_personal_visitante;
                    $data['num_personal_total']     = $num_personal_ivic + $num_personal_visitante;
                    //FIN DE BUSCA LOS COMENSALES DEL DIA ----------------------------------------------------------------
                    
            }else{
                $data['busquedad_no_encontrada'] = false;
                $hora_fuera_de_horario = true;
            }
            $data['hora_fuera_de_horario'] = $hora_fuera_de_horario;
            
            $data['oper'] = "agregar";
            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('plantilla/menu');
            $this->load->view('comensal/v_comensal_frm', $data);
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
            //$valor = "personal_id";          if ( isset($_POST[$valor]) 	){	$personal_id = $_POST[$valor];               }else{	$personal_id	= "";	}
            $valor = "id_personal_ivic";        if ( isset($_POST[$valor]) 	){	$id_personal_ivic = $_POST[$valor];               }else{	$id_personal_ivic	= "";	}
            $valor = "id_personal_visitante";   if ( isset($_POST[$valor]) 	){	$id_personal_visitante = $_POST[$valor];          }else{	$id_personal_visitante	= "";	}

            $fecha = date("Y-m-d");
            $hora  = date("H:i:s"); 
            
            $id_comedor_comida_tipo = "";
            $matriz_comedor_comida_tipo = $this->Comedor_comida_tipo_model->comedor_comida_tipo_buscar_2($hora);
            if($matriz_comedor_comida_tipo != false){
                $id_comedor_comida_tipo = $matriz_comedor_comida_tipo[0]->id;    
            }
            //echo "matriz_comedor_comida_tipo *<pre>"; print_r($matriz_comedor_comida_tipo); echo "</pre>*";
            //[0] => stdClass Object
            //    (
            //        [id] => 3
            //        [nombre] => Cena
            //        [hora_desde] => 17:00:00
            //        [hora_hasta] => 23:59:59
            //    )     
            
            //BUSCO LOS DETALLES DE LA PERSONA
            $tipo = "";
            $persona = "";
            if($id_personal_ivic > 0){
                $matriz_personal_ivic = $this->Personal_ivic_model->personal_ivic_buscar_2($id_personal_ivic);
                $persona  = "(".$matriz_personal_ivic[0]->cedula.") ";
                $persona .= " ".$matriz_personal_ivic[0]->nombres;
                $persona .= " ".$matriz_personal_ivic[0]->apellidos;
                $tipo = "IVIC";
            }
            if($id_personal_visitante > 0){
                $matriz_personal_visitante = $this->Personal_visitante_model->personal_visitante_buscar_2($id_personal_visitante);
                $persona  = "(".$matriz_personal_visitante[0]->cedula.") ";
                $persona .= " ".$matriz_personal_visitante[0]->nombres;
                $persona .= " ".$matriz_personal_visitante[0]->apellidos;
                $tipo = "EXTERNO";
            }            
            //FIN DE BUSCO LOS DETALLES DE LA PERSONA

            //Valida reg existente
            $valido = true;
            $matriz_Comensal = $this->Comensal_model->comensales_buscar_10($fecha, $id_comedor_comida_tipo, $id_personal_ivic, $id_personal_visitante, 1); //echo "cli_clientes_num_reg *".$cohorte_num_reg."*";
            if($matriz_Comensal == false){}
            else{
                    $valido = false; 
                    $mensaje = "El registro no fue incluido, El comensal ".$persona.", ya tiene un tipo de comida de tipo ".$matriz_comedor_comida_tipo[0]->nombre.", en el dia ".$fecha;
                    $s_mensaje = array(
                            'comensal_mensaje_tipo'         => 'alert-danger',
                            'comensal_mensaje_contenido'    => $mensaje
                    );
                    $this->session->set_userdata($s_mensaje);
                    //$this->insertar_bitacora_2("", $mensaje, $mensaje);
                    //GUARDO EN BITACORA ---------------------------------
                    //$persona = $this->cargo_personal_detalles("", $matriz_personal_visitante[$i]->id);
                    $mensaje = "Intento de Repetir, de forma simultanea, El personal ".$tipo." ".$persona.", ya tiene un tipo de comida de tipo ".$matriz_comedor_comida_tipo[0]->nombre.", en el dia ".$fecha;
                    $this->insertar_bitacora_2("", "", $mensaje);                                    
                    //FIN DE GUARDO EN BITACORA ---------------------------------                    
            }
            
            if($id_comedor_comida_tipo > 0){}
            else{
                    $valido = false; 
                    $mensaje = "El registro no fue incluido, Horario de comida esta fuera de hora";
                    $s_mensaje = array(
                            'comensal_mensaje_tipo'         => 'alert-danger',
                            'comensal_mensaje_contenido'    => $mensaje
                    );
                    $this->session->set_userdata($s_mensaje);
                    $this->insertar_bitacora_2("", $mensaje, $mensaje);                
            }
            //FIN de Valida reg existente                        
            
            if($valido == true){
                    $id_usuario=$this->session->userdata('iduser');
                    
                    $id = $this->Comensal_model->comensales_insertar($id_personal_ivic, $id_personal_visitante, $id_comedor_comida_tipo, $fecha, $hora, $id_usuario, '1');
                    if ($id > 0){
                        
                        //INSERTO EN comensales_h_estado_temporal, cuando sea necesario ------------------------------
                        if($id_personal_ivic > 0){
                                unset($matriz_estados_temporales);
                                $matriz_estados_temporales = $this->Estados_temporales_model->estados_temporales_buscar_6($id_personal_ivic, $fecha);
                                if($matriz_estados_temporales != false){
                                    $estados_id     = $matriz_estados_temporales[0]->estados_temporales_id_estados;
                                    $fecha_desde    = $matriz_estados_temporales[0]->estados_temporales_fecha_desde;
                                    $fecha_hasta    = $matriz_estados_temporales[0]->estados_temporales_fecha_hasta;
                                    $comensales_h_estado_temporal_id = $this->Comensales_h_estado_temporal_model->comensales_h_estado_temporal_insertar($id, $estados_id, $fecha_desde, $fecha_hasta);
                                    $mensaje = "Inserto el Registro con id ".$comensales_h_estado_temporal_id;
                                    $mensaje_2 = $mensaje;                                    
                                    $this->insertar_bitacora_2("comensales_h_estado_temporal", $mensaje, $mensaje_2);
                                }
                        }
                        //FIN DE INSERTO EN comensales_h_estado_temporal, cuando sea necesario -----------------------                        
                        
                        $mensaje = "Inserto el Comensal con id ".$id;
                        $mensaje_2 = "Inserto el comensal ".$persona;
                        $s_mensaje = array(
                                'comensal_mensaje_tipo'         => 'alert-success',
                                'comensal_mensaje_contenido'    => 'Registros insertado exitosamente, '.$mensaje_2
                        );
                        $this->session->set_userdata($s_mensaje);
                        $this->insertar_bitacora_2("comensal", $mensaje, $mensaje_2);
                    }                    
            }
            redirect('comensal/agregar');
        }else{
                    $this->session->sess_destroy('username');
                    $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
                    $this->load->view('plantilla/header', $data);
                    $this->load->view('login/v_login_1');
                    $this->load->view('plantilla/footer');
        }
    }
 
    //GUARDA UN REGISTRO PARA EL AREA DE PROGRAMACION DE COMENSALES
    public function agregar_guardar_2(){ 
        $logged = $this->Conf_usuarios_model->isLogged();
        if($logged == TRUE){            
            $valor = "comedor_comida_tipo_id_2";  if ( isset($_POST[$valor]) 	){	$comedor_comida_tipo_id = $_POST[$valor];         }else{	$comedor_comida_tipo_id	= "";	}
            $valor = "id_personal_ivic";        if ( isset($_POST[$valor]) 	){	$id_personal_ivic = $_POST[$valor];               }else{	$id_personal_ivic	= "";	}
            $valor = "id_personal_visitante";   if ( isset($_POST[$valor]) 	){	$id_personal_visitante = $_POST[$valor];          }else{	$id_personal_visitante	= "";	}
            $valor = "fecha_2";                   if ( isset($_POST[$valor]) 	){	$fecha = $_POST[$valor];                          }else{	$fecha	= "";	}
            $valor = "hora_2";                    if ( isset($_POST[$valor]) 	){	$hora = $_POST[$valor];                           }else{	$hora	= "";	}

            $fecha_actual = date("Y-m-d");
            
            //echo "fecha *".$fecha."*";
            $fecha = $this->ordena_fecha_3($fecha);   
            $fecha_con_formato = $this->ordena_fecha_5($fecha);    
            
            unset($matriz_comedor_comida_tipo);
            $matriz_comedor_comida_tipo = $this->Comedor_comida_tipo_model->comedor_comida_tipo_buscar_3($comedor_comida_tipo_id);                        
            
            //BUSCO LOS DETALLES DE LA PERSONA
            $tipo = "";
            $persona = "";
            if($id_personal_ivic > 0){
                $matriz_personal_ivic = $this->Personal_ivic_model->personal_ivic_buscar_2($id_personal_ivic);
                $persona  = "(".$matriz_personal_ivic[0]->cedula.") ";
                $persona .= " ".$matriz_personal_ivic[0]->nombres;
                $persona .= " ".$matriz_personal_ivic[0]->apellidos;
                $tipo = "IVIC";
            }
            if($id_personal_visitante > 0){
                $matriz_personal_visitante = $this->Personal_visitante_model->personal_visitante_buscar_2($id_personal_visitante);
                $persona  = "(".$matriz_personal_visitante[0]->cedula.") ";
                $persona .= " ".$matriz_personal_visitante[0]->nombres;
                $persona .= " ".$matriz_personal_visitante[0]->apellidos;
                $tipo = "EXTERNO";
            }            
            //FIN DE BUSCO LOS DETALLES DE LA PERSONA

            //Valida reg existente ---------------------------------------------------------------
            $valido = true;
            //$matriz_Comensal = $this->Comensal_model->comensales_buscar_10($fecha, $id_comedor_comida_tipo, $id_personal_ivic, $id_personal_visitante, 1); //echo "cli_clientes_num_reg *".$cohorte_num_reg."*";
            $matriz_Comensal = $this->Comensales_programacion_model->comensales_programacion_buscar_10($fecha, $comedor_comida_tipo_id, $id_personal_ivic, $id_personal_visitante);
            if($matriz_Comensal == false){}
            else{
                    $valido = false; 
                    $mensaje = "El registro no fue incluido, El comensal ".$persona.", ya tiene programado un tipo de comida de tipo ".$matriz_comedor_comida_tipo[0]->nombre.", en el dia ".$fecha;
                    $s_mensaje = array(
                            'comensal_mensaje_tipo'         => 'alert-danger',
                            'comensal_mensaje_contenido'    => $mensaje
                    );
                    $this->session->set_userdata($s_mensaje);
            }
            //FIN de Valida reg existente ---------------------------------------------------------------
            //Valida que se programe a una fecha mayor al dia actual ---------------------------------------------------------------
            if($fecha > $fecha_actual){
            }else{
                    $valido = false; 
                    $mensaje = "El registro no fue incluido, la fecha de la programación debe de estar despues del dia actual";
                    $s_mensaje = array(
                            'comensal_mensaje_tipo'         => 'alert-danger',
                            'comensal_mensaje_contenido'    => $mensaje
                    );
                    $this->session->set_userdata($s_mensaje);
            }
            //Fin de Valida que se programe a una fecha mayor al dia actual ---------------------------------------------------------------
            
            if($valido == true){
                    $id_usuario=$this->session->userdata('iduser');
                    $id = $this->Comensales_programacion_model->comensales_programacion_insertar($id_personal_ivic, $id_personal_visitante, $comedor_comida_tipo_id, $fecha, $hora, $id_usuario, 1, 1);
                    if ($id > 0){
                        $mensaje = "Inserto el registro con id ".$id;
                        $mensaje_2 = "Inserto el comensal ".$persona." en la programacion del dia ".$fecha_con_formato." y Hora ".$hora;
                        $s_mensaje = array(
                                'comensal_mensaje_tipo'         => 'alert-success',
                                'comensal_mensaje_contenido'    => 'Registros insertado exitosamente, '.$mensaje_2
                        );
                        $this->session->set_userdata($s_mensaje);
                        $this->insertar_bitacora_2("comensales_programacion", $mensaje, $mensaje_2);
                    }                    
            }
            //redirect('comensal/agregar_3');
            
            $nombre_comedor_comida_tipo = $matriz_comedor_comida_tipo[0]->nombre;
            
            $matriz_comensales_programacion = $this->cargo_ultimos_comensales_programacion($fecha, $comedor_comida_tipo_id);
            
            $fecha = $this->ordena_fecha_4($fecha);    
            
            $data['nombre_comedor_comida_tipo']     = $nombre_comedor_comida_tipo;            
            $data['busquedad_no_encontrada']        = false;
            $data['matriz_personal_ivic']           = false;
            $data['matriz_personal_visitante']      = false;
            $data['matriz_comensales_programacion'] = $matriz_comensales_programacion;            
            $data['fecha']                          = $fecha;
            $data['hora']                           = $hora;
            $data['comedor_comida_tipo_id']         = $comedor_comida_tipo_id;
            
            $data['oper'] = "agregar";
            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('plantilla/menu');
            $this->load->view('comensal/v_comensal_frm_3', $data);
            $this->load->view('plantilla/footer');            
            
        }else{
                    $this->session->sess_destroy('username');
                    $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
                    $this->load->view('plantilla/header', $data);
                    $this->load->view('login/v_login_1');
                    $this->load->view('plantilla/footer');
        }
 
    }    
    
/*
    public function editar($id){
        $logged = $this->Conf_usuarios_model->isLogged();
        $id_conf_roles_es_2 = $this->session->userdata('id_conf_roles_es_2');
        if($logged == TRUE && $id_conf_roles_es_2 == true){
            
            $matriz_cargos                     = $this->Cargos_model->conf_cargos_buscar_3();
            $data['matriz_cargos']             = $matriz_cargos;
            
            $matriz_gerencias                  = $this->Gerencias_model->conf_gerencias_buscar_3();
            $data['matriz_gerencias']          = $matriz_gerencias;
            
            $fila_reg = $this->Personal_ivic_model->comensal_buscar_2($id);   //echo "<pre>"; print_r($fila_reg); echo "</pre>";
            $data['fila_comensal'] = $fila_reg[0];
            $data['oper'] = "editar";

            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('plantilla/menu');
            $this->load->view('comensal/v_comensal_frm', $data);
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
            $valor = "cedula";          if ( isset($_POST[$valor]) 	){	$cedula = $_POST[$valor];               }else{	$cedula	= "";	}
            $valor = "nombres"; 	if ( isset($_POST[$valor]) 	){	$nombres = ucfirst( $_POST[$valor] );	}else{	$nombres	= "";	}
            $valor = "apellidos"; 	if ( isset($_POST[$valor]) 	){	$apellidos = ucfirst( $_POST[$valor] );	}else{	$apellidos	= "";	}
            $valor = "id_cargo"; 	if ( isset($_POST[$valor]) 	){	$id_cargo = $_POST[$valor];             }else{	$id_cargo	= "";	}
            $valor = "id_gerencia"; 	if ( isset($_POST[$valor]) 	){	$id_gerencia = $_POST[$valor];          }else{	$id_gerencia	= "";	}
            $valor = "tipo_comensal"; 	if ( isset($_POST[$valor]) 	){	$tipo_comensal = $_POST[$valor];	}else{	$tipo_comensal	= "";	}
            $valor = "estado";          if ( isset($_POST[$valor]) 	){	$estado = $_POST[$valor];               }else{	$estado	= "";	}
            
            $cedula         = str_replace(".", "", $cedula);
            $nombres        = $this->convierte_texto($nombres);
            $apellidos      = $this->convierte_texto($apellidos);            
            
            $valido = true;
            if($valido == true){
                $oper_realizada = $this->Personal_ivic_model->comensal_editar($id, $nombres, $apellidos, $id_cargo, $id_gerencia, $tipo_comensal, $estado);
                echo "oper_realizada *".$oper_realizada."*";
                if ($oper_realizada){
                    $mensaje = "Actualizó el comensal con id ".$id;
                    $mensaje_2 = "Actualizó el Personal ".$nombres;
                    $s_mensaje = array(
                            'comensal_mensaje_tipo'  => 'alert-success',
                            'comensal_mensaje_contenido'    => 'Registros actualizado exitosamente, '.$mensaje_2
                    );
                    $this->session->set_userdata($s_mensaje);
                    $this->insertar_bitacora_2("comensal", $mensaje, $mensaje_2);

                    redirect('comensal/listar/cargo_ultima_pagina');
                }else{
                    redirect('comensal/editar');
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
*/
    public function anular($id){
            $logged = $this->Conf_usuarios_model->isLogged();
            $id_conf_roles_es_3 = $this->session->userdata('id_conf_roles_es_3');
            if($logged == TRUE && $id_conf_roles_es_3 == true){
                
                $matriz_comensal = $this->Comensal_model->comensales_buscar_2($id);
                $id_personal_ivic       = $matriz_comensal[0]->id_personal_ivic;
                $id_personal_visitante  = $matriz_comensal[0]->id_personal_visitante;
                
                $persona = $this->cargo_personal_detalles($id_personal_ivic, $id_personal_visitante);
                
                //Valida registro relacionado
                $valido = true;
                /*
                $num_rows = $this->Pensum_model->pensum_num_reg_4($id);
                if($num_rows > 0){
                    $valido = false;
                    $mensaje = "Error al eliminar, la Carrera con id ".$id." se encuentra asociado con un Pensum";
                    $mensaje_2 = "Error al eliminar, la Carrera ".$comensal_nombre." se encuentra asociado con un Pensum";
                    $s_mensaje = array(
                            'comensal_mensaje_tipo'         => 'alert-danger',
                            'comensal_mensaje_contenido'    => 'El registro no fue eliminado, '.$mensaje_2
                    );
                    $this->session->set_userdata($s_mensaje);
                    $this->insertar_bitacora_2("comensal", $mensaje, $mensaje_2);                    
                }*/
                //Fin de valida registro relacionado
                if( $valido == true ){
                    $oper_realizada = $this->Comensal_model->comensales_editar($id, 2);
                    if ($oper_realizada){
                            $mensaje = "Anulo el Registro con id ".$id;
                            $mensaje_2 = "Anulo el Registro de comensal de la Persona ".$persona;
                            $s_mensaje = array(
                                    'comensal_mensaje_tipo'         => 'alert-success',
                                    'comensal_mensaje_contenido'    => 'Registros eliminado exitosamente, '.$mensaje_2
                            );
                            $this->session->set_userdata($s_mensaje);
                            $this->insertar_bitacora_2("comensal", $mensaje, $mensaje_2);
                    }
                }
                redirect('comensal/listar/cargo_ultima_pagina');                
            }else{
                redirect('Login/v_login_mensaje_1');
            }
    }

    public function eliminar_programados($id){
            $logged = $this->Conf_usuarios_model->isLogged();
            $id_conf_roles_es_3 = $this->session->userdata('id_conf_roles_es_3');
            if($logged == TRUE && $id_conf_roles_es_3 == true){
                
                $matriz_comensales_programacion = $this->Comensales_programacion_model->comensales_programacion_buscar_2($id);
                $id_personal_ivic       = $matriz_comensales_programacion[0]->id_personal_ivic;
                $id_personal_visitante  = $matriz_comensales_programacion[0]->id_personal_visitante;
                
                $persona = $this->cargo_personal_detalles($id_personal_ivic, $id_personal_visitante);                
                
                
                //Valida registro relacionado
                $valido = true;
                
                //$num_rows = $this->Pensum_model->pensum_num_reg_4($id);
                if($matriz_comensales_programacion[0]->estatus_2 == 1){}
                else{
                    $valido = false;
                    $mensaje = "Error al eliminar, el registro con id ".$id;
                    $mensaje_2 = "Error al eliminar, el registro con id ".$id." para ".$persona.", porque ya se encuentra con estatus de agregado";
                    $s_mensaje = array(
                            'comensal_mensaje_tipo'         => 'alert-danger',
                            'comensal_mensaje_contenido'    => 'El registro no fue eliminado, '.$mensaje_2
                    );
                    $this->session->set_userdata($s_mensaje);
                    $this->insertar_bitacora_2("", $mensaje, $mensaje_2);                    
                }
                //Fin de valida registro relacionado
                if( $valido == true ){
                    $oper_realizada = $this->Comensales_programacion_model->comensales_programacion_eliminar($id);
                    
                    if ($oper_realizada){
                            $mensaje = "Eliminó el Registro con id ".$id;
                            $mensaje_2 = "Eliminó, el registro con id ".$id." para ".$persona;
                            $s_mensaje = array(
                                    'comensal_mensaje_tipo'         => 'alert-success',
                                    'comensal_mensaje_contenido'    => 'Registros eliminado exitosamente, '.$mensaje_2
                            );
                            $this->session->set_userdata($s_mensaje);
                            $this->insertar_bitacora_2("comensales_programacion", $mensaje, $mensaje_2);
                    }
                }
                redirect('Comensal/listar_programados/cargo_ultima_pagina');                
            }else{
                redirect('Login/v_login_mensaje_1');
            }
    }    
    
    
    //_____________________________________________________________________________________________________________________________________________
    //AQUI SE llama al formulario de reporte
    public function reporte_form(){

        echo "Ingresa en reporte";
        phpinfo();
        // $logged = $this->Conf_usuarios_model->isLogged();
        // $id_conf_roles_es_2 = $this->session->userdata('id_conf_roles_es_2');
        // $id_conf_roles_es_3 = $this->session->userdata('id_conf_roles_es_3');
        // $logged = $this->Conf_usuarios_model->isLogged();
        // if($logged == TRUE && ($id_conf_roles_es_3 == true OR $id_conf_roles_es_2 == true)){

        //     $matriz_personal                    = $this->Personal_ivic_model->personal_ivic_buscar_3();
        //     $data['matriz_personal']            = $matriz_personal;

        //     $matriz_comedor_comida_tipo                    = $this->Comedor_comida_tipo_model->comedor_comida_tipo_buscar_4();
        //     $data['matriz_comedor_comida_tipo']            = $matriz_comedor_comida_tipo;
            
        //     $matriz_personal_visitante_tipo                 = $this->Personal_visitante_tipo_model->personal_visitante_tipo_buscar_3();
        //     $data['matriz_personal_visitante_tipo']         = $matriz_personal_visitante_tipo;
            
        //     $matriz_estados = $this->Estados_model->estados_buscar_3();
        //     $data['matriz_estados']             = $matriz_estados;
            
        //     $data['oper'] = "reporte_form";
        //     $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
        //     $this->load->view('plantilla/header', $data);
        //     $this->load->view('plantilla/menu');
        //     $this->load->view('comensal/v_comensal_frm_2', $data);
        //     $this->load->view('plantilla/footer');
        // }else{
        //             $this->session->sess_destroy('username');
        //             $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
        //             $this->load->view('plantilla/header', $data);
        //             $this->load->view('login/v_login_1');
        //             $this->load->view('plantilla/footer');
        // }
    }  
    
    //Formulario que llama a agregar 3
    public function agregar_2(){
        $logged = $this->Conf_usuarios_model->isLogged();
        $id_conf_roles_es_3 = $this->session->userdata('id_conf_roles_es_3');
        if($logged == TRUE && $id_conf_roles_es_3 == true){
            
            $matriz_comedor_comida_tipo = $this->Comedor_comida_tipo_model->comedor_comida_tipo_buscar_4();
            $data['matriz_comedor_comida_tipo']       = $matriz_comedor_comida_tipo;            
            
            $data['oper'] = "agregar";
            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('plantilla/menu');
            $this->load->view('comensal/v_comensal_frm_4', $data);
            $this->load->view('plantilla/footer');                
        }else{
            $this->session->sess_destroy('username');
            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('login/v_login_1');
            $this->load->view('plantilla/footer');
        }
    }    
    
    //PARA AGREGAR UNA LISTA DE COMENSALES PARA LA PROGRAMACION
    public function agregar_3(){
        
        $logged = $this->Conf_usuarios_model->isLogged();
        $id_conf_roles_es_3 = $this->session->userdata('id_conf_roles_es_3');
        $logged = $this->Conf_usuarios_model->isLogged();
        if($logged == TRUE && ($id_conf_roles_es_3 == true)){

            $valor = "cedula";                  if ( isset($_POST[$valor]) 	){	$cedula = $_POST[$valor];               }else{	$cedula	= "";	}
            $valor = "carnet";                  if ( isset($_POST[$valor]) 	){	$carnet = $_POST[$valor];               }else{	$carnet	= "";	}
            $valor = "fecha";                   if ( isset($_POST[$valor]) 	){	$fecha = $_POST[$valor];                }else{	$fecha	= "";	}
            $valor = "comedor_comida_tipo_id";  if ( isset($_POST[$valor]) 	){	$comedor_comida_tipo_id = $_POST[$valor];                }else{	$comedor_comida_tipo_id	= "";	}
            
            unset($matriz_comedor_comida_tipo);
            $matriz_comedor_comida_tipo = $this->Comedor_comida_tipo_model->comedor_comida_tipo_buscar_3($comedor_comida_tipo_id);
            
            $hora  = $matriz_comedor_comida_tipo[0]->hora_desde;
            $fecha = $this->ordena_fecha_3($fecha);   
            
            $fecha_con_formato = $this->ordena_fecha_5($fecha);    

            //SI LA PERSONA ESTA ACTIVO COMO PERSONAL EXTERNO Y EN EL AREA DE PERSONAL, AQUI LO DESCATIVO EN LA FICHA DE PERSONAL EXTERNO
            unset($matriz_personal_ivic);
            $matriz_personal_ivic         = $this->Personal_ivic_model->personal_ivic_buscar_7($cedula, $carnet);
            unset($matriz_personal_visitante);
            $matriz_personal_visitante    = $this->Personal_visitante_model->personal_visitante_buscar_4($cedula);
            if($matriz_personal_ivic != false && $matriz_personal_visitante != false){
                if($matriz_personal_ivic[0]->estado == 1 
                        && $matriz_personal_visitante[0]->estado == 1){
                    $this->Personal_visitante_model->personal_visitante_editar_2($matriz_personal_visitante[0]->id, "2");
                    $persona = $this->cargo_personal_detalles("", $matriz_personal_visitante[0]->id);
                    $mensaje  = "Al personal externo, ".$persona.", se le ha cambiado de forma automatica el estatus a no activo, porque ya tenia un estatus activo como personal del ivic ";
                    $this->insertar_bitacora_2("personal_visitante", $mensaje, $mensaje);
                }                        
            }
            //FI DE SI LA PERSONA ESTA ACTIVO COMO PERSONAL EXTERNO Y EN EL AREA DE PERSONAL, AQUI LO DESCATIVO EN LA FICHA DE PERSONAL EXTERNO

            $id_comedor_comida_tipo             = $matriz_comedor_comida_tipo[0]->id;
            $nombre_comedor_comida_tipo         = $matriz_comedor_comida_tipo[0]->nombre;

            unset($matriz_personal_ivic);
            $matriz_personal_ivic         = $this->Personal_ivic_model->personal_ivic_buscar_7($cedula, $carnet);
            unset($matriz_personal_visitante);
            $matriz_personal_visitante    = $this->Personal_visitante_model->personal_visitante_buscar_4($cedula);
            //echo "matriz_personal_visitante *<pre>"; print_r($matriz_personal_visitante); echo "</pre>*";

            $busquedad_no_encontrada = false;
            if($cedula > 0 or $carnet > 0){
                if($matriz_personal_ivic == false && $matriz_personal_visitante ==false){
                    $busquedad_no_encontrada = true;
                }
            }

            if($matriz_personal_ivic != false){
                    if($matriz_personal_ivic[0]->id_cargo > 0){
                        $matriz_cargos = $this->Cargos_model->cargos_buscar_2($matriz_personal_ivic[0]->id_cargo);
                        $matriz_personal_ivic[0]->cargos_nombre = $matriz_cargos[0]->nombre;                        
                    } 
                    if($matriz_personal_ivic[0]->id_gerencia > 0){
                        $matriz_gerencias = $this->Gerencias_model->gerencias_buscar_2($matriz_personal_ivic[0]->id_gerencia);
                        $matriz_personal_ivic[0]->gerencia_nombre = $matriz_gerencias[0]->nombre;                        
                    }                    
                    if($matriz_personal_ivic[0]->estado > 0){
                            switch ($matriz_personal_ivic[0]->estado) {
                                case 1:     $estado_nombre = "Activo";  break;
                                case 2:     $estado_nombre = "Egresado";  break;
                                case 3:     $estado_nombre = "Vacaciones";  break;
                                case 4:     $estado_nombre = "Reposo";  break;
                                case 5:     $estado_nombre = "Suspendido";  break;
                            }                    
                            $matriz_personal_ivic[0]->estado_nombre = $estado_nombre;
                    }

                    //_______________________________________________________________________________________________
                    //A LA MATRIZ LE COLOCO EL NOMBRE DE LA FOTO POR DEFECTO PARA CUANDO NO TENGA FOTO REGISTRADA
                    if($matriz_personal_ivic != false){
                            for($i = 0; $i < count($matriz_personal_ivic); $i++){
                                $ruta = "images/personal_ivic/".$matriz_personal_ivic[$i]->imagen_nombre; //echo "ruta *".$ruta."*";
                                if(file_exists($ruta) == true){
                                }else{
                                    $matriz_personal_ivic[$i]->imagen_nombre = "sin_imagen.png";

                                }                                
                            }                        
                    }
                    //FIN DE A LA MATRIZ LE COLOCO EL NOMBRE DE LA FOTO POR DEFECTO PARA CUANDO NO TENGA FOTO REGISTRADA
                    //_______________________________________________________________________________________________                            

                    //VALIDA SI PUEDE REGISTRAR -----------------------------------------------------------------------
                    for($i = 0; $i < count($matriz_personal_ivic); $i++){
                            $puede_registrar = true;
                            $mensaje_de_porque_no_registra = "";                                    

                            //VALIDA QUE NO REPITA
                            unset($matriz_comensales);
                            $matriz_comensales = $this->Comensal_model->comensales_buscar_5($matriz_personal_ivic[$i]->id, $id_comedor_comida_tipo, $fecha, 1);
                            if($matriz_comensales == false){ }else{

                                //BUSCO LA PERSONA QUE LO REGISTRO ----------------------------------
                                $persona_q_registra = "";
                                $matriz_conf_usuarios = $this->Conf_usuarios_model->conf_usuarios_buscar_2($matriz_comensales[0]->id_usuario);
                                if($matriz_conf_usuarios != false){
                                    $persona_q_registra = $matriz_conf_usuarios[0]->nombre_usu." ".$matriz_conf_usuarios[0]->apellido_usu;    
                                }
                                //FIN DE BUSCO LA PERSONA QUE LO REGISTRO ---------------------------

                                $puede_registrar = false;
                                $mensaje_de_porque_no_registra  = "No puede Registrar nuevamente, EL comensal, ya tiene un registro, <br />en la fecha <b>".$fecha_con_formato." ".$matriz_comensales[0]->hora."</b> con tipo de comida <b>".$nombre_comedor_comida_tipo."</b>";
                                if($persona_q_registra != ""){
                                    $mensaje_de_porque_no_registra .= ", <br /> fue registrado por <b>".$persona_q_registra."</b>";    
                                }

                                ////GUARDO EN BITACORA ---------------------------------
                                //$persona = $this->cargo_personal_detalles($matriz_personal_ivic[$i]->id, "");
                                //$mensaje = "Intento de Repetir, El personal del IVIC ".$persona.", ya tiene un tipo de comida de tipo ".$matriz_comedor_comida_tipo[0]->nombre.", en el dia ".$fecha;
                                //$this->insertar_bitacora_2("", "", $mensaje);                                    
                                ////FIN DE GUARDO EN BITACORA ---------------------------------                                                                            
                            }
                            //FIN DE VALIDA QUE NO REPITA

                            //VALIDA EL TIPO DE PERSONAL
                            if($matriz_personal_ivic[$i]->estado == 1){}
                            else{
                                $puede_registrar = false;
                                $mensaje_de_porque_no_registra = "No puede Registrar, EL comensal, no tiene un Estado de <b>Activo</b>";
                            }
                            //FIN DE VALIDA EL TIPO DE PERSONAL

                            //VALIDA si el personal tiene un estado temporal
                            if($puede_registrar == true){
                                unset($matriz_estados_temporales);
                                $matriz_estados_temporales = $this->Estados_temporales_model->estados_temporales_buscar_6($matriz_personal_ivic[$i]->id, $fecha);
                                if($matriz_estados_temporales == false){}
                                else{
                                    $matriz_estados_temporales[0]->estados_temporales_fecha_desde = $this->ordena_fecha_5($matriz_estados_temporales[0]->estados_temporales_fecha_desde);
                                    $matriz_estados_temporales[0]->estados_temporales_fecha_hasta = $this->ordena_fecha_5($matriz_estados_temporales[0]->estados_temporales_fecha_hasta);
                                    $estado_temporal = "";
                                    $estado_temporal  =     $matriz_estados_temporales[0]->estados_nombre;
                                    $estado_temporal .= " En las fechas Desde ".$matriz_estados_temporales[0]->estados_temporales_fecha_desde;
                                    $estado_temporal .= " Hasta ".$matriz_estados_temporales[0]->estados_temporales_fecha_hasta;
                                    $puede_registrar = false;
                                    $mensaje_de_porque_no_registra = "No puede Registrar, EL comensal, tiene un Estado Temporal de <b>".$estado_temporal."</b>";
                                }                                        
                            }
                            //Fin de VALIDA si el personal tiene un estado temporal                                    

                            //GUARDO EN BITACORA CUANDO INTENTO REGISTRAR ---------------------------------                                    
                            if($puede_registrar == false){
                                $persona = $this->cargo_personal_detalles($matriz_personal_ivic[$i]->id, "");
                                $mensaje  = "Intento de Repetir, El personal del IVIC ".$persona;
                                $mensaje .= ", ".$mensaje_de_porque_no_registra;
                                $this->insertar_bitacora_2("", "", $mensaje);                                    
                            }
                            //FIN DE GUARDO EN BITACORA CUANDO INTENTO REGISTRAR ---------------------------------                                    

                            $matriz_personal_ivic[$i]->puede_registrar                  = $puede_registrar;
                            $matriz_personal_ivic[$i]->mensaje_de_porque_no_registra    = $mensaje_de_porque_no_registra;

                    }
                    //FIN DE VALIDA SI PUEDE REGISTRAR ___________________________________________________________

            }
            //echo "matriz_personal_ivic *<pre>"; print_r($matriz_personal_ivic); echo "</pre>*";
            //[0] => stdClass Object
            //    (
            //        [id] => 6
            //        [cedula] => 10850205
            //        [nombres] => Leidy Mar
            //        [apellidos] => Ramírez Cástro
            //        [id_cargo] => 1
            //        [id_gerencia] => 6
            //        [estado] => 1
            //        [imagen_nombre] => 
            //        [carnet_codigo] => 10109
            //        [cargos_nombre] => Analista I
            //        [gerencia_nombre] => Caja y Banco
            //        [estado_nombre] => Activo
            //        [puede_registrar] => 1
            //        [mensaje_de_porque_no_registra] => 
            //    )                     

            //echo "matriz_personal_visitante *<pre>"; print_r($matriz_personal_visitante); echo "</pre>*";
            //[0] => stdClass Object
            //    (
            //        [id] => 2
            //        [cedula] => 18123456
            //        [nombres] => Ignasio
            //        [apellidos] => Vargas
            //        [imagen_nombre] => 
            //        [estado] => 1
            //        [id_personal_visitante_tipo] => 5
            //    )          
            if($matriz_personal_visitante != false){
                    if($matriz_personal_visitante[0]->estado > 0){
                            switch ($matriz_personal_visitante[0]->estado) {
                                case 1:     $estado_nombre = "Activo";  break;
                                case 2:     $estado_nombre = "No Activo";  break;
                            }                    
                            $matriz_personal_visitante[0]->estado_nombre = $estado_nombre;
                    }


                    if($matriz_personal_visitante[0]->id_personal_visitante_tipo > 0){
                        $matriz_personal_visitante_tipo = $this->Personal_visitante_tipo_model->personal_visitante_tipo_buscar_2($matriz_personal_visitante[0]->id_personal_visitante_tipo);
                        $matriz_personal_visitante[0]->tipo_nombre = $matriz_personal_visitante_tipo[0]->nombre;
                    }                           

                    //VALIDA SI PUEDE REGISTRAR -----------------------------------------------------------------------
                    for($i = 0; $i < count($matriz_personal_visitante); $i++){
                            $puede_registrar = true;
                            $mensaje_de_porque_no_registra = "";                                    

                            //VALIDA QUE NO REPITA
                            unset($matriz_comensales);
                            $matriz_comensales = $this->Comensal_model->comensales_buscar_8($matriz_personal_visitante[$i]->id, $id_comedor_comida_tipo, $fecha, 1);
                            if($matriz_comensales == false){ }else{

                                //BUSCO LA PERSONA QUE LO REGISTRO ----------------------------------
                                $persona_q_registra = "";
                                $matriz_conf_usuarios = $this->Conf_usuarios_model->conf_usuarios_buscar_2($matriz_comensales[0]->id_usuario);
                                if($matriz_conf_usuarios != false){
                                    $persona_q_registra = $matriz_conf_usuarios[0]->nombre_usu." ".$matriz_conf_usuarios[0]->apellido_usu;    
                                }
                                //FIN DE BUSCO LA PERSONA QUE LO REGISTRO ---------------------------                                        
                                $puede_registrar = false;
                                $mensaje_de_porque_no_registra  = "No puede Registrar nuevamente, EL comensal, ya tiene un registro, <br />en la fecha <b>".$fecha_con_formato." ".$matriz_comensales[0]->hora."</b> con tipo de comida <b>".$nombre_comedor_comida_tipo."</b>";
                                if($persona_q_registra != ""){
                                    $mensaje_de_porque_no_registra .= ", <br /> fue registrado por <b>".$persona_q_registra."</b>";    
                                }                                        

                                //GUARDO EN BITACORA ---------------------------------
                                $persona = $this->cargo_personal_detalles("", $matriz_personal_visitante[$i]->id);
                                $mensaje = "Intento de Repetir, El personal Externo".$persona.", ya tiene un tipo de comida de tipo ".$matriz_comedor_comida_tipo[0]->nombre.", en el dia ".$fecha;
                                $this->insertar_bitacora_2("", "", $mensaje);                                    
                                //FIN DE GUARDO EN BITACORA ---------------------------------
                            }
                            //FIN DE VALIDA QUE NO REPITA

                            //VALIDA EL Estado DE PERSONAL
                            if($matriz_personal_visitante[$i]->estado == 1){}
                            else{
                                $puede_registrar = false;
                                $mensaje_de_porque_no_registra = "No puede Registrar, EL comensal, no tiene un Estado de <b>Activo</b>";
                            }
                            //FIN DE VALIDA EL Estado DE PERSONAL

                            $matriz_personal_visitante[$i]->puede_registrar                  = $puede_registrar;
                            $matriz_personal_visitante[$i]->mensaje_de_porque_no_registra    = $mensaje_de_porque_no_registra;

                    }
                    //FIN DE VALIDA SI PUEDE REGISTRAR ___________________________________________________________

            }
            
            //echo "matriz_personal_visitante *<pre>"; print_r($matriz_personal_visitante); echo "</pre>*";
            //[0] => stdClass Object
            //    (
            //        [id] => 2
            //        [cedula] => 18123456
            //        [nombres] => Ignasio
            //        [apellidos] => Vargas
            //        [imagen_nombre] => 
            //        [estado] => 1
            //        [id_personal_visitante_tipo] => 5
            //        [estado_nombre] => Activo
            //        [tipo_nombre] => Visitante
            //        [puede_registrar] => 
            //        [mensaje_de_porque_no_registra] => No puede Registrar nuevamente, EL comensal, ya tiene un registro, en la fecha 02-03-2023 con tipo de comida Almuerzo
            //    )                    

            $matriz_comensales_programacion = $this->cargo_ultimos_comensales_programacion($fecha, $comedor_comida_tipo_id);
            $fecha = $this->ordena_fecha_4($fecha);    
            
            $data['nombre_comedor_comida_tipo']     = $nombre_comedor_comida_tipo;            
            $data['busquedad_no_encontrada']        = $busquedad_no_encontrada;
            $data['matriz_personal_ivic']           = $matriz_personal_ivic;
            $data['matriz_personal_visitante']      = $matriz_personal_visitante;
            $data['matriz_comensales_programacion'] = $matriz_comensales_programacion;            
            $data['fecha']                          = $fecha;
            $data['hora']                           = $hora;
            $data['comedor_comida_tipo_id']         = $comedor_comida_tipo_id;
            
            $data['oper'] = "agregar";
            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('plantilla/menu');
            $this->load->view('comensal/v_comensal_frm_3', $data);
            $this->load->view('plantilla/footer');
            
        }else{
            $this->session->sess_destroy('username');
            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('login/v_login_1');
            $this->load->view('plantilla/footer');
        }
    }    
    
    public function llama_reporte_form($b_fecha_desde, $b_fecha_hasta, $cedula, $tipo_personal, $id_comedor_comida_tipo, $id_personal_visitante_tipo, $estados_id, $formato){
        $logged = $this->Conf_usuarios_model->isLogged();
        if($logged == TRUE){
            
            if($b_fecha_desde == "NULL"){         $b_fecha_desde = "";          }
            $data['b_fecha_desde'] = $b_fecha_desde;
            if(strlen($b_fecha_desde) > 0){
                $b_fecha_desde = $this->ordena_fecha($b_fecha_desde);    
            }
            $data['b_fecha_desde'] = $b_fecha_desde;            
            
            if($b_fecha_hasta == "NULL"){         $b_fecha_hasta = "";          }
            $data['b_fecha_hasta'] = $b_fecha_hasta;
            if(strlen($b_fecha_hasta) > 0){
                $b_fecha_hasta = $this->ordena_fecha($b_fecha_hasta);    
            }
            $data['b_fecha_hasta'] = $b_fecha_hasta;            

            if($cedula == "NULL"){         $cedula = "";          }
            $data['cedula'] = $cedula;

            if($tipo_personal == "NULL"){         $tipo_personal = "";          }
            $data['tipo_personal'] = $tipo_personal;

            if($id_comedor_comida_tipo == "NULL"){         $id_comedor_comida_tipo = "";          }
            $data['id_comedor_comida_tipo'] = $id_comedor_comida_tipo;

            if($id_personal_visitante_tipo == "NULL"){         $id_personal_visitante_tipo = "";          }
            $data['id_personal_visitante_tipo'] = $id_personal_visitante_tipo;

            if($estados_id == "NULL"){         $estados_id = "";          }
            $data['estados_id'] = $estados_id;
            
            $data['estados_nombre'] = "";
            if($estados_id > 0){
                $matriz_estados = $this->Estados_model->estados_buscar_2($estados_id);
                $data['estados_nombre'] = $matriz_estados[0]->nombre;
            }
            
            $comedor_comida_tipo_nombre = "";
            if($id_comedor_comida_tipo > 0){
                $matriz_comedor_comida_tipo = $this->Comedor_comida_tipo_model->comedor_comida_tipo_buscar_3($id_comedor_comida_tipo);
                $data['comedor_comida_tipo_nombre'] = $matriz_comedor_comida_tipo[0]->nombre;
            }
            
            $personal_visitante_tipo_nombre = "";
            if($id_personal_visitante_tipo > 0){
                $matriz_personal_visitante_tipo = $this->Personal_visitante_tipo_model->personal_visitante_tipo_buscar_2($id_personal_visitante_tipo);
                $data['personal_visitante_tipo_nombre'] = $matriz_personal_visitante_tipo[0]->nombre;
            }            
            
            $filtro_personal_ivic       = 0; 
            $filtro_personal_visitante  = 0;
            if($tipo_personal == 1){
                $filtro_personal_ivic = true;
            }
            if($tipo_personal == 2){
                $filtro_personal_visitante = true;
            }
            
            unset($matriz_comensales);
            $matriz_comensales = $this->Comensal_model->comensales_buscar_6($id_comedor_comida_tipo, $b_fecha_desde, $b_fecha_hasta, $filtro_personal_ivic, $filtro_personal_visitante, 1, $estados_id);
            //echo "matriz_comensales <br />*<pre>"; print_r($matriz_comensales); echo "</pre>*";
            //[0] => stdClass Object
            //    (
            //        [comensales_id] => 1
            //        [comensales_id_personal_ivic] => 15
            //        [comensales_id_personal_visitante] => 
            //        [comensales_fecha] => 2023-02-27
            //        [comensales_hora] => 10:50:49
            //        [comedor_comida_tipo_nombre] => Desayuno
            //    ) 
            
            //FILTRO POR CEDULA-----------------------------------
            //echo "matriz_comensales <br />*<pre>"; print_r($matriz_comensales); echo "</pre>*";
            if($cedula > 0){
                    unset($matriz_comensales_temp); $x = 0;
                    if($matriz_comensales != false){
                            for($i = 0; $i < count($matriz_comensales); $i++){
                                if($matriz_comensales[$i]->comensales_id_personal_ivic > 0){
                                    unset($matriz_personal_ivic);
                                    $matriz_personal_ivic = $this->Personal_ivic_model->personal_ivic_buscar_2($matriz_comensales[$i]->comensales_id_personal_ivic);
                                    if($matriz_personal_ivic[0]->cedula == $cedula){
                                        $matriz_comensales_temp[$x] = $matriz_comensales[$i];
                                        $x = $x + 1;
                                    }
                                }
                                if($matriz_comensales[$i]->comensales_id_personal_visitante > 0){
                                    unset($matriz_personal_visitante);
                                    $matriz_personal_visitante = $this->Personal_visitante_model->personal_visitante_buscar_2($matriz_comensales[$i]->comensales_id_personal_visitante);
                                    //echo "matriz_personal_visitante <br />*<pre>"; print_r($matriz_personal_visitante); echo "</pre>*";
                                    if($matriz_personal_visitante[0]->cedula == $cedula){
                                        $matriz_comensales_temp[$x] = $matriz_comensales[$i];
                                        $x = $x + 1;
                                    }
                                }                        
                            }
                    }
                    unset($matriz_comensales);
                    //echo "matriz_comensales_temp <br />*<pre>"; print_r($matriz_comensales_temp); echo "</pre>*";
                    if(isset($matriz_comensales_temp)){
                        $matriz_comensales = $matriz_comensales_temp;
                    }else{
                        $matriz_comensales = false;
                    }
            }
            //FIN DE FILTRO POR CEDULA----------------------------
            
            //FILTRO POR TIPO----------------------------
            //echo "matriz_comensales <br />*<pre>"; print_r($matriz_comensales); echo "</pre>*";
            //[0] => stdClass Object
            //    (
            //        [comensales_id] => 2
            //        [comensales_id_personal_ivic] => 
            //        [comensales_id_personal_visitante] => 3
            //        [comensales_fecha] => 2023-02-28
            //        [comensales_hora] => 09:35:48
            //        [comedor_comida_tipo_nombre] => Desayuno
            //    )
            if($id_personal_visitante_tipo > 0){
                    unset($matriz_comensales_temp); $x = 0;
                    if($matriz_comensales != false){
                        for($i = 0; $i < count($matriz_comensales); $i++){
                            if($matriz_comensales[$i]->comensales_id_personal_visitante > 0){
                                unset($matriz_personal_visitante);
                                $matriz_personal_visitante = $this->Personal_visitante_model->personal_visitante_buscar_5($matriz_comensales[$i]->comensales_id_personal_visitante);
                                if($matriz_personal_visitante[0]->personal_visitante_tipo_id == $id_personal_visitante_tipo){
                                    $matriz_comensales_temp[$x] = $matriz_comensales[$i];
                                    $x = $x + 1;
                                }                                
                            }
                        }
                    }
                    unset($matriz_comensales);
                    //echo "matriz_comensales_temp <br />*<pre>"; print_r($matriz_comensales_temp); echo "</pre>*";
                    if(isset($matriz_comensales_temp)){
                        $matriz_comensales = $matriz_comensales_temp;
                    }else{
                        $matriz_comensales = false;
                    }                    
            }
            //FIN DE FILTRO POR TIPO----------------------------
            
            
            $personal = "";
            if($matriz_comensales != false){
                
                //echo "matriz_comensales <br />*<pre>"; print_r($matriz_comensales); echo "</pre>*";
                //[0] => stdClass Object
                //    (
                //        [comensales_id] => 10
                //        [comensales_id_personal_ivic] => 
                //        [comensales_id_personal_visitante] => 2
                //        [comensales_fecha] => 2023-03-02
                //        [comensales_hora] => 12:09:29
                //        [comedor_comida_tipo_nombre] => Almuerzo
                //    )
                
                for($i = 0; $i < count($matriz_comensales); $i++){
                    
                    //coloco formato a la fecha --------------------------------
                    $matriz_comensales[$i]->comensales_fecha_con_formato = $this->ordena_fecha_5($matriz_comensales[$i]->comensales_fecha);
                    //FIN DE coloco formato a la fecha -------------------------
                    
                    $personal_cedula = "";
                    $matriz_personal_visitante_tipo = "";
                    if($matriz_comensales[$i]->comensales_id_personal_ivic > 0){
                        unset($matriz_personal_ivic);
                        $matriz_personal_ivic = $this->Personal_ivic_model->personal_ivic_buscar_2($matriz_comensales[$i]->comensales_id_personal_ivic);
                        $personal_cedula     = $matriz_personal_ivic[0]->cedula;
                        $personal            = " ".$matriz_personal_ivic[0]->nombres;
                        $personal           .= " ".$matriz_personal_ivic[0]->apellidos;
                    }
                    if($matriz_comensales[$i]->comensales_id_personal_visitante > 0){
                        unset($matriz_personal_visitante);
                        $matriz_personal_visitante = $this->Personal_visitante_model->personal_visitante_buscar_2($matriz_comensales[$i]->comensales_id_personal_visitante);
                        $personal_cedula     =  $matriz_personal_visitante[0]->cedula;
                        $personal            = " ".$matriz_personal_visitante[0]->nombres;
                        $personal           .= " ".$matriz_personal_visitante[0]->apellidos;                        
                        
                        $matriz_personal_visitante_tipo = $this->Personal_visitante_tipo_model->personal_visitante_tipo_buscar_2($matriz_personal_visitante[0]->id_personal_visitante_tipo);
                        $matriz_personal_visitante_tipo = $matriz_personal_visitante_tipo[0]->nombre;
                        
                    }                    
                    $matriz_comensales[$i]->personal_cedula = $personal_cedula;
                    $matriz_comensales[$i]->personal = $personal;
                    $matriz_comensales[$i]->personal_visitante_tipo_nombre = $matriz_personal_visitante_tipo;
                    
                    $estado_temporal = "";
                    unset($matriz_comensales_h_estado_temporal);
                    $matriz_comensales_h_estado_temporal    = $this->Comensales_h_estado_temporal_model->comensales_h_estado_temporal_buscar_2($matriz_comensales[$i]->comensales_id);
                    if($matriz_comensales_h_estado_temporal != false){
                        $estado_temporal  = $matriz_comensales_h_estado_temporal[0]->estados_nombre;
                        $estado_temporal .= " DESDE:".$matriz_comensales_h_estado_temporal[0]->comensales_h_estado_temporal_fecha_desde;
                        $estado_temporal .= " HASTA:".$matriz_comensales_h_estado_temporal[0]->comensales_h_estado_temporal_fecha_hasta;
                    }
                    $matriz_comensales[$i]->estado_temporal = $estado_temporal;
                    
                }                
            }
            
            //echo "matriz_comensales <pre>"; print_r($matriz_comensales); echo "</pre>";
            
            $data['matriz_comensales']            = $matriz_comensales;
            if($formato == "pdf"){
                $this->load->view('comensal/reporte_comensales.php', $data);        
            }
            if($formato == "excel"){
                $this->load->view('comensal/reporte_comensal_excel.php', $data);
            }
        }else{
                    $this->session->sess_destroy('username');
                    $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
                    $this->load->view('plantilla/header', $data);
                    $this->load->view('login/v_login_1');
                    $this->load->view('plantilla/footer');
        }
    }
    //Fin de AQUI SE llama al formulario de reporte
    //_____________________________________________________________________________________________________________________________________________
    
    //BUSCO LOS DETALLES DE LA PERSONA
    private function cargo_personal_detalles($id_personal_ivic, $id_personal_visitante){
            $persona = "";
            if($id_personal_ivic > 0){
                $matriz_personal_ivic = $this->Personal_ivic_model->personal_ivic_buscar_2($id_personal_ivic);
                $persona  = "(".$matriz_personal_ivic[0]->cedula.") ";
                $persona .= " ".$matriz_personal_ivic[0]->nombres;
                $persona .= " ".$matriz_personal_ivic[0]->apellidos;
            }
            if($id_personal_visitante > 0){
                $matriz_personal_visitante = $this->Personal_visitante_model->personal_visitante_buscar_2($id_personal_visitante);
                $persona  = "(".$matriz_personal_visitante[0]->cedula.") ";
                $persona .= " ".$matriz_personal_visitante[0]->nombres;
                $persona .= " ".$matriz_personal_visitante[0]->apellidos;
            }            
            return $persona;
    }
    
    private function cargo_ultimos_comensales_programacion($fecha, $id_comedor_comida_tipo){
            $matriz_comensales_programacion = $this->Comensales_programacion_model->comensales_programacion_buscar_4($id_comedor_comida_tipo, $fecha);
            if($matriz_comensales_programacion != false){
                for($i = 0; $i < count($matriz_comensales_programacion); $i++){
                    if($matriz_comensales_programacion[$i]->id_personal_ivic > 0){
                        unset($matriz_personal_ivic_temp);
                        $matriz_personal_ivic_temp = $this->Personal_ivic_model->personal_ivic_buscar_2($matriz_comensales_programacion[$i]->id_personal_ivic);
                        $matriz_comensales_programacion[$i]->cedula      = $matriz_personal_ivic_temp[0]->cedula;
                        $matriz_comensales_programacion[$i]->nombres     = $matriz_personal_ivic_temp[0]->nombres;
                        $matriz_comensales_programacion[$i]->apellidos   = $matriz_personal_ivic_temp[0]->apellidos;

                        $matriz_comensales_programacion[$i]->carnet_codigo   = $matriz_personal_ivic_temp[0]->carnet_codigo;

                    }
                    if($matriz_comensales_programacion[$i]->id_personal_visitante > 0){
                        unset($matriz_personal_visitante_temp);
                        $matriz_personal_visitante_temp = $this->Personal_visitante_model->personal_visitante_buscar_2($matriz_comensales_programacion[$i]->id_personal_visitante);
                        $matriz_comensales_programacion[$i]->cedula      = $matriz_personal_visitante_temp[0]->cedula;
                        $matriz_comensales_programacion[$i]->nombres     = $matriz_personal_visitante_temp[0]->nombres;
                        $matriz_comensales_programacion[$i]->apellidos   = $matriz_personal_visitante_temp[0]->apellidos;
                    }
                    //$matriz_comensales_programacion[$i]->personal = $personal;

                    $matriz_comensales_programacion[$i]->fecha_con_formato = $this->ordena_fecha($matriz_comensales_programacion[$i]->fecha);

                    $comida_tipo = "";
                    unset($matriz_comedor_comida_tipo_2);
                    $matriz_comedor_comida_tipo_2 = $this->Comedor_comida_tipo_model->comedor_comida_tipo_buscar_3($matriz_comensales_programacion[$i]->id_comedor_comida_tipo);
                    $comida_tipo = $matriz_comedor_comida_tipo_2[0]->nombre;
                    $matriz_comensales_programacion[$i]->comida_tipo = $comida_tipo;                    

                }                
            }
            return $matriz_comensales_programacion;
    }
    
    
    // ORDENAR EL FORMATO DE LA FECHA
    //  RECIBE LA FECHA EN FORMATO "2010-07-13" Y LA REGRESA EN "dd-mm-YYYY"
    //Y RECIBE LA FECHA EN FORMATO "dd-mm-YYYY" Y LA REGRESA EN "YYYY-mm-dd"
    public function ordena_fecha($fecha){
            $fecha = explode("-", $fecha);
            $dia = $fecha[2];	$mes = $fecha[1];	$anno = $fecha[0];
            return $dia."-".$mes."-".$anno;
    } 
    
    // RECIBE LA FECHA EN FORMATO "dd/mm/YYYY" Y LA REGRESA EN "YYYY-mm-dd"
    public function ordena_fecha_3($fecha){
            $parte2 = explode("/", $fecha);
            return $parte2[2]."-".$parte2[1]."-".$parte2[0];
    }

    // RECIBE LA FECHA EN FORMATO "YYYY-mm-dd" Y LA REGRESA EN "dd/mm/YYYY"
    public function ordena_fecha_4($fecha){
            $parte2 = explode("-", $fecha);
            return $parte2[2]."/".$parte2[1]."/".$parte2[0];
    }    
    
    // RECIBE LA FECHA EN FORMATO "dd-mm-YYYY" Y LA REGRESA EN "YYYY-mm-dd"
    // RECIBE LA FECHA EN FORMATO "YYYY-mm-dd" Y LA REGRESA EN "dd-mm-YYYY"
    public function ordena_fecha_5($fecha){
            $parte2 = explode("-", $fecha);
            return $parte2[2]."-".$parte2[1]."-".$parte2[0];
    } 
    
}
    