<?php
class Conf_usuarios_model extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }


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
    public function conf_usuarios_num_reg($b_texto, $estado){
            $sql = "
                    SELECT conf_usuarios.id_usuario 
                    FROM conf_usuarios, conf_usu_pass WHERE
                    (
                            conf_usuarios.ci_usu LIKE '%".$b_texto."%'
                        OR  conf_usuarios.nombre_usu LIKE '%".$b_texto."%'
                        OR  conf_usuarios.apellido_usu LIKE '%".$b_texto."%'
                        OR  conf_usu_pass.usuario_usu LIKE '%".$b_texto."%'
                    ) AND conf_usuarios.id_usuario > 0 
                    AND conf_usuarios.id_usuario = conf_usu_pass.id_usuario
                    ";
            if($estado > 0){
                    $sql .= "
                        AND conf_usuarios.estado = '".$estado."' 
                    ";
            }
            //echo "<br />sql <pre>*".$sql."*</pre>";
            $resultado = $this->db->query($sql);
            return $resultado->num_rows();
    }

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
    public function conf_usuarios_num_reg_2($ci_usu){
            $sql = "SELECT id_usuario FROM conf_usuarios
                    WHERE ci_usu = '".$ci_usu."'
                        AND  (  ci_usu <> NUll  or ci_usu <> '' )
                        ";      //echo "<br />sql <pre>*".$sql."*</pre>";
            $resultado = $this->db->query($sql);
            return $resultado->num_rows();
    }

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
    public function conf_usuarios_num_reg_3($id_usuario, $ci_usu){
            $sql = "SELECT id_usuario FROM conf_usuarios
                    WHERE
                            (
                                        ci_usu = '".$ci_usu."'
                                AND  (  ci_usu <> NUll  or ci_usu <> '' )
                            )
                            AND id_usuario <> '".$id_usuario."'";      //echo "<br />sql <pre>*".$sql."*</pre>";
            $resultado = $this->db->query($sql);
            return $resultado->num_rows();
    }    

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
    //conf_usu_pass
    //    id_usuario
    //    usuario_usu
    //    pass_usu
    //    olvido_pass_identificador
    //    creado
    //    modificado    
    public function conf_usuarios_buscar($b_texto, $estado, $b_campo_ordenar, $b_orden, $por_pagina, $segmento){
            $sql = "SELECT conf_usuarios.* 
                    FROM conf_usuarios, conf_usu_pass WHERE
                    (
                            conf_usuarios.ci_usu LIKE '%".$b_texto."%'
                        OR  conf_usuarios.nombre_usu LIKE '%".$b_texto."%'
                        OR  conf_usuarios.apellido_usu LIKE '%".$b_texto."%'
                        OR  conf_usu_pass.usuario_usu LIKE '%".$b_texto."%'
                    ) AND conf_usuarios.id_usuario > 0 
                    AND conf_usuarios.id_usuario = conf_usu_pass.id_usuario
                    ";
            if($estado > 0){
                    $sql .= "
                        AND conf_usuarios.estado = '".$estado."' 
                    ";
            }
            if(strlen($b_campo_ordenar) > 0){
                $sql .= " ORDER BY ".$b_campo_ordenar." ".$b_orden;
            }else{
                $sql .= " ORDER BY conf_usuarios.id_usuario DESC";
            }            
            $sql .= " LIMIT ".$segmento.", ".$por_pagina;  //echo "<br />sql <pre>*".$sql."*</pre>";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }    

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
    public function conf_usuarios_buscar_2($id_usuario){
            $sql = "SELECT * FROM conf_usuarios
                    WHERE id_usuario = '".$id_usuario."'";      //echo "<br />sql <pre>*".$sql."*</pre>";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }    
/*    
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
    //conf_usuarios_roles
    //    conf_usuarios_id_usuario
    //    conf_roles_id    
    public function conf_usuarios_buscar_3($conf_roles_id){
            $sql = "SELECT conf_usuarios.* FROM conf_usuarios, conf_usuarios_roles
                    WHERE   conf_usuarios_roles.conf_roles_id = '".$conf_roles_id."'
                        AND conf_usuarios.id_usuario = conf_usuarios_roles.conf_usuarios_id_usuario
                        ORDER BY conf_usuarios.id_usuario ASC
                   ";       //echo "<br />sql <pre>*".$sql."*</pre>";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }    
*/    
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
    public function conf_usuarios_buscar_4($correo){
            $sql = "SELECT * FROM conf_usuarios
                    WHERE 
                         correo = '".$correo."' ";
            //return $sql;
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }

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
    public function conf_usuarios_buscar_5($correo, $id_usuario){
            $sql = "SELECT * FROM conf_usuarios
                    WHERE 
                         correo = '".$correo."' ";
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
/*    
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
    public function conf_usuarios_buscar_6($ci_usu){
            $sql = "SELECT * FROM conf_usuarios
                    WHERE ci_usu = '".$ci_usu."'";      //echo "<br />sql <pre>*".$sql."*</pre>";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }    
*/    
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
    //conf_usu_pass
    //    id_usuario
    //    usuario_usu
    //    pass_usu
    //    olvido_pass_identificador
    //    creado
    //    modificado    
    public function conf_usuarios_buscar_7($correo, $pass_usu){
            $sql = "SELECT 
                            conf_usuarios.id_usuario AS conf_usuarios_id_usuario
                        ,   conf_usuarios.ci_usu AS conf_usuarios_ci_usu
                        ,   conf_usuarios.nombre_usu AS conf_usuarios_nombre_usu
                        ,   conf_usuarios.apellido_usu AS conf_usuarios_apellido_usu
                        ,   conf_usu_pass.usuario_usu AS conf_usu_pass_usuario_usu
                    FROM conf_usuarios, conf_usu_pass
                    WHERE 
                            conf_usuarios.correo     = '".$correo."'
                        AND conf_usu_pass.pass_usu   = '".$pass_usu."'
                        AND conf_usuarios.id_usuario = conf_usu_pass.id_usuario
                    ";      //echo "<br />sql <pre>*".$sql."*</pre>";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }    

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
    public function conf_usuarios_buscar_8(){
            $sql = "SELECT * FROM conf_usuarios
                    ORDER BY ci_usu ASC
                   ";      //echo "<br />sql <pre>*".$sql."*</pre>";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }    
/*    
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
    //conf_usu_pass
    //    id_usuario
    //    usuario_usu
    //    pass_usu
    //    olvido_pass_identificador
    //    creado
    //    modificado    
    public function conf_usuarios_buscar_9($usuario_usu_correo){
            $sql = "SELECT 
                            conf_usuarios.id_usuario AS conf_usuarios_id_usuario
                        ,   conf_usu_pass.usuario_usu AS conf_usu_pass_usuario_usu
                    FROM conf_usuarios, conf_usu_pass
                    WHERE 
                        (
                            conf_usuarios.correo        = '".$usuario_usu_correo."'
                            OR
                            conf_usu_pass.usuario_usu   = '".$usuario_usu_correo."'
                        )       
                        AND conf_usuarios.id_usuario = conf_usu_pass.id_usuario
                    ";      //echo "<br />sql <pre>*".$sql."*</pre>";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }    
*/    
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
    public function conf_usuarios_insertar($ci_usu, $nombre_usu, $apellido_usu, $direccion_usu, $telefono_1, $telefono_2, $correo, $estado){
            $sql = "
            INSERT INTO conf_usuarios (ci_usu, nombre_usu, apellido_usu, direccion_usu, telefono_1, telefono_2, correo, estado) VALUES
            ('".$ci_usu."', '".$nombre_usu."', '".$apellido_usu."', '".$direccion_usu."', '".$telefono_1."', '".$telefono_2."', '".$correo."', '".$estado."')
            ";      //echo "<br />sql <pre>*".$sql."*</pre>";
            $resultado = $this->db->query($sql);    //echo "<hr />resultado *".$resultado."*";
            //return $resultado;
            return $this->db->insert_id();
    }

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
    public function conf_usuarios_editar($id_usuario, $ci_usu, $nombre_usu, $apellido_usu, $direccion_usu, $telefono_1, $telefono_2, $correo, $estado){
            $sql = "
                    UPDATE conf_usuarios SET
                           ci_usu           =   '".$ci_usu."'
                        ,  nombre_usu       =   '".$nombre_usu."'
                        ,  apellido_usu     =   '".$apellido_usu."'
                        ,  direccion_usu    =   '".$direccion_usu."'
                        ,  telefono_1       =   '".$telefono_1."'
                        ,  telefono_2       =   '".$telefono_2."'
                        ,  correo           =   '".$correo."'
                        ,  estado           =   '".$estado."'
                    WHERE id_usuario = '".$id_usuario."'
            ";      //echo "<br />sql <pre>*".$sql."*</pre>";
            $resultado = $this->db->query($sql);
            return $resultado;
    }    
/*
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
    public function conf_usuarios_editar_2($id_usuario, $imagen_nombre){
            if($imagen_nombre == ""){   $imagen_nombre = 'NULL';   }else{ $imagen_nombre = "'".$imagen_nombre."'"; }
            $sql = "
                    UPDATE conf_usuarios SET
                           imagen_nombre           =   ".$imagen_nombre."
                    WHERE id_usuario = '".$id_usuario."'
            ";      //echo "<br />sql <pre>*".$sql."*</pre>";
            $resultado = $this->db->query($sql);
            return $resultado;
    }    
*/    
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
    public function conf_usuarios_deshabilitar($id_usuario){
            $sql = "
                    UPDATE conf_usuarios SET
                           estado           =   '2'
                    WHERE id_usuario = '".$id_usuario."'
            ";      //echo "<br />sql <pre>*".$sql."*</pre>";
            $resultado = $this->db->query($sql);
            return $resultado;
    }
    
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
    public function conf_usuarios_eliminar($id_usuario){
            $sql = "
                    DELETE FROM conf_usuarios WHERE id_usuario = '".$id_usuario."'
            ";      //echo "<br />sql <pre>*".$sql."*</pre>";
            $resultado = $this->db->query($sql);
            return $resultado;
    }    
    
    //Aqui en adelante se estan las funciones de Logeo ----------------------------------------------------------------------------------------------------

    
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
    public function isLogged(){
        if(isset($this->session->userdata['iduser'])){
            $sql = "SELECT id_usuario FROM conf_usuarios
                    WHERE 
                        id_usuario = '".$this->session->userdata['iduser']."'
                        AND estado = '1'
                    ";      //echo "<br />sql <pre>*".$sql."*</pre>";
            $resultado = $this->db->query($sql);
            if($resultado->num_rows() > 0){
                return true;    
            }else{
                return false;    
            }
        }else{
            return false;
        }
    }

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
    public function datos_user($user_ifs){
//        $this->output->enable_profiler(TRUE);
        $this->db->select('*');
        $this->db->from('conf_usu_pass');
        $this->db->join('conf_usuarios','conf_usuarios.id_usuario = conf_usu_pass.id_usuario');
        $this->db->where('conf_usu_pass.usuario_usu', $user_ifs);
        $consulta = $this->db->get();
            
        return $consulta->result();
    }    
/*    
    public function total_user_sigalsx4(){
        
        $this->db->select('*');
        $this->db->from('conf_usuarios');
        $consulta = $this->db->get();
        return $consulta->num_rows();
        
    }    
    
    // USUARIOS PARA LA LISTA
    public function datos_list_user_sigalsx4($por_pagina, $segmento){
        $this->db->select('*');
        $this->db->from('conf_usuarios');
        $this->db->Limit($por_pagina, $segmento);
        $consulta = $this->db->get();
        if ($consulta->num_rows() > 0){
            return $consulta->result();
        }else{
            return FALSE;
        }
    }
*/    
}