<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Alerta extends MX_Controller
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
        $this->load->model('tbl_alerta');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $this->load->tmp_admin->render('alerta_view');
    }

    public function get_tags()
    {
        $this->load->model('tbl_alerta');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $tabla = "";
        $i = 0;
        $lista = $this->tbl_alerta->get_list_tags();
        foreach ($lista as $row) {
            $i++;
            $tabla .= '{"id":"' . $i . '","tag":"' . $row['tag']  . '","fecha":"' . $row['fecha'] . '"},';
        }
        $tabla = substr($tabla, 0, strlen($tabla) - 1);
        //header("Content-type: application/json");
        // echo json_encode($result);
        echo '{"data":[' . $tabla . ']}';
    }

    public function get_ultimo_chip()
    {
        $this->load->model('tbl_alerta');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $i = 0;
        $chip = $this->tbl_alerta->get_list_ultimo_chip();
        /*         echo "</pre>";
        print_r($chip);
        echo "<pre>"; */
        $tag = $chip[0]["tag"];
        /* echo "</pre>";
        print_r($chip[0]["tag"]);
        echo "<pre>"; */

        //header("Content-type: application/json");
        //MANDAMOS AL TAG COMO RESPUESTA
        echo json_encode(array("respuesta" => $tag));
    }
    public function get_ultimo_chip_fecha()
    {
        $this->load->model('tbl_alerta');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $i = 0;
        $chip = $this->tbl_alerta->get_fecha_ultimo_chip();
        /*         echo "</pre>";
        print_r($chip);
        echo "<pre>"; */
        $ultima_lectura = $chip[0]["ultima_lectura"];
        /* echo "</pre>";
        print_r($chip[0]["tag"]);
        echo "<pre>"; */

        //header("Content-type: application/json");
        //MANDAMOS A LA ULTIMA FECHA  COMO RESPUESTA
        echo json_encode(array("respuesta" => $ultima_lectura));
    }
    public function logout()
    {
        $this->session->unset_userdata('logged');
        redirect('admin');
    }
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
