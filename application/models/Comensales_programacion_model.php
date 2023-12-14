<?php
class Comensales_programacion_model extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }
   
    

    //comensales_programacion
    //    id
    //    id_personal_ivic
    //    id_personal_visitante
    //    id_comedor_comida_tipo
    //    fecha
    //    hora
    //    id_usuario
    //    estatus
    //    estatus_2
    public function comensales_programacion_num_reg($b_texto){
            $sql = "
                    SELECT id 
                    FROM comensales_programacion
                    WHERE
                        comensales_programacion.id_personal_ivic IN (
                            SELECT id FROM personal_ivic 
                            WHERE
                                   cedula LIKE '%".$b_texto."%'
                                OR nombres LIKE '%".$b_texto."%'
                                OR apellidos LIKE '%".$b_texto."%'
                                OR carnet_codigo LIKE '%".$b_texto."%'
                        )
                        OR
                        comensales_programacion.id_personal_visitante IN (
                            SELECT id FROM personal_visitante 
                            WHERE
                                   cedula LIKE '%".$b_texto."%'
                                OR nombres LIKE '%".$b_texto."%'
                                OR apellidos LIKE '%".$b_texto."%'
                        )
            "; //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            return $resultado->num_rows();
    }

    
    //comensales_programacion
    //    id
    //    id_personal_ivic
    //    id_personal_visitante
    //    id_comedor_comida_tipo
    //    fecha
    //    hora
    //    id_usuario
    //    estatus
    //    estatus_2
    public function comensales_programacion_buscar($b_texto, $por_pagina, $segmento){
            $sql = "SELECT    comensales_programacion.id AS comensales_programacion_id
                            , comensales_programacion.id_personal_ivic AS comensales_programacion_id_personal_ivic
                            , comensales_programacion.id_personal_visitante AS comensales_programacion_id_personal_visitante
                            , comensales_programacion.id_comedor_comida_tipo AS comensales_programacion_id_comedor_comida_tipo
                            , comensales_programacion.fecha AS comensales_programacion_fecha
                            , comensales_programacion.hora AS comensales_programacion_hora
                            , comensales_programacion.estatus AS comensales_programacion_estatus
                            , comensales_programacion.estatus_2 AS comensales_programacion_estatus_2
                    FROM comensales_programacion
                    WHERE
                        comensales_programacion.id_personal_ivic IN (
                            SELECT id FROM personal_ivic 
                            WHERE
                                   cedula LIKE '%".$b_texto."%'
                                OR nombres LIKE '%".$b_texto."%'
                                OR apellidos LIKE '%".$b_texto."%'
                                OR carnet_codigo LIKE '%".$b_texto."%'
                        )
                        OR
                        comensales_programacion.id_personal_visitante IN (
                            SELECT id FROM personal_visitante 
                            WHERE
                                   cedula LIKE '%".$b_texto."%'
                                OR nombres LIKE '%".$b_texto."%'
                                OR apellidos LIKE '%".$b_texto."%'
                        )                        
                    ORDER BY comensales_programacion.id DESC
                    LIMIT ".$segmento.", ".$por_pagina;  //echo "<br />sql *<pre>".$sql."</pre>*";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }    
    
 
    //comensales_programacion
    //    id
    //    id_personal_ivic
    //    id_personal_visitante
    //    id_comedor_comida_tipo
    //    fecha
    //    hora
    //    id_usuario
    //    estatus
    //    estatus_2
    public function comensales_programacion_buscar_2($id){
            $sql = "SELECT * FROM comensales_programacion
                    WHERE id = '".$id."'"; //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }

    //comensales_programacion
    //    id
    //    id_personal_ivic
    //    id_personal_visitante
    //    id_comedor_comida_tipo
    //    fecha
    //    hora
    //    id_usuario
    //    estatus
    //    estatus_2
    public function comensales_programacion_buscar_3($fecha, $hora, $estatus_2){
            $sql = "SELECT * FROM comensales_programacion
                    WHERE
                            fecha < '".$fecha."'
                        OR (
                                fecha = '".$fecha."'
                            AND hora <= '".$hora."'
                        ) 
                        AND estatus_2 = '".$estatus_2."'
                    ";      //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }

    //comensales_programacion
    //    id
    //    id_personal_ivic
    //    id_personal_visitante
    //    id_comedor_comida_tipo
    //    fecha
    //    hora
    //    id_usuario
    //    estatus
    //    estatus_2
    //BUSCA LOS ULTIMOS 10 comensales
    public function comensales_programacion_buscar_4($id_comedor_comida_tipo, $fecha){
            $sql = "SELECT * 
                    FROM comensales_programacion
                    WHERE
                            id_comedor_comida_tipo = '".$id_comedor_comida_tipo."'
                        AND fecha = '".$fecha."'
                    ORDER BY id DESC
                    LIMIT 10
                    ";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }    
    
/*    
    //comensales_programacion
    //    id
    //    id_personal_ivic
    //    id_personal_visitante
    //    id_comedor_comida_tipo
    //    fecha
    //    hora
    //    id_usuario
    //    estatus
    //    estatus_2
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
    
    //comensales_programacion
    //    id
    //    id_personal_ivic
    //    id_personal_visitante
    //    id_comedor_comida_tipo
    //    fecha
    //    hora
    //    id_usuario
    //    estatus
    //    estatus_2   
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
*/
  
    //comensales_programacion
    //    id
    //    id_personal_ivic
    //    id_personal_visitante
    //    id_comedor_comida_tipo
    //    fecha
    //    hora
    //    id_usuario
    //    estatus
    //    estatus_2     
    public function comensales_programacion_buscar_10($fecha, $id_comedor_comida_tipo, $id_personal_ivic, $id_personal_visitante){
            $sql = "SELECT * FROM comensales_programacion
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
    
    
    //comensales_programacion
    //    id
    //    id_personal_ivic
    //    id_personal_visitante
    //    id_comedor_comida_tipo
    //    fecha
    //    hora
    //    id_usuario
    //    estatus
    //    estatus_2
    public function comensales_programacion_insertar($id_personal_ivic, $id_personal_visitante, $id_comedor_comida_tipo, $fecha, $hora, $id_usuario, $estatus, $estatus_2){
            if($id_personal_ivic > 0){ }else{   $id_personal_ivic = 'NULL';   }
            if($id_personal_visitante > 0){ }else{   $id_personal_visitante = 'NULL';   }
            $sql = "
            INSERT INTO comensales_programacion (id_personal_ivic, id_personal_visitante, id_comedor_comida_tipo, fecha, hora, id_usuario, estatus, estatus_2) VALUES
            (".$id_personal_ivic.", ".$id_personal_visitante.", '".$id_comedor_comida_tipo."', '".$fecha."', '".$hora."', '".$id_usuario."', '".$estatus."', '".$estatus_2."')
            ";      //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);    //echo "<hr />resultado *".$resultado."*";
            return $this->db->insert_id();
    }    

    //comensales_programacion
    //    id
    //    id_personal_ivic
    //    id_personal_visitante
    //    id_comedor_comida_tipo
    //    fecha
    //    hora
    //    id_usuario
    //    estatus
    //    estatus_2
    public function comensales_programacion_editar($id, $estatus_2){
            $sql = "
                    UPDATE comensales_programacion SET
                           estatus_2           =   '".$estatus_2."'
                    WHERE id = '".$id."'
            ";      //echo "<br />sql <pre>*".$sql."*</pre>";
            $resultado = $this->db->query($sql);
            return $resultado;
    } 

    //comensales_programacion
    //    id
    //    id_personal_ivic
    //    id_personal_visitante
    //    id_comedor_comida_tipo
    //    fecha
    //    hora
    //    id_usuario
    //    estatus
    //    estatus_2
    public function comensales_programacion_eliminar($id){
            $sql = "
                    DELETE FROM comensales_programacion WHERE id = '".$id."'
            ";      //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            return $resultado;
    }    

}