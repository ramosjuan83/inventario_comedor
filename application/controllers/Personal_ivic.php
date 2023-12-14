<?php
require_once APPPATH.'controllers/Controlador_padre.php';
class Personal_ivic extends Controlador_padre {
    
    function __construct(){
        parent::__construct();
        $this->load->library('Session');
        $this->load->model('Conf_bitacora_model');
        $this->load->model('Conf_usuarios_model');
        $this->load->model('Personal_ivic_model');
        $this->load->model('Cargos_model');
        $this->load->model('Gerencias_model');
        $this->load->model('Comensal_model');
        $this->load->model('Estados_temporales_model');
        $this->load->model('Estados_model');
        $this->load->model('Tipo_model');
        $this->load->model('Condicion_model');
        $this->load->model('Departamento_model');
        $this->load->model('Categoria_model');
        $this->load->model('Gerencias_2_model');
        
    }

    public function listar($memoria = 'false'){
        //$matriz_conf_configuracion = $this->Conf_configuracion_model->conf_configuracion_buscar_2();
        //$nombre_de_archivo_login = $matriz_conf_configuracion['nombre_de_archivo_login'];
        
        $logged = $this->Conf_usuarios_model->isLogged();
        $id_conf_roles_es_2 = $this->session->userdata('id_conf_roles_es_2');
        if($logged == TRUE && $id_conf_roles_es_2 == true){ 

                if($memoria == 'limpiar'){
                    $this->session->unset_userdata('personal_b_texto');
                    $this->session->unset_userdata('personal_b_id_cargo');
                    $this->session->unset_userdata('personal_b_id_gerencia');
                    $this->session->unset_userdata('personal_b_estado');
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
                if($b_estado == 1){
                    $estado = 1;
                }else{
                    $estado = 2;
                }

                if (	isset ($_POST['b_id_cargo'])	){
                        $b_id_cargo = $_POST['b_id_cargo'];
                        $s_busquedad = array(
                                'personal_b_id_cargo' => $b_id_cargo
                        );
                        $this->session->set_userdata($s_busquedad);
                }else{
                        $b_id_cargo = "";
                        if( strlen($this->session->userdata('personal_b_id_cargo')) > 0  ){
                            $b_id_cargo = $this->session->userdata('personal_b_id_cargo');
                        }
                }
                
                if (	isset ($_POST['b_id_gerencia'])	){
                        $b_id_gerencia = $_POST['b_id_gerencia'];
                        $s_busquedad = array(
                                'personal_b_id_gerencia' => $b_id_gerencia
                        );
                        $this->session->set_userdata($s_busquedad);
                }else{
                        $b_id_gerencia = "";
                        if( strlen($this->session->userdata('personal_b_id_gerencia')) > 0  ){
                            $b_id_gerencia = $this->session->userdata('personal_b_id_gerencia');
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
                $config['base_url'] = base_url().'index.php/personal_ivic/listar/pagina'; // parametro base de la aplicación, si tenemos un .htaccess nos evitamos el index.php
                $total_rows = $this->Personal_ivic_model->personal_ivic_num_reg($b_texto, $b_id_cargo, $b_id_gerencia, $b_estado);
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
                $dat_list = $this->Personal_ivic_model->personal_ivic_buscar($b_texto, $b_id_cargo, $b_id_gerencia, $b_estado, $config['per_page'],$segmento);
                //echo "<br>dat_list *<pre>"; print_r($dat_list); echo "</pre>*";                
                //[0] => stdClass Object
                //    (
                //        [id] => 1718
                //        [cedula] => 5452253
                //        [nombres] => Brigida
                //        [apellidos] => Perez De Martinez
                //        [id_cargo] => 295
                //        [id_gerencia] => 27
                //        [estado] => 1
                //        [imagen_nombre] => 5452253.jpg
                //        [carnet_codigo] => 61664
                //    )

                if($dat_list != false){
                    for($i = 0; $i < count($dat_list); $i++){
                        
                        unset($matriz_cargos);
                        $matriz_cargos = $this->Cargos_model->cargos_buscar_2($dat_list[$i]->id_cargo);
                        $dat_list[$i]->cargos_nombre = $matriz_cargos[0]->nombre;
                        
                        $matriz_gerencias = $this->Gerencias_model->gerencias_buscar_2($dat_list[$i]->id_gerencia);
                        $dat_list[$i]->gerencia_nombre = $matriz_gerencias[0]->nombre;
                        
                        $estado_nombre = "";
                        switch ($dat_list[$i]->estado) {
                            case 1:     $estado_nombre = "Activo";      break;
                            case 2:     $estado_nombre = "Egresado";    break;
                            case 3:     $estado_nombre = "Vacaciones";  break;
                            case 4:     $estado_nombre = "Reposo";      break;
                            case 5:     $estado_nombre = "Suspendido";      break;
                        }
                        $dat_list[$i]->estado_nombre = $estado_nombre;
                        
                        $personal_ivic_id = $dat_list[$i]->id;  //echo "personal_ivic_id *".$personal_ivic_id."*";
                        unset($matriz_comensales);                        
                        $matriz_comensales = $this->Comensal_model->comensales_buscar_7($personal_ivic_id);
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
                $dat_list['b_id_cargo']  = $b_id_cargo;
                $dat_list['b_id_gerencia']  = $b_id_gerencia;
                $dat_list['b_estado']  = $b_estado;
                
                
                
                
                $data['matriz_cargos']  = $this->Cargos_model->conf_cargos_buscar_3(); 
                
                $data['matriz_gerencias']          = $this->Gerencias_model->conf_gerencias_buscar_3();
                
                //$data['matriz_conf_configuracion'] = $this->Conf_configuracion_model->conf_configuracion_buscar_2();
                $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
                $this->load->view('plantilla/header', $data);
                $this->load->view('plantilla/menu');
                $this->load->view('personal_ivic/v_personal_ivic_listar', $dat_list);
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
            $matriz_cargos                     = $this->Cargos_model->conf_cargos_buscar_3();
            $data['matriz_cargos']             = $matriz_cargos;
            
            $matriz_gerencias                  = $this->Gerencias_model->conf_gerencias_buscar_3();
            $data['matriz_gerencias']          = $matriz_gerencias;            
            
            $matriz_gerencias_2                = $this->Gerencias_2_model->gerencias_2_buscar_3();
            $data['matriz_gerencias_2']        = $matriz_gerencias_2;
            
            $matriz_conf_tipo = $this->Tipo_model->conf_tipo_buscar_3();
            $data['matriz_conf_tipo'] = $matriz_conf_tipo;
            
            $matriz_condicion = $this->Condicion_model->conf_condicion_buscar_3();
            $data['matriz_condicion'] = $matriz_condicion;            
            
            $matriz_departamento = $this->Departamento_model->departamento_buscar_3();
            $data['matriz_departamento'] = $matriz_departamento;            

            $matriz_categoria = $this->Categoria_model->categoria_buscar_3();
            $data['matriz_categoria'] = $matriz_categoria;                        
            
            $data['oper'] = "agregar";
            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('plantilla/menu');
            $this->load->view('personal_ivic/v_personal_ivic_frm', $data);
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
            $valor = "cedula";          if ( isset($_POST[$valor]) 	){	$cedula = $_POST[$valor];               }else{	$cedula	= "";	}
            $valor = "nombres"; 	if ( isset($_POST[$valor]) 	){	$nombres = ucfirst( $_POST[$valor] );	}else{	$nombres	= "";	}
            $valor = "apellidos"; 	if ( isset($_POST[$valor]) 	){	$apellidos = ucfirst( $_POST[$valor] );	}else{	$apellidos	= "";	}
            $valor = "id_cargo"; 	if ( isset($_POST[$valor]) 	){	$id_cargo = $_POST[$valor];             }else{	$id_cargo	= "";	}
            $valor = "id_gerencia"; 	if ( isset($_POST[$valor]) 	){	$id_gerencia = $_POST[$valor];          }else{	$id_gerencia	= "";	}
            $valor = "id_gerencia_2"; 	if ( isset($_POST[$valor]) 	){	$id_gerencia_2 = $_POST[$valor];        }else{	$id_gerencia_2	= "";	}
            $valor = "id_tipo"; 	if ( isset($_POST[$valor]) 	){	$id_tipo = $_POST[$valor];              }else{	$id_tipo	= "";	}
            $valor = "id_condicion"; 	if ( isset($_POST[$valor]) 	){	$id_condicion = $_POST[$valor];         }else{	$id_condicion	= "";	}            
            $valor = "estado";          if ( isset($_POST[$valor]) 	){	$estado = $_POST[$valor];               }else{	$estado	= "";	}
            $valor = "carnet_codigo";   if ( isset($_POST[$valor]) 	){	$carnet_codigo = $_POST[$valor];        }else{	$carnet_codigo	= "";	}
            $valor = "id_departamento"; if ( isset($_POST[$valor]) 	){	$id_departamento = $_POST[$valor];      }else{	$id_departamento	= "";	}
            $valor = "id_categoria"; 	if ( isset($_POST[$valor]) 	){	$id_categoria = $_POST[$valor];          }else{	$id_categoria	= "";	}            
            $valor = "fecha_de_ingreso"; if ( isset($_POST[$valor]) 	){	$fecha_de_ingreso = $_POST[$valor];     }else{	$fecha_de_ingreso	= "";	}
            
            $cedula         = str_replace(".", "", $cedula);
            $nombres        = $this->convierte_texto($nombres);
            $apellidos      = $this->convierte_texto($apellidos);            
            if(strlen($fecha_de_ingreso) > 2){     $fecha_de_ingreso = $this->ordena_fecha_3($fecha_de_ingreso);    }            
            
            $imagen_nombre  = $cedula.".jpg";
            /*
            //Valida reg existente
            $valido = false;
            $personal_ivic_num_reg = $this->Personal_ivic_model->personal_ivic_num_reg_2($parametros['nombre']); //echo "cli_clientes_num_reg *".$personal_ivic_num_reg."*";
            if($personal_ivic_num_reg == 0){ $valido = true; }
            else{
                    echo "<script language='javascript'>";
                    echo "alert('El registro no fue incluido, el nombre ya se encuentra en el sistema')";
                    echo "</script>";
                    echo "<script language='javascript'>";
                    echo "window.history.go(-1)";
                    echo "</script>";
            }
            //FIN de Valida reg existente */
            $valido = true;
            if($valido == true){
                    //$id = $this->Personal_ivic_model->personal_ivic_insertar($cedula, $nombres, $apellidos, $id_cargo, $id_gerencia, $estado, $carnet_codigo);
                    //$id = $this->Personal_ivic_model->personal_ivic_insertar($cedula, $nombres, $apellidos, $id_cargo, $id_gerencia, $id_tipo, $id_condicion, $estado, $imagen_nombre, $carnet_codigo);
                    $id = $this->Personal_ivic_model->personal_ivic_insertar($cedula, $nombres, $apellidos, $id_cargo, $id_gerencia, $id_gerencia_2, $id_tipo, $id_condicion, $estado, $imagen_nombre, $carnet_codigo, $id_departamento, $id_categoria, $fecha_de_ingreso);
                    if ($id > 0){
                        $mensaje = "Inserto el Personal ivic con id ".$id;
                        $mensaje_2 = "Inserto el Personal del ivic ".$nombres;
                        $s_mensaje = array(
                                'personal_ivic_mensaje_tipo'         => 'alert-success',
                                'personal_ivic_mensaje_contenido'    => 'Registros insertado exitosamente, '.$mensaje_2
                        );
                        $this->session->set_userdata($s_mensaje);
                        $this->insertar_bitacora_2("personal_ivic", $mensaje, $mensaje_2);
                        redirect('personal_ivic/listar/cargo_ultima_pagina');
                    }else{
                        redirect('personal_ivic/agregar');
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

            $matriz_cargos                     = $this->Cargos_model->conf_cargos_buscar_3();
            $data['matriz_cargos']             = $matriz_cargos;
            
            $matriz_gerencias                  = $this->Gerencias_model->conf_gerencias_buscar_3();
            $data['matriz_gerencias']          = $matriz_gerencias;

            $matriz_gerencias_2                = $this->Gerencias_2_model->gerencias_2_buscar_3();
            $data['matriz_gerencias_2']        = $matriz_gerencias_2;
            
            $fila_reg = $this->Personal_ivic_model->personal_ivic_buscar_2($id);   //echo "<pre>"; print_r($fila_reg); echo "</pre>";
            //[0] => stdClass Object
            //    (
            //        [id] => 1844
            //        [cedula] => 10850103
            //        [nombres] => Jeison3
            //        [apellidos] => Rojas De NuÑez
            //        [id_cargo] => 256
            //        [id_gerencia] => 39
            //        [id_tipo] => 3
            //        [id_condicion] => 1
            //        [estado] => 1
            //        [imagen_nombre] => 10850103.jpg
            //        [firma_nombre] => 
            //        [carnet_codigo] => 1201
            //        [id_departamento] => 2
            //        [id_categoria] => 2
            //        [fecha_ingreso] => 2023-06-23
            //    )
            
            if(strlen($fila_reg[0]->fecha_ingreso) > 2){
                $fila_reg[0]->fecha_ingreso = $this->ordena_fecha_4($fila_reg[0]->fecha_ingreso);    
            }
            
            
            //VERIFICO SI LA IMAGEN EXISTE SI NO QUE HABrA LA IMAGEN POR DEFECTO
            //$ruta = base_url("images/personal_ivic/").$fila_reg[0]->imagen_nombre; //echo "ruta *".$ruta."*";
            $ruta = "images/personal_ivic/".$fila_reg[0]->imagen_nombre; //echo "ruta *".$ruta."*";
            if(file_exists($ruta) == true){
            }else{
                //echo "No encontro la ruta  *".$ruta."*";
                $fila_reg[0]->imagen_nombre = "sin_imagen.png";
            }
            //FIN DE VERIFICO SI LA IMAGEN EXISTE SI NO QUE HABrA LA IMAGEN POR DEFECTO
            
            
            $data['fila_personal'] = $fila_reg[0];
            
            
            $matriz_estados_temporales = $this->Estados_temporales_model->estados_temporales_buscar_5($id);
            if($matriz_estados_temporales != false){
                for($i = 0; $i < count($matriz_estados_temporales); $i++){
                    $matriz_estados_temporales[$i]->estados_temporales_fecha_desde = $this->ordena_fecha_5($matriz_estados_temporales[$i]->estados_temporales_fecha_desde);
                    $matriz_estados_temporales[$i]->estados_temporales_fecha_hasta = $this->ordena_fecha_5($matriz_estados_temporales[$i]->estados_temporales_fecha_hasta);
                }
            }
            $data['matriz_estados_temporales'] = $matriz_estados_temporales;
            
            
            $matriz_conf_tipo = $this->Tipo_model->conf_tipo_buscar_3();
            $data['matriz_conf_tipo'] = $matriz_conf_tipo;
            
            $matriz_condicion = $this->Condicion_model->conf_condicion_buscar_3();
            $data['matriz_condicion'] = $matriz_condicion;

            $matriz_departamento = $this->Departamento_model->departamento_buscar_3();
            $data['matriz_departamento'] = $matriz_departamento;            

            $matriz_categoria = $this->Categoria_model->categoria_buscar_3();
            $data['matriz_categoria'] = $matriz_categoria;            
            
            $data['oper'] = "editar";

            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('plantilla/menu');
            $this->load->view('personal_ivic/v_personal_ivic_frm', $data);
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
            $valor = "id_gerencia_2"; 	if ( isset($_POST[$valor]) 	){	$id_gerencia_2 = $_POST[$valor];        }else{	$id_gerencia_2	= "";	}
            $valor = "id_tipo"; 	if ( isset($_POST[$valor]) 	){	$id_tipo = $_POST[$valor];              }else{	$id_tipo	= "";	}
            $valor = "id_condicion"; 	if ( isset($_POST[$valor]) 	){	$id_condicion = $_POST[$valor];         }else{	$id_condicion	= "";	}
            $valor = "estado";          if ( isset($_POST[$valor]) 	){	$estado = $_POST[$valor];               }else{	$estado	= "";	}
            $valor = "carnet_codigo";   if ( isset($_POST[$valor]) 	){	$carnet_codigo = $_POST[$valor];        }else{	$carnet_codigo	= "";	}
            $valor = "fecha_de_ingreso"; if ( isset($_POST[$valor]) 	){	$fecha_de_ingreso = $_POST[$valor];     }else{	$fecha_de_ingreso	= "";	}
            $valor = "id_departamento"; if ( isset($_POST[$valor]) 	){	$id_departamento = $_POST[$valor];      }else{	$id_departamento	= "";	}
            $valor = "id_categoria"; 	if ( isset($_POST[$valor]) 	){	$id_categoria = $_POST[$valor];          }else{	$id_categoria	= "";	}
            
            $cedula         = str_replace(".", "", $cedula);
            $nombres        = $this->convierte_texto($nombres);
            $apellidos      = $this->convierte_texto($apellidos);            
            
            if(strlen($fecha_de_ingreso) > 2){     $fecha_de_ingreso = $this->ordena_fecha_3($fecha_de_ingreso);    }
            
            $valido = true;
            if($valido == true){
                //BUSCO SI SE ESTA COLOCANDO AL PERSONAL COMO NO ACTIVO
                $matriz_personal_ivic = $this->Personal_ivic_model->personal_ivic_buscar_2($id);
                if($matriz_personal_ivic[0]->estado == 1){
                    if($estado != 1){
                        $fecha = date("Y-m-d");
                        $this->Personal_ivic_model->personal_ivic_editar_3($id, $fecha);
                    }
                }
                //FIN DE BUSCO SI SE ESTA COLOCANDO AL PERSONAL COMO NO ACTIVO
                
                //$oper_realizada = $this->Personal_ivic_model->personal_ivic_editar($id, $nombres, $apellidos, $id_cargo, $id_gerencia, $estado, $carnet_codigo);
                //$oper_realizada = $this->Personal_ivic_model->personal_ivic_editar($id, $nombres, $apellidos, $id_cargo, $id_gerencia, $id_tipo, $id_condicion, $estado, $carnet_codigo);
                $oper_realizada = $this->Personal_ivic_model->personal_ivic_editar($id, $nombres, $apellidos, $id_cargo, $id_gerencia, $id_gerencia_2, $id_tipo, $id_condicion, $estado, $carnet_codigo, $id_departamento, $id_categoria, $fecha_de_ingreso);   //echo "oper_realizada *".$oper_realizada."*";
                if ($oper_realizada){
                    $mensaje = "Actualizó el personal ivic con id ".$id;
                    $mensaje_2 = "Actualizó el Personal ivic ".$nombres;
                    $s_mensaje = array(
                            'personal_ivic_mensaje_tipo'  => 'alert-success',
                            'personal_ivic_mensaje_contenido'    => 'Registros actualizado exitosamente, '.$mensaje_2
                    );
                    $this->session->set_userdata($s_mensaje);
                    $this->insertar_bitacora_2("personal_ivic", $mensaje, $mensaje_2);

                    redirect('personal_ivic/listar/cargo_ultima_pagina');
                }else{
                    redirect('personal_ivic/editar');
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
                
                $matriz_personal_ivic = $this->Personal_ivic_model->personal_ivic_buscar_2($id);
                $personal_ivic_nombre = $matriz_personal_ivic[0]->nombres;
                
                $imagen_nombre = $matriz_personal_ivic[0]->imagen_nombre;  
                
                //Valida registro relacionado
                $valido = true;
                /*
                $num_rows = $this->Pensum_model->pensum_num_reg_4($id);
                if($num_rows > 0){
                    $valido = false;
                    $mensaje = "Error al eliminar, la Carrera con id ".$id." se encuentra asociado con un Pensum";
                    $mensaje_2 = "Error al eliminar, la Carrera ".$personal_ivic_nombre." se encuentra asociado con un Pensum";
                    $s_mensaje = array(
                            'personal_ivic_mensaje_tipo'         => 'alert-danger',
                            'personal_ivic_mensaje_contenido'    => 'El registro no fue eliminado, '.$mensaje_2
                    );
                    $this->session->set_userdata($s_mensaje);
                    $this->insertar_bitacora_2("personal_ivic", $mensaje, $mensaje_2);                    
                }*/
                //Fin de valida registro relacionado
                if( $valido == true ){
                    $oper_realizada = $this->Personal_ivic_model->personal_ivic_eliminar($id);
                    if ($oper_realizada){
                        
                            if($imagen_nombre != ""){
                                $ruta = "images/personal_ivic/".$imagen_nombre;                
                                if(file_exists($ruta) == true){
                                    unlink($ruta);    
                                }
                            }                         
                        
                            $mensaje = "Eliminó el personal ivic con id ".$id;
                            $mensaje_2 = "Eliminó el personal ivic ".$personal_ivic_nombre;
                            $s_mensaje = array(
                                    'personal_ivic_mensaje_tipo'         => 'alert-success',
                                    'personal_ivic_mensaje_contenido'    => 'Registros eliminado exitosamente, '.$mensaje_2
                            );
                            $this->session->set_userdata($s_mensaje);
                            $this->insertar_bitacora_2("personal_ivic", $mensaje, $mensaje_2);
                    }                
                }
                redirect('personal_ivic/listar/cargo_ultima_pagina');                
            }else{
                redirect('Login/v_login_mensaje_1');
            }
    }

    
    public function agregar_estado_temporal($id){
        $logged = $this->Conf_usuarios_model->isLogged();
        $id_conf_roles_es_2 = $this->session->userdata('id_conf_roles_es_2');
        if($logged == TRUE && $id_conf_roles_es_2 == true){
            $data['id']             = $id;
            
            $matriz_estados                    = $this->Estados_model->estados_buscar_3();
            $data['matriz_estados']            = $matriz_estados;            
            
            $data['oper'] = "agregar_estado_temporal";
            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('plantilla/menu');
            $this->load->view('personal_ivic/v_personal_ivic_frm_estado_temporal.php', $data);
            $this->load->view('plantilla/footer');             
            
        }else{
            $this->session->sess_destroy('username');
            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('login/v_login_1');
            $this->load->view('plantilla/footer');
        }
    }
    
    public function agregar_guardar_estado_temporal(){
        $logged = $this->Conf_usuarios_model->isLogged();
        if($logged == TRUE){
            
            $valor = "personal_ivic_id";    if ( isset($_POST[$valor]) 	){	$personal_ivic_id = $_POST[$valor];            }else{	$personal_ivic_id	= "";	}
            $valor = "id_estados";          if ( isset($_POST[$valor]) 	){	$id_estados = $_POST[$valor];                  }else{	$id_estados	= "";	}
            $valor = "b_fecha_desde";       if ( isset($_POST[$valor]) 	){	$b_fecha_desde = $_POST[$valor];               }else{	$b_fecha_desde	= "";	}
            $valor = "b_fecha_hasta";       if ( isset($_POST[$valor]) 	){	$b_fecha_hasta = $_POST[$valor];               }else{	$b_fecha_hasta	= "";	}
            
            $matriz_personal_ivic = $this->Personal_ivic_model->personal_ivic_buscar_2($personal_ivic_id);
            $personal_ivic_nombre = $matriz_personal_ivic[0]->nombres;            
            
            $b_fecha_desde = $this->ordena_fecha_3($b_fecha_desde);
            $b_fecha_hasta = $this->ordena_fecha_3($b_fecha_hasta);
            //echo "b_fecha_desde *".$b_fecha_desde."*";
            
            ////Valida reg existente
            //$valido = false;
            //$personal_ivic_num_reg = $this->Personal_ivic_model->personal_ivic_num_reg_2($parametros['nombre']); //echo "cli_clientes_num_reg *".$personal_ivic_num_reg."*";
            //if($personal_ivic_num_reg == 0){ $valido = true; }
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
                    $id_estados_temporal = $this->Estados_temporales_model->estados_temporales_insertar($personal_ivic_id, $id_estados, $b_fecha_desde, $b_fecha_hasta);
                    if ($id_estados_temporal > 0){
                        $mensaje = "Inserto el Estados_temporales con id ".$id_estados_temporal;
                        $mensaje_2 = "Inserto el Estados_temporal al Personal del ivic ".$personal_ivic_nombre;

                        $s_mensaje = array(
                                'personal_ivic_mensaje_tipo'         => 'alert-success',
                                'personal_ivic_mensaje_contenido'    => 'Registros insertado exitosamente, '.$mensaje_2
                        );
                        $this->session->set_userdata($s_mensaje); 
                        $this->insertar_bitacora_2("Estados_temporales", $mensaje, $mensaje_2);
                        redirect('personal_ivic/editar/'.$personal_ivic_id);
                    }else{
                        redirect('personal_ivic/listar/cargo_ultima_pagina');
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
    
    public function eliminar_estado_temporal($personal_ivic_id, $id){
            $logged = $this->Conf_usuarios_model->isLogged();
            $id_conf_roles_es_2 = $this->session->userdata('id_conf_roles_es_2');
            if($logged == TRUE && $id_conf_roles_es_2 == true){
                
                $matriz_personal_ivic = $this->Personal_ivic_model->personal_ivic_buscar_2($personal_ivic_id);
                $personal_ivic_nombre = $matriz_personal_ivic[0]->nombres;
                
                //Valida registro relacionado
                $valido = true;
                /*
                $num_rows = $this->Pensum_model->pensum_num_reg_4($id);
                if($num_rows > 0){
                    $valido = false;
                    $mensaje = "Error al eliminar, la Carrera con id ".$id." se encuentra asociado con un Pensum";
                    $mensaje_2 = "Error al eliminar, la Carrera ".$personal_ivic_nombre." se encuentra asociado con un Pensum";
                    $s_mensaje = array(
                            'personal_ivic_mensaje_tipo'         => 'alert-danger',
                            'personal_ivic_mensaje_contenido'    => 'El registro no fue eliminado, '.$mensaje_2
                    );
                    $this->session->set_userdata($s_mensaje);
                    $this->insertar_bitacora_2("personal_ivic", $mensaje, $mensaje_2);                    
                }*/
                //Fin de valida registro relacionado
                if( $valido == true ){
                    $oper_realizada = $this->Estados_temporales_model->estados_temporales_eliminar($id);
                    if ($oper_realizada){
                        $mensaje = "Elimino el Estados temporales con id ".$id;
                        $mensaje_2 = "Elimino el Estados_temporal al Personal del ivic ".$personal_ivic_nombre;

                        $s_mensaje = array(
                                'personal_ivic_mensaje_tipo'         => 'alert-success',
                                'personal_ivic_mensaje_contenido'    => 'Registros insertado exitosamente, '.$mensaje_2
                        );
                        $this->session->set_userdata($s_mensaje); 
                        $this->insertar_bitacora_2("Estados_temporales", $mensaje, $mensaje_2);
                        redirect('personal_ivic/editar/'.$personal_ivic_id);
                    }                
                }
                redirect('personal_ivic/listar/cargo_ultima_pagina');                
            }else{
                redirect('Login/v_login_mensaje_1');
            }
    }    
    

//    public function ver_excel_lista($b_texto, $b_estado){
//        $logged = $this->Conf_usuarios_model->isLogged();
//        if($logged == TRUE){
//
//            if($b_estado == "NULL"){         $b_estado = "";          }
//            $data['b_estado'] = $b_estado;            
//            
//            if($b_texto == "NULL"){         $b_texto = "";          }
//            $b_texto = str_replace("'", "", $b_texto);
//            $b_texto_2 = preg_replace('/^0+/', '', $b_texto); //QUITO LOS CEROS A LA IZQUIERDA
//            $b_texto = str_replace("%20", " ", $b_texto); //LE QUITO EL FORMATO DE LOS ESPACIOS ENTRE PALABRAS
//            $data['b_texto'] = $b_texto;
//
//            $estado = "";
//            $estado_1 = "";
//            if($b_estado > 0){
//                if($b_estado == 1){
//                    $estado = 1;
//                    $estado_1 = "Activo";
//                }else{
//                    $estado = 2;
//                    $estado_1 = "No Activo";
//                }                
//            }
//            $data['estado_1'] = $estado_1;
//            
//            $b_id_cargo = "";
//            $b_id_gerencia = "";
//            $matriz_personal_ivic = $this->Personal_ivic_model->personal_ivic_buscar($b_texto, $b_id_cargo, $b_id_gerencia, $estado, "", ""); 
//            //echo "<br>matriz_personal_ivic *<pre>"; print_r($matriz_personal_ivic); echo "</pre>*";
//
//            $data['matriz_personal_ivic'] = $matriz_personal_ivic;
//
//            //CARGO EL ESTADO NOMBRE --------------------------------------------
//            if($matriz_personal_ivic != false){
//                for($i = 0; $i < count($matriz_personal_ivic); $i++){
//
//                    $estado_nombre = "";
//                    switch ($matriz_personal_ivic[$i]->estado) {
//                        case 1:     $estado_nombre = "Activo";      break;
//                        case 2:     $estado_nombre = "Egresado";    break;
//                        case 3:     $estado_nombre = "Vacaciones";  break;
//                        case 4:     $estado_nombre = "Reposo";      break;
//                    }
//                    $matriz_personal_ivic[$i]->estado_nombre = $estado_nombre;            
//                }
//            }
//            //FIN DE CARGO EL ESTADO NOMBRE --------------------------------------------
//            //echo "<br>matriz_personal_ivic *<pre>"; print_r($matriz_personal_ivic); echo "</pre>*";
//            //[0] => stdClass Object
//            //    (
//            //        [id] => 1718
//            //        [cedula] => 5452253
//            //        [nombres] => Brigida
//            //        [apellidos] => Perez De Martinez
//            //        [id_cargo] => 295
//            //        [id_gerencia] => 27
//            //        [estado] => 1
//            //        [imagen_nombre] => 5452253.jpg
//            //        [carnet_codigo] => 61664
//            //        [estado_nombre] => Activo
//            //    )            
//            
//            
//            $this->load->view('personal_ivic/reporte_excel_lista.php', $data);
// 
//        }        
//    }    
    
    public function ver_reporte($formato, $b_texto, $b_id_cargo, $b_id_gerencia, $b_estado){
        $logged = $this->Conf_usuarios_model->isLogged();
        if($logged == TRUE){

            if($b_id_cargo == "NULL"){         $b_id_cargo = "";          }
            $data['b_id_cargo'] = $b_id_cargo;            
            
            if($b_id_gerencia == "NULL"){         $b_id_gerencia = "";          }
            $data['b_id_gerencia'] = $b_id_gerencia;                        
            
            if($b_estado == "NULL"){         $b_estado = "";          }
            $data['b_estado'] = $b_estado;            
            
            if($b_texto == "NULL"){         $b_texto = "";          }
            $b_texto = str_replace("'", "", $b_texto);
            $b_texto_2 = preg_replace('/^0+/', '', $b_texto); //QUITO LOS CEROS A LA IZQUIERDA
            $b_texto = str_replace("%20", " ", $b_texto); //LE QUITO EL FORMATO DE LOS ESPACIOS ENTRE PALABRAS
            $data['b_texto'] = $b_texto;

            $cargo_nombre = "";
            if($b_id_cargo > 0){
                    unset($matriz_cargos);
                    $matriz_cargos = $this->Cargos_model->cargos_buscar_2($b_id_cargo);
                    $cargo_nombre = $matriz_cargos[0]->nombre;
            }
            $data['b_cargo_nombre'] = $cargo_nombre;
            
            $gerencia_nombre = "";
            if($b_id_gerencia > 0){
                    unset($matriz_gerencias);
                    $matriz_gerencias = $this->Gerencias_model->gerencias_buscar_2($b_id_gerencia);
                    $gerencia_nombre = $matriz_gerencias[0]->nombre;                
            }
            $data['b_gerencia_nombre'] = $gerencia_nombre;
            
            $estado = "";
            $estado_1 = "";
            if($b_estado > 0){
                if($b_estado == 1){
                    $estado = 1;
                    $estado_1 = "Activo";
                }else{
                    $estado = 2;
                    $estado_1 = "No Activo";
                }                
            }
            $data['estado_1'] = $estado_1;
            
            $matriz_personal_ivic = $this->Personal_ivic_model->personal_ivic_buscar($b_texto, $b_id_cargo, $b_id_gerencia, $estado, "", ""); 

            $data['matriz_personal_ivic'] = $matriz_personal_ivic;

            
            if($matriz_personal_ivic != false){
                for($i = 0; $i < count($matriz_personal_ivic); $i++){

                    $cargo_nombre = "";
                    if($matriz_personal_ivic[$i]->id_cargo > 0){
                        unset($matriz_cargos);
                        $matriz_cargos = $this->Cargos_model->cargos_buscar_2($matriz_personal_ivic[$i]->id_cargo);
                        $cargo_nombre = $matriz_cargos[0]->nombre;
                    }
                    $matriz_personal_ivic[$i]->cargo_nombre = $cargo_nombre;            

                    $gerencia_nombre = "";
                    if($matriz_personal_ivic[$i]->id_gerencia > 0){
                        unset($matriz_gerencias);
                        $matriz_gerencias = $this->Gerencias_model->gerencias_buscar_2($matriz_personal_ivic[$i]->id_gerencia);
                        $gerencia_nombre = $matriz_gerencias[0]->nombre;
                    }
                    $matriz_personal_ivic[$i]->gerencia_nombre = $gerencia_nombre;            
                    
                    $estado_nombre = "";
                    switch ($matriz_personal_ivic[$i]->estado) {
                        case 1:     $estado_nombre = "Activo";      break;
                        case 2:     $estado_nombre = "Egresado";    break;
                        case 3:     $estado_nombre = "Vacaciones";  break;
                        case 4:     $estado_nombre = "Reposo";      break;
                        case 5:     $estado_nombre = "Suspendido";      break;
                    }
                    $matriz_personal_ivic[$i]->estado_nombre = $estado_nombre;            
                }
            }
            
            //echo "<br>matriz_personal_ivic *<pre>"; print_r($matriz_personal_ivic); echo "</pre>*";
            //[0] => stdClass Object
            //    (
            //        [id] => 1718
            //        [cedula] => 5452253
            //        [nombres] => Brigida
            //        [apellidos] => Perez De Martinez
            //        [id_cargo] => 295
            //        [id_gerencia] => 27
            //        [estado] => 1
            //        [imagen_nombre] => 5452253.jpg
            //        [carnet_codigo] => 61664
            //        [cargo_nombre] => PENSION SOBREVIVIENTE JUBILADO
            //        [gerencia_nombre] => OFICINA DE GESTION HUMANA
            //        [estado_nombre] => Activo
            //    )            
            
            if($formato == "pdf"){
                $this->load->view('personal_ivic/reporte_pdf_lista', $data);    
            }
            if($formato == "excel"){
                $this->load->view('personal_ivic/reporte_excel_lista.php', $data);
            }            
 
        }        
    }
    
    public function subir_archivo($id){
        $logged = $this->Conf_usuarios_model->isLogged();
        $id_conf_roles_es_2 = $this->session->userdata('id_conf_roles_es_2');
        if($logged == TRUE && $id_conf_roles_es_2 == true){
                
            $data['id']             = $id;
            
            $data['id_usuario']    = $id;
            
            $data['oper'] = "subir_archivo";

            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('plantilla/menu');
            
            $this->load->view('personal_ivic/v_personal_ivic_subir_archivos.php', $data);
            $this->load->view('plantilla/b_footer_llamados');
            $this->load->view('personal_ivic/v_footer_llamados');
            $this->load->view('personal_ivic/ajax_archivos');
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
            $matriz_personal_ivic = $this->Personal_ivic_model->personal_ivic_buscar_2($id);
            
            /*
            $ruta = "images/personal_ivic/".$fila_reg[0]->imagen_nombre; //echo "ruta *".$ruta."*";
            if(file_exists($ruta) == true){
            }else{
                //echo "No encontro la ruta  *".$ruta."*";
                $fila_reg[0]->imagen_nombre = "sin_imagen.png";
            }            */
            
            $imagen_nombre = $matriz_personal_ivic[0]->imagen_nombre;            
            if($imagen_nombre != ""){
                $ruta = "images/personal_ivic/".$imagen_nombre;                
                if(file_exists($ruta) == true){
                    unlink($ruta);    
                }
            }
            
            $extension = pathinfo($_FILES['archivo']['name'], PATHINFO_EXTENSION);
            //$imagen_nombre = time()."_".$id.".".$extension;
            $imagen_nombre = $matriz_personal_ivic[0]->cedula.".".$extension;
            $ruta = "images/personal_ivic/".$imagen_nombre;   //echo "<br /> RUTA *".$ruta."*";
            $archivo_cargado = move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta);
            if($archivo_cargado){       //echo json_encode("PASO 1");
                $this->Personal_ivic_model->personal_ivic_editar_2($id, $imagen_nombre);
                $mensaje = "Actualizó la imagen del personal_ivic con id ".$id.", con el nombre de imagen ".$imagen_nombre;
                $mensaje_2 = $mensaje;
                $this->insertar_bitacora_2("personal_ivic", $mensaje, $mensaje_2);
                $valido = 1;
            }else{      //echo json_encode("PASO 2");
                $valido = 0;
            }
            echo json_encode($valido);
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

    public function get_personal_ivic_buscar_2(){
            $id     = $this->input->post('id');
            $matriz_personal_ivic = $this->Personal_ivic_model->personal_ivic_buscar_2($id);
            echo json_encode($matriz_personal_ivic);
    }    
    
    public function get_personal_ivic_buscar_4(){
            $cedula         = $this->input->post('cedula');
            $resultados     = $this->Personal_ivic_model->personal_ivic_buscar_4($cedula); //echo "resultados *"; print_r($resultados); echo "*";
            echo json_encode($resultados);
    }
    
    public function get_personal_ivic_buscar_5(){
            $carnet_codigo    = $this->input->post('carnet_codigo');
            $id     = $this->input->post('id');
            $resultados     = $this->Personal_ivic_model->personal_ivic_buscar_5($carnet_codigo, $id); //echo "resultados *"; print_r($resultados); echo "*";
            echo json_encode($resultados);
    }  

    public function get_personal_ivic_buscar_6(){
            $carnet_codigo    = $this->input->post('carnet_codigo');
            $resultados     = $this->Personal_ivic_model->personal_ivic_buscar_6($carnet_codigo); //echo "resultados *"; print_r($resultados); echo "*";
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
    
    // RECIBE LA FECHA EN FORMATO "dd-mm-YYYY" Y LA REGRESA EN "YYYY-mm-dd"
    // RECIBE LA FECHA EN FORMATO "YYYY-mm-dd" Y LA REGRESA EN "dd-mm-YYYY"
    private function ordena_fecha_5($fecha){
            $parte2 = explode("-", $fecha);
            return $parte2[2]."-".$parte2[1]."-".$parte2[0];
    } 
    
}
