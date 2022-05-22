<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Vinculacion extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('tbl_usuario', 'obj_usuario');
        // creo objeto inventario
        $this->load->model('tbl_inventario', 'obj_inventario');
        $this->load->model('tbl_vinculacion', 'obj_vinculo');
        if ($this->session->userdata('logged') != 'true') {
            redirect('login');
        }
    }

    public function tabla_vinculacion()
    {
        $this->load->model('tbl_vinculacion');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $this->load->tmp_admin->render('vinculacion_actual_view');
    }

    public function elegir_ubigeo_ubicacion()
    {
        $this->load->model('tbl_vinculacion');
        //$ubigeo = $this->obj_inventario->get_ubigeo();
        $atributos = $this->obj_vinculo->get_atributos_actividad("PROGRAMACION DE SALIDA");
        $this->load->tmp_admin->set('atributos', $atributos);
        //print_r($atributos);
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $this->load->tmp_admin->render('programar_salidas_view');
        // $this->load->tmp_admin->render('programar_dar_salida_automatica_view');
    }
    public function listar_ubicacion()
    {
        $this->load->model('tbl_vinculacion');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $ubigeo = $_POST['ubigeo'];
        $actividad = "PROGRAMACION DE SALIDA";
        $ubicacion = $this->obj_vinculo->get_ubicacion_ubigeo($ubigeo, $actividad);
        $ubicacion = $ubicacion[0]["ubicacion"];
        //print_r($ubicacion);
        $arrayResult = $ubicacion;
        echo json_encode($arrayResult);
    }
      public function listar_ubicacion2()
    {
        $this->load->model('tbl_vinculacion');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $ubigeo = $_POST['ubigeo'];
        $actividad = "SALIDA DE ACTIVOS";
        $ubicacion = $this->obj_vinculo->get_ubicacion_ubigeo($ubigeo, $actividad);
        $ubicacion = $ubicacion[0]["ubicacion"];
        //print_r($ubicacion);
        $arrayResult = $ubicacion;
        echo json_encode($arrayResult);
    }
    
    
    public function listar_ubicacion_tiempo_real()
    {
        $this->load->model('tbl_vinculacion');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $ubigeo = $_POST['ubigeo'];
        $actividad = "SALIDA DE ACTIVOS";
        $ubicacion = $this->obj_vinculo->get_ubicacion_ubigeo($ubigeo, $actividad);
        $ubicacion = $ubicacion[0]["ubicacion"];
        //print_r($ubicacion);
        $arrayResult = $ubicacion;
        echo json_encode($arrayResult);
    }
    public function limpiar_casillas()
    {
        $this->load->model('tbl_inventario_tiempo_real');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $this->tbl_inventario_tiempo_real->update_estado_inventario();
        $this->tbl_inventario_tiempo_real->update_fecha_lectura_abc();
        $this->load->tmp_admin->render('programar_salida_automatica_view');
    }

    public function programar_salida_automatica()
    {
        $this->load->model('tbl_dispositivo_rfid');
        //$this->load->model('tbl_inventario_tiempo_real');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        /* $this->tbl_inventario_tiempo_real->update_estado_inventario();
        $this->tbl_inventario_tiempo_real->update_fecha_lectura(); */
        $this->load->tmp_admin->render('programar_salida_automatica_view');
    }
    public function programar_salida_manual()
    {
        $this->load->model('tbl_dispositivo_rfid');
        $atributos = $this->obj_vinculo->get_atributos_actividad("SALIDA DE ACTIVOS");
        $this->load->tmp_admin->set('atributos', $atributos);
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $this->load->tmp_admin->render('programar_salida_manual_view');
    }

    public function vinculacion_masiva()
    {
        $this->load->model('tbl_vinculacion');
        if (1 == 1) {
            $rpta = "CONFIRMACIÓN EXITOSA!!!";
        } else {
            $rpta = "ERROR AL CONFIRMAR LECTURAS!!!";
        }
        echo $rpta;
    }

    public function programacion_automatica()
    {
        $this->load->model('tbl_alerta');
        $this->load->model('tbl_inventario');
        $this->load->model('tbl_vinculacion');
        $this->load->model('tbl_inventario_tiempo_real');
        $this->load->model('tbl_dispositivo_rfid');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        //$lista = $this->tbl_inventario_tiempo_real->get_lista_activos_matriculados();
        $actividad = "PROGRAMACION DE SALIDA";
        $actividad_actual = $this->tbl_vinculacion->get_actividad_actual($actividad);
        $ubigeo = $actividad_actual[0]["ubigeo"];
        $ubicacion = $actividad_actual[0]["ubicacion"];
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
            echo "SIIII COINCIDEN LAS MAC";
            foreach ($lista as $row) {
                $fecha_lectura = $this->tbl_alerta->get_fecha_chip($row['codigo_rfid']);
                //print_r($fecha_lectura);
                $status_programado = "1";
                $status_no_programado = "0";
                if (empty($fecha_lectura)) {
                    $this->tbl_inventario->insertar_estado_lectura_abc($row['id'], $status_no_programado);
                    $this->tbl_inventario->insertar_fecha_lectura_abc($row['id'], "");
                } else {
                    $this->tbl_inventario->insertar_estado_lectura_abc($row['id'], $status_programado);
                    $this->tbl_inventario->insertar_fecha_lectura_abc($row['id'], $fecha_lectura[0]["fecha_lectura"]);
                }
            }
        }
    }
    public function agendar()
    {
        if ($_POST) {
            $elegido = $_POST["elegido"]; //array de codigos productos
            //print_r($elegido);
            $fecha = $_POST["fecha"];

            //INSERCIÓN EN BASE DE DATOS - SALIDAS MySql
            foreach ($elegido as $indice => $id) {
                //print_r($id);
                $this->load->model('tbl_vinculacion');
                $this->load->model('tbl_inventario');
                $atributos_producto = $this->obj_vinculo->get_atributos_vinculado_producto_abc($id);
                /* echo "<pre>";
                print_r($atributos_producto);
                echo "</pre>"; */
                $atributos_cod_rfid = $this->obj_vinculo->get_atributos_vinculado_cod_rfid($id);
                $status = "1";
                $status_salida = "0";
                $orden_salida = $fecha . "--" . $atributos_producto[0]['codigo'] . "-" . $atributos_producto[0]['item'];
                $data = array(
                    'codigo_rfid' => $atributos_cod_rfid[0]['codigo_rfid'],
                    'codigo_producto' => $atributos_producto[0]['codigo'],
                    'id_activo' => $atributos_producto[0]['id'],
                    'descripcion' => $atributos_producto[0]['descripcion'],
                    'guia_remision' => $atributos_producto[0]['guia_remision'],
                    'orden_salida' => $orden_salida,
                    'fecha_salida' => $fecha,
                    'estado_salida' => $status_salida
                );
                try {
                    $result =  $this->tbl_vinculacion->add_salida($data);
                    $result1 = $this->tbl_inventario->update_status_programacion_abc($id, $status);
                    //$result2 = $this->tbl_vinculacion->update_status_salida($cod_producto, $status_salida);
                    if ($result and $result1)
                        $rpta = "Se agendo correctamente";
                    else
                        $rpta = "Error al agendar salida";
                } catch (Exception $e) {
                    $rpta = 'Error de Transacción';
                }
            }
            echo json_encode(array("respuesta" => $rpta));
            //echo $rpta;
            //redirect('admin/vinculacion/eliminar_vinculo');
        }
    }
    public function vincular_activos()
    {
        $this->load->model('tbl_vinculacion');
        //importando datos de la tabla inventario
        $inventarios = $this->obj_inventario->get_lista_inventario_no_vinculados();

        //enviando la variable a la vista
        $this->tmp_admin->set("inventarios", $inventarios);

        //llamar a laplantalla
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $this->load->tmp_admin->render('vincular_activos_view');
    }
    public function ver_salidas()
    {
        $this->load->model('tbl_inventario');

        //llamar a laplantalla
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $this->load->tmp_admin->render('ver_salidas_view');
    }
    public function eliminar_vinculo()
    {
        $this->load->model('tbl_vinculacion');
        $atributos = $this->obj_vinculo->get_atributos_actividad("PROGRAMACION DE SALIDA");
        $this->load->tmp_admin->set('atributos', $atributos);
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $this->load->tmp_admin->render('eliminar_vinculo_view');
    }
    public function salidas_automaticas_tiempo_real()
    {
        $this->load->model('tbl_vinculacion');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $atributos = $this->obj_vinculo->get_atributos_actividad("SALIDA DE ACTIVOS");
        $this->load->tmp_admin->set('atributos', $atributos);
        $this->load->tmp_admin->render('programar_dar_salida_automatica_view');
    }
    public function salidas_tiempo_real()
    {
        $this->load->model('tbl_vinculacion');
        $this->load->model('tbl_inventario_tiempo_real');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $this->tbl_inventario_tiempo_real->update_estado_inventario();
        $this->tbl_inventario_tiempo_real->update_fecha_lectura_abc();
        $this->load->tmp_admin->render('salidas_automaticas_view');
    }
    public function get_activos_matriculados_programados_ubigeo()
    {
        $this->load->model('tbl_alerta');
        $this->load->model('tbl_inventario_tiempo_real');
        $this->load->model('tbl_inventario');
        $this->load->model('tbl_vinculacion');
        $this->load->model('tbl_dispositivo_rfid');
        //$num_vinculados = $this->tbl_inventario->get_all_vinculados();
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $atributos = $this->obj_vinculo->get_actividad_actual("SALIDA DE ACTIVOS");
        $ubigeo = $atributos[0]["ubigeo"];
        $ubicacion = $atributos[0]["ubicacion"];
        $num_vinculados = $this->tbl_vinculacion->get_all_activos_programados_ubigeo_ubicacion($ubigeo, $ubicacion);
        //print_r($num_vinculados);
        $tabla = "";
        $i = 0;
        //$this->tmp_admin->set('encontrados', $encontrados);
        $lista = $this->tbl_vinculacion->get_lista_activos_matriculados_programados_ubigeo($ubigeo, $ubicacion);
        $c_encontrados = $this->tbl_vinculacion->get_encontrados_programados_ubigeo($ubigeo, $ubicacion)->encontrados;
        $c_no_encontrados = $this->tbl_vinculacion->get_no_encontrados_programados_ubigeo($ubigeo, $ubicacion)->no_encontrados;
        $actividad = "SALIDA DE ACTIVOS";
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
                    $fecha_salida = $this->obj_vinculo->get_fecha_orden_salida($row['codigo_producto']);
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
                    $registro["orden_salida"] = $fecha_salida[0]["orden_salida"];
                    $registro["programacion"] = $row["programacion"];
                    $registro["date"] = $row["fecha_ingreso"];
                    $registro["fecha_lectura"] = $row["fecha_lectura"];
                    $registro["c_no_encontrados"] = $c_no_encontrados;
                    $registro["total_activos"] = $num_vinculados[0]["cant_vinculados"];
                    $registros[] = $registro;
                    //$tabla .= '{"id":"' . $i . '","cod_producto":"' . $row['codigo_producto'] . '","cod_rfid":"' . $row['codigo_rfid'] . '","descripcion":"' . $row['descripcion'] . '","valor":"' . $row['valor'] . '","cliente":"' . $row['cliente'] . '","ubigeo":"' . $row['ubigeo'] . '","ubicacion":"' . $row['ubicacion'] . '","lote":"' . $row['lote'] . '","ancho":"' . $row['ancho'] . '","profundidad":"' . $row['profundidad'] . '","peso":"' . $row['peso'] . '","orden_ingreso":"' . $row['orden_ingreso'] . '","orden_salida":"' . $fecha_salida[0]["orden_salida"] . '","programacion":"' . $row['programacion'] . '","date":"' . $row['fecha_ingreso'] . '","fecha_lectura":"' . $row['fecha_lectura'] . '","c_no_encontrados":"' . $c_no_encontrados . '","total_activos":"' . $num_vinculados[0]["cant_vinculados"] . '"},';
                } else {
                    $this->tbl_inventario->insertar_fecha_lectura($row['codigo_producto'], $fecha_lectura[0]["fecha_lectura"]);
                    $fecha_salida = $this->obj_vinculo->get_fecha_orden_salida($row['codigo_producto']);
                    $i++;;
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
                    $registro["orden_salida"] = $fecha_salida[0]["orden_salida"];
                    $registro["programacion"] = $row["programacion"];
                    $registro["date"] = $row["fecha_ingreso"];
                    $registro["fecha_lectura"] = $row["fecha_lectura"];
                    $registro["c_no_encontrados"] = $c_no_encontrados;
                    $registro["c_encontrados"] = $c_encontrados;
                    $registro["total_activos"] = $num_vinculados[0]["cant_vinculados"];
                    $registros[] = $registro;
                    //$tabla .= '{"id":"' . $i . '","cod_producto":"' . $row['codigo_producto'] . '","cod_rfid":"' . $row['codigo_rfid'] . '","descripcion":"' . $row['descripcion'] . '","valor":"' . $row['valor'] . '","cliente":"' . $row['cliente'] . '","ubigeo":"' . $row['ubigeo'] . '","ubicacion":"' . $row['ubicacion'] . '","lote":"' . $row['lote'] . '","ancho":"' . $row['ancho'] . '","profundidad":"' . $row['profundidad'] . '","peso":"' . $row['peso'] . '","orden_ingreso":"' . $row['orden_ingreso'] . '","orden_salida":"' . $fecha_salida[0]["orden_salida"] . '","programacion":"' . $row['programacion'] . '","date":"' . $row['fecha_ingreso'] . '","fecha_lectura":"' . $row['fecha_lectura'] . '","c_no_encontrados":"' . $c_no_encontrados . '","c_encontrados":"' . $c_encontrados . '","total_activos":"' . $num_vinculados[0]["cant_vinculados"] . '"},';
                    sleep(2);
                    // ELIMINANDO LA VINCULACION
                    $this->eliminar_tiempo_real($row['codigo_rfid']);
                }
            }
            //$tabla = substr($tabla, 0, strlen($tabla) - 1);
            //echo '{"data":[' . $tabla . ']}';
            echo '{"data": ' . json_encode($registros) . '}';
        } else {
            $this->load->model('tbl_inventario_tiempo_real');
            $this->load->tmp_admin->setLayout('templates/admin_tmp');
            $fecha_lectura = "";
            $tabla = "";
            $i = 0;
            $registros = array();
            $lista = $this->tbl_vinculacion->get_lista_activos_matriculados_programados_ubigeo($ubigeo, $ubicacion);
            foreach ($lista as $row) {
                $fecha_salida = $this->obj_vinculo->get_fecha_orden_salida($row['codigo_producto']);
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
                $registro["orden_salida"] = $fecha_salida[0]["orden_salida"];
                $registro["programacion"] = $row["programacion"];
                $registro["date"] = $row["fecha_ingreso"];
                $registro["fecha_lectura"] = $row["fecha_lectura"];
                $registro["c_no_encontrados"] = $c_no_encontrados;
                $registro["total_activos"] = $num_vinculados[0]["cant_vinculados"];
                $registros[] = $registro;
                //$tabla .= '{"id":"' . $i . '","cod_producto":"' . $row['codigo_producto'] . '","cod_rfid":"' . $row['codigo_rfid'] . '","descripcion":"' . $row['descripcion'] . '","valor":"' . $row['valor'] . '","cliente":"' . $row['cliente'] . '","ubigeo":"' . $row['ubigeo'] . '","ubicacion":"' . $row['ubicacion'] . '","lote":"' . $row['lote'] . '","ancho":"' . $row['ancho'] . '","profundidad":"' . $row['profundidad'] . '","peso":"' . $row['peso'] . '","orden_ingreso":"' . $row['orden_ingreso'] . '","orden_salida":"' . $fecha_salida[0]["orden_salida"] . '","programacion":"' . $row['programacion'] . '","date":"' . $row['fecha_ingreso'] . '","fecha_lectura":"' . $fecha_lectura . '","c_no_encontrados":"' . $c_no_encontrados . '","total_activos":"' . $num_vinculados[0]["cant_vinculados"] . '"},';
            }
            //$tabla = substr($tabla, 0, strlen($tabla) - 1);
            //echo '{"data":[' . $tabla . ']}';
            echo '{"data": ' . json_encode($registros) . '}';
        }
    }

    public function get_activos_matriculados_programados_ubigeo_abc()
    {
        $this->load->model('tbl_alerta');
        $this->load->model('tbl_inventario_tiempo_real');
        $this->load->model('tbl_inventario');
        $this->load->model('tbl_vinculacion');
        $this->load->model('tbl_dispositivo_rfid');
        //$num_vinculados = $this->tbl_inventario->get_all_vinculados();
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $atributos = $this->obj_vinculo->get_actividad_actual("SALIDA DE ACTIVOS");
        $ubigeo = $atributos[0]["ubigeo"];
        $ubicacion = $atributos[0]["ubicacion"];
        $num_vinculados = $this->tbl_vinculacion->get_all_activos_programados_ubigeo_ubicacion_abc($ubigeo, $ubicacion);
        //print_r($num_vinculados);
        $tabla = "";
        $i = 0;
        //$this->tmp_admin->set('encontrados', $encontrados);
        $lista = $this->tbl_vinculacion->get_lista_activos_matriculados_programados_ubigeo_abc($ubigeo, $ubicacion);
        $c_encontrados = $this->tbl_vinculacion->get_encontrados_programados_ubigeo_abc($ubigeo, $ubicacion)->encontrados;
        $c_no_encontrados = $this->tbl_vinculacion->get_no_encontrados_programados_ubigeo_abc($ubigeo, $ubicacion)->no_encontrados;
        $actividad = "SALIDA DE ACTIVOS";
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
                    $fecha_salida = $this->obj_vinculo->get_fecha_orden_salida($row['id']);
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
                    $registro["nro_dam"] = $row["nro_dam"];
                    $registro["guia_remision"] = $row["guia_remision"];
                    $registro["nro_operacion"] = $row["nro_operacion"];
                    $registro["item"] = $row["item"];
                    $registro["familia_producto"] = $row["familia_producto"];
                    $registro["programacion"] = $row["programacion"];
                    $registro["orden_salida"] = $fecha_salida[0]["orden_salida"];
                    $registro["programacion"] = $row["programacion"];
                    $registro["date"] = $row["fecha_ingreso"];
                    $registro["fecha_lectura"] = $row["fecha_lectura"];
                    $registro["c_no_encontrados"] = $c_no_encontrados;
                    $registro["total_activos"] = $num_vinculados[0]["cant_vinculados"];
                    $registros[] = $registro;
                    //$tabla .= '{"id":"' . $i . '","cod_producto":"' . $row['codigo_producto'] . '","cod_rfid":"' . $row['codigo_rfid'] . '","descripcion":"' . $row['descripcion'] . '","valor":"' . $row['valor'] . '","cliente":"' . $row['cliente'] . '","ubigeo":"' . $row['ubigeo'] . '","ubicacion":"' . $row['ubicacion'] . '","lote":"' . $row['lote'] . '","ancho":"' . $row['ancho'] . '","profundidad":"' . $row['profundidad'] . '","peso":"' . $row['peso'] . '","orden_ingreso":"' . $row['orden_ingreso'] . '","orden_salida":"' . $fecha_salida[0]["orden_salida"] . '","programacion":"' . $row['programacion'] . '","date":"' . $row['fecha_ingreso'] . '","fecha_lectura":"' . $row['fecha_lectura'] . '","c_no_encontrados":"' . $c_no_encontrados . '","total_activos":"' . $num_vinculados[0]["cant_vinculados"] . '"},';
                } else {
                    //print_r($row['id']);
                    //echo "entro donde deberia entrar";
                    $this->tbl_inventario->insertar_fecha_lectura_abc($row['id'], $fecha_lectura[0]["fecha_lectura"]);
                    $fecha_salida = $this->obj_vinculo->get_fecha_orden_salida($row['id']);
                    //print_r($fecha_salida);
                    $i++;;
                    $registro = array();
                    $registro["id"] = $i;
                    $registro["cod_producto"] = $row["codigo_producto"];
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
                    $registro["orden_salida"] = $fecha_salida[0]["orden_salida"];
                    $registro["programacion"] = $row["programacion"];
                    $registro["date"] = $row["fecha_ingreso"];
                    $registro["fecha_lectura"] = $row["fecha_lectura"];
                    $registro["c_no_encontrados"] = $c_no_encontrados;
                    $registro["c_encontrados"] = $c_encontrados;
                    $registro["total_activos"] = $num_vinculados[0]["cant_vinculados"];
                    $registros[] = $registro;
                    //$tabla .= '{"id":"' . $i . '","cod_producto":"' . $row['codigo_producto'] . '","cod_rfid":"' . $row['codigo_rfid'] . '","descripcion":"' . $row['descripcion'] . '","valor":"' . $row['valor'] . '","cliente":"' . $row['cliente'] . '","ubigeo":"' . $row['ubigeo'] . '","ubicacion":"' . $row['ubicacion'] . '","lote":"' . $row['lote'] . '","ancho":"' . $row['ancho'] . '","profundidad":"' . $row['profundidad'] . '","peso":"' . $row['peso'] . '","orden_ingreso":"' . $row['orden_ingreso'] . '","orden_salida":"' . $fecha_salida[0]["orden_salida"] . '","programacion":"' . $row['programacion'] . '","date":"' . $row['fecha_ingreso'] . '","fecha_lectura":"' . $row['fecha_lectura'] . '","c_no_encontrados":"' . $c_no_encontrados . '","c_encontrados":"' . $c_encontrados . '","total_activos":"' . $num_vinculados[0]["cant_vinculados"] . '"},';
                    sleep(2);
                    // ELIMINANDO LA VINCULACION
                    $this->eliminar_tiempo_real($row['codigo_rfid']);
                }
            }
            //$tabla = substr($tabla, 0, strlen($tabla) - 1);
            //echo '{"data":[' . $tabla . ']}';
            echo '{"data": ' . json_encode($registros) . '}';
        } else {
            $this->load->model('tbl_inventario_tiempo_real');
            $this->load->tmp_admin->setLayout('templates/admin_tmp');
            $fecha_lectura = "";
            $tabla = "";
            $i = 0;
            $registros = array();
            $lista = $this->tbl_vinculacion->get_lista_activos_matriculados_programados_ubigeo_abc($ubigeo, $ubicacion);
            foreach ($lista as $row) {
                $fecha_salida = $this->obj_vinculo->get_fecha_orden_salida($row['id']);
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
                $registro["orden_salida"] = $fecha_salida[0]["orden_salida"];
                $registro["programacion"] = $row["programacion"];
                $registro["date"] = $row["fecha_ingreso"];
                $registro["fecha_lectura"] = $row["fecha_lectura"];
                $registro["c_no_encontrados"] = $c_no_encontrados;
                $registro["total_activos"] = $num_vinculados[0]["cant_vinculados"];
                $registros[] = $registro;
                //$tabla .= '{"id":"' . $i . '","cod_producto":"' . $row['codigo_producto'] . '","cod_rfid":"' . $row['codigo_rfid'] . '","descripcion":"' . $row['descripcion'] . '","valor":"' . $row['valor'] . '","cliente":"' . $row['cliente'] . '","ubigeo":"' . $row['ubigeo'] . '","ubicacion":"' . $row['ubicacion'] . '","lote":"' . $row['lote'] . '","ancho":"' . $row['ancho'] . '","profundidad":"' . $row['profundidad'] . '","peso":"' . $row['peso'] . '","orden_ingreso":"' . $row['orden_ingreso'] . '","orden_salida":"' . $fecha_salida[0]["orden_salida"] . '","programacion":"' . $row['programacion'] . '","date":"' . $row['fecha_ingreso'] . '","fecha_lectura":"' . $fecha_lectura . '","c_no_encontrados":"' . $c_no_encontrados . '","total_activos":"' . $num_vinculados[0]["cant_vinculados"] . '"},';
            }
            //$tabla = substr($tabla, 0, strlen($tabla) - 1);
            //echo '{"data":[' . $tabla . ']}';
            echo '{"data": ' . json_encode($registros) . '}';
        }
    }

    public function get_activos_matriculados_fecha_salida()
    {
        $this->load->model('tbl_vinculacion');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $tabla = "";
        $i = 0;
        //print_r($elegido);

       $ubigeo =$this->input->post('ubigeo');
       $ubicacion =$this->input->post('ubicacion');
       $fecha =$this->input->post('fecha');
  
        $lista = $this->tbl_vinculacion->get_lista_activos_matriculados_fecha_salida($ubigeo,$ubicacion,$fecha);

        echo "<pre>";
        print_r($lista);
        echo "</pre>"; 
        foreach ($lista as $row) {
            $fecha_salida = $this->obj_vinculo->get_fecha_orden_salida($row['id']);
            if (empty($fecha_salida)) {
                $i++;
                $tabla .= '{"item":"' . $i . '","id":"' . $row['id'] . '","cod_producto":"' . $row['codigo_producto'] . '","cod_rfid":"' . $row['codigo_rfid'] . '","descripcion":"' . $row['descripcion'] . '","estado":"' . $row['estado'] . '","orden_ingreso":"' . $row['orden_ingreso'] . '","guia_remision":"' . $row['guia_remision'] . '","programacion":"' . $row['programacion'] . '","date":"' . $row['fecha_ingreso'] . '"},';
            } else {
                $i++;
                $tabla .= '{"item":"' . $i . '","id":"' . $row['id'] . '","cod_producto":"' . $row['codigo_producto'] . '","cod_rfid":"' . $row['codigo_rfid'] . '","descripcion":"' . $row['descripcion'] . '","estado":"' . $row['estado'] . '","orden_ingreso":"' . $row['orden_ingreso'] . '","guia_remision":"' . $row['guia_remision'] . '","programacion":"' . $row['programacion'] . '","fecha_salida":"' . $fecha_salida[0]["fecha_salida"] . '","orden_salida":"' . $fecha_salida[0]["orden_salida"] . '","date":"' . $row['fecha_ingreso'] . '"},';
            }
        }
            /*echo "<pre>";
        print_r($tabla);
        echo "</pre>" */;
        $tabla = substr($tabla, 0, strlen($tabla) - 1);
        //header("Content-type: application/json");
        // echo json_encode($result);
        echo '{"data":[' . $tabla . ']}';
    }

    public function get_lista_vinculacion_masiva()
    {
        //$this->form_validation->set_rules('ubigeo', 'ubigeo', 'trim|required'); // importante para que funcione el codigo
        //$this->form_validation->set_message('required', 'Este campo es requerido');
        $this->load->model('tbl_vinculacion');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');

        $tabla = "";
        $i = 0;
        $lista = $this->tbl_vinculacion->get_lista_vinculacion_masiva();
        //print_r($lista);
        $registros = array();
        foreach ($lista as $row) {
            $i++;
            $registro = array();
            $registro["id"] = $row["id_mov"];
            $registro["indice"] = $i;
            $registro["cod_rfid"] = $row["codigo_rfid"];
            $registro["date"] = $row["fecha"];
            $registros[] = $registro;
            //$tabla .= '{"id":"' . $i . '","cod_producto":"' . $row['codigo_producto'] . '","cod_rfid":"' . $row['codigo_rfid'] . '","descripcion":"' . $row['descripcion'] . '","cliente":"' . $row['cliente'] . '","ubigeo":"' . $row['ubigeo'] . '","ubicacion":"' . $row['ubicacion'] . '","lote":"' . $row['lote'] . '","ancho":"' . $row['ancho'] . '","profundidad":"' . $row['profundidad'] . '","peso":"' . $row['peso'] . '","estado":"' . $row['estado'] . '","orden_ingreso":"' . $row['orden_ingreso'] . '","programacion":"' . $row['programacion'] . '","date":"' . $row['fecha_ingreso'] . '","estado_lectura":"' . $row['estado_lectura'] . '"},';
        }
        //$tabla = substr($tabla, 0, strlen($tabla) - 1);
        //echo '{"data":[' . $tabla . ']}';
        /* header("Content-type: application/json");
            echo json_encode('{"data":[' . $tabla . ']}'); */
        echo json_encode($registros);
    }

    public function vinculacion_masiva_tags($id,$correlativo)
    {
        $this->load->model('tbl_vinculacion');
        $this->load->model('tbl_inventario');
        $this->form_validation->set_rules('codigo_producto', 'CODIGO', 'trim|required');
        $this->form_validation->set_message('required', 'Este campo es requerido');
        if ($this->form_validation->run($this) == FALSE) {
            $codigo = $this->obj_inventario->get_cod_inventario_parte_ingreso($id,$correlativo);
            //print_r($codigo);
            $this->load->tmp_admin->set('codigo', $codigo);
            $this->load->tmp_admin->render('vinculacion_masiva_view');
            //print_r($codigo);
            //print_r($this->input->post('codigo_producto'));
        } else {
            // NUMERO DE CHIPS LEIDOS PARA LA VINCULACION MASIVA
            $nro_chips_leidos = $this->obj_inventario->numero_chips_vinculacion_masiva();
            $nro_chips_leidos = $nro_chips_leidos[0]["cant_chips_leidos"];
            //print_r($nro_chips_leidos);
            // CANTIDAD DE ACTIVOS X ITEMS
            $cantidad_items = $this->obj_inventario->get_items_x_id($id);
            //print_r($cantidad_items);
            $cantidad_items = $cantidad_items[0]["cantidad"];
            // CANTIDAD DE ACTIVOS VINCULADOS X ITEMS
            $cantidad_items_vinculados_x_item = $this->obj_inventario->numero_items_vinculados($id,$correlativo);
            $cantidad_items_vinculados_x_item = $cantidad_items_vinculados_x_item[0]["cant_vinculados_x_item"];
            // SI LA CANTIDAD DE CHIPS LEIDOS ES MENOS O IGUAL AL NUMERO DE ITEMS DEL ID HACER PROCESO
            if ($nro_chips_leidos <= $cantidad_items) {
                if($cantidad_items_vinculados_x_item < $cantidad_items){
                    $i = 0;
                    $lista = $this->tbl_vinculacion->get_lista_vinculacion_masiva();
                    //print_r($lista);
                    $tags_vinculados = array();
                    foreach ($lista as $row) {
                        if (!empty($this->tbl_vinculacion->get_cod_rfid_vinculado($row['codigo_rfid'])) && !empty($this->tbl_inventario->get_ultimo_id())) {
                            $i++;
                            $tags = array();
                            $tags[$i] = $row['codigo_rfid'];
                            $tags_vinculados[] = $tags;
                            $rpta = "Las sgtes ETIQUETAS RFID estan VINCULADAS: " . json_encode($tags_vinculados) . " !!!!!";
                        } else {
                            $ultimo_id = 0;
                            if (empty($this->tbl_inventario->get_ultimo_id())) {
                                //print_r((string)((int)$ultimo_id[0]["id"] + 1));
                                $i++;
                                $data = array(
                                    'codigo_rfid' => $row["codigo_rfid"],
                                    'codigo_producto' => $this->input->post('codigo_producto'),
                                    'id_activo' => (string)($ultimo_id + 1),
                                    'status' => '1',
                                    'fecha_vinculacion' => date('Y-m-d H:i:s')
                                );
                                $data1 = array(
                                    'correlativo' => $this->input->post('parte_ingreso'),
                                    'nro_dua' => $this->input->post('nro_dua'),
                                    'guia_remision' => $this->input->post('guia_remision'),
                                    'item' => $this->input->post('item'),
                                    'codigo' => $this->input->post('codigo_producto'),
                                    'id' => (string)((int)$ultimo_id + 1),
                                    'ubigeo' => $this->input->post('ubigeo'),
                                    'ubicacion' => $this->input->post('ubicacion'),
                                    'cliente' => $this->input->post('cliente'),
                                    'familia_producto' => $this->input->post('familia_producto'),
                                    'descripcion' => $this->input->post('descripcion'),
                                    'unidad_medida' => $this->input->post('unidad_medida'),
                                    'cantidad' => $this->input->post('cantidad'),
                                    'observaciones' => $this->input->post('observaciones'),
                                    'jefe_almacen' => $this->input->post('jefe_almacen'),
                                    'estado' => '1',
                                    'estado_salida' => '0',
                                    'programacion' => '0',
                                    'fecha_ingreso' => date("Y-m-d H:i:s")
                                );
                                //print_r($data);
                                try {
                                    $status = "1";
                                    $update_status =  $this->obj_inventario->update_status_abc((string)((int)$ultimo_id + 1), $status);
                                    $result =  $this->tbl_vinculacion->add_vinculacion($data);
                                    $result1 =  $this->tbl_inventario->add_activo_abc($data1);
                                    if ($result and $result1)
                                        $rpta = "Vinculación MASIVA exitosa!!!";
                                    else
                                        $rpta = "Error en Vinculación MASIVA";
                                } catch (Exception $e) {
                                    $rpta = 'Error de Transacción';
                                }
                                //redirect('admin/vinculacion/tabla_vinculacion'); // donde lo puedo poner, porque a la hora que vinCule quiero que me muestre la lista 
                            } else {
                                $ultimo_id = $this->tbl_inventario->get_ultimo_id();
                                //print_r((string)((int)$ultimo_id[0]["id"] + 1));
                                $i++;
                                $data = array(
                                    'codigo_rfid' => $row["codigo_rfid"],
                                    'codigo_producto' => $this->input->post('codigo_producto'),
                                    'id_activo' => (string)((int)$ultimo_id[0]["id"] + 1),
                                    'status' => '1',
                                    'fecha_vinculacion' => date('Y-m-d H:i:s')
                                );
                                $data1 = array(
                                    'correlativo' => $this->input->post('parte_ingreso'),
                                    'nro_dua' => $this->input->post('nro_dua'),
                                    'guia_remision' => $this->input->post('guia_remision'),
                                    'item' => $this->input->post('item'),
                                    'codigo' => $this->input->post('codigo_producto'),
                                    'id' => (string)((int)$ultimo_id[0]["id"] + 1),
                                    'ubigeo' => $this->input->post('ubigeo'),
                                    'ubicacion' => $this->input->post('ubicacion'),
                                    'cliente' => $this->input->post('cliente'),
                                    'familia_producto' => $this->input->post('familia_producto'),
                                    'descripcion' => $this->input->post('descripcion'),
                                    'unidad_medida' => $this->input->post('unidad_medida'),
                                    'cantidad' => $this->input->post('cantidad'),
                                    'observaciones' => $this->input->post('observaciones'),
                                    'jefe_almacen' => $this->input->post('jefe_almacen'),
                                    'estado' => '1',
                                    'estado_salida' => '0',
                                    'programacion' => '0',
                                    'fecha_ingreso' => date("Y-m-d H:i:s")
                                );
                                //print_r($data);
                                try {
                                    $status = "1";
                                    $update_status =  $this->obj_inventario->update_status_abc((string)((int)$ultimo_id[0]["id"] + 1), $status);
                                    $result =  $this->tbl_vinculacion->add_vinculacion($data);
                                    $result1 =  $this->tbl_inventario->add_activo_abc($data1);
                                    if ($result and $result1)
                                        $rpta = "Vinculación MASIVA exitosa!!!";
                                    else
                                        $rpta = "Error en Vinculación MASIVA";
                                } catch (Exception $e) {
                                    $rpta = 'Error de Transacción';
                                }
                                //redirect('admin/vinculacion/tabla_vinculacion'); // donde lo puedo poner, porque a la hora que vinCule quiero que me muestre la lista 
                            }
                    }
                    }
                }
                else{
                    $rpta = "CANTIDAD DE CHIPS A VINCULAR ES MAYOR A LA CANTIDAD de CHIPS VINCULADOS A ESTE ITEM";
                }
            } else {
                $rpta = "LA CANTIDAD DE CHIPS A VINCULAR ES MAYOR A LA CANTIDAD X ITEM";
            }
            echo $rpta;
        }
    }

    public function get_activos_matriculados_ubigeo()
    {
        //$this->form_validation->set_rules('ubigeo', 'ubigeo', 'trim|required'); // importante para que funcione el codigo
        //$this->form_validation->set_message('required', 'Este campo es requerido');
        $this->load->model('tbl_inventario');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $atributos = $this->obj_vinculo->get_actividad_actual("PROGRAMACIÓN DE SALIDA");
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
        $registros = array();
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
            $registro["estado_lectura"] = $row["estado_lectura"];
            $registros[] = $registro;
            //$tabla .= '{"id":"' . $i . '","cod_producto":"' . $row['codigo_producto'] . '","cod_rfid":"' . $row['codigo_rfid'] . '","descripcion":"' . $row['descripcion'] . '","cliente":"' . $row['cliente'] . '","ubigeo":"' . $row['ubigeo'] . '","ubicacion":"' . $row['ubicacion'] . '","lote":"' . $row['lote'] . '","ancho":"' . $row['ancho'] . '","profundidad":"' . $row['profundidad'] . '","peso":"' . $row['peso'] . '","estado":"' . $row['estado'] . '","orden_ingreso":"' . $row['orden_ingreso'] . '","programacion":"' . $row['programacion'] . '","date":"' . $row['fecha_ingreso'] . '","estado_lectura":"' . $row['estado_lectura'] . '"},';
        }
        //$tabla = substr($tabla, 0, strlen($tabla) - 1);
        //echo '{"data":[' . $tabla . ']}';
        /* header("Content-type: application/json");
            echo json_encode('{"data":[' . $tabla . ']}'); */
        echo json_encode($registros);
    }
    public function get_activos_matriculados_ubigeo_abc()
    {
        //$this->form_validation->set_rules('ubigeo', 'ubigeo', 'trim|required'); // importante para que funcione el codigo
        //$this->form_validation->set_message('required', 'Este campo es requerido');
        $this->load->model('tbl_inventario');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $atributos = $this->obj_vinculo->get_actividad_actual("PROGRAMACIÓN DE SALIDA");
        $ubigeo = $atributos[0]["ubigeo"];
        $ubicacion = $atributos[0]["ubicacion"];
        //$ubigeo = $this->input->post('ubigeo');
        //$ubigeo = "LOS OLIVOS";
        /* print_r($ubigeo);
        print_r($ubicacion); */
        $tabla = "";
        $i = 0;
        $lista = $this->tbl_inventario->get_lista_activos_matriculados_ubigeo_abc($ubigeo, $ubicacion);
        //print_r($lista);
        $registros = array();
        foreach ($lista as $row) {
            $i++;
            $registro = array();
            $registro["indice"] = $i;
            $registro["id"] = $row["id"];
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
            $registro["estado_lectura"] = $row["estado_lectura"];
            $registros[] = $registro;
            //$tabla .= '{"id":"' . $i . '","cod_producto":"' . $row['codigo_producto'] . '","cod_rfid":"' . $row['codigo_rfid'] . '","descripcion":"' . $row['descripcion'] . '","cliente":"' . $row['cliente'] . '","ubigeo":"' . $row['ubigeo'] . '","ubicacion":"' . $row['ubicacion'] . '","lote":"' . $row['lote'] . '","ancho":"' . $row['ancho'] . '","profundidad":"' . $row['profundidad'] . '","peso":"' . $row['peso'] . '","estado":"' . $row['estado'] . '","orden_ingreso":"' . $row['orden_ingreso'] . '","programacion":"' . $row['programacion'] . '","date":"' . $row['fecha_ingreso'] . '","estado_lectura":"' . $row['estado_lectura'] . '"},';
        }
        //$tabla = substr($tabla, 0, strlen($tabla) - 1);
        //echo '{"data":[' . $tabla . ']}';
        /* header("Content-type: application/json");
            echo json_encode('{"data":[' . $tabla . ']}'); */
        echo json_encode($registros);
    }
    public function agregar_actividad_salida()
    {
        $this->load->model('tbl_vinculacion');
        $data = array(
            'ubigeo' => $this->input->post('ubigeo'),
            'ubicacion' => $this->input->post('ubicacion'),
            'actividad' => "SALIDA DE ACTIVOS"
        );
        try {
            $result =  $this->tbl_vinculacion->add_actividad_actual($data);
            if ($result)
                $rpta = "REDIRECCIONANDO ...";
            else
                $rpta = "Error al guardar la información";
        } catch (Exception $e) {
            $rpta = 'Error de Transacción';
        }
        echo json_encode(array("respuesta" => $rpta));
    }
      public function agregar_actividad2()
    {
        $this->load->model('tbl_vinculacion');
        $data = array(
            'ubigeo' => $this->input->post('ubigeo'),
            'ubicacion' => $this->input->post('ubicacion'),
            'actividad' => "PROGRAMACION DE SALIDA"
        );

        try {
            $result =  $this->tbl_vinculacion->add_actividad_actual($data);
            if ($result)
                $rpta = "REDIRECCIONANDO ...";
            else
                $rpta = "Error al guardar la información";
        } catch (Exception $e) {
            $rpta = 'Error de Transacción';
        }

        echo json_encode(array("respuesta" => $rpta));
    }
    public function agregar_actividad()
    {
        $this->load->model('tbl_vinculacion');
        $data = array(
            'ubigeo' => $this->input->post('ubigeo'),
            'ubicacion' => $this->input->post('ubicacion'),
            'actividad' => "PROGRAMACION DE SALIDA"
        );

        try {
            $result =  $this->tbl_vinculacion->add_actividad_actual($data);
            if ($result)
                $rpta = "REDIRECCIONANDO ...";
            else
                $rpta = "Error al guardar la información";
        } catch (Exception $e) {
            $rpta = 'Error de Transacción';
        }
        /**
         * Agregando add_programacion_inventario
         */

         $this->load->model('tbl_inventario_tiempo_real');
        $this->load->model('tbl_vinculacion');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        if ($_POST) {
            $user = $this->session->userdata('usuario');
            $fecha = $_POST["fechaAgendar"];
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
            redirect('admin/tiemporeal/programacion_inventario_tiempo_real');
            //redirect('admin/tiemporeal/inventario_tiempo_real');
        }

        /**
        * Agregando add_programacion_inventario
         */


        // echo json_encode(array("respuesta" => $rpta));
    }
    public function get_activos_matriculados()
    {
        $this->load->model('tbl_inventario');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
            $data = array(
            'ubigeo' => $this->input->post('ubigeo'),
            'ubicacion' => $this->input->post('ubicacion'),
            'fecha' =>  $this->input->post('fecha')
        );
$ubigeo = $this->input->post('ubigeo');
$ubicacion = $this->input->post('ubicacion');
   $fecha = $this->input->post('fecha');

        $tabla = "";
        $i = 0;
        $lista = $this->tbl_inventario->get_lista_activos_matriculados($ubigeo,$ubicacion,$fecha);
        //print_r($lista);
        foreach ($lista as $row) {
            $i++;
            $tabla .= '{"item":"' . $i . '","id":"' . $row['id'] . '","cod_producto":"' . $row['codigo_producto'] . '","cod_rfid":"' . $row['codigo_rfid'] . '","descripcion":"' . $row['descripcion'] . '","cliente":"' . $row['cliente'] . '","ubigeo":"' . $row['ubigeo'] . '","ubicacion":"' . $row['ubicacion'] . '","lote":"' . $row['lote'] . '","ancho":"' . $row['ancho'] . '","profundidad":"' . $row['profundidad'] . '","peso":"' . $row['peso'] . '","estado":"' . $row['estado'] . '","orden_ingreso":"' . $row['orden_ingreso'] . '","programacion":"' . $row['programacion'] . '","date":"' . $row['fecha_ingreso'] . '","estado_lectura":"' . $row['estado_lectura'] . '"},';
        }
        $tabla = substr($tabla, 0, strlen($tabla) - 1);
        //header("Content-type: application/json");
        // echo json_encode($result);
        echo '{"data":[' . $tabla . ']}';
    }
    public function get_salida_activos_matriculados()
    {
        $this->load->model('tbl_vinculacion');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $tabla = "";
        $i = 0;
        $lista = $this->tbl_vinculacion->get_lista_activos_con_salida();
        foreach ($lista as $row) {
            $i++;
            $tabla .= '{"id":"' . $i . '","cod_producto":"' . $row['codigo_producto'] . '","cod_rfid":"' . $row['codigo_rfid'] . '","descripcion":"' . $row['descripcion'] . '","orden_ingreso":"' . $row['orden_ingreso'] . '","item":"' . $row['item'] . '","guia_remision":"' . $row['guia_remision'] . '","orden_salida":"' . $row['orden_salida'] . '","fecha_salida":"' . $row['fecha_salida'] . '","fecha_ingreso":"' . $row['fecha_ingreso'] . '"},';
        }
        $tabla = substr($tabla, 0, strlen($tabla) - 1);
        //header("Content-type: application/json");
        // echo json_encode($result);
        echo '{"data":[' . $tabla . ']}';
    }

    public function guardar_vinculacion()
    {
        $this->load->model('tbl_vinculacion');
        $data = array(
            'codigo_rfid' => $this->input->post('codigo_sensor'),
            'cod_inventario' => $this->input->post('rodillo'),
            'fecha_vinculacion' => date('Y-m-d H:i:s')
        );
        try {
            $result =  $this->tbl_vinculacion->add_vinculacion($data);
            if ($result)
                $rpta = "Se guardó correctamente";
            else
                $rpta = "Error al guardar la información";
        } catch (Exception $e) {
            $rpta = 'Error de Transacción';
        }
        echo $rpta; // donde lo puedo poner, porque a la hora que vinule quiero que me mestre la lista 
    }

    public function vincular_activo_x($id_activo)
    {
        $this->load->model('tbl_vinculacion');
        $this->form_validation->set_rules('codigo_producto', 'CODIGO', 'trim|required');
        $this->form_validation->set_message('required', 'Este campo es requerido');
        if ($this->form_validation->run($this) == FALSE) {

            $codigo = $this->obj_inventario->get_cod_inventario_abc($id_activo);
            $this->load->tmp_admin->set('codigo', $codigo);
            $this->load->tmp_admin->render('vincular_activo_x_view');
            //print_r($codigo);
            //print_r($this->input->post('codigo_producto'));
        } else {
            $codigo_rfid = $this->obj_vinculo->get_cod_rfid_vinculado($this->input->post('rfid'));
            //print_r($codigo_rfid);
            // !!!!  ETIQUETA YA VINCULADA
            if ($codigo_rfid != null) {
                $rpta = "Esta Etiqueta RFID ya esta VINCULADA!!!!";
            } else {
                $data = array(
                    'codigo_rfid' => $this->input->post('rfid'),
                    'codigo_producto' => $this->input->post('codigo_producto'),
                    'id_activo' => $id_activo,
                    'status' => '1',
                    'fecha_vinculacion' => date('Y-m-d H:i:s')
                );
                //print_r($data);
                try {
                    $status = "1";
                    $update_status =  $this->obj_inventario->update_status_abc($id_activo, $status);
                    $result =  $this->tbl_vinculacion->add_vinculacion($data);
                    if ($result)
                        $rpta = "Vinculación exitosa!!!";
                    else
                        $rpta = "Error al vincular Activo";
                } catch (Exception $e) {
                    $rpta = 'Error de Transacción';
                }
                //redirect('admin/vinculacion/tabla_vinculacion'); // donde lo puedo poner, porque a la hora que vinCule quiero que me muestre la lista 
            }
            echo $rpta;
        }
    }
    public function vincular_activos_item($id_activo)
    {
        $this->load->model('tbl_vinculacion');
        $this->form_validation->set_rules('codigo_producto', 'CODIGO', 'trim|required');
        $this->form_validation->set_message('required', 'Este campo es requerido');
        if ($this->form_validation->run($this) == FALSE) {

            $codigo = $this->obj_inventario->get_cod_inventario_parte_ingreso($id_activo);
            $this->load->tmp_admin->set('codigo', $codigo);
            $this->load->tmp_admin->render('vinculacion_masiva_view');
            //print_r($codigo);
            //print_r($this->input->post('codigo_producto'));
        } else {
            $codigo_rfid = $this->obj_vinculo->get_cod_rfid_vinculado($this->input->post('rfid'));
            //print_r($codigo_rfid);
            // !!!!  ETIQUETA YA VINCULADA
            if ($codigo_rfid != null) {
                $rpta = "Esta Etiqueta RFID ya esta VINCULADA!!!!";
            } else {
                $data = array(
                    'codigo_rfid' => $this->input->post('rfid'),
                    'codigo_producto' => $this->input->post('codigo_producto'),
                    'id_activo' => $id_activo,
                    'status' => '1',
                    'fecha_vinculacion' => date('Y-m-d H:i:s')
                );
                //print_r($data);
                try {
                    $status = "1";
                    $update_status =  $this->obj_inventario->update_status_abc($id_activo, $status);
                    $result =  $this->tbl_vinculacion->add_vinculacion($data);
                    if ($result)
                        $rpta = "Vinculación exitosa!!!";
                    else
                        $rpta = "Error al vincular Activo";
                } catch (Exception $e) {
                    $rpta = 'Error de Transacción';
                }
                //redirect('admin/vinculacion/tabla_vinculacion'); // donde lo puedo poner, porque a la hora que vinCule quiero que me muestre la lista 
            }

            echo $rpta;
        }
    }

    public function eliminar($cod_rfid)
    {
        $this->load->model('tbl_vinculacion');
        $this->load->model('tbl_inventario');
        $orden_salida = $this->obj_vinculo->get_orden_salida($cod_rfid);
        //print_r($orden_salida);
        if (empty($orden_salida)) {
            $cod_producto = $this->obj_vinculo->get_cod_producto($cod_rfid);
            //print_r($cod_producto);
            $atributos_producto = $this->obj_vinculo->get_atributos_vinculado_producto_abc($cod_producto[0]["id_activo"]);
            print_r($atributos_producto);
            $status_salida = "1";
            $status = "0";
            $fecha = date('Y-m-d H:m:s');
            echo "<pre>";
            print_r($fecha);
            echo "</pre>";
            $orden_salida = $fecha . "--" . $cod_producto[0]["codigo_producto"];
            $data = array(
                'codigo_rfid' => $cod_rfid,
                'codigo_producto' => $cod_producto[0]["codigo_producto"],
                'descripcion' => $atributos_producto[0]['descripcion'],
                'orden_ingreso' => $atributos_producto[0]['orden_ingreso'],
                'orden_salida' => $orden_salida,
                'fecha_salida' => $fecha,
                'estado_salida' => $status_salida
            );
            try {
                $this->tbl_vinculacion->add_salida($data);
                $this->obj_inventario->update_status_salida($cod_producto[0]["codigo_producto"], $status_salida);
                $this->tbl_inventario->update_status_programacion_abc($cod_producto[0]["codigo_producto"], $status);
                $this->obj_inventario->update_status_abc($cod_producto[0]["codigo_producto"], $status);
                $this->obj_vinculo->eliminar($cod_rfid);
                redirect('admin/vinculacion/eliminar_vinculo');
            } catch (Exception $e) {
                $rpta = 'Error de Transacción';
            }
        } else {
            $status = "0";
            $status1 = "1";
            $cod_producto = $this->obj_vinculo->get_cod_producto($cod_rfid);
            //print_r($cod_producto);
            $this->obj_vinculo->eliminar($cod_rfid);
            $this->obj_inventario->update_status_salida($cod_producto[0]["id_activo"], $status1);
            $this->obj_inventario->update_status_abc($cod_producto[0]["id_activo"], $status);
            $this->tbl_inventario->update_status_programacion_abc($cod_producto[0]["id_activo"], $status);
            $this->obj_vinculo->update_status_salida($cod_rfid, $status1);
            redirect('admin/vinculacion/eliminar_vinculo');
        }
    }
    public function eliminacion_masiva_activos()
    {
        $this->load->model('tbl_vinculacion');
        $this->load->model('tbl_inventario');
        if ($_POST) {
            $elegido = $_POST["elegido"]; //array de id de los activos matriculados
            //print_r($elegido);
            foreach ($elegido as $indice => $id) {
                try {
                    $result = $this->tbl_inventario->eliminar($id);
                    //$cod_rfid = $this->tbl_vinculacion->get_cod_rfid_vinculado_editar($id);
                    //$result1 = $this->tbl_vinculacion->eliminar($cod_rfid[0]["codigo_rfid"]);
                    $result1 = $this->tbl_vinculacion->eliminar_x_id($id);
                    if ($result and $result1)
                        $rpta = "Eliminacion Masiva Correcta";
                    else
                        $rpta = "Error al eliminar activos";
                } catch (Exception $e) {
                    $rpta = 'Error de Transacción';
                }
            }
            echo json_encode(array("respuesta" => $rpta));
            //echo $rpta;
            //redirect('admin/vinculacion/eliminar_vinculo');
        }
    }

    public function eliminar_tiempo_real($cod_rfid)
    {
        $this->load->model('tbl_vinculacion');
        $this->load->model('tbl_inventario');
        $orden_salida = $this->obj_vinculo->get_orden_salida($cod_rfid);
        //print_r($orden_salida);
        if (!empty($orden_salida)) {
            $cod_producto = $this->obj_vinculo->get_cod_producto($cod_rfid);
            $id_producto = $this->obj_vinculo->get_id_producto($cod_rfid);
            //print_r($cod_producto);
            $atributos_producto = $this->obj_vinculo->get_atributos_vinculado_producto_abc($id_producto[0]["id_activo"]);
            //print_r($atributos_producto);
            $status_salida = "1";
            $status = "0";
            $fecha = date('Y-m-d H:m:s');
            /* echo "<pre>";
            print_r($fecha);
            echo "</pre>"; */
            $orden_salida = $fecha . "--" . $atributos_producto[0]["codigo"] . "--" . $atributos_producto[0]["item"];
            $data = array(
                'codigo_rfid' => $cod_rfid,
                'codigo_producto' =>  $atributos_producto[0]['codigo'],
                'descripcion' => $atributos_producto[0]['descripcion'],
                'id_activo' => $atributos_producto[0]['id'],
                'orden_ingreso' => $atributos_producto[0]['orden_ingreso'],
                'guia_remision' => $atributos_producto[0]['guia_remision'],
                'orden_salida' => $orden_salida,
                'fecha_salida' => $fecha,
                'estado_salida' => $status_salida
            );
            try {
                $this->tbl_vinculacion->add_salida($data);
                $this->obj_inventario->update_status_salida_abc($id_producto[0]["id_activo"], $status_salida);
                $this->tbl_inventario->update_status_programacion_abc($id_producto[0]["id_activo"], $status);
                $this->obj_inventario->update_status_abc($id_producto[0]["id_activo"], $status);
                $this->obj_vinculo->eliminar($cod_rfid);
                //redirect('admin/vinculacion/ver_salidas');
            } catch (Exception $e) {
                $rpta = 'Error de Transacción';
            }
        }
    }
    public function eliminar_masiva($cod_inventario, $item,$correlativo)
    {
        $this->obj_vinculo->eliminar_masiva($cod_inventario);
        $codigo = $this->obj_inventario->get_cod_inventario_parte_ingreso($item,$correlativo);
        $this->load->tmp_admin->set('codigo', $codigo);
        redirect('admin/vinculacion/vinculacion_masiva_tags/' . $item.'/'.$correlativo);
        //$this->load->tmp_admin->render('vinculacion_masiva_view');
    }

    public function limpiar_tabla_masiva()
    {
        $this->load->model('tbl_vinculacion');
        if ($this->tbl_vinculacion->limpiar_tabla_masiva()) {
            $rpta = "REGISTROS LIMPIOS!";
        } else {
            $rpta = "!!!ERROR AL LIMPIAR REGISTROS!!!";
        }
        echo $rpta;
    }

    public function logout()
    {
        $this->session->unset_userdata('logged');
        redirect('admin');
    }
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */