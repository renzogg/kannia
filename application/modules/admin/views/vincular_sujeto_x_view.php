<div class="row-fluid">
    <h1>
        <center>Vincular SUJETO</center>
    </h1>
</div>
<br>
<script>
    $(function() {
        let repetir = function() {
            $.ajax({
                url: "admin/enrolamiento/get_sujetos_excel_enrolados",
                type: "post",
                data: {},
                dataType: "json",
                success: function(response) {
                    var respuesta = response;
                    var tabla = "";

                    for (ind in respuesta) {
                        var fila = "<tr>";
                        fila += "<td>" + respuesta[ind].id + "</td>";
                        fila += "<td>" + respuesta[ind].nombres + "</td>";
                        fila += "<td>" + respuesta[ind].apellidos + "</td>";
                        fila += "<td>" + respuesta[ind].codigo_rfid + "</td>";
                        fila += "<td>" + respuesta[ind].dni + "</td>";
                        fila += "<td>" + respuesta[ind].cargo + "</td>";
                        fila += "<td>" + respuesta[ind].ubigeo + "</td>";
                        fila += "<td><img src='static/main/img/" + respuesta[ind].imagen + "' alt='Activo' width='42' height='42' style='vertical-align:bottom'>" + "</td>";
                        fila += "<td>" + respuesta[ind].fecha_enrolacion + "</td>";
                        fila += "<td style='text-align:center'><a href='admin/enrolamiento/editar/" + respuesta[ind].dni + "'class='btn btn-success'>Editar</a></td>";
                        fila += "<td style='text-align:center' class='botones'><a data-target='#miModal' data-toggle='miModal'><button class='btn btn-danger boton_eliminar' cod_dni='" + respuesta[ind].dni + "'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span> Eliminar</button></a></td>";
                        fila += "</tr>";
                        tabla += fila;
                    }

                    $("#cuerpo").html(tabla);
                    $("#tbl_vinculacion").DataTable({
                        language: {
                            "decimal": "",
                            "emptyTable": "No hay datos en la tabla",
                            "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                            "infoEmpty": "Mostrando 0 a 0 de 0 entradas",
                            "infoFiltered": "(filtrando de _MAX_ total de entradas)",
                            "infoPostFix": "",
                            "thousands": ",",
                            "lengthMenu": "Mostrar _MENU_ entradas",
                            "loadingRecords": "Cargando...",
                            "processing": "Procesando...",
                            "search": "Buscar:",
                            "zeroRecords": "No se encontraron registros coincidentes",
                            "paginate": {
                                "first": "Primero",
                                "last": "Ultimo",
                                "next": "Siguiente",
                                "previous": "Anterior"
                            },
                            "aria": {
                                "sortAscending": ": Activar para ordenar la columna ascendente",
                                "sortDescending": ": Activar para ordenar la columna Descendente"
                            }
                        }
                    });
                }
            });
        }
        repetir();
    });
    $(document).ready(function() {
        $('input[type="file"]').change(function(e) {
            var fileName = e.target.files[0].name;
            //alert('The file "' + fileName +  '" archivo seleccionado.');
            //console.log(fileName);
            var image = new Image();

            var src = "static/main/img/" + fileName;
            console.log(src);
            var picture = "<img src=" + src +
                " alt='Activo' width='100' height='100' style='vertical-align:bottom'>";
            console.log(picture);
            /* image.picture = picture;
            $('#image').append(image); */
            var fotito = document.getElementById("editar_image");
            fotito.innerHTML = picture;
        });
    });
    $(function() {
        let llamar_chip = function() {
            $.ajax({
                url: "admin/alerta/get_ultimo_chip",
                type: "post",
                data: {},
                dataType: "json",
                error: function(ee) {
                    console.log(ee);
                },
                success: function(response) {
                    //console.log(response.respuesta)
                    var tag = response.respuesta;
                    document.getElementById("rfid").value = tag;
                    console.log(response)
                }
            });
        }
        setInterval(function() {
            llamar_chip();
        }, 1000);
    });

    $(function() {
        $("#form_vinculacion").submit(function(event) {
            /*event.preventDefault();
               var datos = $(this).serialize(),
                url = $(this).attr('action');
            console.log(datos); */
            event.preventDefault(); // Evitamos que salte el enlace. 
            /* Creamos un nuevo objeto FormData. Este sustituye al 
            atributo enctype = "multipart/form-data" que, tradicionalmente, se 
            incluía en los formularios (y que aún se incluye, cuando son enviados 
            desde HTML. */
            var paqueteDeDatos = new FormData();
            /* Todos los campos deben ser añadidos al objeto FormData. Para ello 
            usamos el método append. Los argumentos son el nombre con el que se mandará el 
            dato al script que lo reciba, y el valor del dato.
            Presta especial atención a la forma en que agregamos el contenido 
            del campo de fichero, con el nombre 'archivo'. */
            paqueteDeDatos.append('dni', $('#dni').prop('value'));
            paqueteDeDatos.append('rfid', $('#rfid').prop('value'));
            paqueteDeDatos.append('imagen', $('#name_file')[0].files[0]);
            var url = $(this).attr('action'); // El script que va a recibir los campos de formulario.
            /* Se envia el paquete de datos por ajax. */
            $.ajax({
                type: "POST",
                url: "admin/enrolamiento/vincular_sujeto_x_ajax",
                data: paqueteDeDatos,
                dataType: "html",
                "processData": false,
                "mimeType": "multipart/form-data",
                "contentType": false,
                success: function(resultado) {
                    console.log(resultado)
                    jAlert(resultado, "Mensaje");
                    // refreshTable();
                    document.getElementById("form_vinculacion").reset();
                    setTimeout(function() {
                        document.location.reload(); //Actualiza la pagina
                    }, 2000);
                },
                error: function(error) {
                    alert('ERROR!');
                    //                $.unblockUI();
                }
            });
            return false; //stop the actual form post !important!
        });
    });
