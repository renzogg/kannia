<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Inventario_con_modal extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('tbl_usuario', 'obj_usuario');
        $this->load->model('tbl_inventario', 'obj_inventario');
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
    public function ingresar_activos()
    {
        $this->load->model('tbl_inventario');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $this->load->tmp_admin->render('ingresar_activo_view');
    }
    public function editar_activos()
    {
        $this->load->model('tbl_inventario');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $this->load->tmp_admin->render('editar_eliminar_inventario_view');
    }

    public function tabla_inventario()
    {
        $this->load->model('tbl_inventario');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $this->load->tmp_admin->render('inventario_view');
    }

    public function get_list_inventario()
    {
        $this->load->model('tbl_inventario');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $tabla = "";
        $i = 0;
        $lista = $this->tbl_inventario->get_lista_inventario();
        foreach ($lista as $row) {
            $i++;
            $tabla .= '{"id":"' . $i . '","cod":"' . $row['codigo'] . '","descripcion":"' . $row['descripcion'] . '","imagen":"' . $row['imagen'] . '","date":"' . $row['fecha_inventario'] . '"},';
        }
        $tabla = substr($tabla, 0, strlen($tabla) - 1);
        //header("Content-type: application/json");
        // echo json_encode($result);
        echo '{"data":[' . $tabla . ']}';
    }

    public function guardar_inventario()
    {
        /*var_dump($_POST);
        var_dump($_FILES); */
        //print_r($_FILES);//se pone print_r
        //print_r($_POST['codigo']);
        //print_r($_POST['descripcion']);
        //print_r($_FILES['imagen']['name']);
        //print_r($codigo->codigo);
        $this->load->model('tbl_inventario');
        $cod = $_POST['codigo'];
        $descripcion = $_POST['descripcion'];
        $imagen = $_FILES['imagen']['name'];
        $codigo = $this->obj_inventario->get_cod_repetido($cod);
        //print_r($codigo);
        //SI EL CODIGO INGRESADO YA ESTA REGISTRADO!!!!!!!!!!!!!
        
        if ($codigo!=null) {
            $rpta = "!!!!CODIGO REGISTRADO!!!!!";

            // !!!!!!!!NUEVO CODIGO!!!!!!!!!!!!!!!
        } else {
            //echo "INGRESE AQUI CUANDO EL CODIGO ES NUEVO";
            $cod = $_POST['codigo'];
            $descripcion = $_POST['descripcion'];
            $imagen = $_FILES['imagen']['name'];
            //print_r($imagen);
            //$rpta = "Error al guardar la información";
            //$codigo = $this->obj_inventario->get_cod_inventario($cod);
            //print_r($codigo->codigo);
            $nombre_imagen = pathinfo($imagen, PATHINFO_FILENAME);
            $extension_guardar = pathinfo($imagen, PATHINFO_EXTENSION);
            //print_r($nombre_imagen);
            //print_r($extension_guardar);
            $data = array(
                'codigo' => $cod, //son names
                'descripcion' => $descripcion,
                'imagen'  => $cod . "." . $extension_guardar
            );
            print_r($data);
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
            $config['file_name']           = $cod . "." . $extension_guardar;
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
            //redirect('admin/inventario/ingresar_activos');
            try {
                $result =  $this->tbl_inventario->add_inventario($data);
                if ($result)
                    $rpta = "Se guardó correctamente";
                else
                    $rpta = "Error al guardar la información";
            } catch (Exception $e) {
                $rpta = 'Error de Transacción';
            }
            //redirect("admin/inventario/ingresar_activos"); // lo envia a la misma pagina
        }
        echo $rpta;
    }

    public function editar($cod_inventario)
    {
        $this->form_validation->set_rules('txt_cod_inve', 'CODIGO', 'trim|required');

        $this->form_validation->set_message('required', 'Este campo es requerido');
        if ($this->form_validation->run($this) == FALSE) {
            $codigo = $this->obj_inventario->get_cod_inventario($cod_inventario);
            $this->load->tmp_admin->set('codigo', $codigo);
            $this->load->tmp_admin->render('editar_activo_view');
            //print_r($codigo);
            //print_r($this->input->post('name_file'));
        } else {
            $codigo = $this->obj_inventario->get_cod_inventario($cod_inventario);
            $nombre_imagen = pathinfo($_FILES["name_file"]["name"], PATHINFO_FILENAME);
            $extension = pathinfo($_FILES["name_file"]["name"], PATHINFO_EXTENSION);
            $nombre_archivo = $nombre_imagen . "." . $extension;
            //print_r($nombre_archivo);
            /* $this->load->tmp_admin->set('extension', $extension);
            $this->load->tmp_admin->render('editar_activo_view'); */

            //Si no hacemos ningun cambio  y "SI NO CARGAMOS NINGUNA IMAGEN" SI NO CAMBIO NADA!!
            // Y NO HACEMOS NADA

            if ($nombre_imagen == "" and ($codigo->codigo) == ($this->input->post('txt_cod_inve')) and ($codigo->descripcion) == ($this->input->post('txt_descripcion'))) {

                $codigo = $this->obj_inventario->get_cod_inventario($cod_inventario);
                //print_r($codigo->imagen);
                //print_r($extension);
                $datos_inventario = array();
                $datos_inventario['codigo']  = $this->input->post('txt_cod_inve');
                $datos_inventario['descripcion']  = $this->input->post('txt_descripcion');
                $datos_inventario['imagen']  = $codigo->imagen;
                $datos_inventario['fecha_inventario'] = date('Y-m-d H:i:s');
                //print_r($datos_inventario);
                $this->obj_inventario->editar_inventario($datos_inventario, $cod_inventario);
                redirect('admin/inventario/editar_activos');
            } else {
                // SI EL CODIGO DE INVENTARIO YA ESTA INGRESADO NO SE PUEDE REPETIR EL CODIGO
                $codigo = $this->obj_inventario->get_cod_inventario($cod_inventario);
                $nombre_imagen = pathinfo($_FILES["name_file"]["name"], PATHINFO_FILENAME);
                $extension = pathinfo($_FILES["name_file"]["name"], PATHINFO_EXTENSION);
                $nombre_archivo = $nombre_imagen . "." . $extension;
                print_r($nombre_archivo);
                if ($this->input->post('txt_cod_inve') != ($codigo->codigo)) {
                    $ingreso = "ingreso al condicional";
                    print_r($ingreso);
                    $message = "NO SE PUEDE EDITAR CODIGO_INVENTARIO";
                    echo "             
                    <script>
                        $(function() {
                            $('#dialog').dialog();//if you want you can have a timeout to hide the window after x seconds
                        });
                    </script>
                        <div id='dialog' title='Basic dialog'><p><?php echo $message;?></p></div>
                    ";

                    redirect('admin/inventario/editar_activos');
                } else  if ($nombre_archivo == ".") {
                    // SI EDITAMOS EL CAMPO DESCRIPCION PERO NO CARGAMOS NUEVA IMAGEN
                    $codigo = $this->obj_inventario->get_cod_inventario($cod_inventario);
                    $nombre_imagen = pathinfo($_FILES["name_file"]["name"], PATHINFO_FILENAME);
                    $extension = pathinfo($_FILES["name_file"]["name"], PATHINFO_EXTENSION);
                    $nombre_archivo = $nombre_imagen . "." . $extension;
                    //print_r($codigo->imagen);
                    //print_r($extension);
                    $datos_inventario = array();
                    $datos_inventario['codigo']  = $this->input->post('txt_cod_inve');
                    $datos_inventario['descripcion']  = $this->input->post('txt_descripcion');
                    $datos_inventario['imagen']  = $codigo->imagen;
                    $datos_inventario['fecha_inventario'] = date('Y-m-d H:i:s');
                    print_r($datos_inventario);
                    $this->obj_inventario->editar_inventario($datos_inventario, $cod_inventario);

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
                    redirect('admin/inventario/editar_activos');
                } else {
                    // SI EDITAMOS EL CAMPO DESCRIPCION Y CARGAMOS NUEVA IMAGEN
                    $codigo = $this->obj_inventario->get_cod_inventario($cod_inventario);
                    $nombre_imagen = pathinfo($_FILES["name_file"]["name"], PATHINFO_FILENAME);
                    $extension = pathinfo($_FILES["name_file"]["name"], PATHINFO_EXTENSION);
                    $nombre_archivo = $nombre_imagen . "." . $extension;
                    //print_r($codigo->imagen);
                    //print_r($extension);
                    $datos_inventario = array();
                    $datos_inventario['codigo']  = $this->input->post('txt_cod_inve');
                    $datos_inventario['descripcion']  = $this->input->post('txt_descripcion');
                    $datos_inventario['imagen']  = $this->input->post('txt_cod_inve') . "." . $extension;
                    $datos_inventario['fecha_inventario'] = date('Y-m-d H:i:s');
                    print_r($datos_inventario);
                    $this->obj_inventario->editar_inventario($datos_inventario, $cod_inventario);

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
                    $config['file_name']           = $this->input->post('txt_cod_inve') . "." . $extension;
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
                    redirect('admin/inventario/editar_activos');
                }
            }
        }
    }

    public function eliminar($cod_inventario)
    {
        $this->obj_inventario->eliminar($cod_inventario);
        redirect('admin/inventario/editar_activos');
    }

    public function logout()
    {
        $this->session->unset_userdata('logged');
        redirect('admin');
    }
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */