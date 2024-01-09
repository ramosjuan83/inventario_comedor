<?php
class Gerencias_model extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }

    //gerencias
    //    id
    //    id_gerencia_2
    //    nombre
    public function gerencias_num_reg($b_texto){
            $sql = "
                    SELECT gerencias.id AS gerencias_id
                    FROM gerencias, gerencias_2 
                    WHERE
                        (
                                gerencias.id LIKE '%".$b_texto."%'
                        OR  gerencias.nombre LIKE '%".$b_texto."%'
                        OR  gerencias_2.nombre LIKE '%".$b_texto."%'
                        )
                        AND gerencias.id_gerencia_2 = gerencias_2.id
            "; //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            return $resultado->num_rows();
    }
    
    //gerencias
    //    id
    //    id_gerencia_2
    //    nombre   
    //gerencias_2
    //    id
    //    nombre    
    public function gerencias_buscar($b_texto, $por_pagina, $segmento){
            $sql = "SELECT 
                            gerencias.id AS gerencias_id
                        ,   gerencias.nombre AS gerencias_nombre
                        ,   gerencias_2.id AS gerencias_2_id
                        ,   gerencias_2.nombre AS gerencias_2_nombre
                    FROM gerencias, gerencias_2 
                    WHERE
                        (
                                gerencias.id LIKE '%".$b_texto."%'
                        OR  gerencias.nombre LIKE '%".$b_texto."%'
                        OR  gerencias_2.nombre LIKE '%".$b_texto."%'
                        )
                        AND gerencias.id_gerencia_2 = gerencias_2.id
                    ORDER BY gerencias.id DESC
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
    //    id_gerencia_2
    //    nombre
    public function gerencias_buscar_2($id){
            $sql = "SELECT * 
                    FROM gerencias
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
    //    id_gerencia_2
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
    //    id_gerencia_2
    //    nombre    
    public function gerencias_buscar_4(){
            $sql = "SELECT * 
                    FROM gerencias ORDER BY nombre ASC";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }    
    
    //gerencias
    //    id
    //    id_gerencia_2
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
    //    id_gerencia_2
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
    //    id_gerencia_2
    //    nombre 
    public function gerencias_buscar_7($id_gerencia_2){
            $sql = "SELECT * FROM gerencias
                    WHERE 
                         id_gerencia_2 = '".$id_gerencia_2."' ";
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
    //    id_gerencia_2
    //    nombre
    public function gerencias_insertar($id_gerencia_2, $nombre){
            //if($id_cargo > 0){ }else{   $id_cargo = 'NULL';   }
            //if($id_gerencias > 0){ }else{   $id_gerencias = 'NULL';   }
            $sql = "
            INSERT INTO gerencias (id_gerencia_2, nombre) VALUES
            ('".$id_gerencia_2."', '".$nombre."')
            ";      //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);    //echo "<hr />resultado *".$resultado."*";
            return $this->db->insert_id();
    }    
    
    //gerencias
    //    id
    //    id_gerencia_2
    //    nombre
    public function gerencias_editar($id, $id_gerencia_2, $nombre){
            $sql = "
                    UPDATE gerencias SET
                            id_gerencia_2    =   '".$id_gerencia_2."'
                          , nombre           =   '".$nombre."'
                    WHERE id = '".$id."'
            ";      //echo "<br />sql <pre>*".$sql."*</pre>";
            $resultado = $this->db->query($sql);
            return $resultado;
    } 

    //gerencias
    //    id
    //    id_gerencia_2
    //    nombre    
    public function gerencias_eliminar($id){
            $sql = "
                    DELETE FROM gerencias WHERE id = '".$id."'
            ";      //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            return $resultado;
    }        
    
}