<?php
class Inv_traslado_model extends CI_Model{
    
    function __construct(){
        parent::__construct();
        $this->load->model('Inv_movimiento_inventario_model');
    }

    //traslado
    //    id
    //    nombre
    public function inv_traslado_num_reg($b_texto){
            $sql = "
                    SELECT id FROM inv_traslado WHERE
                            id LIKE '%".$b_texto."%'
                        OR  observacion LIKE '%".$b_texto."%'
            "; //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            return $resultado->num_rows();
    }
    
    //traslado
    //    id
    //    nombre    
    public function inv_traslado_buscar($b_texto, $por_pagina, $segmento){
            $sql = "SELECT date_format(fecha_traslado, '%d/%m/%Y') as fecha_traslado_2,inv_traslado.*,inv_articulo.nombre as nombre_articulo,inv_origen.nombre as nombre_almacen_origen,inv_destino.nombre as nombre_almacen_destino FROM inv_traslado INNER JOIN inv_articulo ON inv_articulo.id=inv_traslado.id_articulo INNER JOIN inv_almacen inv_origen ON inv_origen.id=inv_traslado.id_almacen_origen INNER JOIN inv_almacen inv_destino ON inv_destino.id=inv_traslado.id_almacen_destino WHERE
                            inv_traslado.id LIKE '%".$b_texto."%'
                        OR  inv_traslado.observacion LIKE '%".$b_texto."%' OR date_format(fecha_traslado, '%d/%m/%Y') LIKE '%".$b_texto."%' OR inv_articulo.nombre LIKE '%".$b_texto."%' OR inv_origen.nombre LIKE '%".$b_texto."%' OR inv_destino.nombre LIKE '%".$b_texto."%'
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
 
    
    //traslado
    //    id
    //    nombre
    public function inv_traslado_buscar_2($id){


            $sql = "SELECT *, inv_traslado.id as id,date_format(fecha_traslado, '%d/%m/%Y') as fecha_traslado_2,id_almacen_origen as aux_almacen_origen,id_almacen_destino as aux_almacen_destino,capacidad_almacen FROM inv_traslado
                    INNER JOIN inv_inventario INV ON INV.id_articulo=inv_traslado.id_articulo AND INV.id_almacen=inv_traslado.id_almacen_destino
                    WHERE inv_traslado.id = '".$id."'"; //echo "<br />sql *".$sql."*";
        
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){

                foreach ($resultado->result() as $item)
                {

                    //origen
                    $resul=$this->Inv_movimiento_inventario_model->inv_movimiento_saldo_actual($item->id_articulo,$item->aux_almacen_origen);
                    foreach ($resul as $row){
                                // asigno saldo de al antiguo arreglo
                                //$item->disponibilidad_origen=(floatval($row['saldo_final']));
                                
                        $item->disponibilidad_origen=floatval($row['saldo_final'])+floatval($item->cantidad);
                        
                    }
                 
                    //destino
                    $resul=$this->Inv_movimiento_inventario_model->inv_movimiento_saldo_actual($item->id_articulo,$item->aux_almacen_destino);
                    foreach ($resul as $row){
                        // asigno saldo de al antiguo arreglo
                        // echo "capacidad".floatval($item->capacidad_almacen)."saldo".floatval($row['saldo_final'])."cantidad".floatval($item->cantidad);
                        // phpinfo();
                        $item->disponibilidad_destino=(floatval($item->capacidad_almacen)-floatval($row['saldo_final'])+floatval($item->cantidad));

                    }

               
                       
                }

                return $resultado->result();
            }else{
                return false;
            }
    }

    //traslado
    //    id
    //    nombre
    public function inv_traslado_buscar_3(){
            $sql = "SELECT * FROM inv_traslado ORDER BY nombre ASC";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }    

