<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tiemporeal extends MX_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('tbl_inventario');
        $this->load->model('tbl_usuario','obj_usuario');
        $this->load->model('tbl_vinculacion','obj_vinculo');


       if($this->session->userdata('logged') != 'true'){
           redirect('login');
        }		
    }

    public function rfid_tiempo_real() {     
        $this->load->model('tbl_alerta');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $this->load->tmp_admin->render('rfid_tiempo_real_view');        
    }  
     public function portico_tiempo_real() {     
        $this->load->model('tbl_portico_tiempo_real');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $this->load->tmp_admin->render('portico_tiempo_real_view');        
    }
    public function preinventario_ubigeo_ubicacion() {     
        $this->load->model('tbl_inventario_tiempo_real');
        $this->load->model('tbl_vinculacion');
        $atributos = $this->obj_vinculo->get_atributos_actividad("PRE - INVENTARIADO");
        $this->load->tmp_admin->set('atributos', $atributos);
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $this->load->tmp_admin->render('programar_preinventario_ubigeo_view');        
    }
    public function recibo_deposito() {     
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $this->load->tmp_admin->render('recibo_deposito_view');        
    }
    public function preinventario_tiempo_real() {     
        $this->load->model('tbl_inventario_tiempo_real');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
         $this->tbl_inventario_tiempo_real->update_estado_inventario();
        $this->tbl_inventario_tiempo_real->update_fecha_lectura_abc();
        $this->load->tmp_admin->render('preinventario_tiempo_real_view');        
    }
    public function programacion_inventario_tiempo_real() {  
        $this->load->model('tbl_inventario_tiempo_real');
        $this->load->model('tbl_vinculacion');
        $atributos = $this->obj_vinculo->get_atributos_actividad("INVENTARIADO");
        $this->load->tmp_admin->set('atributos', $atributos);
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        //$this->load->tmp_admin->render('inventario_tiempo_real_view');   
        $this->load->tmp_admin->render('programar_inventario_ubigeo_view');
    }  
    public function inventarios_programados_tiempo_real() {    
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        //$this->load->tmp_admin->render('inventario_tiempo_real_view');   
        $this->load->tmp_admin->render('inventarios_programados_view');
    }  
    public function inventario_tiempo_real($id) {  
        $this->load->model('tbl_inventario_tiempo_real');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $this->tbl_inventario_tiempo_real->update_estado_inventario();
        $this->tbl_inventario_tiempo_real->update_fecha_lectura_abc();
        $num_vinculados = $this->get_vinculados();
        //print_r($num_vinculados);
        // ENVIO TOTAL DE ACTIVOS VINCULADOS ANTES DE QUE ME CARGUE LA VISTA INVENTARIO_TIEMPO_REAL   
        $this->tmp_admin->set('num_vinculados', $num_vinculados[0]["cant_vinculados"]);    
        // ENVIO ID DEL INVENTARIO SELECCIONADO
        $this->tmp_admin->set('id_inventario', $id); 
        $this->load->tmp_admin->render('inventario_tiempo_real_view');   
    }  
    public function get_vinculados(){
        $this->load->model('tbl_inventario');    
        $num_vinculados = $this->tbl_inventario->get_all_vinculados();
        return $num_vinculados;
    }

    public function logout(){                     
        $this->session->unset_userdata('logged');
        redirect('admin');
   }

   
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
 