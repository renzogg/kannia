<div class="row-fluid">
    <h1>
        <center>Vincular Activo</center>
    </h1>
</div>
<br>
<script>
    $(function() {
        let repetir = function() {
            $.ajax({
                url: "admin/inventario/get_activos_vinculados_excel",
                type: "post",
                data: {},
                dataType: "json",
                success: function(response) {
                    //console.log(response);
                    var respuesta = response.data;
                    var tabla = "";

                    for (ind in respuesta) {
                        var fila = "<tr>";
                        fila += "<td>" + respuesta[ind].id + "</td>";
                        fila += "<td>" + respuesta[ind].nro_dam + "</td>";
                        fila += "<td>" + respuesta[ind].guia_remision + "</td>";
                        fila += "<td>" + respuesta[ind].nro_operacion + "</td>";
                        fila += "<td>" + respuesta[ind].item + "</td>";
                        fila += "<td>" + respuesta[ind].codigo + "</td>";
                        fila += "<td>" + respuesta[ind].codigo_rfid + "</td>";
                        fila += "<td>" + respuesta[ind].ubigeo + "</td>";
                        fila += "<td>" + respuesta[ind].ubicacion + "</td>";
                        fila += "<td>" + respuesta[ind].cliente + "</td>";
                        fila += "<td>" + respuesta[ind].familia_producto + "</td>";
                        fila += "<td>" + respuesta[ind].descripcion + "</td>";
                        fila += "<td>" + respuesta[ind].cantidad + "</td>";
                        fila += "<td>" + respuesta[ind].unidad_medida + "</td>";
                        fila += "<td>" + respuesta[ind].fecha_vinculacion + "</td>";
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
                    console.log(response.respuesta)
                    var tag = response.respuesta;

                    document.getElementById("rfid").value = tag;
                    // console.log(response)
                    console.log("Depurar");
                }
            });
        }
        setInterval(function() {
            llamar_chip();
        }, 1000);
    });

    $(function() {
        $("#form_vinculacion").submit(function(event) {
            event.preventDefault();
            var datos = $(this).serialize(),
                url = $(this).attr('action');
            console.log(datos);

            $.ajax({
                type: "POST",
                url: url,
                data: datos,
                dataType: "html",
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
                    <h4>Formulario de Vinculación de Activos</h4>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" id="form_vinculacion" method="post">
                    <?php echo form_open_multipart('', array('class' => 'form-horizontal')) ?>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-4 control-label">Código de Producto</label>
                            <div class="col-md-4">
                                <input type="text" readonly="readonly" class="form-control" name="codigo_producto" id="codigo_producto" placeholder="Ingresa codigo..." value="<?php echo $codigo->codigo; ?>">
                                <?php echo form_error('codigo', '<span class="label label-danger">', '</span>'); ?>
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
                            <label for="inputEmail3" class="col-md-4 control-label">Descripción</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Ingresa descripcion..." value="<?php echo $codigo->descripcion; ?>">
                                <?php echo form_error('descripcion', '<span class="label label-danger">', '</span>'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-4 control-label">Guía de Remisión</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="guia_remision" id="guia_remision" placeholder="Ingresa guia de remision..." value="<?php echo $codigo->guia_remision; ?>">
                                <?php echo form_error('descripcion', '<span class="label label-danger">', '</span>'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-4 control-label">Unidad de Medida</label>
                            <div class="col-md-4 ">
                                <select class="form-control" name="unidad_medida" id="unidad_medida">
                                    <option value="<?php echo $codigo->unidad_medida; ?>"><?php echo $codigo->unidad_medida; ?></option>
                                </select>
                                <?php echo form_error('unidad_medida', '<span class="label label-danger	">', '</span>'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-md-4 control-label">Cantidad</label>
                            <div class="col-md-4"><input type="text" class="form-control" placeholder="cantidad" value="<?php echo $codigo->cantidad; ?>" id="cantidad" name="cantidad" required></div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-4 control-label">Cliente</label>
                            <div class="col-md-4 ">
                                <select class="form-control" name="cliente" id="cliente">
                                    <option value="<?php echo $codigo->cliente; ?>"><?php echo $codigo->cliente; ?></option>
                                </select>
                                <?php echo form_error('cliente', '<span class="label label-danger	">', '</span>'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-4 control-label">Ubigeo</label>
                            <div class="col-md-4 ">
                                <select class="form-control" name="ubigeo" id="ubigeo">
                                    <option value="<?php echo $codigo->ubigeo; ?>"><?php echo $codigo->ubigeo; ?></option>
                                </select>
                                <?php echo form_error('ubigeo', '<span class="label label-danger	">', '</span>'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-4 control-label">Ubicación</label>
                            <div class="col-md-4">
                                <select class="form-control" name="ubicacion" id="ubicacion">
                                    <option value="<?php echo $codigo->ubicacion; ?>"><?php echo $codigo->ubicacion; ?></option>
                                </select>
                                <?php echo form_error('ubicacion', '<span class="label label-danger	">', '</span>'); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-4 control-label">Nro de Operación</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="nro_operacion" id="nro_operacion" placeholder="Ingresa Nro de operacion..." value="<?php echo $codigo->nro_operacion; ?>">
                                <?php echo form_error('nro_operacion', '<span class="label label-danger">', '</span>'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-4 control-label">Familia de producto</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="familia_producto" id="familia_producto" placeholder="Familia de producto..." value="<?php echo $codigo->familia_producto; ?>">
                                <?php echo form_error('familia_producto', '<span class="label label-danger">', '</span>'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-4 control-label">Itém</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="item" id="item" placeholder="Itém..." value="<?php echo $codigo->item; ?>">
                                <?php echo form_error('item', '<span class="label label-danger">', '</span>'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-2 control-label" style="width: 225px">
                                <a data-target="#miModal" data-toggle="miModal"><button type="submit" class="btn btn-success btn_aviso">Vincular</button></a>
                            </div>
                            <div style="float: right; width: 225px">
                                <a class="btn btn-primary" href="admin/inventario/vinculacion_1x1">Atrás</a>
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
                                <th style="text-align:center">N° DAM</th>
                                <th style="text-align:center">GUIA DE REMISIÓN</th>
                                <th style="text-align:center">N° OPERACIÓN</th>
                                <th style="text-align:center">ITEM</th>
                                <th style="text-align:center">CÓDIGO</th>
                                <th style="text-align:center">CÓDIGO RFID</th>
                                <th style="text-align:center">UBIGEO</th>
                                <th style="text-align:center">UBICACIÓN</th>
                                <th style="text-align:center">CLIENTE</th>
                                <th style="text-align:center">FAMILIA PRODUCTO</th>
                                <th style="text-align:center">DESCRIPCIÓN DE ACTIVO</th>
                                <th style="text-align:center">CANTIDAD</th>
                                <th style="text-align:center">UNIDAD DE MEDIDA</th>
                                <th style="text-align:center">FECHA DE VINCULACIÓN</th>
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