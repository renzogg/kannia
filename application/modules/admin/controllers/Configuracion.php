<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Configuracion extends MX_Controller {
    public function __construct(){
        parent::__construct();

        $this->load->model('tbl_usuario','obj_usuario');

       if($this->session->userdata('logged') != 'true'){
           redirect('login');
        }		
    }
	 
	public function index() {     
        $this->load->model('tbl_temperatura');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');     
        $this->load->tmp_admin->render('configuracion_view');        
    }
    

    public function logout(){                     
        $this->session->unset_userdata('logged');
        redirect('admin');
   }

   public function get_valores(){
        try {
            $this->load->model('tbl_configuracion');
            $result =  $this->tbl_configuracion->get_valores();
            header("Content-Type: application/json");
            echo json_encode($result);            
        } catch (Exception $e) {
            $rpta = 'Error de Transacción';
        }
   }

   public function guardar_enormal(){
        $this->load->model('tbl_configuracion');
        $data = array(
            'ID_ESTADO' => 1,
            'LIMITE_S' => $this->input->post('en_limite_superior'),
            'LIMITE_I' =>  $this->input->post('en_limite_inferior'),
            'COD_COLOR' =>  $this->input->post('en_color')
        );
        try {
            $result =  $this->tbl_configuracion->guardar_configuracion($data);
             if ($result)
                    $rpta = "Se guardó correctamente";
            else
                    $rpta = "Error al guardar la información";
            
        } catch (Exception $e) {
            $rpta = 'Error de Transacción';
        }

        echo $rpta;
    }

    public function guardar_eatencion(){
        $this->load->model('tbl_configuracion');
        $data = array(
            'ID_ESTADO' => 2,
            'LIMITE_S' => $this->input->post('ea_limite_superior'),
            'LIMITE_I' =>  $this->input->post('ea_limite_inferior'),
            'COD_COLOR' =>  $this->input->post('ea_color')
        );
        try {
            $result =  $this->tbl_configuracion->guardar_configuracion($data);
             if ($result)
                    $rpta = "Se guardó correctamente";
            else
                    $rpta = "Error al guardar la información";
            
        } catch (Exception $e) {
            $rpta = 'Error de Transacción';
        }

        echo $rpta;
    }

    public function guardar_epeligro(){
        $this->load->model('tbl_configuracion');
        $data = array(
            'ID_ESTADO' => 3,
            'LIMITE_S' => $this->input->post('ep_limite_superior'),
            'LIMITE_I' =>  $this->input->post('ep_limite_inferior'),
            'COD_COLOR' =>  $this->input->post('ep_color')
        );
        try {
            $result =  $this->tbl_configuracion->guardar_configuracion($data);
             if ($result)
                    $rpta = "Se guardó correctamente";
            else
                    $rpta = "Error al guardar la información";
            
        } catch (Exception $e) {
            $rpta = 'Error de Transacción';
        }

        echo $rpta;
    }
    
    
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
 