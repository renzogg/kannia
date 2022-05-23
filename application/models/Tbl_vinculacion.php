<?php

class Tbl_vinculacion extends CI_Model
{

    private $tabla = "tbl_vinculacion";

    public function __construct()
    {
        parent::__construct();
    }

    function get_lista_matriculados()
    {
        try {

            $sql = "SELECT id,descripcion,cliente,codigo_producto,codigo_rfid,ubicacion,peso,ancho,profundidad,lote,orden_ingreso,fecha_ingreso FROM tbl_activos order by fecha_ingreso desc";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    function get_lista_vinculacion()
    {
        try {

            //$sql = "SELECT a.codigo_rodillo, b.codigo_sensor, b.fecha_vinculacion FROM tbl_vinculacion b, tbl_rodillo_maestro a  WHERE b.id_rodillo = a.id";
            $sql = "SELECT codigo_rfid,cod_inventario,fecha_vinculacion FROM tbl_vinculacion order by fecha_vinculacion desc";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    function get_lista_activos_matriculados_fecha_salida($ubigeo,$ubicacion,$fecha)
    {
        
        try {

            $sql = "SELECT tbl_activos_abc_logistics.id as id,tbl_activos_abc_logistics.descripcion as descripcion,tbl_activos_abc_logistics.cliente as cliente,tbl_activos_abc_logistics.codigo as codigo_producto,tbl_vinculacion.codigo_rfid as codigo_rfid,tbl_activos_abc_logistics.ubicacion as ubicacion,tbl_activos_abc_logistics.lote as lote,tbl_activos_abc_logistics.orden_ingreso as orden_ingreso,tbl_activos_abc_logistics.guia_remision as guia_remision,tbl_activos_abc_logistics.estado as estado,tbl_activos_abc_logistics.programacion as programacion,tbl_activos_abc_logistics.fecha_ingreso as fecha_ingreso FROM tbl_activos_abc_logistics inner join tbl_vinculacion on tbl_vinculacion.id_activo=tbl_activos_abc_logistics.id WHERE tbl_activos_abc_logistics.estado = '1'  and tbl_activos_abc_logistics.ubigeo='".$ubigeo."' and tbl_activos_abc_logistics.ubicacion='".$ubicacion."' order by fecha_ingreso asc";
           
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
     function get_lista_vinculacion_masiva()
    {
        try {
            $sql = "SELECT id_mov,identificador,codigo_rfid,mac,estado,estado_movimiento,antenna,diferencia,fecha FROM tbl_vinculacion_masiva WHERE estado = '1' ";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    function limpiar_tabla_masiva(){
        try {
            $sql = "TRUNCATE TABLE tbl_vinculacion_masiva";
            $query = $this->db->query($sql);
            return TRUE;
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    function get_lista_activos_matriculados_fecha_salida_ubigeo($ubigeo,$ubicacion)
    {
        try {

            $sql = "SELECT tbl_activos_abc_logistics.id as id,tbl_activos_abc_logistics.descripcion as descripcion,tbl_activos_abc_logistics.cliente as cliente,tbl_activos_abc_logistics.codigo as codigo_producto,tbl_vinculacion.codigo_rfid as codigo_rfid,tbl_activos_abc_logistics.ubigeo as ubigeo,tbl_activos_abc_logistics.ubicacion as ubicacion,tbl_activos_abc_logistics.valor as valor,tbl_activos_abc_logistics.peso as peso,tbl_activos_abc_logistics.ancho as ancho,tbl_activos_abc_logistics.profundidad as profundidad,tbl_activos_abc_logistics.lote as lote,tbl_activos_abc_logistics.orden_ingreso as orden_ingreso,tbl_activos_abc_logistics.estado as estado,tbl_activos_abc_logistics.programacion as programacion,tbl_activos_abc_logistics.fecha_ingreso as fecha_ingreso FROM tbl_activos_abc_logistics inner join tbl_vinculacion on tbl_vinculacion.codigo_producto=tbl_activos_abc_logistics.codigo WHERE tbl_activos_abc_logistics.estado = '1' AND tbl_activos_abc_logistics.ubigeo = '" . $ubigeo . "' AND tbl_activos_abc_logistics.ubicacion = '" . $ubicacion . "' order by fecha_ingreso asc";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    public function get_encontrados_programados_ubigeo($ubigeo,$ubicacion)
    {
        try {
            $sql = "SELECT count(*) as encontrados FROM tbl_activos WHERE fecha_lectura!='' and estado = '1' and ubigeo = '" .$ubigeo. "' and ubicacion = '" .$ubicacion. "' and programacion = '1' ";
            $query = $this->db->query($sql);

            return $query->row();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
    public function get_encontrados_programados_ubigeo_abc($ubigeo,$ubicacion)
    {
        try {
            $sql = "SELECT count(*) as encontrados FROM tbl_activos_abc_logistics WHERE fecha_lectura!='' and estado = '1' and ubigeo = '" .$ubigeo. "' and ubicacion = '" .$ubicacion. "' and programacion = '1' ";
            $query = $this->db->query($sql);

            return $query->row();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
    public function get_no_encontrados_programados_ubigeo($ubigeo,$ubicacion)
    {
        try {
            $sql = "SELECT count(*) as no_encontrados FROM tbl_activos WHERE fecha_lectura='' and estado = '1' and ubigeo = '" .$ubigeo. "' and ubicacion = '" .$ubicacion. "' and programacion = '1' ";
            $query = $this->db->query($sql);

            return $query->row();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
    public function get_no_encontrados_programados_ubigeo_abc($ubigeo,$ubicacion)
    {
        try {
            $sql = "SELECT count(*) as no_encontrados FROM tbl_activos_abc_logistics WHERE fecha_lectura='' and estado = '1' and ubigeo = '" .$ubigeo. "' and ubicacion = '" .$ubicacion. "' and programacion = '1' ";
            $query = $this->db->query($sql);

            return $query->row();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
    function get_all_activos_programados_ubigeo_ubicacion($ubigeo,$ubicacion)
    {
        try {
            $query = $this->db->query("SELECT count(codigo_producto) cant_vinculados FROM tbl_activos WHERE ubigeo = '" . $ubigeo . "' AND ubicacion = '" . $ubicacion . "' AND estado = '1' AND programacion = '1' ");
            return $query->result_array();
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    function get_all_activos_programados_ubigeo_ubicacion_abc($ubigeo,$ubicacion)
    {
        try {
            $query = $this->db->query("SELECT count(id) cant_vinculados FROM tbl_activos_abc_logistics WHERE ubigeo = '" . $ubigeo . "' AND ubicacion = '" . $ubicacion . "' AND estado = '1' AND programacion = '1' ");
            return $query->result_array();
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    function get_lista_activos_matriculados_programados_ubigeo($ubigeo,$ubicacion)
    {
        try {

            $sql = "SELECT tbl_activos.id as id,tbl_activos.descripcion as descripcion,tbl_activos.cliente as cliente,tbl_activos.codigo_producto as codigo_producto,tbl_activos.unidad_medida as unidad_medida,tbl_activos.cantidad as cantidad,tbl_vinculacion.codigo_rfid as codigo_rfid,tbl_activos.valor as valor,tbl_activos.ubigeo as ubigeo,tbl_activos.ubicacion as ubicacion,tbl_activos.peso as peso,tbl_activos.ancho as ancho,tbl_activos.profundidad as profundidad,tbl_activos.lote as lote,tbl_activos.orden_ingreso as orden_ingreso,tbl_activos.estado as estado,tbl_activos.programacion as programacion,tbl_activos.fecha_ingreso as fecha_ingreso,tbl_activos.estado_lectura as estado_lectura,tbl_activos.fecha_lectura as fecha_lectura FROM tbl_activos inner join tbl_vinculacion on tbl_vinculacion.codigo_producto=tbl_activos.codigo_producto where tbl_activos.estado = '1' AND tbl_activos.programacion = '1' AND tbl_activos.ubigeo = '" . $ubigeo . "' AND  tbl_activos.ubicacion = '" . $ubicacion . "' order by fecha_ingreso asc";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    function get_lista_activos_matriculados_programados_ubigeo_abc($ubigeo,$ubicacion)
    {
        try {

            $sql = "SELECT tbl_activos_abc_logistics.id as id,tbl_activos_abc_logistics.descripcion as descripcion,tbl_activos_abc_logistics.cliente as cliente,tbl_activos_abc_logistics.codigo as codigo_producto,tbl_activos_abc_logistics.unidad_medida as unidad_medida,tbl_activos_abc_logistics.cantidad as cantidad,tbl_vinculacion.codigo_rfid as codigo_rfid,tbl_activos_abc_logistics.valor as valor,tbl_activos_abc_logistics.ubigeo as ubigeo,tbl_activos_abc_logistics.ubicacion as ubicacion,tbl_activos_abc_logistics.nro_dam as nro_dam,tbl_activos_abc_logistics.guia_remision as guia_remision,tbl_activos_abc_logistics.nro_operacion as nro_operacion,tbl_activos_abc_logistics.item as item,tbl_activos_abc_logistics.familia_producto as familia_producto,tbl_activos_abc_logistics.estado as estado,tbl_activos_abc_logistics.programacion as programacion,tbl_activos_abc_logistics.fecha_ingreso as fecha_ingreso,tbl_activos_abc_logistics.estado_lectura as estado_lectura,tbl_activos_abc_logistics.fecha_lectura as fecha_lectura FROM tbl_activos_abc_logistics inner join tbl_vinculacion on tbl_vinculacion.id_activo=tbl_activos_abc_logistics.id where tbl_activos_abc_logistics.estado = '1' AND tbl_activos_abc_logistics.programacion = '1' AND tbl_activos_abc_logistics.ubigeo = '" . $ubigeo . "' AND  tbl_activos_abc_logistics.ubicacion = '" . $ubicacion . "' order by fecha_lectura desc, fecha_ingreso desc";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    function get_lista_activos_con_salida()
    {
        try {

            $sql = "SELECT tbl_salida.id_salida as id,tbl_salida.codigo_producto as codigo_producto,tbl_salida.codigo_rfid as codigo_rfid,tbl_salida.descripcion as descripcion,tbl_salida.orden_ingreso as orden_ingreso,tbl_activos_abc_logistics.item as item,tbl_salida.orden_salida as orden_salida,tbl_salida.guia_remision as guia_remision,tbl_salida.fecha_salida as fecha_salida,tbl_activos_abc_logistics.fecha_ingreso as fecha_ingreso FROM tbl_salida inner join tbl_activos_abc_logistics on tbl_activos_abc_logistics.id=tbl_salida.id_activo WHERE tbl_salida.estado_salida = '1' order by tbl_activos_abc_logistics.fecha_ingreso desc";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    public function get_fecha_orden_salida($id_producto)
    {
        try {
            $sql = "SELECT id_activo,orden_salida,fecha_salida FROM tbl_salida WHERE id_activo = '" . $id_producto . "'";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    public function get_orden_salida($cod_rfid)
    {
        try {
            $sql = "SELECT orden_salida FROM tbl_salida WHERE codigo_rfid = '" . $cod_rfid . "'";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    
    public function get_activos_vinculados()
    {
        try {
            $sql = "select tbl_vinculacion.codigo_rfid as cod_rfid,tbl_vinculacion.cod_inventario as cod_inve, tbl_inventario.descripcion as descripcion,tbl_inventario.imagen as imagen, tbl_vinculacion.fecha_vinculacion as fecha_vinculacion from tbl_vinculacion inner join tbl_inventario on tbl_vinculacion.cod_inventario=tbl_inventario.codigo where tbl_inventario.status = '1' order by tbl_vinculacion.fecha_vinculacion desc";

            $query = $this->db->query($sql);

            return $query->result_array();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

    public function get_cod_activo_vinculado($cod_inve)
    {
        try {
            $this->db->where('cod_inventario', $cod_inve);
            $query = $this->db->get('tbl_vinculacion');
            return $query->row();
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    public function get_cod_rfid_vinculado_antiguo($cod_rfid)
    {
        try {
            $this->db->where('codigo_rfid', $cod_rfid);
            $query = $this->db->get('tbl_vinculacion');
            return $query->row();
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    public function get_cod_rfid_vinculado($cod_rfid)
    {
        try {
            $sql = "SELECT codigo_rfid FROM tbl_vinculacion WHERE codigo_rfid = '" . $cod_rfid . "'";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    public function get_cod_rfid_vinculado_editar($id_producto)
    {
        try {
            $sql = "SELECT codigo_rfid FROM tbl_vinculacion WHERE id_activo = '" . $id_producto . "'";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    public function get_cod_producto($cod_rfid)
    {
        try {
            $sql = "SELECT id_activo, codigo_producto FROM tbl_vinculacion WHERE id_activo = '" . $cod_rfid . "'";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {    
            return false;
        }
    }
       public function get_cod_producto_rfid($cod_rfid)
    {
        try {
            $sql = "SELECT id_activo, codigo_producto FROM tbl_vinculacion WHERE codigo_rfid = '" . $cod_rfid . "'";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {    
            return false;
        }
    }
     public function get_id_producto($cod_rfid)
    {
        try {
            $sql = "SELECT id_activo FROM tbl_vinculacion WHERE codigo_rfid = '" . $cod_rfid . "'";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {    
            return false;
        }
    }
    public function get_atributos_vinculado_producto($cod_producto)
    {
        try {
            $sql = "SELECT descripcion,orden_ingreso FROM tbl_activos WHERE codigo_producto = '" . $cod_producto . "'";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    public function get_atributos_vinculado_producto_abc($id_producto)
    {
        try {
            $sql = "SELECT tbl.id,tbl.codigo,tbl.descripcion,tbl.guia_remision,tbl.orden_ingreso,tbl.item,v.codigo_rfid FROM tbl_activos_abc_logistics tbl join tbl_vinculacion v on v.id_activo = tbl.id WHERE tbl.id = '" . $id_producto . "'";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    public function get_atributos_vinculado_cod_rfid($id_producto)
    {
        try {
            $sql = "SELECT codigo_rfid FROM tbl_vinculacion WHERE id_activo = '" . $id_producto . "'";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    function get_lista_inventario_vinculacion()
    {
        try {

            //$sql = "SELECT a.codigo_rodillo, b.codigo_sensor, b.fecha_vinculacion FROM tbl_vinculacion b, tbl_rodillo_maestro a  WHERE b.id_rodillo = a.id";
            $sql = "SELECT codigo,descrIpcion FROM tbl_inventario";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }

    function add_vinculacion($arrData)
    {
        //$arrData = array_merge($arrData, array( 'UsuarioCreacion' => $this->_arr_Sesion['user'], 'FechaCreacion' => date("Y-m-d H:i:s") ));

        try {
            $this->db->insert('tbl_vinculacion', $arrData);
            if ($this->db->affected_rows() > 0)
                return true;
            else
                return false;
        } catch (Exception $e) {
            return false;
        }
    }
    function add_salida($arrData)
    {
        try {
            $this->db->insert('tbl_salida', $arrData);
            if ($this->db->affected_rows() > 0)
                return true;
            else
                return false;
        } catch (Exception $e) {
            return false;
        }
    }
    public function update_status($cod_rfid, $status)
    {
        try {
            $query = $this->db->query("UPDATE tbl_vinculacion SET status = '" . $status . "' WHERE codigo_rfid = '" . $cod_rfid . "'");
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    public function update_status_salida($cod_rfid, $status)
    {
        try {
            $query = $this->db->query("UPDATE tbl_salida SET estado_salida = '" . $status . "' WHERE id_activo = '" . $cod_rfid . "'");
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    public function get_atributos_actividad($actividad)
    {
        try {
            $sql = "SELECT mac as mac,ubigeo as ubigeo,ubicacion as ubicacion FROM tbl_devices_rfid WHERE actividad = '" . $actividad . "'";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    public function get_dispositivo_asignado($ubigeo,$ubicacion,$actividad)
    {
        try {
            $sql = "SELECT mac as mac FROM tbl_devices_rfid WHERE actividad = '" . $actividad . "' AND ubigeo = '" . $ubigeo . "' AND ubicacion = '" . $ubicacion . "'";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    public function get_dispositivo_asignado_recibo_deposito($actividad)
    {
        try {
            $sql = "SELECT mac as mac FROM tbl_devices_rfid WHERE actividad = '" . $actividad . "'";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    public function get_ubicacion_ubigeo($ubigeo,$actividad)
    {
        try {
            $sql = "SELECT ubicacion as ubicacion FROM tbl_devices_rfid WHERE ubigeo = '" . $ubigeo . "' AND actividad = '" . $actividad . "'";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
      public function limpiar_casillas()
    {
        try {
             $query = $this->db->query("UPDATE tbl_activos SET fecha_lectura = '' WHERE estado = '1'");
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    public function get_actividad_actual($actividad)
    {
        try {
            $sql = "SELECT ubigeo as ubigeo,ubicacion as ubicacion, actividad as actividad, fecha as fecha FROM tbl_actividad_actual WHERE actividad = '" . $actividad . "' order by fecha desc limit 1";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    public function get_actividad($actividad)
    {
        try {
            $sql = "SELECT actividad as actividad FROM tbl_devices_rfid WHERE actividad = '" . $actividad . "'";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    function add_actividad_Actual($arrData)
    {
        try {
            $this->db->insert('tbl_actividad_actual', $arrData);
            if ($this->db->affected_rows() > 0)
                return true;
            else
                return false;
        } catch (Exception $e) {
            return false;
        }
    }
    public function update_all_status($status)
    {
        try {
            $query = $this->db->query("UPDATE tbl_vinculacion SET status = '" . $status . "'WHERE status = '1'");
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    public function eliminar($cod_inve)
    {
        try {
            $this->db->delete('tbl_vinculacion', array('codigo_rfid' => $cod_inve));
            //print_r($this->db->delete('tbl_vinculacion', array('codigo_producto' => $cod_inve)));
            return TRUE;
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    public function eliminar_x_id($cod_inve)
    {
        try {
            $this->db->delete('tbl_vinculacion', array('id_activo' => $cod_inve));
            //print_r($this->db->delete('tbl_vinculacion', array('codigo_producto' => $cod_inve)));
            return TRUE;
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    public function eliminar_masiva($cod_inve)
    {
        try {
            $this->db->delete('tbl_vinculacion_masiva', array('id_mov' => $cod_inve));
            //print_r($this->db->delete('tbl_vinculacion', array('codigo_producto' => $cod_inve)));
        } catch (Exception $exc) {
            return FALSE;
        }
    }
}
