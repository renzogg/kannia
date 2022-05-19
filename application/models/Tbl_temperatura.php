<?php

class Tbl_temperatura extends CI_Model {

    private $tabla = "tbl_sensores";

    public function __construct() {
        parent::__construct();
    }
  

      public function get_temperature(){
        try{
            $sql = 'select ifnull(m.codigo_rodillo, "NO VINCULADO") as codigo_rodillo, s.tempf, s.tempc, s.hm, s.bmac, s.date, s.estado_sensor from tbl_sensores s left join tbl_vinculacion v  on s.bmac = v.codigo_sensor left join tbl_rodillo_maestro m on v.id_rodillo = m.id order by s.date desc';

            $query = $this->db->query($sql);
          
            return $query->result_array();
        }
        catch(Exception $exc) {
            echo $exc->getMessage();
        }
    }



    function get_list_temperature_chart($data) {
        try {                      
            $rodillo=$data['rodillo'];
            $fecha=$data['fecha'];
                //$sql = "(SELECT tempc, SUBSTR(date,11, 9) as fecha FROM tbl_sensores WHERE  bmac= '353' ORDER BY date desc LIMIT 20) order by fecha asc";
             $sql = "(SELECT s.tempc, SUBSTR(s.date,11, 9) as fecha FROM tbl_sensores s left join tbl_vinculacion v ON s.bmac = v.codigo_sensor  WHERE v.id_rodillo='".$rodillo."' AND   SUBSTR(s.date,1, 10) ='".$fecha."' ORDER BY date desc LIMIT 20) order by fecha asc";
            
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }

    function get_list_humedad_chart($data) {
        try {                 
            $rodillo=$data['rodillo'];
            $fecha=$data['fecha'];     
        
                $sql = "(SELECT s.hm, SUBSTR(s.date,11, 9) as fecha FROM tbl_sensores s left join tbl_vinculacion v ON s.bmac = v.codigo_sensor  WHERE v.id_rodillo='".$rodillo."' AND   SUBSTR(s.date,1, 10) = '".$fecha."' ORDER BY date desc LIMIT 20) order by fecha asc";
        
            
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
 function get_last_temp_value($rodillo) {
        try {                      
        
            $sql = "select s.tempc as tempc,SUBSTR(s.date,11, 9) as fecha FROM tbl_sensores s left join tbl_vinculacion v on s.bmac = v.codigo_sensor WHERE v.id_rodillo = '".$rodillo."' ORDER BY date desc limit 1";  
            //$sql = "SELECT s.tempc, SUBSTR(s.date,11, 9) as fecha FROM tbl_sensores s left join tbl_vinculacion v ON s.bmac = v.codigo_sensor  WHERE v.id_rodillo='".$rodillo."'  ORDER BY date desc LIMIT 1";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }

     function get_last_hm_value($rodillo) {
        try { 
            $sql = "select s.hm as hm, SUBSTR(s.date,11, 9) as fecha FROM tbl_sensores s left join tbl_vinculacion v on s.bmac = v.codigo_sensor WHERE v.id_rodillo = '".$rodillo."' ORDER BY date desc limit 1";  
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }

    function get_alertas_hoy($fecha){
        try {    
            $sql = "select COUNT(1) as total FROM tbl_sensores WHERE estado_sensor = 3 AND SUBSTR(date,1,10) = '".$fecha."'";  
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }

    function get_atencion_hoy($fecha){
        try { 
            $sql = "select COUNT(1) as total FROM tbl_sensores WHERE estado_sensor = 2 AND SUBSTR(date,1,10) = '".$fecha."'";  
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }

    function get_normal_hoy($fecha){
        try {                              
            $sql = "select COUNT(1) as total FROM tbl_sensores WHERE estado_sensor = 1 AND SUBSTR(date,1,10) = '".$fecha."'";  
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
 
    

    



}

?>