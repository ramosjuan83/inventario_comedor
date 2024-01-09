<?php
class Bitacora extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->library('Session');
        $this->load->model('Conf_bitacora_model');
        $this->load->model('Conf_usuarios_model');
        $this->load->model('Conf_roles_model');
        //$this->load->model('Conf_configuracion_model');
        //$this->load->model('Conf_empresa_model');
    }

    //_____________________________________________________________________________________________________________________________________________
    //AQUI SE llama al formulario de seleccion de Busquedad de asignaturas por calificar
    public function listar($memoria = 'false'){
        $logged = $this->Conf_usuarios_model->isLogged();
        $id_conf_roles_es_1 = $this->session->userdata('id_conf_roles_es_1');
        if($logged == TRUE && $id_conf_roles_es_1 == true){
        
                //$bitacora_id_usuario_a_omitir = $matriz_conf_configuracion['bitacora_id_usuario_a_omitir'];
        

                if($memoria == 'limpiar'){
                    $this->session->unset_userdata('bitacora_b_id_usuario');
                    $this->session->unset_userdata('bitacora_b_fecha_desde');
                    $this->session->unset_userdata('bitacora_b_fecha_hasta');
                    $this->session->unset_userdata('bitacora_b_texto');
                }
                
                if (	isset ($_POST['b_id_usuario'])	){
                        $b_id_usuario = $_POST['b_id_usuario'];
                        $s_busquedad = array('bitacora_b_id_usuario' => $b_id_usuario);
                        $this->session->set_userdata($s_busquedad);
                }else{
                        $b_id_usuario = "";
                        if( strlen($this->session->userdata('bitacora_b_id_usuario')) > 0  ){
                            $b_id_usuario = $this->session->userdata('bitacora_b_id_usuario');
                        }
                }

                //echo "b_id_usuario *".$b_id_usuario."*";
                //echo "data['matriz_conf_usuarios'] <pre>*"; print_r($data['matriz_conf_usuarios']); echo "*</pre>";
                
                if (	isset ($_POST['b_fecha_desde'])	){
                        $b_fecha_desde = $_POST['b_fecha_desde'];
                        $s_busquedad = array('bitacora_b_fecha_desde' => $b_fecha_desde);
                        $this->session->set_userdata($s_busquedad);
                }else{
                        $b_fecha_desde = "";
                        if( strlen($this->session->userdata('bitacora_b_fecha_desde')) > 0  ){
                            $b_fecha_desde = $this->session->userdata('bitacora_b_fecha_desde');
                        }
                }
                if(strlen($b_fecha_desde) > 2){     $b_fecha_desde = $this->ordena_fecha_3($b_fecha_desde);    }

                if (	isset ($_POST['b_fecha_hasta'])	){
                        $b_fecha_hasta = $_POST['b_fecha_hasta'];
                        $s_busquedad = array('bitacora_b_fecha_hasta' => $b_fecha_hasta);
                        $this->session->set_userdata($s_busquedad);
                }else{
                        $b_fecha_hasta = "";
                        if( strlen($this->session->userdata('bitacora_b_fecha_hasta')) > 0  ){
                            $b_fecha_hasta = $this->session->userdata('bitacora_b_fecha_hasta');
                        }
                }
                if(strlen($b_fecha_hasta) > 2){     $b_fecha_hasta = $this->ordena_fecha_3($b_fecha_hasta);    }
                
                if (	isset ($_POST['b_texto'])	){
                        $b_texto = $_POST['b_texto'];
                        $s_busquedad = array(
                                'bitacora_b_texto' => $b_texto
                        );
                        $this->session->set_userdata($s_busquedad);
                }else{
                        $b_texto = "";
                        if( strlen($this->session->userdata('bitacora_b_texto')) > 0  ){
                            $b_texto = $this->session->userdata('bitacora_b_texto');
                        }
                }
                $b_texto = str_replace("'", "", $b_texto); 
                
                if($memoria == 'cargo_ultima_pagina'){
                        $pagina_actual = $this->session->userdata('carreras_ultima_pagina');    
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
                            'carreras_ultima_pagina' => $pagina_actual
                        );
                        $this->session->set_userdata($s_lista);                    
                        $segmento = $this->uri->segment(4);                    
                }

                $this->load->helper('form');
                $this->load->library('pagination');
                $pages = 8; //Número de registros mostrados por páginas
                $config['base_url'] = base_url().'index.php/Bitacora/listar/pagina'; // parametro base de la aplicación, si tenemos un .htaccess nos evitamos el index.php
                $total_rows = $this->Conf_bitacora_model->conf_bitacora_num_reg($b_id_usuario, $b_fecha_desde, $b_fecha_hasta, $b_texto, "");
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
                $dat_list = $this->Conf_bitacora_model->conf_bitacora_buscar($b_id_usuario, $b_fecha_desde, $b_fecha_hasta, $b_texto, "", $config['per_page'],$segmento);
                
                $data['b_id_usuario']  = $b_id_usuario;
                $data['matriz_conf_usuarios']  = $this->Conf_usuarios_model->conf_usuarios_buscar_8();                
                
                if($dat_list != false){
                    for($i=0; $i < count($dat_list); $i++){
                        $dat_list[$i]->conf_bitacora_fecha = $this->ordena_fecha($dat_list[$i]->conf_bitacora_fecha);  
                    } 
                }
                //echo "dat_list_articulo <pre>*"; print_r($dat_list); echo "*</pre>";
                if(strlen($b_fecha_desde) > 2){     $b_fecha_desde = $this->ordena_fecha_4($b_fecha_desde);    }
                if(strlen($b_fecha_hasta) > 2){     $b_fecha_hasta = $this->ordena_fecha_4($b_fecha_hasta);    }
                $data['b_fecha_desde']  = $b_fecha_desde;
                $data['b_fecha_hasta']  = $b_fecha_hasta;
                
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
                $this->load->view('bitacora/v_bitacora_listar', $dat_list);
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
    public function llama_reporte_de_listar($id_periodo){
        $matriz_conf_configuracion = $this->Conf_configuracion_model->conf_configuracion_buscar_2();
        $nombre_de_archivo_login = $matriz_conf_configuracion['nombre_de_archivo_login'];
        
        $logged = $this->Conf_usuarios_model->isLogged();
        if($logged == TRUE){
            
            //Busco el nombre del periodo
            $matriz_periodos = $this->Periodos_model->periodos_buscar_2($id_periodo);
            $data['periodo_nombre'] = $matriz_periodos[0]->nombre;
            //Fin de Busco el nombre del periodo
            
            $matriz_inscripcion_asignatura = $this->Inscripcion_asignaturas_model->inscripcion_asignatura_buscar_16($id_periodo, 1);
            //echo "matriz_inscripcion_asignatura *<pre>"; print_r($matriz_inscripcion_asignatura); echo "*</pre>";            
            //[0] => stdClass Object
            //    (
            //        [inscripcion_asignaturas_id] => 206
            //        [asignaturas_ofertadas_id_asignatura] => 
            //        [asignaturas_ofertadas_id_asignatura_pensum] => 44
            //        [estudiante_pensum_id_pensum] => 4
            //        [conf_usuarios_ci_usu] => 4283543
            //        [conf_usuarios_nombre_usu] => Henry Antonio
            //        [conf_usuarios_apellido_usu] => Navas Nieves
            //    )
            
            $total_incripciones_asignaturas = 0;
            if($matriz_inscripcion_asignatura != false){
                $total_incripciones_asignaturas = count($matriz_inscripcion_asignatura);    
            }
            $data['total_incripciones_asignaturas'] = $total_incripciones_asignaturas;
            unset($matriz_final);  $x = 0;
            if($matriz_inscripcion_asignatura != false){
                for($i = 0; $i < count($matriz_inscripcion_asignatura); $i++){
                    $id_inscripcion_asignatura = $matriz_inscripcion_asignatura[$i]->inscripcion_asignaturas_id;
                    unset($matriz_notas);
                    $matriz_notas = $this->Notas_model->notas_buscar_6($id_inscripcion_asignatura);
                    if($matriz_notas == false){
                        unset($matriz_asignaturas_pensum);
                        //BUSCO CUANDO LA ASIGNATURA OFERTADA ESTA ASOCIADA CON ASIGNATURA
                        if($matriz_inscripcion_asignatura[$i]->asignaturas_ofertadas_id_asignatura > 0){
                            $id_pensum      = $matriz_inscripcion_asignatura[$i]->estudiante_pensum_id_pensum;
                            $id_asignatura  = $matriz_inscripcion_asignatura[$i]->asignaturas_ofertadas_id_asignatura;
                            $matriz_asignaturas_pensum = $this->Asignaturas_pensum_model->asignaturas_pensum_buscar_5($id_pensum, $id_asignatura);
                        }
                        //FIN DE BUSCO CUANDO LA ASIGNATURA OFERTADA ESTA ASOCIADA CON ASIGNATURA
                        //BUSCO CUANDO LA ASIGNATURA OFERTADA ESTA ASOCIADA CON ASIGNATURA PENSUM
                        if($matriz_inscripcion_asignatura[$i]->asignaturas_ofertadas_id_asignatura_pensum > 0){
                            $id_asignatura_pensum = $matriz_inscripcion_asignatura[$i]->asignaturas_ofertadas_id_asignatura_pensum;
                            //echo "id_asignatura_pensum *".$id_asignatura_pensum."*";
                            $matriz_asignaturas_pensum = $this->Asignaturas_pensum_model->asignaturas_pensum_buscar_6($id_asignatura_pensum);
                            //echo "matriz_asignaturas_pensum <br />*<pre>"; print_r($matriz_asignaturas_pensum); echo "</pre>*";
                        }
                        //FIN DE BUSCO CUANDO LA ASIGNATURA OFERTADA ESTA ASOCIADA CON ASIGNATURA PENSUM                                        
                        
                        //Busco la asignatura
                        $id_asignatura    = $matriz_asignaturas_pensum[0]->asignaturas_pensum_id_asignatura;
                        $matriz_asignatura = $this->Asignatura_model->asignatura_buscar_2($id_asignatura);
                        $matriz_final[$x]['asignatura_codigo_asig']                 = $matriz_asignatura[0]->codigo_asig;
                        $matriz_final[$x]['asignatura_nombre']                      = $matriz_asignatura[0]->nombre;
                        //FIN DE Busco la asignatura

                        //Busco el estudiante
                        $matriz_conf_usuarios = $this->Conf_usuarios_model->conf_usuarios_buscar_2($matriz_inscripcion_asignatura[$i]->estudiante_ficha_id_usuario);
                        $matriz_final[$x]['estudiante_conf_usuarios_ci_usu']          = $matriz_conf_usuarios[0]->ci_usu;
                        $matriz_final[$x]['estudiante_conf_usuarios_nombre_usu']      = $matriz_conf_usuarios[0]->nombre_usu;
                        $matriz_final[$x]['estudiante_conf_usuarios_apellido_usu']    = $matriz_conf_usuarios[0]->apellido_usu;
                        //FIn de Busco el estudiante
                        
                        $matriz_final[$x]['carreras_nombre']                        = $matriz_asignaturas_pensum[0]->carreras_nombre;
                        $matriz_final[$x]['pensum_nombre']                          = $matriz_asignaturas_pensum[0]->pensum_nombre;
                        $matriz_final[$x]['profesor_conf_usuarios_ci_usu']          = $matriz_inscripcion_asignatura[$i]->conf_usuarios_ci_usu;
                        $matriz_final[$x]['profesor_conf_usuarios_nombre_usu']      = $matriz_inscripcion_asignatura[$i]->conf_usuarios_nombre_usu;
                        $matriz_final[$x]['profesor_conf_usuarios_apellido_usu']    = $matriz_inscripcion_asignatura[$i]->conf_usuarios_apellido_usu;
                        
                        $x = $x + 1;
                    }
                }                
            }else{
                $matriz_final = false;
            }
            //echo "matriz_final <br />*<pre>"; print_r($matriz_final); echo "</pre>*";
            //[0] => Array
            //    (
            //        [asignatura_codigo_asig] => 017
            //        [asignatura_nombre] => Dirección de la Producción
            //        [estudiante_conf_usuarios_ci_usu] => 6508940
            //        [estudiante_conf_usuarios_nombre_usu] => Julio César
            //        [estudiante_conf_usuarios_apellido_usu] => Oliveros Guevara
            //        [carreras_nombre] => Maestría
            //        [pensum_nombre] => Ciencia de Dirección (Dedicación Exclusiva)
            //        [profesor_conf_usuarios_ci_usu] => 4283543
            //        [profesor_conf_usuarios_nombre_usu] => Henry Antonio
            //        [profesor_conf_usuarios_apellido_usu] => Navas Nieves
            //    )
            $data['matriz_final'] = $matriz_final;
            
            $matris_conf_empresa = $this->Conf_empresa_model->conf_empresa_buscar_2();
            $data['matris_conf_empresa'] = $matris_conf_empresa;            
            
            $matriz_conf_configuracion = $this->Conf_configuracion_model->conf_configuracion_buscar_2();
            $data['matriz_conf_configuracion'] = $matriz_conf_configuracion;
            
            $formato_asignaturas_si_calificar = $matriz_conf_configuracion['formato_asignaturas_si_calificar'];            
            if($formato_asignaturas_si_calificar == 1){
                $this->load->view('notas/reporte_notas_por_calificar_1', $data);    
            }
        }else{
            $this->session->sess_destroy('username');
            $data['matriz_conf_configuracion'] = $this->Conf_configuracion_model->conf_configuracion_buscar_2();
            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('login/v_login_1');
            $this->load->view('plantilla/footer');
        }
    }    */
    //Fin de AQUI SE llama al formulario de seleccion de Busquedad de asignaturas por calificar    
    //_____________________________________________________________________________________________________________________________________________

    public function ver_reporte($formato, $b_fecha_desde, $b_fecha_hasta, $b_id_usuario, $b_texto){
        $logged = $this->Conf_usuarios_model->isLogged();
        if($logged == TRUE){
            //$matriz_conf_configuracion = $this->Conf_configuracion_model->conf_configuracion_buscar_2();
            //$bitacora_id_usuario_a_omitir = $matriz_conf_configuracion['bitacora_id_usuario_a_omitir'];
            
            if($b_fecha_desde == "NULL"){         $b_fecha_desde = "";          }
            $data['b_fecha_desde'] = $b_fecha_desde;
            if(strlen($b_fecha_desde) > 0){
                $b_fecha_desde = $this->ordena_fecha($b_fecha_desde);    
            }
            
            if($b_fecha_hasta == "NULL"){         $b_fecha_hasta = "";          }
            $data['b_fecha_hasta'] = $b_fecha_hasta;
            if(strlen($b_fecha_hasta) > 0){
                $b_fecha_hasta = $this->ordena_fecha($b_fecha_hasta);    
            }

            if($b_id_usuario == "NULL"){         $b_id_usuario = "";          }
            $data['b_id_usuario'] = $b_id_usuario;
            
            $b_usuario = "";
            if($b_id_usuario > 0){
                $matriz_conf_usuarios = $this->Conf_usuarios_model->conf_usuarios_buscar_2($b_id_usuario);
                $b_usuario  = "(".$matriz_conf_usuarios[0]->ci_usu.")";
                $b_usuario .= " ".$matriz_conf_usuarios[0]->nombre_usu;
                $b_usuario .= " ".$matriz_conf_usuarios[0]->apellido_usu;
            }
            $data['b_usuario'] = $b_usuario;
            
            if($b_texto == "NULL"){         $b_texto = "";          }
            $b_texto = str_replace("'", "", $b_texto);
            $b_texto_2 = preg_replace('/^0+/', '', $b_texto); //QUITO LOS CEROS A LA IZQUIERDA
            $b_texto = str_replace("%20", " ", $b_texto); //LE QUITO EL FORMATO DE LOS ESPACIOS ENTRE PALABRAS
            $data['b_texto'] = $b_texto;

            $matriz_bitacora = $this->Conf_bitacora_model->conf_bitacora_buscar($b_id_usuario, $b_fecha_desde, $b_fecha_hasta, $b_texto, "", "", "");
            $data["matriz_bitacora"] = $matriz_bitacora;
            
            //$matris_conf_empresa = $this->Conf_empresa_model->conf_empresa_buscar_2();
            //$data['matris_conf_empresa'] = $matris_conf_empresa;            
            
            
            //$formato_bitacora_lista = $matriz_conf_configuracion['formato_bitacora_lista'];
            
            //if($formato_bitacora_lista == 1){
                //$this->load->view('bitacora/reporte_pdf_lista_1', $data);    
            //}
                
            if($formato == "pdf"){
                $this->load->view('bitacora/reporte_pdf_lista_1', $data);    
            }
            if($formato == "excel"){
                $this->load->view('bitacora/reporte_excel_lista.php', $data);
            }
        }        
    }
    
    public function ver_pdf_detalle($conf_bitacora_id){
        $logged = $this->Conf_usuarios_model->isLogged();
        if($logged == TRUE){
            $matriz_conf_configuracion = $this->Conf_configuracion_model->conf_configuracion_buscar_2();
            
            $data["conf_bitacora_id"] = $conf_bitacora_id;
            
            $matriz_conf_bitacora = $this->Conf_bitacora_model->conf_bitacora_buscar_2($conf_bitacora_id);
            $data["matriz_conf_bitacora"] = $matriz_conf_bitacora;
            //echo "matriz_conf_bitacora *<pre>"; print_r($matriz_conf_bitacora); echo "*</pre>";
            //[0] => stdClass Object
            //    (
            //        [conf_bitacora_id] => 5076
            //        [conf_bitacora_id_usuario] => 27
            //        [conf_bitacora_fecha] => 2021-01-29
            //        [conf_bitacora_hora] => 21:22:28
            //        [conf_bitacora_tabla_nombre] => profesor_ficha
            //        [conf_bitacora_accion] => Actualizo la cuenta bancaria del profesor con id 27
            //        [conf_bitacora_accion_2] => Actualizo el profesor (8682602) Paola Isabel  Cano Canales
            //        [conf_bitacora_ip_usuario] => ::1
            //        [conf_usuarios_ci_usu] => 8682602
            //        [conf_usuarios_nombre_usu] => Paola Isabel 
            //        [conf_usuarios_apellido_usu] => Cano Canales
            //    )     
            
            $matriz_conf_bitacora[0]->conf_bitacora_fecha = $this->ordena_fecha($matriz_conf_bitacora[0]->conf_bitacora_fecha);
            
            $matris_conf_empresa = $this->Conf_empresa_model->conf_empresa_buscar_2();
            $data['matris_conf_empresa'] = $matris_conf_empresa;
            
            $formato_bitacora_lista = $matriz_conf_configuracion['formato_bitacora_lista'];
            
            if($formato_bitacora_lista == 1){
                $this->load->view('bitacora/reporte_pdf_lista_detalles_1', $data);    
            }
        }        
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
    
}