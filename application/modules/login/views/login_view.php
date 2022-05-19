<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LECTURAS RFID</title>
    <!-- CSS -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/static/main/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/static/main/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/static/main/css/form-elements.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/static/main/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/static/main/css/style1.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    <!-- Favicon and touch icons -->
    <link rel="shortcut icon" href="<?php echo base_url(); ?>/static/main/ico/favicon.png">
    <link rel="apple-touch-icon-precomposed" sizes="144x144"
        href="<?php echo base_url(); ?>/static/main/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114"
        href="<?php echo base_url(); ?>/static/main/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72"
        href="<?php echo base_url(); ?>/static/main/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed"
        href="<?php echo base_url(); ?>/static/main/ico/apple-touch-icon-57-precomposed.png">


</head>


<body>

    <!-- Top content -->
    <div class="top-content">

        <div class="inner-bg">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2 text">
                        <h1>
                            <strong class="shadow">WMS - PLATAFORMA RFID</strong>
                        </h1>
                        <div class="description">
                            <p>
                                Sistema de Lectura RFID
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-3 form-box">
                        <div class="form-top">
                            <div class="form-top-left">
                                <h3>Login </h3>
                                <p>Ingresar sus credenciales:</p>
                            </div>
                            <div class="form-top-right">
                                <i class="fa fa-lock"></i>
                            </div>
                        </div>
                        <div class="form-bottom">
                            <?php echo form_open('', array('class' => 'form-horizontal')); ?>
                            <div class="form-group">
                                <label class="control-label col-md-3" for="usuario">Usuario</label>
                                <div class="col-md-9">
                                    <input class="form-control" type="text" id="usuario" placeholder="Usuario"
                                        name="usuario">
                                    <?php echo form_error('usuario', '<div class="error">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3" for="contrasena">Contraseña</label>
                                <div class="col-md-9">
                                    <input class="form-control" type="password" id="contrasena" placeholder="Contraseña"
                                        name="contrasena">
                                    <?php echo form_error('contrasena', '<div class="error">', '</div>'); ?>
                                </div>
                            </div>





                            <div class="form-group">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" class="btn btn-primary">Entrar</button>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>


    <!-- Javascript -->
    <script src="<?php echo base_url(); ?>/static/main/js/jquery-1.11.1.min.js"></script>
    <script src="<?php echo base_url(); ?>/static/main/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>/static/main/js/jquery.backstretch.min.js"></script>
    <!--AQUI CAMBIO EL BACKGROUND DE LA PAGINA-->
    <script src="<?php echo base_url(); ?>/static/main/js/scripts.js"></script>

    <!--[if lt IE 10]>
            <script src="assets/js/placeholder.js"></script>
        <![endif]-->

</body>

</html>