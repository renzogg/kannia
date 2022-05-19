<?php

class Tbl_carga_excel extends CI_Model
{

    private $tabla = "tbl_activos_abc_logistics";

    public function __construct()
    {
        parent::__construct();
    }

    function get_lista_activos()
    {
        try {
            $sql = "SELECT id,nro_dam,guia_remision,nro_operacion,item,codigo,ubicacion,ubigeo,cliente,familia_producto,descripcion,cantidad,unidad_medida,estado FROM tbl_activos_abc_logistics WHERE estado = '0' ";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    function get_lista_activos_desde_excel()
    {
        try {
            $sql = "SELECT id,nro_dam,guia_remision,nro_operacion,item,codigo,ubicacion,ubigeo,cliente,familia_producto,descripcion,cantidad,unidad_medida,estado FROM tbl_carga_excel ";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    function get_parte_ingreso()
    {
        try {
            $sql = "SELECT id,nro_dua,correlativo,guia_remision,ubicacion,ubigeo,cliente,jefe_almacen,fecha_ingreso,fecha_parte,total_items,status FROM tbl_partes_ingreso ";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    function get_items_parte_ingreso()
    {
        try {
            $sql = "SELECT id,nro_dam,nro_dua,item,nro_operacion,correlativo,codigo,familia_producto,descripcion,cantidad,unidad_medida,valor,codigo,guia_remision,ubicacion,ubigeo,cliente,estado,estado_salida,programacion,estado_lectura,observaciones,jefe_almacen,fecha_ingreso,fecha_parte FROM tbl_carga_parte_ingreso ";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    function get_items_parte_ingreso_correlativo($correlativo)
    {
        try {
            $sql = "SELECT id,nro_dam,nro_dua,item,nro_operacion,correlativo,codigo,familia_producto,descripcion,cantidad,unidad_medida,valor,codigo,guia_remision,ubicacion,ubigeo,cliente,estado,estado_salida,programacion,estado_lectura,observaciones,jefe_almacen,fecha_ingreso,fecha_parte FROM tbl_items_parte_ingreso WHERE correlativo = '" . $correlativo . "' ";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    function get_lista_sujetos_desde_excel()
    {
        try {
            $sql = "SELECT id,nombres,apellidos,dni,cargo,ubigeo,estado_enrolado FROM tbl_sujetos ";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    function get_lista_activos_desde_excel_vinculados()
    {
        try {
            $sql = "SELECT tbl_activos_abc_logistics.id as id,tbl_activos_abc_logistics.nro_dam as nro_dam,tbl_activos_abc_logistics.nro_dua as nro_dua,tbl_activos_abc_logistics.correlativo as correlativo,tbl_activos_abc_logistics.guia_remision as guia_remision,tbl_activos_abc_logistics.nro_operacion as nro_operacion,tbl_activos_abc_logistics.item as item,tbl_activos_abc_logistics.codigo as codigo,tbl_activos_abc_logistics.ubicacion as ubicacion,tbl_activos_abc_logistics.ubigeo as ubigeo,tbl_activos_abc_logistics.cliente as cliente,tbl_activos_abc_logistics.familia_producto as familia_producto,tbl_activos_abc_logistics.descripcion as descripcion,tbl_activos_abc_logistics.cantidad as cantidad,tbl_activos_abc_logistics.unidad_medida as unidad_medida,tbl_activos_abc_logistics.estado as estado, tbl_vinculacion.codigo_rfid as codigo_rfid,tbl_vinculacion.fecha_vinculacion as fecha_vinculacion FROM tbl_activos_abc_logistics INNER JOIN tbl_vinculacion ON tbl_activos_abc_logistics.id = tbl_vinculacion.id_activo WHERE tbl_activos_abc_logistics.estado = '1' ORDER BY tbl_vinculacion.fecha_vinculacion DESC";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    public function update_status_tbl_excel($id_activo, $status)
    {
        try {
            $query = $this->db->query("UPDATE tbl_carga_excel SET estado = '" . $status . "' WHERE id = '" . $id_activo . "'");
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    function get_lista_sujetos_desde_excel_enrolados()
    {
        try {
            $sql = "SELECT tbl_sujetos.id as id,tbl_sujetos.nombres as nombres,tbl_sujetos.apellidos as apellidos,tbl_sujetos.cargo as cargo,tbl_sujetos.dni as dni,tbl_sujetos.ubigeo as ubigeo,tbl_sujetos.estado_enrolado as estado_enrolado, tbl_enrolados.codigo_rfid as codigo_rfid,tbl_sujetos.imagen as imagen,tbl_enrolados.fecha_enrolacion as fecha_enrolacion FROM tbl_sujetos INNER JOIN tbl_enrolados ON tbl_sujetos.dni = tbl_enrolados.dni WHERE tbl_sujetos.estado_enrolado = '1' ORDER BY tbl_enrolados.fecha_enrolacion DESC";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }

    function cargar_excel($nro_dam, $guia_remision, $nro_operacion, $item, $codigo, $ubigeo,$ubicacion,$cliente,$familia_producto, $descripcion, $cantidad, $unidad_medida,$estado,$estado_salida,$programacion,$fecha_ingreso)
    {
        try {
            $sql = "INSERT INTO tbl_activos_abc_logistics (nro_dam,guia_remision,nro_operacion,item,codigo,ubigeo,ubicacion,cliente,familia_producto,descripcion,cantidad,unidad_medida,estado,estado_salida,programacion,fecha_ingreso)  VALUES ('" . $nro_dam . "','" . $guia_remision . "','" . $nro_operacion . "','" . $item . "','" . $codigo . "','" . $ubigeo . "','" . $ubicacion . "','" . $cliente . "','" . $familia_producto . "','" . $descripcion . "','" . $cantidad . "','" . $unidad_medida . "','" . $estado . "','" . $estado_salida . "','" . $programacion . "','" . $fecha_ingreso . "')";
            $query = $this->db->query($sql);
            return TRUE;
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    function cargar_excel_tbl_excel($nro_dam, $guia_remision, $nro_operacion, $item, $codigo, $ubigeo,$ubicacion,$cliente,$familia_producto, $descripcion, $cantidad, $unidad_medida,$estado,$estado_salida,$programacion,$fecha_ingreso)
    {
        try {
            $sql = "INSERT INTO tbl_carga_excel (nro_dam,guia_remision,nro_operacion,item,codigo,ubigeo,ubicacion,cliente,familia_producto,descripcion,cantidad,unidad_medida,estado,estado_salida,programacion,fecha_ingreso)  VALUES ('" . $nro_dam . "','" . $guia_remision . "','" . $nro_operacion . "','" . $item . "','" . $codigo . "','" . $ubigeo . "','" . $ubicacion . "','" . $cliente . "','" . $familia_producto . "','" . $descripcion . "','" . $cantidad . "','" . $unidad_medida . "','" . $estado . "','" . $estado_salida . "','" . $programacion . "','" . $fecha_ingreso . "')";
            $query = $this->db->query($sql);
            return TRUE;
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    function cargar_parte_ingreso_tbl_excel($nro_dua,$guia_remision, $item, $codigo,$correlativo, $ubigeo,$ubicacion,$cliente,$familia_producto, $descripcion, $cantidad, $unidad_medida,$estado,$estado_salida,$programacion,$fecha_ingreso,$observaciones,$jefe_almacen,$fecha_parte)
    {
        try {
            $sql = "INSERT INTO tbl_carga_parte_ingreso (nro_dua,guia_remision,item,codigo,correlativo,ubigeo,ubicacion,cliente,familia_producto,descripcion,cantidad,unidad_medida,estado,estado_salida,programacion,fecha_ingreso,observaciones,jefe_almacen,fecha_parte)  VALUES ('" . $nro_dua . "','" . $guia_remision . "','" . $item . "','" . $codigo . "','" . $correlativo . "','" . $ubigeo . "','" . $ubicacion . "','" . $cliente . "','" . $familia_producto . "','" . $descripcion . "','" . $cantidad . "','" . $unidad_medida . "','" . $estado . "','" . $estado_salida . "','" . $programacion . "','" . $fecha_ingreso . "','" . $observaciones . "','" . $jefe_almacen . "','" . $fecha_parte . "')";
            $query = $this->db->query($sql);
            return TRUE;
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    function cargar_items_parte_ingreso_tbl_excel($nro_dua,$guia_remision, $item, $codigo,$correlativo, $ubigeo,$ubicacion,$cliente,$familia_producto, $descripcion, $cantidad, $unidad_medida,$estado,$estado_salida,$programacion,$fecha_ingreso,$observaciones,$jefe_almacen,$fecha_parte)
    {
        try {
            $sql = "INSERT INTO tbl_items_parte_ingreso (nro_dua,guia_remision,item,codigo,correlativo,ubigeo,ubicacion,cliente,familia_producto,descripcion,cantidad,unidad_medida,estado,estado_salida,programacion,fecha_ingreso,observaciones,jefe_almacen,fecha_parte)  VALUES ('" . $nro_dua . "','" . $guia_remision . "','" . $item . "','" . $codigo . "','" . $correlativo . "','" . $ubigeo . "','" . $ubicacion . "','" . $cliente . "','" . $familia_producto . "','" . $descripcion . "','" . $cantidad . "','" . $unidad_medida . "','" . $estado . "','" . $estado_salida . "','" . $programacion . "','" . $fecha_ingreso . "','" . $observaciones . "','" . $jefe_almacen . "','" . $fecha_parte . "')";
            $query = $this->db->query($sql);
            return TRUE;
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    function get_ultimo_parte_ingreso()
    {
        try {
            $sql = "SELECT correlativo FROM tbl_partes_ingreso ORDER BY fecha_ingreso desc limit 1";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    function buscar_parte_ingreso($correlativo)
    {
        try {
            $sql = "SELECT correlativo FROM tbl_partes_ingreso WHERE correlativo ='".$correlativo."'";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    function buscar_parte_ingreso_tbl_items_parte_ingreso($correlativo)
    {
        try {
            $sql = "SELECT correlativo FROM tbl_items_parte_ingreso WHERE correlativo ='".$correlativo."'";
            $query = $this->db->query($sql);
            return $query->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    function cargar_parte_ingreso($nro_dua,$correlativo,$guia_remision,$ubigeo,$ubicacion,$cliente,$fecha_ingreso,$jefe_almacen,$fecha_parte,$total_items)
    {
        try {
            $sql = "INSERT INTO tbl_partes_ingreso (nro_dua,correlativo,guia_remision,ubigeo,ubicacion,cliente,fecha_ingreso,jefe_almacen,fecha_parte,total_items)  VALUES ('" . $nro_dua . "','" . $correlativo . "','" . $guia_remision . "','" . $ubigeo . "','" . $ubicacion . "','" . $cliente . "','" . $fecha_ingreso . "','" . $jefe_almacen . "','" . $fecha_parte . "','" . $total_items . "')";
            $query = $this->db->query($sql);
            return TRUE;
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    function cargar_excel_sujetos($nombres, $apellidos, $dni, $cargo, $ubigeo,$imagen,$estado)
    {
        try {
            $sql = "INSERT INTO tbl_sujetos (nombres,apellidos,dni,cargo,ubigeo,imagen,estado_enrolado)  VALUES ('" . $nombres . "','" . $apellidos . "','" . $dni . "','" . $cargo . "','" . $ubigeo . "','" . $imagen . "','" . $estado . "')";
            $query = $this->db->query($sql);
            return TRUE;
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    function limpiar_tabla_excel(){
        try {
            $sql = "TRUNCATE TABLE tbl_carga_excel";
            $query = $this->db->query($sql);
            return TRUE;
        } catch (Exception $exc) {
            return FALSE;
        }
    }
    function limpiar_tabla_items_parte(){
        try {
            $sql = "TRUNCATE TABLE tbl_carga_parte_ingreso";
            $query = $this->db->query($sql);
            return TRUE;
        } catch (Exception $exc) {
            return FALSE;
        }
    }
}

