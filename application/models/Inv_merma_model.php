<?php
class Inv_merma_model extends CI_Model{
    
    function __construct(){
        parent::__construct();
        $this->load->model('Inv_movimiento_inventario_model');
    }

    //merma
    //    id
    //    nombre
    public function inv_merma_num_reg($b_texto){
            $sql = "
                    SELECT id FROM inv_merma WHERE
                            id LIKE '%".$b_texto."%'
                        OR  observacion LIKE '%".$b_texto."%'
            "; //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            return $resultado->num_rows();
    }
    
    //merma
    //    id
    //    nombre    
    public function inv_merma_buscar($b_texto, $por_pagina, $segmento){
            $sql = "SELECT date_format(fecha_merma, '%d/%m/%Y') as fecha_merma_2,inv_merma.*,inv_articulo.nombre as nombre_articulo,inv_almacen.nombre as nombre_almacen FROM inv_merma INNER JOIN inv_articulo ON inv_articulo.id=inv_merma.id_articulo INNER JOIN inv_almacen ON inv_almacen.id=inv_merma.id_almacen WHERE
                            inv_merma.id LIKE '%".$b_texto."%'
                        OR  inv_merma.observacion LIKE '%".$b_texto."%' OR date_format(fecha_merma, '%d/%m/%Y') LIKE '%".$b_texto."%' OR inv_articulo.nombre LIKE '%".$b_texto."%' OR inv_almacen.nombre LIKE '%".$b_texto."%'
                    ORDER BY inv_articulo.nombre ASC";

                    if(!isset($segmento)){
                        $sql=$sql." LIMIT ".$segmento.", ".$por_pagina;  //echo "<br />sql *".$sql."*";
                    }

            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }    
 
    
    //merma
    //    id
    //    nombre
    public function inv_merma_buscar_2($id){
            $sql = "SELECT *, date_format(fecha_merma, '%d/%m/%Y') as fecha_merma_2 FROM inv_merma
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

    //merma
    //    id
    //    nombre
    public function inv_merma_buscar_3(){
            $sql = "SELECT * FROM inv_merma ORDER BY nombre ASC";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }    

    //merma
    //    id
    //    nombre
    public function inv_merma_buscar_5($nombre, $id){
            $sql = "SELECT * FROM inv_merma
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
    
    //merma
    //    id
    //    nombre    
    public function inv_merma_buscar_6($nombre){
            $sql = "SELECT * FROM inv_merma
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
    
    public function inv_merma_articulo_almacen($id_articulo,$id_almacen){
        $sql = "SELECT SUM(cantidad) as cantidad FROM inv_merma
                    WHERE 
                         id_articulo = '".$id_articulo."' and id_almacen =".$id_almacen." and id_status=1 GROUP BY id_articulo,id_almacen";
            //return $sql;
            $resultado = $this->db->query($sql);
            $merma=0;
            if( $resultado->num_rows() > 0 ){
                foreach($resultado->result() as $item){
                    $merma=$item->cantidad;
                }
                return $merma;
            }else{
                return false;
            }
    }

    public function inv_total_merma($id_articulo,$id_almacen,$fecha_desde,$fecha_hasta){
        $sql = "SELECT SUM(cantidad) as cantidad FROM inv_merma
        WHERE id_articulo = '".$id_articulo."' and id_almacen = '".$id_almacen."' and fecha_merma between '".$fecha_desde."' and '".$fecha_hasta."' and id_status=1 GROUP BY id_articulo,id_almacen";
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
    
    
    //merma
    //    id
    //    nombre
    public function inv_merma_insertar($nombre,$id_articulo,$fecha_merma,$id_almacen,$cantidad){

            $this->db->insert("inv_merma", [
                "observacion" => $nombre,
                "id_articulo" => $id_articulo,
                "fecha_merma" => $fecha_merma,
                "id_almacen" => $id_almacen,
                "cantidad" => $cantidad,
                "id_status"=>1
            ]);

            $ultimoId=$this->db->insert_id();

            //Registra movimiento en inventario
            $this->Inv_movimiento_inventario_model->inv_movimiento_inventario_insertar($id_articulo,$id_almacen,$fecha_merma,$cantidad,$ultimoId,'merma',$nombre);

            return $this->db->insert_id();
    }    
    
    //merma
    //    id
    //    nombre
    public function inv_merma_editar($id,$id_articulo,$fecha_merma,$id_almacen,$cantidad, $nombre){
        
        $data = array(
            'observacion' => $nombre,
            'id_articulo' => $id_articulo,
            'fecha_merma' => $fecha_merma,
            'id_almacen' => $id_almacen,
            'cantidad'=>$cantidad,
        );

        $resultado=$this->db->update('inv_merma', $data, array('id' => $id));


        $id_mov='';
                $sql = "SELECT * FROM inv_movimiento_inventario
                        WHERE id_documento = '".$id."' and tipo_documento = 'merma'";
                //return $sql;
                $resultado2 = $this->db->query($sql);
                foreach ($resultado2->result_array() as $row)
                {
                        $id_mov=$row['id'];
                }

        // Actualiza movimiento de inventario
        $this->Inv_movimiento_inventario_model->inv_movimiento_inventario_update($id,'merma',$id_articulo,$id_almacen,$fecha_merma,0,$cantidad,$nombre,$id_mov);

        return $resultado;
    } 

    //merma
    //    id
    //    nombre    
    public function inv_merma_eliminar($id){
        $sql = "
        UPDATE inv_merma SET id_status=2  WHERE id = '".$id."'
        ";      //echo "<br />sql *".$sql."*";
        $resultado = $this->db->query($sql);

        $this->Inv_movimiento_inventario_model->inv_movimiento_inventario_eliminar($id,'Merma');
        return $resultado;
    }        
    
}