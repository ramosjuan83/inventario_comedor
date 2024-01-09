<?php
class Personal_ivic_model extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }

    //personal_ivic
    //    id
    //    cedula
    //    nombres
    //    apellidos
    //    id_cargo
    //    id_gerencia
    //    id_gerencia_2
    //    id_tipo
    //    id_condicion
    //    estado
    //    imagen_nombre
    //    firma_nombre
    //    carnet_codigo
    //    id_departamento
    //    id_categoria
    //    fecha_ingreso
    //    fecha_no_activo
    public function personal_ivic_num_reg($b_texto, $id_cargo, $id_gerencia, $estado_1, $b_matriz_id_cargo){
            $sql = "
                    SELECT id FROM personal_ivic WHERE
                        (
                            carnet_codigo LIKE '%".$b_texto."%'
                        OR  nombres LIKE '%".$b_texto."%'
                        OR  apellidos LIKE '%".$b_texto."%'
                        OR  cedula LIKE '%".$b_texto."%'
                        )
                    ";
            if($id_cargo > 0){
                $sql .= " AND id_cargo = '".$id_cargo."'";
            }
            if($id_gerencia > 0){
                $sql .= " AND id_gerencia = '".$id_gerencia."'";
            }
            if($estado_1 == 1){
                $sql .= " AND estado = '1'";
            }
            if($estado_1 == 2){
                $sql .= " AND (
                               estado = '2'
                            OR estado = '3'
                            OR estado = '4'
                            OR estado = '5'
                        )
                ";
            }
            if($b_matriz_id_cargo != false){
                $sql .= " AND (";
                for($i = 0; $i < count($b_matriz_id_cargo); $i++){
                    if($i == 0){
                        $sql .= " id_cargo = '".$b_matriz_id_cargo[$i]."'";    
                    }else{
                        $sql .= " OR id_cargo = '".$b_matriz_id_cargo[$i]."'";
                    }
                }
                $sql .= ")";
            }
            $sql .= " 
            "; //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            return $resultado->num_rows();
    }

    //personal_ivic
    //    id
    //    cedula
    //    nombres
    //    apellidos
    //    id_cargo
    //    id_gerencia
    //    id_gerencia_2
    //    id_tipo
    //    id_condicion
    //    estado
    //    imagen_nombre
    //    firma_nombre
    //    carnet_codigo
    //    id_departamento
    //    id_categoria
    //    fecha_ingreso
    //    fecha_no_activo
    public function personal_ivic_buscar($b_texto, $id_cargo, $id_gerencia, $estado_1, $b_matriz_id_cargo, $por_pagina, $segmento){
            $sql = "SELECT * FROM personal_ivic WHERE
                        (
                            carnet_codigo LIKE '%".$b_texto."%'
                        OR  nombres LIKE '%".$b_texto."%'
                        OR  apellidos LIKE '%".$b_texto."%'
                        OR  cedula LIKE '%".$b_texto."%'
                        )
                    ";
            if($id_cargo > 0){
                $sql .= " AND id_cargo = '".$id_cargo."'";
            }
            if($id_gerencia > 0){
                $sql .= " AND id_gerencia = '".$id_gerencia."'";
            }
            if($estado_1 == 1){
                $sql .= " AND estado = '1'";
            }
            if($estado_1 == 2){
                $sql .= " AND (
                               estado = '2'
                            OR estado = '3'
                            OR estado = '4'
                            OR estado = '5'
                        )
                ";
            }
            if($b_matriz_id_cargo != false){
                $sql .= " AND (";
                for($i = 0; $i < count($b_matriz_id_cargo); $i++){
                    if($i == 0){
                        $sql .= " id_cargo = '".$b_matriz_id_cargo[$i]."'";    
                    }else{
                        $sql .= " OR id_cargo = '".$b_matriz_id_cargo[$i]."'";
                    }
                }
                $sql .= ")";
            }
            $sql .= " 
                    ORDER BY id DESC ";
            if($segmento > 0 or $por_pagina > 0){
                $sql .= " LIMIT ".$segmento.", ".$por_pagina;  
            }            
            //echo "<br />sql *<pre>".$sql."</pre>*";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }

    //personal_ivic
    //    id
    //    cedula
    //    nombres
    //    apellidos
    //    id_cargo
    //    id_gerencia
    //    id_gerencia_2
    //    id_tipo
    //    id_condicion
    //    estado
    //    imagen_nombre
    //    firma_nombre
    //    carnet_codigo
    //    id_departamento
    //    id_categoria
    //    fecha_ingreso
    //    fecha_no_activo
    public function personal_ivic_buscar_2($id){
            $sql = "SELECT * FROM personal_ivic
                    WHERE id = '".$id."'";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }

    //personal_ivic
    //    id
    //    cedula
    //    nombres
    //    apellidos
    //    id_cargo
    //    id_gerencia
    //    id_gerencia_2
    //    id_tipo
    //    id_condicion
    //    estado
    //    imagen_nombre
    //    firma_nombre
    //    carnet_codigo
    //    id_departamento
    //    id_categoria
    //    fecha_ingreso
    //    fecha_no_activo
    public function personal_ivic_buscar_3(){
            $sql = "SELECT * FROM personal_ivic ORDER BY cedula ASC";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }    

    //personal_ivic
    //    id
    //    cedula
    //    nombres
    //    apellidos
    //    id_cargo
    //    id_gerencia
    //    id_gerencia_2
    //    id_tipo
    //    id_condicion
    //    estado
    //    imagen_nombre
    //    firma_nombre
    //    carnet_codigo
    //    id_departamento
    //    id_categoria
    //    fecha_ingreso
    //    fecha_no_activo
    public function personal_ivic_buscar_4($cedula){
            $sql = "SELECT * FROM personal_ivic
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
    
    //personal_ivic
    //    id
    //    cedula
    //    nombres
    //    apellidos
    //    id_cargo
    //    id_gerencia
    //    id_gerencia_2
    //    id_tipo
    //    id_condicion
    //    estado
    //    imagen_nombre
    //    firma_nombre
    //    carnet_codigo
    //    id_departamento
    //    id_categoria
    //    fecha_ingreso
    //    fecha_no_activo
    public function personal_ivic_buscar_5($carnet_codigo, $id){
            $sql = "SELECT * FROM personal_ivic
                    WHERE 
                         carnet_codigo = '".$carnet_codigo."' ";
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
    
    public function personal_ivic_buscar_6($carnet_codigo){
            $sql = "SELECT * FROM personal_ivic
                    WHERE 
                         carnet_codigo = '".$carnet_codigo."' ";
            //return $sql;
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }

    //personal_ivic
    //    id
    //    cedula
    //    nombres
    //    apellidos
    //    id_cargo
    //    id_gerencia
    //    id_gerencia_2
    //    id_tipo
    //    id_condicion
    //    estado
    //    imagen_nombre
    //    firma_nombre
    //    carnet_codigo
    //    id_departamento
    //    id_categoria
    //    fecha_ingreso
    //    fecha_no_activo
    public function personal_ivic_buscar_7($cedula, $carnet_codigo){
            $sql = "SELECT * FROM personal_ivic
                    WHERE 
                           cedula = '".$cedula."' 
                        OR carnet_codigo = '".$carnet_codigo."'
                    ";
            //return $sql;
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }
    
    //personal_ivic
    //    id
    //    cedula
    //    nombres
    //    apellidos
    //    id_cargo
    //    id_gerencia
    //    id_gerencia_2
    //    id_tipo
    //    id_condicion
    //    estado
    //    imagen_nombre
    //    firma_nombre
    //    carnet_codigo
    //    id_departamento
    //    id_categoria
    //    fecha_ingreso
    //    fecha_no_activo
    public function personal_ivic_buscar_8($id_cargo){
            $sql = "SELECT * FROM personal_ivic
                    WHERE id_cargo = '".$id_cargo."'";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }    
    
    //personal_ivic
    //    id
    //    cedula
    //    nombres
    //    apellidos
    //    id_cargo
    //    id_gerencia
    //    id_gerencia_2
    //    id_tipo
    //    id_condicion
    //    estado
    //    imagen_nombre
    //    firma_nombre
    //    carnet_codigo
    //    id_departamento
    //    id_categoria
    //    fecha_ingreso
    //    fecha_no_activo
    public function personal_ivic_buscar_9($id_departamento){
            $sql = "SELECT * FROM personal_ivic
                    WHERE id_departamento = '".$id_departamento."'";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }    
    
    public function personal_ivic_buscar_10($id_gerencia){
            $sql = "SELECT * FROM personal_ivic
                    WHERE id_gerencia = '".$id_gerencia."'";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }    
    
    //personal_ivic
    //    id
    //    cedula
    //    nombres
    //    apellidos
    //    id_cargo
    //    id_gerencia
    //    id_gerencia_2
    //    id_tipo
    //    id_condicion
    //    estado
    //    imagen_nombre
    //    firma_nombre
    //    carnet_codigo
    //    id_departamento
    //    id_categoria
    //    fecha_ingreso
    //    fecha_no_activo
    public function personal_ivic_insertar($cedula, $nombres, $apellidos, $id_cargo, $id_gerencia, $id_gerencia_2, $id_tipo, $id_condicion, $estado, $imagen_nombre, $carnet_codigo, $id_departamento, $id_categoria, $fecha_ingreso){
            if($id_cargo > 0){ }else{   $id_cargo = 'NULL';   }
            if($id_gerencia > 0){ }else{   $id_gerencia = 'NULL';   }
            if($id_gerencia_2 > 0){ }else{   $id_gerencia_2 = 'NULL';   }        
            if($id_tipo > 0){ }else{   $id_tipo = 'NULL';   }
            if($id_condicion > 0){ }else{   $id_condicion = 'NULL';   }
            $sql = "
            INSERT INTO personal_ivic (cedula, nombres, apellidos, id_cargo, id_gerencia, id_gerencia_2, id_tipo, id_condicion, estado, imagen_nombre, carnet_codigo, id_departamento, id_categoria, fecha_ingreso) VALUES
            ('".$cedula."', '".$nombres."', '".$apellidos."', ".$id_cargo.", ".$id_gerencia.", ".$id_gerencia_2.", ".$id_tipo.", ".$id_condicion.", '".$estado."', '".$imagen_nombre."', '".$carnet_codigo."', '".$id_departamento."', '".$id_categoria."', '".$fecha_ingreso."')
            ";      //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);    //echo "<hr />resultado *".$resultado."*";
            return $this->db->insert_id();
    }

    //personal_ivic
    //    id
    //    cedula
    //    nombres
    //    apellidos
    //    id_cargo
    //    id_gerencia
    //    id_gerencia_2
    //    id_tipo
    //    id_condicion
    //    estado
    //    imagen_nombre
    //    firma_nombre
    //    carnet_codigo
    //    id_departamento
    //    id_categoria
    //    fecha_ingreso
    //    fecha_no_activo
    public function personal_ivic_editar($id, $nombres, $apellidos, $id_cargo, $id_gerencia, $id_gerencia_2, $id_tipo, $id_condicion, $estado, $carnet_codigo, $id_departamento, $id_categoria, $fecha_ingreso){
            if($id_cargo > 0){ }else{   $id_cargo = 'NULL';   }
            if($id_gerencia > 0){ }else{   $id_gerencia = 'NULL';   }        
            if($id_gerencia_2 > 0){ }else{   $id_gerencia_2 = 'NULL';   }        
            $sql = "
                    UPDATE personal_ivic SET
                          nombres           =   '".$nombres."'
                        , apellidos         =   '".$apellidos."'
                        , id_cargo          =   ".$id_cargo."
                        , id_gerencia       =   ".$id_gerencia."
                        , id_gerencia_2     =   ".$id_gerencia_2."
                        , id_tipo           =   ".$id_tipo."
                        , id_condicion      =   ".$id_condicion."
                        , estado            =   '".$estado."'
                        , carnet_codigo     =   '".$carnet_codigo."'
                        , id_departamento   =   '".$id_departamento."'
                        , id_categoria      =   '".$id_categoria."'
                        , fecha_ingreso     =   '".$fecha_ingreso."'
                    WHERE id = '".$id."'
            ";      //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            return $resultado;
    }

    //personal_ivic
    //    id
    //    cedula
    //    nombres
    //    apellidos
    //    id_cargo
    //    id_gerencia
    //    id_gerencia_2
    //    id_tipo
    //    id_condicion
    //    estado
    //    imagen_nombre
    //    firma_nombre
    //    carnet_codigo
    //    id_departamento
    //    id_categoria
    //    fecha_ingreso
    //    fecha_no_activo
    public function personal_ivic_editar_2($id, $imagen_nombre){
            if($imagen_nombre == ""){   $imagen_nombre = 'NULL';   }else{ $imagen_nombre = "'".$imagen_nombre."'"; }
            $sql = "
                    UPDATE personal_ivic SET
                           imagen_nombre           =   ".$imagen_nombre."
                    WHERE id = '".$id."'
            ";      //echo "<br />sql <pre>*".$sql."*</pre>";
            $resultado = $this->db->query($sql);
            return $resultado;
    }    
    
    //personal_ivic
    //    id
    //    cedula
    //    nombres
    //    apellidos
    //    id_cargo
    //    id_gerencia
    //    id_gerencia_2
    //    id_tipo
    //    id_condicion
    //    estado
    //    imagen_nombre
    //    firma_nombre
    //    carnet_codigo
    //    id_departamento
    //    id_categoria
    //    fecha_ingreso
    //    fecha_no_activo
    public function personal_ivic_editar_3($id, $fecha_no_activo){
            if($fecha_no_activo == ""){   $fecha_no_activo = 'NULL';   }else{ $fecha_no_activo = "'".$fecha_no_activo."'"; }
            $sql = "
                    UPDATE personal_ivic SET
                           fecha_no_activo           =   ".$fecha_no_activo."
                    WHERE id = '".$id."'
            ";      echo "<br />sql <pre>*".$sql."*</pre>";
            $resultado = $this->db->query($sql);
            return $resultado;
    }    
    
    //personal_ivic
    //    id
    //    cedula
    //    nombres
    //    apellidos
    //    id_cargo
    //    id_gerencia
    //    id_gerencia_2
    //    id_tipo
    //    id_condicion
    //    estado
    //    imagen_nombre
    //    firma_nombre
    //    carnet_codigo
    //    id_departamento
    //    id_categoria
    //    fecha_ingreso
    //    fecha_no_activo
    public function personal_ivic_eliminar($id){
            $sql = "
                    DELETE FROM personal_ivic WHERE id = '".$id."'
            ";      //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            return $resultado;
    }

}