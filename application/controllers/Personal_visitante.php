<?php
require_once APPPATH.'controllers/Controlador_padre.php';
class Personal_visitante extends Controlador_padre {
    
    function __construct(){
        parent::__construct();
        $this->load->library('Session');
        $this->load->model('Conf_bitacora_model');
        $this->load->model('Conf_usuarios_model');
        $this->load->model('Personal_visitante_model');
        $this->load->model('Comensal_model');
        $this->load->model('Personal_visitante_tipo_model');
    }

    public function listar($memoria = 'false'){
        $logged = $this->Conf_usuarios_model->isLogged();
        $id_conf_roles_es_2 = $this->session->userdata('id_conf_roles_es_2');
        $id_conf_roles_es_3 = $this->session->userdata('id_conf_roles_es_3');
        if($logged == TRUE && ($id_conf_roles_es_2 == true || $id_conf_roles_es_3 == true)   ){ 

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
                
                if (	isset ($_POST['b_estado'])	){
                        $b_estado = $_POST['b_estado'];
                        $s_busquedad = array(
                                'personal_b_estado' => $b_estado
                        );
                        $this->session->set_userdata($s_busquedad);
                }else{
                        $b_estado = "";
                        if( strlen($this->session->userdata('personal_b_estado')) > 0  ){
                            $b_estado = $this->session->userdata('personal_b_estado');
                        }
                } 
                
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
                $config['base_url'] = base_url().'index.php/personal_visitante/listar/pagina'; // parametro base de la aplicación, si tenemos un .htaccess nos evitamos el index.php
                $total_rows = $this->Personal_visitante_model->personal_visitante_num_reg($b_texto, $b_estado);
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
                $dat_list = $this->Personal_visitante_model->personal_visitante_buscar($b_texto, $b_estado, $config['per_page'],$segmento);
//echo "<br>dat_list *<pre>"; print_r($dat_list); echo "</pre>*";                
                
                if($dat_list != false){
                    for($i = 0; $i < count($dat_list); $i++){
                        $personal_visitante_id = $dat_list[$i]->id;  //echo "personal_visitante_id *".$personal_visitante_id."*";
                        unset($matriz_comensales);                        
                        $matriz_comensales = $this->Comensal_model->comensales_buscar_11($personal_visitante_id);
                        if($matriz_comensales == false){
                            $dat_list[$i]->tiene_movimiento_en_comensales = false;
                        }else{
                            $dat_list[$i]->tiene_movimiento_en_comensales = true;
                        }
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
                $dat_list['b_estado']  = $b_estado;
                
                
                //$data['matriz_conf_configuracion'] = $this->Conf_configuracion_model->conf_configuracion_buscar_2();
                $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
                $this->load->view('plantilla/header', $data);
                $this->load->view('plantilla/menu');
                $this->load->view('personal_visitante/v_personal_visitante_listar', $dat_list);
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
        $id_conf_roles_es_3 = $this->session->userdata('id_conf_roles_es_3');
        if($logged == TRUE && ($id_conf_roles_es_2 == true || $id_conf_roles_es_3 == true)   ){ 
            
            $matriz_personal_visitante_tipo                 = $this->Personal_visitante_tipo_model->personal_visitante_tipo_buscar_3();
            $data['matriz_personal_visitante_tipo']         = $matriz_personal_visitante_tipo;            
            
            $data['oper'] = "agregar";
            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('plantilla/menu');
            $this->load->view('personal_visitante/v_personal_visitante_frm', $data);
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
            $valor = "cedula";                      if ( isset($_POST[$valor]) 	){	$cedula = $_POST[$valor];                       }else{	$cedula	= "";	}
            $valor = "nombres";                     if ( isset($_POST[$valor]) 	){	$nombres = ucfirst( $_POST[$valor] );           }else{	$nombres	= "";	}
            $valor = "apellidos";                   if ( isset($_POST[$valor]) 	){	$apellidos = ucfirst( $_POST[$valor] );         }else{	$apellidos	= "";	}
            $valor = "estado";                      if ( isset($_POST[$valor]) 	){	$estado = $_POST[$valor];                       }else{	$estado	= "";	}
            $valor = "id_personal_visitante_tipo";  if ( isset($_POST[$valor]) 	){	$id_personal_visitante_tipo = $_POST[$valor];   }else{	$id_personal_visitante_tipo	= "";	}            
            
            $cedula         = str_replace(".", "", $cedula);
            $nombres        = $this->convierte_texto($nombres);
            $apellidos      = $this->convierte_texto($apellidos);            

            ////Valida reg existente
            //$valido = false;
            //$personal_visitante_num_reg = $this->Personal_visitante_model->personal_visitante_num_reg_2($parametros['nombre']); //echo "cli_clientes_num_reg *".$personal_visitante_num_reg."*";
            //if($personal_visitante_num_reg == 0){ $valido = true; }
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
                    $id = $this->Personal_visitante_model->personal_visitante_insertar($cedula, $nombres, $apellidos, $estado, $id_personal_visitante_tipo);
                    if ($id > 0){
                        $mensaje = "Inserto el personal visitante con id ".$id;
                        $mensaje_2 = "Inserto el personal visitante ".$nombres;
                        $s_mensaje = array(
                                'personal_visitante_mensaje_tipo'         => 'alert-success',
                                'personal_visitante_mensaje_contenido'    => 'Registros insertado exitosamente, '.$mensaje_2
                        );
                        $this->session->set_userdata($s_mensaje);
                        $this->insertar_bitacora_2("personal_visitante", $mensaje, $mensaje_2);
                        redirect('personal_visitante/listar/cargo_ultima_pagina');
                    }else{
                        redirect('personal_visitante/agregar');
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
        $id_conf_roles_es_3 = $this->session->userdata('id_conf_roles_es_3');
        if($logged == TRUE && ($id_conf_roles_es_2 == true || $id_conf_roles_es_3 == true)   ){ 

            $matriz_personal_visitante_tipo                 = $this->Personal_visitante_tipo_model->personal_visitante_tipo_buscar_3();
            $data['matriz_personal_visitante_tipo']         = $matriz_personal_visitante_tipo;
            
            $fila_reg = $this->Personal_visitante_model->personal_visitante_buscar_2($id);   //echo "<pre>"; print_r($fila_reg); echo "</pre>";
            $data['fila_personal'] = $fila_reg[0];
            $data['oper'] = "editar";

            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('plantilla/menu');
            $this->load->view('personal_visitante/v_personal_visitante_frm', $data);
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
            $valor = "id";                          if ( isset($_POST[$valor]) 	){	$id = $_POST[$valor];                           }else{	$id	= "";	}
            $valor = "cedula";                      if ( isset($_POST[$valor]) 	){	$cedula = $_POST[$valor];                       }else{	$cedula	= "";	}
            $valor = "nombres";                     if ( isset($_POST[$valor]) 	){	$nombres = ucfirst( $_POST[$valor] );           }else{	$nombres	= "";	}
            $valor = "apellidos";                   if ( isset($_POST[$valor]) 	){	$apellidos = ucfirst( $_POST[$valor] );         }else{	$apellidos	= "";	}
            $valor = "estado";                      if ( isset($_POST[$valor]) 	){	$estado = $_POST[$valor];                       }else{	$estado	= "";	}
            $valor = "id_personal_visitante_tipo";  if ( isset($_POST[$valor]) 	){	$id_personal_visitante_tipo = $_POST[$valor];   }else{	$id_personal_visitante_tipo	= "";	}
            
            $cedula         = str_replace(".", "", $cedula);
            $nombres        = $this->convierte_texto($nombres);
            $apellidos      = $this->convierte_texto($apellidos);            
            
            $valido = true;
            if($valido == true){
                $oper_realizada = $this->Personal_visitante_model->personal_visitante_editar($id, $nombres, $apellidos, $estado, $id_personal_visitante_tipo);
                //echo "oper_realizada *".$oper_realizada."*";
                if ($oper_realizada){
                    $mensaje = "Actualizó el personal visitante con id ".$id;
                    $mensaje_2 = "Actualizó el Personal visitante ".$nombres;
                    $s_mensaje = array(
                            'personal_visitante_mensaje_tipo'  => 'alert-success',
                            'personal_visitante_mensaje_contenido'    => 'Registros actualizado exitosamente, '.$mensaje_2
                    );
                    $this->session->set_userdata($s_mensaje);
                    $this->insertar_bitacora_2("personal_visitante", $mensaje, $mensaje_2);

                    redirect('personal_visitante/listar/cargo_ultima_pagina');
                }else{
                    redirect('personal_visitante/editar');
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
            $id_conf_roles_es_3 = $this->session->userdata('id_conf_roles_es_3');
            if($logged == TRUE && ($id_conf_roles_es_2 == true || $id_conf_roles_es_3 == true)   ){ 
                
                $matriz_personal_visitante = $this->Personal_visitante_model->personal_visitante_buscar_2($id);
                $personal_visitante_nombre = $matriz_personal_visitante[0]->nombres;
                
                $imagen_nombre = $matriz_personal_visitante[0]->imagen_nombre;            
                
                
                //Valida registro relacionado
                $valido = true;
                
                //$num_rows = $this->Pensum_model->pensum_num_reg_4($id);
                //if($num_rows > 0){
                //    $valido = false;
                //    $mensaje = "Error al eliminar, la Carrera con id ".$id." se encuentra asociado con un Pensum";
                //    $mensaje_2 = "Error al eliminar, la Carrera ".$personal_visitante_nombre." se encuentra asociado con un Pensum";
                //    $s_mensaje = array(
                //            'personal_visitante_mensaje_tipo'         => 'alert-danger',
                //            'personal_visitante_mensaje_contenido'    => 'El registro no fue eliminado, '.$mensaje_2
                //    );
                //    $this->session->set_userdata($s_mensaje);
                //    $this->insertar_bitacora_2("personal_visitante", $mensaje, $mensaje_2);                    
                //}
                //Fin de valida registro relacionado
                if( $valido == true ){
                    $oper_realizada = $this->Personal_visitante_model->personal_visitante_eliminar($id);
                    if ($oper_realizada){
                        
                            if($imagen_nombre != ""){
                                $ruta = "images/personal_visitante/".$imagen_nombre;                
                                if(file_exists($ruta) == true){
                                    unlink($ruta);    
                                }
                            }                        
                        
                            $mensaje = "Eliminó el personal visitante con id ".$id;
                            $mensaje_2 = "Eliminó el personal visitante ".$personal_visitante_nombre;
                            $s_mensaje = array(
                                    'personal_visitante_mensaje_tipo'         => 'alert-success',
                                    'personal_visitante_mensaje_contenido'    => 'Registros eliminado exitosamente, '.$mensaje_2
                            );
                            $this->session->set_userdata($s_mensaje);
                            $this->insertar_bitacora_2("personal_visitante", $mensaje, $mensaje_2);
                    }                
                }
                redirect('personal_visitante/listar/cargo_ultima_pagina');                
            }else{
                redirect('Login/v_login_mensaje_1');
            }
    }

    public function ver_pdf_lista($b_texto, $b_estado){
        $logged = $this->Conf_usuarios_model->isLogged();
        if($logged == TRUE){
            
            if($b_estado == "NULL"){         $b_estado = "";          }
            $data['b_estado'] = $b_estado;            
            
            if($b_texto == "NULL"){         $b_texto = "";          }
            $b_texto = str_replace("'", "", $b_texto);
            $b_texto_2 = preg_replace('/^0+/', '', $b_texto); //QUITO LOS CEROS A LA IZQUIERDA
            $b_texto = str_replace("%20", " ", $b_texto); //LE QUITO EL FORMATO DE LOS ESPACIOS ENTRE PALABRAS
            $data['b_texto'] = $b_texto;

            $estado_1 = "";
            if($b_estado > 0){
                if($b_estado == 1){
                    $estado_1 = "Activo";
                }
                if($b_estado == 2){
                    $estado_1 = "No Activo";
                }                
            }
            $data['estado_1'] = $estado_1;
            $matriz_personal_visitante = $this->Personal_visitante_model->personal_visitante_buscar($b_texto, $b_estado, "", ""); 
            //echo "<br>matriz_personal_visitante *<pre>"; print_r($matriz_personal_visitante); echo "</pre>*";

            $data['matriz_personal_visitante'] = $matriz_personal_visitante;

            //CARGO EL ESTADO NOMBRE --------------------------------------------
            if($matriz_personal_visitante != false){
                for($i = 0; $i < count($matriz_personal_visitante); $i++){

                    $estado_nombre = "";
                    switch ($matriz_personal_visitante[$i]->estado) {
                        case 1:     $estado_nombre = "Activo";      break;
                        case 2:     $estado_nombre = "No Activo";    break;
                    }
                    $matriz_personal_visitante[$i]->estado_nombre = $estado_nombre;            
                }
            }
            //FIN DE CARGO EL ESTADO NOMBRE --------------------------------------------
            //echo "<br>matriz_personal_visitante *<pre>"; print_r($matriz_personal_visitante); echo "</pre>*";
            //[0] => stdClass Object
            //    (
            //        [id] => 47
            //        [cedula] => 17743635
            //        [nombres] => Jhoana 
            //        [apellidos] => Echeverria
            //        [imagen_nombre] => 
            //        [estado] => 1
            //        [id_personal_visitante_tipo] => 4
            //        [estado_nombre] => Activo
            //    )           
            
            
            $this->load->view('personal_visitante/reporte_pdf_lista', $data);
 
        }        
    }    
    
    public function ver_excel_lista($b_texto, $b_estado){
        $logged = $this->Conf_usuarios_model->isLogged();
        if($logged == TRUE){

            if($b_estado == "NULL"){         $b_estado = "";          }
            $data['b_estado'] = $b_estado;            
            
            if($b_texto == "NULL"){         $b_texto = "";          }
            $b_texto = str_replace("'", "", $b_texto);
            $b_texto_2 = preg_replace('/^0+/', '', $b_texto); //QUITO LOS CEROS A LA IZQUIERDA
            $b_texto = str_replace("%20", " ", $b_texto); //LE QUITO EL FORMATO DE LOS ESPACIOS ENTRE PALABRAS
            $data['b_texto'] = $b_texto;

            $estado_1 = "";
            if($b_estado > 0){
                if($b_estado == 1){
                    $estado_1 = "Activo";
                }
                if($b_estado == 2){
                    $estado_1 = "No Activo";
                }                
            }
            $data['estado_1'] = $estado_1;
            $matriz_personal_visitante = $this->Personal_visitante_model->personal_visitante_buscar($b_texto, $b_estado, "", ""); 
            //echo "<br>matriz_personal_visitante *<pre>"; print_r($matriz_personal_visitante); echo "</pre>*";

            $data['matriz_personal_visitante'] = $matriz_personal_visitante;

            //CARGO EL ESTADO NOMBRE --------------------------------------------
            if($matriz_personal_visitante != false){
                for($i = 0; $i < count($matriz_personal_visitante); $i++){

                    $estado_nombre = "";
                    switch ($matriz_personal_visitante[$i]->estado) {
                        case 1:     $estado_nombre = "Activo";      break;
                        case 2:     $estado_nombre = "No Activo";    break;
                    }
                    $matriz_personal_visitante[$i]->estado_nombre = $estado_nombre;            
                }
            }
            //FIN DE CARGO EL ESTADO NOMBRE --------------------------------------------
            //echo "<br>matriz_personal_visitante *<pre>"; print_r($matriz_personal_visitante); echo "</pre>*";
            //[0] => stdClass Object
            //    (
            //        [id] => 47
            //        [cedula] => 17743635
            //        [nombres] => Jhoana 
            //        [apellidos] => Echeverria
            //        [imagen_nombre] => 
            //        [estado] => 1
            //        [id_personal_visitante_tipo] => 4
            //        [estado_nombre] => Activo
            //    )
            
            $this->load->view('personal_visitante/reporte_excel_lista.php', $data);
 
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

    public function subir_archivo($id){
        $logged = $this->Conf_usuarios_model->isLogged();
        $id_conf_roles_es_2 = $this->session->userdata('id_conf_roles_es_2');
        $id_conf_roles_es_3 = $this->session->userdata('id_conf_roles_es_3');
        if($logged == TRUE && ($id_conf_roles_es_2 == true || $id_conf_roles_es_3 == true)   ){
                
            $data['id']             = $id;
            
            $data['id_usuario']    = $id;
            
            $data['oper'] = "subir_archivo";

            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('plantilla/menu');
            
            $this->load->view('personal_visitante/v_personal_visitante_subir_archivos.php', $data);
            $this->load->view('plantilla/b_footer_llamados');
            $this->load->view('personal_visitante/v_footer_llamados');
            $this->load->view('personal_visitante/ajax_archivos');
            $this->load->view('plantilla/b_footer_cierre');
            
            
        }else{
            $this->session->sess_destroy('username');
            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('login/v_login_1');
            $this->load->view('plantilla/footer');
        }
    }

    public function get_subir_archivo(){
            $id     = $this->input->post('id');
            $matriz_visitante = $this->Personal_visitante_model->personal_visitante_buscar_2($id);
            
            //$ruta = "images/personal_ivic/".$fila_reg[0]->imagen_nombre; //echo "ruta *".$ruta."*";
            //if(file_exists($ruta) == true){
            //}else{
            //    //echo "No encontro la ruta  *".$ruta."*";
            //    $fila_reg[0]->imagen_nombre = "sin_imagen.png";
            //}            
            
            $imagen_nombre = $matriz_visitante[0]->imagen_nombre;            
            if($imagen_nombre != ""){
                $ruta = "images/personal_visitante/".$imagen_nombre;                
                if(file_exists($ruta) == true){
                    unlink($ruta);    
                }
            }
            
            $extension = pathinfo($_FILES['archivo']['name'], PATHINFO_EXTENSION);
            //$imagen_nombre = time()."_".$id.".".$extension;
            $imagen_nombre = $matriz_visitante[0]->cedula.".".$extension;
            $ruta = "images/personal_visitante/".$imagen_nombre;   //echo "<br /> RUTA *".$ruta."*";
            $archivo_cargado = move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta);
            if($archivo_cargado){       //echo json_encode("PASO 1");
                $this->Personal_visitante_model->personal_visitante_editar_3($id, $imagen_nombre);
                $mensaje = "Actualizó la imagen del personal visitante con id ".$id.", con el nombre de imagen ".$imagen_nombre;
                $mensaje_2 = $mensaje;
                $this->insertar_bitacora_2("personal_visitante", $mensaje, $mensaje_2);
                $valido = 1;
            }else{      //echo json_encode("PASO 2");
                $valido = 0;
            }
            echo json_encode($valido);
    }
    
    public function get_personal_visitante_buscar_2(){
            $id     = $this->input->post('id');
            $matriz_personal_visitante = $this->Personal_visitante_model->personal_visitante_buscar_2($id);
            echo json_encode($matriz_personal_visitante);
    }    
    
    public function get_personal_visitante_buscar_4(){
            $cedula         = $this->input->post('cedula');
            $resultados     = $this->Personal_visitante_model->personal_visitante_buscar_4($cedula); //echo "resultados *"; print_r($resultados); echo "*";
            echo json_encode($resultados);
    }
    /*
    public function get_personal_visitante_buscar_5(){
            $carnet_codigo    = $this->input->post('carnet_codigo');
            $id     = $this->input->post('id');
            $resultados     = $this->Personal_visitante_model->personal_visitante_buscar_5($carnet_codigo, $id); //echo "resultados *"; print_r($resultados); echo "*";
            echo json_encode($resultados);
    }  

    public function get_personal_visitante_buscar_6(){
            $carnet_codigo    = $this->input->post('carnet_codigo');
            $resultados     = $this->Personal_visitante_model->personal_visitante_buscar_6($carnet_codigo); //echo "resultados *"; print_r($resultados); echo "*";
            echo json_encode($resultados);
    }      
*/
    
}
