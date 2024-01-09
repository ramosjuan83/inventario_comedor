<?php
class Comedor_comida_tipo_model extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }
    
    //comedor_comida_tipo
    //    id
    //    nombre
    //    hora_desde
    //    hora_hasta
    public function comedor_comida_tipo_buscar_2($hora){
            $sql = "SELECT * FROM comedor_comida_tipo
                    WHERE 
                            '".$hora."' > hora_desde
                        AND '".$hora."' < hora_hasta
                    "; //echo "<br />sql *".$sql."*";

            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }
    

    //comedor_comida_tipo
    //    id
    //    nombre
    //    hora_desde
    //    hora_hasta
    public function comedor_comida_tipo_buscar_3($id){
            $sql = "SELECT * FROM comedor_comida_tipo
                    WHERE id = '".$id."'"; //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }
    

    //comedor_comida_tipo
    //    id
    //    nombre
    //    hora_desde
    //    hora_hasta
    public function comedor_comida_tipo_buscar_4(){
            $sql = "SELECT * FROM comedor_comida_tipo ORDER BY id ASC";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }    

}