<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Estadisticas extends MX_Controller {
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
        $this->load->tmp_admin->render('estadisticas_view');        
    } 
    public function filaA() {     
        $this->load->model('tbl_temperatura');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $this->load->tmp_admin->render('estadisticasA_view');        
    }  
     public function filaB() {     
        $this->load->model('tbl_temperatura');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $this->load->tmp_admin->render('estadisticasB_view');        
    } 
    public function filaC() {     
        $this->load->model('tbl_temperatura');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $this->load->tmp_admin->render('estadisticasC_view');        
    }  
    public function filaD() {     
        $this->load->model('tbl_temperatura');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $this->load->tmp_admin->render('estadisticasD_view');        
    }  
    public function filaE() {     
        $this->load->model('tbl_temperatura');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $this->load->tmp_admin->render('estadisticasE_view');        
    }   

    public function prueba(){
         $this->load->model('tbl_temperatura');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $tabla = "";
        $i = 0;
        $lista = $this->tbl_temperatura->get_temperatura_chart();
        foreach ($lista as $row) {
            extract($row);
            $data[] = "[$time, $tempc]"; 
            $x = $time;
        // The y value is a random number
        $y = $tempc;


        }       
        
       
        $ret = array($x, $y);
        echo json_encode($ret);
    }

    public function prueba2(){
     
        header("Content-type: text/json");
        // The x value is the current JavaScript time, which is the Unix time multiplied 
        // by 1000.
        $x = time() * 1000;
        // The y value is a random number
        $y = rand(0, 100);

        // Create a PHP array and echo it as JSON
        $ret = array($x, $y);
        echo json_encode($ret);
    }
  
    

    public function logout(){                     
        $this->session->unset_userdata('logged');
        redirect('admin');
   }

    public function get_list_temperature_chart() {       
        $this->load->model('tbl_temperatura');
        
        //$rodillo =  $this->input->post('rodillo');  
        //$fecha =    $this->input->post('fecha');  

        $data = array(
            'rodillo' => $this->input->post('rodillo'),
            'fecha' => $this->input->post('fecha')
        );
      
        $lista = $this->tbl_temperatura->get_list_temperature_chart( $data );
        $num_result = count($lista);

        if ($num_result != 0) {
            $categories = array();
            foreach ($lista as $row) {
                $categories[] = $row["fecha"];
                $temperature[] = (double) $row["tempc"];
            }
            $graph_data = array('categories' => $categories, 'temperature' => $temperature, 'num_result' => $num_result);

            echo json_encode($graph_data);
        } else {
            $respuesta = array();
            $respuesta['rpta'] = 'no data';
            echo json_encode($respuesta);
        }
    }

    public function get_list_humedad_chart() {       
        $this->load->model('tbl_temperatura');
           $data = array(
            'rodillo' => $this->input->post('rodillo'),
            'fecha' => $this->input->post('fecha')
        );    
        $lista = $this->tbl_temperatura->get_list_humedad_chart($data);
        $num_result = count($lista);

        if ($num_result != 0) {
            $categories = array();
            foreach ($lista as $row) {
                $categories[] = $row["fecha"];
                $humedad[] = (double) $row["hm"];
            }
            $graph_data = array('categories' => $categories, 'humedad' => $humedad, 'num_result' => $num_result);

            echo json_encode($graph_data);
        } else {
            $respuesta = array();
            $respuesta['rpta'] = 'no data';
            echo json_encode($respuesta);
        }
    }

    public function get_last_value_temp_chart() {       
        header("Content-type: text/json");
        $this->load->model('tbl_temperatura');
         $rodillo =  $this->input->post('rodillo');  
        $lista = $this->tbl_temperatura->get_last_temp_value($rodillo);
        $x = $lista[0]["fecha"];
        $y = $lista[0]["tempc"];
        $ret = array($x, $y);    
        echo json_encode($ret);
    }

    public function get_last_value_hm_chart() {       
        header("Content-type: text/json");
        $this->load->model('tbl_temperatura');
         $rodillo =  $this->input->post('rodillo');     
        $lista = $this->tbl_temperatura->get_last_hm_value($rodillo);
        $x = $lista[0]["fecha"];
        $y = $lista[0]["hm"];
        $ret = array($x, $y);    
        echo json_encode($ret);
    }
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
 