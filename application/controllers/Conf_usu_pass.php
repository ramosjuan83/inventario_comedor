<?php
require_once APPPATH.'controllers/Controlador_padre.php';
class Conf_usu_pass extends Controlador_padre {
    
    function __construct(){
        parent::__construct();
        $this->load->library('Session');
        $this->load->model('Conf_usuarios_model');
        $this->load->model('Conf_usu_pass_model');
        $this->load->model('Conf_bitacora_model');
        $this->load->model('Conf_roles_model');
    }

    public function editar_contrasena_como_administrador($id, $menu_origen){
        $logged = $this->Conf_usuarios_model->isLogged();
        $id_conf_roles_es_1 = $this->session->userdata('id_conf_roles_es_1');
        if($logged == TRUE && $id_conf_roles_es_1 == true){
            $fila_reg = $this->Conf_usuarios_model->conf_usuarios_buscar_2($id);   //echo "<pre>"; print_r($fila_reg); echo "</pre>";
            $data['conf_usuarios'] = $fila_reg[0];

            $data['menu_origen'] = $menu_origen;
            $data['oper'] = "editar_contrasena_como_administrador";
            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('plantilla/menu');
            $this->load->view('conf_usuarios/v_conf_usu_pass_frm', $data);
            $this->load->view('plantilla/footer');
        }else{
            $this->session->sess_destroy('username');
            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('login/v_login_1');
            $this->load->view('plantilla/footer');
        }
    }

    public function editar_guardar_contrasena_como_administrador(){
        
            $valor = "id_usuario"; 	if ( isset($_POST[$valor]) 	){	$parametros[$valor] = $_POST[$valor];                   }else{	$parametros[$valor]	= "";	}
            $valor = "pass_usu"; 	if ( isset($_POST[$valor]) 	){	$parametros[$valor] = $_POST[$valor];                   }else{	$parametros[$valor]	= "";	}

            $parametros["pass_usu"] = md5($parametros["pass_usu"]);

            $fecha_hora = date("Y-m-d H:i:s");
            $oper_realizada = $this->Conf_usu_pass_model->conf_usuarios_editar_2($parametros['id_usuario'], $parametros['pass_usu'], $fecha_hora);

            if ($oper_realizada){
                $mensaje = "Actualizó la Contraseña del usuario con id ".$parametros['id_usuario'];
                $mensaje_2 = "Actualizó la Contraseña".$this->calcula_datos_de_conf_usu_pass($parametros['id_usuario']);
                $s_mensaje = array(
                        'conf_usuarios_mensaje_tipo'         => 'alert-success',
                        'conf_usuarios_mensaje_contenido'    => 'Registros actualizado exitosamente, '.$mensaje_2
                );
                $this->session->set_userdata($s_mensaje);
                $this->insertar_bitacora_2("conf_usu_pass", $mensaje, $mensaje_2);
            }
            redirect('Conf_usuarios/listar/');

    }

    public function editar_contrasena_como_usuario($menu_origen){
        $logged = $this->Conf_usuarios_model->isLogged();
        if($logged == TRUE){

            $data['menu_origen'] = $menu_origen;
            
            $id = $this->session->userdata('iduser');
            $fila_reg = $this->Conf_usuarios_model->conf_usuarios_buscar_2($id);   //echo "<pre>"; print_r($fila_reg); echo "</pre>";
            $data['conf_usuarios'] = $fila_reg[0];
/*
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
*/
            $data['oper'] = "editar_contrasena_como_usuario";
            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('plantilla/menu');
            $this->load->view('conf_usuarios/v_conf_usu_pass_frm', $data);
            $this->load->view('plantilla/footer');
        }else{
            $this->session->sess_destroy('username');
            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('login/v_login_1');
            $this->load->view('plantilla/footer');
        }
    }   
    
