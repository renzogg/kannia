<?php
class Tbl_usuarios extends CI_Model{
public function __construct() {
parent::__construct();        
}


public function insertar($data){
$this->db->insert('usuario', $data);
}    

}