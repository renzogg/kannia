<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inicio extends MX_Controller {
    public function __construct(){
        parent::__construct();

        $this->load->model('tbl_usuario','obj_usuario');
        $this->load->model('tbl_inventario');
       if($this->session->userdata('logged') != 'true'){
           redirect('login');
        }		
    }
	 
	public function index() { 
        $num_programados = $this->get_programados();
        //print_r($num_programados);
        $this->tmp_admin->set('num_programados', $num_programados[0]["cant_programados"]);
        $num_no_programados = $this->get_no_programados();
        //print_r($num_no_programados);
        $this->tmp_admin->set('num_no_programados', $num_no_programados[0]["cant_no_programados"]);
        $num_vinculados = $this->get_vinculados();
        //print_r($num_vinculados);
        $this->tmp_admin->set('num_vinculados', $num_vinculados[0]["cant_vinculados"]);
        $num_salidas = $this->get_salidas();
        //print_r($num_salidas);
        $this->tmp_admin->set('num_salidas', $num_salidas[0]["cant_salidas"]);
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        //$this->load->tmp_admin->render('home_view.php');  
        $this->load->tmp_admin->render('home.php'); 
  
    } 
    public function get_programados(){
        $this->load->model('tbl_inventario');    
        $num_programados = $this->tbl_inventario->get_all_programados();
        
        return $num_programados;
    }
    public function get_no_programados(){
        $this->load->model('tbl_inventario');    
        $num_no_programados = $this->tbl_inventario->get_all_no_programados();
        
        return $num_no_programados;
    }
    public function get_vinculados(){
        $this->load->model('tbl_inventario');    
        $num_vinculados = $this->tbl_inventario->get_all_vinculados();
        
        return $num_vinculados;
    }
    public function get_salidas(){
        $this->load->model('tbl_inventario');    
        $num_salidas = $this->tbl_inventario->get_salidas();
        
        return $num_salidas;
    }
  
    public function logout(){                     
        $this->session->unset_userdata('logged');
        redirect('admin');
   }
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
 