    //traslado
    //    id
    //    nombre
    public function inv_traslado_buscar_5($nombre, $id){
            $sql = "SELECT * FROM inv_traslado
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
    
    //traslado
    //    id
    //    nombre    
    public function inv_traslado_buscar_6($nombre){
            $sql = "SELECT * FROM inv_traslado
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
    
    public function inv_total_traslado_despacho($id_articulo,$id_almacen,$fecha_desde,$fecha_hasta){
        $sql = "SELECT SUM(cantidad) as cantidad FROM inv_traslado
        WHERE id_articulo = '".$id_articulo."' and id_almacen_origen = '".$id_almacen."' and fecha_traslado between '".$fecha_desde."' and '".$fecha_hasta."' and id_status=1 GROUP BY id_articulo,id_almacen_origen";
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
    public function inv_total_traslado_recepcion($id_articulo,$id_almacen,$fecha_desde,$fecha_hasta){
        $sql = "SELECT SUM(cantidad) as cantidad FROM inv_traslado
        WHERE id_articulo = '".$id_articulo."' and id_almacen_destino = '".$id_almacen."' and fecha_traslado between '".$fecha_desde."' and '".$fecha_hasta."' and id_status=1 GROUP BY id_articulo,id_almacen_destino";
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
    
    //traslado
    //    id
    //    nombre
    public function inv_traslado_insertar($nombre,$id_articulo,$fecha_traslado,$id_almacen_origen,$id_almacen_destino,$cantidad){
            //if($id_cargo > 0){ }else{   $id_cargo = 'NULL';   }
            //if($id_traslado > 0){ }else{   $id_traslado = 'NULL';   }
            // $sql = "
            // INSERT INTO inv_traslado (observacion,id_articulo,fecha_traslado,id_almacen_origen,id_almacen_destino,cantidad) VALUES
            // ('".$nombre."','".$id_articulo."','".$fecha_traslado."','".$id_almacen_origen."','".$id_almacen_destino."','".$cantidad."')
            // ";      //echo "<br />sql *".$sql."*";
            // $resultado = $this->db->query($sql);    //echo "<hr />resultado *".$resultado."*";

            $this->db->insert("inv_traslado", [
                "observacion" => $nombre,
                "id_articulo" => $id_articulo,
                "fecha_traslado" => $fecha_traslado,
                "id_almacen_origen" => $id_almacen_origen,
                "id_almacen_destino"=> $id_almacen_destino,
                "cantidad" => $cantidad,
                "id_status"=>1
            ]);

            $almacen=[$id_almacen_origen,$id_almacen_destino];
            $ultimoId=$this->db->insert_id();

            //Registra movimiento en inventario
            $this->Inv_movimiento_inventario_model->inv_movimiento_inventario_insertar($id_articulo,$almacen,$fecha_traslado,$cantidad,$ultimoId,'traslado',$nombre);

            return $this->db->insert_id();
    }    
    
    //traslado
    //    id
    //    nombre
    public function inv_traslado_editar($id,$id_articulo,$fecha_traslado,$id_almacen_origen,$id_almacen_destino,$cantidad, $nombre){


            $data = array(
                'observacion' => $nombre,
                'id_articulo' => $id_articulo,
                'fecha_traslado' => $fecha_traslado,
                'id_almacen_origen' => $id_almacen_origen,
                'id_almacen_destino' => $id_almacen_destino,
                'cantidad'=>$cantidad,
            );
    
            $resultado=$this->db->update('inv_traslado', $data, array('id' => $id));

            //$origen = $this->db->get_where('inv_movimiento_inventario', array('id_documento' => $id));

            $id_origen='';
            $sql = "SELECT * FROM inv_movimiento_inventario
                    WHERE id_documento = '".$id."' and tipo_documento = 'traslado' and salida=0";
            //return $sql;
            $resultado2 = $this->db->query($sql);
            foreach ($resultado2->result_array() as $row)
            {
                    $id_origen=$row['id'];
            }

            $id_destino='';
            $sql = "SELECT * FROM inv_movimiento_inventario
                    WHERE id_documento = '".$id."' and tipo_documento = 'traslado' and entrada=0";
            //return $sql;
            $resultado2 = $this->db->query($sql);
            foreach ($resultado2->result_array() as $row)
            {
                    $id_destino=$row['id'];
            }

            for($x=1; $x <= 2; $x++){
                if($x==1){
                    $id_mov=$id_origen;
                    $id_almacen=$id_almacen_origen;
                    $salida=$cantidad;
                    $entrada=0;
                }else{
                    $id_mov=$id_destino;
                    $id_almacen=$id_almacen_destino;
                    $entrada=$cantidad;
                    $salida=0;
                }
                $this->Inv_movimiento_inventario_model->inv_movimiento_inventario_update($id,'traslado',$id_articulo,$id_almacen,$fecha_traslado,$entrada,$salida,$nombre,$id_mov);
            }

            //phpinfo();
         
            // Actualiza movimiento de inventario        
           

            return $resultado;
    } 

    //traslado
    //    id
    //    nombre    
    public function inv_traslado_eliminar($id){
        $sql = "
        UPDATE inv_traslado SET id_status=2  WHERE id = '".$id."'
        ";      //echo "<br />sql *".$sql."*";
        $resultado = $this->db->query($sql);

        $this->Inv_movimiento_inventario_model->inv_movimiento_inventario_eliminar($id,'Traslado');
        return $resultado;
    }        
    
}