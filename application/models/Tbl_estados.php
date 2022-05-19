<?php

class Tbl_estados extends CI_Model {

    private $tabla = "tbl_sensores";

    public function __construct() {
        parent::__construct();
    }


    function get_ultimo_A1() {
        try {

            $sql = " select  bmac,codigo_rodillo,descripcion,COD_COLOR,tempc
            from tbl_vinculacion
            INNER JOIN tbl_rodillo_maestro on tbl_rodillo_maestro.id=tbl_vinculacion.id_rodillo
            inner join tbl_sensores on tbl_sensores.bmac=tbl_vinculacion.codigo_sensor
            inner join tbl_estados on tbl_estados.id_estado=tbl_sensores.estado_sensor
            where codigo_rodillo='A1'
            ORDER BY date desc 
            LIMIT 1  ";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }


    function get_ultimo_A2() {
        try {

            $sql = " select  bmac,codigo_rodillo,descripcion,COD_COLOR,tempc
            from tbl_vinculacion
            INNER JOIN tbl_rodillo_maestro on tbl_rodillo_maestro.id=tbl_vinculacion.id_rodillo
            inner join tbl_sensores on tbl_sensores.bmac=tbl_vinculacion.codigo_sensor
            inner join tbl_estados on tbl_estados.id_estado=tbl_sensores.estado_sensor
            where codigo_rodillo='A2'
            ORDER BY date desc 
            LIMIT 1  ";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }


    function get_ultimo_A3() {
        try {

            $sql = "select  bmac,codigo_rodillo,descripcion,COD_COLOR,tempc
            from tbl_vinculacion
            INNER JOIN tbl_rodillo_maestro on tbl_rodillo_maestro.id=tbl_vinculacion.id_rodillo
            inner join tbl_sensores on tbl_sensores.bmac=tbl_vinculacion.codigo_sensor
            inner join tbl_estados on tbl_estados.id_estado=tbl_sensores.estado_sensor
            where codigo_rodillo='A3'
            ORDER BY date desc 
            LIMIT 1  ";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }

    function get_ultimo_B1() {
        try {

            $sql = " select  bmac,codigo_rodillo,descripcion,COD_COLOR,tempc
            from tbl_vinculacion
            INNER JOIN tbl_rodillo_maestro on tbl_rodillo_maestro.id=tbl_vinculacion.id_rodillo
            inner join tbl_sensores on tbl_sensores.bmac=tbl_vinculacion.codigo_sensor
            inner join tbl_estados on tbl_estados.id_estado=tbl_sensores.estado_sensor
            where codigo_rodillo='B1'
            ORDER BY date desc 
            LIMIT 1  ";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }

    function get_ultimo_B2() {
        try {

            $sql = " select  bmac,codigo_rodillo,descripcion,COD_COLOR,tempc
            from tbl_vinculacion
            INNER JOIN tbl_rodillo_maestro on tbl_rodillo_maestro.id=tbl_vinculacion.id_rodillo
            inner join tbl_sensores on tbl_sensores.bmac=tbl_vinculacion.codigo_sensor
            inner join tbl_estados on tbl_estados.id_estado=tbl_sensores.estado_sensor
            where codigo_rodillo='B2'
            ORDER BY date desc 
            LIMIT 1  ";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }

    function get_ultimo_B3() {
        try {

            $sql = " select  bmac,codigo_rodillo,descripcion,COD_COLOR,tempc
            from tbl_vinculacion
            INNER JOIN tbl_rodillo_maestro on tbl_rodillo_maestro.id=tbl_vinculacion.id_rodillo
            inner join tbl_sensores on tbl_sensores.bmac=tbl_vinculacion.codigo_sensor
            inner join tbl_estados on tbl_estados.id_estado=tbl_sensores.estado_sensor
            where codigo_rodillo='B3'
            ORDER BY date desc 
            LIMIT 1  ";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }


    function get_ultimo_C1() {
        try {

            $sql = " select  bmac,codigo_rodillo,descripcion,COD_COLOR,tempc
            from tbl_vinculacion
            INNER JOIN tbl_rodillo_maestro on tbl_rodillo_maestro.id=tbl_vinculacion.id_rodillo
            inner join tbl_sensores on tbl_sensores.bmac=tbl_vinculacion.codigo_sensor
            inner join tbl_estados on tbl_estados.id_estado=tbl_sensores.estado_sensor
            where codigo_rodillo='C1'
            ORDER BY date desc 
            LIMIT 1  ";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }

    function get_ultimo_C2() {
        try {

            $sql = " select  bmac,codigo_rodillo,descripcion,COD_COLOR,tempc
            from tbl_vinculacion
            INNER JOIN tbl_rodillo_maestro on tbl_rodillo_maestro.id=tbl_vinculacion.id_rodillo
            inner join tbl_sensores on tbl_sensores.bmac=tbl_vinculacion.codigo_sensor
            inner join tbl_estados on tbl_estados.id_estado=tbl_sensores.estado_sensor
            where codigo_rodillo='C2'
            ORDER BY date desc 
            LIMIT 1  ";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }

    function get_ultimo_C3() {
        try {

            $sql = " select  bmac,codigo_rodillo,descripcion,COD_COLOR,tempc
            from tbl_vinculacion
            INNER JOIN tbl_rodillo_maestro on tbl_rodillo_maestro.id=tbl_vinculacion.id_rodillo
            inner join tbl_sensores on tbl_sensores.bmac=tbl_vinculacion.codigo_sensor
            inner join tbl_estados on tbl_estados.id_estado=tbl_sensores.estado_sensor
            where codigo_rodillo='C3'
            ORDER BY date desc 
            LIMIT 1  ";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }

    function get_ultimo_D1() {
        try {

            $sql = " select  bmac,codigo_rodillo,descripcion,COD_COLOR,tempc
            from tbl_vinculacion
            INNER JOIN tbl_rodillo_maestro on tbl_rodillo_maestro.id=tbl_vinculacion.id_rodillo
            inner join tbl_sensores on tbl_sensores.bmac=tbl_vinculacion.codigo_sensor
            inner join tbl_estados on tbl_estados.id_estado=tbl_sensores.estado_sensor
            where codigo_rodillo='D1'
            ORDER BY date desc 
            LIMIT 1  ";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }

    function get_ultimo_D2() {
        try {

            $sql = " select  bmac,codigo_rodillo,descripcion,COD_COLOR,tempc
            from tbl_vinculacion
            INNER JOIN tbl_rodillo_maestro on tbl_rodillo_maestro.id=tbl_vinculacion.id_rodillo
            inner join tbl_sensores on tbl_sensores.bmac=tbl_vinculacion.codigo_sensor
            inner join tbl_estados on tbl_estados.id_estado=tbl_sensores.estado_sensor
            where codigo_rodillo='D2'
            ORDER BY date desc 
            LIMIT 1  ";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }

    function get_ultimo_D3() {
        try {

            $sql = " select  bmac,codigo_rodillo,descripcion,COD_COLOR,tempc
            from tbl_vinculacion
            INNER JOIN tbl_rodillo_maestro on tbl_rodillo_maestro.id=tbl_vinculacion.id_rodillo
            inner join tbl_sensores on tbl_sensores.bmac=tbl_vinculacion.codigo_sensor
            inner join tbl_estados on tbl_estados.id_estado=tbl_sensores.estado_sensor
            where codigo_rodillo='D3'
            ORDER BY date desc 
            LIMIT 1  ";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }


        function get_ultimo_E1() {
        try {
            
            $sql = " select  bmac,codigo_rodillo,descripcion,COD_COLOR,tempc
            from tbl_vinculacion
            INNER JOIN tbl_rodillo_maestro on tbl_rodillo_maestro.id=tbl_vinculacion.id_rodillo
            inner join tbl_sensores on tbl_sensores.bmac=tbl_vinculacion.codigo_sensor
            inner join tbl_estados on tbl_estados.id_estado=tbl_sensores.estado_sensor
            where codigo_rodillo='E1'
            ORDER BY date desc 
            LIMIT 1  ";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }

    function get_ultimo_E2() {
        try {
            
            $sql = " select  bmac,codigo_rodillo,descripcion,COD_COLOR,tempc
            from tbl_vinculacion
            INNER JOIN tbl_rodillo_maestro on tbl_rodillo_maestro.id=tbl_vinculacion.id_rodillo
            inner join tbl_sensores on tbl_sensores.bmac=tbl_vinculacion.codigo_sensor
            inner join tbl_estados on tbl_estados.id_estado=tbl_sensores.estado_sensor
            where codigo_rodillo='E2'
            ORDER BY date desc 
            LIMIT 1  ";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }

    function get_ultimo_E3() {
        try {
            
            $sql = " select  bmac,codigo_rodillo,descripcion,COD_COLOR,tempc
            from tbl_vinculacion
            INNER JOIN tbl_rodillo_maestro on tbl_rodillo_maestro.id=tbl_vinculacion.id_rodillo
            inner join tbl_sensores on tbl_sensores.bmac=tbl_vinculacion.codigo_sensor
            inner join tbl_estados on tbl_estados.id_estado=tbl_sensores.estado_sensor
            where codigo_rodillo='E3'
            ORDER BY date desc 
            LIMIT 1  ";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }


    function get_estado_atencion() {
        try {

            $sql = " select count(distinct bmac),COD_COLOR from tbl_sensores 
            INNER JOIN  tbl_estados on tbl_sensores.estado_sensor=tbl_estados.id_estado
            where estado_sensor=2 ";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }

    function get_estado_peligro() {
        try {

            $sql = " select count(distinct bmac),COD_COLOR from tbl_sensores 
            INNER JOIN  tbl_estados on tbl_sensores.estado_sensor=tbl_estados.id_estado
            where estado_sensor=3 ";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }

    

    



}

?>