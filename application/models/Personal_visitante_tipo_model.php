<?php
class Personal_visitante_tipo_model extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }

    //personal_visitante_tipo
    //    id
    //    nombre
    public function personal_visitante_tipo_buscar_2($id){
            $sql = "SELECT * FROM personal_visitante_tipo
                    WHERE id = '".$id."'"; //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }

    //personal_visitante_tipo
    //    id
    //    nombre
    public function personal_visitante_tipo_buscar_3(){
            $sql = "SELECT * FROM personal_visitante_tipo ORDER BY nombre ASC";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }    

}