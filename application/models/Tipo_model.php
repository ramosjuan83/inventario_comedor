<?php
class Tipo_model extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }
/*
    //tipo
    //    id
    //    nombre
    public function tipo_num_reg($b_texto){
            $sql = "
                    SELECT id FROM tipo WHERE
                            id LIKE '%".$b_texto."%'
                        OR  nombre LIKE '%".$b_texto."%'
            "; //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            return $resultado->num_rows();
    }
    
    //tipo
    //    id
    //    nombre    
    public function tipo_buscar($b_texto, $por_pagina, $segmento){
            $sql = "SELECT * FROM tipo WHERE
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
    
    //tipo
    //    id
    //    nombre
    public function tipo_buscar_2($id){
            $sql = "SELECT * FROM tipo
                    WHERE id = '".$id."'"; //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }
*/
    //tipo
    //    id
    //    nombre
    public function conf_tipo_buscar_3(){
            $sql = "SELECT * FROM tipo ORDER BY nombre ASC";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }
/*    
    //tipo
    //    id
    //    nombre
    public function tipo_buscar_5($nombre, $id){
            $sql = "SELECT * FROM tipo
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
    
    //tipo
    //    id
    //    nombre    
    public function tipo_buscar_6($nombre){
            $sql = "SELECT * FROM tipo
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
    
    //tipo
    //    id
    //    nombre
    public function tipo_insertar($nombre){
            //if($id_cargo > 0){ }else{   $id_cargo = 'NULL';   }
            //if($id_gerencia > 0){ }else{   $id_gerencia = 'NULL';   }
            $sql = "
            INSERT INTO tipo (nombre) VALUES
            ('".$nombre."')
            ";      //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);    //echo "<hr />resultado *".$resultado."*";
            return $this->db->insert_id();
    }    
    
    //tipo
    //    id
    //    nombre
    public function tipo_editar($id, $nombre){
            $sql = "
                    UPDATE tipo SET
                           nombre           =   '".$nombre."'
                    WHERE id = '".$id."'
            ";      //echo "<br />sql <pre>*".$sql."*</pre>";
            $resultado = $this->db->query($sql);
            return $resultado;
    } 
    
    //tipo
    //    id
    //    nombre    
    public function tipo_eliminar($id){
            $sql = "
                    DELETE FROM tipo WHERE id = '".$id."'
            ";      //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            return $resultado;
    }    
*/
}