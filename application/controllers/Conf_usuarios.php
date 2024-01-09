<?php
require_once APPPATH.'controllers/Controlador_padre.php';
class Conf_usuarios extends Controlador_padre {
    
    function __construct(){
        parent::__construct();
        $this->load->library('Session');
        $this->load->model('Conf_usuarios_model');
        $this->load->model('Conf_usu_pass_model');
        $this->load->model('Conf_roles_model');
        $this->load->model('Conf_bitacora_model');
        $this->load->model('Conf_roles_model');
        //$this->load->model('Profesor_ficha_model');
        //$this->load->model('Estudiante_ficha_model');
        //$this->load->model('Estudiante_pensum_model');
        //$this->load->model('Conf_configuracion_model');
        //$this->load->model('Estudiante_ficha_estatus_model');
    }

    public function listar($memoria = 'false'){
        $id_conf_roles_es_1 = $this->session->userdata('id_conf_roles_es_1');
        $logged = $this->Conf_usuarios_model->isLogged();
        if($logged == TRUE && $id_conf_roles_es_1 == true){

            if($memoria == 'limpiar'){
                $this->session->unset_userdata('conf_usuarios_b_texto');
                $this->session->unset_userdata('conf_usuarios_b_estado');
            }            
            
            if (	isset ($_POST['b_texto'])	){
                    $b_texto = $_POST['b_texto'];
                    $s_busquedad = array(
                            'conf_usuarios_b_texto' => $b_texto
                    );
                    $this->session->set_userdata($s_busquedad);
            }else{
                    $b_texto = "";
                    if( strlen($this->session->userdata('conf_usuarios_b_texto')) > 0  ){
                        $b_texto = $this->session->userdata('conf_usuarios_b_texto');
                    }
            }
            $b_texto = str_replace("'", "", $b_texto);              

            if (	isset ($_POST['b_estado'])	){
                    $b_estado = $_POST['b_estado'];
                    $s_busquedad = array(
                            'conf_usuarios_b_estado' => $b_estado
                    );
                    $this->session->set_userdata($s_busquedad);
            }else{
                    $b_estado = "";
                    if( strlen($this->session->userdata('conf_usuarios_b_estado')) > 0  ){
                        $b_estado = $this->session->userdata('conf_usuarios_b_estado');
                    }
            }            
            
            if (	isset ($_POST['b_campo_ordenar'])	){
                    $b_campo_ordenar = $_POST['b_campo_ordenar'];
                    $s_busquedad = array(
                            'conf_usuarios_b_campo_ordenar' => $b_campo_ordenar
                    );
                    $this->session->set_userdata($s_busquedad);
            }else{
                    $b_campo_ordenar = "conf_usuarios.ci_usu";
                    if( strlen($this->session->userdata('conf_usuarios_b_campo_ordenar')) > 0  ){
                        $b_campo_ordenar = $this->session->userdata('conf_usuarios_b_campo_ordenar');
                    }
            }

            if (	isset ($_POST['b_orden'])	){
                    $b_orden = $_POST['b_orden'];
                    $s_busquedad = array(
                            'conf_usuarios_b_orden' => $b_orden
                    );
                    $this->session->set_userdata($s_busquedad);
            }else{
                    $b_orden = "DESC";
                    if( strlen($this->session->userdata('conf_usuarios_b_orden')) > 0  ){
                        $b_orden = $this->session->userdata('conf_usuarios_b_orden');
                    }
            }                
            //echo "<br />b_campo_ordenar *".$b_campo_ordenar."*"; echo "<br />b_orden *".$b_orden."*";            
            
            if($memoria == 'cargo_ultima_pagina'){
                    $pagina_actual = $this->session->userdata('conf_usuarios_ultima_pagina');    
                    $segmento = $pagina_actual;                    
            }else{
                    $pagina_actual = "";
                    $pieces = explode("/", $_SERVER['PHP_SELF']);
                    for($i = 0; $i < count($pieces); $i++){
                        if($pieces[$i] == 'pagina'){
                            $i_mas1 = $i + 1;
                            if(isset($pieces[$i_mas1])){
                                $pagina_actual = $pieces[$i_mas1];                            
                            }
                        }
                    }
                    $s_lista = array(
                        'conf_usuarios_ultima_pagina' => $pagina_actual
                    );
                    $this->session->set_userdata($s_lista);                    
                    $segmento = $this->uri->segment(4);                    
            }            
            
            $this->load->helper('form');
            $this->load->library('pagination');
            $pages = 8; //Número de registros mostrados por páginas
            $config['base_url'] = base_url().'index.php/Conf_usuarios/listar/pagina'; // parametro base de la aplicación, si tenemos un .htaccess nos evitamos el index.php
    //      $config['total_rows'] = 20; //calcula el número de filas
            $total_rows           = $this->Conf_usuarios_model->conf_usuarios_num_reg($b_texto, $b_estado);
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
            //el array con los datos a paginar ya preparados
            unset($dat_list);
            $dat_list = $this->Conf_usuarios_model->conf_usuarios_buscar($b_texto, $b_estado, $b_campo_ordenar, $b_orden, $config['per_page'],$segmento);
            //Busco los campos de paginacion
            $data['pag_desde'] = 0;
            $data['pag_hasta'] = 0;
            if($dat_list != false){
                $data['pag_desde']   = $segmento + 1;
                $data['pag_hasta']   = ($segmento) + count($dat_list);                    
            }
            $data['pag_totales'] = $total_rows;
            //Fin de Busco los campos de paginacion
                            
            //Agrego el campo $tiene_movimiento y tiene_pensum a la matriz datalist
            if($dat_list != false){
                for($i=0; $i<count($dat_list); $i++){
                    $matriz_conf_bitacora = $this->Conf_bitacora_model->conf_bitacora_num_reg_2($dat_list[$i]->id_usuario);
                    $dat_list[$i]->tiene_movimiento = $matriz_conf_bitacora;
                }   //echo "<hr /> dat_list <pre>*"; print_r($dat_list); echo "</pre>";                
            }
            //Fin de Agrego el campo $tiene_movimiento a la matriz datalist
            
            $dat_list['dat_list'] = $dat_list;
            $dat_list['b_texto']  = $b_texto;
            $dat_list['b_estado'] = $b_estado;
            $dat_list['b_campo_ordenar'] = $b_campo_ordenar;
            $dat_list['b_orden']  = $b_orden;

            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('plantilla/menu');
            $this->load->view('conf_usuarios/v_conf_usuarios_listar', $dat_list);
            $this->load->view('plantilla/footer');

        }else{
            $this->session->sess_destroy('username');
            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('login/v_login_1');
            $this->load->view('plantilla/footer');
        }

    }
    
