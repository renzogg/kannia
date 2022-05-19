<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MX_Controller {
    public function __construct(){
        parent::__construct();

        $this->load->model('tbl_usuario','obj_usuario');
        if($this->session->userdata('logged') == 'true'){
            redirect('admin');
        }
    }
    
    public function index(){
        $this->form_validation->set_rules('usuario', 'Contenedor', 'trim|required');
        $this->form_validation->set_rules('contrasena', 'Contraseña', 'trim|required');
        $this->form_validation->set_message('required', 'Este campo es requerido');
        //echo md5(helper_get_semilla()."123456");
        if ($this->form_validation->run($this) == FALSE)
        {
            $this->load->view('login_view.php');
            //echo md5("radicalsavar")
          
        }
        else
        {
            $usuario =  $this->input->post('usuario');  
            $contrasena =  $this->input->post('contrasena');  
   
            if($this->obj_usuario->validar_usuario($usuario,$contrasena)){
               
              redirect('admin/inicio');
    
            }else{
               
               redirect('login');   
            }
        }
    }
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */