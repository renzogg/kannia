<?php

class Tbl_pacientes extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_ultimos_dos_chips()
    {
        try {
            $sql = 'select codigo_rfid as codigo_rfid FROM tbl_movimientos where estado =1 order by id_mov desc limit 2';
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
    public function get_cama($codigo_rfid)
    {
        try {
            $sql = "SELECT descripcion,codigo_rfid,codigo_paciente FROM tbl_cama WHERE codigo_rfid = '" . $codigo_rfid . "'";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }

    public function get_brazalete($codigo_rfid)
    {
        try {
            $sql = "SELECT descripcion,codigo_rfid,codigo_paciente FROM tbl_brazalete WHERE codigo_rfid = '" . $codigo_rfid . "'";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    public function get_paciente($codigo_paciente)
    {
        try {
            $sql = "SELECT nombres,apellidos,imagen FROM tbl_pacientes WHERE codigo_paciente = '" . $codigo_paciente . "'";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    public function get_control_cama_brazalete_paciente()
    {
        try {
            $sql = "SELECT tbl_cama.codigo_rfid AS cod_rfid_cama,tbl_cama.descripcion AS descripcion_cama, tbl_brazalete.codigo_rfid AS cod_rfid_brazalete,tbl_brazalete.descripcion AS descripcion_brazalete, tbl_paciente.codigo_pacente AS codigo_paciente FROM ((tbl_cama INNER JOIN tbl_brazalete ON tbl_cama.codigo_paciente=tbl_brazalete.codigo_paciente) INNER JOIN tbl_pacientes ON tbl_pacientes.codigo_paciente=tbl_brazalete.codigo_paciente)"; 

            $query = $this->db->query($sql);

            return $query->result_array();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
}
