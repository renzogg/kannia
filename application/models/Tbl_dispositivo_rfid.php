<?php

class Tbl_dispositivo_rfid extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function add_dispositivo($arrData)
    {
        //$arrData = array_merge($arrData, array( 'UsuarioCreacion' => $this->_arr_Sesion['user'], 'FechaCreacion' => date("Y-m-d H:i:s") ));

        try {
            $this->db->insert('tbl_devices_rfid', $arrData);
            if ($this->db->affected_rows() > 0)
                return true;
            else
                return false;
        } catch (Exception $e) {
            return false;
        }
    }
    public function get_list_ultimo_mac()
    {
        try {
            $sql = 'select mac as mac FROM tbl_movimientos where estado =1 order by fecha desc limit 1';
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
    public function get_dispositivo($mac)
    {
        try {
            $sql = "SELECT mac FROM tbl_devices_rfid WHERE mac = '" . $mac . "'";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    public function get_lista_dispositivos()
    {
        try {

            $sql = "SELECT id_device,mac,ubigeo,usuario,ubicacion,actividad,estado,fecha_asignacion FROM tbl_devices_rfid order by fecha_asignacion desc";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    public function get_lista_dispositivos_actividad($actividad)
    {
        try {

            $sql = "SELECT id_device,mac,ubigeo,usuario,ubicacion,actividad,estado,fecha_asignacion FROM tbl_devices_rfid WHERE actividad = '" . $actividad . "'order by fecha_asignacion asc";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }


    public function eliminar($id_device)
    {
        try {
            $this->db->delete('tbl_devices_rfid', array('id_device' => $id_device));
        } catch (Exception $exc) {
            return FALSE;
        }
    }
}