    public function agregar(){
        $matriz_conf_usuarios_roles = $this->Conf_roles_model->conf_usuarios_roles_buscar_2($this->session->userdata('iduser'), 1);
        if( $matriz_conf_usuarios_roles != false ){ $data['id_conf_roles_es_1'] = true;    }else{ $data['id_conf_roles_es_1'] = false; }
        $matriz_conf_usuarios_roles = $this->Conf_roles_model->conf_usuarios_roles_buscar_2($this->session->userdata('iduser'), 2);
        if( $matriz_conf_usuarios_roles != false ){ $data['id_conf_roles_es_2'] = true;    }else{ $data['id_conf_roles_es_2'] = false; }
        $matriz_conf_usuarios_roles = $this->Conf_roles_model->conf_usuarios_roles_buscar_2($this->session->userdata('iduser'), 3);
        if( $matriz_conf_usuarios_roles != false ){ $data['id_conf_roles_es_3'] = true;    }else{ $data['id_conf_roles_es_3'] = false; }
        $matriz_conf_usuarios_roles = $this->Conf_roles_model->conf_usuarios_roles_buscar_2($this->session->userdata('iduser'), 4);
        if( $matriz_conf_usuarios_roles != false ){ $data['id_conf_roles_es_4'] = true;    }else{ $data['id_conf_roles_es_4'] = false; }
        $matriz_conf_usuarios_roles = $this->Conf_roles_model->conf_usuarios_roles_buscar_2($this->session->userdata('iduser'), 5);
        if( $matriz_conf_usuarios_roles != false ){ $data['id_conf_roles_es_5'] = true;    }else{ $data['id_conf_roles_es_5'] = false; }
        
        $logged = $this->Conf_usuarios_model->isLogged();
        //if($logged == TRUE && $data['id_conf_roles_es_1'] == true){ //USUARIO ADMINISTRADOR
        if($data['id_conf_roles_es_1'] == true or $data['id_conf_roles_es_4'] == true){
            
            $matriz_conf_roles = $this->Conf_roles_model->conf_roles_buscar_3();
            $data['matriz_conf_roles'] = $matriz_conf_roles;
            
            $data['menu_origen'] = "Conf_usuarios_listar";
            
//            $matriz_conf_usuarios_roles = $this->Conf_roles_model->conf_usuarios_roles_buscar_2($this->session->userdata('iduser'), 1);   //echo "<pre>matriz_conf_usuarios_roles *"; print_r($matriz_conf_usuarios_roles); echo "*</pre>";
//            if( $matriz_conf_usuarios_roles != false ){    $data['conf_roles_id_es_1'] = true;    
//            }else{                                              $data['conf_roles_id_es_1'] = false; }            
            
            $data['matriz_conf_usuarios_roles'] = "";
            
            $data['oper'] = "agregar";
            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
            
            //echo "data <pre> *"; print_r($data); echo "*</pre>data";
            
            $this->load->view('plantilla/header', $data);
            $this->load->view('plantilla/menu');
            $this->load->view('conf_usuarios/v_conf_usuarios_frm', $data);
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
        
            $valor = "ci_usu";          if ( isset($_POST[$valor]) 	){	$parametros[$valor] = $_POST[$valor];                   }else{	$parametros[$valor]	= "";	}
            $valor = "nombre_usu"; 	if ( isset($_POST[$valor]) 	){	$parametros[$valor] = ucfirst( $_POST[$valor] );	}else{	$parametros[$valor]	= "";	}
            $valor = "apellido_usu"; 	if ( isset($_POST[$valor]) 	){	$parametros[$valor] = ucfirst( $_POST[$valor] );	}else{	$parametros[$valor]	= "";	}
            $valor = "direccion_usu"; 	if ( isset($_POST[$valor]) 	){	$parametros[$valor] = ucfirst( $_POST[$valor] );	}else{	$parametros[$valor]	= "";	}
            $valor = "telefono_1"; 	if ( isset($_POST[$valor]) 	){	$parametros[$valor] = $_POST[$valor];                   }else{	$parametros[$valor]	= "";	}
            $valor = "telefono_2"; 	if ( isset($_POST[$valor]) 	){	$parametros[$valor] = $_POST[$valor];                   }else{	$parametros[$valor]	= "";	}
            $valor = "correo";          if ( isset($_POST[$valor]) 	){	$parametros[$valor] = $_POST[$valor];                   }else{	$parametros[$valor]	= "";	}            
            $valor = "usuario_usu"; 	if ( isset($_POST[$valor]) 	){	$parametros[$valor] = $_POST[$valor];                   }else{	$parametros[$valor]	= "";	}
            $valor = "pass_usu"; 	if ( isset($_POST[$valor]) 	){	$parametros[$valor] = $_POST[$valor];                   }else{	$parametros[$valor]	= "";	}
            $valor = "rol_actualizar";  if ( isset($_POST[$valor]) 	){	$parametros[$valor] = $_POST[$valor];                   }else{	$parametros[$valor]	= "";	}
            $valor = "rol";             if ( isset($_POST[$valor]) 	){	$parametros[$valor] = $_POST[$valor];                   }else{	$parametros[$valor]	= "false";	}            
            $valor = "estado";          if ( isset($_POST[$valor]) 	){	$parametros[$valor] = $_POST[$valor];                   }else{	$parametros[$valor]	= "";	}

            $parametros["ci_usu"]       = str_replace(".", "", $parametros["ci_usu"]);
            $parametros["pass_usu"]     = md5($parametros["pass_usu"]);
            $parametros["nombre_usu"]   = $this->convierte_texto($parametros["nombre_usu"]);
            $parametros["apellido_usu"] = $this->convierte_texto($parametros["apellido_usu"]);            

            $id_nucleo=$this->session->userdata('id_nucleo');
            
            //Valida reg existente
            $valido = false;
            $conf_usuarios_num_reg = $this->Conf_usuarios_model->conf_usuarios_num_reg_2($parametros['ci_usu']); //echo "conf_usuarios_num_reg *".$conf_usuarios_num_reg."*";

            if($conf_usuarios_num_reg == 0){ $valido = true; }
            else{
                    echo "<script language='javascript'>";
                    echo "alert('El registro no fue incluido, la cedula ya se encuentra en el sistema')";
                    echo "</script>";
                    echo "<script language='javascript'>";
                    echo "window.history.go(-1)";
                    echo "</script>";
            }
            //FIN de Valida reg existente

            if($valido == true){
                    $id_usuario = $this->Conf_usuarios_model->conf_usuarios_insertar($parametros['ci_usu'], $parametros['nombre_usu'], $parametros['apellido_usu'], $parametros['direccion_usu'], $parametros['telefono_1'], $parametros['telefono_2'], $parametros['correo'], $parametros['estado']);
                    if ($id_usuario > 0){
                        
                        //Actualiza los roles       -------------------------------------------------
                        if($parametros['rol_actualizar'] == true){
                            $this->Conf_roles_model->conf_usuarios_roles_eliminar($id_usuario);
                            if($parametros['rol'] != "false"){
                                for($i = 0; $i < count($parametros['rol']); $i++){
                                    $this->Conf_roles_model->conf_usuarios_roles_insertar($id_usuario, $parametros['rol'][$i], $id_nucleo);
                                }
                            }
                        }
                        //Actualiza la ficha del rol asociado-----------
                            $num_encontrado = 0;    $parametros["id_usuario"] = $id_usuario;
                            $rol_2_a_guardar = false;
                            if($parametros['rol'] != "false"){
                                for($i = 0; $i < count($parametros['rol']); $i++){  //echo "<hr>parametros['rol'][i] *".$parametros['rol'][$i]."*";                                
                                    if( $parametros['rol'][$i] == 2){ $rol_2_a_guardar = true; }
                                    if( $parametros['rol'][$i] == 3){ $rol_3_a_guardar = true; }
                                }
                            } //echo "<br />rol_2_a_guardar *".$rol_2_a_guardar."*";

                        //Fin de Actualiza la ficha del rol asociado-----------                        
                        //Fin de actualiza los roles       -------------------------------------------                        
                        $fecha_hora = date("Y-m-d H:i:s");
                        $this->Conf_usu_pass_model->conf_usu_pass_insertar($id_usuario, $parametros['usuario_usu'], $parametros['pass_usu'], $fecha_hora);
                        
                        $mensaje = "Inserto el usuario con id ".$id_usuario;
                        $mensaje_2 = "Inserto el usuario ".$this->calcula_datos_de_conf_usuarios($id_usuario);
                        $s_mensaje = array(
                                'conf_usuarios_mensaje_tipo'         => 'alert-success',
                                'conf_usuarios_mensaje_contenido'    => 'Registros insertado exitosamente, '.$mensaje_2
                        );
                        $this->session->set_userdata($s_mensaje);
                        $this->insertar_bitacora_2("conf_usuarios", $mensaje, $mensaje_2);
                        $this->insertar_bitacora_2("conf_usu_pass", $mensaje, $mensaje_2);

                        redirect('Conf_usuarios/listar');
                    }else{
                        redirect('Conf_usuarios/agregar');
                    }
            }
    }

    /*
    public function subir_archivo($id, $menu_origen){
        $matriz_conf_usuarios_roles = $this->Conf_roles_model->conf_usuarios_roles_buscar_2($this->session->userdata('iduser'), 1);
        if( $matriz_conf_usuarios_roles != false ){ $data['id_conf_roles_es_1'] = true;    }else{ $data['id_conf_roles_es_1'] = false; }
        $matriz_conf_usuarios_roles = $this->Conf_roles_model->conf_usuarios_roles_buscar_2($this->session->userdata('iduser'), 2);
        if( $matriz_conf_usuarios_roles != false ){ $data['id_conf_roles_es_2'] = true;    }else{ $data['id_conf_roles_es_2'] = false; }
        $matriz_conf_usuarios_roles = $this->Conf_roles_model->conf_usuarios_roles_buscar_2($this->session->userdata('iduser'), 3);
        if( $matriz_conf_usuarios_roles != false ){ $data['id_conf_roles_es_3'] = true;    }else{ $data['id_conf_roles_es_3'] = false; }
        $matriz_conf_usuarios_roles = $this->Conf_roles_model->conf_usuarios_roles_buscar_2($this->session->userdata('iduser'), 4);
        if( $matriz_conf_usuarios_roles != false ){ $data['id_conf_roles_es_4'] = true;    }else{ $data['id_conf_roles_es_4'] = false; }
        $matriz_conf_usuarios_roles = $this->Conf_roles_model->conf_usuarios_roles_buscar_2($this->session->userdata('iduser'), 5);
        if( $matriz_conf_usuarios_roles != false ){ $data['id_conf_roles_es_5'] = true;    }else{ $data['id_conf_roles_es_5'] = false; }
        
        $matriz_conf_configuracion = $this->Conf_configuracion_model->conf_configuracion_buscar_2();
        $nombre_de_archivo_login = $matriz_conf_configuracion['nombre_de_archivo_login'];
        
        //$logged = $this->Conf_usuarios_model->isLogged();
        //if($logged == TRUE && $this->session->userdata('usertipo') == 1){ //USUARIO ADMINISTRADOR
        if($data['id_conf_roles_es_1'] == true or $data['id_conf_roles_es_4'] == true){        
            $data['id']             = $id;
            $data['menu_origen']    = $menu_origen;
            
            $data['id_usuario']    = $id;
            
            $data['oper'] = "subir_archivo";
            $data['matriz_conf_configuracion'] = $this->Conf_configuracion_model->conf_configuracion_buscar_2();
            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('plantilla/menu');
            $this->load->view('conf_usuarios/v_conf_usuarios_subir_archivos', $data);
            $this->load->view('plantilla/b_footer_llamados');
            $this->load->view('conf_usuarios/v_footer_llamados');
            $this->load->view('conf_usuarios/ajax_archivos');
            $this->load->view('plantilla/b_footer_cierre');
        }else{
            $this->session->sess_destroy('username');
            $data['matriz_conf_configuracion'] = $this->Conf_configuracion_model->conf_configuracion_buscar_2();
            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('login/v_login_1';
            $this->load->view('plantilla/footer');
        }
    } */
    
    public function editar_como_administrador($id){
        
        $logged = $this->Conf_usuarios_model->isLogged();
        $id_conf_roles_es_1 = $this->session->userdata('id_conf_roles_es_1');
        if($logged == TRUE && $id_conf_roles_es_1 == true){
            
            $data['id'] = $id;
            $data['id_conf_roles_es_1'] = $id_conf_roles_es_1;
            
            $data['menu_origen'] = "Conf_usuarios_listar";
            
            $fila_reg = $this->Conf_usuarios_model->conf_usuarios_buscar_2($id);   //echo "<pre>"; print_r($fila_reg); echo "</pre>";
            $data['conf_usuarios'] = $fila_reg[0];

            $matriz_conf_roles = $this->Conf_roles_model->conf_roles_buscar_3();
            $data['matriz_conf_roles'] = $matriz_conf_roles;
            
            $matriz_conf_usuarios_roles = $this->Conf_roles_model->conf_usuarios_roles_buscar($id); //echo "<pre>matriz_conf_usuarios_roles *"; print_r($matriz_conf_usuarios_roles); echo "*</pre>";
            $data['matriz_conf_usuarios_roles'] = $matriz_conf_usuarios_roles;
            
            $fila_reg = $this->Conf_usu_pass_model->conf_usu_pass_buscar($id);   //echo "<pre>"; print_r($fila_reg); echo "</pre>";
            $data['conf_usu_pass'] = $fila_reg[0];
            
            $matriz_conf_usuarios_roles = $this->Conf_roles_model->conf_usuarios_roles_buscar_2($this->session->userdata('iduser'), 1);   //echo "<pre>matriz_conf_usuarios_roles *"; print_r($matriz_conf_usuarios_roles); echo "*</pre>";
            if( $matriz_conf_usuarios_roles != false ){    $data['conf_roles_id_es_1'] = true;    
            }else{                                              $data['conf_roles_id_es_1'] = false; }

            $data['oper'] = "editar_como_administrador";
            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('plantilla/menu');
            $this->load->view('conf_usuarios/v_conf_usuarios_frm', $data);
            $this->load->view('plantilla/footer');
        }else{
            $this->session->sess_destroy('username');
            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('login/v_login_1');
            $this->load->view('plantilla/footer');
        }
    }

    public function editar_guardar_como_administrador(){
        
            $valor = "id_usuario"; 	if ( isset($_POST[$valor]) 	){	$parametros[$valor] = $_POST[$valor];                   }else{	$parametros[$valor]	= "";	}
            $valor = "ci_usu";          if ( isset($_POST[$valor]) 	){	$parametros[$valor] = $_POST[$valor];                   }else{	$parametros[$valor]	= "";	}
            $valor = "nombre_usu"; 	if ( isset($_POST[$valor]) 	){	$parametros[$valor] = ucfirst( $_POST[$valor] );	}else{	$parametros[$valor]	= "";	}
            $valor = "apellido_usu"; 	if ( isset($_POST[$valor]) 	){	$parametros[$valor] = ucfirst( $_POST[$valor] );	}else{	$parametros[$valor]	= "";	}
            $valor = "direccion_usu"; 	if ( isset($_POST[$valor]) 	){	$parametros[$valor] = ucfirst( $_POST[$valor] );	}else{	$parametros[$valor]	= "";	}
            $valor = "telefono_1"; 	if ( isset($_POST[$valor]) 	){	$parametros[$valor] = $_POST[$valor];                   }else{	$parametros[$valor]	= "";	}
            $valor = "telefono_2"; 	if ( isset($_POST[$valor]) 	){	$parametros[$valor] = $_POST[$valor];                   }else{	$parametros[$valor]	= "";	}
            $valor = "correo";          if ( isset($_POST[$valor]) 	){	$parametros[$valor] = $_POST[$valor];                   }else{	$parametros[$valor]	= "";	}
            $valor = "usuario_usu"; 	if ( isset($_POST[$valor]) 	){	$parametros[$valor] = $_POST[$valor];                   }else{	$parametros[$valor]	= "";	}
            $valor = "rol_actualizar";  if ( isset($_POST[$valor]) 	){	$parametros[$valor] = $_POST[$valor];                   }else{	$parametros[$valor]	= "";	}
            $valor = "rol";             if ( isset($_POST[$valor]) 	){	$parametros[$valor] = $_POST[$valor];                   }else{	$parametros[$valor]	= "false";	}
            $valor = "estado";          if ( isset($_POST[$valor]) 	){	$parametros[$valor] = $_POST[$valor];                   }else{	$parametros[$valor]	= "";	}

            $parametros["ci_usu"]       = str_replace(".", "", $parametros["ci_usu"]);
            $parametros["nombre_usu"]   = $this->convierte_texto($parametros["nombre_usu"]);
            $parametros["apellido_usu"] = $this->convierte_texto($parametros["apellido_usu"]);
            
            $id_nucleo=$this->session->userdata('id_nucleo');
            
            //echo " <br />parametros[usuario_usu] *".$parametros["usuario_usu"]."*";
            
            //Valida reg existente
            $valido = false;
            $conf_usuarios_num_reg = $this->Conf_usuarios_model->conf_usuarios_num_reg_3($parametros['id_usuario'], $parametros['ci_usu']); //echo "conf_usuarios_num_reg *".$conf_usuarios_num_reg."*";
            if($conf_usuarios_num_reg == 0){ $valido = true; }
            else{
                    echo "<script language='javascript'>";
                    echo "alert('El registro no fue incluido, la cedula ya se encuentra en el sistema')";
                    echo "</script>";
                    echo "<script language='javascript'>";
                    ////echo "window.history.go(-1)";
                    echo "</script>";
            }
            //FIN de Valida reg existente

            if($valido == true){    
                $oper_realizada = $this->Conf_usuarios_model->conf_usuarios_editar($parametros['id_usuario'], $parametros['ci_usu'], $parametros['nombre_usu'], $parametros['apellido_usu'], $parametros['direccion_usu'], $parametros['telefono_1'], $parametros['telefono_2'], $parametros['correo'], $parametros['estado']);
                if ($oper_realizada){
                    //Actualiza los roles       -------------------------------------------------
                    if($parametros['rol_actualizar'] == true){
                        $this->Conf_roles_model->conf_usuarios_roles_eliminar($parametros['id_usuario']);
                        if($parametros['rol'] != "false"){
                            for($i = 0; $i < count($parametros['rol']); $i++){
                                $this->Conf_roles_model->conf_usuarios_roles_insertar($parametros['id_usuario'], $parametros['rol'][$i]);
                            }
                        }
                        
                        //Actualiza la ficha del rol asociado-----------
                            $num_encontrado = 0;
                            $rol_2_a_guardar = false;
                            $rol_3_a_guardar = false;
                            if($parametros['rol'] != "false"){
                                for($i = 0; $i < count($parametros['rol']); $i++){  //echo "<hr>parametros['rol'][i] *".$parametros['rol'][$i]."*";                                
                                    if( $parametros['rol'][$i] == 2){ $rol_2_a_guardar = true; }
                                    if( $parametros['rol'][$i] == 3){ $rol_3_a_guardar = true; }
                                }
                            } //echo "<br />rol_2_a_guardar *".$rol_2_a_guardar."*";
                        //Fin de Actualiza la ficha del rol asociado-----------
                    }
                    //Fin de actualiza los roles       -------------------------------------------
                    
                    //compruebo si tiene un registro asociado en "conf_usu_pass"
                    $conf_usu_pass_num_reg = $this->Conf_usu_pass_model->conf_usu_pass_buscar($parametros["id_usuario"]);
                    
                    $mensaje_2 = "Actualizó el usuario ".$this->calcula_datos_de_conf_usuarios($parametros["id_usuario"]);
                    
                    if($conf_usu_pass_num_reg == 0){
                            //AQUI INSERTO EL registro en conf_usu_pass
                            $fecha_hora = date("Y-m-d H:i:s");
                            $this->Conf_usu_pass_model->conf_usu_pass_insertar($parametros["id_usuario"], $parametros['usuario_usu'], "", $fecha_hora);
                            $mensaje = "Inserto el usuario con id ".$id_usuario;
                            $this->session->set_userdata($s_mensaje);
                            $this->insertar_bitacora_2("conf_usu_pass", $mensaje, $mensaje_2);                    
                            //Fin de AQUI INSERTO EL registro en conf_usu_pass                        
                    }else{
                            //AQUI Edito EL registro en conf_usu_pass
                            $this->Conf_usu_pass_model->conf_usuarios_editar($parametros["id_usuario"], $parametros["usuario_usu"]);
                            //FIN DE AQUI Edito EL registro en conf_usu_pass                        
                    }
                    $mensaje = "Actualizó el usuario con id ".$parametros['id_usuario'];
                    $s_mensaje = array(
                            'conf_usuarios_mensaje_tipo'         => 'alert-success',
                            'conf_usuarios_mensaje_contenido'    => 'Registros actualizado exitosamente, '.$mensaje_2
                    );
                    $this->session->set_userdata($s_mensaje);
                    $this->insertar_bitacora_2("conf_usuarios, conf_usu_pass, conf_usuarios_roles", $mensaje, $mensaje_2);                    
                        
                }
                //echo " *Conf_usuarios/editar_como_administrador/".$parametros['id_usuario']."*";
                redirect('Conf_usuarios/editar_como_administrador/'.$parametros['id_usuario']);
                
            }
    }
    
    public function ver($menu_origen){
        
        $matriz_conf_usuarios_roles = $this->Conf_roles_model->conf_usuarios_roles_buscar_2($this->session->userdata('iduser'), 1);
        if( $matriz_conf_usuarios_roles != false ){ $data['id_conf_roles_es_1'] = true;    }else{ $data['id_conf_roles_es_1'] = false; }
        $matriz_conf_usuarios_roles = $this->Conf_roles_model->conf_usuarios_roles_buscar_2($this->session->userdata('iduser'), 2);
        if( $matriz_conf_usuarios_roles != false ){ $data['id_conf_roles_es_2'] = true;    }else{ $data['id_conf_roles_es_2'] = false; }
        $matriz_conf_usuarios_roles = $this->Conf_roles_model->conf_usuarios_roles_buscar_2($this->session->userdata('iduser'), 3);
        if( $matriz_conf_usuarios_roles != false ){ $data['id_conf_roles_es_3'] = true;    }else{ $data['id_conf_roles_es_3'] = false; }
        $matriz_conf_usuarios_roles = $this->Conf_roles_model->conf_usuarios_roles_buscar_2($this->session->userdata('iduser'), 4);
        if( $matriz_conf_usuarios_roles != false ){ $data['id_conf_roles_es_4'] = true;    }else{ $data['id_conf_roles_es_4'] = false; }
        $matriz_conf_usuarios_roles = $this->Conf_roles_model->conf_usuarios_roles_buscar_2($this->session->userdata('iduser'), 5);
        if( $matriz_conf_usuarios_roles != false ){ $data['id_conf_roles_es_5'] = true;    }else{ $data['id_conf_roles_es_5'] = false; }
        
        $matriz_conf_configuracion = $this->Conf_configuracion_model->conf_configuracion_buscar_2();
        $nombre_de_archivo_login = $matriz_conf_configuracion['nombre_de_archivo_login'];        
        
        $logged = $this->Conf_usuarios_model->isLogged();
        if($logged == true){
            
            $data['menu_origen'] = $menu_origen;
            
            $id = $this->session->userdata('iduser');
            
            $fila_reg = $this->Conf_usuarios_model->conf_usuarios_buscar_2($id);   //echo "<pre>"; print_r($fila_reg); echo "</pre>";
            $data['conf_usuarios'] = $fila_reg[0];

            $matriz_conf_roles = $this->Conf_roles_model->conf_roles_buscar_3();
            $data['matriz_conf_roles'] = $matriz_conf_roles;
            
            $matriz_conf_usuarios_roles = $this->Conf_roles_model->conf_usuarios_roles_buscar($id); //echo "<pre>matriz_conf_usuarios_roles *"; print_r($matriz_conf_usuarios_roles); echo "*</pre>";
            $data['matriz_conf_usuarios_roles'] = $matriz_conf_usuarios_roles;
            
            $fila_reg = $this->Conf_usu_pass_model->conf_usu_pass_buscar($id);   //echo "<pre>"; print_r($fila_reg); echo "</pre>";
            $data['conf_usu_pass'] = $fila_reg[0];
            
            $matriz_conf_usuarios_roles = $this->Conf_roles_model->conf_usuarios_roles_buscar_2($this->session->userdata('iduser'), 1);   //echo "<pre>matriz_conf_usuarios_roles *"; print_r($matriz_conf_usuarios_roles); echo "*</pre>";
            if( $matriz_conf_usuarios_roles != false ){    $data['conf_roles_id_es_1'] = true;    
            }else{                                              $data['conf_roles_id_es_1'] = false; }

            //Busco el estado del estudiante, para enviar mensaje en labarra de menu
            $usuario_mensaje = "";      $usuario_mensaje_color = "";
            $id_usuario=$this->session->userdata('iduser');
            $data['id_usuario'] = $id_usuario;
            $matriz_estudiante_ficha_estatus = $this->Estudiante_ficha_estatus_model->estudiante_ficha_estatus_buscar_4($id_usuario);
            if($matriz_estudiante_ficha_estatus != false){
                $estudiante_ficha_estatus_id        = $matriz_estudiante_ficha_estatus[0]->estudiante_ficha_estatus_id;
                $estudiante_ficha_estatus_nombre    = $matriz_estudiante_ficha_estatus[0]->estudiante_ficha_estatus_nombre;
                switch ($estudiante_ficha_estatus_id){
                    case 1:     $usuario_mensaje_color = "text-success";    break;
                    case 2:     $usuario_mensaje_color = "text-warning";    break;
                    case 3:     $usuario_mensaje_color = "text-danger";     break;
                    case 4:     $usuario_mensaje_color = "text-warning";    break;
                    case 5:     $usuario_mensaje_color = "text-warning";    break;
                }            
                $usuario_mensaje = "Estudiante ".$estudiante_ficha_estatus_nombre;
            }
            $data['usuario_mensaje'] = $usuario_mensaje;
            $data['usuario_mensaje_color'] = $usuario_mensaje_color;
            //Fin de Busco el estado del estudiante, para enviar mensaje en labarra de menu            
            
            $data['oper'] = "ver";
            $data['matriz_conf_configuracion'] = $this->Conf_configuracion_model->conf_configuracion_buscar_2();
            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('plantilla/menu');
            $this->load->view('conf_usuarios/v_conf_usuarios_frm', $data);
            $this->load->view('plantilla/footer');
        }else{
            $this->session->sess_destroy('username');
            $data['matriz_conf_configuracion'] = $this->Conf_configuracion_model->conf_configuracion_buscar_2();
            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('login/v_login_1');
            $this->load->view('plantilla/footer');
        }
    }    

    public function eliminar($id){
        $logged = $this->Conf_usuarios_model->isLogged();
        $id_conf_roles_es_1 = $this->session->userdata('id_conf_roles_es_1');
        if($logged == TRUE && $id_conf_roles_es_1 == true){
           
            //Valida registro relacionado
            $valido = true;
            $num_rows = $this->Conf_bitacora_model->Conf_bitacora_num_reg_2($id);
            if($num_rows > 0){
                $valido = false;
                $mensaje = "Error al eliminar, el usuario con id ".$id." ya a tenido movimientos de ingreso al sistema";
                $mensaje_2 = "Error al eliminar, el usuario ".$this->calcula_datos_de_conf_usuarios($id)." ya a tenido movimientos de ingreso al sistema";
                $s_mensaje = array(
                        'conf_usuarios_mensaje_tipo'         => 'alert-danger',
                        'conf_usuarios_mensaje_contenido'    => 'El registro no fue eliminado, '.$mensaje_2
                );
                $this->session->set_userdata($s_mensaje);
                $this->insertar_bitacora_2("conf_usuarios", $mensaje, $mensaje_2);                    
            }
            //Fin de valida registro relacionado
            if( $valido == true ){
                
                $this->Conf_roles_model->conf_usuarios_roles_eliminar($id);
                
                $mensaje_2 = "Eliminó el usuario ".$this->calcula_datos_de_conf_usuarios($id);
                
                $oper_realizada = $this->Conf_usuarios_model->conf_usuarios_eliminar($id);
                if ($oper_realizada){
                        $mensaje = "Eliminó el usuario con id ".$id;
                        $s_mensaje = array(
                                'conf_usuarios_mensaje_tipo'         => 'alert-success',
                                'conf_usuarios_mensaje_contenido'    => 'Registros eliminado exitosamente, '.$mensaje_2
                        );
                        $this->session->set_userdata($s_mensaje);
                        $this->insertar_bitacora_2("conf_usuarios", $mensaje, $mensaje_2);
                }                
            }            
            redirect('Conf_usuarios/listar');
        }else{
            $this->session->sess_destroy('username');
            $data['matriz_conf_configuracion'] = $this->Conf_configuracion_model->conf_configuracion_buscar_2();
            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('login/v_login_1');
            $this->load->view('plantilla/footer');
        }            
    }
    
    public function deshabilitar($id){
        $logged = $this->Conf_usuarios_model->isLogged();
        $id_conf_roles_es_1 = $this->session->userdata('id_conf_roles_es_1');
        if($logged == TRUE && $id_conf_roles_es_1 == true){
            $oper_realizada = $this->Conf_usuarios_model->conf_usuarios_deshabilitar($id);
            if ($oper_realizada){
                    $mensaje = "Deshabilito el usuario con id ".$id;
                    $mensaje_2 = "Deshabilito el usuario ".$this->calcula_datos_de_conf_usuarios($id);
                    $s_mensaje = array(
                            'conf_usuarios_mensaje_tipo'         => 'alert-success',
                            'conf_usuarios_mensaje_contenido'    => 'Registros deshabilitado exitosamente, '.$mensaje_2
                    );
                    $this->session->set_userdata($s_mensaje);
                    $this->insertar_bitacora_2("conf_usuarios", $mensaje, $mensaje_2);
            }
            redirect('Conf_usuarios/listar');
        }else{
            $this->session->sess_destroy('username');
            $data['matriz_conf_configuracion'] = $this->Conf_configuracion_model->conf_configuracion_buscar_2();
            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('login/v_login_1');
            $this->load->view('plantilla/footer');
        }            
    } 
    
    //convierte en mayuscula la primera letra de cada palabra, y coloca el resto en minuscula
    public function convierte_texto($texto){
        $pieces = explode(" ", $texto);
        $texto = "";
        for($i = 0; $i < count($pieces); $i++){
            $pieces[$i] = strtolower($pieces[$i]);
            $pieces[$i] = ucwords($pieces[$i]);
            if($i > 0){ $texto .= " "; }
            $texto .= $pieces[$i];
        }
        return $texto;
    }
    
    private function calcula_datos_de_conf_usuarios($id_usuario){
        $matriz_conf_usuarios = $this->Conf_usuarios_model->conf_usuarios_buscar_2($id_usuario);

        $texto = "(".$matriz_conf_usuarios[0]->ci_usu.") ".$matriz_conf_usuarios[0]->nombre_usu." ".$matriz_conf_usuarios[0]->apellido_usu;

        return $texto;
    }
    
    public function get_conf_usuarios_buscar_4(){
            $correo         = $this->input->post('correo');
            $resultados     = $this->Conf_usuarios_model->conf_usuarios_buscar_4($correo); //echo "resultados *"; print_r($resultados); echo "*";
            echo json_encode($resultados);
    }
    
    public function get_conf_usuarios_buscar_5(){
            $correo         = $this->input->post('correo');
            $id_usuario     = $this->input->post('id_usuario');
            $resultados     = $this->Conf_usuarios_model->conf_usuarios_buscar_5($correo, $id_usuario); //echo "resultados *"; print_r($resultados); echo "*";
            echo json_encode($resultados);
    }
    
    public function get_subir_archivo(){
            $id_usuario     = $this->input->post('id_usuario');
            $matriz_conf_usuarios = $this->Conf_usuarios_model->conf_usuarios_buscar_2($id_usuario);
            $imagen_nombre = $matriz_conf_usuarios[0]->imagen_nombre;            
            if($imagen_nombre != ""){
                $ruta = "images/conf_usuario/".$imagen_nombre;                
                unlink($ruta);
            }
            
            $extension = pathinfo($_FILES['archivo']['name'], PATHINFO_EXTENSION);
            $imagen_nombre = time()."_".$id_usuario.".".$extension;
            $ruta = "images/conf_usuario/".$imagen_nombre;   //echo "<br /> RUTA *".$ruta."*";
            $archivo_cargado = move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta);
            if($archivo_cargado){       //echo json_encode("PASO 1");
                $this->Conf_usuarios_model->conf_usuarios_editar_2($id_usuario, $imagen_nombre);
                $mensaje = "Actualizó la imagen del usuario con id_usuario ".$id_usuario.", con el nombre de imagen ".$imagen_nombre;
                $mensaje_2 = "Actualizó la imagen del usuario con id_usuario ".$this->calcula_datos_de_conf_usuarios($id_usuario).", con el nombre de imagen ".$imagen_nombre;
                $this->insertar_bitacora_2("conf_usuarios", $mensaje, $mensaje_2);
                $valido = 1;
            }else{      //echo json_encode("PASO 2");
                $valido = 0;
            }
            echo json_encode($valido);
    }
    public function get_eliminar_archivo(){
            $id_usuario     = $this->input->post('id_usuario');
            $matriz_conf_usuarios = $this->Conf_usuarios_model->conf_usuarios_buscar_2($id_usuario);
            
            $imagen_nombre = $matriz_conf_usuarios[0]->imagen_nombre;
            $ruta = "images/conf_usuario/".$imagen_nombre;   //echo json_encode($ruta);            
            $eliminado = "";
            $eliminado = unlink($ruta);
            if($eliminado == true){
                $this->Conf_usuarios_model->conf_usuarios_editar_2($id_usuario, "");
                $mensaje = "Eliminó la imagen del usuario con id_usuario ".$id_usuario.", con el nombre de imagen ".$imagen_nombre;
                $mensaje_2 = "Eliminó la imagen del usuario con id_usuario ".$this->calcula_datos_de_conf_usuarios($id_usuario).", con el nombre de imagen ".$imagen_nombre;
                $this->insertar_bitacora_2("conf_usuarios", $mensaje, $mensaje_2);
                $valido = 1;
            }else{
                $valido = 0;
            }
            echo json_encode($valido);
    }
    
    public function get_conf_usuarios_buscar_2(){
            $id_usuario     = $this->input->post('id_usuario');
            $matriz_conf_usuarios = $this->Conf_usuarios_model->conf_usuarios_buscar_2($id_usuario);
            echo json_encode($matriz_conf_usuarios);
    }   

    public function get_conf_usuarios_buscar_6(){
            $ci_usu     = $this->input->post('ci_usu');
            $matriz_conf_usuarios = $this->Conf_usuarios_model->conf_usuarios_buscar_6($ci_usu);
            echo json_encode($matriz_conf_usuarios);
    } 
}