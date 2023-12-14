<?php
class Gerencias_model extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }

    //gerencias
    //    id
    //    nombre
    public function gerencias_num_reg($b_texto){
            $sql = "
                    SELECT id FROM gerencias WHERE
                            id LIKE '%".$b_texto."%'
                        OR  nombre LIKE '%".$b_texto."%'
            "; //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            return $resultado->num_rows();
    }
    
    //gerencias
    //    id
    //    nombre    
    public function gerencias_buscar($b_texto, $por_pagina, $segmento){
            $sql = "SELECT * FROM gerencias WHERE
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
 
    
    //gerencias
    //    id
    //    nombre
    public function gerencias_buscar_2($id){
            $sql = "SELECT * FROM gerencias
                    WHERE id = '".$id."'"; //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }

    //gerencias
    //    id
    //    nombre
    public function conf_gerencias_buscar_3(){
            $sql = "SELECT * FROM gerencias ORDER BY nombre ASC";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }    

    //gerencias
    //    id
    //    nombre
    public function gerencias_buscar_5($nombre, $id){
            $sql = "SELECT * FROM gerencias
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
    
    //gerencias
    //    id
    //    nombre    
    public function gerencias_buscar_6($nombre){
            $sql = "SELECT * FROM gerencias
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
    
    //gerencias
    //    id
    //    nombre
    public function gerencias_insertar($nombre){
            //if($id_cargo > 0){ }else{   $id_cargo = 'NULL';   }
            //if($id_gerencias > 0){ }else{   $id_gerencias = 'NULL';   }
            $sql = "
            INSERT INTO gerencias (nombre) VALUES
            ('".$nombre."')
            ";      //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);    //echo "<hr />resultado *".$resultado."*";
            return $this->db->insert_id();
    }    
    
    //gerencias
    //    id
    //    nombre
    public function gerencias_editar($id, $nombre){
            $sql = "
                    UPDATE gerencias SET
                           nombre           =   '".$nombre."'
                    WHERE id = '".$id."'
            ";      //echo "<br />sql <pre>*".$sql."*</pre>";
            $resultado = $this->db->query($sql);
            return $resultado;
    } 

    //gerencias
    //    id
    //    nombre    
    public function gerencias_eliminar($id){
            $sql = "
                    DELETE FROM gerencias WHERE id = '".$id."'
            ";      //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            return $resultado;
    }        
    
}