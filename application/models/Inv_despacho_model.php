<?php
class Inv_despacho_model extends CI_Model{
    
    function __construct(){
        parent::__construct();
        $this->load->model('Inv_movimiento_inventario_model');
    }

    //despacho
    //    id
    //    nombre
    public function inv_despacho_num_reg($b_texto){
            $sql = "
                    SELECT id FROM inv_despacho WHERE
                            id LIKE '%".$b_texto."%'
                        OR  observacion LIKE '%".$b_texto."%'
            "; //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            return $resultado->num_rows();
    }
    
    //despacho
    //    id
    //    nombre    
    public function inv_despacho_buscar($b_texto, $por_pagina, $segmento){
            $sql = "SELECT  (SELECT saldo_final FROM inv_movimiento_inventario WHERE id_articulo = inv_despacho.id_articulo AND id_almacen=inv_despacho.id_almacen ORDER BY id DESC LIMIT 1) as saldo,date_format(fecha_egreso, '%d/%m/%Y') as fecha_egreso_2,inv_despacho.*,inv_articulo.nombre as nombre_articulo,inv_almacen.nombre as nombre_almacen FROM inv_despacho INNER JOIN inv_articulo ON inv_articulo.id=inv_despacho.id_articulo INNER JOIN inv_almacen ON inv_almacen.id=inv_despacho.id_almacen WHERE
                            inv_despacho.id LIKE '%".$b_texto."%'
                        OR  inv_despacho.observacion LIKE '%".$b_texto."%' OR date_format(fecha_egreso, '%d/%m/%Y') LIKE '%".$b_texto."%' OR inv_articulo.nombre LIKE '%".$b_texto."%' OR inv_almacen.nombre LIKE '%".$b_texto."%'
                    ORDER BY inv_articulo.nombre ASC";

            if(!empty($segmento)){
                $sql=$sql." LIMIT ".$segmento.", ".$por_pagina;  //echo "<br />sql *".$sql."*";
            }

            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }    
 
    
    //despacho
    //    id
    //    nombre
    public function inv_despacho_buscar_2($id){
            $sql = "SELECT *, date_format(fecha_egreso, '%d/%m/%Y') as fecha_egreso_2 FROM inv_despacho
                    WHERE id = '".$id."'"; //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){

                foreach ($resultado->result() as $item)
                {
                    $resul=$this->Inv_movimiento_inventario_model->inv_movimiento_saldo_actual($item->id_articulo,$item->id_almacen);
                    foreach ($resul as $row){
                        // asigno saldo de al antiguo arreglo

                        $item->disponibilidad=(floatval($row['saldo_final'])+floatval($item->cantidad));
                    }
                       
                }

                return $resultado->result();
            }else{
                return false;
            }
    }

    //despacho
    //    id
    //    nombre
    public function inv_despacho_buscar_3(){
            $sql = "SELECT * FROM inv_despacho ORDER BY nombre ASC";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }    

    //despacho
    //    id
    //    nombre
    public function inv_despacho_buscar_5($nombre, $id){
            $sql = "SELECT * FROM inv_despacho
                    WHERE 
                         observacion = '".$nombre."' ";
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
    
    //despacho
    //    id
    //    nombre    
    public function inv_despacho_buscar_6($nombre){
            $sql = "SELECT * FROM inv_despacho
                    WHERE 
                         observacion = '".$nombre."' ";
            //return $sql;
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }   
    
    
    public function inv_total_despacho($id_articulo,$id_almacen,$fecha_desde,$fecha_hasta){
        $sql = "SELECT SUM(cantidad) as cantidad FROM inv_despacho
        WHERE id_articulo = '".$id_articulo."' and id_almacen = '".$id_almacen."' and fecha_egreso between '".$fecha_desde."' and '".$fecha_hasta."' and id_status=1 GROUP BY id_articulo,id_almacen";
        //return $sql;
        $resultado = $this->db->query($sql);
        if( $resultado->num_rows() > 0 ){
            $cantidad=0;
            foreach($resultado->result() as $item){
                $cantidad=$item->cantidad;
            }

            return $cantidad;

        }else{
            return 0;
        }
    }
    
    //despacho
    //    id
    //    nombre
    public function inv_despacho_insertar($nombre,$id_articulo,$fecha_egreso,$id_almacen,$cantidad){


            $this->db->insert("inv_despacho", [
                "observacion" => $nombre,
                "id_articulo" => $id_articulo,
                "fecha_egreso" => $fecha_egreso,
                "id_almacen" => $id_almacen,
                "cantidad" => $cantidad,
                "id_status"=>1
            ]);

            $ultimoId=$this->db->insert_id();

            //Registra movimiento en inventario
            $this->Inv_movimiento_inventario_model->inv_movimiento_inventario_insertar($id_articulo,$id_almacen,$fecha_egreso,$cantidad,$ultimoId,'despacho',$nombre);

            return $this->db->insert_id();
    }    
    
    //despacho
    //    id
    //    nombre
    public function inv_despacho_editar($id,$id_articulo,$fecha_egreso,$id_almacen,$cantidad, $nombre){
            $data = array(
                'observacion' => $nombre,
                'id_articulo' => $id_articulo,
                'fecha_egreso' => $fecha_egreso,
                'id_almacen' => $id_almacen,
                'cantidad'=>$cantidad,
            );

            $resultado=$this->db->update('inv_despacho', $data, array('id' => $id));

            $id_mov='';
            $sql = "SELECT * FROM inv_movimiento_inventario
                    WHERE id_documento = '".$id."' and tipo_documento = 'despacho'";
            //return $sql;
            $resultado2 = $this->db->query($sql);
            foreach ($resultado2->result_array() as $row)
            {
                    $id_mov=$row['id'];
            }


            // Actualiza movimiento de inventario
            $this->Inv_movimiento_inventario_model->inv_movimiento_inventario_update($id,'despacho',$id_articulo,$id_almacen,$fecha_egreso,0,$cantidad,$nombre,$id_mov);

            return $resultado;
    } 

    //despacho
    //    id
    //    nombre    
    public function inv_despacho_eliminar($id){
        $sql = "
        UPDATE inv_despacho SET id_status=2  WHERE id = '".$id."'
        ";      //echo "<br />sql *".$sql."*";
        $resultado = $this->db->query($sql);

        $this->Inv_movimiento_inventario_model->inv_movimiento_inventario_eliminar($id,'Despacho');
        return $resultado;
    }        
    
}