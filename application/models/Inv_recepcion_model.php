<?php
class Inv_recepcion_model extends CI_Model{
    
    function __construct(){
        parent::__construct();
        $this->load->model('Inv_movimiento_inventario_model');
        
    }

    //recepcion
    //    id
    //    nombre
    public function inv_recepcion_num_reg($b_texto){
            $sql = "
                    SELECT id FROM inv_recepcion WHERE
                            id LIKE '%".$b_texto."%'
                        OR  observacion LIKE '%".$b_texto."%'
            "; //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            return $resultado->num_rows();
    }
    
    //recepcion
    //    id
    //    nombre    
    public function inv_recepcion_buscar($b_texto, $por_pagina, $segmento){
            $sql = "SELECT date_format(fecha_ingreso, '%d/%m/%Y') as fecha_ingreso_2,date_format(fecha_vencimiento, '%d/%m/%Y') as fecha_vencimiento_2,inv_recepcion.*,inv_articulo.nombre as nombre_articulo,inv_almacen.nombre as nombre_almacen,
                            (SELECT saldo_final FROM inv_movimiento_inventario WHERE id_articulo = inv_recepcion.id_articulo AND id_almacen=inv_recepcion.id_almacen ORDER BY id DESC LIMIT 1) as saldo,inv_recepcion.id_status
                             FROM inv_recepcion INNER JOIN inv_articulo ON inv_articulo.id=inv_recepcion.id_articulo INNER JOIN inv_almacen ON inv_almacen.id=inv_recepcion.id_almacen WHERE
                             (inv_recepcion.id LIKE '%".$b_texto."%'
                        OR  inv_recepcion.observacion LIKE '%".$b_texto."%' OR date_format(fecha_ingreso, '%d/%m/%Y') LIKE '%".$b_texto."%' OR date_format(fecha_vencimiento, '%d/%m/%Y') LIKE '%".$b_texto."%' OR inv_articulo.nombre LIKE '%".$b_texto."%' OR inv_almacen.nombre LIKE '%".$b_texto."%')
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
 
    
    //recepcion
    //    id
    //    nombre
    public function inv_recepcion_buscar_2($id){
            $sql = "SELECT *, inv_recepcion.id as id, date_format(fecha_ingreso, '%d/%m/%Y') as fecha_ingreso_2,capacidad_almacen,0 as disponibilidad  ,(SELECT saldo_final FROM inv_movimiento_inventario WHERE id_articulo = inv_recepcion.id_articulo AND id_almacen=inv_recepcion.id_almacen ORDER BY id DESC LIMIT 1) as saldo FROM inv_recepcion
                    INNER JOIN inv_inventario INV ON INV.id_articulo=inv_recepcion.id_articulo AND INV.id_almacen=inv_recepcion.id_almacen
                    WHERE inv_recepcion.id = '".$id."' AND inv_recepcion.id_status=1"; //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){

                foreach ($resultado->result() as $item)
                {
                    $resul=$this->Inv_movimiento_inventario_model->inv_movimiento_saldo_actual($item->id_articulo,$item->id_almacen);
                    foreach ($resul as $row){
                        // asigno saldo de al antiguo arreglo

                        $item->disponibilidad=(floatval($item->capacidad_almacen)-floatval($row['saldo_final'])+floatval($item->cantidad));
                    }
                       
                }


                return $resultado->result();
            }else{
                return false;
            }
    }

    //recepcion
    //    id
    //    nombre
    public function inv_recepcion_buscar_3(){
            $sql = "SELECT * FROM inv_recepcion ORDER BY nombre ASC";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }    

    //recepcion
    //    id
    //    nombre
    public function inv_recepcion_buscar_5($nombre, $id){
            $sql = "SELECT * FROM inv_recepcion
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
    
    //recepcion
    //    id
    //    nombre    
    public function inv_recepcion_buscar_6($nombre){
            $sql = "SELECT * FROM inv_recepcion
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
    
    public function inv_total_recepcion($id_articulo,$id_almacen,$fecha_desde,$fecha_hasta){
        $sql = "SELECT SUM(cantidad) as cantidad FROM inv_recepcion
        WHERE id_articulo = '".$id_articulo."' and id_almacen = '".$id_almacen."' and fecha_ingreso between '".$fecha_desde."' and '".$fecha_hasta."' and id_status=1 GROUP BY id_articulo,id_almacen";
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
    
    //recepcion
    //    id
    //    nombre
    public function inv_recepcion_insertar($nombre,$id_articulo,$fecha_ingreso,$id_almacen,$cantidad,$fecha_vencimiento){
            //if($id_cargo > 0){ }else{   $id_cargo = 'NULL';   }
            //if($id_recepcion > 0){ }else{   $id_recepcion = 'NULL';   }
            // $sql = "
            // INSERT INTO inv_recepcion (observacion,id_articulo,fecha_ingreso,id_almacen,cantidad) VALUES
            // ('".$nombre."','".$id_articulo."','".$fecha_ingreso."','".$id_almacen."','".$cantidad."')
            // ";      //echo "<br />sql *".$sql."*";
            // $resultado = $this->db->query($sql);
            // $ultimoId = $this->db->insert_id();

            $this->db->insert("inv_recepcion", [
                "observacion" => $nombre,
                "id_articulo" => $id_articulo,
                "fecha_ingreso" => $fecha_ingreso,
                "fecha_vencimiento" => $fecha_vencimiento,
                "id_almacen" => $id_almacen,
                "cantidad" => $cantidad,
                "id_status"=>1
            ]);

            $ultimoId=$this->db->insert_id();

            //Registra movimiento en inventario
            $this->Inv_movimiento_inventario_model->inv_movimiento_inventario_insertar($id_articulo,$id_almacen,$fecha_ingreso,$cantidad,$ultimoId,'recepcion',$nombre);
            
            
            //echo "<hr />resultado *".$resultado."*";
            return $this->db->insert_id();


    }    
    
    //recepcion
    //    id
    //    nombre
    public function inv_recepcion_editar($id,$id_articulo,$fecha_ingreso,$id_almacen,$cantidad, $nombre, $fecha_vencimiento){

 
                $data = array(
                        'observacion' => $nombre,
                        'id_articulo' => $id_articulo,
                        'fecha_ingreso' => $fecha_ingreso,
                        'fecha_vencimiento' => $fecha_vencimiento,
                        'id_almacen' => $id_almacen,
                        'cantidad'=>$cantidad,
                );
        
                $resultado=$this->db->update('inv_recepcion', $data, array('id' => $id));

                $id_mov='';
                $sql = "SELECT * FROM inv_movimiento_inventario
                        WHERE id_documento = '".$id."' and tipo_documento = 'recepcion'";
                //return $sql;
                $resultado2 = $this->db->query($sql);
                foreach ($resultado2->result_array() as $row)
                {
                        $id_mov=$row['id'];
                }

                // Actualiza movimiento de inventario
                $this->Inv_movimiento_inventario_model->inv_movimiento_inventario_update($id,'recepcion',$id_articulo,$id_almacen,$fecha_ingreso,$cantidad,0,$nombre,$id_mov);

            return $resultado;
    } 

    //recepcion
    //    id
    //    nombre    
    public function inv_recepcion_eliminar($id){
            $sql = "
                    UPDATE inv_recepcion SET id_status=2  WHERE id = '".$id."'
            ";      //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);

            $this->Inv_movimiento_inventario_model->inv_movimiento_inventario_eliminar($id,'Recepcion');
            return $resultado;
    }        
    
}