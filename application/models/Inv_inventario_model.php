<?php
class Inv_inventario_model extends CI_Model{
    
    function __construct(){
        parent::__construct();
        $this->load->model('Inv_recepcion_model');
        $this->load->model('Inv_despacho_model');
        $this->load->model('Inv_merma_model');
        $this->load->model('Inv_traslado_model');
        $this->load->model('Inv_movimiento_inventario_model');

    }

    //inventario
    //    id
    //    nombre
    public function inv_inventario_num_reg($b_texto){
            $sql = "
                    SELECT id FROM inv_inventario WHERE
                            id LIKE '%".$b_texto."%'
                        OR  capacidad_almacen LIKE '%".$b_texto."%'
            "; //echo "<br />sql *".$sql."*";   

            $resultado = $this->db->query($sql);
            return $resultado->num_rows();
    }
    
    //inventario
    //    id
    //    nombre    
    public function inv_inventario_buscar($b_texto, $por_pagina, $segmento){
            $sql = "SELECT 0 as disponible,inv_inventario.id as id,inv_inventario.*,inv_articulo.nombre as nombre_articulo,inv_almacen.nombre as nombre_almacen,inv_unidad_medida.nombre as nombre_medida FROM inv_inventario INNER JOIN inv_articulo ON inv_articulo.id=inv_inventario.id_articulo INNER JOIN inv_almacen ON inv_almacen.id=inv_inventario.id_almacen INNER JOIN inv_unidad_medida ON inv_unidad_medida.id=inv_articulo.id_unidad_medida WHERE
                            inv_inventario.id LIKE '%".$b_texto."%'
                        OR  inv_inventario.capacidad_almacen LIKE '%".$b_texto."%' OR inv_articulo.nombre LIKE '%".$b_texto."%' OR inv_almacen.nombre LIKE '%".$b_texto."%' OR inv_unidad_medida.nombre LIKE '%".$b_texto."%'
                    ORDER BY inv_articulo.nombre ASC";
                    
                    if(!empty($segmento)){
                        $sql." LIMIT ".$segmento.", ".$por_pagina;  //echo "<br />sql *".$sql."*";       
                    } 

            $resultado = $this->db->query($sql);
            $arrAlmacen=array();

            if( $resultado->num_rows() > 0 ){
                
                foreach ($resultado->result() as $row){

                    //phpinfo();
                    $saldo=0;
                       //definir rowspan
                    $resul=array_filter($arrAlmacen, fn($e)=>$e==$row->id_almacen);
                    $row->rowspan=count($resul)>0?0:1;
                    if(count($resul)==0){
                           array_push($arrAlmacen,$row->id_almacen);
                    }

                    

                    $arrSaldo=$this->Inv_movimiento_inventario_model->inv_movimiento_saldo_fecha($row->id_articulo,$row->id_almacen,date("Y-m-d"));

                    if($arrSaldo){
                        foreach($arrSaldo as $item){
    
                            
                            $saldo=$item['saldo_final'];
                           
                        }
                    }
                    $row->disponible=$saldo>0?$saldo:0;
                }

                return $resultado->result();
            }else{
                return false;
            }
            // if( $resultado->num_rows() > 0 ){

                
            //     return $resultado->result();
            // }else{
            //     return false;
            // }
    }  

    function inv_inventario_existe_ajuste($almacen,$fecha){

        $sql="SELECT * FROM inv_ajuste_inventario WHERE id_almacen='$almacen' AND fecha='$fecha' AND id_status=1";
        $resultado = $this->db->query($sql);


        if( $resultado->num_rows() > 0 ){
            
            foreach ($resultado->result() as $row){
                // Se elimina el detalle del ajuste del día por almacen
                $sqlDeleteAD = "
                UPDATE inv_ajuste_detalle_inventario SET id_status=2 WHERE id_ajuste='".$row->id."'";      //echo "<br />sql *".$sql."*";
                 $resultadoAD = $this->db->query($sqlDeleteAD);

                 // Se elimina el ajuste del día por almacen
                 $sqlDeleteA = "
                 UPDATE inv_ajuste_inventario SET id_status=2 WHERE id='".$row->id."'";      //echo "<br />sql *".$sql."*";
                $resultadoA = $this->db->query($sqlDeleteA);

            }
        }    

    }
    

