<?php

class Tbl_alerta extends CI_Model
{

    private $tabla = "tbl_sensores";

    public function __construct()
    {
        parent::__construct();
    }

    public function get_list_tags()
    {
        try {
            $sql = 'select  codigo_rfid as tag,fecha as fecha FROM tbl_movimientos where estado =1 order by fecha desc ';
            $query = $this->db->query($sql);

            return $query->result_array();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

    public function get_list_real()
    {
        try {
            $sql = 'select  codigo_rfid as tag,fecha as fecha FROM tbl_movimientos  where estado =1 order by fecha desc limit 20';
            $query = $this->db->query($sql);

            return $query->result_array();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
    public function get_list_ultimo_chip()
    {
        try {
            $sql = 'select codigo_rfid as tag FROM tbl_movimientos where estado =1 order by fecha desc limit 1';
            $query = $this->db->query($sql);

            return $query->result_array();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
    public function get_fecha_ultimo_chip()
    {
        try {
            $sql = 'select  fecha as ultima_lectura FROM tbl_movimientos  where estado =1 order by fecha desc limit 1';
            $query = $this->db->query($sql);

            return $query->result_array();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
    // CONSIGO LA FECHA DEL ULTIMO CHIP LEIDO
    public function get_fecha_chip($cod_rfid)
    {
        try {
            $sql = "SELECT fecha AS fecha_lectura FROM tbl_movimientos WHERE codigo_rfid = '" .$cod_rfid. "'  AND estado_movimiento = '1' ORDER BY fecha DESC limit 1";
            $query = $this->db->query($sql);

            return $query->result_array();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

    public function get_encontrados()
    {
        try {
            $sql = "SELECT count(*) as encontrados FROM tbl_activos WHERE fecha_lectura!='' and estado = '1'";
            $query = $this->db->query($sql);

            return $query->row();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
    public function get_encontrados_ubigeo($ubigeo,$ubicacion)
    {
        try {
            $sql = "SELECT count(*) as encontrados FROM tbl_activos WHERE fecha_lectura!='' and estado = '1' and ubigeo = '" .$ubigeo. "' and ubicacion = '" .$ubicacion. "' ";
            $query = $this->db->query($sql);

            return $query->row();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
    public function get_encontrados_ubigeo_abc($ubigeo,$ubicacion)
    {
        try {
            $sql = "SELECT count(*) as encontrados FROM tbl_activos_abc_logistics WHERE fecha_lectura!='' and estado = '1' and ubigeo = '" .$ubigeo. "' and ubicacion = '" .$ubicacion. "' ";
            $query = $this->db->query($sql);

            return $query->row();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
    public function get_no_encontrados()
    {
        try {
            $sql = "SELECT count(*) as no_encontrados FROM tbl_activos WHERE fecha_lectura=''and estado = '1'";
            $query = $this->db->query($sql);

            return $query->row();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
    public function get_no_encontrados_ubigeo($ubigeo,$ubicacion)
    {
        try {
            $sql = "SELECT count(*) as no_encontrados FROM tbl_activos WHERE fecha_lectura='' and estado = '1' and ubigeo = '" .$ubigeo. "' and ubicacion = '" .$ubicacion. "' ";
            $query = $this->db->query($sql);

            return $query->row();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
    public function get_no_encontrados_ubigeo_abc($ubigeo,$ubicacion)
    {
        try {
            $sql = "SELECT count(*) as no_encontrados FROM tbl_activos_abc_logistics WHERE fecha_lectura='' and estado = '1' and ubigeo = '" .$ubigeo. "' and ubicacion = '" .$ubicacion. "' ";
            $query = $this->db->query($sql);

            return $query->row();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

    public function get_estado_ultimo_chip($cod_rfid)
    {
        try {
            $sql = 'select estado as estado FROM tbl_movimientos where codigo_rfid ='.$cod_rfid.' and estado = 1 order by fecha desc limit 1';
            $query = $this->db->query($sql);

            return $query->result_array();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
    
}
