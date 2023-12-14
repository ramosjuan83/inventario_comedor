<?php
class Inv_movimiento_inventario_model extends CI_Model{
    
    function __construct(){
        parent::__construct();
        $this->load->model('Inv_movimiento_inventario_model');
        $this->load->model('Inv_merma_model');
    }

    //movimiento_inventario
    //    id
    //    nombre
    public function inv_movimiento_inventario_num_reg($b_texto){
            $sql = "
                    SELECT id FROM inv_movimiento_inventario WHERE
                            id LIKE '%".$b_texto."%'
                        OR  capacidad_almacen LIKE '%".$b_texto."%'
            "; //echo "<br />sql *".$sql."*";   

            $resultado = $this->db->query($sql);
            return $resultado->num_rows();
    }
    
    //movimiento_inventario
    //    id
    //    nombre    
    public function inv_movimiento_inventario_buscar($b_texto, $por_pagina, $segmento){
            $sql = "SELECT inv_movimiento_inventario.id as id,inv_movimiento_inventario.*,inv_articulo.nombre as nombre_articulo,inv_almacen.nombre as nombre_almacen,inv_unidad_medida.nombre as nombre_medida FROM inv_movimiento_inventario INNER JOIN inv_articulo ON inv_articulo.id=inv_movimiento_inventario.id_articulo INNER JOIN inv_almacen ON inv_almacen.id=inv_movimiento_inventario.id_almacen INNER JOIN inv_unidad_medida ON inv_unidad_medida.id=inv_articulo.id_unidad_medida WHERE
                            inv_movimiento_inventario.id LIKE '%".$b_texto."%'
                        OR  inv_movimiento_inventario.capacidad_almacen LIKE '%".$b_texto."%'
                    ORDER BY inv_movimiento_inventario.id DESC
                    LIMIT ".$segmento.", ".$por_pagina;  //echo "<br />sql *".$sql."*";       
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }    
 
    
    //movimiento_inventario
    //    id
    //    nombre
    public function inv_movimiento_inventario_buscar_2($id){
            $sql = "SELECT * FROM inv_movimiento_inventario
                    WHERE id = '".$id."'"; //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }

    //movimiento_inventario
    //    id
    //    nombre
    public function inv_movimiento_inventario_buscar_3(){
            $sql = "SELECT * FROM inv_movimiento_inventario ORDER BY nombre ASC";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }    

    //movimiento_inventario
    //    id
    //    nombre
    public function inv_movimiento_inventario_buscar_5($nombre, $id){
            $sql = "SELECT * FROM inv_movimiento_inventario
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
    
    //movimiento_inventario
    //    id
    //    nombre    
    public function inv_movimiento_inventario_buscar_6($nombre){
            $sql = "SELECT * FROM inv_movimiento_inventario
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
    
    public function inv_movimiento_saldo_actual($articulo,$almacen){
        $sql = "SELECT saldo_final FROM inv_movimiento_inventario WHERE id_articulo = '".$articulo."' AND id_almacen= '".$almacen."' and id_status=1 ORDER BY id DESC LIMIT 1";

        $resultado = $this->db->query($sql);
        if( $resultado->num_rows() > 0 ){
            return $resultado->result_array();
        }else{
            return false;
        }

    }  

    public function inv_movimiento_saldo_fecha($articulo,$almacen,$fecha){

        $sql = "SELECT saldo_final FROM inv_movimiento_inventario WHERE id_articulo = '".$articulo."' AND id_almacen= '".$almacen."' AND fecha <='".$fecha."' and id_status=1 ORDER BY id DESC LIMIT 1";

        $resultado = $this->db->query($sql);
        if( $resultado->num_rows() > 0 ){
            return $resultado->result_array();
        }else{
            return false;
        }

    }  

    public function inv_movimiento_consultar_saldo_anterior($id_articulo,$id_almacen,$fecha){
        $sql = "SELECT * FROM inv_movimiento_inventario
                WHERE 
                     id_articulo = '".$id_articulo."' AND id_almacen='".$id_almacen."' and id_status=1 order by id desc limit 1";
            
        //return $sql;
        //echo $sql;
        $resultado = $this->db->query($sql);
        if( $resultado->num_rows() > 0 ){

            $valor=0;
            foreach($resultado->result_array() as $item){
                $valor=$item['saldo_inicial']+$item['entrada']-$item['salida'];
            }
            
            return $valor;
        }else{
            return 0;
        }
    } 
    
    //movimiento_inventario
    //    id
    //    nombre
    public function inv_movimiento_inventario_insertar($id_articulo,$id_almacen,$fecha,$cantidad,$id_documento,$tipo_documento,$observacion){
            //if($id_cargo > 0){ }else{   $id_cargo = 'NULL';   }
            //if($id_movimiento_inventario > 0){ }else{   $id_movimiento_inventario = 'NULL';   }

            
  


            $entrada=0;
            $salida=0;
            $long=1;
            $destino="";
            $auxAlmacen="";

            switch($tipo_documento){
                case 'recepcion':
                    $entrada=$cantidad;
                    $auxAlmacen=$id_almacen;
                break;
                case 'merma':
                case 'despacho':    
                    $salida=$cantidad;
                    $auxAlmacen=$id_almacen;
                break;
                case 'traslado':    
                    $auxAlmacen=$id_almacen[0];
                    $destino=$id_almacen[1];
                    $salida=$cantidad;
                    $long=2;
                break;
            }
            
            

            for($x=1; $x <= $long; $x++){

                if($x==1){
                    $saldo = $this->inv_movimiento_consultar_saldo_anterior($id_articulo,$auxAlmacen,$fecha);
                    $saldo_final=($saldo+$entrada-$salida);
                }else{
                    $saldo = $this->inv_movimiento_consultar_saldo_anterior($id_articulo,$destino,$fecha);
                    $saldo_final=($saldo+$cantidad);
                }
                
                

                $this->db->insert("inv_movimiento_inventario", [
                    "id_articulo" => $id_articulo,
                    "id_almacen" => $x==2?$destino:$auxAlmacen,
                    "saldo_inicial" => $saldo,
                    "fecha" => $fecha,
                    "entrada" => $x==2?$cantidad:$entrada,//condicion para traslado
                    "salida" => $x==2?0:$salida, //condicion para traslado
                    "id_documento"=>$id_documento,
                    "saldo_final"=>$saldo_final,
                    "tipo_documento"=>$tipo_documento,
                    "observacion"=>$observacion,
                    "id_status"=>1
                ]);
            }
          

            return $this->db->insert_id();
    }    
    
    //movimiento_inventario
    //    id
    //    nombre
    public function inv_movimiento_inventario_update($id,$tipo_documento,$id_articulo,$id_almacen,$fecha,$entrada,$salida,$observacion,$num_movimiento){

            $data = array(
                'id_articulo' => $id_articulo,
                'id_almacen' => $id_almacen,
                'fecha' => $fecha,
                'entrada'=>$entrada,
                'salida'=>$salida,
                'observacion'=>$observacion,
            );
    
            //echo "id_alamcen".$id_almacen."num_movimiento".$num_movimiento;
            $resultado=$this->db->update('inv_movimiento_inventario', $data, array('id_documento' => $id,'tipo_documento'=>$tipo_documento,'id'=>$num_movimiento));
            // Actualizo los saldos del movimiento actual y de los movimientos futuros            
            $saldo = $this->inv_actualizar_saldo($id_articulo,$id_almacen,$fecha,$entrada,$salida,$num_movimiento,"update");

   
        return $resultado;
    } 

    public function inv_movimiento_inventario_eliminar($id,$tipo_documento){

        $data=array(
            'id_status'=>2
        );

        $resultado=$this->db->update('inv_movimiento_inventario', $data, array('id_documento' => $id,'tipo_documento'=>$tipo_documento));

        $sqlMovimiento="SELECT id_articulo,id_almacen,id FROM inv_movimiento_inventario WHERE id_documento=$id AND tipo_documento='$tipo_documento'";
        $resultMov = $this->db->query($sqlMovimiento);
        foreach($resultMov->result() as $item){
            $id_articulo=$item->id_articulo;
            $id_almacen=$item->id_almacen;
            $num_movimiento=$item->id;

            $saldo = $this->inv_actualizar_saldo($id_articulo,$id_almacen,$fecha,0,0,$num_movimiento,"delete");
        }
        
        

    }

    public function inv_actualizar_saldo_superiores($id_articulo,$id_almacen,$num_movimiento,$saldo_final){

        //CONSULTAR LOS MOVIMIENTOS SUPERIORES PARA ACTUALIZAR SU SALDO INICIAL y SU SALDO FINAL
        $whereP="id_articulo='".$id_articulo."' AND id_almacen='".$id_almacen."' AND id > '".$num_movimiento."' and id_status=1";
        $sqlPosterior="SELECT id,saldo_inicial,entrada,salida,saldo_final FROM inv_movimiento_inventario WHERE $whereP ORDER BY id ASC";
        // echo "sqlPosterior".$sqlPosterior;
        // phpinfo();
        $resultadoPosterior = $this->db->query($sqlPosterior);

        $cont=0;
        foreach($resultadoPosterior->result() as $row){
            $idMov=$row->id;
            if($cont==0){
                $saldo_inicialP=$saldo_final;
                $saldo_finalP=floatval($saldo_inicialP)+floatval($row->entrada)-floatval($row->salida);
            }else{
                $saldo_inicialP=$saldo_finalA;
                $saldo_finalP=floatval($saldo_inicialP)+floatval($row->entrada)-floatval($row->salida);
            }

            $data = array(
                'saldo_inicial'=>$saldo_inicialP,
                'saldo_final'=>$saldo_finalP
            );
    
              // ACTUALIZAR EL MOVIMIENTO siguiente
            $resultado=$this->db->update('inv_movimiento_inventario', $data, array('id'=>$idMov));
            $saldo_finalA=$saldo_finalP;
            $cont++;
        }
    }

    public function inv_actualizar_saldo($id_articulo,$id_almacen,$fecha,$entrada,$salida,$num_movimiento,$operacion){

        //CONSULTAR EL MOVIMIENTO ANTERIOR PARA TRAER EL SALDO FINAL
        $where=" id_articulo='".$id_articulo."' AND id_almacen='".$id_almacen."' AND id < '".$num_movimiento."' and id_status=1 ORDER BY id DESC limit 1";
        $sqlAnterior="SELECT saldo_final FROM inv_movimiento_inventario WHERE $where";

        $resultadoAnterior = $this->db->query($sqlAnterior);
        if( $resultadoAnterior->num_rows() > 0 ){
                foreach($resultadoAnterior->result() as $item){
                    $saldo_inicial=$item->saldo_final;

                    if($operacion=="update"){
                        $saldo_final=$saldo_inicial+$entrada-$salida;
                        $data = array(
                            'saldo_inicial'=>$saldo_inicial,
                            'saldo_final'=>$saldo_final
                        );
                          // ACTUALIZAR EL MOVIMIENTO ACTUAL
                        $resultado=$this->db->update('inv_movimiento_inventario', $data, array('id'=>$num_movimiento));
                    }else{
                        $saldo_final=$saldo_inicial;
                    }
                    
                
                
                }

                
                $this->inv_actualizar_saldo_superiores($id_articulo,$id_almacen,$num_movimiento,$saldo_final);


        }else{
            //SI NO TENGO MOVIMIENTO ANTERIOR

            if($operacion=="update"){
                $saldo_inicial=0;
                $saldo_final=$saldo_inicial+$entrada-$salida;

                $data = array(
                        'saldo_inicial'=>$saldo_inicial,
                        'saldo_final'=>$saldo_final
                    );
            
                      // ACTUALIZAR EL MOVIMIENTO ACTUAL
                $resultado=$this->db->update('inv_movimiento_inventario', $data, array('id'=>$num_movimiento));
            }else{
                $saldo_final=0;
            }
                

                $this->inv_actualizar_saldo_superiores($id_articulo,$id_almacen,$num_movimiento,$saldo_final);
        }

         

        // phpinfo();
    }

    //movimiento_inventario
    //    id
    //    nombre    
    // public function inv_movimiento_inventario_eliminar($id){
    //         $sql = "
    //                 DELETE FROM inv_movimiento_inventario WHERE id = '".$id."'
    //         ";      //echo "<br />sql *".$sql."*";
    //         $resultado = $this->db->query($sql);
    //         return $resultado;
    // }        
    
    public function inv_inventario_estadistica($id_articulo,$id_almacen){

    $arreglo_where = array();
    $x=0;
    $where="";
    $sep="";
    if($id_articulo!='null'){
        $arreglo_where[$x++]=" m_inv.id_articulo=".$id_articulo;
    }

    if($id_almacen!='null'){
        $arreglo_where[$x++]=" m_inv.id_almacen=".$id_almacen;
    }


    for($i=0; $i < count($arreglo_where) ; $i++){

        $where.=$sep.$arreglo_where[$i];
        if($sep==""){
            $sep=" AND ";
        }    
    }

    if(count($arreglo_where)==0){
        $where=" m_inv.id_status=1";
    }else{
        $where=$where." and m_inv.id_status=1"; 
    }

    // echo "where".$where;
    // phpinfo();

        $sql = "SELECT m_inv.id_articulo,m_inv.id_almacen,m_inv.fecha,ar.nombre as nombre_articulo,date_format(m_inv.fecha,'%d/%m/%y') as fecha,al.nombre as nombre_almacen,inv.capacidad_almacen,
                      un.nombre as nombre_unidad 
                FROM inv_movimiento_inventario m_inv 
                INNER JOIN inv_articulo ar ON ar.id=m_inv.id_articulo
                INNER JOIN inv_unidad_medida un ON un.id=ar.id_unidad_medida
                INNER JOIN inv_almacen al ON al.id=m_inv.id_almacen
                INNER JOIN inv_inventario inv ON inv.id_articulo=ar.id AND inv.id_almacen=al.id
                WHERE $where 
                GROUP BY m_inv.id_almacen,m_inv.id_articulo ";
        //return $sql;
        $resultado = $this->db->query($sql);
        $arrAlmacen=array();
        if( $resultado->num_rows() > 0 ){
            foreach($resultado->result() as $item){
                $rsSaldo=$this->inv_movimiento_saldo_actual($item->id_articulo,$item->id_almacen);
                foreach($rsSaldo as $row){
                    $item->disponible=$row['saldo_final'];
                    
                    //definir rowspan
                    $resul=array_filter($arrAlmacen, fn($e)=>$e==$item->id_almacen);
                    $item->rowspan=count($resul)>0?0:1;
                    if(count($resul)==0){
                        array_push($arrAlmacen,$item->id_almacen);
                    }
                    
                }

                $total_rows = $this->Inv_merma_model->inv_merma_articulo_almacen($item->id_articulo,$item->id_almacen);
                $item->merma=$total_rows;
            }
            return $resultado->result();
        }else{
            return false;
        }
    }   

   
}