    public function inv_inventario_buscar_almacen($b_texto,$fecha, $por_pagina, $segmento){

        $sql = "SELECT 0 as disponible,inv_inventario.id as id,inv_inventario.*,inv_articulo.nombre as nombre_articulo,inv_articulo.id as id_articulo,inv_almacen.nombre as nombre_almacen,inv_unidad_medida.nombre as nombre_medida,monto_ajuste, ADI.monto_ajuste,AI.fecha as fecha FROM inv_inventario 
                INNER JOIN inv_articulo ON inv_articulo.id=inv_inventario.id_articulo 
                INNER JOIN inv_almacen ON inv_almacen.id=inv_inventario.id_almacen 
                INNER JOIN inv_unidad_medida ON inv_unidad_medida.id=inv_articulo.id_unidad_medida
                LEFT JOIN inv_ajuste_inventario AI ON AI.id_almacen=inv_almacen.id AND AI.fecha='$fecha' AND AI.id_status=1
                LEFT JOIN inv_ajuste_detalle_inventario ADI ON ADI.id_articulo=inv_articulo.id AND ADI.id_ajuste=AI.id AND ADI.id_status=1 WHERE
                        inv_inventario.id_almacen LIKE '%".$b_texto."%'
                ORDER BY inv_articulo.nombre ASC";
                
                //echo $sql;
                // if(!empty($segmento)){
                //     $sql." LIMIT ".$segmento.", ".$por_pagina;  //echo "<br />sql *".$sql."*";       
                // } 



        $resultado = $this->db->query($sql);
        $arrAlmacen=array();


        if( $resultado->num_rows() > 0 ){
            
            foreach ($resultado->result() as $row){

                //phpinfo();
                $saldo=0;
                   //definir rowspan
                $resul=array_filter($arrAlmacen, fn($e)=>$e==$row->id_almacen);
                $row->rowspan=count($resul)>0?0:1;
                if(count($resul)==0){
                       array_push($arrAlmacen,$row->id_almacen);
                }

                $arrSaldo=$this->Inv_movimiento_inventario_model->inv_movimiento_saldo_fecha($row->id_articulo,$row->id_almacen,$fecha);

                if($arrSaldo){
                    foreach($arrSaldo as $item){

                        
                        $saldo=$item['saldo_final'];
                       
                    }
                }
                $row->disponible=$saldo>0?$saldo:0;
                $row->fecha_busqueda=$fecha;
            }

            return $resultado->result();
        }else{
            return false;
        }
        // if( $resultado->num_rows() > 0 ){

            
        //     return $resultado->result();
        // }else{
        //     return false;
        // }
}  
 
 
    
