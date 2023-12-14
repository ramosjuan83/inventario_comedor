<?php
class Conf_roles_model extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }
  /*
    //conf_roles
    //    id_rol
    //    nombre
    public function conf_roles_buscar_2($id_rol){
            $sql = "SELECT * 
                    FROM conf_roles
                    WHERE
                        id_rol = '".$id_rol."'
                    ORDER BY id_rol ASC";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }    
*/    
    //conf_roles
    //    id_rol
    //    nombre
    public function conf_roles_buscar_3(){
            $sql = "SELECT * FROM conf_roles ORDER BY id_rol ASC";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }    
/*    
     

    
    //______________________________________________________________________________________________________
    //conf_usuarios_roles
    //______________________________________________________________________________________________________

    //conf_usuarios_roles
    //    conf_usuarios_id_usuario
    //    conf_roles_id
    public function conf_usuarios_roles_num_reg_2($conf_usuarios_id_usuario, $conf_roles_id){
            $sql = "SELECT conf_usuarios_id_usuario FROM conf_usuarios_roles
                    WHERE 
                            conf_usuarios_id_usuario = '".$conf_usuarios_id_usuario."'
                        AND conf_roles_id = '".$conf_roles_id."'
                    ";      //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            return $resultado->num_rows();
    }    
   */    
    
    //conf_usuarios_roles
    //    conf_usuarios_id_usuario
    //    conf_roles_id
    public function conf_usuarios_roles_buscar($conf_usuarios_id_usuario){
            $sql = "SELECT * FROM conf_usuarios_roles
                    WHERE   conf_usuarios_id_usuario = '".$conf_usuarios_id_usuario."'
                   ";           //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }
    
    //conf_usuarios_roles
    //    conf_usuarios_id_usuario
    //    conf_roles_id    
    public function conf_usuarios_roles_buscar_2($conf_usuarios_id_usuario, $conf_roles_id){
            $sql = "SELECT * FROM conf_usuarios_roles
                    WHERE   conf_usuarios_id_usuario = '".$conf_usuarios_id_usuario."'
                        AND conf_roles_id = '".$conf_roles_id."'
                   ";       //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }
/*
    //conf_usuarios_roles
    //    conf_usuarios_id_usuario
    //    conf_roles_id
    //conf_roles
    //    id_rol
    //    nombre    
    public function conf_usuarios_roles_buscar_3($conf_usuarios_id_usuario){
            $sql = "SELECT 
                          conf_usuarios_roles.conf_roles_id AS conf_usuarios_roles_conf_roles_id
                        , conf_roles.id_rol AS conf_roles_id_rol
                        , conf_roles.nombre AS conf_roles_nombre
                    FROM conf_usuarios_roles, conf_roles
                    WHERE
                            conf_usuarios_roles.conf_roles_id = conf_roles.id_rol
                        AND conf_usuarios_roles.conf_usuarios_id_usuario = '".$conf_usuarios_id_usuario."'
                    ORDER BY conf_roles.id_rol ASC";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }    
    */
    //conf_usuarios_roles
    //    conf_usuarios_id_usuario
    //    conf_roles_id
    public function conf_usuarios_roles_insertar($conf_usuarios_id_usuario, $conf_roles_id){
            $sql = "
            INSERT INTO conf_usuarios_roles (conf_usuarios_id_usuario, conf_roles_id) VALUES
            ('".$conf_usuarios_id_usuario."', '".$conf_roles_id."')
            ";      //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);    //echo "<hr />resultado *".$resultado."*";
            return $this->db->insert_id();
    }

    //conf_usuarios_roles
    //    conf_usuarios_id_usuario
    //    conf_roles_id
    public function conf_usuarios_roles_eliminar($conf_usuarios_id_usuario){
            $sql = "
                    DELETE FROM conf_usuarios_roles WHERE conf_usuarios_id_usuario = '".$conf_usuarios_id_usuario."'
            ";      //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            return $resultado;
    }
    /*
    //conf_usuarios_roles
    //    conf_usuarios_id_usuario
    //    conf_roles_id
    public function conf_usuarios_roles_eliminar_2($conf_usuarios_id_usuario, $conf_roles_id){
            $sql = "
                    DELETE FROM conf_usuarios_roles 
                    WHERE 
                            conf_usuarios_id_usuario = '".$conf_usuarios_id_usuario."'
                        AND conf_roles_id = '".$conf_roles_id."'
            ";      //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            return $resultado;
    }    
*/
}