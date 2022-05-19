<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends MX_Controller {
    public function __construct(){
        parent::__construct();

        $this->load->model('tbl_usuario','obj_usuario');
        //$this->load->model('tbl_sensorParser','obj_sensorParser');

       if($this->session->userdata('logged') != 'true'){
           redirect('login');
        }
		
    }
	 
	public function index(){ 
    //   $datos = $this->obj_sensorParser->get_all_sensorParser(2000)->result();

        $this->tmp_admin->set('usuario',$this->session->userdata('usuario'));
      //  $this->tmp_admin->set('datos',$datos);

      redirect('admin/inicio');
	}

   

    public function logout(){                     
      $this->session->unset_userdata('logged');
       redirect('admin');
   }

    public function chino(){                     
      echo "jose";
   }
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
 