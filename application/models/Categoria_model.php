<?php
class Categoria_model extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }
/*
    //categoria
    //    id
    //    nombre
    public function categoria_num_reg($b_texto){
            $sql = "
                    SELECT id FROM categoria WHERE
                            id LIKE '%".$b_texto."%'
                        OR  nombre LIKE '%".$b_texto."%'
            "; //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            return $resultado->num_rows();
    }
    
    //categoria
    //    id
    //    nombre    
    public function categoria_buscar($b_texto, $por_pagina, $segmento){
            $sql = "SELECT * FROM categoria WHERE
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
    
    //categoria
    //    id
    //    nombre
    public function categoria_buscar_2($id){
            $sql = "SELECT * FROM categoria
                    WHERE id = '".$id."'"; //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }
*/
    //categoria
    //    id
    //    nombre
    public function categoria_buscar_3(){
            $sql = "SELECT * FROM categoria ORDER BY nombre ASC";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }
/*    
    //categoria
    //    id
    //    nombre
    public function categoria_buscar_5($nombre, $id){
            $sql = "SELECT * FROM categoria
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
    
    //categoria
    //    id
    //    nombre    
    public function categoria_buscar_6($nombre){
            $sql = "SELECT * FROM categoria
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
    
    //categoria
    //    id
    //    nombre
    public function categoria_insertar($nombre){
            //if($id_cargo > 0){ }else{   $id_cargo = 'NULL';   }
            //if($id_gerencia > 0){ }else{   $id_gerencia = 'NULL';   }
            $sql = "
            INSERT INTO categoria (nombre) VALUES
            ('".$nombre."')
            ";      //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);    //echo "<hr />resultado *".$resultado."*";
            return $this->db->insert_id();
    }    
    
    //categoria
    //    id
    //    nombre
    public function categoria_editar($id, $nombre){
            $sql = "
                    UPDATE categoria SET
                           nombre           =   '".$nombre."'
                    WHERE id = '".$id."'
            ";      //echo "<br />sql <pre>*".$sql."*</pre>";
            $resultado = $this->db->query($sql);
            return $resultado;
    } 
    
    //categoria
    //    id
    //    nombre    
    public function categoria_eliminar($id){
            $sql = "
                    DELETE FROM categoria WHERE id = '".$id."'
            ";      //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            return $resultado;
    }    
*/
}