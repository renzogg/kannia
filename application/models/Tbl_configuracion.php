<?php

class Tbl_configuracion extends CI_Model {

    private $tabla = "tbl_estados";

    public function __construct() {
        parent::__construct();
    }


      public function get_valores(){
        try{
            $query = $this->db->get($this->tabla);
            return $query->result();
        }
        catch(Exception $exc) {
            echo $exc->getMessage();
        }
    }

    public function guardar_configuracion($arrData) {
        //$arrData = array_merge($arrData, array( 'UsuarioCreacion' => $this->_arr_Sesion['user'], 'FechaCreacion' => date("Y-m-d H:i:s") ));

        try {
            $this->db->where('ID_ESTADO',  $arrData["ID_ESTADO"]);
            $this->db->update('tbl_estados', $arrData); 
            if ($this->db->trans_status() === true)
                return true;
            else
                return false;
        } catch (Exception $e) {
            return false;
        }
    }


 

}

?>