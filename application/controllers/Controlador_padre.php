<?php
class Controlador_padre extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        $this->load->library('Session');
        $this->load->model('Conf_bitacora_model');
    }
    
    protected function insertar_bitacora_2($tabla_nombre, $accion, $accion_2){
            $id_usuario=$this->session->userdata('iduser');  //echo "id_usuario *".$id_usuario."*";
            $fecha = date("Y-m-d"); //  2000-04-07
            $hora  = date("H:i:s");	//$tiempo=date("h:m:s");
            if (	isset($_SERVER["HTTP_X_FORWARDED_FOR"])		){ //SI ESTA DEFINIDA PARA COMPATIBILIDAD DE NAVEGADORES
                    if($_SERVER["HTTP_X_FORWARDED_FOR"]){ $ip_usuario = $_SERVER["HTTP_X_FORWARDED_FOR"]; }
            }else{   $ip_usuario = $_SERVER["REMOTE_ADDR"];  }
            if($id_usuario > 0){
                //$this->Conf_bitacora_model->conf_bitacora_insertar($id_usuario, $fecha, $hora, $tabla_nombre, $accion, $ip_usuario);    
                $this->Conf_bitacora_model->conf_bitacora_insertar_2($id_usuario, $fecha, $hora, $tabla_nombre, $accion, $accion_2, $ip_usuario);
            }
    }
/*

    
    public function zerofill_2($entero, $largo){
        // Limpiamos por si se encontraran errores de tipo en las variables
        $entero = (int)$entero; //SI SE QUIERE USAR UN CARACTER COMENTAR ESTA LINEA Y COLOCARLE "trim()" AL VALOR ENTRANTE
        $largo = (int)$largo;

        $relleno = '';

        
        //* Determinamos la cantidad de caracteres utilizados por $entero
        //* Si este valor es mayor o igual que $largo, devolvemos el $entero
        //* De lo contrario, rellenamos con ceros a la izquierda del número
        if (strlen($entero) < $largo) {
            $relleno = str_repeat('0', $largo - strlen($entero));
        }
        return $relleno . $entero;
    }    
*/    
}
