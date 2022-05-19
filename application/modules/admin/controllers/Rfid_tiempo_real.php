<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rfid_Tiempo_Real extends MX_Controller {
    public function __construct(){
        parent::__construct();

        $this->load->model('tbl_usuario','obj_usuario');

        if($this->session->userdata('logged') != 'true'){
           redirect('login');
        }		
    }
	 
	public function index() {     
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $this->load->tmp_admin->render('rfid_tiempo_real_view');
    }

    public function get_list_real() {
        $this->load->model('tbl_alerta');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $tabla = "";
        $i = 0;
        $lista = $this->tbl_alerta->get_list_real();

        foreach ($lista as $key => $row) {
            $tabla.= '{"id":"' . $key. '","tag":"' . $row['tag']  . '","fecha":"' . $row['fecha'] . '"},';
        }
        
        $tabla = substr($tabla, 0, strlen($tabla) - 1);
        //header("Content-type: application/json");
        // echo json_encode($result);
        echo '{"data":[' . $tabla . ']}';
        //y normal
    }

    public function logout(){                     
        $this->session->unset_userdata('logged');
        redirect('admin');
   }
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
 