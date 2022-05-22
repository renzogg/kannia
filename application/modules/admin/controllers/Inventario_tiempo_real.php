<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Inventario_tiempo_real extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('tbl_usuario', 'obj_usuario');
        $this->load->model('tbl_alerta', 'obj_lectura');
        $this->load->model('tbl_inventario', 'obj_inventario');
        $this->load->model('tbl_vinculacion', 'obj_vinculacion');
        if ($this->session->userdata('logged') != 'true') {
            redirect('login');
        }
    }
    public function index()
    {
        $this->load->model('tbl_inventario');
        $this->load->model('tbl_inventario_tiempo_real');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $this->tbl_inventario_tiempo_real->update_estado_inventario();
        $this->tbl_inventario_tiempo_real->update_fecha_lectura();
        $num_vinculados = $this->tbl_inventario->get_all_vinculados();
        $this->tmp_admin->set('num_vinculados', $num_vinculados[0]["cant_vinculados"]);
        $this->load->model('tbl_inventario_tiempo_Real');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $this->load->tmp_admin->render('inventario_tiempo_real_view');
    }
    public function listar_ubicacion()
    {
        $this->load->model('tbl_vinculacion');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $ubigeo = $_POST['ubigeo'];
        $actividad = "INVENTARIADO";
        $ubicacion = $this->obj_vinculacion->get_ubicacion_ubigeo($ubigeo, $actividad);
        //print_r($ubicacion);
        $ubicacion = $ubicacion[0]["ubicacion"];
        $arrayResult = $ubicacion;
        echo json_encode($arrayResult);
    }
    public function listar_ubicacion_preinventario()
    {
        $this->load->model('tbl_vinculacion');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $ubigeo = $_POST['ubigeo'];
        $actividad = "PRE - INVENTARIADO";
        $ubicacion = $this->obj_vinculacion->get_ubicacion_ubigeo($ubigeo, $actividad);
        //print_r($ubicacion);
        $ubicacion = $ubicacion[0]["ubicacion"];
        $arrayResult = $ubicacion;
        echo json_encode($arrayResult);
    }
    public function agregar_actividad()
    {
        $this->load->model('tbl_vinculacion');
        $data = array(
            'ubigeo' => $this->input->post('ubigeo'),
            'ubicacion' => $this->input->post('ubicacion'),
            'actividad' => "INVENTARIADO"
        );
        try {
            $result =  $this->tbl_vinculacion->add_actividad_actual($data);
            if ($result)
                $rpta = "!!!!CONFIRMACIÓN EXITOSA!!!";
            else
                $rpta = "Error al guardar la información";
        } catch (Exception $e) {
            $rpta = 'Error de Transacción';
        }
        echo json_encode(array("respuesta" => $rpta));
    }
    public function agregar_actividad_preinventario()
    {
        $this->load->model('tbl_vinculacion');
        $data = array(
            'ubigeo' => $this->input->post('ubigeo'),
            'ubicacion' => $this->input->post('ubicacion'),
            'actividad' => "PRE - INVENTARIADO"
        );
        try {
            $result =  $this->tbl_vinculacion->add_actividad_actual($data);
            if ($result)
                $rpta = "!!!!CONFIRMACIÓN EXITOSA!!!";
            else
                $rpta = "Error al guardar la información";
        } catch (Exception $e) {
            $rpta = 'Error de Transacción';
        }
        echo json_encode(array("respuesta" => $rpta));
    }

    public function get_activos_matriculados_ubigeo()
    {
        //$this->form_validation->set_rules('ubigeo', 'ubigeo', 'trim|required'); // importante para que funcione el codigo
        //$this->form_validation->set_message('required', 'Este campo es requerido');
        $this->load->model('tbl_inventario');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $atributos = $this->obj_vinculo->get_actividad_actual("INVENTARIADO");
        $ubigeo = $atributos[0]["ubigeo"];
        $ubicacion = $atributos[0]["ubicacion"];
        //$ubigeo = $this->input->post('ubigeo');
        //$ubigeo = "LOS OLIVOS";
        /* print_r($ubigeo);
        print_r($ubicacion); */
        $tabla = "";
        $i = 0;
        $lista = $this->tbl_inventario->get_lista_activos_matriculados_ubigeo($ubigeo, $ubicacion);
        //print_r($lista);
        foreach ($lista as $row) {
            $i++;
            $tabla .= '{"id":"' . $i . '","cod_producto":"' . $row['codigo_producto'] . '","cod_rfid":"' . $row['codigo_rfid'] . '","descripcion":"' . $row['descripcion'] . '","cliente":"' . $row['cliente'] . '","ubigeo":"' . $row['ubigeo'] . '","ubicacion":"' . $row['ubicacion'] . '","lote":"' . $row['lote'] . '","ancho":"' . $row['ancho'] . '","profundidad":"' . $row['profundidad'] . '","peso":"' . $row['peso'] . '","estado":"' . $row['estado'] . '","orden_ingreso":"' . $row['orden_ingreso'] . '","programacion":"' . $row['programacion'] . '","date":"' . $row['fecha_ingreso'] . '","estado_lectura":"' . $row['estado_lectura'] . '"},';
        }
        $tabla = substr($tabla, 0, strlen($tabla) - 1);
        echo '{"data":[' . $tabla . ']}';
        /* header("Content-type: application/json");
            echo json_encode('{"data":[' . $tabla . ']}'); */
    }
    public function get_preinventario_tiempo_real()
    {
        $this->load->model('tbl_alerta');
        $this->load->model('tbl_inventario_tiempo_real');
        $this->load->model('tbl_inventario');
        $this->load->model('tbl_vinculacion');
        $this->load->model('tbl_dispositivo_rfid');
        //$num_vinculados = $this->tbl_inventario->get_all_vinculados();
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $actividad = "PRE - INVENTARIADO";
        $actividad = $this->tbl_vinculacion->get_actividad($actividad);
        if (!empty($actividad)) {
            $actividad = "PRE - INVENTARIADO";
            $atributos = $this->obj_vinculacion->get_actividad_actual("PRE - INVENTARIADO");
            $ubigeo = $atributos[0]["ubigeo"];
            $ubicacion = $atributos[0]["ubicacion"];
            $num_vinculados = $this->tbl_inventario->get_all_vinculados_ubigeo_ubicacion_abc($ubigeo, $ubicacion);
            //print_r($num_vinculados);
            $tabla = "";
            $i = 0;
            $encontrados = "0";
            $no_encontrados = "0";
            /* $c_encontrados = $this->tbl_alerta->get_encontrados()->encontrados;
            $c_no_encontrados = $this->tbl_alerta->get_no_encontrados()->no_encontrados; */
            $c_encontrados = $this->tbl_alerta->get_encontrados_ubigeo_abc($ubigeo, $ubicacion)->encontrados;
            $c_no_encontrados = $this->tbl_alerta->get_no_encontrados_ubigeo_abc($ubigeo, $ubicacion)->no_encontrados;
            //$this->tmp_admin->set('encontrados', $encontrados);
            $lista = $this->tbl_inventario_tiempo_real->get_lista_activos_matriculados_ubigeo_abc($ubigeo, $ubicacion);
            $mac_asignada = $this->tbl_vinculacion->get_dispositivo_asignado($ubigeo, $ubicacion, $actividad);
            $mac_asignada = $mac_asignada[0]["mac"];
            //print_r($mac_asignada);
            $ultimo_mac = $this->tbl_dispositivo_rfid->get_list_ultimo_mac();
            $ultimo_mac = $ultimo_mac[0]["mac"];
            $ultimo_mac = substr($ultimo_mac, 7, 17);
            //print_r($ultimo_mac);
            // DISCRIMINACION DE DISPOSITIVO RFID
            if ($ultimo_mac == $mac_asignada) {
                //print_r($lista);
                $registros = array();
                foreach ($lista as $row) {
                    $fecha_lectura = $this->tbl_alerta->get_fecha_chip($row['codigo_rfid']);
                    //print_r($fecha_lectura);
                    if (empty($fecha_lectura)) {
                        $this->tbl_inventario->insertar_fecha_lectura_abc($row['id'], "");
                        $no_encontrados++;
                        $i++;
                        $registro = array();
                        $registro["id"] = $i;
                        $registro["cod_producto"] = $row["codigo_producto"];
                        $registro["cod_rfid"] = $row["codigo_rfid"];
                        $registro["descripcion"] = $row["descripcion"];
                        $registro["cliente"] = $row["cliente"];
                        $registro["valor"] = $row["valor"];
                        $registro["ubigeo"] = $row["ubigeo"];
                        $registro["ubicacion"] = $row["ubicacion"];
                        $registro["lote"] = $row["lote"];
                        $registro["ancho"] = $row["ancho"];
                        $registro["profundidad"] = $row["profundidad"];
                        $registro["peso"] = $row["peso"];
                        $registro["orden_ingreso"] = $row["orden_ingreso"];
                        $registro["programacion"] = $row["programacion"];
                        $registro["date"] = $row["fecha_ingreso"];
                        $registro["fecha_lectura"] = $row["fecha_lectura"];
                        $registro["c_no_encontrados"] = $c_no_encontrados;
                        $registro["total_activos"] = $num_vinculados[0]["cant_vinculados"];
                        $registros[] = $registro;
                        //$tabla .= '{"id":"' . $i . '","cod_producto":"' . $row['codigo_producto'] . '","cod_rfid":"' . $row['codigo_rfid'] . '","descripcion":"' . $row['descripcion'] . '","valor":"' . $row['valor'] . '","cliente":"' . $row['cliente'] . '","ubigeo":"' . $row['ubigeo'] . '","ubicacion":"' . $row['ubicacion'] . '","lote":"' . $row['lote'] . '","ancho":"' . $row['ancho'] . '","profundidad":"' . $row['profundidad'] . '","peso":"' . $row['peso'] . '","orden_ingreso":"' . $row['orden_ingreso'] . '","programacion":"' . $row['programacion'] . '","date":"' . $row['fecha_ingreso'] . '","fecha_lectura":"' . $row['fecha_lectura'] . '","c_no_encontrados":"' . $c_no_encontrados . '","total_activos":"' . $num_vinculados[0]["cant_vinculados"] . '"},';
                    } else {
                        $this->tbl_inventario->insertar_fecha_lectura_abc($row['id'], $fecha_lectura[0]["fecha_lectura"]);
                        $encontrados++;
                        $i++;
                        $registro = array();
                        $registro["id"] = $i;
                        $registro["cod_producto"] = $row["codigo_producto"];
                        $registro["cod_rfid"] = $row["codigo_rfid"];
                        $registro["descripcion"] = $row["descripcion"];
                        $registro["cliente"] = $row["cliente"];
                        $registro["valor"] = $row["valor"];
                        $registro["ubigeo"] = $row["ubigeo"];
                        $registro["ubicacion"] = $row["ubicacion"];
                        $registro["lote"] = $row["lote"];
                        $registro["ancho"] = $row["ancho"];
                        $registro["profundidad"] = $row["profundidad"];
                        $registro["peso"] = $row["peso"];
                        $registro["orden_ingreso"] = $row["orden_ingreso"];
                        $registro["programacion"] = $row["programacion"];
                        $registro["date"] = $row["fecha_ingreso"];
                        $registro["fecha_lectura"] = $row["fecha_lectura"];
                        $registro["c_no_encontrados"] = $c_no_encontrados;
                        $registro["c_encontrados"] = $c_encontrados;
                        $registro["total_activos"] = $num_vinculados[0]["cant_vinculados"];
                        $registros[] = $registro;
                        //$tabla .= '{"id":"' . $i . '","cod_producto":"' . $row['codigo_producto'] . '","cod_rfid":"' . $row['codigo_rfid'] . '","descripcion":"' . $row['descripcion'] . '","valor":"' . $row['valor'] . '","cliente":"' . $row['cliente'] . '","ubigeo":"' . $row['ubigeo'] . '","ubicacion":"' . $row['ubicacion'] . '","lote":"' . $row['lote'] . '","ancho":"' . $row['ancho'] . '","profundidad":"' . $row['profundidad'] . '","peso":"' . $row['peso'] . '","orden_ingreso":"' . $row['orden_ingreso'] . '","programacion":"' . $row['programacion'] . '","date":"' . $row['fecha_ingreso'] . '","fecha_lectura":"' . $row['fecha_lectura'] . '","c_no_encontrados":"' . $c_no_encontrados . '","c_encontrados":"' . $c_encontrados . '","total_activos":"' . $num_vinculados[0]["cant_vinculados"] . '"},';
                    }
                }
                echo '{"data": ' . json_encode($registros) . '}';
            } else {
                $this->load->model('tbl_inventario_tiempo_real');
                $this->load->tmp_admin->setLayout('templates/admin_tmp');
                $num_vinculados = $this->tbl_inventario->get_all_vinculados_ubigeo_ubicacion_abc($ubigeo, $ubicacion);
                $fecha_lectura = "";
                $registros = array();
                $tabla = "";
                $i = 0;
                $lista = $this->tbl_inventario_tiempo_real->get_lista_activos_matriculados_ubigeo_abc($ubigeo, $ubicacion);
                foreach ($lista as $row) {
                    $i++;
                    $registro = array();
                    $registro["id"] = $i;
                    $registro["cod_producto"] = $row["codigo_producto"];
                    $registro["cod_rfid"] = $row["codigo_rfid"];
                    $registro["descripcion"] = $row["descripcion"];
                    $registro["cliente"] = $row["cliente"];
                    $registro["valor"] = $row["valor"];
                    $registro["ubigeo"] = $row["ubigeo"];
                    $registro["ubicacion"] = $row["ubicacion"];
                    $registro["lote"] = $row["lote"];
                    $registro["ancho"] = $row["ancho"];
                    $registro["profundidad"] = $row["profundidad"];
                    $registro["peso"] = $row["peso"];
                    $registro["orden_ingreso"] = $row["orden_ingreso"];
                    $registro["programacion"] = $row["programacion"];
                    $registro["date"] = $row["fecha_ingreso"];
                    $registro["fecha_lectura"] = $row["fecha_lectura"];
                    $registro["c_no_encontrados"] = $c_no_encontrados;
                    $registro["total_activos"] = $num_vinculados[0]["cant_vinculados"];
                    $registros[] = $registro;
                    //$tabla .= '{"id":"' . $i . '","cod_producto":"' . $row['codigo_producto'] . '","cod_rfid":"' . $row['codigo_rfid'] . '","descripcion":"' . $row['descripcion'] . '","valor":"' . $row['valor'] . '","cliente":"' . $row['cliente'] . '","ubigeo":"' . $row['ubigeo'] . '","ubicacion":"' . $row['ubicacion'] . '","lote":"' . $row['lote'] . '","ancho":"' . $row['ancho'] . '","profundidad":"' . $row['profundidad'] . '","peso":"' . $row['peso'] . '","orden_ingreso":"' . $row['orden_ingreso'] . '","programacion":"' . $row['programacion'] . '","date":"' . $row['fecha_ingreso'] . '","fecha_lectura":"' . $fecha_lectura . '","c_no_encontrados":"' . $c_no_encontrados . '","total_activos":"' . $num_vinculados[0]["cant_vinculados"] . '"},';
                }
                //$tabla = substr($tabla, 0, strlen($tabla) - 1);
                //echo '{"data":[' . $tabla . ']}';
                echo '{"data": ' . json_encode($registros) . '}';
            }
        } else {
            //echo "CHRIS - NO ASIGNASTE DISPOSITIVO";
            $this->load->model('tbl_inventario_tiempo_real');
            $this->load->tmp_admin->setLayout('templates/admin_tmp');
            $num_vinculados = $this->tbl_inventario->get_all_vinculados();
            $c_no_encontrados = $num_vinculados[0]["cant_vinculados"];
            $registros = array();
            $tabla = "";
            $i = 0;
            $lista = $this->tbl_inventario_tiempo_real->get_lista_activos_matriculados_ubigeo_simple();
            foreach ($lista as $row) {
                $fecha_lectura = "";
                $i++;
                $registro = array();
                $registro["id"] = $i;
                $registro["cod_producto"] = $row["codigo_producto"];
                $registro["cod_rfid"] = $row["codigo_rfid"];
                $registro["descripcion"] = $row["descripcion"];
                $registro["cliente"] = $row["cliente"];
                $registro["valor"] = $row["valor"];
                $registro["ubigeo"] = $row["ubigeo"];
                $registro["ubicacion"] = $row["ubicacion"];
                $registro["lote"] = $row["lote"];
                $registro["ancho"] = $row["ancho"];
                $registro["profundidad"] = $row["profundidad"];
                $registro["peso"] = $row["peso"];
                $registro["orden_ingreso"] = $row["orden_ingreso"];
                $registro["programacion"] = $row["programacion"];
                $registro["date"] = $row["fecha_ingreso"];
                $registro["fecha_lectura"] = $row["fecha_lectura"];
                $registro["c_no_encontrados"] = $c_no_encontrados;
                $registro["total_activos"] = $num_vinculados[0]["cant_vinculados"];
                $registros[] = $registro;
                //$tabla .= '{"id":"' . $i . '","cod_producto":"' . $row['codigo_producto'] . '","cod_rfid":"' . $row['codigo_rfid'] . '","descripcion":"' . $row['descripcion'] . '","valor":"' . $row['valor'] . '","cliente":"' . $row['cliente'] . '","ubigeo":"' . $row['ubigeo'] . '","ubicacion":"' . $row['ubicacion'] . '","lote":"' . $row['lote'] . '","ancho":"' . $row['ancho'] . '","profundidad":"' . $row['profundidad'] . '","peso":"' . $row['peso'] . '","c_no_encontrados":"' . $c_no_encontrados . '","orden_ingreso":"' . $row['orden_ingreso'] . '","programacion":"' . $row['programacion'] . '","date":"' . $row['fecha_ingreso'] . '","fecha_lectura":"' . $fecha_lectura . '","total_activos":"' . $num_vinculados[0]["cant_vinculados"] . '"},';
            }
            //$tabla = substr($tabla, 0, strlen($tabla) - 1);
            //echo '{"data":[' . $tabla . ']}';
            echo '{"data": ' . json_encode($registros) . '}';
        }
    }
    public function get_preinventario_tiempo_real_abc()
    {
        $this->load->model('tbl_alerta');
        $this->load->model('tbl_inventario_tiempo_real');
        $this->load->model('tbl_inventario');
        $this->load->model('tbl_vinculacion');
        $this->load->model('tbl_dispositivo_rfid');
        //$num_vinculados = $this->tbl_inventario->get_all_vinculados();
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $actividad = "PRE - INVENTARIADO";
        $actividad = $this->tbl_vinculacion->get_actividad($actividad);
        if (!empty($actividad)) {
            $actividad = "PRE - INVENTARIADO";
            $atributos = $this->obj_vinculacion->get_actividad_actual("PRE - INVENTARIADO");
            $ubigeo = $atributos[0]["ubigeo"];
            $ubicacion = $atributos[0]["ubicacion"];
            $num_vinculados = $this->tbl_inventario->get_all_vinculados_ubigeo_ubicacion_abc($ubigeo, $ubicacion);
            //print_r($num_vinculados);
            $tabla = "";
            $i = 0;
            $encontrados = "0";
            $no_encontrados = "0";
            /* $c_encontrados = $this->tbl_alerta->get_encontrados()->encontrados;
            $c_no_encontrados = $this->tbl_alerta->get_no_encontrados()->no_encontrados; */
            $c_encontrados = $this->tbl_alerta->get_encontrados_ubigeo_abc($ubigeo, $ubicacion)->encontrados;
            $c_no_encontrados = $this->tbl_alerta->get_no_encontrados_ubigeo_abc($ubigeo, $ubicacion)->no_encontrados;
            //$this->tmp_admin->set('encontrados', $encontrados);
            $lista = $this->tbl_inventario_tiempo_real->get_lista_activos_matriculados_ubigeo_abc($ubigeo, $ubicacion);
            $mac_asignada = $this->tbl_vinculacion->get_dispositivo_asignado($ubigeo, $ubicacion, $actividad);
            $mac_asignada = $mac_asignada[0]["mac"];
            //print_r($mac_asignada);
            $ultimo_mac = $this->tbl_dispositivo_rfid->get_list_ultimo_mac();
            $ultimo_mac = $ultimo_mac[0]["mac"];
            $ultimo_mac = substr($ultimo_mac, 7, 17);
            //print_r($ultimo_mac);
            // DISCRIMINACION DE DISPOSITIVO RFID
            if ($ultimo_mac == $mac_asignada) {
                //print_r($lista);
                $registros = array();
                foreach ($lista as $row) {
                    $fecha_lectura = $this->tbl_alerta->get_fecha_chip($row['codigo_rfid']);
                    //print_r($fecha_lectura);
                    if (empty($fecha_lectura)) {
                        $this->tbl_inventario->insertar_fecha_lectura_abc($row['codigo'], "");
                        $no_encontrados++;
                        $i++;
                        $registro = array();
                        $registro["id"] = $i;
                        $registro["cod_producto"] = $row["codigo"];
                        $registro["cod_rfid"] = $row["codigo_rfid"];
                        $registro["descripcion"] = $row["descripcion"];
                        $registro["cliente"] = $row["cliente"];
                        $registro["valor"] = $row["valor"];
                        $registro["ubigeo"] = $row["ubigeo"];
                        $registro["ubicacion"] = $row["ubicacion"];
                        $registro["nro_dam"] = $row["nro_dam"];
                        $registro["guia_remision"] = $row["guia_remision"];
                        $registro["nro_operacion"] = $row["nro_operacion"];
                        $registro["item"] = $row["item"];
                        $registro["familia_producto"] = $row["familia_producto"];
                        $registro["programacion"] = $row["programacion"];
                        $registro["date"] = $row["fecha_ingreso"];
                        $registro["fecha_lectura"] = $row["fecha_lectura"];
                        $registro["c_no_encontrados"] = $c_no_encontrados;
                        $registro["total_activos"] = $num_vinculados[0]["cant_vinculados"];
                        $registros[] = $registro;
                        //$tabla .= '{"id":"' . $i . '","cod_producto":"' . $row['codigo'] . '","cod_rfid":"' . $row['codigo_rfid'] . '","descripcion":"' . $row['descripcion'] . '","valor":"' . $row['valor'] . '","cliente":"' . $row['cliente'] . '","ubigeo":"' . $row['ubigeo'] . '","ubicacion":"' . $row['ubicacion'] . '","lote":"' . $row['lote'] . '","ancho":"' . $row['ancho'] . '","profundidad":"' . $row['profundidad'] . '","peso":"' . $row['peso'] . '","orden_ingreso":"' . $row['orden_ingreso'] . '","programacion":"' . $row['programacion'] . '","date":"' . $row['fecha_ingreso'] . '","fecha_lectura":"' . $row['fecha_lectura'] . '","c_no_encontrados":"' . $c_no_encontrados . '","total_activos":"' . $num_vinculados[0]["cant_vinculados"] . '"},';
                    } else {
                        $this->tbl_inventario->insertar_fecha_lectura_abc($row['codigo'], $fecha_lectura[0]["fecha_lectura"]);
                        $encontrados++;
                        $i++;
                        $registro = array();
                        $registro["id"] = $i;
                        $registro["cod_producto"] = $row["codigo"];
                        $registro["cod_rfid"] = $row["codigo_rfid"];
                        $registro["descripcion"] = $row["descripcion"];
                        $registro["cliente"] = $row["cliente"];
                        $registro["valor"] = $row["valor"];
                        $registro["ubigeo"] = $row["ubigeo"];
                        $registro["ubicacion"] = $row["ubicacion"];
                        $registro["nro_dam"] = $row["nro_dam"];
                        $registro["guia_remision"] = $row["guia_remision"];
                        $registro["nro_operacion"] = $row["nro_operacion"];
                        $registro["item"] = $row["item"];
                        $registro["familia_producto"] = $row["familia_producto"];
                        $registro["programacion"] = $row["programacion"];
                        $registro["date"] = $row["fecha_ingreso"];
                        $registro["fecha_lectura"] = $row["fecha_lectura"];
                        $registro["c_no_encontrados"] = $c_no_encontrados;
                        $registro["c_encontrados"] = $c_encontrados;
                        $registro["total_activos"] = $num_vinculados[0]["cant_vinculados"];
                        $registros[] = $registro;
                        //$tabla .= '{"id":"' . $i . '","cod_producto":"' . $row['codigo'] . '","cod_rfid":"' . $row['codigo_rfid'] . '","descripcion":"' . $row['descripcion'] . '","valor":"' . $row['valor'] . '","cliente":"' . $row['cliente'] . '","ubigeo":"' . $row['ubigeo'] . '","ubicacion":"' . $row['ubicacion'] . '","lote":"' . $row['lote'] . '","ancho":"' . $row['ancho'] . '","profundidad":"' . $row['profundidad'] . '","peso":"' . $row['peso'] . '","orden_ingreso":"' . $row['orden_ingreso'] . '","programacion":"' . $row['programacion'] . '","date":"' . $row['fecha_ingreso'] . '","fecha_lectura":"' . $row['fecha_lectura'] . '","c_no_encontrados":"' . $c_no_encontrados . '","c_encontrados":"' . $c_encontrados . '","total_activos":"' . $num_vinculados[0]["cant_vinculados"] . '"},';
                    }
                }
                echo '{"data": ' . json_encode($registros) . '}';
            } else {
                $this->load->model('tbl_inventario_tiempo_real');
                $this->load->tmp_admin->setLayout('templates/admin_tmp');
                $num_vinculados = $this->tbl_inventario->get_all_vinculados_ubigeo_ubicacion_abc($ubigeo, $ubicacion);
                $fecha_lectura = "";
                $registros = array();
                $tabla = "";
                $i = 0;
                $lista = $this->tbl_inventario_tiempo_real->get_lista_activos_matriculados_ubigeo_abc($ubigeo, $ubicacion);
                foreach ($lista as $row) {
                    $i++;
                    $registro = array();
                    $registro["id"] = $i;
                    $registro["cod_producto"] = $row["codigo"];
                    $registro["cod_rfid"] = $row["codigo_rfid"];
                    $registro["descripcion"] = $row["descripcion"];
                    $registro["cliente"] = $row["cliente"];
                    $registro["valor"] = $row["valor"];
                    $registro["ubigeo"] = $row["ubigeo"];
                    $registro["ubicacion"] = $row["ubicacion"];
                    $registro["nro_dam"] = $row["nro_dam"];
                    $registro["guia_remision"] = $row["guia_remision"];
                    $registro["nro_operacion"] = $row["nro_operacion"];
                    $registro["item"] = $row["item"];
                    $registro["familia_producto"] = $row["familia_producto"];
                    $registro["programacion"] = $row["programacion"];
                    $registro["date"] = $row["fecha_ingreso"];
                    $registro["fecha_lectura"] = $row["fecha_lectura"];
                    $registro["c_no_encontrados"] = $c_no_encontrados;
                    $registro["total_activos"] = $num_vinculados[0]["cant_vinculados"];
                    $registros[] = $registro;
                    //$tabla .= '{"id":"' . $i . '","cod_producto":"' . $row['codigo'] . '","cod_rfid":"' . $row['codigo_rfid'] . '","descripcion":"' . $row['descripcion'] . '","valor":"' . $row['valor'] . '","cliente":"' . $row['cliente'] . '","ubigeo":"' . $row['ubigeo'] . '","ubicacion":"' . $row['ubicacion'] . '","lote":"' . $row['lote'] . '","ancho":"' . $row['ancho'] . '","profundidad":"' . $row['profundidad'] . '","peso":"' . $row['peso'] . '","orden_ingreso":"' . $row['orden_ingreso'] . '","programacion":"' . $row['programacion'] . '","date":"' . $row['fecha_ingreso'] . '","fecha_lectura":"' . $fecha_lectura . '","c_no_encontrados":"' . $c_no_encontrados . '","total_activos":"' . $num_vinculados[0]["cant_vinculados"] . '"},';
                }
                //$tabla = substr($tabla, 0, strlen($tabla) - 1);
                //echo '{"data":[' . $tabla . ']}';
                echo '{"data": ' . json_encode($registros) . '}';
            }
        } else {
            //echo "CHRIS - NO ASIGNASTE DISPOSITIVO";
            $this->load->model('tbl_inventario_tiempo_real');
            $this->load->tmp_admin->setLayout('templates/admin_tmp');
            $num_vinculados = $this->tbl_inventario->get_all_vinculados();
            $c_no_encontrados = $num_vinculados[0]["cant_vinculados"];
            $registros = array();
            $tabla = "";
            $i = 0;
            $lista = $this->tbl_inventario_tiempo_real->get_lista_activos_matriculados_ubigeo_abc();
            foreach ($lista as $row) {
                $fecha_lectura = "";
                $i++;
                $registro = array();
                $registro["id"] = $i;
                $registro["cod_producto"] = $row["codigo"];
                $registro["cod_rfid"] = $row["codigo_rfid"];
                $registro["descripcion"] = $row["descripcion"];
                $registro["cliente"] = $row["cliente"];
                $registro["valor"] = $row["valor"];
                $registro["ubigeo"] = $row["ubigeo"];
                $registro["ubicacion"] = $row["ubicacion"];
                $registro["nro_dam"] = $row["nro_dam"];
                $registro["guia_remision"] = $row["guia_remision"];
                $registro["nro_operacion"] = $row["nro_operacion"];
                $registro["item"] = $row["item"];
                $registro["familia_producto"] = $row["familia_producto"];
                $registro["programacion"] = $row["programacion"];
                $registro["date"] = $row["fecha_ingreso"];
                $registro["fecha_lectura"] = $row["fecha_lectura"];
                $registro["c_no_encontrados"] = $c_no_encontrados;
                $registro["total_activos"] = $num_vinculados[0]["cant_vinculados"];
                $registros[] = $registro;
                //$tabla .= '{"id":"' . $i . '","cod_producto":"' . $row['codigo'] . '","cod_rfid":"' . $row['codigo_rfid'] . '","descripcion":"' . $row['descripcion'] . '","valor":"' . $row['valor'] . '","cliente":"' . $row['cliente'] . '","ubigeo":"' . $row['ubigeo'] . '","ubicacion":"' . $row['ubicacion'] . '","lote":"' . $row['lote'] . '","ancho":"' . $row['ancho'] . '","profundidad":"' . $row['profundidad'] . '","peso":"' . $row['peso'] . '","c_no_encontrados":"' . $c_no_encontrados . '","orden_ingreso":"' . $row['orden_ingreso'] . '","programacion":"' . $row['programacion'] . '","date":"' . $row['fecha_ingreso'] . '","fecha_lectura":"' . $fecha_lectura . '","total_activos":"' . $num_vinculados[0]["cant_vinculados"] . '"},';
            }
            //$tabla = substr($tabla, 0, strlen($tabla) - 1);
            //echo '{"data":[' . $tabla . ']}';
            echo '{"data": ' . json_encode($registros) . '}';
        }
    }
    public function get_inventario_tiempo_real()
    {
        $this->load->model('tbl_alerta');
        $this->load->model('tbl_inventario_tiempo_real');
        $this->load->model('tbl_inventario');
        $this->load->model('tbl_vinculacion');
        $this->load->model('tbl_dispositivo_rfid');
        //$num_vinculados = $this->tbl_inventario->get_all_vinculados();
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $actividad = "INVENTARIADO";
        $actividad = $this->tbl_vinculacion->get_actividad($actividad);
        if (!empty($actividad)) {
            $actividad = "INVENTARIADO";
            $atributos = $this->obj_vinculacion->get_actividad_actual("INVENTARIADO");
            $ubigeo = $atributos[0]["ubigeo"];
            $ubicacion = $atributos[0]["ubicacion"];
            $num_vinculados = $this->tbl_inventario->get_all_vinculados_ubigeo_ubicacion($ubigeo, $ubicacion);
            //print_r($num_vinculados);
            $tabla = "";
            $i = 0;
            $encontrados = "0";
            $no_encontrados = "0";
            /* $c_encontrados = $this->tbl_alerta->get_encontrados()->encontrados;
            $c_no_encontrados = $this->tbl_alerta->get_no_encontrados()->no_encontrados; */
            $c_encontrados = $this->tbl_alerta->get_encontrados_ubigeo($ubigeo, $ubicacion)->encontrados;
            $c_no_encontrados = $this->tbl_alerta->get_no_encontrados_ubigeo($ubigeo, $ubicacion)->no_encontrados;
            //$this->tmp_admin->set('encontrados', $encontrados);
            $lista = $this->tbl_inventario_tiempo_real->get_lista_activos_matriculados_ubigeo($ubigeo, $ubicacion);
            $mac_asignada = $this->tbl_vinculacion->get_dispositivo_asignado($ubigeo, $ubicacion, $actividad);
            $mac_asignada = $mac_asignada[0]["mac"];
            //print_r($mac_asignada);
            $ultimo_mac = $this->tbl_dispositivo_rfid->get_list_ultimo_mac();
            $ultimo_mac = $ultimo_mac[0]["mac"];
            $ultimo_mac = substr($ultimo_mac, 7, 17);
            //print_r($ultimo_mac);
            // DISCRIMINACION DE DISPOSITIVO RFID
            if ($ultimo_mac == $mac_asignada) {
                //print_r($lista);
                $registros = array();
                foreach ($lista as $row) {
                    $fecha_lectura = $this->tbl_alerta->get_fecha_chip($row['codigo_rfid']);
                    //print_r($fecha_lectura);
                    if (empty($fecha_lectura)) {
                        $this->tbl_inventario->insertar_fecha_lectura($row['codigo_producto'], "");
                        $no_encontrados++;
                        $i++;
                        $registro = array();
                        $registro["id"] = $i;
                        $registro["cod_producto"] = $row["codigo_producto"];
                        $registro["cod_rfid"] = $row["codigo_rfid"];
                        $registro["descripcion"] = $row["descripcion"];
                        $registro["cliente"] = $row["cliente"];
                        $registro["valor"] = $row["valor"];
                        $registro["ubigeo"] = $row["ubigeo"];
                        $registro["ubicacion"] = $row["ubicacion"];
                        $registro["lote"] = $row["lote"];
                        $registro["ancho"] = $row["ancho"];
                        $registro["profundidad"] = $row["profundidad"];
                        $registro["peso"] = $row["peso"];
                        $registro["orden_ingreso"] = $row["orden_ingreso"];
                        $registro["programacion"] = $row["programacion"];
                        $registro["date"] = $row["fecha_ingreso"];
                        $registro["fecha_lectura"] = $row["fecha_lectura"];
                        $registro["c_no_encontrados"] = $c_no_encontrados;
                        $registro["total_activos"] = $num_vinculados[0]["cant_vinculados"];
                        $registros[] = $registro;
                        //$tabla .= '{"id":"' . $i . '","cod_producto":"' . $row['codigo_producto'] . '","cod_rfid":"' . $row['codigo_rfid'] . '","descripcion":"' . $row['descripcion'] . '","valor":"' . $row['valor'] . '","cliente":"' . $row['cliente'] . '","ubigeo":"' . $row['ubigeo'] . '","ubicacion":"' . $row['ubicacion'] . '","lote":"' . $row['lote'] . '","ancho":"' . $row['ancho'] . '","profundidad":"' . $row['profundidad'] . '","peso":"' . $row['peso'] . '","orden_ingreso":"' . $row['orden_ingreso'] . '","programacion":"' . $row['programacion'] . '","date":"' . $row['fecha_ingreso'] . '","fecha_lectura":"' . $row['fecha_lectura'] . '","c_no_encontrados":"' . $c_no_encontrados . '","total_activos":"' . $num_vinculados[0]["cant_vinculados"] . '"},';
                    } else {
                        $this->tbl_inventario->insertar_fecha_lectura($row['codigo_producto'], $fecha_lectura[0]["fecha_lectura"]);
                        $encontrados++;
                        $i++;
                        $registro = array();
                        $registro["id"] = $i;
                        $registro["cod_producto"] = $row["codigo_producto"];
                        $registro["cod_rfid"] = $row["codigo_rfid"];
                        $registro["descripcion"] = $row["descripcion"];
                        $registro["cliente"] = $row["cliente"];
                        $registro["valor"] = $row["valor"];
                        $registro["ubigeo"] = $row["ubigeo"];
                        $registro["ubicacion"] = $row["ubicacion"];
                        $registro["lote"] = $row["lote"];
                        $registro["ancho"] = $row["ancho"];
                        $registro["profundidad"] = $row["profundidad"];
                        $registro["peso"] = $row["peso"];
                        $registro["orden_ingreso"] = $row["orden_ingreso"];
                        $registro["programacion"] = $row["programacion"];
                        $registro["date"] = $row["fecha_ingreso"];
                        $registro["fecha_lectura"] = $row["fecha_lectura"];
                        $registro["c_no_encontrados"] = $c_no_encontrados;
                        $registro["c_encontrados"] = $c_encontrados;
                        $registro["total_activos"] = $num_vinculados[0]["cant_vinculados"];
                        $registros[] = $registro;
                        //$tabla .= '{"id":"' . $i . '","cod_producto":"' . $row['codigo_producto'] . '","cod_rfid":"' . $row['codigo_rfid'] . '","descripcion":"' . $row['descripcion'] . '","valor":"' . $row['valor'] . '","cliente":"' . $row['cliente'] . '","ubigeo":"' . $row['ubigeo'] . '","ubicacion":"' . $row['ubicacion'] . '","lote":"' . $row['lote'] . '","ancho":"' . $row['ancho'] . '","profundidad":"' . $row['profundidad'] . '","peso":"' . $row['peso'] . '","orden_ingreso":"' . $row['orden_ingreso'] . '","programacion":"' . $row['programacion'] . '","date":"' . $row['fecha_ingreso'] . '","fecha_lectura":"' . $row['fecha_lectura'] . '","c_no_encontrados":"' . $c_no_encontrados . '","c_encontrados":"' . $c_encontrados . '","total_activos":"' . $num_vinculados[0]["cant_vinculados"] . '"},';
                    }
                }
                echo '{"data": ' . json_encode($registros) . '}';
            } else {
                $this->load->model('tbl_inventario_tiempo_real');
                $this->load->tmp_admin->setLayout('templates/admin_tmp');
                $num_vinculados = $this->tbl_inventario->get_all_vinculados_ubigeo_ubicacion($ubigeo, $ubicacion);
                $fecha_lectura = "";
                $registros = array();
                $tabla = "";
                $i = 0;
                $lista = $this->tbl_inventario_tiempo_real->get_lista_activos_matriculados_ubigeo($ubigeo, $ubicacion);
                foreach ($lista as $row) {
                    $i++;
                    $registro = array();
                    $registro["id"] = $i;
                    $registro["cod_producto"] = $row["codigo_producto"];
                    $registro["cod_rfid"] = $row["codigo_rfid"];
                    $registro["descripcion"] = $row["descripcion"];
                    $registro["cliente"] = $row["cliente"];
                    $registro["valor"] = $row["valor"];
                    $registro["ubigeo"] = $row["ubigeo"];
                    $registro["ubicacion"] = $row["ubicacion"];
                    $registro["lote"] = $row["lote"];
                    $registro["ancho"] = $row["ancho"];
                    $registro["profundidad"] = $row["profundidad"];
                    $registro["peso"] = $row["peso"];
                    $registro["orden_ingreso"] = $row["orden_ingreso"];
                    $registro["programacion"] = $row["programacion"];
                    $registro["date"] = $row["fecha_ingreso"];
                    $registro["fecha_lectura"] = $row["fecha_lectura"];
                    $registro["c_no_encontrados"] = $c_no_encontrados;
                    $registro["total_activos"] = $num_vinculados[0]["cant_vinculados"];
                    $registros[] = $registro;
                    //$tabla .= '{"id":"' . $i . '","cod_producto":"' . $row['codigo_producto'] . '","cod_rfid":"' . $row['codigo_rfid'] . '","descripcion":"' . $row['descripcion'] . '","valor":"' . $row['valor'] . '","cliente":"' . $row['cliente'] . '","ubigeo":"' . $row['ubigeo'] . '","ubicacion":"' . $row['ubicacion'] . '","lote":"' . $row['lote'] . '","ancho":"' . $row['ancho'] . '","profundidad":"' . $row['profundidad'] . '","peso":"' . $row['peso'] . '","orden_ingreso":"' . $row['orden_ingreso'] . '","programacion":"' . $row['programacion'] . '","date":"' . $row['fecha_ingreso'] . '","fecha_lectura":"' . $fecha_lectura . '","c_no_encontrados":"' . $c_no_encontrados . '","total_activos":"' . $num_vinculados[0]["cant_vinculados"] . '"},';
                }
                //$tabla = substr($tabla, 0, strlen($tabla) - 1);
                //echo '{"data":[' . $tabla . ']}';
                echo '{"data": ' . json_encode($registros) . '}';
            }
        } else {
            //echo "CHRIS - NO ASIGNASTE DISPOSITIVO";
            $this->load->model('tbl_inventario_tiempo_real');
            $this->load->tmp_admin->setLayout('templates/admin_tmp');
            $num_vinculados = $this->tbl_inventario->get_all_vinculados();
            $c_no_encontrados = $num_vinculados[0]["cant_vinculados"];
            $registros = array();
            $tabla = "";
            $i = 0;
            $lista = $this->tbl_inventario_tiempo_real->get_lista_activos_matriculados_ubigeo_simple();
            foreach ($lista as $row) {
                $fecha_lectura = "";
                $i++;
                $registro = array();
                $registro["id"] = $i;
                $registro["cod_producto"] = $row["codigo_producto"];
                $registro["cod_rfid"] = $row["codigo_rfid"];
                $registro["descripcion"] = $row["descripcion"];
                $registro["cliente"] = $row["cliente"];
                $registro["valor"] = $row["valor"];
                $registro["ubigeo"] = $row["ubigeo"];
                $registro["ubicacion"] = $row["ubicacion"];
                $registro["lote"] = $row["lote"];
                $registro["ancho"] = $row["ancho"];
                $registro["profundidad"] = $row["profundidad"];
                $registro["peso"] = $row["peso"];
                $registro["orden_ingreso"] = $row["orden_ingreso"];
                $registro["programacion"] = $row["programacion"];
                $registro["date"] = $row["fecha_ingreso"];
                $registro["fecha_lectura"] = $row["fecha_lectura"];
                $registro["c_no_encontrados"] = $c_no_encontrados;
                $registro["total_activos"] = $num_vinculados[0]["cant_vinculados"];
                $registros[] = $registro;
                //$tabla .= '{"id":"' . $i . '","cod_producto":"' . $row['codigo_producto'] . '","cod_rfid":"' . $row['codigo_rfid'] . '","descripcion":"' . $row['descripcion'] . '","valor":"' . $row['valor'] . '","cliente":"' . $row['cliente'] . '","ubigeo":"' . $row['ubigeo'] . '","ubicacion":"' . $row['ubicacion'] . '","lote":"' . $row['lote'] . '","ancho":"' . $row['ancho'] . '","profundidad":"' . $row['profundidad'] . '","peso":"' . $row['peso'] . '","c_no_encontrados":"' . $c_no_encontrados . '","orden_ingreso":"' . $row['orden_ingreso'] . '","programacion":"' . $row['programacion'] . '","date":"' . $row['fecha_ingreso'] . '","fecha_lectura":"' . $fecha_lectura . '","total_activos":"' . $num_vinculados[0]["cant_vinculados"] . '"},';
            }
            //$tabla = substr($tabla, 0, strlen($tabla) - 1);
            //echo '{"data":[' . $tabla . ']}';
            echo '{"data": ' . json_encode($registros) . '}';
        }
    }
    public function get_inventario_tiempo_real_abc()
    {
        $this->load->model('tbl_alerta');
        $this->load->model('tbl_inventario_tiempo_real');
        $this->load->model('tbl_inventario');
        $this->load->model('tbl_vinculacion');
        $this->load->model('tbl_dispositivo_rfid');
        //$num_vinculados = $this->tbl_inventario->get_all_vinculados();
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $actividad = "INVENTARIADO";
        $actividad = $this->tbl_vinculacion->get_actividad($actividad);
        if (!empty($actividad)) {
            $actividad = "INVENTARIADO";
            $atributos = $this->obj_vinculacion->get_actividad_actual("INVENTARIADO");
            $ubigeo = $atributos[0]["ubigeo"];
            $ubicacion = $atributos[0]["ubicacion"];
            $num_vinculados = $this->tbl_inventario->get_all_vinculados_ubigeo_ubicacion_abc($ubigeo, $ubicacion);
            //print_r($num_vinculados);
            $tabla = "";
            $i = 0;
            $encontrados = "0";
            $no_encontrados = "0";
            /* $c_encontrados = $this->tbl_alerta->get_encontrados()->encontrados;
            $c_no_encontrados = $this->tbl_alerta->get_no_encontrados()->no_encontrados; */
            $c_encontrados = $this->tbl_alerta->get_encontrados_ubigeo_abc($ubigeo, $ubicacion)->encontrados;
            $c_no_encontrados = $this->tbl_alerta->get_no_encontrados_ubigeo_abc($ubigeo, $ubicacion)->no_encontrados;
            //$this->tmp_admin->set('encontrados', $encontrados);
            $lista = $this->tbl_inventario_tiempo_real->get_lista_activos_matriculados_ubigeo_abc($ubigeo, $ubicacion);
            $mac_asignada = $this->tbl_vinculacion->get_dispositivo_asignado($ubigeo, $ubicacion, $actividad);
            $mac_asignada = $mac_asignada[0]["mac"];
            //print_r($mac_asignada);
            $ultimo_mac = $this->tbl_dispositivo_rfid->get_list_ultimo_mac();
            $ultimo_mac = $ultimo_mac[0]["mac"];
            $ultimo_mac = substr($ultimo_mac, 7, 17);
            //print_r($ultimo_mac);
            // DISCRIMINACION DE DISPOSITIVO RFID
            if ($ultimo_mac == $mac_asignada) {
                //print_r($lista);
                $registros = array();
                foreach ($lista as $row) {
                    $fecha_lectura = $this->tbl_alerta->get_fecha_chip($row['codigo_rfid']);
                    //print_r($fecha_lectura);
                    if (empty($fecha_lectura)) {
                        $this->tbl_inventario->insertar_fecha_lectura_abc($row['id'], "");
                        $no_encontrados++;
                        $i++;
                        $registro = array();
                        $registro["id"] = $i;
                        $registro["cod_producto"] = $row["codigo_producto"];
                        $registro["cod_rfid"] = $row["codigo_rfid"];
                        $registro["descripcion"] = $row["descripcion"];
                        $registro["correlativo"] = $row["correlativo"];
                        $registro["cliente"] = $row["cliente"];
                        $registro["valor"] = $row["valor"];
                        $registro["ubigeo"] = $row["ubigeo"];
                        $registro["ubicacion"] = $row["ubicacion"];
                        $registro["nro_dam"] = $row["nro_dam"];
                        $registro["guia_remision"] = $row["guia_remision"];
                        $registro["nro_operacion"] = $row["nro_operacion"];
                        $registro["item"] = $row["item"];
                        $registro["familia_producto"] = $row["familia_producto"];
                        $registro["programacion"] = $row["programacion"];
                        $registro["date"] = $row["fecha_ingreso"];
                        $registro["fecha_lectura"] = $row["fecha_lectura"];
                        $registro["c_no_encontrados"] = $c_no_encontrados;
                        $registro["total_activos"] = $num_vinculados[0]["cant_vinculados"];
                        $registros[] = $registro;
                        //$tabla .= '{"id":"' . $i . '","cod_producto":"' . $row['codigo'] . '","cod_rfid":"' . $row['codigo_rfid'] . '","descripcion":"' . $row['descripcion'] . '","valor":"' . $row['valor'] . '","cliente":"' . $row['cliente'] . '","ubigeo":"' . $row['ubigeo'] . '","ubicacion":"' . $row['ubicacion'] . '","lote":"' . $row['lote'] . '","ancho":"' . $row['ancho'] . '","profundidad":"' . $row['profundidad'] . '","peso":"' . $row['peso'] . '","orden_ingreso":"' . $row['orden_ingreso'] . '","programacion":"' . $row['programacion'] . '","date":"' . $row['fecha_ingreso'] . '","fecha_lectura":"' . $row['fecha_lectura'] . '","c_no_encontrados":"' . $c_no_encontrados . '","total_activos":"' . $num_vinculados[0]["cant_vinculados"] . '"},';
                    } else {
                        $this->tbl_inventario->insertar_fecha_lectura_abc($row['id'], $fecha_lectura[0]["fecha_lectura"]);
                        $encontrados++;
                        $i++;
                        $registro = array();
                        $registro["id"] = $i;
                        $registro["cod_producto"] = $row["codigo_producto"];
                        $registro["cod_rfid"] = $row["codigo_rfid"];
                        $registro["descripcion"] = $row["descripcion"];
                        $registro["correlativo"] = $row["correlativo"];
                        $registro["cliente"] = $row["cliente"];
                        $registro["valor"] = $row["valor"];
                        $registro["ubigeo"] = $row["ubigeo"];
                        $registro["ubicacion"] = $row["ubicacion"];
                        $registro["nro_dam"] = $row["nro_dam"];
                        $registro["guia_remision"] = $row["guia_remision"];
                        $registro["nro_operacion"] = $row["nro_operacion"];
                        $registro["item"] = $row["item"];
                        $registro["familia_producto"] = $row["familia_producto"];
                        $registro["programacion"] = $row["programacion"];
                        $registro["date"] = $row["fecha_ingreso"];
                        $registro["fecha_lectura"] = $row["fecha_lectura"];
                        $registro["c_no_encontrados"] = $c_no_encontrados;
                        $registro["c_encontrados"] = $c_encontrados;
                        $registro["total_activos"] = $num_vinculados[0]["cant_vinculados"];
                        $registros[] = $registro;
                        //$tabla .= '{"id":"' . $i . '","cod_producto":"' . $row['codigo_producto'] . '","cod_rfid":"' . $row['codigo_rfid'] . '","descripcion":"' . $row['descripcion'] . '","valor":"' . $row['valor'] . '","cliente":"' . $row['cliente'] . '","ubigeo":"' . $row['ubigeo'] . '","ubicacion":"' . $row['ubicacion'] . '","lote":"' . $row['lote'] . '","ancho":"' . $row['ancho'] . '","profundidad":"' . $row['profundidad'] . '","peso":"' . $row['peso'] . '","orden_ingreso":"' . $row['orden_ingreso'] . '","programacion":"' . $row['programacion'] . '","date":"' . $row['fecha_ingreso'] . '","fecha_lectura":"' . $row['fecha_lectura'] . '","c_no_encontrados":"' . $c_no_encontrados . '","c_encontrados":"' . $c_encontrados . '","total_activos":"' . $num_vinculados[0]["cant_vinculados"] . '"},';
                    }
                }
                echo '{"data": ' . json_encode($registros) . '}';
            } else {
                $this->load->model('tbl_inventario_tiempo_real');
                $this->load->tmp_admin->setLayout('templates/admin_tmp');
                $num_vinculados = $this->tbl_inventario->get_all_vinculados_ubigeo_ubicacion_abc($ubigeo, $ubicacion);
                $fecha_lectura = "";
                $registros = array();
                $tabla = "";
                $i = 0;
                $lista = $this->tbl_inventario_tiempo_real->get_lista_activos_matriculados_ubigeo_abc($ubigeo, $ubicacion);
                foreach ($lista as $row) {
                    $i++;
                    $registro = array();
                    $registro["id"] = $i;
                    $registro["cod_producto"] = $row["codigo_producto"];
                    $registro["cod_rfid"] = $row["codigo_rfid"];
                    $registro["descripcion"] = $row["descripcion"];
                    $registro["correlativo"] = $row["correlativo"];
                    $registro["cliente"] = $row["cliente"];
                    $registro["valor"] = $row["valor"];
                    $registro["ubigeo"] = $row["ubigeo"];
                    $registro["ubicacion"] = $row["ubicacion"];
                    $registro["nro_dam"] = $row["nro_dam"];
                    $registro["guia_remision"] = $row["guia_remision"];
                    $registro["nro_operacion"] = $row["nro_operacion"];
                    $registro["item"] = $row["item"];
                    $registro["familia_producto"] = $row["familia_producto"];
                    $registro["programacion"] = $row["programacion"];
                    $registro["date"] = $row["fecha_ingreso"];
                    $registro["fecha_lectura"] = $row["fecha_lectura"];
                    $registro["c_no_encontrados"] = $c_no_encontrados;
                    $registro["total_activos"] = $num_vinculados[0]["cant_vinculados"];
                    $registros[] = $registro;
                    //$tabla .= '{"id":"' . $i . '","cod_producto":"' . $row['codigo'] . '","cod_rfid":"' . $row['codigo_rfid'] . '","descripcion":"' . $row['descripcion'] . '","valor":"' . $row['valor'] . '","cliente":"' . $row['cliente'] . '","ubigeo":"' . $row['ubigeo'] . '","ubicacion":"' . $row['ubicacion'] . '","lote":"' . $row['lote'] . '","ancho":"' . $row['ancho'] . '","profundidad":"' . $row['profundidad'] . '","peso":"' . $row['peso'] . '","orden_ingreso":"' . $row['orden_ingreso'] . '","programacion":"' . $row['programacion'] . '","date":"' . $row['fecha_ingreso'] . '","fecha_lectura":"' . $fecha_lectura . '","c_no_encontrados":"' . $c_no_encontrados . '","total_activos":"' . $num_vinculados[0]["cant_vinculados"] . '"},';
                }
                //$tabla = substr($tabla, 0, strlen($tabla) - 1);
                //echo '{"data":[' . $tabla . ']}';
                echo '{"data": ' . json_encode($registros) . '}';
            }
        } else {
            //echo "CHRIS - NO ASIGNASTE DISPOSITIVO";
            $this->load->model('tbl_inventario_tiempo_real');
            $this->load->tmp_admin->setLayout('templates/admin_tmp');
            $num_vinculados = $this->tbl_inventario->get_all_vinculados();
            $c_no_encontrados = $num_vinculados[0]["cant_vinculados"];
            $registros = array();
            $tabla = "";
            $i = 0;
            $lista = $this->tbl_inventario_tiempo_real->get_lista_activos_matriculados_ubigeo_abc();
            foreach ($lista as $row) {
                $fecha_lectura = "";
                $i++;
                $registro = array();
                $registro["id"] = $i;
                $registro["cod_producto"] = $row["codigo_producto"];
                $registro["cod_rfid"] = $row["codigo_rfid"];
                $registro["descripcion"] = $row["descripcion"];
                $registro["correlativo"] = $row["correlativo"];
                $registro["cliente"] = $row["cliente"];
                $registro["valor"] = $row["valor"];
                $registro["ubigeo"] = $row["ubigeo"];
                $registro["ubicacion"] = $row["ubicacion"];
                $registro["nro_dam"] = $row["nro_dam"];
                $registro["guia_remision"] = $row["guia_remision"];
                $registro["nro_operacion"] = $row["nro_operacion"];
                $registro["item"] = $row["item"];
                $registro["familia_producto"] = $row["familia_producto"];
                $registro["programacion"] = $row["programacion"];
                $registro["date"] = $row["fecha_ingreso"];
                $registro["fecha_lectura"] = $row["fecha_lectura"];
                $registro["c_no_encontrados"] = $c_no_encontrados;
                $registro["total_activos"] = $num_vinculados[0]["cant_vinculados"];
                $registros[] = $registro;
                //$tabla .= '{"id":"' . $i . '","cod_producto":"' . $row['codigo'] . '","cod_rfid":"' . $row['codigo_rfid'] . '","descripcion":"' . $row['descripcion'] . '","valor":"' . $row['valor'] . '","cliente":"' . $row['cliente'] . '","ubigeo":"' . $row['ubigeo'] . '","ubicacion":"' . $row['ubicacion'] . '","lote":"' . $row['lote'] . '","ancho":"' . $row['ancho'] . '","profundidad":"' . $row['profundidad'] . '","peso":"' . $row['peso'] . '","c_no_encontrados":"' . $c_no_encontrados . '","orden_ingreso":"' . $row['orden_ingreso'] . '","programacion":"' . $row['programacion'] . '","date":"' . $row['fecha_ingreso'] . '","fecha_lectura":"' . $fecha_lectura . '","total_activos":"' . $num_vinculados[0]["cant_vinculados"] . '"},';
            }
            //$tabla = substr($tabla, 0, strlen($tabla) - 1);
            //echo '{"data":[' . $tabla . ']}';
            echo '{"data": ' . json_encode($registros) . '}';
        }
    }
    public function get_inventario_tiempo_real_1()
    {
        $this->load->model('tbl_alerta');
        $this->load->model('tbl_inventario_tiempo_real');
        $this->load->model('tbl_inventario');
        $this->load->model('tbl_vinculacion');
        $this->load->model('tbl_dispositivo_rfid');
        //$num_vinculados = $this->tbl_inventario->get_all_vinculados();
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $atributos = $this->obj_vinculacion->get_actividad_actual("INVENTARIADO");
        $ubigeo = $atributos[0]["ubigeo"];
        $ubicacion = $atributos[0]["ubicacion"];
        $num_vinculados = $this->tbl_inventario->get_all_vinculados_ubigeo_ubicacion($ubigeo, $ubicacion);
        //print_r($num_vinculados);
        $tabla = "";
        $i = 0;
        $encontrados = "0";
        $no_encontrados = "0";
        /* $c_encontrados = $this->tbl_alerta->get_encontrados()->encontrados;
        $c_no_encontrados = $this->tbl_alerta->get_no_encontrados()->no_encontrados; */
        $c_encontrados = $this->tbl_alerta->get_encontrados_ubigeo($ubigeo, $ubicacion)->encontrados;
        $c_no_encontrados = $this->tbl_alerta->get_no_encontrados_ubigeo($ubigeo, $ubicacion)->no_encontrados;
        //$this->tmp_admin->set('encontrados', $encontrados);
        $lista = $this->tbl_inventario_tiempo_real->get_lista_activos_matriculados_ubigeo($ubigeo, $ubicacion);
        $actividad = "INVENTARIADO";
        $mac_asignada = $this->tbl_vinculacion->get_dispositivo_asignado($ubigeo, $ubicacion, $actividad);
        $mac_asignada = $mac_asignada[0]["mac"];
        //print_r($mac_asignada);
        $ultimo_mac = $this->tbl_dispositivo_rfid->get_list_ultimo_mac();
        $ultimo_mac = $ultimo_mac[0]["mac"];
        $ultimo_mac = substr($ultimo_mac, 7, 17);
        //print_r($ultimo_mac);
        // DISCRIMINACION DE DISPOSITIVO RFID
        if ($ultimo_mac == $mac_asignada) {
            //print_r($lista);
            foreach ($lista as $row) {
                $fecha_lectura = $this->tbl_alerta->get_fecha_chip($row['codigo_rfid']);
                //print_r($fecha_lectura);
                if (empty($fecha_lectura)) {
                    $this->tbl_inventario->insertar_fecha_lectura($row['codigo_producto'], "");
                    $no_encontrados++;
                    $i++;
                    $tabla .= '{"id":"' . $i . '","cod_producto":"' . $row['codigo_producto'] . '","cod_rfid":"' . $row['codigo_rfid'] . '","descripcion":"' . $row['descripcion'] . '","valor":"' . $row['valor'] . '","cliente":"' . $row['cliente'] . '","ubigeo":"' . $row['ubigeo'] . '","ubicacion":"' . $row['ubicacion'] . '","lote":"' . $row['lote'] . '","ancho":"' . $row['ancho'] . '","profundidad":"' . $row['profundidad'] . '","peso":"' . $row['peso'] . '","orden_ingreso":"' . $row['orden_ingreso'] . '","programacion":"' . $row['programacion'] . '","date":"' . $row['fecha_ingreso'] . '","fecha_lectura":"' . $row['fecha_lectura'] . '","c_no_encontrados":"' . $c_no_encontrados . '","total_activos":"' . $num_vinculados[0]["cant_vinculados"] . '"},';
                } else {
                    $this->tbl_inventario->insertar_fecha_lectura($row['codigo_producto'], $fecha_lectura[0]["fecha_lectura"]);
                    $encontrados++;
                    $i++;
                    $tabla .= '{"id":"' . $i . '","cod_producto":"' . $row['codigo_producto'] . '","cod_rfid":"' . $row['codigo_rfid'] . '","descripcion":"' . $row['descripcion'] . '","valor":"' . $row['valor'] . '","cliente":"' . $row['cliente'] . '","ubigeo":"' . $row['ubigeo'] . '","ubicacion":"' . $row['ubicacion'] . '","lote":"' . $row['lote'] . '","ancho":"' . $row['ancho'] . '","profundidad":"' . $row['profundidad'] . '","peso":"' . $row['peso'] . '","orden_ingreso":"' . $row['orden_ingreso'] . '","programacion":"' . $row['programacion'] . '","date":"' . $row['fecha_ingreso'] . '","fecha_lectura":"' . $row['fecha_lectura'] . '","c_no_encontrados":"' . $c_no_encontrados . '","c_encontrados":"' . $c_encontrados . '","total_activos":"' . $num_vinculados[0]["cant_vinculados"] . '"},';
                }
            }
            $tabla = substr($tabla, 0, strlen($tabla) - 1);
            echo '{"data":[' . $tabla . ']}';
        } else {
            $this->load->model('tbl_inventario_tiempo_real');
            $this->load->tmp_admin->setLayout('templates/admin_tmp');
            $fecha_lectura = "";
            $tabla = "";
            $i = 0;
            $lista = $this->tbl_inventario_tiempo_real->get_lista_activos_matriculados_ubigeo($ubigeo, $ubicacion);
            foreach ($lista as $row) {
                $i++;
                $tabla .= '{"id":"' . $i . '","cod_producto":"' . $row['codigo_producto'] . '","cod_rfid":"' . $row['codigo_rfid'] . '","descripcion":"' . $row['descripcion'] . '","valor":"' . $row['valor'] . '","cliente":"' . $row['cliente'] . '","ubigeo":"' . $row['ubigeo'] . '","ubicacion":"' . $row['ubicacion'] . '","lote":"' . $row['lote'] . '","ancho":"' . $row['ancho'] . '","profundidad":"' . $row['profundidad'] . '","peso":"' . $row['peso'] . '","orden_ingreso":"' . $row['orden_ingreso'] . '","programacion":"' . $row['programacion'] . '","date":"' . $row['fecha_ingreso'] . '","fecha_lectura":"' . $fecha_lectura . '","c_no_encontrados":"' . $c_no_encontrados . '","total_activos":"' . $num_vinculados[0]["cant_vinculados"] . '"},';
            }
            $tabla = substr($tabla, 0, strlen($tabla) - 1);
            echo '{"data":[' . $tabla . ']}';
        }
    }
    public function get_inventario_tiempo_real_antiguo()
    {
        $this->load->model('tbl_alerta');
        $this->load->model('tbl_inventario_tiempo_real');
        $this->load->model('tbl_inventario');
        $num_vinculados = $this->tbl_inventario->get_all_vinculados();
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $tabla = "";
        $i = 0;
        $encontrados = "0";
        $no_encontrados = "0";
        $this->tmp_admin->set('encontrados', $encontrados);
        $lista = $this->tbl_inventario_tiempo_real->get_lista_activos_matriculados();
        foreach ($lista as $row) {
            //print_r($fecha_lectura);
            $this->tbl_inventario->insertar_fecha_lectura($row['codigo_rfid']);
            if (empty($fecha_lectura)) {
                $estado = "0";
                $no_encontrados++;
                $i++;
                $tabla .= '{"id":"' . $i . '","cod_producto":"' . $row['codigo_producto'] . '","cod_rfid":"' . $row['codigo_rfid'] . '","descripcion":"' . $row['descripcion'] . '","cliente":"' . $row['cliente'] . '","ubicacion":"' . $row['ubicacion'] . '","lote":"' . $row['lote'] . '","ancho":"' . $row['ancho'] . '","profundidad":"' . $row['profundidad'] . '","peso":"' . $row['peso'] . '","estado":"' . $estado . '","orden_ingreso":"' . $row['orden_ingreso'] . '","programacion":"' . $row['programacion'] . '","date":"' . $row['fecha_ingreso'] . '","no_encontrados":"' . $no_encontrados . '","total_activos":"' . $num_vinculados[0]["cant_vinculados"] . '"},';
            } else {
                $estado = "1";
                $encontrados++;
                $i++;
                $tabla .= '{"id":"' . $i . '","cod_producto":"' . $row['codigo_producto'] . '","cod_rfid":"' . $row['codigo_rfid'] . '","descripcion":"' . $row['descripcion'] . '","cliente":"' . $row['cliente'] . '","ubicacion":"' . $row['ubicacion'] . '","lote":"' . $row['lote'] . '","ancho":"' . $row['ancho'] . '","profundidad":"' . $row['profundidad'] . '","peso":"' . $row['peso'] . '","estado":"' . $estado . '","orden_ingreso":"' . $row['orden_ingreso'] . '","programacion":"' . $row['programacion'] . '","date":"' . $row['fecha_ingreso'] . '","encontrados":"' . $encontrados . '","total_activos":"' . $num_vinculados[0]["cant_vinculados"] . '"},';
            }
        }
        $tabla = substr($tabla, 0, strlen($tabla) - 1);
        /* header("Content-type: application/json");
        $result = '{"data":[' . $tabla . ']}';
        echo json_encode($result); */
        echo '{"data":[' . $tabla . ']}';
    }

    public function get_programacion_inventario()
    {
        $this->load->model('tbl_inventario_tiempo_real');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $tabla = "";
        $i = 0;
        $lista = $this->tbl_inventario_tiempo_real->get_inventario_programado();
        foreach ($lista as $row) {
            $i++;
            $tabla .= '{"indices":"' . $i . '","id":"' . $row['id'] . '","usuario":"' . $row['usuario'] . '","ubigeo":"' . $row['ubigeo'] . '","ubicacion":"' . $row['ubicacion'] . '","fecha_inventario":"' . $row['fecha_inventario'] . '","fecha_programacion":"' . $row['fecha_programacion'] . '","status":"' . $row['status'] . '"},';
        }
        $tabla = substr($tabla, 0, strlen($tabla) - 1);
        //header("Content-type: application/json");
        // echo json_encode($result);
        echo '{"data":[' . $tabla . ']}';
    }
    public function add_programacion_inventario()
    {
        $this->load->model('tbl_inventario_tiempo_real');
        $this->load->model('tbl_vinculacion');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        if ($_POST) {
            $user = $this->session->userdata('usuario');
            $fecha = $_POST["fecha"];
            $actividad = "INVENTARIADO";
            $actividad_actual = $this->tbl_vinculacion->get_actividad_actual($actividad);
            $ubigeo = $actividad_actual[0]["ubigeo"];
            $ubicacion = $actividad_actual[0]["ubicacion"];

            //INSERCIÓN EN BASE DE DATOS - SALIDAS MySql
            $data = array(
                'usuario' => $user,
                'fecha_inventario' => $fecha,
                'ubigeo' => $ubigeo,
                'ubicacion' => $ubicacion
            );
            try {
                $result =  $this->tbl_inventario_tiempo_real->add_programacion_inventario($data);
                if ($result)
                    $rpta = "Se agendo inventariado correctamente";
                else
                    $rpta = "Error al agendar inventariado";
            } catch (Exception $e) {
                $rpta = 'Error de Transacción';
            }
            echo json_encode(array("respuesta" => $rpta));
            // redirect('admin/tiemporeal/programacion_inventario_tiempo_real');
        }
    }
    public function reiniciar_inventariado_antiguo()
    {
        $this->load->model('tbl_inventario_tiempo_real');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $this->tbl_inventario_tiempo_real->update_estado_inventario();
        redirect('admin/tiemporeal/inventario_tiempo_real');
    }
    public function reiniciar_inventariado($id_inventario)
    {
        $this->load->model('tbl_inventario_tiempo_real');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $this->tbl_inventario_tiempo_real->update_estado_inventario();
        $this->tbl_inventario_tiempo_real->update_fecha_lectura_abc();
        redirect('admin/tiemporeal/inventario_tiempo_real/' . $id_inventario);
    }
    public function reiniciar_generar_recibo_deposito($correlativo)
    {
        $this->load->model('tbl_inventario_tiempo_real');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $this->tbl_inventario_tiempo_real->update_estado_inventario();
        $this->tbl_inventario_tiempo_real->update_fecha_lectura_abc();
        redirect('admin/inventario_tiempo_real/recibo_deposito/' . $correlativo);
    }
    public function reiniciar_preinventariado()
    {
        $this->load->model('tbl_inventario_tiempo_real');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $this->tbl_inventario_tiempo_real->update_estado_inventario();
        $this->tbl_inventario_tiempo_real->update_fecha_lectura_abc();
        redirect('admin/tiemporeal/preinventario_tiempo_real');
    }
    public function eliminar($cod_inventario)
    {
        $this->load->model('tbl_inventario_tiempo_real');
        $this->tbl_inventario_tiempo_real->eliminar($cod_inventario);
        //$this->tbl_inventario_tiempo_real->eliminar_inventario_realizado($cod_inventario);
        redirect('admin/tiemporeal/programacion_inventario_tiempo_real');
    }
    
    public function finalizar_inventario($id_inventario)
    {
        $this->load->model('tbl_alerta');
        $this->load->model('tbl_inventario_tiempo_real');
        $this->load->model('tbl_inventario');
        $this->load->model('tbl_vinculacion');
        $this->load->model('tbl_dispositivo_rfid');
        //$num_vinculados = $this->tbl_inventario->get_all_vinculados();
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $actividad = "INVENTARIADO";
        $atributos = $this->obj_vinculacion->get_actividad_actual("INVENTARIADO");
        $ubigeo = $atributos[0]["ubigeo"];
        $ubicacion = $atributos[0]["ubicacion"];
        $lista = $this->tbl_inventario_tiempo_real->get_lista_activos_matriculados_ubigeo_abc($ubigeo, $ubicacion);
        $c_encontrados = $this->tbl_alerta->get_encontrados_ubigeo_abc($ubigeo, $ubicacion)->encontrados;
        $c_no_encontrados = $this->tbl_alerta->get_no_encontrados_ubigeo_abc($ubigeo, $ubicacion)->no_encontrados;
        $id_inventario = $this->tbl_inventario_tiempo_real->id_inventario_tiempo_real($id_inventario);
        $fecha_finalizacion = date("Y-m-d H:i:s");
        $user = $this->session->userdata('usuario');
        $i = 0;
        $status = "0";
        print_r();
        foreach ($lista as $row) {
            // CARGAR INVENTARIO REALIZADO
            $this->tbl_inventario_tiempo_real->cargar_inventario_realizado($id_inventario[0]["id"], $row["nro_dua"], $row['guia_remision'], $row["item"], $row["codigo_producto"], $row["codigo_rfid"], $row["correlativo"], $row["ubigeo"], $row["ubicacion"], $row["cliente"], $row["familia_producto"], $row["descripcion"], $row["cantidad"], $row["unidad_medida"], $row["jefe_almacen"], $id_inventario[0]["fecha_inventario"], $row["fecha_ingreso"], $row["fecha_lectura"], $fecha_finalizacion);
            // CARGAR DETALLES DE INVENTARIO
            $this->tbl_inventario_tiempo_real->cargar_detalles_inventario($id_inventario[0]["id"], $row["correlativo"], $user, $row["jefe_almacen"], $row["ubigeo"], $row["ubicacion"], $row["cliente"], $row["fecha_ingreso"], $id_inventario[0]["fecha_inventario"], $status, $fecha_finalizacion);
        }
        $this->tbl_inventario_tiempo_real->actualizar_estado_inventario_realizado($id_inventario[0]["id"]);
        redirect('admin/inventario_tiempo_real/historial_inventarios');
    }
    public function generar_recibo($correlativo)
    {
        $this->load->model('tbl_inventario_tiempo_real');
        if ($this->tbl_inventario_tiempo_real->get_correlativo($correlativo) != null) {
            echo "<script>
                alert('EL RECIBO DE DEPÓSITO PARA ESTE PARTE YA HA SIDO GENERADO');
                window.location= 'admin/inventario_tiempo_real/recibos_generados'
            </script>";
        } else {
            $status = "0";
            $this->load->model('tbl_alerta');
            $this->load->model('tbl_inventario_tiempo_real');
            $this->load->model('tbl_inventario');
            $this->load->model('tbl_vinculacion');
            $this->load->model('tbl_dispositivo_rfid');
            //$num_vinculados = $this->tbl_inventario->get_all_vinculados();
            $this->load->tmp_admin->setLayout('templates/admin_tmp');
            $actividad = "RECIBO DE DEPOSITO";
            $atributos = $this->obj_vinculacion->get_actividad_actual($actividad);
            $c_encontrados = $this->tbl_inventario_tiempo_real->get_encontrados_correlativo($correlativo)->encontrados;
            $c_no_encontrados = $this->tbl_inventario_tiempo_real->get_no_encontrados_correlativo($correlativo)->no_encontrados;
            $total = $c_encontrados + $c_no_encontrados;
            //$this->tmp_admin->set('encontrados', $encontrados);
            $lista = $this->tbl_inventario_tiempo_real->get_lista_activos_matriculados_correlativo_abc($correlativo);
            $fecha_finalizacion = date("Y-m-d H:i:s");
            $user = $this->session->userdata('usuario');
            $i = 0;
            foreach ($lista as $row) {
                $i++;
                // CARGAR RECIBO DE DEPOSITO REALIZADO
                $this->tbl_inventario_tiempo_real->cargar_recibo_deposito_realizado($row["nro_dua"], $row['guia_remision'], $row["item"], $row["codigo_producto"], $row["codigo_rfid"], $row["correlativo"], $row["ubigeo"], $row["ubicacion"], $row["cliente"], $row["familia_producto"], $row["descripcion"], $row["cantidad"], $row["unidad_medida"], $row["jefe_almacen"], $row["fecha_ingreso"], $row["fecha_lectura"], $fecha_finalizacion);
                // CARGAR DETALLES DE RECIBO DE DEPOSITO
                $this->tbl_inventario_tiempo_real->cargar_detalles_recibo($row["correlativo"], $user, $row["jefe_almacen"], $row["ubigeo"], $row["ubicacion"], $row["cliente"], $row["fecha_ingreso"], $status, $fecha_finalizacion);
                $this->tbl_inventario_tiempo_real->update_partes_ingreso($correlativo);
            }
            redirect('admin/inventario_tiempo_real/recibos_generados');
        }
    }
    public function get_detalles_inventario()
    {
        $this->load->model('tbl_inventario_tiempo_real');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $tabla = "";
        $i = 0;
        $lista = $this->tbl_inventario_tiempo_real->get_tbl_detalles_inventario();
        /* echo "<pre>";
        print_r($lista);
        echo "</pre>"; */
        $registros = array();
        foreach ($lista as $row) {
            $i++;
            $registro = array();
            $registro["id"] = $i;
            $registro["id_inventario"] = $row["id_inventario"];
            $registro["correlativo"] = $row["correlativo"];
            $registro["cliente"] = $row["cliente"];
            $registro["ubigeo"] = $row["ubigeo"];
            $registro["ubicacion"] = $row["ubicacion"];
            $registro["usuario"] = $row["usuario"];
            $registro["jefe_almacen"] = $row["jefe_almacen"];
            $registro["fecha_programacion"] = $row["fecha_programacion"];
            $registro["fecha_finalizacion"] = $row["fecha_finalizacion"];
            $registro["status"] = $row["status"];
            $registros[] = $registro;
        }
        echo json_encode($registros);
    }
    public function get_detalles_recibo()
    {
        $this->load->model('tbl_inventario_tiempo_real');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $tabla = "";
        $i = 0;
        $lista = $this->tbl_inventario_tiempo_real->get_tbl_detalles_recibo();
        /* echo "<pre>";
        print_r($lista);
        echo "</pre>"; */
        $registros = array();
        foreach ($lista as $row) {
            $i++;
            $registro = array();
            $registro["id"] = $i;
            $registro["id_inventario"] = $row["id_inventario"];
            $registro["correlativo"] = $row["correlativo"];
            $registro["cliente"] = $row["cliente"];
            $registro["ubigeo"] = $row["ubigeo"];
            $registro["ubicacion"] = $row["ubicacion"];
            $registro["usuario"] = $row["usuario"];
            $registro["jefe_almacen"] = $row["jefe_almacen"];
            $registro["fecha_programacion"] = $row["fecha_programacion"];
            $registro["fecha_finalizacion"] = $row["fecha_finalizacion"];
            $registro["status"] = $row["status"];
            $registros[] = $registro;
        }
        echo json_encode($registros);
    }
    public function historial_inventarios()
    {
        $this->load->model('tbl_inventario_tiempo_real');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $this->load->tmp_admin->render('inventarios_realizados_view');
    }
    public function recibos_generados()
    {
        $this->load->model('tbl_inventario_tiempo_real');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $this->load->tmp_admin->render('recibos_deposito_generados_view');
    }
    public function get_vinculados()
    {
        $this->load->model('tbl_inventario');
        $num_vinculados = $this->tbl_inventario->get_all_vinculados();
        return $num_vinculados;
    }
    public function inve($id_inventario)
    {
        $this->load->model('tbl_alerta');
        $this->load->model('tbl_inventario_tiempo_real');
        $this->load->model('tbl_inventario');
        $this->load->model('tbl_vinculacion');

        $id_inventario = $this->tbl_inventario_tiempo_real->id_inventario_tiempo_real($id_inventario);
           
        $num_vinculados = $this->get_vinculados();
        $this->tmp_admin->set('num_vinculados', $num_vinculados[0]["cant_vinculados"]);
        $this->load->tmp_admin->set('id_inventario', $id_inventario[0]["id"]);
        $this->load->tmp_admin->render('inventario_tiempo_real_realizado_view');
    }
    public function recibo_nro($correlativo)
    {
        $this->load->model('tbl_alerta');
        $this->load->model('tbl_inventario_tiempo_real');
        $this->load->model('tbl_inventario');
        $this->load->model('tbl_vinculacion');
        $this->tmp_admin->set('correlativo', $correlativo);
        $this->load->tmp_admin->render('recibo_deposito_realizado_view');
    }
    public function get_inventario_realizado($id_inventario)
    {
        $this->load->model('tbl_inventario_tiempo_real');
        $this->load->model('tbl_inventario');
        $this->load->model('tbl_vinculacion');

        
        $actividad = "INVENTARIADO";
        $actividad = $this->tbl_vinculacion->get_actividad($actividad);
        $atributos = $this->obj_vinculacion->get_actividad_actual("INVENTARIADO");
        $ubigeo = $atributos[0]["ubigeo"];
        $ubicacion = $atributos[0]["ubicacion"];
        $tabla = "";
        $i = 0;

        $c_encontrados = $this->tbl_inventario_tiempo_real->get_encontrados_id_inventario($id_inventario)->encontrados;
        $c_no_encontrados = $this->tbl_inventario_tiempo_real->get_no_encontrados_id_inventario($id_inventario)->no_encontrados;
        //$this->tmp_admin->set('encontrados', $encontrados);
        $total = $c_encontrados + $c_no_encontrados;
        $lista = $this->tbl_inventario_tiempo_real->get_lista_inventario_realizado($id_inventario);
        //print_r($lista);
        $registros = array();
        foreach ($lista as $row) {
            $i++;
            $registro = array();
            $registro["id"] = $i;
            $registro["cod_producto"] = $row["codigo"];
            $registro["cod_rfid"] = $row["codigo_rfid"];
            $registro["descripcion"] = $row["descripcion"];
            $registro["correlativo"] = $row["correlativo"];
            $registro["cliente"] = $row["cliente"];
            $registro["ubigeo"] = $row["ubigeo"];
            $registro["ubicacion"] = $row["ubicacion"];
            $registro["nro_dua"] = $row["nro_dua"];
            $registro["guia_remision"] = $row["guia_remision"];
            $registro["item"] = $row["item"];
            $registro["familia_producto"] = $row["familia_producto"];
            $registro["date"] = $row["fecha_ingreso"];
            $registro["fecha_lectura"] = $row["fecha_lectura"];
            $registro["c_no_encontrados"] = $c_no_encontrados;
            $registro["c_encontrados"] = $c_encontrados;
            $registro["total_activos"] = $total;
            $registros[] = $registro;
        }
        echo '{"data": ' . json_encode($registros) . '}';
    }
    public function recibo_deposito($correlativo)
    {
        $this->load->model('tbl_vinculacion');
        $this->load->model('tbl_inventario_tiempo_real');
        $this->load->model('tbl_dispositivo_rfid');
        $actividad = "RECIBO DE DEPOSITO";
        /*
        $mac_asignada = $this->tbl_vinculacion->get_dispositivo_asignado_recibo_deposito($actividad);
        $mac_asignada = $mac_asignada[0]["mac"];
        $ultimo_mac = $this->tbl_dispositivo_rfid->get_list_ultimo_mac();
        $ultimo_mac = $ultimo_mac[0]["mac"];
        $ultimo_mac = substr($ultimo_mac, 7, 17);*/

        if ($this->tbl_vinculacion->get_dispositivo_asignado_recibo_deposito($actividad) == null) {
            echo "<script>
                alert('UD NO HA ASIGNADO UN DISPOSITIVO RFID PARA GENERAR RECIBO DE DEPOSITO');
            </script>";
            $this->load->tmp_admin->render('recibo_deposito_view');
            //redirect("admin/tiemporeal/recibo_deposito");
        } else if ($ultimo_mac != $mac_asignada) {
            echo "<script>
                alert('LA MAC ASIGNADA PARA ESTA ACTIVIDAD NO CORRESPONDE A LA QUE ACTUALMENTE UD ESTA UTILIZANDO');
            </script>";
            $this->load->tmp_admin->render('recibo_deposito_view');
        } else {
            $this->tbl_inventario_tiempo_real->update_estado_inventario();
            $this->tbl_inventario_tiempo_real->update_fecha_lectura_abc();
            $this->load->tmp_admin->set('correlativo', $correlativo);
            $this->load->tmp_admin->render('recibo_deposito_tiempo_real_view');
        }
    }
    public function generar_recibo_deposito($correlativo)
    {
        $this->load->model('tbl_alerta');
        $this->load->model('tbl_inventario_tiempo_real');
        $this->load->model('tbl_inventario');
        $this->load->model('tbl_vinculacion');
        $this->load->model('tbl_dispositivo_rfid');
        //$num_vinculados = $this->tbl_inventario->get_all_vinculados();
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $actividad = "RECIBO DE DEPOSITO";
        $c_encontrados = $this->tbl_inventario_tiempo_real->get_encontrados_correlativo_tr($correlativo)->encontrados;
        $c_no_encontrados = $this->tbl_inventario_tiempo_real->get_no_encontrados_correlativo_tr($correlativo)->no_encontrados;
        $total = $c_encontrados + $c_no_encontrados;
        //$this->tmp_admin->set('encontrados', $encontrados);
        $lista = $this->tbl_inventario_tiempo_real->get_lista_activos_matriculados_correlativo_abc($correlativo);
        $mac_asignada = $this->tbl_vinculacion->get_dispositivo_asignado_recibo_deposito($actividad);
        $mac_asignada = $mac_asignada[0]["mac"];
        //print_r($mac_asignada);
        $ultimo_mac = $this->tbl_dispositivo_rfid->get_list_ultimo_mac();
        $ultimo_mac = $ultimo_mac[0]["mac"];
        $ultimo_mac = substr($ultimo_mac, 7, 17);
        //print_r($ultimo_mac);
        // DISCRIMINACION DE DISPOSITIVO RFID
        if ($ultimo_mac == $mac_asignada) {
            //print_r($lista);
            $registros = array();
            $i = 0;
            foreach ($lista as $row) {
                $fecha_lectura = $this->tbl_alerta->get_fecha_chip($row['codigo_rfid']);
                //print_r($fecha_lectura);
                if (empty($fecha_lectura)) {
                    $this->tbl_inventario->insertar_fecha_lectura_abc($row['id'], "");
                    $i++;
                    $registro = array();
                    $registro["id"] = $i;
                    $registro["cod_producto"] = $row["codigo_producto"];
                    $registro["cod_rfid"] = $row["codigo_rfid"];
                    $registro["descripcion"] = $row["descripcion"];
                    $registro["correlativo"] = $row["correlativo"];
                    $registro["cliente"] = $row["cliente"];
                    $registro["valor"] = $row["valor"];
                    $registro["ubigeo"] = $row["ubigeo"];
                    $registro["ubicacion"] = $row["ubicacion"];
                    $registro["nro_dam"] = $row["nro_dam"];
                    $registro["guia_remision"] = $row["guia_remision"];
                    $registro["nro_operacion"] = $row["nro_operacion"];
                    $registro["item"] = $row["item"];
                    $registro["familia_producto"] = $row["familia_producto"];
                    $registro["programacion"] = $row["programacion"];
                    $registro["date"] = $row["fecha_ingreso"];
                    $registro["fecha_lectura"] = $row["fecha_lectura"];
                    $registro["c_no_encontrados"] = $c_no_encontrados;
                    $registro["total_activos"] = $total;
                    $registros[] = $registro;
                } else {
                    $this->tbl_inventario->insertar_fecha_lectura_abc($row['id'], $fecha_lectura[0]["fecha_lectura"]);
                    $i++;
                    $registro = array();
                    $registro["id"] = $i;
                    $registro["cod_producto"] = $row["codigo_producto"];
                    $registro["cod_rfid"] = $row["codigo_rfid"];
                    $registro["descripcion"] = $row["descripcion"];
                    $registro["correlativo"] = $row["correlativo"];
                    $registro["cliente"] = $row["cliente"];
                    $registro["valor"] = $row["valor"];
                    $registro["ubigeo"] = $row["ubigeo"];
                    $registro["ubicacion"] = $row["ubicacion"];
                    $registro["nro_dam"] = $row["nro_dam"];
                    $registro["guia_remision"] = $row["guia_remision"];
                    $registro["nro_operacion"] = $row["nro_operacion"];
                    $registro["item"] = $row["item"];
                    $registro["familia_producto"] = $row["familia_producto"];
                    $registro["programacion"] = $row["programacion"];
                    $registro["date"] = $row["fecha_ingreso"];
                    $registro["fecha_lectura"] = $row["fecha_lectura"];
                    $registro["c_no_encontrados"] = $c_no_encontrados;
                    $registro["c_encontrados"] = $c_encontrados;
                    $registro["total_activos"] = $total;
                    $registros[] = $registro;
                }
            }
            echo '{"data": ' . json_encode($registros) . '}';
        }
    }

    public function get_recibo_deposito($correlativo)
    {

        $this->load->model('tbl_alerta');
        $this->load->model('tbl_inventario_tiempo_real');
        $this->load->model('tbl_inventario');
        $this->load->model('tbl_vinculacion');
        $this->load->model('tbl_dispositivo_rfid');
        //$num_vinculados = $this->tbl_inventario->get_all_vinculados();
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $actividad = "RECIBO DE DEPOSITO";
        $c_encontrados = $this->tbl_inventario_tiempo_real->get_encontrados_correlativo($correlativo)->encontrados;
        $c_no_encontrados = $this->tbl_inventario_tiempo_real->get_no_encontrados_correlativo($correlativo)->no_encontrados;
        $total = $c_encontrados + $c_no_encontrados;
        //$this->tmp_admin->set('encontrados', $encontrados);
        $lista = $this->tbl_inventario_tiempo_real->get_lista_recibo_realizado($correlativo);

        //print_r($lista);
        $registros = array();
        $i = 0;
        foreach ($lista as $row) {
            $i++;
            $registro = array();
            $registro["id"] = $i;
            $registro["cod_producto"] = $row["codigo"];
            $registro["cod_rfid"] = $row["codigo_rfid"];
            $registro["descripcion"] = $row["descripcion"];
            $registro["correlativo"] = $row["correlativo"];
            $registro["cliente"] = $row["cliente"];
            $registro["ubigeo"] = $row["ubigeo"];
            $registro["ubicacion"] = $row["ubicacion"];
            $registro["guia_remision"] = $row["guia_remision"];
            $registro["item"] = $row["item"];
            $registro["familia_producto"] = $row["familia_producto"];
            $registro["date"] = $row["fecha_ingreso"];
            $registro["fecha_lectura"] = $row["fecha_lectura"];
            $registro["c_no_encontrados"] = $c_no_encontrados;
            $registro["c_encontrados"] = $c_encontrados;
            $registro["total_activos"] = $total;
            $registros[] = $registro;
        }
        echo '{"data": ' . json_encode($registros) . '}';
    }



    public function logout()
    {
        $this->session->unset_userdata('logged');
        redirect('admin');
    }
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */