<?php
class Departamento_model extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }

    //departamento
    //    id
    //    id_gerencia
    //    nombre
    public function departamento_num_reg($b_texto){
            $sql = "
                    SELECT id FROM departamento WHERE
                            id LIKE '%".$b_texto."%'
                        OR  nombre LIKE '%".$b_texto."%'
            "; //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            return $resultado->num_rows();
    }
    
    //departamento
    //    id
    //    id_gerencia
    //    nombre
    //gerencias
    //    id
    //    id_gerencia_2
    //    nombre    
    public function departamento_buscar($b_texto, $por_pagina, $segmento){
            $sql = "SELECT departamento.id AS departamento_id
                        , departamento.id_gerencia AS departamento_id_gerencia
                        , departamento.nombre AS departamento_nombre
                        , gerencias.nombre AS gerencias_nombre
                    FROM departamento, gerencias WHERE
                        (
                                departamento.id LIKE '%".$b_texto."%'
                            OR  departamento.nombre LIKE '%".$b_texto."%'
                            OR  gerencias.nombre LIKE '%".$b_texto."%'
                        )
                        AND departamento.id_gerencia = gerencias.id
                    ORDER BY departamento.id DESC
                    LIMIT ".$segmento.", ".$por_pagina;  //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }    
 
    //departamento
    //    id
    //    id_gerencia
    //    nombre
    public function departamento_buscar_2($id){
            $sql = "SELECT * FROM departamento
                    WHERE id = '".$id."'"; //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }

    //departamento
    //    id
    //    id_gerencia
    //    nombre
    public function departamento_buscar_3(){
            $sql = "SELECT * FROM departamento ORDER BY nombre ASC";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }

    //departamento
    //    id
    //    id_gerencia
    //    nombre
    public function departamento_buscar_5($nombre, $id){
            $sql = "SELECT * FROM departamento
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
    
    //departamento
    //    id
    //    id_gerencia
    //    nombre
    public function departamento_buscar_6($nombre){
            $sql = "SELECT * FROM departamento
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
    
    //departamento
    //    id
    //    id_gerencia
    //    nombre
    public function departamento_buscar_7($id_gerencia){
            $sql = "SELECT * FROM departamento
                    WHERE 
                         id_gerencia = '".$id_gerencia."' ";
            //return $sql;
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }    

    //departamento
    //    id
    //    id_gerencia
    //    nombre
    public function departamento_insertar($id_gerencia, $nombre){
            //if($id_cargo > 0){ }else{   $id_cargo = 'NULL';   }
            //if($id_gerencia > 0){ }else{   $id_gerencia = 'NULL';   }
            $sql = "
            INSERT INTO departamento (id_gerencia, nombre) VALUES
            ('".$id_gerencia."', '".$nombre."')
            ";      //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);    //echo "<hr />resultado *".$resultado."*";
            return $this->db->insert_id();
    }    
    
    //departamento
    //    id
    //    id_gerencia
    //    nombre
    public function departamento_editar($id, $id_gerencia, $nombre){
            $sql = "
                    UPDATE departamento SET
                           id_gerencia      =   '".$id_gerencia."'
                        ,  nombre           =   '".$nombre."'
                    WHERE id = '".$id."'
            ";      //echo "<br />sql <pre>*".$sql."*</pre>";
            $resultado = $this->db->query($sql);
            return $resultado;
    } 

    //departamento
    //    id
    //    id_gerencia
    //    nombre
    public function departamento_eliminar($id){
            $sql = "
                    DELETE FROM departamento WHERE id = '".$id."'
            ";      //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            return $resultado;
    }    

}