<?php

class Tbl_inventario_tiempo_real extends CI_Model
{

    private $tabla = "ktraceso_lectura_rfid";

    public function __construct()
    {
        parent::__construct();
    }

    public function get_activos_vinculados_presente()
    {
        try {
            $sql = "select tbl_vinculacion.codigo_rfid as cod_rfid,tbl_vinculacion.cod_inventario as cod_inve, tbl_inventario.descripcion as descripcion,tbl_inventario.imagen as imagen, tbl_vinculacion.status as status, tbl_vinculacion.fecha_vinculacion as fecha_vinculacion from tbl_vinculacion inner join tbl_inventario on tbl_vinculacion.cod_inventario=tbl_inventario.codigo where tbl_inventario.status = '1' order by tbl_vinculacion.fecha_vinculacion desc";

            $query = $this->db->query($sql);

            return $query->result_array();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
    public function get_tags_vinculados()
    {
        try {
            $sql = "select tbl_vinculacion.codigo_rfid as cod_rfid from tbl_vinculacion inner join tbl_inventario on tbl_vinculacion.cod_inventario=tbl_inventario.codigo where tbl_inventario.status = '1' order by tbl_vinculacion.fecha_vinculacion desc";

            $query = $this->db->query($sql);

            return $query->result_array();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
    function get_lista_activos_matriculados_ubigeo_simple()
    {
        try {

            $sql = "SELECT tbl_activos.id as id,tbl_activos.descripcion as descripcion,tbl_activos.cliente as cliente,tbl_activos.codigo_producto as codigo_producto,tbl_activos.valor as valor,tbl_vinculacion.codigo_rfid as codigo_rfid,tbl_activos.ubigeo as ubigeo,tbl_activos.ubicacion as ubicacion,tbl_activos.peso as peso,tbl_activos.ancho as ancho,tbl_activos.profundidad as profundidad,tbl_activos.lote as lote,tbl_activos.orden_ingreso as orden_ingreso,tbl_activos.estado as estado,tbl_activos.programacion as programacion,tbl_activos.fecha_ingreso as fecha_ingreso,tbl_activos.fecha_lectura as fecha_lectura FROM tbl_activos inner join tbl_vinculacion on tbl_vinculacion.codigo_producto=tbl_activos.codigo_producto where tbl_activos.estado = '1' order by fecha_ingreso desc";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    function get_lista_activos_matriculados()
    {
        try {

            $sql = "SELECT tbl_activos.id as id,tbl_activos.descripcion as descripcion,tbl_activos.cliente as cliente,tbl_activos.codigo_producto as codigo_producto,tbl_activos.valor as valor,tbl_vinculacion.codigo_rfid as codigo_rfid,tbl_activos.ubigeo as ubigeo,tbl_activos.ubicacion as ubicacion,tbl_activos.peso as peso,tbl_activos.ancho as ancho,tbl_activos.profundidad as profundidad,tbl_activos.lote as lote,tbl_activos.orden_ingreso as orden_ingreso,tbl_activos.estado as estado,tbl_activos.programacion as programacion,tbl_activos.fecha_ingreso as fecha_ingreso,tbl_activos.fecha_lectura as fecha_lectura FROM tbl_activos inner join tbl_vinculacion on tbl_vinculacion.codigo_producto=tbl_activos.codigo_producto where tbl_activos.estado = '1' order by fecha_lectura desc";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    function get_lista_activos_matriculados_ubigeo($ubigeo, $ubicacion)
    {
        try {

            $sql = "SELECT tbl_activos.id as id,tbl_activos.descripcion as descripcion,tbl_activos.cliente as cliente,tbl_activos.codigo_producto as codigo_producto,tbl_activos.unidad_medida as unidad_medida,tbl_activos.cantidad as cantidad,tbl_vinculacion.codigo_rfid as codigo_rfid,tbl_activos.valor as valor,tbl_activos.ubigeo as ubigeo,tbl_activos.ubicacion as ubicacion,tbl_activos.peso as peso,tbl_activos.ancho as ancho,tbl_activos.profundidad as profundidad,tbl_activos.lote as lote,tbl_activos.orden_ingreso as orden_ingreso,tbl_activos.estado as estado,tbl_activos.programacion as programacion,tbl_activos.fecha_ingreso as fecha_ingreso,tbl_activos.estado_lectura as estado_lectura,tbl_activos.fecha_lectura as fecha_lectura FROM tbl_activos inner join tbl_vinculacion on tbl_vinculacion.codigo_producto=tbl_activos.codigo_producto where tbl_activos.estado = '1' AND tbl_activos.ubigeo = '" . $ubigeo . "' AND  tbl_activos.ubicacion = '" . $ubicacion . "' order by fecha_lectura desc, fecha_ingreso desc";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    function get_lista_activos_matriculados_ubigeo_abc($ubigeo, $ubicacion)
    {
        try {

            $sql = "SELECT tbl_activos_abc_logistics.id as id,tbl_activos_abc_logistics.descripcion as descripcion,tbl_activos_abc_logistics.correlativo as correlativo,tbl_activos_abc_logistics.cliente as cliente,tbl_activos_abc_logistics.codigo as codigo_producto,tbl_activos_abc_logistics.unidad_medida as unidad_medida,tbl_activos_abc_logistics.cantidad as cantidad,tbl_vinculacion.codigo_rfid as codigo_rfid,tbl_activos_abc_logistics.valor as valor,tbl_activos_abc_logistics.ubigeo as ubigeo,tbl_activos_abc_logistics.ubicacion as ubicacion,tbl_activos_abc_logistics.nro_dam as nro_dam,tbl_activos_abc_logistics.jefe_almacen as jefe_almacen,tbl_activos_abc_logistics.nro_dua as nro_dua,tbl_activos_abc_logistics.guia_remision as guia_remision,tbl_activos_abc_logistics.nro_operacion as nro_operacion,tbl_activos_abc_logistics.item as item,tbl_activos_abc_logistics.familia_producto as familia_producto,tbl_activos_abc_logistics.estado as estado,tbl_activos_abc_logistics.unidad_medida as unidad_medida,tbl_activos_abc_logistics.cantidad as cantidad,tbl_activos_abc_logistics.lote as lote,tbl_activos_abc_logistics.ancho as ancho,tbl_activos_abc_logistics.profundidad as profundidad,tbl_activos_abc_logistics.peso as peso,tbl_activos_abc_logistics.orden_ingreso as orden_ingreso,tbl_activos_abc_logistics.programacion as programacion,tbl_activos_abc_logistics.jefe_almacen as jefe_almacen,tbl_activos_abc_logistics.fecha_ingreso as fecha_ingreso,tbl_activos_abc_logistics.fecha_lectura as fecha_lectura,tbl_activos_abc_logistics.estado_lectura as estado_lectura,tbl_activos_abc_logistics.fecha_lectura as fecha_lectura FROM tbl_activos_abc_logistics inner join tbl_vinculacion on tbl_vinculacion.id_activo=tbl_activos_abc_logistics.id where tbl_activos_abc_logistics.estado = '1' AND tbl_activos_abc_logistics.ubigeo = '" . $ubigeo . "' AND  tbl_activos_abc_logistics.ubicacion = '" . $ubicacion . "' order by fecha_lectura desc, fecha_ingreso desc";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    function get_lista_activos_matriculados_correlativo_abc($correlativo)
    {
        try {

            $sql = "SELECT tbl_activos_abc_logistics.id as id,tbl_activos_abc_logistics.descripcion as descripcion,tbl_activos_abc_logistics.correlativo as correlativo,tbl_activos_abc_logistics.cliente as cliente,tbl_activos_abc_logistics.codigo as codigo_producto,tbl_activos_abc_logistics.unidad_medida as unidad_medida,tbl_activos_abc_logistics.cantidad as cantidad,tbl_vinculacion.codigo_rfid as codigo_rfid,tbl_activos_abc_logistics.valor as valor,tbl_activos_abc_logistics.ubigeo as ubigeo,tbl_activos_abc_logistics.ubicacion as ubicacion,tbl_activos_abc_logistics.nro_dam as nro_dam,tbl_activos_abc_logistics.jefe_almacen as jefe_almacen,tbl_activos_abc_logistics.nro_dua as nro_dua,tbl_activos_abc_logistics.guia_remision as guia_remision,tbl_activos_abc_logistics.nro_operacion as nro_operacion,tbl_activos_abc_logistics.item as item,tbl_activos_abc_logistics.familia_producto as familia_producto,tbl_activos_abc_logistics.estado as estado,tbl_activos_abc_logistics.unidad_medida as unidad_medida,tbl_activos_abc_logistics.cantidad as cantidad,tbl_activos_abc_logistics.lote as lote,tbl_activos_abc_logistics.ancho as ancho,tbl_activos_abc_logistics.profundidad as profundidad,tbl_activos_abc_logistics.peso as peso,tbl_activos_abc_logistics.orden_ingreso as orden_ingreso,tbl_activos_abc_logistics.programacion as programacion,tbl_activos_abc_logistics.jefe_almacen as jefe_almacen,tbl_activos_abc_logistics.fecha_ingreso as fecha_ingreso,tbl_activos_abc_logistics.fecha_lectura as fecha_lectura,tbl_activos_abc_logistics.estado_lectura as estado_lectura,tbl_activos_abc_logistics.fecha_lectura as fecha_lectura FROM tbl_activos_abc_logistics inner join tbl_vinculacion on tbl_vinculacion.id_activo=tbl_activos_abc_logistics.id where tbl_activos_abc_logistics.estado = '1' AND tbl_activos_abc_logistics.correlativo = '" . $correlativo . "' order by fecha_lectura desc, fecha_ingreso desc";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    function get_lista_activos_abc_matriculados_ubigeo($ubigeo, $ubicacion)
    {
        try {

            $sql = "SELECT tbl_activos_abc_logistics.id as id,tbl_activos_abc_logistics.descripcion as descripcion,tbl_activos_abc_logistics.cliente as cliente,tbl_activos_abc_logistics.codigo as codigo_producto,tbl_activos_abc_logistics.unidad_medida as unidad_medida,tbl_activos_abc_logistics.cantidad as cantidad,tbl_vinculacion.codigo_rfid as codigo_rfid,tbl_activos_abc_logistics.nro_dam as nro_dam,tbl_activos_abc_logistics.ubigeo as ubigeo,tbl_activos_abc_logistics.ubicacion as ubicacion,tbl_activos_abc_logistics.guia_remision as guia_remision,tbl_activos_abc_logistics.nro_operacion as nro_operacion,tbl_activos_abc_logistics.item as item,tbl_activos_abc_logistics.familia_producto as familia_producto,tbl_activos_abc_logistics.orden_ingreso as orden_ingreso,tbl_activos_abc_logistics.estado as estado,tbl_activos_abc_logistics.programacion as programacion,tbl_activos_abc_logistics.fecha_ingreso as fecha_ingreso,tbl_activos_abc_logistics.estado_lectura as estado_lectura,tbl_activos_abc_logistics.fecha_lectura as fecha_lectura FROM tbl_activos_abc_logistics_abc_logistics inner join tbl_vinculacion on tbl_vinculacion.codigo_producto=tbl_activos_abc_logistics.codigo_producto where tbl_activos_abc_logistics.estado = '1' AND tbl_activos_abc_logistics.ubigeo = '" . $ubigeo . "' AND  tbl_activos_abc_logistics.ubicacion = '" . $ubicacion . "' order by fecha_lectura desc, fecha_ingreso desc";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    public function get_all_cod_rfid_vinculado()
    {
        try {
            $sql = "SELECT codigo_rfid FROM tbl_vinculacion ";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    public function limpiar_tbl_movimientos()
    {
        try {
            $sql = "TRUNCATE tbl_movimientos";
            $query = $this->db->query($sql);
        } catch (Exception $e) {
            return false;
        }
    }
    public function update_estado_inventario()
    {
        try {
            $query = $this->db->query("UPDATE tbl_movimientos SET estado_movimiento = '0'");

            return TRUE;
        } catch (Exception $exc) {
            return FALSE;
        }
    }
     public function actualizar_estado_inventario_realizado($id_inventario)
    {
        try {
            $query = $this->db->query("UPDATE tbl_inventario_tiempo_real SET status = '1' WHERE id = '".$id_inventario."'");
            return TRUE;
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    public function update_partes_ingreso($correlativo)
    {
        try {
            $query = $this->db->query("UPDATE tbl_partes_ingreso SET status = '1' WHERE correlativo = '".$correlativo."'");

            return TRUE;
        } catch (Exception $exc) {
            return FALSE;
        }
    }

    public function update_estado_lectura()
    {
        try {
            $query = $this->db->query("UPDATE tbl_activos SET estado_lectura = '0' WHERE estado = '1'");

            return TRUE;
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    public function update_estado_lectura_abc()
    {
        try {
            $query = $this->db->query("UPDATE tbl_activos_abc_logistics SET estado_lectura = '0' WHERE estado = '1'");

            return TRUE;
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    public function update_fecha_lectura()
    {
        try {
            $query = $this->db->query("UPDATE tbl_activos SET fecha_lectura = '' WHERE estado = '1'");
            return TRUE;
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    public function update_fecha_lectura_abc()
    {
        try {
            $query = $this->db->query("UPDATE tbl_activos_abc_logistics SET fecha_lectura = '' WHERE estado = '1'");
            return TRUE;
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    public function get_inventario_programado()
    {
        try {
            $sql = "SELECT id,usuario, ubigeo, ubicacion, fecha_inventario,fecha_programacion,status FROM tbl_inventario_tiempo_real order by id desc ";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    function add_programacion_inventario($arrData)
    {
        //$arrData = array_merge($arrData, array( 'UsuarioCreacion' => $this->_arr_Sesion['user'], 'FechaCreacion' => date("Y-m-d H:i:s") ));

        try {
            $this->db->insert('tbl_inventario_tiempo_real', $arrData);
            if ($this->db->affected_rows() > 0)
                return true;
            else
                return false;
        } catch (Exception $e) {
            return false;
        }
    }
    public function eliminar($cod_inventario)
    {
        try {
            $this->db->delete('tbl_inventario_tiempo_real', array('id' => $cod_inventario));
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    public function eliminar_inventario_realizado($cod_inventario)
    {
        try {
            $this->db->delete('tbl_inventarios_realizados', array('id_inventario' => $cod_inventario));
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    function cargar_inventario_realizado($id_inventario, $nro_dua, $guia_remision, $item, $codigo, $codigo_rfid, $correlativo, $ubigeo, $ubicacion, $cliente, $familia_producto, $descripcion, $cantidad, $unidad_medida, $jefe_almacen, $fecha_inventario, $fecha_ingreso, $fecha_lectura, $fecha_finalizacion)
    {
        try {
            $sql = "INSERT INTO tbl_inventarios_realizados (id_inventario,nro_dua,guia_remision,item,codigo,codigo_rfid,correlativo,ubigeo,ubicacion,cliente,familia_producto,descripcion,cantidad,unidad_medida,jefe_almacen,fecha_inventario,fecha_ingreso,fecha_lectura,fecha_finalizacion)  VALUES ('" . $id_inventario . "','" . $nro_dua . "','" . $guia_remision . "','" . $item . "','" . $codigo . "','" . $codigo_rfid . "','" . $correlativo . "','" . $ubigeo . "','" . $ubicacion . "','" . $cliente . "','" . $familia_producto . "','" . $descripcion . "','" . $cantidad . "','" . $unidad_medida . "','" . $jefe_almacen . "','" . $fecha_inventario . "','" . $fecha_ingreso . "','" . $fecha_lectura . "','" . $fecha_finalizacion . "')";
            $query = $this->db->query($sql);
            return TRUE;
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    function cargar_recibo_deposito_realizado($nro_dua, $guia_remision, $item, $codigo, $codigo_rfid, $correlativo, $ubigeo, $ubicacion, $cliente, $familia_producto, $descripcion, $cantidad, $unidad_medida, $jefe_almacen, $fecha_ingreso, $fecha_lectura, $fecha_finalizacion)
    {
        try {
            $sql = "INSERT INTO tbl_recibo_deposito_tr (nro_dua,guia_remision,item,codigo,codigo_rfid,correlativo,ubigeo,ubicacion,cliente,familia_producto,descripcion,cantidad,unidad_medida,jefe_almacen,fecha_ingreso,fecha_lectura,fecha_finalizacion)  VALUES ('" . $nro_dua . "','" . $guia_remision . "','" . $item . "','" . $codigo . "','" . $codigo_rfid . "','" . $correlativo . "','" . $ubigeo . "','" . $ubicacion . "','" . $cliente . "','" . $familia_producto . "','" . $descripcion . "','" . $cantidad . "','" . $unidad_medida . "','" . $jefe_almacen . "','" . $fecha_ingreso . "','" . $fecha_lectura . "','" . $fecha_finalizacion . "')";
            $query = $this->db->query($sql);
            return TRUE;
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    function cargar_detalles_inventario($id_inventario, $correlativo, $usuario, $jefe_almacen, $ubigeo, $ubicacion, $cliente, $fecha_ingreso, $fecha_programacion, $status, $fecha_finalizacion)
    {
        try {
            $sql = "INSERT INTO tbl_detalles_inventario (id_inventario,correlativo,usuario,jefe_almacen,ubigeo,ubicacion,cliente,fecha_ingreso,fecha_programacion,status,fecha_finalizacion)  VALUES ('" . $id_inventario . "','" . $correlativo . "','" . $usuario . "','" . $jefe_almacen . "','" . $ubigeo . "','" . $ubicacion . "','" . $cliente . "','" . $fecha_ingreso . "','" . $fecha_programacion . "','" . $status . "','" . $fecha_finalizacion . "')";
            $query = $this->db->query($sql);
            return TRUE;
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    function cargar_detalles_recibo( $correlativo, $usuario, $jefe_almacen, $ubigeo, $ubicacion, $cliente, $fecha_ingreso, $status, $fecha_finalizacion)
    {
        try {
            $sql = "INSERT INTO tbl_detalles_recibo_deposito (correlativo,usuario,jefe_almacen,ubigeo,ubicacion,cliente,fecha_ingreso,status,fecha_finalizacion)  VALUES ('" . $correlativo . "','" . $usuario . "','" . $jefe_almacen . "','" . $ubigeo . "','" . $ubicacion . "','" . $cliente . "','" . $fecha_ingreso . "','" . $status . "','" . $fecha_finalizacion . "')";
            $query = $this->db->query($sql);
            return TRUE;
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    
    public function id_inventario_tiempo_real($id_inventario)
    {
        try {
            $sql = "SELECT id,usuario,ubigeo,ubicacion,fecha_inventario,fecha_programacion FROM tbl_inventario_tiempo_real WHERE id = '" . $id_inventario . "'";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    public function get_correlativo($correlativo)
    {
        try {
            $sql = "SELECT correlativo FROM tbl_detalles_recibo_deposito WHERE correlativo = '" . $correlativo . "'";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    function get_tbl_detalles_inventario()
    {
        try {

            $sql = "SELECT DISTINCT tbl_detalles_inventario.id_inventario as id_inventario,tbl_detalles_inventario.correlativo as correlativo,tbl_detalles_inventario.usuario as usuario,tbl_detalles_inventario.jefe_almacen as jefe_almacen,tbl_detalles_inventario.cliente as cliente,tbl_detalles_inventario.ubigeo as ubigeo,tbl_detalles_inventario.ubicacion as ubicacion,tbl_detalles_inventario.fecha_programacion as fecha_programacion,tbl_detalles_inventario.status as status,tbl_detalles_inventario.fecha_finalizacion as fecha_finalizacion FROM tbl_detalles_inventario  order by fecha_finalizacion desc";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    function get_tbl_detalles_recibo()
    {
        try {

            $sql = "SELECT DISTINCT tbl_detalles_recibo_deposito.id_inventario as id_inventario,tbl_detalles_recibo_deposito.correlativo as correlativo,tbl_detalles_recibo_deposito.usuario as usuario,tbl_detalles_recibo_deposito.jefe_almacen as jefe_almacen,tbl_detalles_recibo_deposito.cliente as cliente,tbl_detalles_recibo_deposito.ubigeo as ubigeo,tbl_detalles_recibo_deposito.ubicacion as ubicacion,tbl_detalles_recibo_deposito.fecha_programacion as fecha_programacion,tbl_detalles_recibo_deposito.status as status,tbl_detalles_recibo_deposito.fecha_finalizacion as fecha_finalizacion FROM tbl_detalles_recibo_deposito  order by fecha_finalizacion desc";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    function get_tbl_detalles_inventario_x_id($id_inventario)
    {
        try {

            $sql = "SELECT DISTINCT id_inventario,correlativo,usuario,jefe_almacen,cliente,ubigeo,ubicacion, fecha_programacion,status,fecha_finalizacion FROM tbl_detalles_inventario WHERE id_inventario = '" . $id_inventario . "'";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    function get_tbl_detalles_recibo_x_correlativo($correlativo)
    {
        try {

            $sql = "SELECT DISTINCT id_inventario,correlativo,usuario,jefe_almacen,cliente,ubigeo,ubicacion,status,fecha_finalizacion FROM tbl_detalles_recibo_deposito WHERE correlativo = '" . $correlativo . "'";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    function get_lista_inventario_realizado($id_inventario)
    {
        try {

            $sql = "SELECT id, id_inventario, descripcion ,correlativo, cliente ,codigo , unidad_medida,cantidad,codigo_rfid,ubigeo,ubicacion,jefe_almacen,nro_dua,guia_remision, item ,familia_producto,unidad_medida,cantidad,jefe_almacen, fecha_ingreso, fecha_lectura FROM tbl_inventarios_realizados WHERE id_inventario = '" . $id_inventario . "' order by fecha_lectura desc, fecha_ingreso desc";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    function get_lista_recibo_realizado($correlativo)
    {
        try {

            $sql = "SELECT id, correlativo, descripcion , cliente ,codigo , unidad_medida,cantidad,codigo_rfid,ubigeo,ubicacion,jefe_almacen,nro_dua,guia_remision, item ,familia_producto,unidad_medida,cantidad,jefe_almacen, fecha_ingreso, fecha_lectura FROM tbl_recibo_deposito_tr WHERE correlativo = '" . $correlativo . "' order by fecha_lectura desc, fecha_ingreso desc";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    function get_encontrados_id_inventario($id_inventario)
    {
        try {
            $sql = "SELECT count(*) as encontrados FROM tbl_inventarios_realizados WHERE fecha_lectura!='' and  id_inventario = '" .$id_inventario. "'";
            $query = $this->db->query($sql);

            return $query->row();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
    function get_encontrados_correlativo_tr($correlativo)
    {
        try {
            $sql = "SELECT count(*) as encontrados FROM tbl_activos_abc_logistics WHERE fecha_lectura!='' and  correlativo = '" .$correlativo. "' and estado = '1'";
            $query = $this->db->query($sql);

            return $query->row();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
    function get_no_encontrados_correlativo_tr($correlativo)
    {
        try {
            $sql = "SELECT count(*) as no_encontrados FROM tbl_activos_abc_logistics WHERE fecha_lectura='' and  correlativo = '" .$correlativo. "' and estado = '1'";
            $query = $this->db->query($sql);

            return $query->row();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
    function get_encontrados_correlativo($correlativo)
    {
        try {
            $sql = "SELECT count(*) as encontrados FROM tbl_recibo_deposito_tr WHERE fecha_lectura!='' and  correlativo = '" .$correlativo. "'";
            $query = $this->db->query($sql);

            return $query->row();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
    function get_no_encontrados_id_inventario($id_inventario)
    {
        try {
            $sql = "SELECT count(*) as no_encontrados FROM tbl_inventarios_realizados WHERE fecha_lectura ='' and  id_inventario = '" .$id_inventario. "'";
            $query = $this->db->query($sql);

            return $query->row();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
    function get_no_encontrados_correlativo($correlativo)
    {
        try {
            $sql = "SELECT count(*) as no_encontrados FROM tbl_recibo_deposito_tr WHERE fecha_lectura ='' and  correlativo = '" .$correlativo. "'";
            $query = $this->db->query($sql);

            return $query->row();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
}
