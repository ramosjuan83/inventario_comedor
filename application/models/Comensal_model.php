<?php
class Comensal_model extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }

    //comensales    
    //    id
    //    id_personal_ivic
    //    id_personal_visitante
    //    id_comedor_comida_tipo
    //    fecha
    //    hora
    //    id_usuario
    //    estatus
    public function comensales_num_reg($b_texto){
            $sql = "
                    SELECT id 
                    FROM comensales
                    WHERE
                        comensales.id_personal_ivic IN (
                            SELECT id FROM personal_ivic 
                            WHERE
                                   cedula LIKE '%".$b_texto."%'
                                OR nombres LIKE '%".$b_texto."%'
                                OR apellidos LIKE '%".$b_texto."%'
                                OR carnet_codigo LIKE '%".$b_texto."%'
                        )
                        OR
                        comensales.id_personal_visitante IN (
                            SELECT id FROM personal_visitante 
                            WHERE
                                   cedula LIKE '%".$b_texto."%'
                                OR nombres LIKE '%".$b_texto."%'
                                OR apellidos LIKE '%".$b_texto."%'
                        )
            "; //echo "<br />sql *<pre>".$sql."</pre>*";
            $resultado = $this->db->query($sql);
            return $resultado->num_rows();
    }
    
    //comensales    
    //    id
    //    id_personal_ivic
    //    id_personal_visitante
    //    id_comedor_comida_tipo
    //    fecha
    //    hora
    //    id_usuario
    //    estatus 
    //personal_ivic
    //    id
    //    cedula
    //    nombres
    //    apellidos
    //    id_cargo
    //    id_gerencia
    //    estado
    //    imagen_nombre
    //    carnet_codigo
    //personal_visitante
    //    id
    //    cedula
    //    nombres
    //    apellidos
    //    imagen_nombre
    //    estado
    //    id_personal_visitante_tipo    
    public function comensales_buscar($b_texto, $por_pagina, $segmento){
            $sql = "SELECT    comensales.id AS comensales_id
                            , comensales.id_personal_ivic AS comensales_id_personal_ivic
                            , comensales.id_personal_visitante AS comensales_id_personal_visitante
                            , comensales.id_comedor_comida_tipo AS comensales_id_comedor_comida_tipo
                            , comensales.fecha AS comensales_fecha
                            , comensales.hora AS comensales_hora
                            , comensales.estatus AS comensales_estatus
                    FROM comensales
                    WHERE
                        comensales.id_personal_ivic IN (
                            SELECT id FROM personal_ivic 
                            WHERE
                                   cedula LIKE '%".$b_texto."%'
                                OR nombres LIKE '%".$b_texto."%'
                                OR apellidos LIKE '%".$b_texto."%'
                                OR carnet_codigo LIKE '%".$b_texto."%'
                        )
                        OR
                        comensales.id_personal_visitante IN (
                            SELECT id FROM personal_visitante 
                            WHERE
                                   cedula LIKE '%".$b_texto."%'
                                OR nombres LIKE '%".$b_texto."%'
                                OR apellidos LIKE '%".$b_texto."%'
                        )                        
                    ORDER BY comensales.id DESC
                    LIMIT ".$segmento.", ".$por_pagina;  //echo "<br />sql *<pre>".$sql."</pre>*";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }    
    
    //comensales    
    //    id
    //    id_personal_ivic
    //    id_personal_visitante
    //    id_comedor_comida_tipo
    //    fecha
    //    hora
    //    id_usuario
    //    estatus
    public function comensales_buscar_2($id){
            $sql = "SELECT * FROM comensales
                    WHERE id = '".$id."'";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }
/*
    //comensales    
    //    id
    //    id_personal_ivic
    //    id_personal_visitante
    //    id_comedor_comida_tipo
    //    fecha
    //    hora
    //    id_usuario
    //    estatus
    public function personal_buscar_3(){
            $sql = "SELECT * FROM personal ORDER BY nombre ASC";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }    
*/
    //comensales    
    //    id
    //    id_personal_ivic
    //    id_personal_visitante
    //    id_comedor_comida_tipo
    //    fecha
    //    hora
    //    id_usuario
    //    estatus
    public function comensales_buscar_4($id_comedor_comida_tipo, $fecha, $estatus){
            $sql = "SELECT * 
                    FROM comensales
                    WHERE
                            id_comedor_comida_tipo = '".$id_comedor_comida_tipo."'
                        AND fecha = '".$fecha."'
                        AND estatus = '".$estatus."'
                    ORDER BY id DESC
                    LIMIT 10
                    ";
            //return $sql;
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }  
    
    //comensales    
    //    id
    //    id_personal_ivic
    //    id_personal_visitante
    //    id_comedor_comida_tipo
    //    fecha
    //    hora
    //    id_usuario
    //    estatus    
    public function comensales_buscar_5($id_personal_ivic, $id_comedor_comida_tipo, $fecha, $estatus){
            $sql = "SELECT * FROM comensales
                    WHERE   id_personal_ivic = '".$id_personal_ivic."'
                        AND id_comedor_comida_tipo = '".$id_comedor_comida_tipo."'
                        AND fecha = '".$fecha."'
                        AND estatus = '".$estatus."'
                    ORDER BY id ASC
                    ";
            //return $sql;
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }

    //comensales    
    //    id
    //    id_personal_ivic
    //    id_personal_visitante
    //    id_comedor_comida_tipo
    //    fecha
    //    hora
    //    id_usuario
    //    estatus
    public function comensales_buscar_8($id_personal_visitante, $id_comedor_comida_tipo, $fecha, $estatus){
            $sql = "SELECT * FROM comensales
                    WHERE   id_personal_visitante = '".$id_personal_visitante."'
                        AND id_comedor_comida_tipo = '".$id_comedor_comida_tipo."'
                        AND fecha = '".$fecha."'
                        AND estatus = '".$estatus."'
                    ORDER BY id ASC
                    ";
            //return $sql;
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }    
    
    //comensales    
    //    id
    //    id_personal_ivic
    //    id_personal_visitante
    //    id_comedor_comida_tipo
    //    fecha
    //    hora
    //    id_usuario
    //    estatus
    public function comensales_buscar_9($id_comedor_comida_tipo, $fecha, $filtro_personal_ivic, $filtro_personal_visitante, $estatus){
            $sql = "SELECT * FROM comensales
                    WHERE   
                            id_comedor_comida_tipo = '".$id_comedor_comida_tipo."'
                        AND fecha = '".$fecha."'";
            if($filtro_personal_ivic == true){
                    $sql .= "
                        AND id_personal_ivic > 0
                    ";                
            }
            if($filtro_personal_visitante == true){
                    $sql .= "
                        AND id_personal_visitante > 0
                    ";                
            }            
            
            $sql .= "
                    AND estatus = '".$estatus."'
                    ORDER BY id ASC
                    ";
            //return $sql;
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }    
    
    //comensales    
    //    id
    //    id_personal_ivic
    //    id_personal_visitante
    //    id_comedor_comida_tipo
    //    fecha
    //    hora
    //    id_usuario
    //    estatus
    //personal_ivic
    //    id
    //    cedula
    //    nombres
    //    apellidos
    //    id_cargo
    //    id_gerencia
    //    estado
    //    imagen_nombre
    //    carnet_codigo
    //personal_visitante
    //    id
    //    cedula
    //    nombres
    //    apellidos
    //    imagen_nombre
    //    estado
    //comedor_comida_tipo
    //    id
    //    nombre
    //    hora_desde
    //    hora_hasta
    //public function comensales_buscar_6($fecha_desde, $fecha_hasta, $id_personal_ivic, $id_personal_visitante, $filtro_personal_ivic, $filtro_personal_visitante){
    public function comensales_buscar_6($id_comedor_comida_tipo, $fecha_desde, $fecha_hasta, $filtro_personal_ivic, $filtro_personal_visitante, $estatus, $estados_id){
            $sql = "SELECT 
                          comensales.id AS comensales_id 
                        , comensales.id_personal_ivic AS comensales_id_personal_ivic  
                        , comensales.id_personal_visitante AS comensales_id_personal_visitante
                        , comensales.fecha AS comensales_fecha
                        , comensales.hora AS comensales_hora
                        , comedor_comida_tipo.nombre AS comedor_comida_tipo_nombre
                    FROM comensales, comedor_comida_tipo
                    WHERE
                            comensales.id_comedor_comida_tipo = comedor_comida_tipo.id
                    ";
            if($id_comedor_comida_tipo > 0 ){
                    $sql .= "
                        AND comensales.id_comedor_comida_tipo = '".$id_comedor_comida_tipo."'
                    ";                
            }            
            if($fecha_desde != "" && $fecha_hasta != "" ){
                    $sql .= "
                        AND comensales.fecha BETWEEN '".$fecha_desde."' AND '".$fecha_hasta."'
                    ";                
            }
            /*
            if($id_personal_ivic > 0 OR $id_personal_visitante > 0){
                    $sql .= "
                        AND (
                                comensales.id_personal_ivic = '".$id_personal_ivic."'
                            OR  comensales.id_personal_visitante = '".$id_personal_visitante."'
                        )
                    ";                
            } */
            if($filtro_personal_ivic == true){
                    $sql .= "
                        AND comensales.id_personal_ivic > 0
                    ";                
            }
            if($filtro_personal_visitante == true){
                    $sql .= "
                        AND comensales.id_personal_visitante > 0
                    ";
            }     
            if($estados_id > 0 ){
                    $sql .= "
                        AND comensales.id IN (
                                SELECT comensales_h_estado_temporal.comensales_id AS id 
                                FROM comensales_h_estado_temporal, comensales
                                WHERE 
                                        comensales_h_estado_temporal.comensales_id = comensales.id
                                    AND comensales_h_estado_temporal.estados_id = '".$estados_id."'
                                ";
                                if($id_comedor_comida_tipo > 0 ){
                                        $sql .= "
                                            AND comensales.id_comedor_comida_tipo = '".$id_comedor_comida_tipo."'
                                        ";                
                                }
                                if($fecha_desde != "" && $fecha_hasta != "" ){
                                        $sql .= "
                                            AND comensales.fecha BETWEEN '".$fecha_desde."' AND '".$fecha_hasta."'
                                        ";                
                                }                    
                                $sql .= "
                        )";
            }
            $sql .= "
                    AND comensales.estatus = '".$estatus."'
                    ORDER BY comensales.id ASC
                    ";  //echo "sql *<pre>".$sql."</pre>*";

            //return $sql;
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }    

    //comensales    
    //    id
    //    id_personal_ivic
    //    id_personal_visitante
    //    id_comedor_comida_tipo
    //    fecha
    //    hora
    //    id_usuario
    //    estatus
    public function comensales_buscar_7($id_personal_ivic){
            $sql = "SELECT * FROM comensales
                    WHERE   id_personal_ivic = '".$id_personal_ivic."'
                    ORDER BY id ASC
                    "; //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }
    //comensales    
    //    id
    //    id_personal_ivic
    //    id_personal_visitante
    //    id_comedor_comida_tipo
    //    fecha
    //    hora
    //    id_usuario   
    //    estatus
    public function comensales_buscar_11($id_personal_visitante){
            $sql = "SELECT * FROM comensales
                    WHERE   id_personal_visitante = '".$id_personal_visitante."'
                    ORDER BY id ASC
                    "; //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }    
    
    //comensales    
    //    id
    //    id_personal_ivic
    //    id_personal_visitante
    //    id_comedor_comida_tipo
    //    fecha
    //    hora
    //    id_usuario
    //    estatus
    public function comensales_buscar_10($fecha, $id_comedor_comida_tipo, $id_personal_ivic, $id_personal_visitante, $estatus){
            $sql = "SELECT * FROM comensales
                    WHERE   fecha = '".$fecha."' 
                        AND id_comedor_comida_tipo = '".$id_comedor_comida_tipo."'
                    ";
            if($id_personal_ivic > 0){
                    $sql .= "
                        AND id_personal_ivic = '".$id_personal_ivic."'
                    ";                
            }
            if($id_personal_visitante == true){
                    $sql .= "
                        AND id_personal_visitante = '".$id_personal_visitante."'
                    ";                
            }            
            $sql .= "
                    AND estatus = '".$estatus."'
                    ORDER BY id ASC
                    ";      //echo "<br />sql *".$sql."*";
            //return $sql;
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }    
    
    //comensales    
    //    id
    //    id_personal_ivic
    //    id_personal_visitante
    //    id_comedor_comida_tipo
    //    fecha
    //    hora
    //    id_usuario
    //    estatus
    public function comensales_insertar($id_personal_ivic, $id_personal_visitante, $id_comedor_comida_tipo, $fecha, $hora, $id_usuario, $estatus){
            if($id_personal_ivic > 0){      $id_personal_ivic       = "'".$id_personal_ivic."'";        }else{   $id_personal_ivic = 'NULL';   }
            if($id_personal_visitante > 0){ $id_personal_visitante  = "'".$id_personal_visitante."'";   }else{   $id_personal_visitante = 'NULL';   }
            $sql = "
            INSERT INTO comensales (id_personal_ivic, id_personal_visitante, id_comedor_comida_tipo, fecha, hora, id_usuario, estatus) VALUES
            (".$id_personal_ivic.", ".$id_personal_visitante.", '".$id_comedor_comida_tipo."', '".$fecha."', '".$hora."', '".$id_usuario."', '".$estatus."')
            ";      //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);    //echo "<hr />resultado *".$resultado."*";
            return $this->db->insert_id();
    }
    

    //comensales    
    //    id
    //    id_personal_ivic
    //    id_personal_visitante
    //    id_comedor_comida_tipo
    //    fecha
    //    hora
    //    id_usuario
    //    estatus
    public function comensales_editar($id, $estatus){
            $sql = "
                    UPDATE comensales SET
                          estatus           =   '".$estatus."'
                    WHERE id = '".$id."'
            ";      //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            return $resultado;
    }
/*
    //comensales    
    //    id
    //    id_personal_ivic
    //    id_personal_visitante
    //    id_comedor_comida_tipo
    //    fecha
    //    hora
    //    id_usuario
    //    estatus
    public function personal_editar_2($id, $imagen_nombre){
            if($imagen_nombre == ""){   $imagen_nombre = 'NULL';   }else{ $imagen_nombre = "'".$imagen_nombre."'"; }
            $sql = "
                    UPDATE personal SET
                           imagen_nombre           =   ".$imagen_nombre."
                    WHERE id = '".$id."'
            ";      //echo "<br />sql <pre>*".$sql."*</pre>";
            $resultado = $this->db->query($sql);
            return $resultado;
    }    
    
    //comensales    
    //    id
    //    id_personal_ivic
    //    id_personal_visitante
    //    id_comedor_comida_tipo
    //    fecha
    //    hora
    //    id_usuario
    //    estatus
    public function personal_eliminar($id){
            $sql = "
                    DELETE FROM personal WHERE id = '".$id."'
            ";      //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            return $resultado;
    }
*/
}