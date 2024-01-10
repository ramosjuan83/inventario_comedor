<?php
class Inv_unidad_medida_model extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }

    //unidad_medida
    //    id
    //    nombre
    public function inv_unidad_medida_num_reg($b_texto){
            $sql = "
                    SELECT id FROM inv_unidad_medida WHERE
                            id LIKE '%".$b_texto."%'
                        OR  nombre LIKE '%".$b_texto."%' OR observacion LIKE '%".$b_texto."%'
            "; //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            return $resultado->num_rows();
    }
    
    //unidad_medida
    //    id
    //    nombre    
    public function inv_unidad_medida_buscar($b_texto, $por_pagina, $segmento){
            $sql = "SELECT * FROM inv_unidad_medida WHERE
                            id LIKE '%".$b_texto."%'
                        OR  nombre LIKE '%".$b_texto."%' OR observacion LIKE '%".$b_texto."%'
                    ORDER BY nombre ASC
                    LIMIT ".$segmento.", ".$por_pagina;  //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }    
 
    
    //unidad_medida
    //    id
    //    nombre
    public function inv_unidad_medida_buscar_2($id){
            $sql = "SELECT * FROM inv_unidad_medida
                    WHERE id = '".$id."'"; //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }

    //unidad_medida
    //    id
    //    nombre
    public function inv_unidad_medida_buscar_3(){
            $sql = "SELECT * FROM inv_unidad_medida ORDER BY nombre ASC";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }    

    //unidad_medida
    //    id
    //    nombre
    public function inv_unidad_medida_buscar_5($nombre, $id){
            $sql = "SELECT * FROM inv_unidad_medida
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
    
    //unidad_medida
    //    id
    //    nombre    
    public function inv_unidad_medida_buscar_6($nombre){
            $sql = "SELECT * FROM inv_unidad_medida
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
    
    //unidad_medida
    //    id
    //    nombre
    public function inv_unidad_medida_insertar($nombre,$observacion){
            //if($id_cargo > 0){ }else{   $id_cargo = 'NULL';   }
            //if($id_unidad_medida > 0){ }else{   $id_unidad_medida = 'NULL';   }
            $sql = "
            INSERT INTO inv_unidad_medida (nombre,observacion,id_status) VALUES
            ('".$nombre."','".$observacion."','1')
            ";      //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);    //echo "<hr />resultado *".$resultado."*";
            return $this->db->insert_id();
    }    
    
    //unidad_medida
    //    id
    //    nombre
    public function inv_unidad_medida_editar($id, $nombre, $observacion){
            $sql = "
                    UPDATE inv_unidad_medida SET
                           nombre           =   '".$nombre."', observacion='".$observacion."'
                    WHERE id = '".$id."'
            ";      //echo "<br />sql <pre>*".$sql."*</pre>";
            $resultado = $this->db->query($sql);
            return $resultado;
    } 

    //unidad_medida
    //    id
    //    nombre    
    public function inv_unidad_medida_eliminar($id){
        $sql = "
        UPDATE inv_unidad_medida SET id_status=2  WHERE id = '".$id."'
        ";      //echo "<br />sql *".$sql."*";
        $resultado = $this->db->query($sql);

        return $resultado;
    }        
    
}