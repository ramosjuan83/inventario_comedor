<?php
class Inv_tipo_articulo_model extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }

    //tipo_articulo
    //    id
    //    nombre
    public function inv_tipo_articulo_num_reg($b_texto){
            $sql = "
                    SELECT id FROM inv_tipo_articulo WHERE
                            id LIKE '%".$b_texto."%'
                        OR  nombre LIKE '%".$b_texto."%' OR observacion LIKE '%".$b_texto."%'
            "; //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            return $resultado->num_rows();
    }
    
    //tipo_articulo
    //    id
    //    nombre    
    public function inv_tipo_articulo_buscar($b_texto, $por_pagina, $segmento){
            $sql = "SELECT * FROM inv_tipo_articulo WHERE
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
 
    
    //tipo_articulo
    //    id
    //    nombre
    public function inv_tipo_articulo_buscar_2($id){
            $sql = "SELECT * FROM inv_tipo_articulo
                    WHERE id = '".$id."'"; //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }

    //tipo_articulo
    //    id
    //    nombre
    public function inv_tipo_articulo_buscar_3(){
            $sql = "SELECT * FROM inv_tipo_articulo WHERE id_status=1 ORDER BY nombre ASC";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }    

    //tipo_articulo
    //    id
    //    nombre
    public function inv_tipo_articulo_buscar_5($nombre, $id){
            $sql = "SELECT * FROM inv_tipo_articulo
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
    
    //tipo_articulo
    //    id
    //    nombre    
    public function inv_tipo_articulo_buscar_6($nombre){
            $sql = "SELECT * FROM inv_tipo_articulo
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
    
    //tipo_articulo
    //    id
    //    nombre
    public function inv_tipo_articulo_insertar($nombre,$observacion){
            //if($id_cargo > 0){ }else{   $id_cargo = 'NULL';   }
            //if($id_tipo_articulo > 0){ }else{   $id_tipo_articulo = 'NULL';   }
            $sql = "
            INSERT INTO inv_tipo_articulo (nombre,observacion,id_status) VALUES
            ('".$nombre."','".$observacion."','1')
            ";      //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);    //echo "<hr />resultado *".$resultado."*";
            return $this->db->insert_id();
    }    
    
    //tipo_articulo
    //    id
    //    nombre
    public function inv_tipo_articulo_editar($id, $nombre, $observacion){
            $sql = "
                    UPDATE inv_tipo_articulo SET
                           nombre           =   '".$nombre."', observacion='".$observacion."'
                    WHERE id = '".$id."'
            ";      //echo "<br />sql <pre>*".$sql."*</pre>";
            $resultado = $this->db->query($sql);
            return $resultado;
    } 

    //tipo_articulo
    //    id
    //    nombre    
    public function inv_tipo_articulo_eliminar($id){
        $sql = "UPDATE inv_tipo_articulo SET id_status=2  WHERE id = '".$id."'
        ";      //echo "<br />sql *".$sql."*";
        $resultado = $this->db->query($sql);

        return $resultado;
    }        
    
}