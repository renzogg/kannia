<?php

class Tbl_usuario extends CI_Model{
    private $tabla = 'usuario';
    private $contrasena = 'contrasena';
    private $usuario = 'usuario';

    public function __construct() {
        parent::__construct();        
    }

    public function get_usuario($id){
        try {   
            $this->db->where('id',$id);
            $query = $this->db->get($this->tabla);
            return $query->row();
        } catch (Exception $exc) {
            return FALSE;
        }
    }

    
    public function get_all_usuario(){
        try{
            $query = $this->db->get($this->tabla);
            return $query->result();
        }
        catch(Exception $exc) {
            echo $exc->getMessage();
        }
    }
    
    public function editar_usuario($datos,$id){
        try {
            $this->db->where('id', $id);
            $this->db->update($this->tabla, $datos); 
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    public function validar_usuario($usuario,$contrasena){
        try { 
            $this->db->where($this->usuario,$usuario);
            //$this->db->where($this->contrasena,md5(helper_get_semilla().$contrasena));
            $this->db->where($this->contrasena,$contrasena);
            $query = $this->db->get($this->tabla);

            if($query->num_rows() > 0){
        
                $this->session->set_userdata('logged','true');
                $row = $query->row_array();
                $this->session->set_userdata($row);
            }
            return $query->row();
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    /*public function get_all_usuarios_array(){
        try {
            $this->db->select('*');
            $this->db->from($this->tabla);
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    */

    public function insert_usuario($datos){
        try {
            $this->db->insert($this->tabla, $datos); 
        } catch (Exception $exc) {
            return FALSE;
        }
    }

    public function eliminar($id){
        try {
            $this->db->delete($this->tabla, array('id' => $id)); 
        } catch (Exception $exc) {
            return FALSE;
        }
    }
} 
?>