    public function editar_guardar_contrasena_como_usuario(){
        
        $logged = $this->Conf_usuarios_model->isLogged();
        if($logged == TRUE){
        
            $valor = "id_usuario"; 	if ( isset($_POST[$valor]) 	){	$parametros[$valor] = $_POST[$valor];                   }else{	$parametros[$valor]	= "";	}
            $valor = "pass_usu"; 	if ( isset($_POST[$valor]) 	){	$parametros[$valor] = $_POST[$valor];                   }else{	$parametros[$valor]	= "";	}

            $valor = "menu_origen"; 	if ( isset($_POST[$valor]) 	){	$menu_origen = $_POST[$valor];                          }else{	$menu_origen	= "";	}

            $parametros["pass_usu"] = md5($parametros["pass_usu"]);

            $data['menu_origen'] = $menu_origen;

            $fecha_hora = date("Y-m-d H:i:s");
            $oper_realizada = $this->Conf_usu_pass_model->conf_usuarios_editar_2($parametros['id_usuario'], $parametros['pass_usu'], $fecha_hora);

            if ($oper_realizada){
                $mensaje = "Actualizó la Contraseña del usuario con id ".$parametros['id_usuario'];
                $mensaje_2 = "Actualizó la Contraseña".$this->calcula_datos_de_conf_usu_pass($parametros['id_usuario']);
                $s_mensaje = array(
                        'conf_usuarios_mensaje_tipo'         => 'alert-success',
                        'conf_usuarios_mensaje_contenido'    => 'Registros actualizado exitosamente, '.$mensaje_2
                );
                $this->session->set_userdata($s_mensaje);
                $this->insertar_bitacora_2("conf_usu_pass", $mensaje, $mensaje_2);
            }

            $data['ruta_llamados_head'] = "plantilla/llamados_head/llamados_head_basicos.php";
            $this->load->view('plantilla/header', $data);
            $this->load->view('plantilla/menu');
            $this->load->view('conf_usuarios/v_conf_usu_pass_frm_2', $data);
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
    public function editar_guardar_para_reiniciar_password(){
        $valor = "id_usuario";                  if ( isset($_POST[$valor]) 	){	$parametros[$valor] = $_POST[$valor];                   }else{	$parametros[$valor]	= "";	}
        $valor = "pass_usu";                    if ( isset($_POST[$valor]) 	){	$parametros[$valor] = $_POST[$valor];                   }else{	$parametros[$valor]	= "";	}
        $valor = "olvido_pass_identificador"; 	if ( isset($_POST[$valor]) 	){	$olvido_pass_identificador = $_POST[$valor];            }else{	$olvido_pass_identificador	= "";	}

        $matriz_conf_usu_pass = $this->Conf_usu_pass_model->conf_usu_pass_buscar_5($olvido_pass_identificador);
        if($matriz_conf_usu_pass != false){ //ESTO ES POR SEGURIDAD PARA QUE SOLO SE MODIFIQUE SI SE SABE EL $olvido_pass_identificador
            $parametros["pass_usu"] = md5($parametros["pass_usu"]);
            
            $fecha_hora = date("Y-m-d H:i:s");  //2019-07-17 14:14:27
            $oper_realizada = $this->Conf_usu_pass_model->conf_usuarios_editar_2($parametros['id_usuario'], $parametros['pass_usu'], $fecha_hora);
            if ($oper_realizada){
                $mensaje = "Actualizó la Contraseña correctamente. Por favor inicie sesión con su nueva contraseña.";
                $s_mensaje = array(
                        'login_mensaje_tipo'  => 'alert-success',
                        'login_mensaje_contenido'    => $mensaje
                );
                $this->session->set_userdata($s_mensaje);
                //echo "PASO A1";
                redirect('');
            }            
        }else{
            redirect('');
        }        

    }    
*/    
    private function calcula_datos_de_conf_usu_pass($id_usuario){
        $matriz_conf_usuarios = $this->Conf_usuarios_model->conf_usuarios_buscar_2($id_usuario);

        $texto = ", del usuario (".$matriz_conf_usuarios[0]->ci_usu.") ".$matriz_conf_usuarios[0]->nombre_usu." ".$matriz_conf_usuarios[0]->apellido_usu;

        return $texto;
    }    
    
    public function get_conf_usu_pass_buscar_3(){
            $usuario_usu    = $this->input->post('usuario_usu');
            $id_usuario     = $this->input->post('id_usuario');
            $resultados     = $this->Conf_usu_pass_model->conf_usu_pass_buscar_3($usuario_usu, $id_usuario); //echo "resultados *"; print_r($resultados); echo "*";
            echo json_encode($resultados);
    }

    public function get_conf_usu_pass_buscar_4(){
            $usuario_usu    = $this->input->post('usuario_usu');
            $resultados     = $this->Conf_usu_pass_model->conf_usu_pass_buscar_4($usuario_usu); //echo "resultados *"; print_r($resultados); echo "*";
            echo json_encode($resultados);
    }    

}