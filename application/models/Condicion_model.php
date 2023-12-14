<?php
class Condicion_model extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }
/*
    //condicion
    //    id
    //    nombre
    public function condicion_num_reg($b_texto){
            $sql = "
                    SELECT id FROM condicion WHERE
                            id LIKE '%".$b_texto."%'
                        OR  nombre LIKE '%".$b_texto."%'
            "; //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            return $resultado->num_rows();
    }
    
    //condicion
    //    id
    //    nombre    
    public function condicion_buscar($b_texto, $por_pagina, $segmento){
            $sql = "SELECT * FROM condicion WHERE
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
    
    //condicion
    //    id
    //    nombre
    public function condicion_buscar_2($id){
            $sql = "SELECT * FROM condicion
                    WHERE id = '".$id."'"; //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }
*/
    //condicion
    //    id
    //    nombre
    public function conf_condicion_buscar_3(){
            $sql = "SELECT * FROM condicion ORDER BY nombre ASC";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }
/*    
    //condicion
    //    id
    //    nombre
    public function condicion_buscar_5($nombre, $id){
            $sql = "SELECT * FROM condicion
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
    
    //condicion
    //    id
    //    nombre    
    public function condicion_buscar_6($nombre){
            $sql = "SELECT * FROM condicion
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
    
    //condicion
    //    id
    //    nombre
    public function condicion_insertar($nombre){
            //if($id_cargo > 0){ }else{   $id_cargo = 'NULL';   }
            //if($id_gerencia > 0){ }else{   $id_gerencia = 'NULL';   }
            $sql = "
            INSERT INTO condicion (nombre) VALUES
            ('".$nombre."')
            ";      //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);    //echo "<hr />resultado *".$resultado."*";
            return $this->db->insert_id();
    }    
    
    //condicion
    //    id
    //    nombre
    public function condicion_editar($id, $nombre){
            $sql = "
                    UPDATE condicion SET
                           nombre           =   '".$nombre."'
                    WHERE id = '".$id."'
            ";      //echo "<br />sql <pre>*".$sql."*</pre>";
            $resultado = $this->db->query($sql);
            return $resultado;
    } 
    
    //condicion
    //    id
    //    nombre    
    public function condicion_eliminar($id){
            $sql = "
                    DELETE FROM condicion WHERE id = '".$id."'
            ";      //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            return $resultado;
    }    
*/
}