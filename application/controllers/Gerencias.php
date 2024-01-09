<?php
require_once APPPATH.'controllers/Controlador_padre.php';
class Gerencias extends Controlador_padre {
    
    function __construct(){
        parent::__construct();
        $this->load->library('Session');
        $this->load->model('Conf_bitacora_model');
        $this->load->model('Conf_usuarios_model');
        $this->load->model('Gerencias_model');
        $this->load->model('Personal_ivic_model');
        $this->load->model('Gerencias_2_model');
    }

    public function listar($memoria = 'false'){
        $logged = $this->Conf_usuarios_model->isLogged();
        $id_conf_roles_es_2 = $this->session->userdata('id_conf_roles_es_2');
        if($logged == TRUE && $id_conf_roles_es_2 == true){ 

                if($memoria == 'limpiar'){
                    $this->session->unset_userdata('gerencias_b_texto');
                }
                
                if (	isset ($_POST['b_texto'])	){
                        $b_texto = $_POST['b_texto'];
                        $s_busquedad = array(
                                'gerencias_b_texto' => $b_texto
                        );
                        $this->session->set_userdata($s_busquedad);
                }else{
                        $b_texto = "";
                        if( strlen($this->session->userdata('gerencias_b_texto')) > 0  ){
                            $b_texto = $this->session->userdata('gerencias_b_texto');
                        }
                }
                $b_texto = str_replace("'", "", $b_texto);
                
                if($memoria == 'cargo_ultima_pagina'){
                        $pagina_actual = $this->session->userdata('gerencias_ultima_pagina');    
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
                            'gerencias_ultima_pagina' => $pagina_actual
                        );
                        $this->session->set_userdata($s_lista);                    
                        $segmento = $this->uri->segment(4);                    
                }

                $this->load->helper('form');
                $this->load->library('pagination');
                $pages = 8; //Número de registros mostrados por páginas
                $config['base_url'] = base_url().'index.php/gerencias/listar/pagina'; // parametro base de la aplicación, si tenemos un .htaccess nos evitamos el index.php
                $total_rows = $this->Gerencias_model->gerencias_num_reg($b_texto);
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
                $dat_list = $this->Gerencias_model->gerencias_buscar($b_texto, $config['per_page'],$segmento);
                //echo "<br>dat_list *<pre>"; print_r($dat_list); echo "</pre>*";                
                //[0] => stdClass Object
                //    (
                //        [gerencias_id] => 60
                //        [gerencias_nombre] => UNIDAD DE TECNOLOGIA NUCLEAR (U.T.N.)
                //        [gerencias_2_nombre] => SUB-DIRECCIÓN
                //    )
                
                if($dat_list != false){
                    for($i = 0; $i < count($dat_list); $i++){
                        $gerencias_id = $dat_list[$i]->gerencias_id;  //echo "gerencias_id *".$gerencias_id."*";
                        unset($matriz_comensales);                        
                        //$matriz_personal_ivic = $this->Personal_ivic_model->personal_ivic_buscar_9($gerencias_id);
                        $matriz_personal_ivic = $this->Personal_ivic_model->personal_ivic_buscar_10($gerencias_id);
                        if($matriz_personal_ivic == false){
                            $dat_list[$i]->esta_asociado_en_personal_ivic = false;
                        }else{
                            $dat_list[$i]->esta_asociado_en_personal_ivic = true;
                        }
                        
                        //$matriz_gerencias_2 = $this->Gerencias_2_model->gerencias_2_buscar_2($dat_list[$i]->id_gerencia_2);
                        //$dat_list[$i]->gerencias_2_nombre = $matriz_gerencias_2[0]->nombre;
                    }                    
                } 
                //echo "<br>dat_list *<pre>"; print_r($dat_list); echo "</pre>*";
                //[0] => stdClass Object
                //    (
                //        [id] => 60
                //        [id_gerencia_2] => 5
                //        [nombre] => UNIDAD DE TECNOLOGIA NUCLEAR (U.T.N.)
                //        [esta_asociado_en_personal_ivic] => 1
                //        [gerencias_2_nombre] => SUB-DIRECCIÓN
                //    )                
                
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
                $this->load->view('gerencias/v_gerencias_listar', $dat_list);
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
        $id_conf_roles_es_2 = $this->session->userdata('id_conf_roles_es_2');
        if($logged == TRUE && $id_conf_roles_es_2 == true){
            $data['oper'] = "agregar";
            
            $matriz_gerencias_2 = $this->Gerencias_2_model->gerencias_2_buscar_3();
            $data['matriz_gerencias_2'] = $matriz_gerencias_2;             
            
            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('plantilla/menu');
            $this->load->view('gerencias/v_gerencias_frm', $data);
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
            $valor = "id_gerencia_2";  if ( isset($_POST[$valor])              ){	$id_gerencia_2 = $_POST[$valor];       }else{	$id_gerencia_2	= "";	}            
            
            echo "id_gerencia_2 *".$id_gerencia_2."*";
            
            $nombre        = $this->convierte_texto($nombre);

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
                    //$id = $this->Gerencias_model->gerencias_insertar($nombre);
                    $id = $this->Gerencias_model->gerencias_insertar($id_gerencia_2, $nombre);
                    if ($id > 0){
                        $mensaje = "Inserto el gerencias con id ".$id;
                        $mensaje_2 = "Inserto el gerencias ".$nombre;
                        $s_mensaje = array(
                                'gerencias_mensaje_tipo'         => 'alert-success',
                                'gerencias_mensaje_contenido'    => 'Registros insertado exitosamente, '.$mensaje_2
                        );
                        $this->session->set_userdata($s_mensaje);
                        $this->insertar_bitacora_2("gerencias", $mensaje, $mensaje_2);
                        redirect('gerencias/listar/cargo_ultima_pagina');
                    }else{
                        redirect('gerencias/agregar');
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
        $id_conf_roles_es_2 = $this->session->userdata('id_conf_roles_es_2');
        if($logged == TRUE && $id_conf_roles_es_2 == true){

            $matriz_gerencias_2 = $this->Gerencias_2_model->gerencias_2_buscar_3();
            $data['matriz_gerencias_2'] = $matriz_gerencias_2; 
            
            $fila_reg = $this->Gerencias_model->gerencias_buscar_2($id);   //echo "<pre>"; print_r($fila_reg); echo "</pre>";
            $data['fila_registro'] = $fila_reg[0]; 
            $data['oper'] = "editar";

            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('plantilla/menu');
            $this->load->view('gerencias/v_gerencias_frm', $data);
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
            $valor = "nombre";          if ( isset($_POST[$valor])      ){	$nombre = ucfirst( $_POST[$valor] );	}else{	$nombre	= "";	}
            $valor = "id_gerencia_2";  if ( isset($_POST[$valor])              ){	$id_gerencia_2 = $_POST[$valor];       }else{	$id_gerencia_2	= "";	}            

            $nombre        = $this->convierte_texto($nombre);
            
            $valido = true;
            if($valido == true){
                $oper_realizada = $this->Gerencias_model->gerencias_editar($id, $id_gerencia_2, $nombre);
                //echo "oper_realizada *".$oper_realizada."*";
                if ($oper_realizada){
                    $mensaje = "Actualizó el gerencias con id ".$id;
                    $mensaje_2 = "Actualizó el gerencias ".$nombre;
                    $s_mensaje = array(
                            'gerencias_mensaje_tipo'  => 'alert-success',
                            'gerencias_mensaje_contenido'    => 'Registros actualizado exitosamente, '.$mensaje_2
                    );
                    $this->session->set_userdata($s_mensaje);
                    $this->insertar_bitacora_2("gerencias", $mensaje, $mensaje_2);

                    redirect('gerencias/listar/cargo_ultima_pagina');
                }else{
                    redirect('gerencias/editar');
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
            $id_conf_roles_es_2 = $this->session->userdata('id_conf_roles_es_2');
            if($logged == TRUE && $id_conf_roles_es_2 == true){
                
                $matriz_gerencias = $this->Gerencias_model->gerencias_buscar_2($id);
                $gerencias_nombre = $matriz_gerencias[0]->nombres;
                
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
                    $oper_realizada = $this->Gerencias_model->gerencias_eliminar($id);
                    if ($oper_realizada){
                            $mensaje = "Eliminó el gerencias con id ".$id;
                            $mensaje_2 = "Eliminó el gerencias ".$gerencias_nombre;
                            $s_mensaje = array(
                                    'gerencias_mensaje_tipo'         => 'alert-success',
                                    'gerencias_mensaje_contenido'    => 'Registros eliminado exitosamente, '.$mensaje_2
                            );
                            $this->session->set_userdata($s_mensaje);
                            $this->insertar_bitacora_2("gerencias", $mensaje, $mensaje_2);
                    }                
                }
                redirect('gerencias/listar/cargo_ultima_pagina');                
            }else{
                redirect('Login/v_login_mensaje_1');
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
    
    public function get_gerencias_buscar_5(){
            $nombre     = $this->input->post('nombre');
            $id         = $this->input->post('id');
            $resultados     = $this->Gerencias_model->gerencias_buscar_5($nombre, $id); //echo "resultados *"; print_r($resultados); echo "*";
            echo json_encode($resultados);
    }

    public function get_gerencias_buscar_6(){
            $nombre     = $this->input->post('nombre');
            $resultados = $this->Gerencias_model->gerencias_buscar_6($nombre); //echo "resultados *"; print_r($resultados); echo "*";
            echo json_encode($resultados);
    }

    public function get_gerencias_buscar_7(){
            $id_gerencia_2     = $this->input->post('id_gerencia_2');
            $resultados = $this->Gerencias_model->gerencias_buscar_7($id_gerencia_2); //echo "resultados *"; print_r($resultados); echo "*";
            echo json_encode($resultados);
    }    

}
