<?php

/************************************************************
 * Plantilla para encabezado y pie de página                 *
 *                                                           *
 * Fecha:    2021-02-09                                      *
 * Autor:  Marko Robles                                      *
 * Web:  www.codigosdeprogramacion.com                       *
 ************************************************************/

require 'fpdf/fpdf.php';

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // RECIBO VARIABLES DE LA PAGINA REPORTE.PHP
        $variable_ubigeo = $_SESSION['ubigeo'];
        $variable_ubicacion = $_SESSION['ubicacion'];
        $variable_correlativo = $_SESSION['correlativo'];
        $variable_usuario = $_SESSION['usuario'];
        $variable_jefe_almacen = $_SESSION['jefe_almacen'];
        $variable_fecha_programacion = $_SESSION['fecha_programacion'];
        $variable_fecha_finalizacion = $_SESSION['fecha_finalizacion'];
        if(isset($_SESSION['encontrados'])){
             $variable_encontrados = $_SESSION['encontrados'];
        }
        else{
             $variable_encontrados = "";
        }
       
       
        // $variable_no_encontrados = $_SESSION['no_encontrados'];
        $variable_no_encontrados = "";

        
        $variable_total = $_SESSION['total'];
        // Logo
        $this->Image("static/main/img/ABC.JPG", 20, 25, 70);
        // Arial bold 15
        //Fecha
        $this->SetFont("Arial", "", 10);
        $this->Cell(270, 40, "Hora y fecha de Reporte: " . date("Y-m-d H:i:s"), 0, 1, "R");
        // TRAIGO UBICACION, UBIGEO, PARTE DE INGRESO, USUARIO, JEFE DE ALMACEN, FECHAS
        $this->Cell(270, -30, "Ubigeo: " . $variable_ubigeo, 0, 1, "R");
        $this->Cell(270, 40, utf8_decode("Ubicación: ") . $variable_ubicacion, 0, 1, "R");
        $this->Cell(270, -30, utf8_decode("Parte de Ingreso: ") . $variable_correlativo, 0, 1, "R");
        $this->Cell(270, 40, utf8_decode("Usuario: ") . $variable_usuario, 0, 1, "R");
        $this->Cell(270, -30, utf8_decode("Jefe de Almacén: ") . $variable_jefe_almacen, 0, 1, "R");
        $this->Cell(270, 40, utf8_decode("Fecha de Programación: ") . $variable_fecha_programacion, 0, 1, "R");
        $this->Cell(270, -30, utf8_decode("Hora y fecha de Inventario: ") . $variable_fecha_finalizacion, 0, 1, "R");
        // RESUMEN DEL INVENTARIO
        $this->SetFont("Arial", "B", 12);
        $this->Cell(270, -30, utf8_decode("RESUMEN DEL INVENTARIO"), 0, 1, "C");
        $this->SetFont("Arial", "B", 10);
        $this->SetTextColor(77, 245, 80);
        $this->Cell(270, 40, utf8_decode("Activos encontrados: ") . $variable_encontrados, 0, 1, "C");
        $this->SetTextColor(245, 100, 77);
        $this->Cell(270, -30, utf8_decode("Activos NO encontrados: ") . $variable_no_encontrados, 0, 1, "C");
        $this->SetTextColor(33,128,235);
        $this->Cell(270, 40, utf8_decode("Total de Activos : ") . $variable_total, 0, 1, "C");

        // Salto de línea
        $this->Ln(20);
        $this->SetFont("Arial", "B", 14);
        // Título
        $this->Cell(25);
        $this->Cell(220, 5, utf8_decode("INVENTARIO DE ACTIVOS ETIQUETADOS CON TECNOLOGÍA RFID"), 0, 0, "C");
        // Salto de línea
        $this->Ln(10);
    }

    // CAMPOS 
    function campos($label)
    {
        // Ancho del borde (1 mm)
        $this->SetLineWidth(1.5);
        // Arial 12
        $this->SetFont('Arial', 'B', 10);
        // Color de fondo
        $this->SetFillColor(48,243,222);
        // Título
        $this->Cell(44, 7, "$label", 1, 0, 'C', true);
    }
     // CODIGO RFID
     function codigo_rfid($label)
     {
         // Ancho del borde (1 mm)
         $this->SetLineWidth(1.5);
         // Arial 12
         $this->SetFont('Arial', 'B', 10);
         // Color de fondo
         $this->SetFillColor(42,243,222);
         // Título
         $this->Cell(50, 7, "$label", 1, 0, 'C', true);
     }
     // DESCRIPCION
     function descripcion($label)
     {
         // Ancho del borde (1 mm)
         $this->SetLineWidth(1.5);
         // Arial 12
         $this->SetFont('Arial', 'B', 10);
         // Color de fondo
         $this->SetFillColor(45,243,222);
         // Título
         $this->Cell(60, 7, "$label", 1, 0, 'C', true);
     }
    // PARTE DE INGRESO 
    function item($label)
    {
        // Ancho del borde (1 mm)
        $this->SetLineWidth(1.5);
        // Arial 12
        $this->SetFont('Arial', 'B', 10);
        // Color de fondo
        $this->SetFillColor(45,243,222);
        // Título
        $this->Cell(18, 7, "$label", 1, 0, 'C', true);
    }
    // GUIA DE REMISION
    function guia_remision($label)
    {
        // Ancho del borde (1 mm)
        $this->SetLineWidth(1.5);
        // Arial 12
        $this->SetFont('Arial', 'B', 10);
        // Color de fondo
        $this->SetFillColor(45,243,222);
        // Título
        $this->Cell(30, 7, "$label", 1, 0, 'C', true);
    }
     // FAMILIA DE PRODUCTO
     function familia_producto($label)
     {
         // Ancho del borde (1 mm)
         $this->SetLineWidth(1.5);
         // Arial 12
         $this->SetFont('Arial', 'B', 10);
         // Color de fondo
         $this->SetFillColor(45,243,222);
         // Título
         $this->Cell(25, 7, "$label", 1, 0, 'C', true);
     }
    // ULTIMO CAMPO
    function ultimo_campo($label)
    {
        // Ancho del borde (1 mm)
        $this->SetLineWidth(1.5);
        // Arial 12
        $this->SetFont('Arial', 'B', 10);
        // Color de fondo
        $this->SetFillColor(45,243,222);
        // Título
        $this->Cell(40, 7, "$label", 1, 1, 'C', true);
    }

    // CAMPO ID
    function id($label)
    {
        // Ancho del borde (1 mm)
        $this->SetLineWidth(1.5);
        // Arial 12
        $this->SetFont('Arial', 'B', 10);
        // Color de fondo
        $this->SetFillColor(45,243,222);
        // Título
        $this->Cell(7, 7, "$label", 1, 0, 'C', true);
    }


    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}