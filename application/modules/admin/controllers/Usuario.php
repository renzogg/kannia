<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario extends MX_Controller {
    private $clase = "usuario";

    public function __construct(){
        parent::__construct();
        $logged = $this->session->userdata('logged');
 
        if(!$logged){
            redirect();
        }

        $this->load->model('tbl_'.$this->clase,'obj_'.$this->clase);
    }

	public function index(){
        $usuario_all = $this->obj_usuario->get_all_usuario();

        $this->load->tmp_admin->setLayout('templates/maestro_tmp');
        $this->load->tmp_admin->set('usuario_all',$usuario_all);
		$this->load->tmp_admin->render('usuario/usuario_view.php','usuario');
	}


    public function agregar(){
        $this->load->tmp_admin->setLayout('templates/maestro_tmp');
        $this->form_validation->set_rules('usuario', 'usuario', 'trim|required');

        $this->form_validation->set_message('required', 'Este campo es requerido');

        if ($this->form_validation->run($this) == FALSE)
        {
            $this->load->tmp_admin->render('usuario/usuario_agregar_view.php','usuario');
        }
        else
        {
            $datos_usuario = array();
            $datos_usuario['usuario']         = $this->input->post('usuario');
            $datos_usuario['contrasena']         = md5(helper_get_semilla().$this->input->post('contrasena'));
            $datos_usuario['estado'] =  $this->input->post('estado');

           $this->obj_usuario->insert_usuario($datos_usuario);

           redirect('admin/usuario');
        }
    }

    public function editar($id){
       $this->load->tmp_admin->setLayout('templates/maestro_tmp');
       $this->form_validation->set_rules('usuario', 'usuario', 'trim|required');
       $this->form_validation->set_message('required', 'Este campo es requerido');
       
        if ($this->form_validation->run($this) == FALSE)
        {
            $usuario = $this->obj_usuario->get_usuario($id);
            $this->load->tmp_admin->set('usuario',$usuario);

            /*$contrasena = $this->obj_usuario->get_all_contrasena();
            $this->loas->tmp_admin->set('contrasena',$contrasena);*/

            $this->load->tmp_admin->render('usuario/usuario_editar_view.php','usuario');
        }
        else
        {
            $datos_usuario = array();
            $datos_usuario['usuario']         = $this->input->post('usuario');
            $datos_usuario['contrasena'] = $this->input->post('contrasena');
            $datos_usuario['estado'] = $this->input->post('estado');

            $this->obj_usuario->editar_usuario($datos_usuario,$id);

            redirect('admin/usuario');
        }
    }

    public function eliminar($id){
        $this->obj_usuario->eliminar($id);
        redirect('admin/usuario');
    }
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */