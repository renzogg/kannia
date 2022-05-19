<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Inventario extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('tbl_usuario', 'obj_usuario');
        $this->load->model('tbl_inventario', 'obj_inventario');
        $this->load->model('tbl_vinculacion', 'obj_vinculacion');
        $this->load->model('tbl_carga_excel', 'obj_excel');
        if ($this->session->userdata('logged') != 'true') {
            redirect('login');
        }
    }
    public function index()
    {
        $this->load->model('tbl_inventario');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $datos_inve = $this->obj_inventario->get_lista_inventario();

        $this->load->tmp_admin->set('datos_inve', $datos_inve);
        $this->load->tmp_admin->render('inventario_view');
    }

    public function inventario_actual()
    {
        $this->load->model('tbl_inventario');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $this->load->tmp_admin->render('inventario_view');
    }
    public function activos_matriculados()
    {
        $this->load->model('tbl_inventario');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $this->load->tmp_admin->render('activos_matriculados_view');
    }
   
    public function partes_ingreso()
    {
        $this->load->model('tbl_inventario');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $this->load->tmp_admin->render('partes_ingreso_view');
    }
    public function ingresar_activos()
    {
        $this->load->model('tbl_inventario');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $clientes = $this->obj_inventario->get_clientes();
        /* echo "<pre>";
        //print_r($clientes[0]["cliente"]);
        print_r($clientes);
        echo "</pre>"; */
        $this->load->tmp_admin->set('clientes', $clientes);
        $ubigeo = $this->obj_inventario->get_ubigeo();
        //print_r($ubigeo);
        $id_ubigeo = $this->obj_inventario->get_id_ubigeo("SJL");
        //print_r($id_ubigeo);
        //$ubicacion = $this->obj_inventario->get_ubicacion($id_ubigeo);
        $ubicacion = $this->obj_inventario->get_ubicacion();
        //print_r($ubicacion);
        $this->load->tmp_admin->set('ubigeo', $ubigeo);
        $this->load->tmp_admin->set('ubicacion', $ubicacion);
        $this->load->tmp_admin->render('ingresar_activo_abc_view');
    }
    public function listar_ubicaciones()
    {
        $this->load->model('tbl_inventario');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $ubigeo = $_POST['ubigeo'];
        $id_ubigeo = $this->obj_inventario->get_id_ubigeo($ubigeo);
        //print_r($id_ubigeo);
        $ubicacion = $this->obj_inventario->get_ubicacion_ubigeo($id_ubigeo[0]["id_ubigeo"]);
        $arrayResult = $ubicacion;
        //print_r($ubicacion);
        echo json_encode($arrayResult);
    }
    public function editar_activos()
    {
        $this->load->model('tbl_inventario');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $this->load->tmp_admin->render('editar_eliminar_inventario_view');
    }
    public function eliminacion_masiva()
    {
        $this->load->model('tbl_inventario');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $this->load->tmp_admin->render('eliminar_inventario_masivo_view');
    }
    public function vinculacion_1x1()
    {
        $this->load->model('tbl_inventario');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $this->load->tmp_admin->render('vincular_activos_abc_view');
    }
    public function ver_items($correlativo)
    {
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $this->load->tmp_admin->set('correlativo', $correlativo);
        $this->load->tmp_admin->render('items_view');
    }
    public function ver_items_parte_ingreso($correlativo)
    {
        $this->load->model('tbl_inventario');
        $this->load->model('tbl_carga_excel');
        //$correlativo =  $this->tbl_carga_excel->get_ultimo_parte_ingreso();
        //$lista = $this->tbl_carga_excel->get_items_parte_ingreso_correlativo($correlativo[0]["correlativo"]);
        $lista = $this->tbl_carga_excel->get_items_parte_ingreso_correlativo($correlativo);
        $registros = array();
        $i = 0;
        foreach ($lista as $row) {
            $i++;
            $registro = array();
            $registro["id"] = $i;
            $registro["nro_dua"] = $row["nro_dua"];
            $registro["guia_remision"] = $row["guia_remision"];
            $registro["nro_operacion"] = $row["nro_operacion"];
            $registro["item"] = $row["item"];
            $activos_vinculados = $this->tbl_inventario->numero_items_vinculados($row["item"],$row["correlativo"]);
            //print_r($activos_vinculados);
            if($activos_vinculados[0]["cant_vinculados_x_item"] == 0){
                $registro["estado_items"] = "0";
            }
            else{
                $activos_x_items = $this->tbl_inventario->get_activos_item($row["item"],$row["correlativo"]);
                if($activos_x_items[0]["cantidad"] > $activos_vinculados[0]["cant_vinculados_x_item"]){
                    $registro["estado_items"] = "1";
                }
                else{
                    $registro["estado_items"] = "0";
                }
            }
            $registro["codigo"] = $row["codigo"];
            $registro["correlativo"] = $row["correlativo"];
            $registro["ubigeo"] = $row["ubigeo"];
            $registro["ubicacion"] = $row["ubicacion"];
            $registro["cliente"] = $row["cliente"];
            $registro["familia_producto"] = $row["familia_producto"];
            $registro["descripcion"] = $row["descripcion"];
            $registro["cantidad"] = $row["cantidad"];
            $registro["unidad_medida"] = $row["unidad_medida"];
            $registro["fecha_ingreso"] = $row["fecha_ingreso"];
            $registro["fecha_parte"] = $row["fecha_parte"];
            $registro["jefe_almacen"] = $row["jefe_almacen"];
            $registro["observaciones"] = $row["observaciones"];
            $registro["estado"] = $row["estado"];
            $registros[] = $registro;
        }
        echo '{"data": ' . json_encode($registros) . '}';
        //echo json_encode($registros);     
    }

    public function tabla_inventario()
    {
        $this->load->model('tbl_inventario');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $this->load->tmp_admin->render('inventario_view');
    }
    public function cargar_activos()
    {
        $this->load->model('tbl_carga_excel');
        $clientes = $this->obj_inventario->get_clientes();
        /* echo "<pre>";
        //print_r($clientes[0]["cliente"]);
        print_r($clientes);
        echo "</pre>"; */
        $this->load->tmp_admin->set('clientes', $clientes);
        $ubigeo = $this->obj_inventario->get_ubigeo();
        //print_r($ubigeo);
        //$ubicacion = $this->obj_inventario->get_ubicacion($id_ubigeo);
        $ubicacion = $this->obj_inventario->get_ubicacion();
        //print_r($ubicacion);
        $this->load->tmp_admin->set('ubigeo', $ubigeo);
        $this->load->tmp_admin->set('ubicacion', $ubicacion);
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $this->load->tmp_admin->render('cargar_activos_excel_view');
    }
    public function cargar_parte_ingreso()
    {
        $this->load->model('tbl_carga_excel');
        $clientes = $this->obj_inventario->get_clientes();
        /* echo "<pre>";
        //print_r($clientes[0]["cliente"]);
        print_r($clientes);
        echo "</pre>"; */
        $this->load->tmp_admin->set('clientes', $clientes);
        $ubigeo = $this->obj_inventario->get_ubigeo();
        //print_r($ubigeo);
        //$ubicacion = $this->obj_inventario->get_ubicacion($id_ubigeo);
        $ubicacion = $this->obj_inventario->get_ubicacion();
        //print_r($ubicacion);
        $this->load->tmp_admin->set('ubigeo', $ubigeo);
        $this->load->tmp_admin->set('ubicacion', $ubicacion);
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $this->load->tmp_admin->render('cargar_parte_ingreso_excel_view');
    }
    public function cargar_activos_excel()
    {
        $this->load->model('tbl_carga_excel');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        extract($_POST);
        if (isset($_POST['action'])) {
            $action = $_POST['action'];
        }
        if (isset($action) == "upload") {
            //echo "entro";
            //Limpio tabla carga_excel
            $this->load->model('tbl_carga_excel');
            $this->tbl_carga_excel->limpiar_tabla_excel();
            //cargamos el fichero
            $archivo = $_FILES['excel']['name'];
            $tipo = $_FILES['excel']['type'];
            $destino = "cop_" . $archivo; //Le agregamos un prefijo para identificarlo el archivo cargado
            if (copy($_FILES['excel']['tmp_name'], $destino)) echo "Archivo Cargado Con Éxito";
            else echo "Error Al Cargar el Archivo";

            if (file_exists("cop_" . $archivo)) {
                /** Llamamos las clases necesarias PHPEcel */
                require_once('Classes/PHPExcel.php');
                require_once('Classes/PHPExcel/Reader/Excel2007.php');
                // Cargando la hoja de excel
                $objReader = new PHPExcel_Reader_Excel2007();
                $objPHPExcel = $objReader->load("cop_" . $archivo);
                $objFecha = new PHPExcel_Shared_Date();
                // Asignamon la hoja de excel activa
                $objPHPExcel->setActiveSheetIndex(0);

                // Importante - conexión con la base de datos 
                // Rellenamos el arreglo con los datos  del archivo xlsx que ha sido subido

                $columnas = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
                $filas = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

                //Creamos un array con todos los datos del Excel importado
                for ($i = 2; $i <= $filas; $i++) {
                    $_DATOS_EXCEL[$i]['nro_dam'] = $objPHPExcel->getActiveSheet()->getCell('B' . $i)->getCalculatedValue();
                    $_DATOS_EXCEL[$i]['guia_remision'] = $objPHPExcel->getActiveSheet()->getCell('C' . $i)->getCalculatedValue();
                    $_DATOS_EXCEL[$i]['nro_operacion'] = $objPHPExcel->getActiveSheet()->getCell('D' . $i)->getCalculatedValue();
                    $_DATOS_EXCEL[$i]['item'] = $objPHPExcel->getActiveSheet()->getCell('E' . $i)->getCalculatedValue();
                    $_DATOS_EXCEL[$i]['codigo'] = $objPHPExcel->getActiveSheet()->getCell('F' . $i)->getCalculatedValue();
                    $_DATOS_EXCEL[$i]['familia_producto'] = $objPHPExcel->getActiveSheet()->getCell('G' . $i)->getCalculatedValue();
                    $_DATOS_EXCEL[$i]['descripcion'] = $objPHPExcel->getActiveSheet()->getCell('H' . $i)->getCalculatedValue();
                    $_DATOS_EXCEL[$i]['cantidad'] = $objPHPExcel->getActiveSheet()->getCell('I' . $i)->getCalculatedValue();
                    $_DATOS_EXCEL[$i]['unidad_medida'] = $objPHPExcel->getActiveSheet()->getCell('J' . $i)->getCalculatedValue();
                }
                $errores = 0;
                /* echo "<pre>";
			       print_r($_DATOS_EXCEL);
			       echo "</pre>"; */

                // INSERTANDO DATOS DE LA HOJA EXCEL A LA BASE DE DATOS
                $status = "0";
                $ubigeo = $_POST["ubigeo"];
                $ubicacion = $_POST["ubicacion"];
                $cliente = $_POST["cliente"];
                $fecha_ingreso = date("Y-m-d H:i:s");
                foreach ($_DATOS_EXCEL as $campo => $valor) {
                    $this->tbl_carga_excel->cargar_excel($valor['nro_dam'], $valor['guia_remision'], $valor['nro_operacion'], $valor['item'], $valor['codigo'], $ubigeo, $ubicacion, $cliente, $valor['familia_producto'], $valor['descripcion'], $valor['cantidad'], $valor['unidad_medida'], $status, $tatus, $status, $fecha_ingreso);
                    $this->tbl_carga_excel->cargar_excel_tbl_excel($valor['nro_dam'], $valor['guia_remision'], $valor['nro_operacion'], $valor['item'], $valor['codigo'], $ubigeo, $ubicacion, $cliente, $valor['familia_producto'], $valor['descripcion'], $valor['cantidad'], $valor['unidad_medida'], $status, $tatus, $status, $fecha_ingreso);
                }
                $rpta = "ARCHIVO IMPORTADO CON EXITO, EN TOTAL" . $campo . "REGISTROS Y " . $errores . "ERRORES";

                //Borramos el archivo que esta en el servidor con el prefijo cop_
                unlink($destino);
                redirect('admin/inventario/cargar_activos');
            }
            //si por algun motivo no cargo el archivo cop_ 
            else {
                $rpta = "Primero debes cargar el archivo con extension .xlsx";
            }
            echo $rpta;
        }
    }
    public function cargar_parte_ingreso_excel()
    {
        $this->load->model('tbl_carga_excel');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        extract($_POST);
        if (isset($_POST['action'])) {
            $action = $_POST['action'];
        }
        if (isset($action) == "upload") {
            //echo "entro";
            //Limpio tabla carga_excel
            $this->load->model('tbl_carga_excel');
            $this->tbl_carga_excel->limpiar_tabla_excel();
            //cargamos el fichero
            $archivo = $_FILES['excel']['name'];
            $tipo = $_FILES['excel']['type'];
            $destino = "cop_" . $archivo; //Le agregamos un prefijo para identificarlo el archivo cargado
            if (copy($_FILES['excel']['tmp_name'], $destino)){
                //echo "Archivo Cargado Con Éxito";
            }
            else{
                echo "Error Al Cargar el Archivo";
            }
            if (file_exists("cop_" . $archivo)) {
                //echo "ENTRO PARA TRATAMIENTO";
                /** Llamamos las clases necesarias PHPEcel */
                require_once('Classes/PHPExcel.php');
                require_once('Classes/PHPExcel/Reader/Excel2007.php');
                // Cargando la hoja de excel
                $objReader = new PHPExcel_Reader_Excel2007();
                $objPHPExcel = $objReader->load("cop_" . $archivo);
                $objFecha = new PHPExcel_Shared_Date();
                // Asignamon la hoja de excel activa
                $objPHPExcel->setActiveSheetIndex(0);

                // Importante - conexión con la base de datos 
                // Rellenamos el arreglo con los datos  del archivo xlsx que ha sido subido

                $columnas = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
                $filas = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
                // DATOS DEL ENCABEZADO DEL EXCEL
                $correlativo = $objPHPExcel->getActiveSheet()->getCell('B8')->getCalculatedValue();
                $cliente = $objPHPExcel->getActiveSheet()->getCell('B9')->getCalculatedValue();
                $fecha_parte = $objPHPExcel->getActiveSheet()->getCell('B10')->getCalculatedValue();
                $jefe_almacen = $objPHPExcel->getActiveSheet()->getCell('B12')->getCalculatedValue();
                $guia_remision = $objPHPExcel->getActiveSheet()->getCell('G6')->getCalculatedValue();
                $nro_dua = $objPHPExcel->getActiveSheet()->getCell('G7')->getCalculatedValue();

                $ultimo_correlativo = $this->tbl_carga_excel->buscar_parte_ingreso_tbl_items_parte_ingreso($correlativo);
                $correlativo_encontrado = $this->tbl_carga_excel->buscar_parte_ingreso($correlativo);
                //print_r($ultimo_correlativo);
                //CONDICIONAL PARA FILTRAR PARTES DE INGRESO QUE YA HAN SIDO CARGADOS 
                if(!empty($correlativo_encontrado[0]["correlativo"])  || !empty($ultimo_correlativo[0]["correlativo"])){
                    $rpta = "!!!!!ESTE PARTE DE INGRESO YA FUE CARGADO!!!!!!!";
                }
                else{
                    //Creamos un array con todos los datos del Excel importado
                    $j = 0;
                    for ($i = 16; $i <= $filas; $i++) {
                        // EVITO COGER CELDAS QUE NO SON NECESARIAS
                        if ($objPHPExcel->getActiveSheet()->getCell('E' . $i)->getCalculatedValue() != "" ) {
                            $j++;
                            $_DATOS_EXCEL[$i]['item'] = $objPHPExcel->getActiveSheet()->getCell('B' . $i)->getCalculatedValue();
                            $_DATOS_EXCEL[$i]['codigo'] = $objPHPExcel->getActiveSheet()->getCell('C' . $i)->getCalculatedValue();
                            $_DATOS_EXCEL[$i]['familia_producto'] = $objPHPExcel->getActiveSheet()->getCell('E' . $i)->getCalculatedValue();
                            // BUSCO CON STRPOS LA PALABRA CLAVE PARA DETERMINAR EL TIPO DE FAMILIA
                            if (strpos($_DATOS_EXCEL[$i]['familia_producto'], 'Piso') !== false) {
                                $_DATOS_EXCEL[$i]['familia_producto'] = "PISO";
                            } else if (strpos($_DATOS_EXCEL[$i]['familia_producto'], 'Muestra') !== false) {
                                $_DATOS_EXCEL[$i]['familia_producto'] = "MUESTRA";
                            } else if (strpos($_DATOS_EXCEL[$i]['familia_producto'], 'Pergo') !== false) {
                                $_DATOS_EXCEL[$i]['familia_producto'] = "PERGO";
                            } else if (strpos($_DATOS_EXCEL[$i]['familia_producto'], 'Pergo') !== false || strpos($_DATOS_EXCEL[$i]['familia_producto'], 'PERGO') !== false) {
                                $_DATOS_EXCEL[$i]['familia_producto'] = "PERGO";
                            } else if (strpos($_DATOS_EXCEL[$i]['familia_producto'], 'PLLSA') !== false) {
                                $_DATOS_EXCEL[$i]['familia_producto'] = "PLLSA";
                            } else if (strpos($_DATOS_EXCEL[$i]['familia_producto'], 'Zocalo') !== false || strpos($_DATOS_EXCEL[$i]['familia_producto'], 'Zócalo') !== false) {
                                $_DATOS_EXCEL[$i]['familia_producto'] = "ZOCALO";
                            } else if (strpos($_DATOS_EXCEL[$i]['familia_producto'], 'Iso trans') !== false) {
                                $_DATOS_EXCEL[$i]['familia_producto'] = "ISO TRANS";
                            } else if (strpos($_DATOS_EXCEL[$i]['familia_producto'], 'Perfil') !== false) {
                                $_DATOS_EXCEL[$i]['familia_producto'] = "PERFIL";
                            } else if (strpos($_DATOS_EXCEL[$i]['familia_producto'], 'Versa') !== false) {
                                $_DATOS_EXCEL[$i]['familia_producto'] = "VERSA";
                            } else if (strpos($_DATOS_EXCEL[$i]['familia_producto'], 'Silent') !== false) {
                                $_DATOS_EXCEL[$i]['familia_producto'] = "SILENT";
                            } else if (strpos($_DATOS_EXCEL[$i]['familia_producto'], 'Botella') !== false) {
                                $_DATOS_EXCEL[$i]['familia_producto'] = "BOTELLA";
                            } else if (strpos($_DATOS_EXCEL[$i]['familia_producto'], 'Cinta') !== false || strpos($_DATOS_EXCEL[$i]['familia_producto'], 'CINTA') !== false) {
                                $_DATOS_EXCEL[$i]['familia_producto'] = "CINTA";
                            } else if (strpos($_DATOS_EXCEL[$i]['familia_producto'], 'Subsuelo') !== false) {
                                $_DATOS_EXCEL[$i]['familia_producto'] = "SUBSUELO";
                            } else if (strpos($_DATOS_EXCEL[$i]['familia_producto'], 'Transitstop') !== false) {
                                $_DATOS_EXCEL[$i]['familia_producto'] = "TRANSITSTOP";
                            }
                            $_DATOS_EXCEL[$i]['descripcion'] = $objPHPExcel->getActiveSheet()->getCell('D' . $i)->getCalculatedValue();
                            $_DATOS_EXCEL[$i]['cantidad'] = $objPHPExcel->getActiveSheet()->getCell('F' . $i)->getCalculatedValue();
                            $_DATOS_EXCEL[$i]['unidad_medida'] = $objPHPExcel->getActiveSheet()->getCell('G' . $i)->getCalculatedValue();
                            $_DATOS_EXCEL[$i]['observaciones'] = $objPHPExcel->getActiveSheet()->getCell('I' . $i)->getCalculatedValue();
                            // ENVIANDO DATOS EN DURO
                            $_DATOS_EXCEL[$i]['correlativo'] = $correlativo;
                            $_DATOS_EXCEL[$i]['cliente'] = $cliente;
                            $_DATOS_EXCEL[$i]['fecha_parte'] = $fecha_parte;
                            $_DATOS_EXCEL[$i]['jefe_almacen'] = $jefe_almacen;
                            $_DATOS_EXCEL[$i]['guia_remision'] = $guia_remision;
                            $_DATOS_EXCEL[$i]['nro_dua'] = $nro_dua;
                        }
                    }
                    $errores = 0;
                    /* echo "<pre>";
                       print_r($_DATOS_EXCEL);
                       echo "</pre>"; */
    
                    // INSERTANDO DATOS DE LA HOJA EXCEL A LA BASE DE DATOS
                    $status = "0";
                    $ubigeo = $_POST["ubigeo"];
                    $ubicacion = $_POST["ubicacion"];
                    $fecha_ingreso = date("Y-m-d H:i:s");
                    foreach ($_DATOS_EXCEL as $campo => $valor) {
                        $this->tbl_carga_excel->cargar_parte_ingreso_tbl_excel($valor['nro_dua'], $valor['guia_remision'], $valor['item'], $valor['codigo'], $valor['correlativo'], $ubigeo, $ubicacion, $cliente, $valor['familia_producto'], $valor['descripcion'], $valor['cantidad'], $valor['unidad_medida'], $status, $status, $status, $fecha_ingreso, $valor['observaciones'], $valor['jefe_almacen'], $valor['fecha_parte']);
                        $this->tbl_carga_excel->cargar_items_parte_ingreso_tbl_excel($valor['nro_dua'], $valor['guia_remision'], $valor['item'], $valor['codigo'], $valor['correlativo'], $ubigeo, $ubicacion, $cliente, $valor['familia_producto'], $valor['descripcion'], $valor['cantidad'], $valor['unidad_medida'], $status, $status, $status, $fecha_ingreso, $valor['observaciones'], $valor['jefe_almacen'], $valor['fecha_parte']);
                    }
                    // NUMERO DE ITEMS
                    $total_items = $j;
                    $this->tbl_carga_excel->cargar_parte_ingreso($nro_dua, $correlativo, $guia_remision, $ubigeo, $ubicacion, $cliente, $fecha_ingreso, $jefe_almacen, $fecha_parte,$total_items);
                    //$rpta = "ARCHIVO IMPORTADO CON EXITO, EN TOTAL" . $campo . "REGISTROS Y " . $errores . "ERRORES";
                    $rpta = "ARCHIVO IMPORTADO CON ÉXITO";
    
                    //Borramos el archivo que esta en el servidor con el prefijo cop_
                    unlink($destino);
                    //redirect('admin/inventario/cargar_parte_ingreso');
                }
            }
            //si por algun motivo no cargo el archivo cop_ 
            else {
                $rpta = "Primero debes cargar el archivo con extension .xlsx";
            }
            echo $rpta;
        }else{
            echo '<pre>';
            print_r($_POST);
            echo '</pre>';
        }



    }
    public function limpiar_tabla()
    {
        $this->load->model('tbl_carga_excel');
        $this->tbl_carga_excel->limpiar_tabla_excel();
        redirect('admin/inventario/cargar_activos');
    }
    public function limpiar_tabla_items()
    {
        $this->load->model('tbl_carga_excel');
        $this->tbl_carga_excel->limpiar_tabla_items_parte();
        redirect('admin/inventario/cargar_parte_ingreso');
    }
    public function get_list_inventario_no_vinculados()
    {
        $this->load->model('tbl_inventario');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $tabla = "";
        $i = 0;
        $lista = $this->tbl_inventario->get_lista_inventario_no_vinculados();
        foreach ($lista as $row) {
            $i++;
            $tabla .= '{"id":"' . $i . '","cod":"' . $row['codigo'] . '","descripcion":"' . $row['descripcion'] . '","imagen":"' . $row['imagen'] . '","date":"' . $row['fecha_inventario'] . '"},';
        }
        $tabla = substr($tabla, 0, strlen($tabla) - 1);
        //header("Content-type: application/json");
        // echo json_encode($result);
        echo '{"data":[' . $tabla . ']}';
    }
    public function get_activos_abc()
    {
        $this->load->model('tbl_carga_excel');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $tabla = "";
        $i = 0;
        $lista = $this->tbl_carga_excel->get_lista_activos();
        /* echo "<pre>";
        print_r($lista);
        echo "</pre>"; */
        $registros = array();
        foreach ($lista as $row) {
            $i++;
            $registro = array();
            $registro["id"] = $row["id"];
            $registro["indice"] = $i;
            $registro["nro_dam"] = $row["nro_dam"];
            $registro["guia_remision"] = $row["guia_remision"];
            $registro["nro_operacion"] = $row["nro_operacion"];
            $registro["item"] = $row["item"];
            $registro["codigo"] = $row["codigo"];
            $registro["ubigeo"] = $row["ubigeo"];
            $registro["ubicacion"] = $row["ubicacion"];
            $registro["cliente"] = $row["cliente"];
            $registro["familia_producto"] = $row["familia_producto"];
            $registro["descripcion"] = $row["descripcion"];
            $registro["cantidad"] = $row["cantidad"];
            $registro["unidad_medida"] = $row["unidad_medida"];
            $registro["estado"] = $row["estado"];
            $registros[] = $registro;
        }
        echo '{"data": ' . json_encode($registros) . '}';
        //echo json_encode($registros);
    }

    public function get_activos_excel()
    {
        $this->load->model('tbl_carga_excel');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $tabla = "";
        $i = 0;
        $lista = $this->tbl_carga_excel->get_lista_activos_desde_excel();
        /* echo "<pre>";
        print_r($lista);
        echo "</pre>"; */
        $registros = array();
        foreach ($lista as $row) {
            $i++;
            $registro = array();
            $registro["id"] = $row["id"];
            $registro["nro_dam"] = $row["nro_dam"];
            $registro["guia_remision"] = $row["guia_remision"];
            $registro["nro_operacion"] = $row["nro_operacion"];
            $registro["item"] = $row["item"];
            $registro["codigo"] = $row["codigo"];
            $registro["ubigeo"] = $row["ubigeo"];
            $registro["ubicacion"] = $row["ubicacion"];
            $registro["cliente"] = $row["cliente"];
            $registro["familia_producto"] = $row["familia_producto"];
            $registro["descripcion"] = $row["descripcion"];
            $registro["cantidad"] = $row["cantidad"];
            $registro["unidad_medida"] = $row["unidad_medida"];
            $registro["estado"] = $row["estado"];
            $registros[] = $registro;
        }
        echo '{"data": ' . json_encode($registros) . '}';
        //echo json_encode($registros);
    }
    public function get_items_parte_ingreso_excel()
    {
        $this->load->model('tbl_carga_excel');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $tabla = "";
        $i = 0;
        $lista = $this->tbl_carga_excel->get_items_parte_ingreso();
        /* echo "<pre>";
        print_r($lista);
        echo "</pre>"; */
        $registros = array();
        foreach ($lista as $row) {
            $i++;
            $registro = array();
            $registro["id"] = $i;
            $registro["nro_dua"] = $row["nro_dua"];
            $registro["guia_remision"] = $row["guia_remision"];
            $registro["nro_operacion"] = $row["nro_operacion"];
            $registro["item"] = $row["item"];
            $registro["codigo"] = $row["codigo"];
            $registro["correlativo"] = $row["correlativo"];
            $registro["ubigeo"] = $row["ubigeo"];
            $registro["ubicacion"] = $row["ubicacion"];
            $registro["cliente"] = $row["cliente"];
            $registro["familia_producto"] = $row["familia_producto"];
            $registro["descripcion"] = $row["descripcion"];
            $registro["cantidad"] = $row["cantidad"];
            $registro["unidad_medida"] = $row["unidad_medida"];
            $registro["fecha_ingreso"] = $row["fecha_ingreso"];
            $registro["fecha_parte"] = $row["fecha_parte"];
            $registro["jefe_almacen"] = $row["jefe_almacen"];
            $registro["observaciones"] = $row["observaciones"];
            $registro["estado"] = $row["estado"];
            $registros[] = $registro;
        }
        echo '{"data": ' . json_encode($registros) . '}';
        //echo json_encode($registros);
    }
    public function get_parte_ingreso()
    {
        $this->load->model('tbl_carga_excel');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $tabla = "";
        $i = 0;
        $lista = $this->tbl_carga_excel->get_parte_ingreso();
        /* echo "<pre>";
        print_r($lista);
        echo "</pre>"; */
        $registros = array();
        foreach ($lista as $row) {
            $i++;
            $registro = array();
            $registro["item"] = $i;
            $registro["id"] = $row["id"];
            $registro["nro_dua"] = $row["nro_dua"];
            $registro["guia_remision"] = $row["guia_remision"];
            $registro["correlativo"] = $row["correlativo"];
            $registro["ubigeo"] = $row["ubigeo"];
            $registro["ubicacion"] = $row["ubicacion"];
            $registro["cliente"] = $row["cliente"];
            $registro["jefe_almacen"] = $row["jefe_almacen"];
            $registro["fecha_parte"] = $row["fecha_parte"];
            $registro["fecha_ingreso"] = $row["fecha_ingreso"];
            $registro["total_items"] = $row["total_items"];
            $registro["status"] = $row["status"];
            $registros[] = $registro;
        }
        echo '{"data": ' . json_encode($registros) . '}';
        //echo json_encode($registros);
    }
    public function get_activos_vinculados_excel()
    {
        $this->load->model('tbl_carga_excel');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $tabla = "";
        $i = 0;
        $lista = $this->tbl_carga_excel->get_lista_activos_desde_excel_vinculados();
        /* echo "<pre>";
        print_r($lista);
        echo "</pre>"; */
        $registros = array();
        foreach ($lista as $row) {
            $i++;
            $registro = array();
            $registro["indice"] = $i;
            $registro["id"] = $row["id"];
            $registro["nro_dam"] = $row["nro_dam"];
            $registro["nro_dua"] = $row["nro_dua"];
            $registro["correlativo"] = $row["correlativo"];
            $registro["guia_remision"] = $row["guia_remision"];
            $registro["nro_operacion"] = $row["nro_operacion"];
            $registro["item"] = $row["item"];
            $registro["codigo"] = $row["codigo"];
            $registro["codigo_rfid"] = $row["codigo_rfid"];
            $registro["ubigeo"] = $row["ubigeo"];
            $registro["ubicacion"] = $row["ubicacion"];
            $registro["cliente"] = $row["cliente"];
            $registro["familia_producto"] = $row["familia_producto"];
            $registro["descripcion"] = $row["descripcion"];
            $registro["cantidad"] = $row["cantidad"];
            $registro["unidad_medida"] = $row["unidad_medida"];
            $registro["fecha_vinculacion"] = $row["fecha_vinculacion"];
            $registro["estado"] = $row["estado"];
            $registros[] = $registro;
        }
        //echo json_encode($registros);
        echo '{"data": ' . json_encode($registros) . '}';
    }
    public function get_activos_matriculados_sin_rfid()
    {
        $this->load->model('tbl_inventario');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $tabla = "";
        $i = 0;
        $lista = $this->tbl_inventario->get_lista_activos();
        /* echo "<pre>";
        print_r($lista);
        echo "</pre>"; */
        foreach ($lista as $row) {
            $i++;
            $tabla .= '{"id":"' . $i . '","cod_producto":"' . $row['codigo_producto'] . '","descripcion":"' . $row['descripcion'] . '","cliente":"' . $row['cliente'] . '","valor":"' . $row['valor'] . '","unidad_medida":"' . $row['unidad_medida'] . '","cantidad":"' . $row['cantidad'] . '","ubigeo":"' . $row['ubigeo'] . '","ubicacion":"' . $row['ubicacion'] . '","lote":"' . $row['lote'] . '","ancho":"' . $row['ancho'] . '","profundidad":"' . $row['profundidad'] . '","peso":"' . $row['peso'] . '","orden_ingreso":"' . $row['orden_ingreso'] . '","programacion":"' . $row['programacion'] . '","date":"' . $row['fecha_ingreso'] . '"},';
        }
        $tabla = substr($tabla, 0, strlen($tabla) - 1);
        echo '{"data":[' . $tabla . ']}';
        //header("Content-type: application/json");
        // echo json_encode($result);
    }

    public function get_activos_matriculados()
    {
        $this->load->model('tbl_inventario');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $tabla = "";
        $i = 0;
        $lista = $this->tbl_inventario->get_lista_activos_matriculados();
        /* echo "<pre>";
        print_r($lista);
        echo "</pre>"; */
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
            $registro["unidad_medida"] = $row["unidad_medida"];
            $registro["cantidad"] = $row["cantidad"];
            $registro["ubigeo"] = $row["ubigeo"];
            $registro["ubicacion"] = $row["ubicacion"];
            $registro["lote"] = $row["lote"];
            $registro["ancho"] = $row["ancho"];
            $registro["profundidad"] = $row["profundidad"];
            $registro["peso"] = $row["peso"];
            $registro["orden_ingreso"] = $row["orden_ingreso"];
            $registro["programacion"] = $row["programacion"];
            $registro["date"] = $row["fecha_ingreso"];
            $registros[] = $registro;
            //$tabla .= '{"id":"' . $i . '","cod_producto":"' . $row['codigo_producto'] . '","cod_rfid":"' . $row['codigo_rfid'] . '","descripcion":"' . $row['descripcion'] . '","cliente":"' . $row['cliente'] . '","valor":"' . $row['valor'] . '","unidad_medida":"' . $row['unidad_medida'] . '","cantidad":"' . $row['cantidad'] . '","ubigeo":"' . $row['ubigeo'] . '","ubicacion":"' . $row['ubicacion'] . '","lote":"' . $row['lote'] . '","ancho":"' . $row['ancho'] . '","profundidad":"' . $row['profundidad'] . '","peso":"' . $row['peso'] . '","orden_ingreso":"' . $row['orden_ingreso'] . '","programacion":"' . $row['programacion'] . '","date":"' . $row['fecha_ingreso'] . '"},';
        }
        echo json_encode($registros);
    }

    public function guardar_activo()
    {
        /* var_dump($_POST);
        var_dump($_FILES); 
        print_r($_FILES);//se pone print_r
        print_r($_POST['codigo']);
        print_r($_POST['descripcion']);
        */
        $this->load->model('tbl_inventario');
        $this->load->model('tbl_vinculacion');
        $cod_rfid = $this->input->post('rfid');
        $cod_producto = $this->input->post('codigo_sensor');
        //print_r($cod_producto);
        $codigo = $this->obj_vinculacion->get_cod_rfid_vinculado($cod_rfid);
        $codigo_producto = $this->obj_inventario->get_cod_producto_repetido($cod_producto);

        //print_r($codigo_producto);
        //print_r($codigo);
        //SI EL CODIGO INGRESADO YA ESTA REGISTRADO!!!!!!!!!!!!!
        if (empty($codigo) == "0" or empty($codigo_producto) == "0") {
            $rpta = "!!!!ESTE CODIGO YA HA SIDO REGISTRADO!!!!!";

            // !!!!!!!!NUEVO CODIGO!!!!!!!!!!!!!!!
        } else if ($this->input->post('cliente') != "" and $this->input->post('ubigeo') != "" and $this->input->post('ubicacion') != "") {
            $status1 = "1";
            $status = "0";
            //$rpta = "Error al guardar la información";
            //$codigo = $this->obj_inventario->get_cod_inventario($cod);
            //print_r($codigo->codigo);
            $data1 = array(
                'codigo_producto' => $this->input->post('codigo_sensor'),
                'descripcion' => $this->input->post('descripcion'),
                'cliente' => $this->input->post('cliente'),
                'valor' => $this->input->post('valor'),
                'unidad_medida' => $this->input->post('unidad_medida'),
                'cantidad' => $this->input->post('cantidad'),
                'ubigeo' => $this->input->post('ubigeo'),
                'ubicacion' => $this->input->post('ubicacion'),
                'lote' => $this->input->post('lote'),
                'ancho' => $this->input->post('ancho'),
                'peso' => $this->input->post('peso'),
                'profundidad' => $this->input->post('profundidad'),
                'orden_ingreso' => $this->input->post('ingreso'),
                'estado' => $status1,
                'estado_salida' => $status,
                'programacion' => $status,
                'fecha_ingreso' => date("Y-m-d H:i:s")
            );
            $data2 = array(
                'codigo_producto' => $this->input->post('codigo_sensor'),
                'codigo_rfid' => $this->input->post('rfid'),
                'status' => $status1,
                'fecha_vinculacion' => date("Y-m-d H:i:s")
            );
            //print_r($data);

            //redirect('admin/inventario/ingresar_activos');
            try {
                $result =  $this->tbl_inventario->add_activo($data1);
                $result1 =  $this->tbl_inventario->add_activo_vinculado($data2);
                if ($result and $result1)
                    $rpta = "Se guardó correctamente";
                else
                    $rpta = "Error al guardar la información";
            } catch (Exception $e) {
                $rpta = 'Error de Transacción';
            }
            //redirect("admin/inventario/ingresar_activos"); // lo envia a la misma pagina
        } else {
            $rpta = "Debe elegir Ubigeo ó Ubicación | Cliente";
        }
        echo $rpta;
    }
    public function guardar_activo_abc()
    {
        /* var_dump($_POST);
        var_dump($_FILES); 
        print_r($_FILES);//se pone print_r
        print_r($_POST['codigo']);
        print_r($_POST['descripcion']);
        */
        $this->load->model('tbl_inventario');
        $this->load->model('tbl_vinculacion');
        $cod_rfid = $this->input->post('rfid');
        $cod_producto = $this->input->post('codigo_sensor');
        //print_r($cod_producto);
        $codigo = $this->obj_vinculacion->get_cod_rfid_vinculado($cod_rfid);
        $codigo_producto = $this->obj_inventario->get_cod_producto_repetido($cod_producto);

        //print_r($codigo_producto);
        //print_r($codigo);
        //SI EL CODIGO INGRESADO YA ESTA REGISTRADO!!!!!!!!!!!!!
        if (empty($codigo) == "0" or empty($codigo_producto) == "0") {
            $rpta = "!!!!ESTE CODIGO YA HA SIDO REGISTRADO!!!!!";

            // !!!!!!!!NUEVO CODIGO!!!!!!!!!!!!!!!
        } else if ($this->input->post('cliente') != "" and $this->input->post('ubigeo') != "" and $this->input->post('ubicacion') != "") {
            $status1 = "1";
            $status = "0";
            //$rpta = "Error al guardar la información";
            //$codigo = $this->obj_inventario->get_cod_inventario($cod);
            //print_r($codigo->codigo);
            $data1 = array(
                'nro_dam' => $this->input->post('nro_dam'),
                'guia_remision' => $this->input->post('guia_remision'),
                'nro_operacion' => $this->input->post('nro_operacion'),
                'item' => $this->input->post('item'),
                'codigo' => $this->input->post('codigo_sensor'),
                'ubigeo' => $this->input->post('ubigeo'),
                'ubicacion' => $this->input->post('ubicacion'),
                'cliente' => $this->input->post('cliente'),
                'familia_producto' => $this->input->post('familia_producto'),
                'descripcion' => $this->input->post('descripcion'),
                'unidad_medida' => $this->input->post('unidad_medida'),
                'cantidad' => $this->input->post('cantidad'),
                'estado' => $status1,
                'estado_salida' => $status,
                'programacion' => $status,
                'fecha_ingreso' => date("Y-m-d H:i:s")
            );
            $data2 = array(
                'codigo_producto' => $this->input->post('codigo_sensor'),
                'codigo_rfid' => $this->input->post('rfid'),
                'status' => $status1,
                'fecha_vinculacion' => date("Y-m-d H:i:s")
            );
            //print_r($data);

            //redirect('admin/inventario/ingresar_activos');
            try {
                $result =  $this->tbl_inventario->add_activo_abc($data1);
                $result1 =  $this->tbl_inventario->add_activo_vinculado($data2);
                if ($result and $result1)
                    $rpta = "Se guardó correctamente";
                else
                    $rpta = "Error al guardar la información";
            } catch (Exception $e) {
                $rpta = 'Error de Transacción';
            }
            //redirect("admin/inventario/ingresar_activos"); // lo envia a la misma pagina
        } else {
            $rpta = "Debe elegir Ubigeo ó Ubicación | Cliente";
        }
        echo $rpta;
    }
    public function editar_parte_ingreso($cod_inventario)
    {
        $this->form_validation->set_rules('correlativo', 'correlativo', 'trim|required'); // importante para que funcione el codigo
        $this->form_validation->set_message('required', 'Este campo es requerido');
        $clientes = $this->obj_inventario->get_clientes();
        $this->load->tmp_admin->set('clientes', $clientes);
        $ubigeo = $this->obj_inventario->get_ubigeo();
        $this->load->tmp_admin->set('ubigeo', $ubigeo);
        $ubicacion = $this->obj_inventario->get_ubicacion();
        //print_r($ubicacion);
        $this->load->tmp_admin->set('ubicacion', $ubicacion);
        if ($this->form_validation->run($this) == FALSE) {
            $codigo = $this->obj_inventario->get_cod_parte_ingreso($cod_inventario);
            $this->load->tmp_admin->set('codigo', $codigo);
            $this->load->tmp_admin->render('editar_parte_ingreso_view');
            //print_r($codigo);
            //print_r($this->input->post('name_file'));
        } else {
            if ($this->input->post('ubicacion') == '0') {
                $codigo = $this->obj_inventario->get_cod_parte_ingreso($cod_inventario);
                //print_r($codigo->imagen);
                //print_r($extension);
                $datos_inventario = array();
                $datos_inventario['correlativo']  = $this->input->post('correlativo');
                $datos_inventario['guia_remision']  = $this->input->post('guia_remision');
                $datos_inventario['nro_dua']  = $this->input->post('nro_dua');
                $datos_inventario['jefe_almacen']  = $this->input->post('jefe_almacen');
                $datos_inventario['cliente']  = $this->input->post('cliente');
                $datos_inventario['ubigeo']  = $this->input->post('ubigeo');
                $datos_inventario['ubicacion']  = $codigo->ubicacion;
                print_r($datos_inventario);
                $this->obj_inventario->editar_inventario_abc($datos_inventario, $cod_inventario);
                redirect('admin/inventario/editar_parte_ingreso/'.$cod_inventario);
            } else {
                $codigo = $this->obj_inventario->get_cod_parte_ingreso($cod_inventario);
                //print_r($codigo->imagen);
                //print_r($extension);
                $datos_inventario = array();
                $datos_inventario['correlativo']  = $this->input->post('correlativo');
                $datos_inventario['guia_remision']  = $this->input->post('guia_remision');
                $datos_inventario['nro_dua']  = $this->input->post('nro_dua');
                $datos_inventario['jefe_almacen']  = $this->input->post('jefe_almacen');
                $datos_inventario['cliente']  = $this->input->post('cliente');
                $datos_inventario['ubigeo']  = $this->input->post('ubigeo');
                $datos_inventario['ubicacion']  = $this->input->post('ubicacion');
                print_r($datos_inventario);
                $this->obj_inventario->editar_parte_ingreso($datos_inventario, $cod_inventario);
                redirect('admin/inventario/editar_parte_ingreso/'.$cod_inventario);
            }
        }
    }
    public function editar_abc($cod_inventario)
    {
        $this->form_validation->set_rules('producto', 'CODIGO', 'trim|required'); // importante para que funcione el codigo
        $this->form_validation->set_message('required', 'Este campo es requerido');
        $clientes = $this->obj_inventario->get_clientes();
        $this->load->tmp_admin->set('clientes', $clientes);
        $ubigeo = $this->obj_inventario->get_ubigeo();
        $this->load->tmp_admin->set('ubigeo', $ubigeo);
        $ubicacion = $this->obj_inventario->get_ubicacion();
        //print_r($ubicacion);
        $this->load->tmp_admin->set('ubicacion', $ubicacion);
        if ($this->form_validation->run($this) == FALSE) {
            $codigo = $this->obj_inventario->get_cod_inventario_abc($cod_inventario);
            $this->load->tmp_admin->set('codigo', $codigo);
            $codigo_rfid = $this->obj_vinculacion->get_cod_rfid_vinculado_editar($cod_inventario);
            //print_r($codigo_rfid);
            $this->load->tmp_admin->set('codigo_rfid', $codigo_rfid);
            $this->load->tmp_admin->render('editar_activo_abc_view');
            //print_r($codigo);
            //print_r($this->input->post('name_file'));
        } else {
            if ($this->input->post('ubicacion') == '0') {
                $codigo = $this->obj_inventario->get_cod_inventario_abc($cod_inventario);
                //print_r($codigo->imagen);
                //print_r($extension);
                $datos_inventario = array();
                $datos_inventario['nro_dam']  = $this->input->post('nro_dam');
                $datos_inventario['guia_remision']  = $this->input->post('guia_remision');
                $datos_inventario['nro_operacion']  = $this->input->post('nro_operacion');
                $datos_inventario['item']  = $this->input->post('item');
                $datos_inventario['codigo']  = $this->input->post('producto');
                $datos_inventario['descripcion']  = $this->input->post('descripcion');
                $datos_inventario['unidad_medida']  = $this->input->post('unidad_medida');
                $datos_inventario['cantidad']  = $this->input->post('cantidad');
                $datos_inventario['cliente']  = $this->input->post('cliente');
                $datos_inventario['ubigeo']  = $this->input->post('ubigeo');
                $datos_inventario['ubicacion']  = $codigo->ubicacion;
                $datos_inventario['familia_producto']  = $this->input->post('familia_producto');
                $datos_inventario['fecha_ingreso'] = $codigo->fecha_ingreso;
                print_r($datos_inventario);
                $this->obj_inventario->editar_inventario_abc($datos_inventario, $cod_inventario);
                redirect('admin/inventario/editar_activos');
            } else {
                $codigo = $this->obj_inventario->get_cod_inventario($cod_inventario);
                //print_r($codigo->imagen);
                //print_r($extension);
                $datos_inventario = array();
                $datos_inventario['nro_dam']  = $this->input->post('nro_dam');
                $datos_inventario['guia_remision']  = $this->input->post('guia_remision');
                $datos_inventario['nro_operacion']  = $this->input->post('nro_operacion');
                $datos_inventario['item']  = $this->input->post('item');
                $datos_inventario['codigo']  = $this->input->post('producto');
                $datos_inventario['descripcion']  = $this->input->post('descripcion');
                $datos_inventario['unidad_medida']  = $this->input->post('unidad_medida');
                $datos_inventario['cantidad']  = $this->input->post('cantidad');
                $datos_inventario['cliente']  = $this->input->post('cliente');
                $datos_inventario['ubigeo']  = $this->input->post('ubigeo');
                $datos_inventario['ubicacion']  = $this->input->post('ubicacion');
                $datos_inventario['familia_producto']  = $this->input->post('familia_producto');
                $datos_inventario['fecha_ingreso'] = $codigo->fecha_ingreso;
                print_r($datos_inventario);
                $this->obj_inventario->editar_inventario_abc($datos_inventario, $cod_inventario);
                redirect('admin/inventario/editar_activos');
            }
        }
    }
    public function editar($cod_inventario)
    {
        $this->form_validation->set_rules('producto', 'CODIGO', 'trim|required'); // importante para que funcione el codigo
        $this->form_validation->set_message('required', 'Este campo es requerido');
        $clientes = $this->obj_inventario->get_clientes();
        $this->load->tmp_admin->set('clientes', $clientes);
        $ubigeo = $this->obj_inventario->get_ubigeo();
        $this->load->tmp_admin->set('ubigeo', $ubigeo);
        $ubicacion = $this->obj_inventario->get_ubicacion();
        //print_r($ubicacion);
        $this->load->tmp_admin->set('ubicacion', $ubicacion);
        if ($this->form_validation->run($this) == FALSE) {
            $codigo = $this->obj_inventario->get_cod_inventario($cod_inventario);
            $this->load->tmp_admin->set('codigo', $codigo);
            $codigo_rfid = $this->obj_vinculacion->get_cod_rfid_vinculado_editar($cod_inventario);
            //print_r($codigo_rfid);
            $this->load->tmp_admin->set('codigo_rfid', $codigo_rfid);
            $this->load->tmp_admin->render('editar_activo_view');
            //print_r($codigo);
            //print_r($this->input->post('name_file'));
        } else {
            if ($this->input->post('ubicacion') == '0') {
                $codigo = $this->obj_inventario->get_cod_inventario($cod_inventario);
                //print_r($codigo->imagen);
                //print_r($extension);
                $datos_inventario = array();
                $datos_inventario['codigo_producto']  = $this->input->post('producto');
                $datos_inventario['descripcion']  = $this->input->post('descripcion');
                $datos_inventario['valor']  = $this->input->post('valor');
                $datos_inventario['unidad_medida']  = $this->input->post('unidad_medida');
                $datos_inventario['cantidad']  = $this->input->post('cantidad');
                $datos_inventario['cliente']  = $this->input->post('cliente');
                $datos_inventario['ubigeo']  = $this->input->post('ubigeo');
                $datos_inventario['ubicacion']  = $codigo->ubicacion;
                $datos_inventario['peso']  = $this->input->post('peso');
                $datos_inventario['ancho']  = $this->input->post('ancho');
                $datos_inventario['profundidad']  = $this->input->post('profundidad');
                $datos_inventario['lote']  = $this->input->post('lote');
                $datos_inventario['fecha_ingreso'] = $codigo->fecha_ingreso;
                print_r($datos_inventario);
                $this->obj_inventario->editar_inventario($datos_inventario, $cod_inventario);
                redirect('admin/inventario/editar_activos');
            } else {
                $codigo = $this->obj_inventario->get_cod_inventario($cod_inventario);
                //print_r($codigo->imagen);
                //print_r($extension);
                $datos_inventario = array();
                $datos_inventario['codigo_producto']  = $this->input->post('producto');
                $datos_inventario['descripcion']  = $this->input->post('descripcion');
                $datos_inventario['valor']  = $this->input->post('valor');
                $datos_inventario['unidad_medida']  = $this->input->post('unidad_medida');
                $datos_inventario['cantidad']  = $this->input->post('cantidad');
                $datos_inventario['cliente']  = $this->input->post('cliente');
                $datos_inventario['ubigeo']  = $this->input->post('ubigeo');
                $datos_inventario['ubicacion']  = $this->input->post('ubicacion');
                $datos_inventario['peso']  = $this->input->post('peso');
                $datos_inventario['ancho']  = $this->input->post('ancho');
                $datos_inventario['profundidad']  = $this->input->post('profundidad');
                $datos_inventario['lote']  = $this->input->post('lote');
                $datos_inventario['fecha_ingreso'] = $codigo->fecha_ingreso;
                print_r($datos_inventario);
                $this->obj_inventario->editar_inventario($datos_inventario, $cod_inventario);
                redirect('admin/inventario/editar_activos');
            }
        }
    }

    public function eliminar($cod_inventario)
    {
        $this->obj_inventario->eliminar($cod_inventario);
        //print_r($cod_inventario);
        $cod_rfid = $this->obj_vinculacion->get_cod_rfid_vinculado_editar($cod_inventario);
        //print_r($cod_rfid);
        $this->obj_vinculacion->eliminar($cod_rfid[0]["codigo_rfid"]);
        redirect('admin/inventario/editar_activos');
    }
    public function eliminar_parte_ingreso($correlativo)
    {
        $this->obj_inventario->eliminar_parte_ingreso($correlativo);
        $this->obj_inventario->eliminar_items_parte_ingreso($correlativo);
        redirect('admin/inventario/partes_ingreso');
    }

    public function logout()
    {
        $this->session->unset_userdata('logged');
        redirect('admin');
    }
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */