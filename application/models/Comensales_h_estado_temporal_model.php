<?php
class Comensales_h_estado_temporal_model extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }
    
    //comensales_h_estado_temporal
    //    id
    //    comensales_id
    //    estados_id
    //    fecha_desde
    //    fecha_hasta
    
/*
    //cargos
    //    id
    //    nombre
    public function cargos_num_reg($b_texto){
            $sql = "
                    SELECT id FROM cargos WHERE
                            id LIKE '%".$b_texto."%'
                        OR  nombre LIKE '%".$b_texto."%'
            "; //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            return $resultado->num_rows();
    }
    
    //cargos
    //    id
    //    nombre    
    public function cargos_buscar($b_texto, $por_pagina, $segmento){
            $sql = "SELECT * FROM cargos WHERE
                            id LIKE '%".$b_texto."%'
                        OR  nombre LIKE '%".$b_texto."%'
                    ORDER BY id DESC
                    LIMIT ".$segmento.", ".$por_pagina;  //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }    
*/    
    //comensales_h_estado_temporal
    //    id
    //    comensales_id
    //    estados_id
    //    fecha_desde
    //    fecha_hasta
    public function comensales_h_estado_temporal_buscar_2($comensales_id){
            $sql = "SELECT 
                          comensales_h_estado_temporal.fecha_desde as comensales_h_estado_temporal_fecha_desde
                        , comensales_h_estado_temporal.fecha_hasta as comensales_h_estado_temporal_fecha_hasta
                        , estados.nombre AS estados_nombre
                    FROM comensales_h_estado_temporal, estados
                    WHERE 
                            comensales_h_estado_temporal.estados_id = estados.id
                        AND comensales_id = '".$comensales_id."'"; //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }

/*
    //cargos
    //    id
    //    nombre
    public function conf_cargos_buscar_3(){
            $sql = "SELECT * FROM cargos ORDER BY nombre ASC";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }
    
    //cargos
    //    id
    //    nombre
    public function cargos_buscar_5($nombre, $id){
            $sql = "SELECT * FROM cargos
                    WHERE 
                         nombre = '".$nombre."' ";
            if($id > 0){
                $sql .= " AND id <> '".$id."'";                
            } //return $sql;
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }  
    
    //cargos
    //    id
    //    nombre    
    public function cargos_buscar_6($nombre){
            $sql = "SELECT * FROM cargos
                    WHERE 
                         nombre = '".$nombre."' ";
            //return $sql;
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }
*/    
    //comensales_h_estado_temporal
    //    id
    //    comensales_id
    //    estados_id
    //    fecha_desde
    //    fecha_hasta
    public function comensales_h_estado_temporal_insertar($comensales_id, $estados_id, $fecha_desde, $fecha_hasta){
            $sql = "
            INSERT INTO comensales_h_estado_temporal (comensales_id, estados_id, fecha_desde, fecha_hasta) VALUES
            ('".$comensales_id."', '".$estados_id."', '".$fecha_desde."', '".$fecha_hasta."')
            ";      //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);    //echo "<hr />resultado *".$resultado."*";
            return $this->db->insert_id();
    }    
/*    
    //cargos
    //    id
    //    nombre
    public function cargos_editar($id, $nombre){
            $sql = "
                    UPDATE cargos SET
                           nombre           =   '".$nombre."'
                    WHERE id = '".$id."'
            ";      //echo "<br />sql <pre>*".$sql."*</pre>";
            $resultado = $this->db->query($sql);
            return $resultado;
    } 
    
    //cargos
    //    id
    //    nombre    
    public function cargos_eliminar($id){
            $sql = "
                    DELETE FROM cargos WHERE id = '".$id."'
            ";      //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            return $resultado;
    }    
*/
}