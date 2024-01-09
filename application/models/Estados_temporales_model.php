<?php
class Estados_temporales_model extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }
    
    
    //Estados_temporales
    //    id
    //    id_personal_ivic
    //    id_estados
    //    fecha_desde
    //    fecha_hasta
    
    
/*
    //cargos
    //    id
    //    nombre
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
    
    //cargos
    //    id
    //    nombre
    public function cargos_buscar_2($id){
            $sql = "SELECT * FROM cargos
                    WHERE id = '".$id."'"; //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }
*/
    //cargos
    //    id
    //    nombre
    public function conf_cargos_buscar_3(){
            $sql = "SELECT * FROM cargos ORDER BY nombre ASC";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }


    //estados_temporales
    //    id
    //    id_personal_ivic
    //    id_estados
    //    fecha_desde
    //    fecha_hasta    
    //estados
    //    id
    //    nombre
    public function estados_temporales_buscar_5($id_personal_ivic){
            $sql = "SELECT 
                          estados_temporales.id AS estados_temporales_id
                        , estados_temporales.fecha_desde AS estados_temporales_fecha_desde
                        , estados_temporales.fecha_hasta AS estados_temporales_fecha_hasta
                        , estados.nombre AS estados_nombre
                    FROM estados_temporales, estados
                    WHERE
                        estados_temporales.id_personal_ivic = '".$id_personal_ivic."'
                            AND estados_temporales.id_estados = estados.id
                            ORDER BY estados_temporales.id DESC
                            LIMIT 10
                        
                    ";  //echo $sql;
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }  
    
    //estados_temporales
    //    id
    //    id_personal_ivic
    //    id_estados
    //    fecha_desde
    //    fecha_hasta    
    //estados
    //    id
    //    nombre
    public function estados_temporales_buscar_6($id_personal_ivic, $fecha){
            $sql = "SELECT 
                          estados_temporales.id AS estados_temporales_id
                        , estados_temporales.id_estados AS estados_temporales_id_estados
                        , estados_temporales.fecha_desde AS estados_temporales_fecha_desde
                        , estados_temporales.fecha_hasta AS estados_temporales_fecha_hasta
                        , estados.nombre AS estados_nombre
                    FROM estados_temporales, estados
                    WHERE
                                estados_temporales.id_personal_ivic = '".$id_personal_ivic."'
                            AND estados_temporales.fecha_desde <= '".$fecha."'
                            AND estados_temporales.fecha_hasta >= '".$fecha."'
                            AND estados_temporales.id_estados = estados.id
                            ORDER BY estados_temporales.id DESC
                    ";  //echo "<pre>".$sql."</pre>";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }    

    //estados_temporales
    //    id
    //    id_personal_ivic
    //    id_estados
    //    fecha_desde
    //    fecha_hasta 
    public function estados_temporales_insertar($id_personal_ivic, $id_estados, $fecha_desde, $fecha_hasta){
            //if($id_cargo > 0){ }else{   $id_cargo = 'NULL';   }
            //if($id_gerencia > 0){ }else{   $id_gerencia = 'NULL';   }
            $sql = "
            INSERT INTO estados_temporales (id_personal_ivic, id_estados, fecha_desde, fecha_hasta) VALUES
            ('".$id_personal_ivic."', '".$id_estados."', '".$fecha_desde."', '".$fecha_hasta."')
            ";      //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);    //echo "<hr />resultado *".$resultado."*";
            return $this->db->insert_id();
    }    
    
    /*
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
    */
    
    //estados_temporales
    //    id
    //    id_personal_ivic
    //    id_estados
    //    fecha_desde
    //    fecha_hasta     
    public function estados_temporales_eliminar($id){
            $sql = "
                    DELETE FROM estados_temporales WHERE id = '".$id."'
            ";      //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            return $resultado;
    }    

}