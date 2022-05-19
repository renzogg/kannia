<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Paciente extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('tbl_usuario', 'obj_usuario');

        if ($this->session->userdata('logged') != 'true') {
            redirect('login');
        }
    }

    public function index()
    {
        $this->load->model('tbl_pacientes');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $this->load->tmp_admin->render('control_sujetos_cama_brazalete_view');
    }

    public function get_paciente_cama_brazalete()
    {
        $this->load->model('tbl_pacientes');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $chips = $this->tbl_pacientes->get_ultimos_dos_chips();
        /* echo "<pre>";
        print_r($this->tbl_pacientes->get_cama("000000000000030108002527"));
        print_r($chips[1]["codigo_rfid"]);
        echo "</pre>"; */
        $tag1 = $chips[0]["codigo_rfid"];
        $tag2 = $chips[1]["codigo_rfid"];
        //$tag1 = "E280117000000214BA6138C0";
        //$tag2 = "E280117000000213D49CD317";
        $cama1 = $this->tbl_pacientes->get_cama($tag1);
        //print_r($chips);
        //print_r($cama1);
        $cama2 = $this->tbl_pacientes->get_cama($tag2);
        //print_r($this->tbl_pacientes->get_brazalete($tag2));
        if (!empty($cama1) && !empty($this->tbl_pacientes->get_brazalete($tag2))) {
            //echo "entro";
            $brazalete = $this->tbl_pacientes->get_brazalete($tag2);
            //print_r($brazalete);
            if ($cama1[0]["codigo_paciente"] == $brazalete[0]["codigo_paciente"]) {
                //echo "entro";
                $paciente = $this->tbl_pacientes->get_paciente($cama1[0]["codigo_paciente"]);
                //print_r($paciente);
                $registros = array();
                $registro = array();
                $registro["nombres"] =  $paciente[0]["nombres"];
                $registro["apellidos"] = $paciente[0]["apellidos"];
                $registro["imagen"] = $paciente[0]["imagen"];
                $registro["cama_paciente"] = $cama1[0]["descripcion"];
                $registro["brazalete_paciente"] = $brazalete[0]["descripcion"];
                $registro["rfid_cama"] = $cama1[0]["codigo_rfid"];
                $registro["rfid_brazalete"] = $brazalete[0]["codigo_rfid"];
                $registro["estado"] = "1";
                $registros[] = $registro;
                /* $datos = '{"nombres":"' . $nombres  . '","apellidos":"' . $apellidos  . '","cama_paciente":"' . $cama_paciente  . '","brazalete_paciente":"' . $brazalete_paciente  . '","rfid_cama":"' . $rfid_cama  . '","rfid_brazalete":"' . $rfid_brazalete  . '","estado":"' . $estado  . '"},';
                $datos = substr($datos, 0, strlen($datos) - 1);
                echo '{"data":[' . $datos . ']}'; */
                //header("Content-type: application/json");
                echo json_encode($registros);
            } else {
                $registros = array();
                $registro = array();
                $registro["estado"] = "0";
                $registros[] = $registro;
                /* $datos = '{"cama_paciente":"' . $cama_paciente  . '","brazalete_paciente":"' . $brazalete_paciente  . '","rfid_cama":"' . $rfid_cama  . '","rfid_brazalete":"' . $rfid_brazalete  . '","estado":"' . $estado  . '"},';
                $datos = substr($datos, 0, strlen($datos) - 1);
                echo '{"data":[' . $datos . ']}'; */
                echo json_encode($registros);
            }
        } else if (!empty($cama2) && !empty($this->tbl_pacientes->get_brazalete($tag1))) {
            $brazalete = $this->tbl_pacientes->get_brazalete($tag1);
            if ($cama2[0]["codigo_paciente"] == $brazalete[0]["codigo_paciente"]) {
                //print_r($this->tbl_pacientes->get_paciente($cama2[0]["codigo_paciente"]));
                $paciente = $this->tbl_pacientes->get_paciente($cama2[0]["codigo_paciente"]);
                $registros = array();
                $registro = array();
                $registro["nombres"] =  $paciente[0]["nombres"];
                $registro["apellidos"] = $paciente[0]["apellidos"];
                $registro["imagen"] = $paciente[0]["imagen"];
                $registro["cama_paciente"] = $cama2[0]["descripcion"];
                $registro["brazalete_paciente"] = $brazalete[0]["descripcion"];
                $registro["rfid_cama"] = $cama2[0]["codigo_rfid"];
                $registro["rfid_brazalete"] = $brazalete[0]["codigo_rfid"];
                $registro["estado"] = "1";
                $registros[] = $registro;
                /* $datos = '{"nombres":"' . $nombres  . '","apellidos":"' . $apellidos  . '","cama_paciente":"' . $cama_paciente  . '","brazalete_paciente":"' . $brazalete_paciente  . '","rfid_cama":"' . $rfid_cama  . '","rfid_brazalete":"' . $rfid_brazalete  . '","estado":"' . $estado  . '"},';
                $datos = substr($datos, 0, strlen($datos) - 1);
                echo '{"data":[' . $datos . ']}'; */
                echo json_encode($registros);
            } else {
                $registros = array();
                $registro = array();
                $registro["estado"] = "0";
                $registros[] = $registro;
                /* $datos = '{"cama_paciente":"' . $cama_paciente  . '","brazalete_paciente":"' . $brazalete_paciente  . '","rfid_cama":"' . $rfid_cama  . '","rfid_brazalete":"' . $rfid_brazalete  . '","estado":"' . $estado  . '"},';
            $datos = substr($datos, 0, strlen($datos) - 1);
            echo '{"data":[' . $datos . ']}'; */
                echo json_encode($registros);
            }
        } else {
            $registros = array();
            $registro = array();
            $registro["estado"] = "0";
            $registros[] = $registro;
            echo json_encode($registros);
        }
        //header("Content-type: application/json");
        //MANDAMOS AL TAG COMO RESPUESTA
        //echo json_encode(array("respuesta" => $tag));
    }
    public function logout()
    {
        $this->session->unset_userdata('logged');
        redirect('admin');
    }
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
