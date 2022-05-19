<!DOCTYPE html>
<html lang="en">

<head>
    <title>Administraci&oacute;n</title>
    <base href="<?php echo base_url(); ?>">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="StartUp Admin Panel">
    <meta name="keywords"
        content="Admin, Dashboard, Bootstrap3, Sass, transform, CSS3, HTML5, Web design, UI Design, Responsive Dashboard, Responsive Admin, Admin Template, Best Admin UI, Bootstrap Template, Wrap Bootstrap, Bootstrap">
    <meta name="author" content="Bootstrap Gallery">
    <link rel="shortcut icon" href="img/icono.ico">
    <title>StartUp Admin Panel, StartUp Dashboard</title>
    <link href="<?php echo base_url(); ?>static/main/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <!-- <link href="<?php echo base_url(); ?>static/main/bootstrap.min.css" rel="stylesheet"> -->
    <link href="<?php echo base_url(); ?>static/main/css/main.css" rel="stylesheet" id="themeSwitcher">
    <link href="<?php echo base_url(); ?>static/main/fonts/icomoon/icomoon.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>static/main/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>static/main/select2.min.css" rel="stylesheet">
    <link href=" <?php echo base_url(); ?>static/main/css/c3/c3.css" rel="stylesheet">
    <link href=" <?php echo base_url(); ?>static/main/css/estilos.css" rel="stylesheet">
    <!--Datatable-->
    <link rel="stylesheet" type="text/css"
        href="<?php echo base_url(); ?>static/main/js/datatable/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css"
        href="<?php echo base_url(); ?>static/main/js/datatable/css/buttons.dataTables.min.css">

    <!--Stylos de los botones input  -->
    <!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>static/main/metro-all.min.css"> -->
    <!--Stylos de los botones input  -->


    <!--Scripts de bootstraps  -->
    <!-- <script src="<?php echo base_url(); ?>static/main/js/jquery-1.11.1.min.js"></script> -->
    <script src="<?php echo base_url(); ?>static/main/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>static/main/js/jquery.qtip.js"></script>
    <script src="<?php echo base_url(); ?>static/main/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>static/main/select2.min.js"></script>
    <!-- <script src="<?php echo base_url(); ?>static/main/bootstrap.bundle.min.js"></script> -->
    <script src="<?php echo base_url(); ?>static/main/js/scrollup.min.js"></script>
    <!--Scripts de bootstraps  -->
    <!--Script de Datatables  -->
    <script type="text/javascript" charset="utf8"
        src="<?php echo base_url(); ?>static/main/js/datatable/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="<?php echo base_url(); ?>static/main/js/datatable/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="<?php echo base_url(); ?>static/main/js/datatable/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="<?php echo base_url(); ?>static/main/js/datatable/js/buttons.html5.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="<?php echo base_url(); ?>static/main/js/datatable/js/jszip.min.js">
    </script>
    <script type="text/javascript" charset="utf8"
        src="<?php echo base_url(); ?>static/main/js/datatable/js/buttons.flash.min.js"></script>
    <script type="text/javascript" src="https://code.highcharts.com/highcharts.js"></script>
    <!--Script de Datatables  -->
    <!-- Para el avioncito-->
    <script src="<?php echo base_url(); ?>static/main/js/scrollup.min.js"></script>
    <!-- <script src="<?php echo base_url(); ?>static/main/js/bootstrap.min.js"></script> -->
    <!-- <script src="<?php echo base_url(); ?>static/main/js/scrollup.min.js"></script> -->
    <script src="<?php echo base_url(); ?>static/main/js/themeSwitcher.js"></script>
    <script src="<?php echo base_url(); ?>static/main/js/common.js"></script>
    <script src="<?php echo base_url(); ?>static/main/admin.plugins.js"></script>
    <!------------->
    <!-- script botton style -->
    <!-- <script src="<?php echo base_url(); ?>static/main/metro.min.js"></script> -->
    <!-- script botton style -->
    <!-- script botton style -->
    <script src="<?php echo base_url(); ?>static/main/sweetalert.js"></script>
    <!-- script botton style -->

</head>

