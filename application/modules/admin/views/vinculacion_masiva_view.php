<div class="row-fluid">
    <h1>
        <center>VINCULACIÓN MASIVA DE CODIGOS RFID -> 1-SKU</center>
    </h1>
</div>

<script>
    $(function() {
        let repetir = function() {
            $.ajax({
                url: "admin/vinculacion/get_lista_vinculacion_masiva",
                type: "post",
                data: {},
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    var respuesta = response;
                    var tabla = "";

                    for (ind in respuesta) {
                        var fila = "<tr>";
                        fila += "<td>" + respuesta[ind].indice + "</td>";
                        fila += "<td>" + respuesta[ind].cod_rfid + "</td>";
                        fila += "<td>" + respuesta[ind].date + "</td>";
                        fila += "<td style='text-align:center' class='botones'><a data-target='#miModalEliminar' data-toggle='miModal'><button class='btn btn-warning boton_eliminar' cod_inventario='" + respuesta[ind].id + "' cod_item ='" + <?php echo $codigo->item; ?> + "' correlativo ='" + <?php echo $codigo->correlativo; ?> + "'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span> Eliminar</button></a></td>";
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

    // LLAMO A MODAL ELIMINAR
    $("body").on("click", ".boton_eliminar", function() {
        //$('#miModal').modal('show'); //<-- you should use show in this situation
        $('#miModalEliminar').modal();
        var cod_inventario = $(this).attr('cod_inventario');
        var cod_item = $(this).attr('cod_item');
        var correlativo = $(this).attr('correlativo');
        $('.eliminar').attr('href', 'admin/vinculacion/eliminar_masiva/' + cod_inventario + '/' + cod_item + '/' + correlativo);
    });
    //ENVIAR DATA DE VINCULACION MASIVA
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
                    jAlert(resultado, "Mensaje");
                    //refreshTable();
                    document.getElementById("form_vinculacion").reset();
                    setTimeout(function() {
                        document.location.reload(); //Actualiza la pagina
                    }, 5000);
                },
                error: function(error) {
                    alert('ERROR!');
                    //                $.unblockUI();
                }
            });
            return false; //stop the actual form post !important!
        });
    });
    //BOTON CON RESPUESTA PARA LIMPIAR LA TABLA Y REFRESCAR LA PAGINA
    $(function() {
        $("#form_limpiar").submit(function(event) {
            event.preventDefault();
            var datos = $(this).serialize(),
                url = "admin/vinculacion/limpiar_tabla_masiva";
            console.log(datos);

            $.ajax({
                type: "POST",
                url: url,
                data: datos,
                dataType: "html",
                success: function(resultado) {
                    jAlert(resultado, "Mensaje");
                    //refreshTable();
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
    //BOTON CON RESPUESTA PARA CONFIRMAR LECTURAS Y REFRESCAR LA PAGINA
    $(function() {
        $("#form_confirmar").submit(function(event) {
            event.preventDefault();
            var datos = $(this).serialize(),
                url = "admin/vinculacion/vinculacion_masiva";
            console.log(datos);

            $.ajax({
                type: "POST",
                url: url,
                data: datos,
                dataType: "html",
                success: function(resultado) {
                    jAlert(resultado, "Mensaje");
                    //refreshTable();
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
<br>
<br>
<br>

<div class="main-container">
    <div class="row gutter">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="panel panel-light panel-blue">
                <div class="panel-heading">
                    <h4>Formulario para Vincular "N" Código RFID a 1 SKU</h4>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" id="form_vinculacion" method="post">
                        <?php echo form_open_multipart('', array('class' => 'form-horizontal')) ?>
                        <div class="form-group row gutter">
                            <label for="inputPassword3" class="col-sm-2 control-label">Correlativo de PARTE DE INGRESO</label>
                            <div class="col-sm-7"><input type="text" class="form-control" placeholder="parte_ingreso" id="parte_ingreso" name="parte_ingreso" value="<?php echo $codigo->correlativo; ?>"></div>
                        </div>
                        <div class="form-group row gutter">
                            <label for="inputPassword3" class="col-sm-2 control-label">Descripcion</label>
                            <div class="col-sm-7"><input type="text" class="form-control" placeholder="Descripcion" id="descripcion" name="descripcion" value="<?php echo $codigo->descripcion; ?>"></div>
                        </div>
                        <div class="form-group row gutter">
                            <label for="inputPassword3" class="col-sm-2 control-label">Código de Activo (SKU)</label>
                            <div class="col-sm-7"><input type="text" class="form-control" placeholder="Codigo de Barras del activo" id="codigo_producto" name="codigo_producto" value="<?php echo $codigo->codigo; ?>">
                            </div>
                        </div>
                        <div class="form-group row gutter">
                            <label for="inputEmail3" class="col-sm-2 control-label">Cliente</label>
                            <div class="col-sm-7 ">
                                <select class="form-control" name="cliente" id="cliente">
                                    <option value="<?php echo $codigo->cliente; ?>"><?php echo $codigo->cliente; ?></option>
                                </select>
                                <?php echo form_error('cliente', '<span class="label label-danger	">', '</span>'); ?>
                            </div>
                        </div>
                        <div class="form-group row gutter">
                            <label for="inputEmail3" class="col-sm-2 control-label">Ubigeo</label>
                            <div class="col-sm-7 ">
                                <select class="form-control" name="ubigeo" id="ubigeo">
                                    <option value="<?php echo $codigo->ubigeo; ?>"><?php echo $codigo->ubigeo; ?></option>
                                </select>
                                <?php echo form_error('ubigeo', '<span class="label label-danger	">', '</span>'); ?>
                            </div>
                        </div>
                        <div class="form-group row gutter">
                            <label for="inputEmail3" class="col-sm-2 control-label">Ubicación</label>
                            <div class="col-sm-7 ">
                                <select class="form-control" name="ubicacion" id="ubicacion">
                                    <option value="<?php echo $codigo->ubicacion; ?>"><?php echo $codigo->ubicacion; ?></option>
                                </select>
                                <?php echo form_error('ubicacion', '<span class="label label-danger	">', '</span>'); ?>
                            </div>
                        </div>
                        <div class="form-group row gutter">
                            <label for="inputPassword3" class="col-sm-2 control-label">Nro DUA</label>
                            <div class="col-sm-7"><input type="text" class="form-control" placeholder="Ingrese nro_dua" id="nro_dua" name="nro_dua" value="<?php echo $codigo->nro_dua; ?>"></div>
                        </div>
                        <div class="form-group row gutter">
                            <label for="inputPassword3" class="col-sm-2 control-label">Guia de Remisión</label>
                            <div class="col-sm-7"><input type="text" class="form-control" placeholder="Ingrese guia_remision" id="guia_remision" name="guia_remision" value="<?php echo $codigo->guia_remision; ?>"></div>
                            <button type="submit" class="btn btn-success" id="guardar">Vincular</button>
                        </div>

                        <div class="form-group row gutter">
                            <label for="inputPassword3" class="col-sm-2 control-label">Item</label>
                            <div class="col-sm-7"><input type="text" class="form-control" placeholder="Ingrese Item" id="item" name="item" value="<?php echo $codigo->item; ?>"></div>
                        </div>
                        <div class="form-group row gutter">
                            <label for="inputPassword3" class="col-sm-2 control-label">Familia de Producto</label>
                            <div class="col-sm-7"><input type="text" class="form-control" placeholder="Ingrese familia producto" id="familia_producto" name="familia_producto" value="<?php echo $codigo->familia_producto; ?>"></div>
                        </div>
                        <div class="form-group row gutter">
                            <label for="inputEmail3" class="col-sm-2 control-label">Unidad de Medida</label>
                            <div class="col-sm-7 ">
                                <select class="form-control" name="unidad_medida" id="unidad_medida">
                                    <option value="<?php echo $codigo->unidad_medida; ?>"><?php echo $codigo->unidad_medida; ?></option>
                                </select>
                                <?php echo form_error('unidad_medida', '<span class="label label-danger	">', '</span>'); ?>
                            </div>
                        </div>
                        <div class="form-group row gutter">
                            <label for="inputPassword3" class="col-sm-2 control-label">Cantidad</label>
                            <div class="col-sm-7"><input type="text" class="form-control" placeholder="cantidad" id="cantidad" name="cantidad" value="<?php echo $codigo->cantidad; ?>"></div>
                        </div>
                        <div class="form-group row gutter">
                            <label for="inputPassword3" class="col-sm-2 control-label">Observaciones</label>
                            <div class="col-sm-7"><input type="text" class="form-control" id="observaciones" name="observaciones" value="<?php echo $codigo->observaciones; ?>"></div>
                        </div>
                        <div class="form-group row gutter">
                            <label for="inputPassword3" class="col-sm-2 control-label">Jefe de Almacén</label>
                            <div class="col-sm-7"><input type="text" class="form-control" id="jefe_almacen" name="jefe_almacen" value="<?php echo $codigo->jefe_almacen; ?>"></div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-3"></div>
    <div class="row gutter">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="panel panel-light panel-green">
                <div class="panel-heading">
                    <h4>LISTA DE CÓDIGOS RFID LEIDOS - TIEMPO REAL</h4>
                </div>
                <div class="panel-body table-responsive">
                    <table class="table danger table-striped no-margin text-center" id="tbl_vinculacion" class="display">
                        <thead>
                            <tr>
                                <th style="text-align:center">ITEM</th>
                                <th style="text-align:center">CÓDIGO RFID</th>
                                <th style="text-align:center">FECHA DE LECTURA</th>
                                <th style="text-align:center">ELIMINAR</th>
                            </tr>
                        </thead>
                        <tbody id="cuerpo">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- BOTON CONFIRMAR TAGS RFID LEIDOS-->
        <form enctype="multipart/form-data" action="admin/vinculacion/vinculacion_masiva" method="POST" id="form_confirmar">
            <div style="float: left; width: 225px">
                <a href="admin/vinculacion/vinculacion_masiva"><button type="submit" class="btn btn-success btn_confirmar">CONFIRMAR LECTURAS</button></a>
            </div>
        </form>
        <!--FIN DE BOTON-->
        <!-- BOTON ATRAS-->
        <div style="float: right; width: 225px">
            <a href="admin/inventario/ver_items/<?php echo $codigo->correlativo; ?>"><button type="submit" class="btn btn-warning btn_confirmar">ATRÁS</button></a>
        </div>
        <!--FIN DE BOTON-->
        <!-- BOTON LIMPIAR TABLA EXCEL-->
        <form enctype="multipart/form-data" action="admin/vinculacion/limpiar_tabla_masiva" method="POST" id="form_limpiar">
            <div style="float: right; width: 225px">
                <a href="admin/vinculacion/limpiar_tabla_masiva"><button type="submit" class="btn btn-info btn_reiniciar">Limpiar tabla excel</button></a>
            </div>
        </form>
        <!--FIN DE BOTON-->
    </div>

    <!--    MODAL ELIMINAR-->
    <div class="modal fade" tabindex="-1" role="dialog" id="miModalEliminar">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <h4>¿Desea eliminar este registro?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <a type="button" class="btn btn-primary eliminar">Eliminar</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
</div>