<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Enrolamiento extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('tbl_usuario', 'obj_usuario');
        $this->load->model('tbl_enrolados', 'obj_enrolados');
        $this->load->model('tbl_inventario', 'obj_inventario');
        if ($this->session->userdata('logged') != 'true') {
            redirect('login');
        }
    }
    public function index()
    {
        $this->load->model('tbl_enrolados');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $this->load->tmp_admin->render('sujetos_enrolados_view');
    }
    public function enrolar_sujetos()
    {
        $this->load->model('tbl_enrolados');
        $ubigeo = $this->obj_inventario->get_ubigeo();
        $this->load->tmp_admin->set('ubigeo', $ubigeo);
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $this->load->tmp_admin->render('enrolar_sujetos_view');
    }
    public function enrolar_sujetos_automatico()
    {
        $this->load->model('tbl_enrolados');
        $this->load->model('tbl_inventario');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $ubigeo = $this->obj_inventario->get_ubigeo();
        $this->load->tmp_admin->set('ubigeo', $ubigeo);
        $this->load->tmp_admin->render('cargar_enrolados_excel_view');
    }
    public function control_acceso_rfid()
    {
        $this->load->model('tbl_enrolados');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $this->load->tmp_admin->render('control_sujetos_live_view');
    }

    public function editar_sujeto()
    {
        $this->load->model('tbl_enrolados');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $this->load->tmp_admin->render('editar_sujeto_view');
    }
    public function cargar_sujetos_excel()
    {
        $this->load->model('tbl_carga_excel');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        extract($_POST);
        if (isset($_POST['action'])) {
            $action = $_POST['action'];
        }
        if (isset($action) == "upload") {
            //echo "entro";
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
                    $_DATOS_EXCEL[$i]['nombres'] = $objPHPExcel->getActiveSheet()->getCell('C' . $i)->getCalculatedValue();
                    $_DATOS_EXCEL[$i]['apellidos'] = $objPHPExcel->getActiveSheet()->getCell('D' . $i)->getCalculatedValue();
                    $_DATOS_EXCEL[$i]['dni'] = $objPHPExcel->getActiveSheet()->getCell('E' . $i)->getCalculatedValue();
                    $_DATOS_EXCEL[$i]['cargo'] = $objPHPExcel->getActiveSheet()->getCell('F' . $i)->getCalculatedValue();
                }
                $errores = 0;
                /* echo "<pre>";
			       print_r($_DATOS_EXCEL);
			       echo "</pre>"; */

                // INSERTANDO DATOS DE LA HOJA EXCEL A LA BASE DE DATOS
                $status = "0";
                $ubigeo = $_POST["ubigeo"];
                $imagen = "SIN IMAGEN";
                foreach ($_DATOS_EXCEL as $campo => $valor) {
                    $this->tbl_carga_excel->cargar_excel_sujetos($valor['nombres'], $valor['apellidos'], $valor['dni'], $valor['cargo'], $ubigeo, $imagen, $status);
                }
                $rpta = "ARCHIVO IMPORTADO CON EXITO, EN TOTAL" . $campo . "REGISTROS Y " . $errores . "ERRORES";

                //Borramos el archivo que esta en el servidor con el prefijo cop_
                unlink($destino);
                redirect('admin/enrolamiento/enrolar_sujetos_automatico');
            }
            //si por algun motivo no cargo el archivo cop_ 
            else {
                $rpta = "Primero debes cargar el archivo con extension .xlsx";
            }
            echo $rpta;
        }
    }
    public function get_list_inventario_no_vinculados()
    {
        $this->load->model('tbl_enrolados');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $tabla = "";
        $i = 0;
        $lista = $this->tbl_enrolados->get_lista_inventario_no_vinculados();
        foreach ($lista as $row) {
            $i++;
            $tabla .= '{"id":"' . $i . '","cod":"' . $row['codigo'] . '","descripcion":"' . $row['descripcion'] . '","imagen":"' . $row['imagen'] . '","date":"' . $row['fecha_inventario'] . '"},';
        }
        $tabla = substr($tabla, 0, strlen($tabla) - 1);
        //header("Content-type: application/json");
        // echo json_encode($result);
        echo '{"data":[' . $tabla . ']}';
    }
    public function get_sujetos_excel()
    {
        $this->load->model('tbl_carga_excel');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $tabla = "";
        $i = 0;
        $lista = $this->tbl_carga_excel->get_lista_sujetos_desde_excel();
        /* echo "<pre>";
        print_r($lista);
        echo "</pre>"; */
        $registros = array();
        foreach ($lista as $row) {
            $i++;
            $registro = array();
            $registro["id"] = $i;
            $registro["nombres"] = $row["nombres"];
            $registro["apellidos"] = $row["apellidos"];
            $registro["dni"] = $row["dni"];
            $registro["cargo"] = $row["cargo"];
            $registro["ubigeo"] = $row["ubigeo"];
            $registro["estado"] = $row["estado_enrolado"];
            $registros[] = $registro;
        }
        echo json_encode($registros);
    }
    public function get_sujetos_excel_enrolados()
    {
        $this->load->model('tbl_carga_excel');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $tabla = "";
        $i = 0;
        $lista = $this->tbl_carga_excel->get_lista_sujetos_desde_excel_enrolados();
        /* echo "<pre>";
        print_r($lista);
        echo "</pre>"; */
        $registros = array();
        foreach ($lista as $row) {
            $i++;
            $registro = array();
            $registro["id"] = $row["id"];
            $registro["nombres"] = $row["nombres"];
            $registro["apellidos"] = $row["apellidos"];
            $registro["codigo_rfid"] = $row["codigo_rfid"];
            $registro["dni"] = $row["dni"];
            $registro["cargo"] = $row["cargo"];
            $registro["ubigeo"] = $row["ubigeo"];
            $registro["imagen"] = $row["imagen"];
            $registro["estado"] = $row["estado_enrolado"];
            $registro["fecha_enrolacion"] = $row["fecha_enrolacion"];
            $registros[] = $registro;
        }
        echo json_encode($registros);
    }
    public function get_sujetos_enrolados()
    {
        $this->load->model('tbl_enrolados');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $tabla = "";
        $i = 0;
        $lista = $this->tbl_enrolados->get_lista_sujetos_enrolados();
        $registros = array();
        foreach ($lista as $row) {
            $i++;
            $registro = array();
            $registro["id"] = $i;
            $registro["nombres"] = $row["nombres"];
            $registro["apellidos"] = $row["apellidos"];
            $registro["codigo_rfid"] = $row["codigo_rfid"];
            $registro["dni"] = $row["dni"];
            $registro["cargo"] = $row["cargo"];
            $registro["ubigeo"] = $row["ubigeo"];
            $registro["imagen"] = $row["imagen"];
            $registro["status"] = $row["estado"];
            $registro["date"] = $row["fecha_enrolacion"];
            $registros[] = $registro;
            /* $tabla .= '{"id":"' . $i . '","nombres":"' . $row['nombres'] . '","apellidos":"' . $row['apellidos'] . '","dni":"' . $row['dni'] . '","cargo":"' . $row['cargo'] . '","codigo_rfid":"' . $row['codigo_rfid'] . '","ubigeo":"' . $row['ubigeo'] . '","imagen":"' . $row['imagen'] . '","status":"' . $row['estado'] . '","date":"' . $row['fecha_enrolacion'] . '"},'; */
        }
        /* $tabla = substr($tabla, 0, strlen($tabla) - 1);
        echo '{"data":[' . $tabla . ']}'; */
        echo json_encode($registros);
    }

    public function guardar_enrolados()
    {
        /* var_dump($_POST);
        var_dump($_FILES); 
        print_r($_FILES);//se pone print_r
        print_r($_POST['codigo']);
        print_r($_FILES['imagen']['name']); */
        $this->load->model('tbl_enrolados');
        $cod = $_POST['codigo_rfid'];
        $dni = $_POST['dni'];
        $imagen = $_FILES['imagen']['name'];
        $codigo = $this->tbl_enrolados->get_cod_repetido($cod);
        $cod_dni = $this->tbl_enrolados->get_cod_dni_vinculado($dni);
        /* print_r($codigo);
        print_r($cod_dni); */

        //SI EL CODIGO INGRESADO YA ESTA REGISTRADO!!!!!!!!!!!!!
        if (!empty($codigo) or !empty($cod_dni)) {
            $rpta = "!!!!CODIGO RFID ó DNI VINCULADO!!!!!";
            // !!!!!!!!NUEVO CODIGO!!!!!!!!!!!!!!!
        } else {
            //echo "INGRESE AQUI CUANDO EL CODIGO ES NUEVO";
            $cod = $_POST['codigo_rfid'];
            $dni = $_POST['dni'];
            $nombres = $_POST['nombres'];
            $apellidos = $_POST['apellidos'];
            $ubigeo = $_POST['ubigeo'];
            $cargo = $_POST['cargo'];
            $imagen = $_FILES['imagen']['name'];
            $status = "1";
            //print_r($imagen);
            //$rpta = "Error al guardar la información";
            //$codigo = $this->obj_enrolados->get_cod_dni($cod);
            //print_r($codigo->codigo);
            $nombre_imagen = pathinfo($imagen, PATHINFO_FILENAME);
            $extension_guardar = pathinfo($imagen, PATHINFO_EXTENSION);
            //print_r($nombre_imagen);
            //print_r($extension_guardar);
            $data1 = array(
                'dni' => $dni,
                'nombres' => $nombres,
                'apellidos' => $apellidos,
                'cargo' => $cargo,
                'ubigeo' => $ubigeo,
                'imagen'  => $dni . "." . $extension_guardar,
                'estado_enrolado' => $status
            );
            $data2 = array(
                'codigo_rfid' => $cod, //son names
                'dni' => $dni,
                'estado' => $status,
                'fecha_enrolacion' => date("Y-m-d H:i:s")
            );
            //print_r($data);
            //Jalar carpeta
            $carpeta = "static/main/img";
            if (!file_exists($carpeta)) {
                mkdir($carpeta, 0777, true);
            }
            $config['upload_path']          = 'static/main/img/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['max_size']             = 50000;
            $config['max_width']            = 5048;
            $config['max_height']           = 5068;
            $config['file_name']           = $dni . "." . $extension_guardar;
            $config['overwrite']           = TRUE;

            $this->load->library('upload', $config);

            //cargar archivo
            if (!$this->upload->do_upload('imagen')) {
                $error = array('error' => $this->upload->display_errors());
                print_r($error);
            } else {
                $result = array('upload_data' => $this->upload->data());
            }
            try {
                $result =  $this->tbl_enrolados->add_sujeto_enrolado($data2);
                $result1 =  $this->tbl_enrolados->add_sujeto($data1);
                if ($result and $result1)
                    $rpta = "SUJETO ENROLADO!!";
                else
                    $rpta = "ERROR AL GUARDAR LA INFORMACIÓN";
            } catch (Exception $e) {
                $rpta = 'Error de Transacción';
            }
            //redirect("admin/inventario/ingresar_activos"); // lo envia a la misma pagina
        }
        echo $rpta;
    }


    public function vincular_sujeto_x_ajax()
    {
        $this->load->model('tbl_enrolados');
        $codigo_rfid = $this->tbl_enrolados->get_cod_repetido($this->input->post('rfid'));
        $dni_vinculado = $this->tbl_enrolados->get_cod_dni($this->input->post('dni'));
        //print_r($codigo_rfid);
        // !!!!  ETIQUETA YA VINCULADA
        if (!empty($codigo_rfid) || !empty($dni_vinculado)) {
            $rpta = "Esta Etiqueta ya esta VINCULADA | DNI VINCULADO!!!!";
        } else {
            $data = array(
                'codigo_rfid' => $this->input->post('rfid'),
                'dni' => $this->input->post('dni'),
                'estado' => '1',
                'fecha_enrolacion' => date('Y-m-d H:i:s')
            );
            //print_r($data);
            try {
                $status = "1";
                $imagen = $_FILES['imagen']['name'];
                $extension = pathinfo($imagen, PATHINFO_EXTENSION);

                //Jalar carpeta
                $carpeta = "static/main/img";
                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0777, true);
                }
                $config['upload_path']          = 'static/main/img/';
                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                $config['max_size']             = 50000;
                $config['max_width']            = 5048;
                $config['max_height']           = 5068;
                $config['file_name']           = $this->input->post('dni') . "." . $extension;
                $config['overwrite']           = TRUE;

                $this->load->library('upload', $config);

                //cargar archivo
                if (!$this->upload->do_upload('imagen')) {
                    $error = array('error' => $this->upload->display_errors());
                    print_r($error);
                    //redirect("admin/" . $this->controller . "/editar/" . $id);
                } else {
                    $result = array('upload_data' => $this->upload->data());
                    // redirect("admin/" . $this->controller . "/editar/" . $id); 
                }

                $update_status =  $this->obj_enrolados->update_status($this->input->post('dni'), $status);
                $update_imagen =  $this->obj_enrolados->update_imagen($this->input->post('dni'), $this->input->post('dni') . "." . $extension);
                $result =  $this->tbl_enrolados->add_sujeto_enrolado($data);
                if ($result)
                    $rpta = "Vinculación exitosa!!!";
                else
                    $rpta = "Error al vincular Activo";
            } catch (Exception $e) {
                $rpta = 'Error de Transacción';
            }
        }
        echo $rpta;
    }

    public function vincular_sujeto_x($dni)
    {
        $this->load->model('tbl_enrolados');
        $this->form_validation->set_rules('dni', 'CODIGO', 'trim|required');
        $this->form_validation->set_message('required', 'Este campo es requerido');
        if ($this->form_validation->run($this) == FALSE) {
            $codigo = $this->tbl_enrolados->get_cod_dni_sujeto($dni);
            //print_r($codigo);
            $this->load->tmp_admin->set('codigo', $codigo);
            $this->load->tmp_admin->render('vincular_sujeto_x_view');
            //print_r($this->input->post('codigo_producto'));
        }
    }

    public function editar($dni)
    {
        $this->form_validation->set_rules('dni', 'CODIGO', 'trim|required');
        $this->form_validation->set_message('required', 'Este campo es requerido');
        if ($this->form_validation->run($this) == FALSE) {
            $codigo = $this->obj_enrolados->get_cod_dni($dni);
            $this->load->tmp_admin->set('codigo', $codigo);
            $codigo_rfid = $this->obj_enrolados->get_cod_rfid_vinculado_editar($dni);
            $this->load->tmp_admin->set('codigo_rfid', $codigo_rfid);
            //print_r($codigo_rfid);
            $this->load->tmp_admin->render('editar_sujeto_view');
            //print_r($codigo);
            //print_r($this->input->post('name_file'));
        } else {
            $codigo = $this->obj_enrolados->get_cod_dni($dni);
            $this->load->tmp_admin->set('codigo', $codigo);
            $codigo_rfid = $this->obj_enrolados->get_cod_rfid_vinculado_editar($dni);
            $this->load->tmp_admin->set('codigo_rfid', $codigo_rfid);
            $nombre_imagen = pathinfo($_FILES["name_file"]["name"], PATHINFO_FILENAME);
            $extension = pathinfo($_FILES["name_file"]["name"], PATHINFO_EXTENSION);
            $nombre_archivo = $nombre_imagen . "." . $extension;
            //print_r($nombre_archivo);
            /* $this->load->tmp_admin->set('extension', $extension);
            $this->load->tmp_admin->render('editar_activo_view'); */

            //Si no hacemos ningun cambio  y "SI NO CARGAMOS NINGUNA IMAGEN" SI NO CAMBIO NADA!!
            // Y NO HACEMOS NADA
            if ($nombre_imagen == "" and ($codigo->nombres) == ($this->input->post('nombres')) and ($codigo->apellidos) == ($this->input->post('apellidos')) and ($codigo->cargo) == ($this->input->post('cargo'))) {

                $codigo = $this->obj_enrolados->get_cod_dni($dni);
                //print_r($codigo->imagen);
                //print_r($extension);
                $datos_inventario = array();
                $datos_inventario['dni']  = $this->input->post('dni');
                $datos_inventario['nombres']  = $this->input->post('nombres');
                $datos_inventario['apellidos']  = $this->input->post('apellidos');
                $datos_inventario['imagen']  = $codigo->imagen;
                $datos_inventario['cargo']  = $this->input->post('cargo');
                //print_r($datos_inventario);
                $this->obj_enrolados->editar_sujeto($datos_inventario, $dni);
                redirect('admin/enrolamiento');
            } else {
                if ($nombre_archivo == ".") {
                    // SI EDITAMOS LOS DEMAS CAMPOS PERO NO CARGAMOS NUEVA IMAGEN
                    $codigo = $this->obj_enrolados->get_cod_dni($dni);
                    $nombre_imagen = pathinfo($_FILES["name_file"]["name"], PATHINFO_FILENAME);
                    $extension = pathinfo($_FILES["name_file"]["name"], PATHINFO_EXTENSION);
                    $nombre_archivo = $nombre_imagen . "." . $extension;
                    //print_r($codigo->imagen);
                    //print_r($extension);
                    $datos_inventario = array();
                    $datos_inventario['dni']  = $this->input->post('dni');
                    $datos_inventario['nombres']  = $this->input->post('nombres');
                    $datos_inventario['apellidos']  = $this->input->post('apellidos');
                    $datos_inventario['cargo']  = $this->input->post('cargo');
                    $datos_inventario['imagen']  = $codigo->imagen;
                    print_r($datos_inventario);
                    $this->obj_enrolados->editar_sujeto($datos_inventario, $dni);

                    //Jalar carpeta
                    $carpeta = "static/main/img";
                    if (!file_exists($carpeta)) {
                        mkdir($carpeta, 0777, true);
                    }
                    $config['upload_path']          = 'static/main/img/';
                    $config['allowed_types']        = 'gif|jpg|png|jpeg';
                    $config['max_size']             = 50000;
                    $config['max_width']            = 5048;
                    $config['max_height']           = 5068;
                    $config['file_name']           = $codigo->imagen;
                    $config['overwrite']           = TRUE;

                    $this->load->library('upload', $config);

                    //cargar archivo
                    if (!$this->upload->do_upload('name_file')) {
                        $error = array('error' => $this->upload->display_errors());
                        print_r($error);
                        //redirect("admin/" . $this->controller . "/editar/" . $id);
                    } else {
                        $result = array('upload_data' => $this->upload->data());
                        // redirect("admin/" . $this->controller . "/editar/" . $id); 
                    }
                    redirect('admin/enrolamiento');
                } else {
                    // SI EDITAMOS LOS DEMAS CAMPOS Y CARGAMOS NUEVA IMAGEN
                    $nombre_imagen = pathinfo($_FILES["name_file"]["name"], PATHINFO_FILENAME);
                    $extension = pathinfo($_FILES["name_file"]["name"], PATHINFO_EXTENSION);
                    $nombre_archivo = $nombre_imagen . "." . $extension;
                    $datos_inventario = array();
                    $datos_inventario['dni']  = $this->input->post('dni');
                    $datos_inventario['nombres']  = $this->input->post('nombres');
                    $datos_inventario['apellidos']  = $this->input->post('apellidos');
                    $datos_inventario['cargo']  = $this->input->post('cargo');
                    $datos_inventario['imagen']  = $this->input->post('dni') . "." . $extension;
                    print_r($datos_inventario);
                    $this->obj_enrolados->editar_sujeto($datos_inventario, $dni);

                    //Jalar carpeta
                    $carpeta = "static/main/img";
                    if (!file_exists($carpeta)) {
                        mkdir($carpeta, 0777, true);
                    }
                    $config['upload_path']          = 'static/main/img/';
                    $config['allowed_types']        = 'gif|jpg|png|jpeg';
                    $config['max_size']             = 50000;
                    $config['max_width']            = 5048;
                    $config['max_height']           = 5068;
                    $config['file_name']           = $this->input->post('dni') . "." . $extension;
                    $config['overwrite']           = TRUE;

                    $this->load->library('upload', $config);

                    //cargar archivo
                    if (!$this->upload->do_upload('name_file')) {
                        $error = array('error' => $this->upload->display_errors());
                        print_r($error);
                        //redirect("admin/" . $this->controller . "/editar/" . $id);
                    } else {
                        $result = array('upload_data' => $this->upload->data());
                        // redirect("admin/" . $this->controller . "/editar/" . $id); 
                    }
                    redirect('admin/enrolamiento');
                }
            }
        }
    }

    public function eliminar($dni)
    {
        $status = "0";
        $this->obj_enrolados->update_status($dni, $status);
        $this->obj_enrolados->eliminar($dni);
        redirect('admin/enrolamiento');
    }

    public function logout()
    {
        $this->session->unset_userdata('logged');
        redirect('admin');
    }
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */