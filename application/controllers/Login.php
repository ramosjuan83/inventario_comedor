<?php
require_once APPPATH.'controllers/Controlador_padre.php';
class Login extends Controlador_padre{

    function __construct(){
        parent::__construct();
        $this->load->library('Session');
        $this->load->model('Conf_configuracion_model');
        $this->load->model('Conf_usuarios_model');
        $this->load->model('Conf_usu_pass_model');
        $this->load->model('Conf_roles_model');
        $this->load->model('Comensales_programacion_model');
        $this->load->model('Comensal_model');
        
    }

/*    
    //AREA INICIAL DEL SISTEMA
    public function area_inicial_fija(){
        echo "area_inicial_fija";
        $matriz_conf_configuracion = $this->Conf_configuracion_model->conf_configuracion_buscar_2();
        $nombre_de_archivo_login = $matriz_conf_configuracion['nombre_de_archivo_login'];
        
        $logged = $this->Conf_usuarios_model->isLogged();
        if($logged == TRUE){
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
            
            if($data['id_conf_roles_es_1'] == true || $data['id_conf_roles_es_4'] == true){
                redirect('Login/tablero_admin');
            }
            
            //Busco el estado del estudiante, para enviar mensaje en labarra de menu
            $usuario_mensaje = "";      $usuario_mensaje_color = "";
            $id_usuario=$this->session->userdata('iduser');
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
            
            //DETERMINO SI ES UN USUARIO SIN ROL ASIGNADO
            $tiene_rol_asignado = true;
            $matriz_conf_roles_model = $this->Conf_roles_model->conf_usuarios_roles_buscar($this->session->userdata('iduser'));
            if($matriz_conf_roles_model == false){
                $tiene_rol_asignado = false;
            }
            $data['tiene_rol_asignado'] = $tiene_rol_asignado;
            //FIN DE DETERMINO SI ES UN USUARIO SIN ROL ASIGNADO
            
            $nombre_de_archivo_inicio = $matriz_conf_configuracion['nombre_de_archivo_inicio'];
            
            $data['matriz_conf_configuracion'] = $this->Conf_configuracion_model->conf_configuracion_buscar_2();
            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('plantilla/menu');
            //$this->load->view('inicio/v_inicio');
            $this->load->view('inicio/'.$nombre_de_archivo_inicio);
            $this->load->view('plantilla/footer');
        }else{
            $this->session->sess_destroy('username');
            $data['matriz_conf_configuracion'] = $this->Conf_configuracion_model->conf_configuracion_buscar_2();
            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('login/'.$nombre_de_archivo_login);
            $this->load->view('plantilla/footer');
        } 
    } 
*/
        

    //tablero_admin
    //public function index_tablero(){
    public function index(){
        
        //$matriz_conf_configuracion = $this->Conf_configuracion_model->conf_configuracion_buscar_2();
        //$nombre_de_archivo_login = $matriz_conf_configuracion['nombre_de_archivo_login'];
        $nombre_de_archivo_login = "v_login_1";
        
//        $matriz_conf_usuarios_roles = $this->Conf_roles_model->conf_usuarios_roles_buscar_2($this->session->userdata('iduser'), 1);
//        if( $matriz_conf_usuarios_roles != false ){ $data['id_conf_roles_es_1'] = true;    }else{ $data['id_conf_roles_es_1'] = false; }
//        $matriz_conf_usuarios_roles = $this->Conf_roles_model->conf_usuarios_roles_buscar_2($this->session->userdata('iduser'), 2);
//        if( $matriz_conf_usuarios_roles != false ){ $data['id_conf_roles_es_2'] = true;    }else{ $data['id_conf_roles_es_2'] = false; }
//        $matriz_conf_usuarios_roles = $this->Conf_roles_model->conf_usuarios_roles_buscar_2($this->session->userdata('iduser'), 3);
//        if( $matriz_conf_usuarios_roles != false ){ $data['id_conf_roles_es_3'] = true;    }else{ $data['id_conf_roles_es_3'] = false; }
//        $matriz_conf_usuarios_roles = $this->Conf_roles_model->conf_usuarios_roles_buscar_2($this->session->userdata('iduser'), 4);
//        if( $matriz_conf_usuarios_roles != false ){ $data['id_conf_roles_es_4'] = true;    }else{ $data['id_conf_roles_es_4'] = false; }
//        $matriz_conf_usuarios_roles = $this->Conf_roles_model->conf_usuarios_roles_buscar_2($this->session->userdata('iduser'), 5);
//        if( $matriz_conf_usuarios_roles != false ){ $data['id_conf_roles_es_5'] = true;    }else{ $data['id_conf_roles_es_5'] = false; }

        $logged = $this->Conf_usuarios_model->isLogged();
        
        $motrar_tablero_administrador   = false;
        $motrar_tablero_profesor        = false;
        $motrar_tablero_estudiante      = false;
        
        if($logged == true){
        
            //if($data['id_conf_roles_es_1'] == true || $data['id_conf_roles_es_4'] == true){
                    //$motrar_tablero_administrador   = true;
                
//$id_conf_roles_es_1
            
            //DETERMINO SI ES UN USUARIO SIN ROL ASIGNADO
            $tiene_rol_asignado = true;
            $matriz_conf_roles_model = $this->Conf_roles_model->conf_usuarios_roles_buscar($this->session->userdata('iduser'));
            if($matriz_conf_roles_model == false){
                $tiene_rol_asignado = false;
            }
            $data['tiene_rol_asignado'] = $tiene_rol_asignado;
            //FIN DE DETERMINO SI ES UN USUARIO SIN ROL ASIGNADO            

            //$data['matriz_conf_configuracion'] = $this->Conf_configuracion_model->conf_configuracion_buscar_2();
            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('plantilla/menu');
            $this->load->view('inicio/v_inicio');

            //$this->load->view('inicio/'.$nombre_de_archivo_inicio);
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
    
/*    
    public function v_login_mensaje_1(){
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
        if($logged == TRUE){
            $data['matriz_conf_configuracion'] = $this->Conf_configuracion_model->conf_configuracion_buscar_2();
            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
            
            $this->load->view('plantilla/header', $data);
            $this->load->view('plantilla/menu');
            $this->load->view('login/v_login_mensaje_1');
            $this->load->view('plantilla/footer');
        }else{
            $this->session->sess_destroy('username');
            $data['matriz_conf_configuracion'] = $this->Conf_configuracion_model->conf_configuracion_buscar_2();
            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('login/'.$nombre_de_archivo_login);
            $this->load->view('plantilla/footer');
        }
    }    
*/
    //ESTO ES AUTENTICAR
    //public function sigalsx4_login(){
    public function autenticar(){
        $nombre_de_archivo_login = "v_login_1";
        
        $usuario_desabilitado = false;
        if(!isset($_POST['ingresar'])){
            $this->session->sess_destroy('username');
            $data['matriz_conf_configuracion'] = $this->Conf_configuracion_model->conf_configuracion_buscar_2();
            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('login/'.$nombre_de_archivo_login);
            $this->load->view('plantilla/footer');
        }else{
            $usuario = $this->input->post('user_intra');
            $pass = $this->input->post('pass_intra');
            //echo " pass *".$pass."*";
            $pass = md5($pass);
            //echo " pass *".$pass."*";
            //$isValidLogin = $this->Conf_usu_pass_model->getLogin($usuario,$pass); //pasamos los valores al modelo para que compruebe si existe el usuario con ese password

            $isValidLogin = false;
            $matriz_conf_usu_pass = $this->Conf_usu_pass_model->conf_usu_pass_buscar_6($usuario, $pass);
            if($matriz_conf_usu_pass != false){
                
                    $id_usuario = $matriz_conf_usu_pass[0]->conf_usuarios_id_usuario;
                
                    unset($matriz_conf_usuarios_roles);
                    $matriz_conf_usuarios_roles = $this->Conf_roles_model->conf_usuarios_roles_buscar_2($id_usuario, 1);
                    if( $matriz_conf_usuarios_roles != false ){ $id_conf_roles_es_1 = true;    }else{ $id_conf_roles_es_1 = false; }
                    unset($matriz_conf_usuarios_roles);
                    $matriz_conf_usuarios_roles = $this->Conf_roles_model->conf_usuarios_roles_buscar_2($id_usuario, 2);
                    if( $matriz_conf_usuarios_roles != false ){ $id_conf_roles_es_2 = true;    }else{ $id_conf_roles_es_2 = false; }
                    unset($matriz_conf_usuarios_roles);
                    $matriz_conf_usuarios_roles = $this->Conf_roles_model->conf_usuarios_roles_buscar_2($id_usuario, 3);
                    if( $matriz_conf_usuarios_roles != false ){ $id_conf_roles_es_3 = true;    }else{ $id_conf_roles_es_3 = false; }
                    $matriz_conf_usuarios_roles = $this->Conf_roles_model->conf_usuarios_roles_buscar_2($id_usuario, 4);
                    if( $matriz_conf_usuarios_roles != false ){ $id_conf_roles_es_4 = true;    }else{ $id_conf_roles_es_4 = false; }
                    $matriz_conf_usuarios_roles = $this->Conf_roles_model->conf_usuarios_roles_buscar_2($id_usuario, 5);
                    if( $matriz_conf_usuarios_roles != false ){ $id_conf_roles_es_5 = true;    }else{ $id_conf_roles_es_5 = false; }
                    
                    $sesion_data = array(
                      'iduser'    => $matriz_conf_usu_pass[0]->conf_usuarios_id_usuario
                    , 'ciuser'    => $matriz_conf_usu_pass[0]->conf_usuarios_ci_usu
                    , 'username'  => $matriz_conf_usu_pass[0]->conf_usuarios_nombre_usu
                    , 'userapell' => $matriz_conf_usu_pass[0]->conf_usuarios_apellido_usu
                    //'usertipo' => $rs_user->tipo_usu,
                    //'user' => $rs_user->usuario_usu
                    //'id_nucleo' => 1 //NUCLEO POR DEFECTO, MIENTRAS NO ESTA CONSTRUIDA EL QUE LO DEBE DE CARGAR
                    , 'id_conf_roles_es_1' => $id_conf_roles_es_1
                    , 'id_conf_roles_es_2' => $id_conf_roles_es_2
                    , 'id_conf_roles_es_3' => $id_conf_roles_es_3
                    , 'id_conf_roles_es_4' => $id_conf_roles_es_4
                    , 'id_conf_roles_es_5' => $id_conf_roles_es_5
                    );
                    $this->session->set_userdata($sesion_data);                    
                    
                    $isValidLogin = true;
            }
            if($isValidLogin){ // si existe el usuario, registramos las variables de sesión y abrimos la página de exito
                /*
                $dat_user = $this->Conf_usuarios_model->datos_user($usuario);
                foreach ($dat_user as $rs_user){
                    
                        $id_usuario = $rs_user->id_usuario;
                    
                        unset($matriz_conf_usuarios_roles);
                        $matriz_conf_usuarios_roles = $this->Conf_roles_model->conf_usuarios_roles_buscar_2($id_usuario, 1);
                        if( $matriz_conf_usuarios_roles != false ){ $id_conf_roles_es_1 = true;    }else{ $id_conf_roles_es_1 = false; }
                        unset($matriz_conf_usuarios_roles);
                        $matriz_conf_usuarios_roles = $this->Conf_roles_model->conf_usuarios_roles_buscar_2($id_usuario, 2);
                        if( $matriz_conf_usuarios_roles != false ){ $id_conf_roles_es_2 = true;    }else{ $id_conf_roles_es_2 = false; }
                        unset($matriz_conf_usuarios_roles);
                        $matriz_conf_usuarios_roles = $this->Conf_roles_model->conf_usuarios_roles_buscar_2($id_usuario, 3);
                        if( $matriz_conf_usuarios_roles != false ){ $id_conf_roles_es_3 = true;    }else{ $id_conf_roles_es_3 = false; }

                    
                        $sesion_data = array(
                          'iduser' => $rs_user->id_usuario
                        , 'ciuser' => $rs_user->ci_usu
                        , 'username' => $rs_user->nombre_usu
                        , 'userapell' => $rs_user->apellido_usu
                        //'usertipo' => $rs_user->tipo_usu,
                        //'user' => $rs_user->usuario_usu
                        //'id_nucleo' => 1 //NUCLEO POR DEFECTO, MIENTRAS NO ESTA CONSTRUIDA EL QUE LO DEBE DE CARGAR
                        , 'id_conf_roles_es_1' => $id_conf_roles_es_1
                        , 'id_conf_roles_es_2' => $id_conf_roles_es_2
                        , 'id_conf_roles_es_3' => $id_conf_roles_es_3
                        );
                        $this->session->set_userdata($sesion_data);
                }
                */
                $logged = $this->Conf_usuarios_model->isLogged();
                if($logged == TRUE){
                    
                    $mensaje = "Inicio session el usuario";
                    $id_usuario=$this->session->userdata('iduser');
                    $mensaje_2 = "Inicio session el usuario ".$this->calcula_datos_de_conf_usuarios($id_usuario);                    
                    $this->insertar_bitacora_2("", $mensaje, $mensaje_2);
                    
                    $this->actualiza_comensales_programados();
                    
                    redirect('/Login/');
                }else{
                    $usuario_desabilitado = true;
                    $data['usuario_desabilitado'] = $usuario_desabilitado;
                    $mensaje = "Intento ingresar el usuario, si estar activo en el sistema";
                    $this->insertar_bitacora_2("", $mensaje, $mensaje);                    
                    
                    //$this->load->view('sigalsx4_login_view');
                    //$data['matriz_conf_configuracion'] = $this->Conf_configuracion_model->conf_configuracion_buscar_2();
                    $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
                    $this->load->view('plantilla/header', $data);
                    $this->load->view('login/v_login_1');
                    $this->load->view('plantilla/footer');
                }
            }else{
                // si es erroneo, devolvemos un mensaje de error
//                $this->load->view('ifs_login_view_error');
                $error['error_pass'] = 0;
                //$this->load->view('sigalsx4_login_view', $error);
                //$data['matriz_conf_configuracion'] = $this->Conf_configuracion_model->conf_configuracion_buscar_2();
                $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
                $this->load->view('plantilla/header', $data);
                $this->load->view('login/v_login_1', $error);
                $this->load->view('plantilla/footer');

            }
        }
    }

    public function destroy(){
        //destruimos la sesión

        $mensaje = "Se cerro la session del usuario";
        $id_usuario=$this->session->userdata('iduser');
        $mensaje_2 = "Cerro la session el usuario ".$this->calcula_datos_de_conf_usuarios($id_usuario);
        $this->insertar_bitacora_2("", $mensaje, $mensaje_2);

        $sesion_data = array(
            'username' => FALSE,
        );
        $this->session->set_userdata($sesion_data);
        $this->session->sess_destroy('username');
        redirect('/Login/','Refresh');
    }

    private function calcula_datos_de_conf_usuarios($id_usuario){
        $matriz_conf_usuarios = $this->Conf_usuarios_model->conf_usuarios_buscar_2($id_usuario);

        $texto = "(".$matriz_conf_usuarios[0]->ci_usu.") ".$matriz_conf_usuarios[0]->nombre_usu." ".$matriz_conf_usuarios[0]->apellido_usu;

        return $texto;
    }    
    
    private function actualiza_comensales_programados(){
        $fecha = date("Y-m-d");
        $hora  = date("H:i:s"); 
        $matriz_comensales_programacion = $this->Comensales_programacion_model->comensales_programacion_buscar_3($fecha, $hora, 1);
        //echo "matriz_comensales_programacion *<pre>"; print_r($matriz_comensales_programacion); echo "</pre>*";
        //[0] => stdClass Object
        //    (
        //        [id] => 10
        //        [id_personal_ivic] => 1
        //        [id_personal_visitante] => 
        //        [id_comedor_comida_tipo] => 2
        //        [fecha] => 2023-06-24
        //        [hora] => 11:56:00
        //        [id_usuario] => 1
        //        [estatus] => 1
        //        [estatus_2] => 1
        //    )
        if($matriz_comensales_programacion != false){
            for($i = 0; $i < count($matriz_comensales_programacion); $i++){
                
                unset($matriz_Comensal);
                $matriz_Comensal = $this->Comensal_model->comensales_buscar_10($matriz_comensales_programacion[$i]->fecha, $matriz_comensales_programacion[$i]->id_comedor_comida_tipo, $matriz_comensales_programacion[$i]->id_personal_ivic, $matriz_comensales_programacion[$i]->id_personal_visitante, 1); //echo "cli_clientes_num_reg *".$cohorte_num_reg."*";
                if($matriz_Comensal == false){
                    $id = $this->Comensal_model->comensales_insertar($matriz_comensales_programacion[$i]->id_personal_ivic, $matriz_comensales_programacion[$i]->id_personal_visitante, $matriz_comensales_programacion[$i]->id_comedor_comida_tipo, $matriz_comensales_programacion[$i]->fecha, $matriz_comensales_programacion[$i]->hora, $matriz_comensales_programacion[$i]->id_usuario, '1');
                    if ($id > 0){
                        $this->Comensales_programacion_model->comensales_programacion_editar($matriz_comensales_programacion[$i]->id, 2);
                        $mensaje = "Inserto el Registro con id ".$id;
                        $mensaje_2 = "Inserto un registro que se encontraba programado de forma automatica";
                        $this->insertar_bitacora_2("comensal, comensales_programacion", $mensaje, $mensaje_2);                        
                    }                    
                }
            }            
        }

    }

}