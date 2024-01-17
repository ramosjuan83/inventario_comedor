<?php
require_once APPPATH.'controllers/Controlador_padre.php';
class Inv_articulo extends Controlador_padre {
    
    function __construct(){
        parent::__construct();
        $this->load->library('Session');
        $this->load->model('Conf_bitacora_model');
        $this->load->model('Conf_usuarios_model');
        $this->load->model('Inv_articulo_model');
        $this->load->model('Inv_unidad_medida_model');
        $this->load->model('Inv_tipo_articulo_model');
        $this->load->model('Inv_almacen_model');
        $this->load->model('Personal_ivic_model');
    }

    public function listar($memoria = 'false'){

        $logged = $this->Conf_usuarios_model->isLogged();
        $id_conf_roles_es_5 = $this->session->userdata('id_conf_roles_es_5');
        if($logged == TRUE && $id_conf_roles_es_5 == true){ 

                if($memoria == 'limpiar'){
                    $this->session->unset_userdata('inv_articulo_b_texto');
                }
                
                if (	isset ($_POST['b_texto'])	){
                        $b_texto = $_POST['b_texto'];
                        $s_busquedad = array(
                                'inv_articulo_b_texto' => $b_texto
                        );
                        $this->session->set_userdata($s_busquedad);
                }else{
                        $b_texto = "";
                        if( strlen($this->session->userdata('inv_articulo_b_texto')) > 0  ){
                            $b_texto = $this->session->userdata('inv_articulo_b_texto');
                        }
                }
                $b_texto = str_replace("'", "", $b_texto);
                
                if($memoria == 'cargo_ultima_pagina'){
                        $pagina_actual = $this->session->userdata('inv_articulo_ultima_pagina');    
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
                            'inv_articulo_ultima_pagina' => $pagina_actual
                        );
                        $this->session->set_userdata($s_lista);                    
                        $segmento = $this->uri->segment(4);                    
                }

                $this->load->helper('form');
                $this->load->library('pagination');
                $pages = 8; //Número de registros mostrados por páginas
                $config['base_url'] = base_url().'index.php/inv_articulo/listar/pagina'; // parametro base de la aplicación, si tenemos un .htaccess nos evitamos el index.php
                $total_rows = $this->Inv_articulo_model->inv_articulo_num_reg($b_texto);
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
                $dat_list = $this->Inv_articulo_model->inv_articulo_buscar($b_texto, $config['per_page'],$segmento);
// //echo "<br>dat_list *<pre>"; print_r($dat_list); echo "</pre>*";                
                
                if($dat_list != false){
                    for($i = 0; $i < count($dat_list); $i++){
                        // $articulo_id = $dat_list[$i]->id;  //echo "gerencias_id *".$gerencias_id."*";
                        // unset($matriz_comensales);                        
                        // $matriz_personal_ivic = $this->Personal_ivic_model->personal_ivic_buscar_9($articulo_id);
                        // if($matriz_personal_ivic == false){
                        //     $dat_list[$i]->esta_asociado_en_personal_ivic = false;
                        // }else{
                        //     $dat_list[$i]->esta_asociado_en_personal_ivic = true;
                        // }
                        $dat_list[$i]->esta_asociado_en_personal_ivic = false;   
                    }       
                              
                } 
// //echo "<br>dat_list *<pre>"; print_r($dat_list); echo "</pre>*";
                
                
//                 //Busco los campos de paginacion
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
                $this->load->view('inv_articulo/v_inv_articulo_listar', $dat_list);
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
        if($logged == TRUE && $id_conf_roles_es_5 == true){

            $matriz_tipo_articulos                     = $this->Inv_tipo_articulo_model->inv_tipo_articulo_buscar_3();
            $matriz_unidades                     = $this->Inv_unidad_medida_model->inv_unidad_medida_buscar_3();
            //$matriz_almacenes                     = $this->Inv_almacen_model->inv_almacen_buscar_3();


            $data['matriz_unidades']             = $matriz_unidades;
            //$data['matriz_almacenes']             = $matriz_almacenes;
            $data['matriz_tipo_articulos'] = $matriz_tipo_articulos;

            $data['oper'] = "agregar";
            
            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos2.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('plantilla/menu');
            $this->load->view('inv_articulo/v_inv_articulo_frm', $data);
            $this->load->view('plantilla/footer');       
            
            //necesarios para subir archivo
            $this->load->view('plantilla/b_footer_llamados');
            $this->load->view('personal_ivic/v_footer_llamados');
            $this->load->view('personal_ivic/ajax_archivos');
            $this->load->view('plantilla/b_footer_cierre');
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
            $valor = "codigo";          if ( isset($_POST[$valor])              ){	$codigo = ucfirst( $_POST[$valor] );	}else{	$codigo	= "";	}        
            $valor = "nombre";          if ( isset($_POST[$valor])              ){	$nombre = ucfirst( $_POST[$valor] );	}else{	$nombre	= "";	}
            $valor = "observacion";          if ( isset($_POST[$valor])              ){	$observacion = ucfirst( $_POST[$valor] );	}else{	$observacion	= "";	}
            $valor = "id_tipo_articulo";          if ( isset($_POST[$valor])              ){	$id_tipo_articulo = ucfirst( $_POST[$valor] );	}else{	$id_tipo_articulo	= "";	}
            $valor = "id_unidad_medida";          if ( isset($_POST[$valor])              ){	$id_unidad_medida = ucfirst( $_POST[$valor] );	}else{	$id_unidad_medida	= "";	}
           // $valor = "id_almacen";          if ( isset($_POST[$valor])              ){	$id_almacen = ucfirst( $_POST[$valor] );	}else{	$id_almacen	= "";	}

            $codigo        = $this->convierte_texto($codigo);
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
                    $id = $this->Inv_articulo_model->inv_articulo_insertar($codigo,$nombre,$id_unidad_medida,$id_tipo_articulo,$observacion);
                    if ($id > 0){
                        $this->get_subir_archivo($id);
                        $mensaje = "Inserto en artículo con id ".$id;
                        $mensaje_2 = "Inserto el artículo ".$nombre;
                        $s_mensaje = array(
                                'inv_articulo_mensaje_tipo'         => 'alert-success',
                                'inv_articulo_mensaje_contenido'    => 'Puede asociar una imagen al artículo, '.$mensaje_2
                        );
                        $this->session->set_userdata($s_mensaje);
                        $this->insertar_bitacora_2("inv_articulo", $mensaje, $mensaje_2);
                        redirect('inv_articulo/listar/cargo_ultima_pagina');
                        //redirect('Inv_articulo/subir_archivo/'.$id);
                    }else{
                        redirect('inv_articulo/agregar');
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
        if($logged == TRUE && $id_conf_roles_es_5 == true){

            
            $matriz_unidades                     = $this->Inv_unidad_medida_model->inv_unidad_medida_buscar_3();
            //$matriz_almacenes                     = $this->Inv_almacen_model->inv_almacen_buscar_3();
            $matriz_tipo_articulos                     = $this->Inv_tipo_articulo_model->inv_tipo_articulo_buscar_3();


            $data['matriz_unidades']             = $matriz_unidades;
            //$data['matriz_almacenes']            = $matriz_almacenes;
            $data['matriz_tipo_articulos'] = $matriz_tipo_articulos;
            
            $fila_reg = $this->Inv_articulo_model->inv_articulo_buscar_2($id);   //echo "<pre>"; print_r($fila_reg); echo "</pre>";
            $data['fila_registro'] = $fila_reg[0]; 
            $data['oper'] = "editar";

            //VERIFICO SI LA IMAGEN EXISTE SI NO QUE HABrA LA IMAGEN POR DEFECTO
            //$ruta = base_url("images/personal_ivic/").$fila_reg[0]->imagen_nombre; //echo "ruta *".$ruta."*";
            $ruta = "images/articulo/".$fila_reg[0]->imagen_articulo; //echo "ruta *".$ruta."*";
            if(file_exists($ruta) == true){
            }else{
                //echo "No encontro la ruta  *".$ruta."*";
                $fila_reg[0]->imagen_nombre = "sin_imagen.png";
            }

            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos2.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('plantilla/menu');
            $this->load->view('inv_articulo/v_inv_articulo_frm', $data);
            $this->load->view('plantilla/footer');

            //necesarios para subir archivo
            $this->load->view('plantilla/b_footer_llamados');
            $this->load->view('personal_ivic/v_footer_llamados');
            $this->load->view('personal_ivic/ajax_archivos');
            $this->load->view('plantilla/b_footer_cierre');

        }else{
            $this->session->sess_destroy('username');
            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos2.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('login/v_login_1');
            $this->load->view('plantilla/footer');
        }
    }

    public function subir_archivo($id){
        $logged = $this->Conf_usuarios_model->isLogged();
        $id_conf_roles_es_5 = $this->session->userdata('id_conf_roles_es_5');
        if($logged == TRUE && $id_conf_roles_es_5 == true){
                
            $data['id']             = $id;
            
            $data['id_usuario']    = $id;
            
            $data['oper'] = "subir_archivo";

            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos2.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('plantilla/menu');
            
           $this->load->view('inv_articulo/v_inv_articulo_subir_archivos.php', $data);
            $this->load->view('plantilla/b_footer_llamados');
            $this->load->view('personal_ivic/v_footer_llamados');
            $this->load->view('personal_ivic/ajax_archivos');
            $this->load->view('plantilla/b_footer_cierre');
            
            
        }else{
            $this->session->sess_destroy('username');
            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos2.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('login/v_login_1');
            $this->load->view('plantilla/footer');
        }
    }

    public function get_subir_archivo($id){
        //$id = $this->input->post('id');


        $matriz_articulo = $this->Inv_articulo_model->inv_articulo_buscar_2($id);
        
        /*
        $ruta = "images/personal_ivic/".$fila_reg[0]->imagen_nombre; //echo "ruta *".$ruta."*";
        if(file_exists($ruta) == true){
        }else{
            //echo "No encontro la ruta  *".$ruta."*";
            $fila_reg[0]->imagen_nombre = "sin_imagen.png";
        }            */
        
        $imagen_nombre = $matriz_articulo[0]->imagen_articulo;            
        if($imagen_nombre != ""){
            $ruta = "images/articulo/".$imagen_nombre;                
            if(file_exists($ruta) == true){
                unlink($ruta);    
            }
        }
        
        $extension = pathinfo($_FILES['archivo']['name'], PATHINFO_EXTENSION);
        //$imagen_nombre = time()."_".$id.".".$extension;
        $imagen_nombre = $matriz_articulo[0]->id.".".$extension;
        $ruta = "images/articulo/".$imagen_nombre;   //echo "<br /> RUTA *".$ruta."*";
        $archivo_cargado = move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta);
        
        if($archivo_cargado){       //echo json_encode("PASO 1");
            $this->Inv_articulo_model->inv_articulo_editar_2($id, $imagen_nombre);
            $mensaje = "Actualizó la imagen del artículo con id ".$id.", con el nombre de imagen ".$imagen_nombre;
            $mensaje_2 = $mensaje;
            $this->insertar_bitacora_2("articulo", $mensaje, $mensaje_2);
            $valido = 1;
        }else{      //echo json_encode("PASO 2");

            $valido = 0;
        }
        echo json_encode($valido);
}    

    public function editar_guardar(){
        $logged = $this->Conf_usuarios_model->isLogged();
        if($logged == TRUE){

            
            $valor = "id";              if ( isset($_POST[$valor]) 	){	$id = $_POST[$valor];                   }else{	$id	= "";	}
            $valor = "codigo";          if ( isset($_POST[$valor])              ){	$codigo = ucfirst( $_POST[$valor] );	}else{	$codigo	= "";	}
            $valor = "nombre";          if ( isset($_POST[$valor])              ){	$nombre = ucfirst( $_POST[$valor] );	}else{	$nombre	= "";	}
            $valor = "observacion";          if ( isset($_POST[$valor])              ){	$observacion = ucfirst( $_POST[$valor] );	}else{	$observacion	= "";	}
            $valor = "id_tipo_articulo";              if ( isset($_POST[$valor]) 	){	$id_tipo_articulo = $_POST[$valor];                   }else{	$id_tipo_articulo	= "";	}
            $valor = "id_unidad_medida";              if ( isset($_POST[$valor]) 	){	$id_unidad_medida = $_POST[$valor];                   }else{	$id_unidad_medida	= "";	}
            //$valor = "id_almacen";              if ( isset($_POST[$valor]) 	){	$id_almacen = $_POST[$valor];                   }else{	$id_almacen	= "";	}
            $valor = "imagen_articulo";              if ( isset($_POST[$valor]) 	){	$imagen_articulo = $_POST[$valor];                   }else{	$imagen_articulo	= "";	}

            $codigo        = $this->convierte_texto($codigo);
            $nombre        = $this->convierte_texto($nombre);

       
            
            
            $valido = true;
            if($valido == true){
                $oper_realizada = $this->Inv_articulo_model->inv_articulo_editar($id, $codigo, $nombre, $id_unidad_medida,$id_tipo_articulo,$observacion,$imagen_articulo);
                //echo "oper_realizada *".$oper_realizada."*";
                $this->get_subir_archivo($id);
                if ($oper_realizada){
                    $mensaje = "Actualizó el artículo con id ".$id;
                    $mensaje_2 = "Actualizó el Artículo ".$nombre;
                    $s_mensaje = array(
                            'inv_articulo_mensaje_tipo'  => 'alert-success',
                            'inv_articulo_mensaje_contenido'    => 'Registros actualizado exitosamente, '.$mensaje_2
                    );
                    $this->session->set_userdata($s_mensaje);
                    $this->insertar_bitacora_2("inv_articulo", $mensaje, $mensaje_2);

                    redirect('inv_articulo/listar/cargo_ultima_pagina');
                }else{
                    redirect('inv_articulo/editar');
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
                
                $matriz_articulo = $this->Inv_articulo_model->inv_articulo_buscar_2($id);
                $articulo_nombre = $matriz_articulo[0]->nombres;
                
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
                    $oper_realizada = $this->Inv_articulo_model->inv_articulo_eliminar($id);
                    if ($oper_realizada){
                            $mensaje = "Eliminó el unidad medida con id ".$id;
                            $mensaje_2 = "Eliminó el unidad medida ".$articulo_nombre;
                            $s_mensaje = array(
                                    'inv_articulo_mensaje_tipo'         => 'alert-success',
                                    'inv_articulo_mensaje_contenido'    => 'Registros eliminado exitosamente, '.$mensaje_2
                            );
                            $this->session->set_userdata($s_mensaje);
                            $this->insertar_bitacora_2("inv_articulo", $mensaje, $mensaje_2);
                    }                
                }
                redirect('inv_articulo/listar/cargo_ultima_pagina');                
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
    
    public function get_inv_articulo_buscar_5(){
            $nombre     = $this->input->post('nombre');
            $id         = $this->input->post('id');
            $resultados     = $this->Inv_articulo_model->inv_articulo_buscar_5($nombre, $id); //echo "resultados *"; print_r($resultados); echo "*";
            echo json_encode($resultados);
    }

    public function get_inv_articulo_buscar_6(){
            $nombre     = $this->input->post('nombre');
            $resultados = $this->Inv_articulo_model->inv_articulo_buscar_6($nombre); //echo "resultados *"; print_r($resultados); echo "*";
            echo json_encode($resultados);
    }  

    public function get_inv_articulo_buscar_8(){

        $codigo     = $this->input->post('codigo');
        $id         = $this->input->post('id');
        $resultados     = $this->Inv_articulo_model->inv_articulo_buscar_8($codigo, $id); //echo "resultados *"; print_r($resultados); echo "*";
        echo json_encode($resultados);
    }
    
    public function get_inv_articulo_buscar_7(){
        $codigo     = $this->input->post('codigo');
        $resultados = $this->Inv_articulo_model->inv_articulo_buscar_7($codigo); //echo "resultados *"; print_r($resultados); echo "*";
        echo json_encode($resultados);
    }
    
    public function reporte_form(){

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
            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos2.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('plantilla/menu');
            $this->load->view('reporte_articulo/v_articulo_frm_2', $data);
            $this->load->view('plantilla/footer');
        }else{
                    $this->session->sess_destroy('username');
                    $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos2.php";
                    $this->load->view('plantilla/header', $data);
                    $this->load->view('login/v_login_1');
                    $this->load->view('plantilla/footer');
        }
    } 


    public function llama_reporte_form($id_articulo,$id_almacen,$fecha_desde,$fecha_hasta,$id_tipo_articulo,$formato){

        // echo "id_articulo".$id_articulo."id_almacen".$id_almacen."fecha_desde".$fecha_desde."fecha_hasta".$fecha_hasta."fomato".$formato;
        // phpinfo();
        $logged = $this->Conf_usuarios_model->isLogged();
        if($logged == TRUE){


            $matriz_movimientos   = $this->Inv_articulo_model->inv_reporte_articulo($id_articulo,$id_almacen,$fecha_desde,$fecha_hasta,$id_tipo_articulo);
            
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
           
            if($id_tipo_articulo!=null && $id_tipo_articulo!='null'){
                $resulArt = $this->Inv_tipo_articulo_model->inv_tipo_articulo_buscar_2($id_tipo_articulo);
                $nombre_tipo_articulo=$resulArt[0]->nombre;
                
             }else{
                $nombre_tipo_articulo="null";
             }
           // phpinfo();
            //filtros
            $data['nombre_articulo']=$nombre_articulo;
            $data['nombre_almacen']=$nombre_almacen;
            $data['fecha_desde']=$fecha_desde;
            $data['fecha_hasta']=$fecha_hasta;
            $data['nombre_tipo_articulo']=$nombre_tipo_articulo;


            //detalles
            $data['matriz_articulos']  = $matriz_movimientos;

            if($formato == "pdf"){
                $this->load->view('reporte_articulo/reporte_articulos.php', $data);        
            }
            if($formato == "excel"){
                $this->load->view('reporte_articulo/reporte_articulo_excel.php', $data);
            }
        }    
    }    

}
