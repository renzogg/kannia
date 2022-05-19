<?php

class Tbl_enrolados extends CI_Model
{

    private $tabla = "tbl_enrolados";

    public function __construct()
    {
        parent::__construct();
    }

    function get_lista_sujetos()
    {
        try {
            $sql = "SELECT id,dni,nombres,apellidos,cargo,imagen,estado_sujeto_enrolado FROM tbl_sujetos";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    function get_lista_sujetos_enrolados_cod_rfid($cod_rfid)
    {
        try {

            $sql = "SELECT tbl_sujetos.id as id,tbl_sujetos.dni as dni,tbl_sujetos.nombres as nombres,tbl_sujetos.apellidos as apellidos,tbl_sujetos.cargo as cargo,tbl_sujetos.imagen as imagen,tbl_enrolados.codigo_rfid as codigo_rfid,tbl_sujetos.estado_enrolado as estado,tbl_enrolados.fecha_enrolacion as fecha_enrolacion FROM tbl_sujetos inner join tbl_enrolados on tbl_enrolados.dni=tbl_sujetos.dni where tbl_enrolados.codigo_rfid = '" . $cod_rfid . "' AND  tbl_sujetos.estado_enrolado = '1' order by tbl_enrolados.fecha_enrolacion desc";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    
    function get_lista_sujetos_enrolados()
    {
        try {

            $sql = "SELECT tbl_sujetos.id as id,tbl_sujetos.dni as dni,tbl_sujetos.nombres as nombres,tbl_sujetos.apellidos as apellidos,tbl_sujetos.cargo as cargo,tbl_sujetos.imagen as imagen,tbl_sujetos.ubigeo as ubigeo,tbl_enrolados.codigo_rfid as codigo_rfid,tbl_sujetos.estado_enrolado as estado,tbl_enrolados.fecha_enrolacion as fecha_enrolacion FROM tbl_sujetos inner join tbl_enrolados on tbl_enrolados.dni=tbl_sujetos.dni where tbl_sujetos.estado_enrolado = '1' order by tbl_enrolados.fecha_enrolacion desc";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    function get_lista_activos_matriculados_ubigeo($ubigeo,$ubicacion)
    {
        try {

            $sql = "SELECT tbl_activos.id as id,tbl_activos.descripcion as descripcion,tbl_activos.cliente as cliente,tbl_activos.codigo_producto as codigo_producto,tbl_activos.unidad_medida as unidad_medida,tbl_activos.cantidad as cantidad,tbl_vinculacion.codigo_rfid as codigo_rfid,tbl_activos.valor as valor,tbl_activos.ubigeo as ubigeo,tbl_activos.ubicacion as ubicacion,tbl_activos.peso as peso,tbl_activos.ancho as ancho,tbl_activos.profundidad as profundidad,tbl_activos.lote as lote,tbl_activos.orden_ingreso as orden_ingreso,tbl_activos.estado as estado,tbl_activos.programacion as programacion,tbl_activos.fecha_ingreso as fecha_ingreso,tbl_activos.estado_lectura as estado_lectura FROM tbl_activos inner join tbl_vinculacion on tbl_vinculacion.codigo_producto=tbl_activos.codigo_producto where tbl_activos.estado = '1' AND tbl_activos.ubigeo = '" . $ubigeo . "' AND  tbl_activos.ubicacion = '" . $ubicacion . "' order by fecha_ingreso desc";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
   
    function get_all_vinculados()
    {
        try {
            $query = $this->db->query("SELECT count(codigo_rfid) cant_vinculados FROM tbl_vinculacion");
            return $query->result_array();
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    function get_all_vinculados_ubigeo_ubicacion($ubigeo,$ubicacion)
    {
        try {
            $query = $this->db->query("SELECT count(codigo_producto) cant_vinculados FROM tbl_activos WHERE ubigeo = '" . $ubigeo . "' AND ubicacion = '" . $ubicacion . "' AND estado = '1' ");
            return $query->result_array();
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    function get_salidas()
    {
        try {
            $query = $this->db->query("SELECT count(codigo_producto) cant_salidas FROM tbl_activos WHERE estado = '0' AND estado_salida = '1'");
            return $query->result_array();
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    function get_lista_inventario_no_vinculados()
    {
        try {

            //$sql = "SELECT a.codigo_rodillo, b.codigo_sensor, b.fecha_inventario FROM tbl_inventario b, tbl_rodillo_maestro a  WHERE b.id_rodillo = a.id";
            $sql = "SELECT id_inventario,codigo,descripcion,imagen,fecha_inventario FROM tbl_inventario WHERE status = '0' ";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }

    public function get_cod_repetido($rfid)
    {
        try {
            $sql = "SELECT codigo_rfid FROM tbl_enrolados WHERE codigo_rfid = '" . $rfid . "'";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    public function get_cod_dni_vinculado($dni)
    {
        try {
            $sql = "SELECT dni FROM tbl_enrolados WHERE dni = '" . $dni . "'";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }

    public function get_dni_rfid($cod_rfid)
    {
        try {
            $sql = "SELECT dni FROM tbl_enrolados WHERE codigo_rfid = '" . $cod_rfid . "'";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    function add_sujeto_enrolado($arrData)
    {
        //$arrData = array_merge($arrData, array( 'UsuarioCreacion' => $this->_arr_Sesion['user'], 'FechaCreacion' => date("Y-m-d H:i:s") ));

        try {
            $this->db->insert('tbl_enrolados', $arrData);
            if ($this->db->affected_rows() > 0)
                return true;
            else
                return false;
        } catch (Exception $e) {
            return false;
        }
    }
    function add_sujeto($arrData)
    {
        //$arrData = array_merge($arrData, array( 'UsuarioCreacion' => $this->_arr_Sesion['user'], 'FechaCreacion' => date("Y-m-d H:i:s") ));

        try {
            $this->db->insert('tbl_sujetos', $arrData);
            if ($this->db->affected_rows() > 0)
                return true;
            else
                return false;
        } catch (Exception $e) {
            return false;
        }
    }

    public function get_cod_dni($dni)
    {
        try {
            $this->db->where('dni', $dni);
            $this->db->where('estado_enrolado', '1');
            $query = $this->db->get('tbl_sujetos');
            return $query->row();
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    public function get_cod_dni_sujeto($dni)
    {
        try {
            $this->db->where('dni', $dni);
            $query = $this->db->get('tbl_sujetos');
            $this->db->where('estado_enrolado', '0');
            return $query->row();
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    public function get_cod_rfid_vinculado_editar($dni)
    {
        try {
            $sql = "SELECT codigo_rfid,fecha_enrolacion FROM tbl_enrolados WHERE dni = '" . $dni . "'";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    public function editar_sujeto($datos, $dni)
    {
        try {
            $this->db->where('dni', $dni);
            $this->db->update('tbl_sujetos', $datos);
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    public function editar_enrolado($datos, $cod_inventario)
    {
        try {
            $this->db->where('dni', $cod_inventario);
            $this->db->update('tbl_enrolados', $datos);
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    public function update_status($dni, $status)
    {
        try {
            $query = $this->db->query("UPDATE tbl_sujetos SET estado_enrolado = '" . $status . "' WHERE dni = '" . $dni . "'");
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    public function update_imagen($dni, $imagen)
    {
        try {
            $query = $this->db->query("UPDATE tbl_sujetos SET imagen = '" . $imagen . "' WHERE dni = '" . $dni . "'");
        } catch (Exception $exc) {
            return FALSE;
        }
    }

    public function eliminar($dni)
    {
        try {
            $this->db->delete('tbl_enrolados', array('dni' => $dni));
        } catch (Exception $exc) {
            return FALSE;
        }
    }
}
