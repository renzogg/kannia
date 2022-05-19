<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Reporte extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('tbl_usuario', 'obj_usuario');

        if ($this->session->userdata('logged') != 'true') {
            redirect('login');
        }
    }

    public function index()
    {
        $this->load->model('tbl_temperatura');
        $this->load->tmp_admin->setLayout('templates/admin_tmp');
        $this->load->tmp_admin->render('historial_portico_view');
    }

    public function get_vinculados()
    {
        $this->load->model('tbl_inventario');
        $num_vinculados = $this->tbl_inventario->get_all_vinculados();
        return $num_vinculados;
    }

    public function reporte_inventario($id_inventario)
    {
        $this->load->model('tbl_alerta');
        $this->load->model('tbl_inventario_tiempo_real');
        $this->load->model('tbl_inventario');
        $this->load->model('tbl_vinculacion');

        require "Plantilla.php";
        
        $id_inventario = $this->tbl_inventario_tiempo_real->id_inventario_tiempo_real($id_inventario);
        //print_r($id_inventario);
        $num_vinculados = $this->get_vinculados();
        $this->tmp_admin->set('num_vinculados', $num_vinculados[0]["cant_vinculados"]);
        $this->load->tmp_admin->set('id_inventario', $id_inventario[0]["id"]);
        //$this->load->tmp_admin->render('plantilla.php');
        $actividad = "INVENTARIADO";
        $actividad = $this->tbl_vinculacion->get_actividad($actividad);
        $atributos = $this->tbl_vinculacion->get_actividad_actual("INVENTARIADO");
        $ubigeo = $atributos[0]["ubigeo"];
        $ubicacion = $atributos[0]["ubicacion"];
        $c_encontrados = $this->tbl_inventario_tiempo_real->get_encontrados_id_inventario($id_inventario[0]["id"])->encontrados;
        $c_no_encontrados = $this->tbl_inventario_tiempo_real->get_no_encontrados_id_inventario($id_inventario[0]["id"])->no_encontrados;
        $total = $c_encontrados + $c_no_encontrados ;
        $detalles_inventario = $this->tbl_inventario_tiempo_real->get_tbl_detalles_inventario_x_id($id_inventario[0]["id"]);
        //print_r($detalles_inventario);

        // VARIABLES A ENVIAR
        $variable_ubigeo = $id_inventario[0]["ubigeo"];
        $variable_ubicacion = $id_inventario[0]["ubicacion"];
        $variable_correlativo = $detalles_inventario[0]["correlativo"];
        $variable_usuario = $detalles_inventario[0]["usuario"];
        $variable_jefe_almacen = $detalles_inventario[0]["jefe_almacen"];
        $variable_fecha_programacion = $detalles_inventario[0]["fecha_programacion"];
        $variable_fecha_finalizacion = $detalles_inventario[0]["fecha_finalizacion"];
        // ENVIO VARIABLES A LA PAGINA plantilla.php
        $_SESSION['ubigeo'] = $variable_ubigeo;
        $_SESSION['ubicacion'] = $variable_ubicacion;
        $_SESSION['correlativo'] = $variable_correlativo;
        $_SESSION['usuario'] = $variable_usuario;
        $_SESSION['jefe_almacen'] = $variable_jefe_almacen;
        $_SESSION['fecha_programacion'] = $variable_fecha_programacion;
        $_SESSION['fecha_finalizacion'] = $variable_fecha_finalizacion;

        $i = 0;
        //$this->tmp_admin->set('encontrados', $encontrados);
        $lista = $this->tbl_inventario_tiempo_real->get_lista_inventario_realizado($id_inventario[0]["id"]);
        //print_r($lista);
        $pdf = new PDF("L", "mm", "A4");
        $pdf->AliasNbPages();
        $pdf->SetMargins(15, 10, 10);
        $pdf->AddPage();

        // IMPRIMIMOS CABECERAS
        $pdf->id(utf8_decode("Id"));
        $pdf->guia_remision(utf8_decode("Guía Remisión"));
        $pdf->item(utf8_decode("Itém"));
        $pdf->campos(utf8_decode("Código Producto"));
        $pdf->codigo_rfid(utf8_decode("Código RFID"));
        $pdf->descripcion(utf8_decode("Descripción"));
        $pdf->familia_producto(utf8_decode("Producto"));
        $pdf->ultimo_campo(utf8_decode("Fecha Ingreso"));
        //print_r($lista);
        $i = 0;
        foreach ($lista as $row) {
            if($row["fecha_lectura"] != ""){
                $i++;
                $pdf->SetFillColor(77, 245, 80);
                $pdf->SetLineWidth(0.5);
                $pdf->SetFont("Arial", "", 9);
                // Id
                $pdf->Cell(7, 7, $i, 1, 0, "C", TRUE);
                // Guia de Remision
                $pdf->Cell(30, 7, utf8_decode($row['guia_remision']), 1, 0, "C", TRUE);
                // Parte de Ingreso
                $pdf->Cell(18, 7, utf8_decode($row['item']), 1, 0, "C", TRUE);
                // Codigo de producto
                $pdf->Cell(44, 7, $row['codigo'], 1, 0, "C", TRUE);
                // Codigo RFID
                $pdf->Cell(50, 7, $row['codigo_rfid'], 1, 0, "C", TRUE);
                // Descripcion
                $pdf->Cell(60, 7, utf8_decode($row['descripcion']), 1, 0, "C", TRUE);
                // Familia de Producto
                $pdf->Cell(25, 7, $row['familia_producto'], 1, 0, "C", TRUE);
                // Fecha de Ingreso
                $pdf->Cell(40, 7, $row['fecha_ingreso'], 1, 1, "C", TRUE);
                //$encontrados++;
            }
            else{
                $i++;
                $pdf->SetFillColor(245, 100, 77);
                $pdf->SetLineWidth(0.5);
                $pdf->SetFont("Arial", "", 9);
                // Id
                $pdf->Cell(7, 7, $i, 1, 0, "C", TRUE);
                // Guia de Remision
                $pdf->Cell(30, 7, utf8_decode($row['guia_remision']), 1, 0, "C", TRUE);
                // Parte de Ingreso
                $pdf->Cell(18, 7, utf8_decode($row['item']), 1, 0, "C", TRUE);
                // Codigo de producto
                $pdf->Cell(44, 7, $row['codigo'], 1, 0, "C", TRUE);
                // Codigo RFID
                $pdf->Cell(50, 7, $row['codigo_rfid'], 1, 0, "C", TRUE);
                // Descripcion
                $pdf->Cell(60, 7, utf8_decode($row['descripcion']), 1, 0, "C", TRUE);
                // Familia de Producto
                $pdf->Cell(25, 7, $row['familia_producto'], 1, 0, "C", TRUE);
                // Fecha de Ingreso
                $pdf->Cell(40, 7, $row['fecha_ingreso'], 1, 1, "C", TRUE);
                //$no_encontrados++;
            }
            $_SESSION['encontrados'] = $c_encontrados;
            $_SESSION['no_encontrados'] = $c_no_encontrados;
        }
        $num_vinculados = $total;
        $_SESSION['total'] = $num_vinculados;
        $date = date("Y-m-d H:i:s");

        $pdf->Output('I', $id_inventario[0]["id"] . "_" . $date . '.pdf');
    }
    public function reporte_recibo_deposito($correlativo)
    {
        $this->load->model('tbl_alerta');
        $this->load->model('tbl_inventario_tiempo_real');
        $this->load->model('tbl_inventario');
        $this->load->model('tbl_vinculacion');

        require "Plantilla_recibo.php";
    
        $c_encontrados = $this->tbl_inventario_tiempo_real->get_encontrados_correlativo($correlativo)->encontrados;
        $c_no_encontrados = $this->tbl_inventario_tiempo_real->get_no_encontrados_correlativo($correlativo)->no_encontrados;
        $total = $c_encontrados + $c_no_encontrados ;
        $detalles_inventario = $this->tbl_inventario_tiempo_real->get_tbl_detalles_recibo_x_correlativo($correlativo);
        //print_r($detalles_inventario);

        // VARIABLES A ENVIAR
        $variable_ubigeo = $detalles_inventario[0]["ubigeo"];
        $variable_ubicacion = $detalles_inventario[0]["ubicacion"];
        $variable_correlativo = $detalles_inventario[0]["correlativo"];
        $variable_usuario = $detalles_inventario[0]["usuario"];
        $variable_jefe_almacen = $detalles_inventario[0]["jefe_almacen"];
        $variable_fecha_finalizacion = $detalles_inventario[0]["fecha_finalizacion"];
        // ENVIO VARIABLES A LA PAGINA plantilla.php
        $_SESSION['ubigeo'] = $variable_ubigeo;
        $_SESSION['ubicacion'] = $variable_ubicacion;
        $_SESSION['correlativo'] = $variable_correlativo;
        $_SESSION['usuario'] = $variable_usuario;
        $_SESSION['jefe_almacen'] = $variable_jefe_almacen;
        $_SESSION['fecha_finalizacion'] = $variable_fecha_finalizacion;

        $i = 0;
        //$this->tmp_admin->set('encontrados', $encontrados);
        $lista = $this->tbl_inventario_tiempo_real->get_lista_recibo_realizado($correlativo);
        //print_r($lista);
        $pdf = new PDF("L", "mm", "A4");
        $pdf->AliasNbPages();
        $pdf->SetMargins(15, 10, 10);
        $pdf->AddPage();

        // IMPRIMIMOS CABECERAS
        $pdf->id(utf8_decode("Id"));
        $pdf->guia_remision(utf8_decode("Guía Remisión"));
        $pdf->item(utf8_decode("Itém"));
        $pdf->campos(utf8_decode("Código Producto"));
        $pdf->codigo_rfid(utf8_decode("Código RFID"));
        $pdf->descripcion(utf8_decode("Descripción"));
        $pdf->familia_producto(utf8_decode("Producto"));
        $pdf->ultimo_campo(utf8_decode("Fecha Ingreso"));
        //print_r($lista);
        $i = 0;
        foreach ($lista as $row) {
            if($row["fecha_lectura"] != ""){
                $i++;
                $pdf->SetFillColor(77, 245, 80);
                $pdf->SetLineWidth(0.5);
                $pdf->SetFont("Arial", "", 9);
                // Id
                $pdf->Cell(7, 7, $i, 1, 0, "C", TRUE);
                // Guia de Remision
                $pdf->Cell(30, 7, utf8_decode($row['guia_remision']), 1, 0, "C", TRUE);
                // Parte de Ingreso
                $pdf->Cell(20, 7, utf8_decode($row['item']), 1, 0, "C", TRUE);
                // Codigo de producto
                $pdf->Cell(40, 7, $row['codigo'], 1, 0, "C", TRUE);
                // Codigo RFID
                $pdf->Cell(50, 7, $row['codigo_rfid'], 1, 0, "C", TRUE);
                // Descripcion
                $pdf->Cell(60, 7, utf8_decode($row['descripcion']), 1, 0, "C", TRUE);
                // Familia de Producto
                $pdf->Cell(25, 7, $row['familia_producto'], 1, 0, "C", TRUE);
                // Fecha de Ingreso
                $pdf->Cell(40, 7, $row['fecha_ingreso'], 1, 1, "C", TRUE);
                //$encontrados++;
            }
            else{
                $i++;
                $pdf->SetFillColor(245, 100, 77);
                $pdf->SetLineWidth(0.5);
                $pdf->SetFont("Arial", "", 9);
                // Id
                $pdf->Cell(7, 7, $i, 1, 0, "C", TRUE);
                // Guia de Remision
                $pdf->Cell(30, 7, utf8_decode($row['guia_remision']), 1, 0, "C", TRUE);
                // Parte de Ingreso
                $pdf->Cell(20, 7, utf8_decode($row['item']), 1, 0, "C", TRUE);
                // Codigo de producto
                $pdf->Cell(40, 7, $row['codigo'], 1, 0, "C", TRUE);
                // Codigo RFID
                $pdf->Cell(50, 7, $row['codigo_rfid'], 1, 0, "C", TRUE);
                // Descripcion
                $pdf->Cell(60, 7, utf8_decode($row['descripcion']), 1, 0, "C", TRUE);
                // Familia de Producto
                $pdf->Cell(25, 7, $row['familia_producto'], 1, 0, "C", TRUE);
                // Fecha de Ingreso
                $pdf->Cell(40, 7, $row['fecha_ingreso'], 1, 1, "C", TRUE);
                //$no_encontrados++;
            }
            $_SESSION['encontrados'] = $c_encontrados;
            $_SESSION['no_encontrados'] = $c_no_encontrados;
        }
        $num_vinculados = $total;
        $_SESSION['total'] = $num_vinculados;
        $date = date("Y-m-d H:i:s");

        $pdf->Output('I', $correlativo . "_" . $date . '.pdf');
    }

    public function logout()
    {
        $this->session->unset_userdata('logged');
        redirect('admin');
    }
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */