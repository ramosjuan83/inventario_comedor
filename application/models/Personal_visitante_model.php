<?php
class Personal_visitante_model extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }

    //personal_visitante
    //    id
    //    cedula
    //    nombres
    //    apellidos
    //    imagen_nombre
    //    estado
    //    id_personal_visitante_tipo
    public function personal_visitante_num_reg($b_texto, $estado){
            $sql = "
                    SELECT id FROM personal_visitante WHERE
                        (
                                id LIKE '%".$b_texto."%'
                            OR  nombres LIKE '%".$b_texto."%'
                            OR  apellidos LIKE '%".$b_texto."%'
                            OR  cedula LIKE '%".$b_texto."%'
                        )
                    ";
            if($estado > 0){
                $sql .= " AND estado = '".$estado."'";                
            }
            $sql .= "
            "; //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            return $resultado->num_rows();
    }
/*
    //personal_visitante
    //    id
    //    cedula
    //    nombres
    //    apellidos
    //    imagen_nombre
    //    estado
    //    id_personal_visitante_tipo
    public function personal_ivic_num_reg_2($nombre){
            $sql = "SELECT id_personal_ivic FROM personal_ivic
                    WHERE nombre = '".$nombre."'
                        AND  (  nombre <> NUll  or nombre <> '' )
                        ";      //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            return $resultado->num_rows();
    }

    //personal_visitante
    //    id
    //    cedula
    //    nombres
    //    apellidos
    //    imagen_nombre
    //    estado
    //    id_personal_visitante_tipo
    public function personal_ivic_num_reg_3($id_personal_ivic, $nombre){
            $sql = "SELECT id_personal_ivic FROM personal_ivic
                    WHERE
                            (
                                        nombre = '".$nombre."'
                                AND  (  nombre <> NUll  or nombre <> '' )
                            )
                            AND id_personal_ivic <> '".$id_personal_ivic."'";      //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            return $resultado->num_rows();
    }
*/
    
    //personal_visitante
    //    id
    //    cedula
    //    nombres
    //    apellidos
    //    imagen_nombre
    //    estado
    //    id_personal_visitante_tipo
    public function personal_visitante_buscar($b_texto, $estado, $por_pagina, $segmento){
            $sql = "SELECT * FROM personal_visitante WHERE
                        (
                                id LIKE '%".$b_texto."%'
                            OR  nombres LIKE '%".$b_texto."%'
                            OR  apellidos LIKE '%".$b_texto."%'
                            OR  cedula LIKE '%".$b_texto."%'
                        )
                    ";
            if($estado > 0){
                $sql .= " AND estado = '".$estado."'";                
            }
            $sql .= "
                    ORDER BY id DESC ";
            if($segmento > 0 or $por_pagina > 0){
                $sql .= " LIMIT ".$segmento.", ".$por_pagina;  
            }            //echo "<br />sql *".$sql."*";
            
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }
    
    //personal_visitante
    //    id
    //    cedula
    //    nombres
    //    apellidos
    //    imagen_nombre
    //    estado
    //    id_personal_visitante_tipo
    public function personal_visitante_buscar_2($id){
            $sql = "SELECT * FROM personal_visitante
                    WHERE id = '".$id."'";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }

/*
    //personal_visitante
    //    id
    //    cedula
    //    nombres
    //    apellidos
    //    imagen_nombre
    //    estado
    //    id_personal_visitante_tipo
    public function personal_ivic_buscar_3(){
            $sql = "SELECT * FROM personal_ivic ORDER BY cedula ASC";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }    
*/
    //personal_visitante
    //    id
    //    cedula
    //    nombres
    //    apellidos
    //    imagen_nombre
    //    estado
    //    id_personal_visitante_tipo
    public function personal_visitante_buscar_4($cedula){
            $sql = "SELECT * FROM personal_visitante
                    WHERE 
                         cedula = '".$cedula."' ";
            //return $sql;
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    } 
    
    //personal_visitante
    //    id
    //    cedula
    //    nombres
    //    apellidos
    //    imagen_nombre
    //    estado
    //    id_personal_visitante_tipo
    //personal_visitante_tipo
    //    id
    //    nombre
    public function personal_visitante_buscar_5($personal_visitante_id){
            $sql = "SELECT 
                              personal_visitante.id AS personal_visitante_id
                            , personal_visitante_tipo.id AS personal_visitante_tipo_id
                            , personal_visitante_tipo.nombre AS personal_visitante_tipo_nombre
                    FROM personal_visitante, personal_visitante_tipo
                    WHERE   personal_visitante.id = '".$personal_visitante_id."'
                        AND personal_visitante.id_personal_visitante_tipo = personal_visitante_tipo.id
                    ";      //echo "<br />sql *<pre>".$sql."</pre>*";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }    
    
    //personal_visitante
    //    id
    //    cedula
    //    nombres
    //    apellidos
    //    imagen_nombre
    //    estado
    //    id_personal_visitante_tipo
    public function personal_visitante_insertar($cedula, $nombres, $apellidos, $estado, $id_personal_visitante_tipo){
            $sql = "
            INSERT INTO personal_visitante (cedula, nombres, apellidos, estado, id_personal_visitante_tipo) VALUES
            ('".$cedula."', '".$nombres."', '".$apellidos."', '".$estado."', '".$id_personal_visitante_tipo."')
            ";      //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);    //echo "<hr />resultado *".$resultado."*";
            return $this->db->insert_id();
    }

    //personal_visitante
    //    id
    //    cedula
    //    nombres
    //    apellidos
    //    imagen_nombre
    //    estado
    //    id_personal_visitante_tipo
    public function personal_visitante_editar($id, $nombres, $apellidos, $estado, $id_personal_visitante_tipo){
            if($id_cargo > 0){ }else{   $id_cargo = 'NULL';   }
            if($id_gerencia > 0){ }else{   $id_gerencia = 'NULL';   }        
            $sql = "
                    UPDATE personal_visitante SET
                          nombres           =   '".$nombres."'
                        , apellidos         =   '".$apellidos."'
                        , estado            =   '".$estado."'
                        , id_personal_visitante_tipo            =   '".$id_personal_visitante_tipo."'
                    WHERE id = '".$id."'
            ";      //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            return $resultado;
    }

    //personal_visitante
    //    id
    //    cedula
    //    nombres
    //    apellidos
    //    imagen_nombre
    //    estado
    //    id_personal_visitante_tipo
    public function personal_visitante_editar_2($id, $estado){
            $sql = "
                    UPDATE personal_visitante SET
                          estado            =   '".$estado."'
                    WHERE id = '".$id."'
            ";      //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            return $resultado;
    }
    
    public function personal_visitante_editar_3($id, $imagen_nombre){
            if($imagen_nombre == ""){   $imagen_nombre = 'NULL';   }else{ $imagen_nombre = "'".$imagen_nombre."'"; }
            $sql = "
                    UPDATE personal_visitante SET
                           imagen_nombre           =   ".$imagen_nombre."
                    WHERE id = '".$id."'
            ";      //echo "<br />sql <pre>*".$sql."*</pre>";
            $resultado = $this->db->query($sql);
            return $resultado;
    }
    
    
    //personal_visitante
    //    id
    //    cedula
    //    nombres
    //    apellidos
    //    imagen_nombre
    //    estado
    //    id_personal_visitante_tipo
    public function personal_visitante_eliminar($id){
            $sql = "
                    DELETE FROM personal_visitante WHERE id = '".$id."'
            ";      //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            return $resultado;
    }

}