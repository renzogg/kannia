<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuarios extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('tbl_usuarios');
		if($this->session->userdata('logged') != 'true'){
			redirect('login');
		}
	}

	public function index(){
		$this->load->library('form_validation');

		$this->load->tmp_admin->setLayout('templates/admin_tmp');
//$this->load->tmp_admin->render('config_view');
	}

	public function insertar() {
		$data=array(
			'usuario'=>$this->input->post('usuario'),
			'contrasena'=>$this->input->post('contrasena'),
			//'perfil'=>$this->input->post('perfil'),
			);

		var_dump($data);
		$this->load->model('tbl_usuarios');
		$this->tbl_usuarios->insertar($data);
		redirect('admin/config'); 
	}

}

?>