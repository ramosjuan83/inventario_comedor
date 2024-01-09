<?php
class Conf_usu_pass_model extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }
/*
    //conf_usu_pass
    //    id_usuario
    //    usuario_usu
    //    pass_usu
    //    olvido_pass_identificador
    //    creado
    //    modificado
    public function conf_usu_pass_num_reg($id_usuario){
            $sql = "
                    SELECT id_usuario FROM conf_usu_pass WHERE
                            id_usuario = '".$id_usuario."'
            "; //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            return $resultado->num_rows();
    }    
*/    
    //conf_usu_pass
    //    id_usuario
    //    usuario_usu
    //    pass_usu
    //    olvido_pass_identificador
    //    creado
    //    modificado
    public function conf_usu_pass_buscar($id_usuario){
            $sql = "SELECT * FROM conf_usu_pass
                    WHERE id_usuario = '".$id_usuario."'";  //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }
/*
    //conf_usu_pass
    //    id_usuario
    //    usuario_usu
    //    pass_usu
    //    olvido_pass_identificador
    //    creado
    //    modificado
    public function conf_usu_pass_buscar_2($usuario_usu, $pass_usu){
            $sql = "SELECT * FROM conf_usu_pass
                    WHERE 
                        usuario_usu = '".$usuario_usu."'
                        AND pass_usu = '".$pass_usu."' ";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }
*/    
    //conf_usu_pass
    //    id_usuario
    //    usuario_usu
    //    pass_usu
    //    olvido_pass_identificador
    //    creado
    //    modificado
    public function conf_usu_pass_buscar_3($usuario_usu, $id_usuario){
            $sql = "SELECT * FROM conf_usu_pass
                    WHERE 
                         usuario_usu = '".$usuario_usu."' ";
            if($id_usuario > 0){
                $sql .= " AND id_usuario <> '".$id_usuario."'";                
            } //return $sql;
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }
    
    //conf_usu_pass
    //    id_usuario
    //    usuario_usu
    //    pass_usu
    //    olvido_pass_identificador
    //    creado
    //    modificado
    public function conf_usu_pass_buscar_4($usuario_usu){
            $sql = "SELECT * FROM conf_usu_pass
                    WHERE 
                         usuario_usu = '".$usuario_usu."' ";
            //return $sql;
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }
/*    
    //conf_usu_pass
    //    id_usuario
    //    usuario_usu
    //    pass_usu
    //    olvido_pass_identificador
    //    creado
    //    modificado
    public function conf_usu_pass_buscar_5($olvido_pass_identificador){
            $sql = "SELECT * FROM conf_usu_pass
                    WHERE 
                         olvido_pass_identificador = '".$olvido_pass_identificador."' ";
            //return $sql;
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }    
    */


    //conf_usu_pass
    //    id_usuario
    //    usuario_usu
    //    pass_usu
    //    olvido_pass_identificador
    //    creado
    //    modificado    
    //conf_usuarios
    //    id_usuario
    //    ci_usu
    //    nombre_usu
    //    apellido_usu
    //    direccion_usu
    //    telefono_1
    //    telefono_2
    //    correo
    //    estado
    //    imagen_nombre   
    public function conf_usu_pass_buscar_6($usuario_usu, $pass_usu){
            $sql = "SELECT 
                            conf_usu_pass.usuario_usu AS conf_usu_pass_usuario_usu                
                        ,   conf_usuarios.id_usuario AS conf_usuarios_id_usuario
                        ,   conf_usuarios.ci_usu AS conf_usuarios_ci_usu
                        ,   conf_usuarios.nombre_usu AS conf_usuarios_nombre_usu
                        ,   conf_usuarios.apellido_usu AS conf_usuarios_apellido_usu
                    FROM conf_usu_pass, conf_usuarios
                    WHERE 
                            conf_usu_pass.usuario_usu   = '".$usuario_usu."'
                        AND conf_usu_pass.pass_usu      = '".$pass_usu."'
                        AND conf_usu_pass.id_usuario = conf_usuarios.id_usuario
                    ";      //echo "<br />sql <pre>*".$sql."*</pre>";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    } 
    
    //conf_usu_pass
    //    id_usuario
    //    usuario_usu
    //    pass_usu
    //    olvido_pass_identificador
    //    creado
    //    modificado
    public function conf_usu_pass_insertar($id_usuario, $usuario_usu, $pass_usu, $creado){
            if($usuario_usu == ""){ $usuario_usu = 'NULL';   }else{ $usuario_usu = "'".$usuario_usu."'";   }
            $sql = "
            INSERT INTO conf_usu_pass (id_usuario, usuario_usu, pass_usu, creado) VALUES
            ('".$id_usuario."', ".$usuario_usu.", '".$pass_usu."', '".$creado."')
            ";      //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);    //echo "<hr />resultado *".$resultado."*";
            //return $resultado;
            return $this->db->insert_id();
    }
    
    //conf_usu_pass
    //    id_usuario
    //    usuario_usu
    //    pass_usu
    //    olvido_pass_identificador
    //    creado
    //    modificado
    public function conf_usuarios_editar($id_usuario, $usuario_usu){
            $sql = "
                    UPDATE conf_usu_pass SET
                           usuario_usu           =   '".$usuario_usu."'
                    WHERE id_usuario = '".$id_usuario."'
            ";      //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            return $resultado;
    }

    //conf_usu_pass
    //    id_usuario
    //    usuario_usu
    //    pass_usu
    //    olvido_pass_identificador
    //    creado
    //    modificado
    public function conf_usuarios_editar_2($id_usuario, $pass_usu, $modificado){
            $sql = "
                    UPDATE conf_usu_pass SET
                           pass_usu           =   '".$pass_usu."'
                        ,  modificado           =   '".$modificado."'
                    WHERE id_usuario = '".$id_usuario."'
            ";      //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            return $resultado;
    }
/*
    //conf_usu_pass
    //    id_usuario
    //    usuario_usu
    //    pass_usu
    //    olvido_pass_identificador
    //    creado
    //    modificado
    //conf_usuarios
    //    id_usuario
    //    ci_usu
    //    nombre_usu
    //    apellido_usu
    //    direccion_usu
    //    telefono_1
    //    telefono_2
    //    correo
    //    estado    
    public function conf_usu_pass_editar_3($id_usuario, $olvido_pass_identificador){
            $sql = "
                    UPDATE conf_usu_pass SET
                           conf_usu_pass.olvido_pass_identificador           =   '".$olvido_pass_identificador."'
                    WHERE id_usuario = '".$id_usuario."'
            ";      //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            return $resultado;
    }    
    
    //OTRAS FUNCIONES --------------------------------------------------------------
*/    
    //conf_usu_pass
    //    id_usuario
    //    usuario_usu
    //    pass_usu
    //    olvido_pass_identificador
    //    creado
    //    modificado
    public function getLogin($user_sigalsx4,$pass_sigalsx4){

        $data = array(
            'usuario_usu' => $user_sigalsx4,
            'pass_usu' => $pass_sigalsx4
//            'pass_ase' => md5($pass_intra),
//            'stat_user' => 1
        );

        $query = $this->db->get_where('conf_usu_pass',$data);
        return $query->result_array();
    }    

 
}