<body>
    <header class="clearfix">
        <!-- <div class="logo"><img src="<?php echo base_url(); ?>static/main/img/logo.png" alt="Logo"></div> -->

        <div class="pull-right">
            <ul id="header-actions" class="clearfix">
                <li class="list-box user-admin dropdown">
                    <div class="admin-details">
                        <div class="name">
                            <?php
                     $usuario = $this->session->userdata('usuario');
                     echo ucwords(strtolower($usuario));;
                     ?>
                        </div>
                        <div class="designation">
                            <?php
                     $perfil = $this->session->userdata('perfil');
                     echo ucwords(strtolower($perfil));;
                     ?>
                        </div>
                    </div>
                    <a id="drop4" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- <i class="icon-account_circle"></i> -->
                        <div class="logos"><img style=" height: 30px;" src="
                                <?php echo base_url(); ?>static/main/img/ABC.JPG" alt="Logo"></div>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-content">
                            <a href="<?php echo site_url('admin/logout'); ?>">Salir</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

        <div class="custom-search"><input type="text" class="search-query" placeholder="Search here ..."> <i
                class="icon-search4"></i></div>
    </header>
    <div class="container-fluid">
        <!-- <div class="left-sidebar">
            <a href="profile.html" class="user-wrapper clearfix">
                <div class="user-avatar"><img src="<?php echo base_url(); ?>static/main/img/ABC.JPG" alt="StartUp User">
                </div>
                <div class="profile-status">
                    <p class="welcome">BIENVENIDO</p>
                    <p class="name"> <?php
                                 $usuario = $this->session->userdata('usuario');
                                 echo ucwords(strtolower($usuario));;
                                 ?></p>
                </div>
            </a>
            <div class="panel-group" id="leftSidebar" role="tablist" aria-multiselectable="true">


                <div class="panel">
                    <div class="panel-heading" role="tab" id="headingThree">
                        <h4 class="panel-title"><a class="collapsed" role="button" data-toggle="collapse"
                                data-parent="#leftSidebar" href="#collapseThree" aria-expanded="false"
                                aria-controls="collapseThree">Team <span class="label label-success">10</span></a></h4>
                    </div>

                </div>

                <div class="panel">
                    <div class="panel-heading" role="tab" id="headingSeven">
                        <h4 class="panel-title"><a class="collapsed" role="button" data-toggle="collapse"
                                data-parent="#leftSidebar" href="#collapseSeven" aria-expanded="false"
                                aria-controls="collapseSeven">Locations <span class="label label-teal">21</span></a>
                        </h4>
                    </div>
                    <div id="collapseSeven" class="panel-collapse collapse" role="tabpanel"
                        aria-labelledby="headingSeven">
                        <div class="panel-body">
                            <ul class="views">
                                <li>
                                    <p class="detail-info"><i class="icon-vinyl blue"></i> Germany</p>
                                </li>
                                <li>
                                    <p class="detail-info"><i class="icon-vinyl green"></i> Japan</p>
                                </li>
                                <li>
                                    <p class="detail-info"><i class="icon-vinyl red"></i>United States</p>
                                </li>
                                <li>
                                    <p class="detail-info"><i class="icon-vinyl yellow"></i>India</p>
                                </li>
                                <li>
                                    <p class="detail-info"><i class="icon-vinyl violet"></i>France</p>
                                </li>
                                <li>
                                    <p class="detail-info"><i class="icon-vinyl violet"></i>Canada</p>
                                </li>
                                <li>
                                    <p class="detail-info"><i class="icon-vinyl teal"></i>United Kingdom</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->


        <div class="dashboard-wrapper">
            <nav class="navbar navbar-default">
                <div class="navbar-header"><button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false"><span class="sr-only">Toggle
                            navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span
                            class="icon-bar"></span></button></div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                aria-haspopup="true" aria-expanded="false"><i class="icon-text-document"></i> Matrícula
                                de Activos <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <!--<li><a href="admin/inventario/cargar_activos">Cargar Activos desde Excel</a></li>-->
                                <li><a href="admin/inventario/cargar_parte_ingreso">Cargar PARTE DE INGRESO desde
                                        Excel</a></li>
                                <li><a href="admin/inventario/vinculacion_1x1">Matricular Activos - 1x1 Automático</a>
                                <li><a href="admin/inventario/partes_ingreso">Visualizar PARTES DE INGRESO</a></li>
                                <!--<li><a href="admin/inventario/ingresar_activos">Matricular Activo - Manual</a></li>-->
                                <li><a href="admin/inventario/editar_activos">Editar - Eliminar Matrícula Activo </a>
                                </li>
                                <li><a href="admin/inventario/eliminacion_masiva">Eliminar Matrícula Activo Masivamente
                                    </a></li>
                                <li><a href="admin/inventario/activos_matriculados">Activos Matriculados</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                aria-haspopup="true" aria-expanded="false"><i class="icon-text-document"></i> Asignación
                                de Dispositivo RFID <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="admin/dispositivo_rfid">Dispositivos asignados RFID</a></li>
                                <li><a href="admin/dispositivo_rfid/asignacion">Asignar dispositivo RFID</a></li>
                                <li><a href="admin/dispositivo_rfid/desvinculacion">Desvincular dispositivo RFID</a>
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                aria-haspopup="true" aria-expanded="false"><i class="icon-warning2"></i> Eventos en
                                Tiempo Real <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="admin/tiemporeal/preinventario_ubigeo_ubicacion">Pre Inventario - Tiempo
                                        Real</a></li>
                                <li><a href="admin/tiemporeal/recibo_deposito">Generar RECIBO DEPOSITO</a></li>
                                <li><a href="admin/tiemporeal/programacion_inventario_tiempo_real">Programación
                                        Inventario - Tiempo Real</a></li>
                                <li><a href="admin/inventario_tiempo_real/historial_inventarios">Historial - Inventarios
                                        Realizados</a></li>
                                <li><a href="admin/inventario_tiempo_real/recibos_generados">Historial - Recibos de
                                        Depósito</a></li>
                                <li><a href="admin/tiemporeal/portico_tiempo_real">Pórtico RFID - Tiempo Real</a></li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                aria-haspopup="true" aria-expanded="false"><i class="icon-text-document"></i> Salida de
                                Activos <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="admin/vinculacion/elegir_ubigeo_ubicacion">Programación de Salidas de
                                        Activos - Masivo</a></li>
                                <li><a href="admin/vinculacion/salidas_automaticas_tiempo_real">Dar Salidas Programadas
                                        de Activos - Masiva</a></li>
                                <li><a href="admin/vinculacion/programar_salida_manual">Programación de Salidas de
                                        Activos - Manual</a></li>
                                <!-- <li><a href="admin/vinculacion/programar_salida_automatica">Programación de Salidas de Activo Automática</a></li> -->
                                <li><a href="admin/vinculacion/eliminar_vinculo">Dar Salidas Programadas de Activos -
                                        Manual</a></li>
                                <li><a href="admin/vinculacion/ver_salidas">Ver Salidas de Activos Matriculados</a></li>

                            </ul>
                        </li>

                        <li>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                aria-haspopup="true" aria-expanded="false"><i class="icon-text-document"></i> Control de
                                Acceso - RFID <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="admin/enrolamiento/enrolar_sujetos_automatico">Enrolar Sujeto -
                                        Automática</a></li>
                                <li><a href="admin/enrolamiento/enrolar_sujetos">Enrolar Sujeto - Manual</a></li>
                                <li><a href="admin/enrolamiento">Sujetos Enrolados</a></li>
                                <li><a href="admin/enrolamiento/control_acceso_rfid">Control de Acceso RFID</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="admin/inicio">
                                <i class="icon-home2"></i>
                                Reporte
                            </a>
                        </li>
                        <!-- <li>
                     <a href="admin/paciente">
                        <i class="icon-home2"></i>
                        Control de Pacientes - RFID TIEMPO REAL
                     </a>
                  </li>

                  <li class="dropdown">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="icon-text-document"></i> Historial <span class="caret"></span></a>
                     <ul class="dropdown-menu">
                        <li><a href="admin/alerta">Historial TAGS RFID Leídos</a></li>
                        <li><a href="admin/portico_tiempo_real">Historial Portico RFID</a></li>
                     </ul>
                  </li> -->

                    </ul>
                </div>
            </nav>
            <div class="top-bar clearfix">
                <div class="container-fluid">
                    <div class="row gutter">
                        <?php echo $body; ?>
                    </div>
                </div>
            </div>

            <footer class="footer">Copyright <span> - 2022</span>.</footer>
        </div>
    </div>




</body>

</html>