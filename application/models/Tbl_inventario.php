<?php

class Tbl_inventario extends CI_Model
{

    private $tabla = "tbl_activos";

    public function __construct()
    {
        parent::__construct();
    }


    function get_lista_inventario()
    {
        try {

            //$sql = "SELECT a.codigo_rodillo, b.codigo_sensor, b.fecha_inventario FROM tbl_inventario b, tbl_rodillo_maestro a  WHERE b.id_rodillo = a.id";
            $sql = "SELECT id_inventario,codigo,descripcion,imagen,status,fecha_inventario FROM tbl_inventario";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    function get_lista_activos()
    {
        try {

            $sql = "SELECT id,descripcion,cliente,codigo_producto,ubigeo,ubicacion,valor,peso,ancho,profundidad,lote,cantidad,unidad_medida,orden_ingreso,estado,programacion,fecha_ingreso FROM tbl_activos order by fecha_ingreso asc";
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
    function get_lista_activos_matriculados_ubigeo_abc($ubigeo,$ubicacion)
    {
        try {

            $sql = "SELECT tbl_activos_abc_logistics.id as id,tbl_activos_abc_logistics.descripcion as descripcion,tbl_activos_abc_logistics.cliente as cliente,tbl_activos_abc_logistics.codigo as codigo,tbl_activos_abc_logistics.unidad_medida as unidad_medida,tbl_activos_abc_logistics.cantidad as cantidad,tbl_vinculacion.codigo_rfid as codigo_rfid,tbl_activos_abc_logistics.valor as valor,tbl_activos_abc_logistics.ubigeo as ubigeo,tbl_activos_abc_logistics.ubicacion as ubicacion,tbl_activos_abc_logistics.nro_dam as nro_dam,tbl_activos_abc_logistics.guia_remision as guia_remision,tbl_activos_abc_logistics.nro_operacion as nro_operacion,tbl_activos_abc_logistics.item as item,tbl_activos_abc_logistics.familia_producto as familia_producto,tbl_activos_abc_logistics.estado as estado,tbl_activos_abc_logistics.programacion as programacion,tbl_activos_abc_logistics.fecha_ingreso as fecha_ingreso,tbl_activos_abc_logistics.estado_lectura as estado_lectura,tbl_activos_abc_logistics.fecha_lectura as fecha_lectura FROM tbl_activos_abc_logistics inner join tbl_vinculacion on tbl_vinculacion.id_activo=tbl_activos_abc_logistics.id where tbl_activos_abc_logistics.estado = '1' AND tbl_activos_abc_logistics.ubigeo = '" . $ubigeo . "' AND  tbl_activos_abc_logistics.ubicacion = '" . $ubicacion . "' order by fecha_lectura desc, fecha_ingreso desc";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    
    function get_lista_activos_matriculados($ubigeo,$ubicacion,$fecha)
    {
        try {

            $sql = "SELECT tbl_activos_abc_logistics.id as id,tbl_activos_abc_logistics.descripcion as descripcion,tbl_activos_abc_logistics.cliente as cliente,tbl_activos_abc_logistics.codigo as codigo_producto,tbl_activos_abc_logistics.unidad_medida as unidad_medida,tbl_activos_abc_logistics.cantidad as cantidad,tbl_vinculacion.codigo_rfid as codigo_rfid,tbl_activos_abc_logistics.valor as valor,tbl_activos_abc_logistics.ubigeo as ubigeo,tbl_activos_abc_logistics.ubicacion as ubicacion,tbl_activos_abc_logistics.peso as peso,tbl_activos_abc_logistics.ancho as ancho,tbl_activos_abc_logistics.profundidad as profundidad,tbl_activos_abc_logistics.lote as lote,tbl_activos_abc_logistics.orden_ingreso as orden_ingreso,tbl_activos_abc_logistics.estado as estado,tbl_activos_abc_logistics.programacion as programacion,tbl_activos_abc_logistics.fecha_ingreso as fecha_ingreso,tbl_activos_abc_logistics.estado_lectura as estado_lectura FROM tbl_activos_abc_logistics inner join tbl_vinculacion on tbl_vinculacion.id_activo=tbl_activos_abc_logistics.id where tbl_activos_abc_logistics.estado = '1'
            and  tbl_activos_abc_logistics.ubigeo='".$ubigeo."'  and tbl_activos_abc_logistics.ubicacion='".$ubicacion."'
             order by fecha_ingreso desc";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    function get_all_programados()
    {
        try {
            $query = $this->db->query("SELECT count(programacion) cant_programados FROM tbl_activos_abc_logistics WHERE programacion = '1'");
            return $query->result_array();
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    function get_all_no_programados()
    {
        try {
            $query = $this->db->query("SELECT count(programacion) cant_no_programados FROM tbl_activos_abc_logistics WHERE programacion = '0' and estado = '1'");
            return $query->result_array();
        } catch (Exception $exc) {
            return FALSE;
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
    function get_all_vinculados_ubigeo_ubicacion_abc($ubigeo,$ubicacion)
    {
        try {
            $query = $this->db->query("SELECT count(id) cant_vinculados FROM tbl_activos_abc_logistics WHERE ubigeo = '" . $ubigeo . "' AND ubicacion = '" . $ubicacion . "' AND estado = '1' ");
            return $query->result_array();
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    function get_salidas()
    {
        try {
            $query = $this->db->query("SELECT count(id) cant_salidas FROM tbl_activos_abc_logistics WHERE estado = '0' AND estado_salida = '1'");
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

    function get_clientes()
    {
        try {

            //$sql = "SELECT a.codigo_rodillo, b.codigo_sensor, b.fecha_inventario FROM tbl_inventario b, tbl_rodillo_maestro a  WHERE b.id_rodillo = a.id";
            $sql = "SELECT cliente FROM tbl_clientes";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    function get_ubicacion()
    {
        try {
            $sql = "SELECT ubicacion FROM tbl_ubicacion";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    function get_ubigeo()
    {
        try {
            $sql = "SELECT ubigeo FROM tbl_ubigeo";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    function get_id_ubigeo($ubigeo)
    {
        try {
            $sql = "SELECT id_ubigeo FROM tbl_ubigeo WHERE ubigeo = '" . $ubigeo . "'";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    function get_ubicacion_ubigeo($id_ubigeo)
    {
        try {
            $sql = "SELECT tbl_ubicacion.ubicacion as ubicacion FROM tbl_ubicacion INNER JOIN tbl_ubigeo_ubicacion ON tbl_ubicacion.id_ubicacion = tbl_ubigeo_ubicacion.id_ubicacion WHERE tbl_ubigeo_ubicacion.id_ubigeo = '" . $id_ubigeo . "'";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    public function get_cod_repetido($cod_inventario)
    {
        try {
            $this->db->where('codigo_rfid', $cod_inventario);
            $query = $this->db->get('tbl_activos');
            return $query->row();
        } catch (Exception $exc) {
            return FALSE;
        }
    }

    public function get_cod_producto_repetido($cod_producto)
    {
        try {
            $sql = "SELECT codigo_producto FROM tbl_activos WHERE codigo_producto = '" . $cod_producto . "' AND estado='1'";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    function add_inventario($arrData)
    {
        //$arrData = array_merge($arrData, array( 'UsuarioCreacion' => $this->_arr_Sesion['user'], 'FechaCreacion' => date("Y-m-d H:i:s") ));

        try {
            $this->db->insert('tbl_inventario', $arrData);
            if ($this->db->affected_rows() > 0)
                return true;
            else
                return false;
        } catch (Exception $e) {
            return false;
        }
    }
    function add_activo($arrData)
    {
        //$arrData = array_merge($arrData, array( 'UsuarioCreacion' => $this->_arr_Sesion['user'], 'FechaCreacion' => date("Y-m-d H:i:s") ));

        try {
            $this->db->insert('tbl_activos', $arrData);
            if ($this->db->affected_rows() > 0)
                return true;
            else
                return false;
        } catch (Exception $e) {
            return false;
        }
    }
    function add_activo_abc($arrData)
    {
        //$arrData = array_merge($arrData, array( 'UsuarioCreacion' => $this->_arr_Sesion['user'], 'FechaCreacion' => date("Y-m-d H:i:s") ));

        try {
            $this->db->insert('tbl_activos_abc_logistics', $arrData);
            if ($this->db->affected_rows() > 0)
                return true;
            else
                return false;
        } catch (Exception $e) {
            return false;
        }
    }
    function add_activo_vinculado($arrData)
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
    public function get_id_inventario($id_inventario)
    {
        try {
            $this->db->where('id_inventario', $id_inventario);
            $query = $this->db->get('tbl_inventario');
            return $query->row();
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    public function get_cod_inventario($cod_inventario)
    {
        try {
            $this->db->where('codigo_producto', $cod_inventario);
            $query = $this->db->get('tbl_activos');
            return $query->row();
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    public function get_cod_inventario_abc($id_activo)
    {
        try {
            $this->db->where('item', $id_activo);
            $query = $this->db->get('tbl_activos_abc_logistics');
            return $query->row();
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    public function get_cod_inventario_parte_ingreso($id_activo,$correlativo)
    {
        try {
            $this->db->where('item', $id_activo);
            $this->db->where('correlativo', $correlativo);
            $query = $this->db->get('tbl_items_parte_ingreso');
            return $query->row();
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    public function get_cod_parte_ingreso($id_activo)
    {
        try {
            $this->db->where('id', $id_activo);
            $query = $this->db->get('tbl_partes_ingreso');
            return $query->row();
        } catch (Exception $exc) {
            return FALSE;
        }
    }

    public function editar_inventario($datos, $cod_inventario)
    {
        try {
            $this->db->where('codigo_producto', $cod_inventario);
            $this->db->update('tbl_activos', $datos);
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    public function editar_inventario_abc($datos, $cod_inventario)
    {
        try {
            $this->db->where('codigo', $cod_inventario);
            $this->db->update('tbl_activos_abc_logistics', $datos);
        } catch (Exception $exc) {
            return FALSE;
        }
    }
     public function editar_parte_ingreso($datos, $cod_inventario)
    {
        try {
            $this->db->where('id', $cod_inventario);
            $this->db->update('tbl_partes_ingreso', $datos);
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    public function update_status($cod_inventario, $status)
    {
        try {
            $query = $this->db->query("UPDATE tbl_activos SET estado = '" . $status . "' WHERE codigo_producto = '" . $cod_inventario . "'");
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    public function update_status_abc($id_activo, $status)
    {
        try {
            $query = $this->db->query("UPDATE tbl_activos_abc_logistics SET estado = '" . $status . "' WHERE id = '" . $id_activo . "'");
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    public function update_status_abc_tbl_salida($id_activo, $status)
    {
        try {
            $query = $this->db->query("UPDATE tbl_salida SET estado_salida = '" . $status . "' WHERE id = '" . $id_activo . "'");
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    public function update_status_salida($id_inventario, $status)
    {
        try {
            $query = $this->db->query("UPDATE tbl_activos_abc_logistics SET estado_salida = '" . $status . "' WHERE id = '" . $id_inventario . "'");
        } catch (Exception $exc) {
            return FALSE;
        }
    }
     public function update_status_salida_abc($id_inventario, $status)
    {
        try {
            $query = $this->db->query("UPDATE tbl_activos_abc_logistics SET estado_salida = '" . $status . "' WHERE id = '" . $id_inventario . "'");
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    public function update_status_programacion($cod_inventario, $status)
    {
        try {
            $query = $this->db->query("UPDATE tbl_activos SET programacion = '" . $status . "' WHERE codigo_producto = '" . $cod_inventario . "'");

            return TRUE;
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    public function update_status_programacion_abc($id_inventario, $status)
    {
        try {
            $query = $this->db->query("UPDATE tbl_activos_abc_logistics SET programacion = '" . $status . "' WHERE id = '" . $id_inventario . "'");

            return TRUE;
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    public function insertar_fecha_lectura($cod_producto, $fecha_lectura)
    {
        try {
            $query = $this->db->query("UPDATE tbl_activos SET fecha_lectura = '" . $fecha_lectura . "' WHERE codigo_producto = '" . $cod_producto . "'");

            return TRUE;
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    public function insertar_fecha_lectura_abc($id_producto, $fecha_lectura)
    {
        try {
            $query = $this->db->query("UPDATE tbl_activos_abc_logistics SET fecha_lectura = '" . $fecha_lectura . "' WHERE id = '" . $id_producto . "'");

            return TRUE;
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    public function insertar_estado_lectura($cod_producto, $status)
    {
        try {
            $query = $this->db->query("UPDATE tbl_activos SET estado_lectura = '" . $status . "' WHERE codigo_producto = '" . $cod_producto . "' AND estado = '1' ");
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    public function insertar_estado_lectura_abc($id_producto, $status)
    {
        try {
            $query = $this->db->query("UPDATE tbl_activos_abc_logistics SET estado_lectura = '" . $status . "' WHERE id = '" . $id_producto . "' AND estado = '1' ");
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    public function eliminar($cod_inventario)
    {
        try {
            $this->db->delete('tbl_activos_abc_logistics', array('id' => $cod_inventario));
            return true;
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    public function eliminar_parte_ingreso($correlativo)
    {
        try {
            $this->db->delete('tbl_partes_ingreso', array('correlativo' => $correlativo));
            return true;
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    public function eliminar_items_parte_ingreso($correlativo)
    {
        try {
            $this->db->delete('tbl_items_parte_ingreso', array('correlativo' => $correlativo));
            return true;
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    public function get_ultimo_id()
    {
        try {
            $sql = "SELECT id FROM tbl_activos_abc_logistics ORDER BY id desc limit 1";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    function get_activos_item($item,$correlativo)
    {
        try {
            $sql = "SELECT cantidad FROM tbl_activos_abc_logistics WHERE item = '" . $item ."' AND correlativo = '".$correlativo."'";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    function numero_items_vinculados($item,$correlativo)
    {
        try {
            $query = $this->db->query("SELECT count(item) cant_vinculados_x_item FROM tbl_activos_abc_logistics WHERE item = '".$item."' AND estado = '1'AND correlativo = '".$correlativo."'");
            return $query->result_array();
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    function get_items_x_id($id)
    {
        try {
            $query = $this->db->query("SELECT cantidad FROM tbl_carga_parte_ingreso WHERE item = '".$id."'");
            return $query->result_array();
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    function numero_chips_vinculacion_masiva()
    {
        try {
            $query = $this->db->query("SELECT count(codigo_rfid) cant_chips_leidos FROM tbl_vinculacion_masiva WHERE estado = '1' AND codigo_rfid != '' ");
            return $query->result_array();
        } catch (Exception $exc) {
            return FALSE;
        }
    }
}
