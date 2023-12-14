<?php
class Inv_articulo_model extends CI_Model{
    
    function __construct(){
        parent::__construct();
        $this->load->model('Inv_movimiento_inventario_model');
        
    }

    //articulo
    //    id
    //    nombre
    public function inv_articulo_num_reg($b_texto){
            $sql = "
                    SELECT id FROM inv_articulo WHERE
                            id LIKE '%".$b_texto."%'
                        OR  nombre LIKE '%".$b_texto."%' OR  observacion LIKE '%".$b_texto."%'
            "; //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            return $resultado->num_rows();
    }
    
    //articulo
    //    id
    //    nombre    
    public function inv_articulo_buscar($b_texto, $por_pagina, $segmento){
            $sql = "SELECT inv_articulo.observacion,inv_articulo.id_tipo_articulo,inv_articulo.id as id,inv_articulo.codigo as codigo,inv_articulo.nombre as nombre,inv_unidad_medida.nombre as nombre_medida,inv_tipo_articulo.nombre as nombre_tipo_articulo,inv_articulo.imagen_articulo as imagen_articulo,inv_articulo.id_status as id_status  
                    FROM inv_articulo INNER JOIN inv_unidad_medida ON inv_unidad_medida.id=inv_articulo.id_unidad_medida 
                    INNER JOIN inv_tipo_articulo ON inv_tipo_articulo.id=inv_articulo.id_tipo_articulo 
        
                    WHERE
                            inv_articulo.id LIKE '%".$b_texto."%'
                        OR  inv_articulo.nombre LIKE '%".$b_texto."%' OR inv_articulo.observacion LIKE '%".$b_texto."%' OR inv_tipo_articulo.nombre LIKE '%".$b_texto."%' OR inv_unidad_medida.nombre LIKE '%".$b_texto."%'
                    ORDER BY inv_articulo.codigo ASC
                    LIMIT ".$segmento.", ".$por_pagina;  //echo "<br />sql *".$sql."*";
            // echo $sql;
            // phpinfo();        
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                
                return $resultado->result();
            }else{
                return false;
            }
    }    
 
    
        //almacen
    //    id
    //    nombre
    public function inv_articulo_buscar_1(){
        $sql = "SELECT * FROM inv_articulo WHERE id_status=1 ORDER BY nombre ASC";
        $resultado = $this->db->query($sql);
        if( $resultado->num_rows() > 0 ){
            return $resultado->result();
        }else{
            return false;
        }
}  

    //articulo
    //    id
    //    nombre
    public function inv_articulo_buscar_2($id){

            $sql = "SELECT * FROM inv_articulo
                    WHERE id = '".$id."'"; //echo "<br />sql *".$sql."*";

            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }

    //articulo
    //    id
    //    nombre
    public function inv_articulo_buscar_3(){
            $sql = `SELECT inv_articulo.id as id,inv_articulo.codigo as codigo,inv_articulo.nombre as nombre,inv_unidad_medida.nombre as nombre_medida,
                            inv_tipo_articulo.nombre as nombre_tipo_articulo 
                    FROM inv_articulo 
                    INNER JOIN inv_unidad_medida ON inv_unidad_medida.id=inv_articulo.id_unidad_medida
                    INNER JOIN inv_tipo_articulo ON inv_tipo_articulo.id=inv_articulo.id_tipo_articulo  
                    ORDER BY nombre ASC`;

            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }    

    //articulo
    //    id
    //    nombre
    public function inv_articulo_buscar_5($nombre, $id){
            $sql = "SELECT * FROM inv_articulo
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

    //articulo
    //    id
    //    codigo edit
    public function inv_articulo_buscar_8($codigo, $id){

            $sql = "SELECT * FROM inv_articulo
                    WHERE 
                         codigo = '".$codigo."' ";
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
    
    //articulo
    //    id
    //    nombre    
    public function inv_articulo_buscar_6($nombre){
            $sql = "SELECT * FROM inv_articulo
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
    
    public function inv_articulo_buscar_7($codigo){
        $sql = "SELECT * FROM inv_articulo
                WHERE 
                     codigo = '".$codigo."' ";
        //return $sql;
        $resultado = $this->db->query($sql);
        if( $resultado->num_rows() > 0 ){
            return $resultado->result();
        }else{
            return false;
        }
} 
    
    //articulo
    //    id
    //    nombre
    public function inv_articulo_insertar($codigo,$nombre,$id_unidad_medida,$id_tipo_articulo,$observacion){
            //if($id_cargo > 0){ }else{   $id_cargo = 'NULL';   }
            //if($id_articulo > 0){ }else{   $id_articulo = 'NULL';   }
            $sql = "
            INSERT INTO inv_articulo (codigo,nombre,id_unidad_medida,id_tipo_articulo,observacion,id_status) VALUES
            ('".$codigo."','".$nombre."','".$id_unidad_medida."','".$id_tipo_articulo."','".$observacion."','1')
            ";      //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);    //echo "<hr />resultado *".$resultado."*";

            $resul_id=$this->db->insert_id();

            $codigoPad=str_pad($this->db->insert_id(),4,"0",STR_PAD_LEFT);
            $sqlUpdate="UPDATE inv_articulo SET codigo='".$codigoPad."' WHERE id=".$this->db->insert_id();
            $this->db->query($sqlUpdate);

            return $resul_id;
    }    
    
    //articulo
    //    id
    //    nombre
    public function inv_articulo_editar($id, $codigo, $nombre, $id_unidad_medida, $id_tipo_articulo,$observacion){

            $sql = "
                    UPDATE inv_articulo SET
                    codigo = '".$codigo."' ,nombre =   '".$nombre."', id_unidad_medida= '".$id_unidad_medida."',id_tipo_articulo='".$id_tipo_articulo."', observacion='".$observacion."'
                    WHERE id = '".$id."'
            ";      //echo "<br />sql <pre>*".$sql."*</pre>";
            $resultado = $this->db->query($sql);
            return $resultado;
    } 

    public function inv_articulo_editar_2($id, $imagen_nombre){

        if($imagen_nombre == ""){   $imagen_nombre = 'NULL';   }else{ $imagen_nombre = "'".$imagen_nombre."'"; }
        $sql = "
                UPDATE inv_articulo SET
                       imagen_articulo           =   ".$imagen_nombre."
                WHERE id = '".$id."'
        ";      //echo "<br />sql <pre>*".$sql."*</pre>";
        $resultado = $this->db->query($sql);
        return $resultado;
}    

    //articulo
    //    id
    //    nombre    
    public function inv_articulo_eliminar($id){
        $sql = "UPDATE inv_articulo SET id_status=2  WHERE id = '".$id."'
        ";      //echo "<br />sql *".$sql."*";
        $resultado = $this->db->query($sql);

        return $resultado;
    }  

    public function inv_reporte_articulo($id_articulo,$id_almacen,$fecha_desde,$fecha_hasta,$id_tipo_articulo){

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
        if($id_tipo_articulo!='null'){
            $arreglo_where[$x++]=" tar.id=".$id_tipo_articulo;
        }
    
    
        for($i=0; $i < count($arreglo_where) ; $i++){
    
            $where.=$sep.$arreglo_where[$i];
            if($sep==""){
                $sep=" AND ";
            }    
        }
    
        //if(count($arreglo_where)==0){
            $fecha_desde=explode("-",$fecha_desde);
            $fecha_desde=$fecha_desde[2]."-".$fecha_desde[1]."-".$fecha_desde[0];
            $fecha_hasta=explode("-",$fecha_hasta);
            $fecha_hasta=$fecha_hasta[2]."-".$fecha_hasta[1]."-".$fecha_hasta[0];

            $and=" AND";
            //echo "arreglo_where".count($arreglo_where);
            if(count($arreglo_where)==0){
               $and=" " ;
            }
            $where.=" ".$and." m_inv.fecha between '".$fecha_desde."' AND '".$fecha_hasta."' AND m_inv.id_status=1 ";
        //}
    
        // echo "where".$where;
        // phpinfo();
    
            $sql = "SELECT m_inv.id_articulo,m_inv.id_almacen,m_inv.fecha as fecha_aux,ar.nombre as nombre_articulo,date_format(m_inv.fecha,'%d/%m/%y') as fecha,al.nombre as nombre_almacen,inv.capacidad_almacen,tar.nombre as nombre_tipo_articulo, und.nombre as unidad_medida 
                    FROM inv_movimiento_inventario m_inv 
                    INNER JOIN inv_articulo ar ON ar.id=m_inv.id_articulo
                    INNER JOIN inv_unidad_medida und ON und.id=ar.id_unidad_medida
                    INNER JOIN inv_tipo_articulo tar ON tar.id=ar.id_tipo_articulo 
                    INNER JOIN inv_almacen al ON al.id=m_inv.id_almacen
                    INNER JOIN inv_inventario inv ON inv.id_articulo=ar.id AND inv.id_almacen=al.id
                    WHERE $where 
                    GROUP BY m_inv.id_almacen,m_inv.id_articulo,m_inv.fecha ";

    
            ///return $sql;

            $resultado = $this->db->query($sql);
            $arrAlmacen=array();
            
            if( $resultado->num_rows() > 0 ){
                

                foreach ($resultado->result() as $row){
                    $saldo=0;
                       //definir rowspan
                    $resul=array_filter($arrAlmacen, fn($e)=>$e==$row->id_almacen);
                    $row->rowspan=count($resul)>0?0:1;
                    if(count($resul)==0){
                           array_push($arrAlmacen,$row->id_almacen);
                    }

                    $arrSaldo=$this->Inv_movimiento_inventario_model->inv_movimiento_saldo_fecha($row->id_articulo,$row->id_almacen,$row->fecha_aux);
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
        }   

    
}