<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Portico_tiempo_real extends MX_Controller {
    public function __construct(){
        parent::__construct();

        $this->load->model('tbl_usuario','obj_usuario');

       if($this->session->userdata('logged') != 'true'){
           redirect('login');
        }		
    }
	 
	public function index() {     
        $this->load->model('tbl_portico_tiempo_real');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $this->load->tmp_admin->render('historial_portico_view');        
    }


    public function get_portico_tiempo_real() {
        $this->load->model('tbl_portico_tiempo_real');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $tabla = "";
        $i = 0;
        $lista = $this->tbl_portico_tiempo_real->get_portico_tiempo_real();
        foreach ($lista as $row) {
            $i++;
            $tabla.= '{"id":"' . $i. '","codRFID":"' . $row['cod_rfid']  . '","dni":"' . $row['dni']  . '","nombres":"' . $row['nombres']  . '","apellidos":"' . $row['apellidos']  . '","cargo":"' . $row['cargo']  . '","imagen":"' . $row['imagen']  . '","fecha_enrolacion":"' . $row['fecha_enrolacion']  . '","date":"' . $row['fecha'] . '"},';
        }
        $tabla = substr($tabla, 0, strlen($tabla) - 1);
        echo '{"data":[' . $tabla . ']}';
    }
    
    public function logout(){                     
        $this->session->unset_userdata('logged');
        redirect('admin');
   }
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
 