    //inventario
    //    id
    //    nombre
    public function inv_inventario_buscar_2($id){
            $sql = "SELECT * FROM inv_inventario
                    WHERE id = '".$id."'"; //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }

    //inventario
    //    id
    //    nombre
    public function inv_inventario_buscar_3(){
            $sql = "SELECT * FROM inv_inventario ORDER BY nombre ASC";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }    

    //inventario
    //    id
    //    nombre
    public function inv_inventario_buscar_5($nombre, $id){
            $sql = "SELECT * FROM inv_inventario
                    WHERE 
                         capacidad_almacen = '".$nombre."' ";
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
    
    //inventario
    //    id
    //    nombre    
    public function inv_inventario_buscar_6($nombre){
            $sql = "SELECT * FROM inv_inventario
                    WHERE 
                         capacidad_almacen = '".$nombre."' ";
            //return $sql;
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    } 
    
    public function inv_inventario_capacidad($articulo,$almacen){
        $sql = "SELECT capacidad_almacen FROM inv_inventario
                WHERE 
                     id_articulo = '".$articulo."' AND id_almacen= '".$almacen."'";
        //return $sql;
        $resultado = $this->db->query($sql);
        if( $resultado->num_rows() > 0 ){
            return $resultado->result();
        }else{
            return false;
        }
    }  
    

    public function inv_inventario_general($id_articulo,$id_almacen,$fecha_desde,$fecha_hasta){

        $arreglo_where = array();
        $x=0;
        $where="";
        $sep="";
        if($id_articulo!='null'){
            $arreglo_where[$x++]=" inv.id_articulo=".$id_articulo;
        }
    
        if($id_almacen!='null'){
            $arreglo_where[$x++]=" inv.id_almacen=".$id_almacen;
        }
    
    
        for($i=0; $i < count($arreglo_where) ; $i++){
    
            $where.=$sep.$arreglo_where[$i];
            if($sep==""){
                $sep=" AND ";
            }    
        }

        $fecha_desde=explode("-",$fecha_desde);
        $fecha_desde=$fecha_desde[2]."-".$fecha_desde[1]."-".$fecha_desde[0];
        $fecha_hasta=explode("-",$fecha_hasta);
        $fecha_hasta=$fecha_hasta[2]."-".$fecha_hasta[1]."-".$fecha_hasta[0];


    
        if(count($arreglo_where)==0){
            $where=1;
        }
    
        // echo "where".$where;
        // phpinfo();
    
            $sql = "SELECT inv.id_articulo,inv.id_almacen,(al.nombre) as nombre_almacen,(ar.nombre) as nombre_articulo, (un.nombre) as nombre_unidad 
                    FROM inv_inventario inv 
                    INNER JOIN inv_articulo ar ON ar.id=inv.id_articulo
                    INNER JOIN inv_almacen al ON al.id=inv.id_almacen
                    INNER JOIN inv_unidad_medida un ON un.id=ar.id_unidad_medida
                    WHERE $where 
                    GROUP BY inv.id_almacen,inv.id_articulo ";
      
            //return $sql;
            $resultado = $this->db->query($sql);
            $arrAlmacen=array();
            if( $resultado->num_rows() > 0 ){

                foreach($resultado->result() as $item){
                    $saldo=0;
                    $arrSaldo=$this->Inv_movimiento_inventario_model->inv_movimiento_saldo_fecha($item->id_articulo,$item->id_almacen,$fecha_hasta);
                    if($arrSaldo){
                        foreach($arrSaldo as $itemSaldo){
    
                            $saldo=$itemSaldo['saldo_final'];
                           
                        }
                    }
                 
                    $item->disponible=$saldo>0?$saldo:0;


                    $resul=array_filter($arrAlmacen, fn($e)=>$e==$item->id_almacen);
                        $item->rowspan=count($resul)>0?0:1;
                        if(count($resul)==0){
                            array_push($arrAlmacen,$item->id_almacen);
                        }

                    $cantidadRecepcion = $this->Inv_recepcion_model->inv_total_recepcion($item->id_articulo,$item->id_almacen,$fecha_desde,$fecha_hasta);
                    $item->cantidad_recepcion=$cantidadRecepcion;

                    $cantidadDespachoTraslado = $this->Inv_traslado_model->inv_total_traslado_despacho($item->id_articulo,$item->id_almacen,$fecha_desde,$fecha_hasta);
                    $item->cantidad_despacho_traslado=$cantidadDespachoTraslado;
                    
                    $cantidadRecepcionTraslado = $this->Inv_traslado_model->inv_total_traslado_recepcion($item->id_articulo,$item->id_almacen,$fecha_desde,$fecha_hasta);
                    $item->cantidad_recepcion_traslado=$cantidadRecepcionTraslado;

                

                    $cantidadDespacho = $this->Inv_despacho_model->inv_total_despacho($item->id_articulo,$item->id_almacen,$fecha_desde,$fecha_hasta);
                    $item->cantidad_despacho=$cantidadDespacho;

                    $cantidadMerma = $this->Inv_merma_model->inv_total_merma($item->id_articulo,$item->id_almacen,$fecha_desde,$fecha_hasta);
                    $item->cantidad_merma=$cantidadMerma;

                    
                }

                return $resultado->result();
            }else{
                return false;
            }
        }   
    
    //inventario
    //    id
    //    nombre
    public function inv_inventario_insertar($id_articulo,$id_almacen,$capacidad_almacen){
            //if($id_cargo > 0){ }else{   $id_cargo = 'NULL';   }
            //if($id_inventario > 0){ }else{   $id_inventario = 'NULL';   }
            $sql = "
            INSERT INTO inv_inventario (capacidad_almacen,id_articulo,id_almacen) VALUES
            ('".$capacidad_almacen."','".$id_articulo."','".$id_almacen."')
            ";      //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);    //echo "<hr />resultado *".$resultado."*";
       
            return $this->db->insert_id();
    }  
    
    public function inv_inventario_insertar_ajuste($almacen,$fecha,$observacion){
        //if($id_cargo > 0){ }else{   $id_cargo = 'NULL';   }
        //if($id_inventario > 0){ }else{   $id_inventario = 'NULL';   }
        $sql = "
        INSERT INTO inv_ajuste_inventario (fecha,observacion,id_almacen,id_status) VALUES
        ('".$fecha."','".$observacion."','".$almacen."','1')
        ";      //echo "<br />sql *".$sql."*";
        $resultado = $this->db->query($sql);    //echo "<hr />resultado *".$resultado."*";
        return $this->db->insert_id();
}   

public function inv_inventario_insertar_ajuste_detalle($ajuste,$articulo,$monto_ajuste,$monto_disponibilidad,$monto_diferencia){
    //if($id_cargo > 0){ }else{   $id_cargo = 'NULL';   }
    //if($id_inventario > 0){ }else{   $id_inventario = 'NULL';   }
    $sql = "
    INSERT INTO inv_ajuste_detalle_inventario (id_ajuste,id_articulo,monto_disponibilidad,monto_ajuste,monto_diferencia,id_status) VALUES
    ('".$ajuste."','".$articulo."','".$monto_disponibilidad."','".$monto_ajuste."','".$monto_diferencia."','1')
    ";      //echo "<br />sql *".$sql."*";
    $resultado = $this->db->query($sql);    //echo "<hr />resultado *".$resultado."*";
    return $this->db->insert_id();
}   
    
    //inventario
    //    id
    //    nombre
    public function inv_inventario_editar($id,$id_articulo,$id_almacen,$capacidad_almacen){
            $sql = "
                    UPDATE inv_inventario SET
                           capacidad_almacen='".$capacidad_almacen."',id_articulo='".$id_articulo."',id_almacen='".$id_almacen."'
                    WHERE id = '".$id."'
            ";      //echo "<br />sql <pre>*".$sql."*</pre>";
            $resultado = $this->db->query($sql);
            return $resultado;
    } 

    //inventario
    //    id
    //    nombre    
    public function inv_inventario_eliminar($id){
            $sql = "
                    DELETE FROM inv_inventario WHERE id = '".$id."'
            ";      //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            return $resultado;
    }        
    
}