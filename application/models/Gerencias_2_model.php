<?php
class Gerencias_2_model extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }

    //gerencias_2
    //    id
    //    nombre
    public function gerencias_2_buscar_2($id){
            $sql = "SELECT * FROM gerencias_2
                    WHERE id = '".$id."'"; //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }

    //gerencias_2
    //    id
    //    nombre
    public function gerencias_2_buscar_3(){
            $sql = "SELECT * 
                    FROM gerencias_2 ORDER BY nombre ASC";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }

}