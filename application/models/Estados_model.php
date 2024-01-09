<?php
class Estados_model extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }

    //Estados_model
    //    id
    //    nombre
    
    
/*    
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
    //estados
    //    id
    //    nombre
    public function estados_buscar_2($id){
            $sql = "SELECT * FROM estados
                    WHERE id = '".$id."'"; //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }

    //estados
    //    id
    //    nombre
    public function estados_buscar_3(){
            $sql = "SELECT * FROM estados ORDER BY id ASC";
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
    
    //cargos
    //    id
    //    nombre
    public function cargos_insertar($nombre){
            //if($id_cargo > 0){ }else{   $id_cargo = 'NULL';   }
            //if($id_gerencia > 0){ }else{   $id_gerencia = 'NULL';   }
            $sql = "
            INSERT INTO cargos (nombre) VALUES
            ('".$nombre."')
            ";      //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);    //echo "<hr />resultado *".$resultado."*";
            return $this->db->insert_id();
    }    
    
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