</script>
<!--PARA VER ERRORES-->
<!--<pre>
	<?php
    echo print_r($codigo);
    ?>
    </pre>-->
<div class="main-container">
    <div class="row gutter">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="panel panel-light panel-brown">
                <div class="panel-heading">
                    <h4>Formulario de Vinculación de Sujetos</h4>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" id="form_vinculacion" method="post">
                        <?php echo form_open_multipart('', array('class' => 'form-horizontal')) ?>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-4 control-label">DNI</label>
                            <div class="col-md-4">
                                <input type="text" readonly="readonly" class="form-control" name="dni" id="dni" placeholder="Ingresa DNI..." value="<?php echo $codigo->dni; ?>">
                                <?php echo form_error('dni', '<span class="label label-danger">', '</span>'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-4 control-label">Código RFID</label>
                            <div class="col-md-4">
                                <input type="text" readonly="readonly" class="form-control" name="rfid" id="rfid" placeholder="Ingresa codigo...">
                                <?php echo form_error('codigo', '<span class="label label-danger">', '</span>'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-4 control-label">Nombres</label>
                            <div class="col-md-4">
                                <input type="text" readonly="readonly" class="form-control" name="nombres" id="nombres" placeholder="Ingresa nombres..." value="<?php echo $codigo->nombres; ?>">
                                <?php echo form_error('nombres', '<span class="label label-danger">', '</span>'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-4 control-label">Apellidos</label>
                            <div class="col-md-4">
                                <input type="text" readonly="readonly" class="form-control" name="apellidos" id="apellidos" placeholder="Ingresa apellidos..." value="<?php echo $codigo->apellidos; ?>">
                                <?php echo form_error('apellidos', '<span class="label label-danger">', '</span>'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-4 control-label">Cargo</label>
                            <div class="col-md-4 ">
                                <input type="text" readonly="readonly" class="form-control" name="cargo" id="cargo" placeholder="Ingresa cargo..." value="<?php echo $codigo->cargo; ?>">
                                <?php echo form_error('cargo', '<span class="label label-danger">', '</span>'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-4 control-label">Ubigeo</label>
                            <div class="col-md-4 ">
                                <input type="text" readonly="readonly" class="form-control" name="ubigeo" id="ubigeo" placeholder="Ingresa ubigeo..." value="<?php echo $codigo->ubigeo; ?>">
                                <?php echo form_error('ubigeo', '<span class="label label-danger	">', '</span>'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="image" class="col-md-4 control-label" id="select_file">Subir Imagen</label>
                            <input type="file" id="name_file" class="form-control-file" name="name_file" required>
                            <div id="editar_image" class="relative" required></div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-2 control-label" style="width: 225px">
                                <a data-target="#miModal" data-toggle="miModal"><button type="submit" class="btn btn-success btn_aviso">Vincular</button></a>
                            </div>
                            <div style="float: right; width: 225px">
                                <a class="btn btn-primary" href="admin/enrolamiento/enrolar_sujetos_automatico">Atrás</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row gutter">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="panel panel-light panel-facebook">
                <div class="panel-heading">
                    <h4>Tabla de Vinculación</h4>
                </div>
                <div class="panel-body table-responsive">
                    <table class="table danger table-striped no-margin text-center" id="tbl_vinculacion" class="display">
                        <thead>
                            <tr>
                                <th style="text-align:center">ITEM</th>
                                <th style="text-align:center">NOMBRES</th>
                                <th style="text-align:center">APELLIDOS</th>
                                <th style="text-align:center">CÓDIGO RFID</th>
                                <th style="text-align:center">DNI</th>
                                <th style="text-align:center">CARGO</th>
                                <th style="text-align:center">UBIGEO</th>
                                <th style="text-align:center">IMAGEN</th>
                                <th style="text-align:center">FECHA DE VINCULACIÓN</th>
                                <th style="text-align:center">EDITAR</th>
                                <th style="text-align:center">ELIMINAR</th>
                            </tr>
                        </thead>
                        <tbody id="cuerpo">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>