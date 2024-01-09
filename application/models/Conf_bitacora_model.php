<?php
class Conf_bitacora_model extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }

    //conf_bitacora
    //        id
    //        id_usuario
    //        fecha
    //        hora
    //        tabla_nombre
    //        accion
    //        accion_2
    //        ip_usuario
    public function conf_bitacora_num_reg($b_id_usuario, $fecha_desde, $fecha_hasta, $b_texto, $bitacora_id_usuario_a_omitir){
            $sql = "SELECT id 
                    FROM conf_bitacora, conf_usuarios 
                    WHERE
                        (
                                conf_bitacora.id LIKE '%".$b_texto."%'
                            OR  conf_bitacora.tabla_nombre LIKE '%".$b_texto."%'
                            OR  conf_bitacora.accion LIKE '%".$b_texto."%'
                            OR  conf_bitacora.accion_2 LIKE '%".$b_texto."%'
                            OR  conf_bitacora.ip_usuario LIKE '%".$b_texto."%'
                        ) ";
            if(   strlen($fecha_desde) > 2   or  strlen($fecha_hasta) > 2){
                    $sql .= " AND conf_bitacora.fecha BETWEEN '".$fecha_desde."' AND '".$fecha_hasta."' ";
            }
            $sql .= "            
                        AND conf_bitacora.id_usuario = conf_usuarios.id_usuario";
            if($b_id_usuario > 0){
                    $sql .= " AND conf_bitacora.id_usuario = '".$b_id_usuario."' ";
            }
            if($bitacora_id_usuario_a_omitir > 0){
                    $sql .= " AND conf_bitacora.id_usuario <> '".$bitacora_id_usuario_a_omitir."' ";
            }         
            $sql .= "
            "; //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            return $resultado->num_rows();
    }    
    
    //conf_bitacora
    //        id
    //        id_usuario
    //        fecha
    //        hora
    //        tabla_nombre
    //        accion
    //        accion_2
    //        ip_usuario 
    public function conf_bitacora_num_reg_2($id_usuario){
            $sql = "SELECT id FROM conf_bitacora
                    WHERE id_usuario = '".$id_usuario."'";      //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            return $resultado->num_rows();
    }
    
    //conf_bitacora
    //        id
    //        id_usuario
    //        fecha
    //        hora
    //        tabla_nombre
    //        accion
    //        accion_2
    //        ip_usuario
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
    public function conf_bitacora_buscar($b_id_usuario, $fecha_desde, $fecha_hasta, $b_texto, $bitacora_id_usuario_a_omitir, $por_pagina, $segmento){
            $sql = "SELECT 
                          conf_bitacora.id AS conf_bitacora_id
                        , conf_bitacora.id_usuario AS conf_bitacora_id_usuario
                        , conf_bitacora.fecha AS conf_bitacora_fecha
                        , conf_bitacora.hora AS conf_bitacora_hora
                        , conf_bitacora.tabla_nombre AS conf_bitacora_tabla_nombre
                        , conf_bitacora.accion AS conf_bitacora_accion
                        , conf_bitacora.accion_2 AS conf_bitacora_accion_2
                        , conf_bitacora.ip_usuario AS conf_bitacora_ip_usuario
                        , conf_usuarios.ci_usu AS conf_usuarios_ci_usu
                        , conf_usuarios.nombre_usu AS conf_usuarios_nombre_usu
                        , conf_usuarios.apellido_usu AS conf_usuarios_apellido_usu
                    FROM conf_bitacora, conf_usuarios 
                    WHERE
                        (
                                conf_bitacora.id LIKE '%".$b_texto."%'
                            OR  conf_bitacora.tabla_nombre LIKE '%".$b_texto."%'
                            OR  conf_bitacora.accion LIKE '%".$b_texto."%'
                            OR  conf_bitacora.accion_2 LIKE '%".$b_texto."%'
                            OR  conf_bitacora.ip_usuario LIKE '%".$b_texto."%'
                        ) ";
            if(   strlen($fecha_desde) > 2   or  strlen($fecha_hasta) > 2){
                    $sql .= " AND conf_bitacora.fecha BETWEEN '".$fecha_desde."' AND '".$fecha_hasta."' ";
            }
            $sql .= "            
                        AND conf_bitacora.id_usuario = conf_usuarios.id_usuario";
            if($b_id_usuario > 0){
                    $sql .= " AND conf_bitacora.id_usuario = '".$b_id_usuario."' ";
            }
            if($bitacora_id_usuario_a_omitir > 0){
                    $sql .= " AND conf_bitacora.id_usuario <> '".$bitacora_id_usuario_a_omitir."' ";
            }
            $sql .= "
                    ORDER BY id DESC";
            if($segmento > 0 or $por_pagina > 0){
                $sql .= " LIMIT ".$segmento.", ".$por_pagina;  
            }  //echo "<br />sql *<pre>".$sql."</pre>*";    
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }
    
    //conf_bitacora
    //        id
    //        id_usuario
    //        fecha
    //        hora
    //        tabla_nombre
    //        accion
    //        accion_2
    //        ip_usuario
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
    public function conf_bitacora_buscar_2($conf_bitacora_id){
            $sql = "SELECT 
                          conf_bitacora.id AS conf_bitacora_id
                        , conf_bitacora.id_usuario AS conf_bitacora_id_usuario
                        , conf_bitacora.fecha AS conf_bitacora_fecha
                        , conf_bitacora.hora AS conf_bitacora_hora
                        , conf_bitacora.tabla_nombre AS conf_bitacora_tabla_nombre
                        , conf_bitacora.accion AS conf_bitacora_accion
                        , conf_bitacora.accion_2 AS conf_bitacora_accion_2
                        , conf_bitacora.ip_usuario AS conf_bitacora_ip_usuario
                        , conf_usuarios.ci_usu AS conf_usuarios_ci_usu
                        , conf_usuarios.nombre_usu AS conf_usuarios_nombre_usu
                        , conf_usuarios.apellido_usu AS conf_usuarios_apellido_usu
                    FROM conf_bitacora, conf_usuarios 
                    WHERE
                            conf_bitacora.id = '".$conf_bitacora_id."'
                        AND conf_bitacora.id_usuario = conf_usuarios.id_usuario
                    ORDER BY conf_bitacora.id ASC"; //echo "<br />sql *<pre>".$sql."</pre>*";    
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }
    
    //conf_bitacora
    //        id
    //        id_usuario
    //        fecha
    //        hora
    //        tabla_nombre
    //        accion
    //        accion_2
    //        ip_usuario
    public function conf_bitacora_insertar($id_usuario, $fecha, $hora, $tabla_nombre, $accion, $ip_usuario){
            $sql = "
            INSERT INTO conf_bitacora (id_usuario, fecha, hora, tabla_nombre, accion, ip_usuario) VALUES
            ('".$id_usuario."', '".$fecha."', '".$hora."', '".$tabla_nombre."', '".$accion."', '".$ip_usuario."')
            ";      //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);    //echo "<hr />resultado *".$resultado."*";
            return $resultado;  //return $this->db->insert_id();
    }
    
    //conf_bitacora
    //        id
    //        id_usuario
    //        fecha
    //        hora
    //        tabla_nombre
    //        accion
    //        accion_2
    //        ip_usuario
    public function conf_bitacora_insertar_2($id_usuario, $fecha, $hora, $tabla_nombre, $accion, $accion_2, $ip_usuario){
            $sql = "
            INSERT INTO conf_bitacora(id_usuario, fecha, hora, tabla_nombre, accion, accion_2, ip_usuario) VALUES
            ('".$id_usuario."', '".$fecha."', '".$hora."', '".$tabla_nombre."', '".$accion."', '".$accion_2."', '".$ip_usuario."')
            ";      //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);    //echo "<hr />resultado *".$resultado."*";
            return $resultado;  //return $this->db->insert_id();
    }    

}