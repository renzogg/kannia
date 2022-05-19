<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dispositivo_rfid extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('tbl_usuario', 'obj_usuario');
        $this->load->model('tbl_dispositivo_rfid', 'obj_dispositivo_rfid');
        $this->load->model('tbl_inventario', 'obj_inventario');
        if ($this->session->userdata('logged') != 'true') {
            redirect('login');
        }
    }
    public function index()
    {
        $this->load->model('tbl_dispositivo_rfid');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $this->load->tmp_admin->render('dispositivos_rfid_view');
    }
    public function get_ultimo_mac()
    {
        $this->load->model('tbl_dispositivo_rfid');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $ultimo_mac = $this->obj_dispositivo_rfid->get_list_ultimo_mac();
        //print_r($ultimo_mac);
        $ultimo_mac = $ultimo_mac[0]["mac"];
        $ultimo_mac = substr($ultimo_mac, 7, 17);
        //header("Content-type: application/json");
        //MANDAMOS LA MAC ADDRESS COMO RESPUESTA
        echo json_encode(array("respuesta" => $ultimo_mac));
    }
    public function asignacion()
    {
        $this->load->model('tbl_inventario');
        $ubigeo = $this->obj_inventario->get_ubigeo();
        //print_r($ubigeo);
        $id_ubigeo = $this->obj_inventario->get_id_ubigeo("SJL");
        //print_r($id_ubigeo);
        //$ubicacion = $this->obj_inventario->get_ubicacion($id_ubigeo);
        $ubicacion = $this->obj_inventario->get_ubicacion();
        //print_r($ubicacion);

        $this->load->tmp_admin->set('ubigeo', $ubigeo);
        $this->load->tmp_admin->set('ubicacion', $ubicacion);
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        //$this->load->tmp_admin->render('inventario_tiempo_real_view');   
        $this->load->tmp_admin->render('asignar_dispositivo_rfid_view');
    }
    public function desvinculacion()
    {
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        //$this->load->tmp_admin->render('inventario_tiempo_real_view');   
        $this->load->tmp_admin->render('desvincular_dispositivo_view');
    }

    public function get_dispositivo_rfid()
    {
        $this->load->model('tbl_dispositivo_rfid');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $tabla = "";
        $i = 0;
        $lista = $this->tbl_dispositivo_rfid->get_lista_dispositivos();
        foreach ($lista as $row) {
            $i++;
            $tabla .= '{"id":"' . $i . '","id_device":"' . $row['id_device'] . '","mac":"' . $row['mac'] . '","ubigeo":"' . $row['ubigeo'] . '","ubicacion":"' . $row['ubicacion'] . '","actividad":"' . $row['actividad'] . '","usuario":"' . $row['usuario'] . '","estado":"' . $row['estado'] . '","date":"' . $row['fecha_asignacion'] . '"},';
        }
        $tabla = substr($tabla, 0, strlen($tabla) - 1);
        //header("Content-type: application/json");
        // echo json_encode($result);
        echo '{"data":[' . $tabla . ']}';
    }
    public function get_dispositivo_rfid_preinventario()
    {
        $this->load->model('tbl_dispositivo_rfid');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $tabla = "";
        $i = 0;
        $actividad = "PRE - INVENTARIADO";
        $lista = $this->tbl_dispositivo_rfid->get_lista_dispositivos_actividad($actividad);
        foreach ($lista as $row) {
            $i++;
            $tabla .= '{"id":"' . $i . '","id_device":"' . $row['id_device'] . '","mac":"' . $row['mac'] . '","ubigeo":"' . $row['ubigeo'] . '","ubicacion":"' . $row['ubicacion'] . '","actividad":"' . $row['actividad'] . '","usuario":"' . $row['usuario'] . '","estado":"' . $row['estado'] . '","date":"' . $row['fecha_asignacion'] . '"},';
        }
        $tabla = substr($tabla, 0, strlen($tabla) - 1);
        //header("Content-type: application/json");
        // echo json_encode($result);
        echo '{"data":[' . $tabla . ']}';
    }
    public function get_dispositivo_rfid_programacion_salida()
    {
        $this->load->model('tbl_dispositivo_rfid');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $tabla = "";
        $i = 0;
        $actividad = "PROGRAMACION DE SALIDA";
        $lista = $this->tbl_dispositivo_rfid->get_lista_dispositivos_actividad($actividad);
        foreach ($lista as $row) {
            $i++;
            $tabla .= '{"id":"' . $i . '","id_device":"' . $row['id_device'] . '","mac":"' . $row['mac'] . '","ubigeo":"' . $row['ubigeo'] . '","ubicacion":"' . $row['ubicacion'] . '","actividad":"' . $row['actividad'] . '","usuario":"' . $row['usuario'] . '","estado":"' . $row['estado'] . '","date":"' . $row['fecha_asignacion'] . '"},';
        }
        $tabla = substr($tabla, 0, strlen($tabla) - 1);
        //header("Content-type: application/json");
        // echo json_encode($result);
        echo '{"data":[' . $tabla . ']}';
    }
    public function get_dispositivo_rfid_programacion_salida_automatica()
    {
        $this->load->model('tbl_dispositivo_rfid');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $tabla = "";
        $i = 0;
        $actividad = "SALIDA DE ACTIVOS";
        $lista = $this->tbl_dispositivo_rfid->get_lista_dispositivos_actividad($actividad);
        foreach ($lista as $row) {
            $i++;
            $tabla .= '{"id":"' . $i . '","id_device":"' . $row['id_device'] . '","mac":"' . $row['mac'] . '","ubigeo":"' . $row['ubigeo'] . '","ubicacion":"' . $row['ubicacion'] . '","actividad":"' . $row['actividad'] . '","usuario":"' . $row['usuario'] . '","estado":"' . $row['estado'] . '","date":"' . $row['fecha_asignacion'] . '"},';
        }
        $tabla = substr($tabla, 0, strlen($tabla) - 1);
        //header("Content-type: application/json");
        // echo json_encode($result);
        echo '{"data":[' . $tabla . ']}';
    }

    public function add_dispositivo_rfid()
    {
        $this->load->model('tbl_dispositivo_rfid');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $mac = $_POST["mac"];
        // return $mac;
        if($mac=="MANUAL"){
            $dispositivo=[];
        }
        else{
            $dispositivo = $this->tbl_dispositivo_rfid->get_dispositivo($mac);
        }
  
        // print_r($dispositivo);
        // return;
        if (isset($_POST["ubigeo"]) and isset($_POST["ubicacion"]) and empty($dispositivo)) {
            $ubigeo = $_POST["ubigeo"];
            //echo "ENTRO";
            $ubicacion = $_POST["ubicacion"];
            $mac = $_POST["mac"];
            $user = $this->session->userdata('usuario');
            $estado = "1";
            $actividad = $_POST["actividad"];
            //INSERCIÓN EN BASE DE DATOS - SALIDAS MySql
            $data = array(
                'mac' => $mac,
                'ubigeo' => $ubigeo,
                'ubicacion' => $ubicacion,
                'usuario' => $user,
                'estado' => $estado,
                'actividad' => $actividad,
                'fecha_asignacion' => date("Y-m-d H:i:s")
            );
            
            if ($ubicacion == '0' || $ubigeo == '') {
                $rpta = "Eliga Ubicación | Ubigeo";
            } 
            elseif($actividad == ''){
                $rpta = "Debe elegir una Actividad";
            }
            else {
                try {
                    $result =  $this->tbl_dispositivo_rfid->add_dispositivo($data);
                    if ($result)
                        $rpta = "Se asigno dispositivo RFID";
                    else
                        $rpta = "Error en asignación";
                } catch (Exception $e) {
                    $rpta = 'Error de Transacción';
                }
            }
            echo $rpta;
        }
        else if($_POST["mac"] and empty($dispositivo)){
            $mac = $_POST["mac"];
            $user = $this->session->userdata('usuario');
            $estado = "1";
            $actividad = $_POST["actividad"];
            //INSERCIÓN EN BASE DE DATOS - SALIDAS MySql
            $data = array(
                'mac' => $mac,
                'ubigeo' => "SIN UBIGEO",
                'ubicacion' => "SIN UBICACIÓN",
                'usuario' => $user,
                'estado' => $estado,
                'actividad' => $actividad,
                'fecha_asignacion' => date("Y-m-d H:i:s")
            );
            try {
                $result =  $this->tbl_dispositivo_rfid->add_dispositivo($data);
                if ($result)
                    $rpta = "Se asigno dispositivo RFID";
                else
                    $rpta = "Error en asignación";
            } catch (Exception $e) {
                $rpta = 'Error de Transacción';
            }
            echo $rpta;
        } 
        else {
            $rpta = "Este dispositivo RFID ya se encuentra asignado";
            echo $rpta;
        }
    }
    public function eliminar($id_Device)
    {
        $this->load->model('tbl_dispositivo_rfid');
        $this->tbl_dispositivo_rfid->eliminar($id_Device);
        redirect('admin/dispositivo_rfid/asignacion');
    }
    public function logout()
    {
        $this->session->unset_userdata('logged');
        redirect('admin');
    }
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */