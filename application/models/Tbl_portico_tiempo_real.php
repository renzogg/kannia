<?php

class Tbl_portico_tiempo_real extends CI_Model
{

    private $tabla = "ktraceso_lectura_rfid";

    public function __construct()
    {
        parent::__construct();
    }

    public function get_portico_tiempo_real()
    {
        try {
            $sql = "SELECT tbl_movimientos.codigo_rfid AS cod_rfid,tbl_enrolados.fecha_enrolacion AS fecha_enrolacion, tbl_sujetos.dni AS dni,tbl_sujetos.nombres AS nombres,tbl_sujetos.apellidos AS apellidos,tbl_sujetos.imagen AS imagen, tbl_sujetos.cargo AS cargo,tbl_movimientos.fecha AS fecha FROM ((tbl_movimientos INNER JOIN tbl_enrolados ON tbl_movimientos.codigo_rfid=tbl_enrolados.codigo_rfid) INNER JOIN tbl_sujetos ON tbl_enrolados.dni=tbl_sujetos.dni) WHERE tbl_sujetos.estado_enrolado = 1 AND tbl_movimientos.estado = 1 ORDER BY tbl_movimientos.fecha DESC";

            $query = $this->db->query($sql);

            return $query->result_array();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
}
