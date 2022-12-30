    (jQuery)(document).ready(function($) {
        //var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
        declareDatePicker();
        inicializar_utilidades();
        pintarSelectPosicion2();
        pintarSelectPosicion();
        //obtenerEtiqueta();
        (jQuery)("#selector_fecha").val(fechaHoy());
        (jQuery)("#fecha_desde").val(fechaHoy());
        (jQuery)("#fecha_hasta").val(fechaHoy());
        (jQuery)("#introjsFechaResumen").val(fechaHoy());
    });

    (jQuery)('.marcarTodos').on('click', function(){
        var valor=(jQuery)(this).prop('checked');
        var padre=(jQuery)(this).attr('data-parent');
        (jQuery)('#'+padre+' table tr td input[type="checkbox"]').each(function(){
            if(!(jQuery)(this).prop('disabled'))
                (jQuery)(this).prop('checked', valor);
        });
    });


    var myStack = {
        "dir1": "down",
        "dir2": "right",
        "push": "top"
    };

    function fechaHoy(){
        var today = new Date();
        var ret = "";
        var dd = today.getDate();
        var mm = today.getMonth() + 1;
        var yyyy = today.getFullYear();

        if (dd < 10) {
            dd = '0' + dd
        }

        if (mm < 10) {
            mm = '0' + mm
        }

        ret = dd + '/' + mm + '/' + yyyy;
        return ret;
    }

    function inicializar_utilidades() {
      var url=(jQuery)('#urlAjax').val();
      (jQuery).ajax({
        type: "POST",
        url:url,
        data:{
          'form_key' : (jQuery)('input:hidden[name=form_key]').val(),
          action:'getInitUtilidades',
        },
        complete: function (msg) {
        var retorno = JSON.parse(msg.responseText);

        if(retorno.tipoCron === 'ajax'){
            ejecutarCron();
        }
            pintarEstados(msg.responseText);
        },
        error: function (msg) {
            pintarEstados(msg.responseText);
        }
      });
    }

    function pintarEstados(retorno) {

    var retorno = JSON.parse(retorno);

        if (retorno.etiquetaDefecto != 'undefined' && retorno.etiquetaDefecto != null) {
            (jQuery)('#select_tipo_etiqueta2').val(retorno.etiquetaDefecto);
            pintarSelectPosicion();
        }

        if (retorno.etiquetaDefecto != 'undefined' && retorno.etiquetaDefecto != null) {
            (jQuery)('#select_tipo_etiqueta').val(retorno.etiquetaDefecto);
            pintarSelectPosicion2();
        }
    }


    function convertirFormato(locale){
        switch(locale){
            case "es_ES":
                return "dd/MM/yyyy";
            break;
            case "en_US":
                return "MM/dd/yyyy";
            break;
            case "en_GB":
                return "MM/dd/yyyy";
            break;
            case "pt_PT":
                return "dd/MM/yyyy";
            break;
            default:
                return "dd/MM/yyyy";
            break;
        }
    }

    function declareDatePicker(){
        var locale = obtenerIdioma();
         requirejs(['jquery','mage/translate','mage/calendar'], (function($,$trans,$cal){
            (jQuery)('#fecha_desde').calendar({
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                currentText: $trans('Go Today'),
                closeText: $trans('Close'),
                showWeek: true,
                showOn: "both",
                dateFormat: convertirFormato(locale),
                defaultDate: new Date(),
            });

            (jQuery)('#fecha_desde  + button.ui-datepicker-trigger').css('right', '3%');
            (jQuery)('#fecha_desde  + button.ui-datepicker-trigger').css('top', '5%');

            (jQuery)('#fecha_hasta').calendar({
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                currentText: $trans('Go Today'),
                closeText: $trans('Close'),
                showWeek: true,
                showOn: "both",
                dateFormat: convertirFormato(locale),
                defaultDate: new Date(),
            });

            (jQuery)('#fecha_hasta + button.ui-datepicker-trigger').css('right', '3%');
            (jQuery)('#fecha_hasta + button.ui-datepicker-trigger').css('top', '5%');



            (jQuery)('#selector_fecha').calendar({
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                currentText: $trans('Go Today'),
                closeText: $trans('Close'),
                showWeek: true,
                showOn: "both",
                dateFormat: convertirFormato(locale),
                defaultDate: new Date(),
            });

            (jQuery)('#selector_fecha + button.ui-datepicker-trigger').css('right', '1%');
            (jQuery)('#selector_fecha + button.ui-datepicker-trigger').css('top', '5%');



            (jQuery)('#introjsFechaResumen').calendar({
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                currentText: $trans('Go Today'),
                closeText: $trans('Close'),
                showWeek: true,
                showOn: "both",
                dateFormat: convertirFormato(locale),
                defaultDate: new Date(),
            });

            (jQuery)('#introjsFechaResumen  + button.ui-datepicker-trigger').css('right', '4%');
            (jQuery)('#introjsFechaResumen  + button.ui-datepicker-trigger').css('top', '40%');

        }));

    }

    function declareDataTables(dataTable, orden){
        var table = (jQuery)('#'+dataTable).DataTable({
            dom: 'Bfrtlip',
            order:orden,
            responsive:true,
            language:{
                "sProcessing":     procesandoTablaGrab,
                "sLengthMenu":     mostrarTablaGrab,
                "sZeroRecords":    noResultadosTablaGrab,
                "sEmptyTable":     sinDatosTablaGrab,
                "sInfo":           mostrandoTablaGrab,
                "sInfoEmpty":      mostrandoCeroTablaGrab,
                "sInfoFiltered":   filtrandoTablaGrab,
                "sInfoPostFix":    "",
                "sSearch":         buscarTablaGrab,
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": cargandoTablaGrab,
                "oPaginate": {
                    "sFirst":    primeroTablaGrab,
                    "sLast":     ultimoTablaGrab,
                    "sNext":     siguienteTablaGrab,
                    "sPrevious": anteriorTablaGrab
                },
                "oAria": {
                    "sSortAscending":  ascendenteTablaGrab,
                    "sSortDescending": descendenteTablaGrab
                }
            },

            });
            (jQuery)('#'+dataTable+' tfoot th').each( function (index,value) {
                var title = (jQuery)(this).text();
                (jQuery)(this).html( '<button class="CEX-btn CEX-button-yellow w-100 activarBuscador" id="activarBuscador'+index+'"><i class="fa fa-search w-100"></i></button><input id="inputBuscador'+index+'" type="text" class="form-control w-100 d-none inputBuscador" />' );
            });
            //var data = table.buttons.exportData({
            //    columns: ':visible'
            //});
            table.columns().every( function () {
                var that = this;
                (jQuery)( 'input', this.footer() ).on( 'keyup change', function () {
                    if(this.value!=''){
                        if ( that.search() !== this.value ) {
                            that.search( this.value ).draw();
                        }
                    }else{
                        (jQuery)(this).addClass('d-none');
                        (jQuery)(this).parent().find('.activarBuscador').removeClass('d-none');
                        that.search( this.value ).draw();
                    }
                });
            });
            (jQuery)('.activarBuscador').click(function(event) {
                event.stopPropagation();
                (jQuery)(this).addClass('d-none');
                (jQuery)(this).parent().find('.inputBuscador').removeClass('d-none');

            });
            (jQuery)('.inputBuscador').click(function(event) {
                event.stopPropagation();
            });

            (jQuery)('html').click( function(event) {
                if((jQuery)('.activarBuscador').length>0){
                    (jQuery)('.activarBuscador').each(function(index,value){
                        var input=(jQuery)(this).parent().find('.inputBuscador');
                        if(input.val()==''){
                            (jQuery)(this).parent().find('.activarBuscador').removeClass('d-none');
                            input.addClass('d-none');
                        }
                    });
                }
            });

    }

    function obtenerPedidosBusqueda(event, borrado = 0) {
       // (jQuery)('#contenedor_errores').html('');
        //(jQuery)('#contenedor_errores').addClass('d-none');

        event.preventDefault();
        var desde=(jQuery)('#fecha_desde').val();
        var hasta=(jQuery)('#fecha_hasta').val();
        var url=(jQuery)('#urlAjax').val();

        (jQuery).ajax({
            type: "POST",
            url:url,
            data:{
              'form_key' : (jQuery)('input:hidden[name=form_key]').val(),
              action:'obtenerPedidosBusqueda',
              desde: desde,
              hasta: hasta,
          },
          showLoader: true,
          complete: function (msg) {
              pintarSelectPosicion();
              (jQuery)('#respuesta_buscador_pedidos').removeClass('d-none');
              (jQuery)('#CEX-loading').addClass('d-none');
              pintarPedidosBusqueda(msg.responseText, borrado);
          },
          error: function (msg) {
              }
          });
    }


    function buscarPedido(event){
        event.preventDefault();
        var fecha=(jQuery)('#introjsFechaResumen').val();
        var url=(jQuery)('#urlAjax').val();

        (jQuery).ajax({
            type: "POST",
            url:url,
            data:{
              'form_key' : (jQuery)('input:hidden[name=form_key]').val(),
              action:'buscarPedido',
              fecha: fecha,
          },
          showLoader: true,
          complete: function (msg) {
                (jQuery)('#contenedor_pedidos').removeClass('d-none');
                pintarSelectPosicion2();
                (jQuery)('#contenedor_pedidos').removeClass('d-none');
                (jQuery)('#contenedor_pedidos_reimpresion').removeClass('d-none');

                (jQuery)('#CEX-loading').addClass('d-none');
                pintarPedido(msg.responseText);
            },
            error: function(msg) {
                (jQuery)('#CEX-loading').addClass('d-none');
            }
          });

    }

    function pintarSelectPosicion() {
        var option = "";
        if ((jQuery)("#select_tipo_etiqueta2").val() == '1') {
            (jQuery)("#introjsPosicionEtiqueta").removeClass('d-none');
            option += "<option value='1'>1</option>" +
                "<option value='2'>2</option>" +
                "<option value='3'>3</option>";
                (jQuery)("#posicion_etiqueta_masiva").html(option);
        } else if ((jQuery)("#select_tipo_etiqueta2").val() == '2') {
            (jQuery)("#introjsPosicionEtiqueta").removeClass('d-none');
            option += "<option value='1'>1</option>" +
                "<option value='2'>2</option>";
                (jQuery)("#posicion_etiqueta_masiva").html(option);
        } else {
            (jQuery)("#introjsPosicionEtiqueta").addClass('d-none');
        }
    }


    function pintarSelectPosicion2() {
        var option = "";
        if ((jQuery)("#select_tipo_etiqueta").val()=='1') {
            (jQuery)("#introjsPosicionEtiqueta2").removeClass('d-none');
            option+="<option value='1'>1</option>"+
            "<option value='2'>2</option>"+
            "<option value='3'>3</option>";
            (jQuery)("#posicion_etiquetas").html(option);
        } else if ((jQuery)("#select_tipo_etiqueta").val()=='2') {
            (jQuery)("#introjsPosicionEtiqueta2").removeClass('d-none');
            option+="<option value='1'>1</option>"+
            "<option value='2'>2</option>";
            (jQuery)("#posicion_etiquetas").html(option);
        } else {
            (jQuery)("#introjsPosicionEtiqueta2").addClass('d-none');
        }
    }

     function pintarPedidosBusqueda(resultado, borrado) {
        var pedidos = JSON.parse(resultado);
        var tabla = '';

        if (borrado == 0) {
            (jQuery)("#contenedor_errores").empty();
        }

        var cabecera = "<table id='grabacionMasiva' border=0 class='table w-100'>" +
            "<thead><tr>" +
            "<th>"+idTablaGrab+"</th>" +
            "<th>"+refEnvioTablaGrab+"</th>" +
            "<th>"+estadoTablaGrab+"</th>" +
            "<th>"+clienteTablaGrab+"</th>" +
            //"<th><?php //echo $this->__('Precio');?></th>"+
            "<th>"+fechaTablaGrab+"</th>" +
            "<th>"+numEnvioTablaGrab+"</th>" +
            "<th>"+codOficinaTablaGrab+"</th>" +
            "<th>"+metodoTablaGrab+"</th>" +
            "<th>"+productoTablaGrab+"</th>" +
            "<th>"+bultosTablaGrab+"</th>" +
            "</tr></thead>";
        var footer = "<tfoot><tr>" +
            "<th>"+idTablaGrab+"</th>" +
            "<th>"+refEnvioTablaGrab+"</th>" +
            "<th>"+estadoTablaGrab+"</th>" +
            "<th>"+clienteTablaGrab+"</th>" +
            //"<th><?php //echo $this->__('Precio');?></th>"+
            "<th>"+fechaTablaGrab+"</th>" +
            "<th>"+numEnvioTablaGrab+"</th>" +
            "<th>"+codOficinaTablaGrab+"</th>" +
            "<th>"+metodoTablaGrab+"</th>" +
            "<th>"+productoTablaGrab+"</th>" +
            "<th>"+bultosTablaGrab+"</th>" +
            "</tr></tfoot>";
        var cierre = "</tbody>"+footer+"</table>";
        var elementos = '<tbody>';
        if (pedidos == null || pedidos == '') {
            (jQuery)('#contenedor_etiquetas_grabacion').addClass('d-none');
            //elementos +="<tr><td colspan='8' class='text-center'><strong><?php echo $this->__('No hay resultados para la búsqueda');?></strong></td></tr>";
        } else {
            (jQuery)('#contenedor_etiquetas_grabacion').removeClass('d-none');
            pedidos.forEach(function(element) {
                var checkbox = '';
                if (!element.numeroEnvio){
                    checkbox = "<input type='checkbox' id='" + element.idOrden +
                    "'class='marcarPedidos form-control my-auto before'  value='" +
                    element.idOrden + "' title='Click para seleccionar'>" + element.idOrden;
                }else{
                    checkbox = "<input type='checkbox' id='" + element.idOrden +
                    "'class='marcarPedidos form-control my-auto before'  value='" +
                    element.idOrden + "' title='Pedido GRABADO' disabled>" + element.idOrden;
                }
                elementos += "<tr>" +
                    "<td class='d-flex'>" + checkbox + "</td>" +
                    "<td>" + element.numCollect + "</td>" +
                    "<td>" + element.estado + "</td>" +
                    "<td>" + element.cliente + "</td>" +
                    //"<td>"+element.precio +"</td>"+
                    "<td>" + element.fecha + "</td>" +
                    "<td>" + element.numeroEnvio + "</td>" +
                    "<td>" + element.codigoOficina + "</td>" +
                    "<td>" + element.carrierProducto + "</td>" +
                    "<td>" + element.selectProductos + "</td>" +
                    "<td><input type='number' class='form-control' value='" + element.bultos + "'>" +
                    "</tr>";
            });
        }
        (jQuery)('#respuesta_buscador_pedidos').html(cabecera + elementos + cierre);
        (jQuery)('#contenedor_respuesta_buscador_pedidos').removeClass('d-none');
        //(jQuery)('#contenedor_errores').html('');
        $orden=new Array();
        $orden=[[1, 'asc'],[0, 'desc']];
        declareDataTables('grabacionMasiva',$orden);
    }

    function pintarPedido(msg) {
        var pedidos = JSON.parse(msg);
        var cabecera = "<table id='reimpresionMasiva' border=0 class='table w-100'>" +
            "<thead><tr>" +
            "<th>"+idTabla+"</th>" +
            "<th>"+refEnvioTabla+"</th>" +
            "<th>"+codEnvioTabla+"</th>" +
            "<th>"+nomDestinatarioTabla+"</th>" +
            "<th>"+dirDestinatarioTabla+"</th>" +
            "<th>"+fechaCreacionTabla+"</th>" +
            "</tr></thead>";
        var footer = "<tfoot><tr>" +
            "<th>ID</th>" +
            "<th>REF ENVÍO</th>" +
            "<th>CÓDIGO ENVÍO</th>" +
            "<th>NOMBRE DESTINATARIO</th>" +
            "<th>DIRECCIÓN DESTINATARIO</th>" +
            "<th>FECHA CREACIÓN</th>" +
            "</tr></tfoot>";
        var cierre = "</tbody>"+footer+"</table>";
        var elementos = '<tbody>';
        if (pedidos == null || pedidos == '') {
            (jQuery)('#contenedor_etiquetas_reimpresion').addClass('d-none');
            //elementos +="<tr><td colspan='6' class='text-center'><strong><?php echo $this->__('No hay resultados para la búsqueda');?></strong></td></tr>";
        } else {
            (jQuery)('#contenedor_etiquetas_reimpresion').removeClass('d-none');
            pedidos.forEach(function(element) {
                if (element.dias >= 7) {
                    var checkbox = "<input type='checkbox' class='form-control my-auto before' id='" + element
                        .idOrden + "' value='" + element
                        .numCollect + "' disabled>" + element.idOrden;
                } else {
                    var checkbox = "<input type='checkbox' class='marcarEtiquetas form-control my-auto before' id='" +
                        element.idOrden +
                        "' value='" + element.numCollect + "'>" + element.idOrden;
                }
                elementos += "<tr>" +
                    "<td class='d-flex'>" + checkbox + "</td>" +
                    "<td>" + element.numCollect + "</td>" +
                    "<td>" + element.numShip + "</td>" +
                    "<td>" + element.NombreDestinatario + "</td>" +
                    "<td>" + element.direccionDestino + "</td>" +
                    "<td>" + element.fecha + "</td>" +
                    "</tr>";

            });
        }

        (jQuery)('#contenedor_pedidos_reimpresion').html(cabecera + elementos + cierre);
        (jQuery)('#contenedor_pedidos').removeClass('d-none');
        $orden=new Array();
        $orden=[[1, 'asc'],[0, 'desc']];
        declareDataTables('reimpresionMasiva',$orden);
    }

    function activarManual(manual, check) {
        manual += 'Manual';
        (jQuery)('.CEX-manual').addClass('d-none');
        (jQuery)('#' + manual).removeClass('d-none');
        switch (check) {
            case 1:
                (jQuery)('#toggleGrabacionIntroJS').prop('checked', false);
                checkGrabacionIntroJS();
                break;
            case 2:
                (jQuery)('#toggleReimpresionIntroJS').prop('checked', false);
                checkReimpresionIntroJS();
                break;
            case 3:
                (jQuery)('#toggleResumenIntroJS').prop('checked', false);
                checkResumenIntroJS();
                break;
        }
        selectTab(check);
    }

    function selectTab(check){
        switch (check) {
            case 1:
                (jQuery)('#grabar_envios').addClass( "show active" );
                (jQuery)('#grabar_envios').removeClass( "fade" );

                (jQuery)('#cex_generar_etiquetas').removeClass( "show active" );
                (jQuery)('#cex_generar_etiquetas').addClass( "fade" );

                (jQuery)('#cex_generar_resumen').removeClass( "show active" );
                (jQuery)('#cex_generar_resumen').addClass( "fade" );
                break;
            case 2:
                (jQuery)('#grabar_envios').removeClass( "show active" );
                (jQuery)('#grabar_envios').addClass( "fade" );

                (jQuery)('#cex_generar_etiquetas').addClass( "show active" );
                (jQuery)('#cex_generar_etiquetas').removeClass( "fade" );

                (jQuery)('#cex_generar_resumen').removeClass( "show active" );
                (jQuery)('#cex_generar_resumen').addClass( "fade" );
                break;
            case 3:
                (jQuery)('#grabar_envios').removeClass( "show active" );
                (jQuery)('#grabar_envios').addClass( "fade" );

                (jQuery)('#cex_generar_etiquetas').removeClass( "show active" );
                (jQuery)('#cex_generar_etiquetas').addClass( "fade" );

                (jQuery)('#cex_generar_resumen').addClass( "show active" );
                (jQuery)('#cex_generar_resumen').removeClass( "fade" );
                break;
        }
    }


     (jQuery)('.collapse').on('hidden.bs.collapse', function () {
        var idAtributo=this.id;
        var eq=(jQuery)('#'+idAtributo).attr('eq');
        (jQuery)('.collapse').eq(eq).collapse('show');
    });


     function generarNumerosEnvio(event) {
        event.preventDefault();
        (jQuery)('#CEX-loading').removeClass('d-none');
        (jQuery)('#contenedor_errores').html('');
        (jQuery)('#contenedor_errores').addClass('d-none');
        var ordenes = {};
        let errores = [];
        let etiquetas = [];
        ordenes = parsearGrabacionMasiva();

        if(ordenes.length ==0){
            pintarNotificacionError(errorSeleccion);
            return;
        }
            var url=(jQuery)('#urlAjax').val();
            (jQuery).ajax({
                type: "POST",
                url:url,
                data:{
                    'form_key' : (jQuery)('input:hidden[name=form_key]').val(),
                    action:         'cexFormPedidos',
                    ordenes:        ordenes,
                    id_employee:    1,
                    tipoEtiqueta:   (jQuery)('#select_tipo_etiqueta2').val(),
                    posicion:       (jQuery)("#posicion_etiqueta_masiva").val(),
                },
                showLoader: true,
                success: function(msg) {
                    (jQuery)('#CEX-loading').addClass('d-none');
                    msg= JSON.parse(msg); 
                    if(msg.etiquetas != false){
                        msg.etiquetas.forEach(function(etiqueta){                            
                            descargarEtiqueta(etiqueta)             
                        }); 
                    }
                    if(msg.errores != false){
                        pintarNotificacionError(errorReimpresion);
                        (jQuery)('#contenedor_errores').html(msg.errores);
                        (jQuery)('#contenedor_errores').removeClass('d-none');
                    }

                    if(msg.errores == false){
                        obtenerPedidosBusqueda(event,0);
                    } 
                },
                error: function (msg) {
                    (jQuery)('#CEX-loading').addClass('d-none');
                }
            });
    }

    function pintarErrores(errores, nombreTabla, idContenedor) {
        requirejs(['pnotify' ,'pnotify.buttons', 'pnotify.confirm'], function(PNotify){
            PNotify.prototype.options.styling = "bootstrap3";
            new PNotify({
                title: 'ERROR',
                text: conErrores,
                type: 'error',
                stack: myStack
            });
        });
        var cabecera = "<h4>"+tituloErroresTabla+"</h4>";
        cabecera += "<table id='"+nombreTabla+ "' class='table w-100'>" +
                     "<thead><tr>" +
                     "<th>"+idErroresTabla+"</th>" +
                     "<th>"+mensajeErroresTabla+"</th>" +
                     "<th>"+enlaceErroresTabla+"</th>" +
                     "</tr></thead>";
        var finTabla = "</table>";
        var contenido = "<tbody>";
        errores.forEach(function(cliente) {
         cliente.forEach(function(elemento){
             var token = '{$cex_token|escape:"javascript":"UTF-8"}';
             var enlace = "<a href='"+elemento.url+"'>"+editarErroresTabla+"</a>";
             contenido += "<tr>" +
                             "<td>" + elemento.idOrder + "</td>" +
                             "<td>" + elemento.codError + " - " + elemento.desErr + "</td>" +
                             "<td>" + enlace + "</td>" +
                             "</tr>";
         });
        });
        contenido+='</tbody>';
        var footer="<tfoot><tr>" +
                     "<th>"+idErroresTabla+"</th>" +
                     "<th>"+mensajeErroresTabla+"</th>" +
                     "<th>"+enlaceErroresTabla+"</th>" +
                     "</tr></tfoot>";
        (jQuery)(idContenedor).html(cabecera + contenido + footer + finTabla);
        (jQuery)(idContenedor).removeClass('d-none');
    }



    function generarEtiquetasGrabaciones(msg) {
        var url=(jQuery)('#urlAjax').val();
        var retorno = new Array();
        var checkboxes = (jQuery)('#respuesta_buscador_pedidos input[type=checkbox]:checked');
        for (i = 0; i < checkboxes.length; i++) {
            msg.forEach(function(element){
                if(element['id_order']==checkboxes[i].value && element['resultado'] == '1'){
                    retorno.push(element['numCollect']);
                }
            });
        }

        if(retorno.length>0){
          (jQuery).ajax({
                type: "POST",
                url:url,
                data:{
                    'form_key'      : (jQuery)('input:hidden[name=form_key]').val(),
                    action          : 'cexGenerarEtiquetas',
                    numCollect      : retorno,
                    tipoEtiqueta    : (jQuery)('#select_tipo_etiqueta2').val(),
                    posicion        : (jQuery)("#posicion_etiqueta_masiva").val(),
                    tipoReimpresion : 1,
                },
                showLoader: true,
                complete: function (msg) {
                    msg=msg.responseText;
                    (jQuery)('#CEX-loading').addClass('d-none');
                    var base64 = msg.substring(153);
                    var date = new Date();
                    var nombre = 'etiquetas' + date.getTime() + '.pdf';
                    (jQuery)("#etiquetas").attr("download", nombre);
                    (jQuery)("#etiquetas").attr("href", "data:application/pdf;base64," + base64);
                    (jQuery)("#etiquetas")[0].click();
                },
                error: function (msg) {
                }
            });
        }
    }

    function generarEtiquetasReimpresion(event) {
        event.preventDefault();
        (jQuery)('#CEX-loading').removeClass('d-none');
        (jQuery)('#contenedor_errores_reimpresion').html('');
        (jQuery)('#contenedor_errores_reimpresion').addClass('d-none');
        var numCollect = obtenerNumCollects();

        if (numCollect.length == 0) {
            pintarNotificacionError(errorSeleccion);
            return;
        }
        var url=(jQuery)('#urlAjax').val();
        (jQuery).ajax({
            type: "POST",
            url: url,
            data: {
                'form_key'          : (jQuery)('input:hidden[name=form_key]').val(),
                'action'            : 'cexGenerarEtiquetas',
                'numCollect'        : numCollect,
                'tipoEtiqueta'      : (jQuery)('#select_tipo_etiqueta').val(),
                'posicion'          : (jQuery)("#posicion_etiquetas").val(),
                'tipoReimpresion'   : 0
            },
            success: function(msg) {
                (jQuery)('#CEX-loading').addClass('d-none');
                msg = JSON.parse(msg);
                msg.etiquetas.forEach(function (etiqueta) {
                    if (etiqueta != null){
                        descargarEtiqueta(etiqueta);
                    }                            
                });
                if(msg.errores !== false) {
                    pintarNotificacionError(errorReimpresion);
                    (jQuery)('#contenedor_errores_reimpresion').html(msg.errores);
                    (jQuery)('#contenedor_errores_reimpresion').removeClass('d-none');
                }
            },
            error: function(msg) {
                (jQuery)('#CEX-loading').addClass('d-none');
            }
        });

    }

    function pintarNotificacionError(mensaje){
        requirejs(['pnotify' ,'pnotify.buttons', 'pnotify.confirm'], function(PNotify){
            PNotify.prototype.options.styling = "bootstrap3";
            new PNotify({
                title: 'ERROR',
                text: mensaje,
                type: 'error',
                stack: myStack
            });
        });
        (jQuery)('#CEX-loading').addClass('d-none');
    }

    function descargarEtiqueta(etiqueta){
        var date = new Date();
        var nombre = 'Etiqueta_' + date.getDate() + '_' + (date.getMonth()+1) + '_' +date.getFullYear() + '_'  +'.pdf';
        (jQuery)("#etiquetas").attr("download", nombre);
        (jQuery)("#etiquetas").attr("href", "data:application/pdf;base64," + etiqueta);
        (jQuery)("#etiquetas")[0].click();
    }

    function parsearGrabacionMasiva() {
        var respuesta = new Array();
        (jQuery)('#grabacionMasiva input.marcarPedidos:checked').each(function() {
            var linea = getRow(this);
            if(linea != null)
                respuesta.push(linea);
        });

        comprobarNumBultos(respuesta);
        return respuesta;
    }

    function buscarResumen(event){
        event.preventDefault();
        var url=(jQuery)('#urlAjax').val();
        (jQuery).ajax({
            type: "POST",
            url:url,
            data:{
                'form_key': (jQuery)('input:hidden[name=form_key]').val(),
                action: 'buscarResumen',
                fecha: formatFecha((jQuery)('#introjsFechaResumen').val()),
            },
            showLoader: true,
            complete: function (msg) {
                pintarResumen(msg.responseText);
            },
            error: function (msg) {
            }
        });

    }

    function pintarResumen(msg) {
        var pedidos = JSON.parse(msg);
        var cabecera = "<table id='resumenPedidos' border=0 class='table w-100'>" +
            "<thead><tr>" +
            "<th>"+idTabla +"</th>" +
            "<th>"+refEnvioTabla+"</th>" +
            "<th>"+codEnvioTabla +"</th>" +
            "<th>"+nomDestinatarioTabla +"</th>" +
            "<th>"+dirDestinatarioTabla  +"</th>" +
            "<th>"+fechaCreacionTabla  +"</th>" +
            "</tr></thead>";
        var footer = "<tfoot><tr>" +
            "<th>"+idTabla +"</th>" +
            "<th>"+refEnvioTabla+"</th>" +
            "<th>"+codEnvioTabla +"</th>" +
            "<th>"+nomDestinatarioTabla +"</th>" +
            "<th>"+dirDestinatarioTabla  +"</th>" +
            "<th>"+fechaCreacionTabla  +"</th>" +
            "</tr></tfoot>";
        var cierre = "</tbody>"+footer+"</table>";

        var elementos = '<tbody>';
        if (pedidos == null || pedidos == '') {
            (jQuery)('#opcionesResumen').addClass('d-none');
            //elementos +="<tr><td colspan='6' class='text-center'><strong><?php echo $this->__('No hay resultados para la b&uacute;squeda');?></strong></td></tr>";
        } else {
            (jQuery)('#opcionesResumen').removeClass('d-none');
            pedidos.forEach(function(element) {

                var checkbox = "<input type='checkbox' class='marcarResumen form-control my-auto before' id='" + element.idOrden +"' value='" + element.numCollect + "'>" + element.idOrden;

                elementos += "<tr>" +
                    "<td class='d-flex'>" + checkbox + "</td>" +
                    "<td>" + element.numCollect + "</td>" +
                    "<td>" + element.numShip + "</td>" +
                    "<td>" + element.NombreDestinatario + "</td>" +
                    "<td>" + element.direccionDestino + "</td>" +
                    "<td>" + element.fecha + "</td>" +
                    "</tr>";
            });
        }

        (jQuery)('#contenedor_resumen_pedidos').html(cabecera + elementos + cierre);
        (jQuery)('#contenedor_resumen').removeClass('d-none');
        (jQuery)('#boton_resumen').removeClass('d-none');
        (jQuery)('#marcarResumen').removeClass('d-none');
        $orden=new Array();
        $orden=[[1, 'asc'],[0, 'desc']];
        declareDataTables('resumenPedidos',$orden);
    }

    function imprimirResumen(event){
        event.preventDefault();
        (jQuery)('#contenedor_errores_resumen').html('');
        (jQuery)('#contenedor_errores_resumen').addClass('d-none');
        var url         =(jQuery)('#urlAjax').val();
        var retorno     = new Array();
        var checkboxes  = (jQuery)('#contenedor_resumen input.marcarResumen:checked');

        for (i = 0; i < checkboxes.length; i++) {
            retorno.push(checkboxes[i].value);
        }

        if(retorno == 0){
            requirejs(['pnotify' ,'pnotify.buttons', 'pnotify.confirm'], function(PNotify){
                PNotify.prototype.options.styling = "bootstrap3";
                new PNotify({
                    title : selectError,
                    text  : selectEnvio,
                    type  : 'error',
                    stack : myStack
                });
            });
            return;
        }
        (jQuery).ajax({
            type: "POST",
            url:url,
            data:{
                'form_key'  : (jQuery)('input:hidden[name=form_key]').val(),
                action      : 'generarResumen',
                fecha       : formatFecha((jQuery)('#introjsFechaResumen').val()),
                numCollect  : retorno,
            },
            showLoader: true,
            complete: function (msg) {
                msg = JSON.parse(msg.responseText); 
                msg.reports.forEach(function (report) {
                    if (report != null){
                        descargarResumen(report);
                    }                            
                });

                if(msg.errors !== false) {
                    pintarNotificacionError(errorResumen);                                  
                    (jQuery)('#contenedor_errores_resumen').html(msg.errors);
                    (jQuery)('#contenedor_errores_resumen').removeClass('d-none');
                }
            },
            error: function (msg) {
            }
        });

    }

    function descargarResumen(resumen){
        var date    = new Date();
        var nombre  = 'Resumen_' + date.getDate() + '_' + (date.getMonth()+1) + '_' +date.getFullYear() + '_'  +'.pdf';
        (jQuery)("#etiquetas").attr("download", nombre);
        (jQuery)("#etiquetas").attr("href", "data:application/pdf;base64," + resumen);
        (jQuery)("#etiquetas")[0].click(); 
    }

    function formatFecha(fecha){
        var fechaArray=fecha.split('/');
        var nuevo_formato=fechaArray[2]+'-'+fechaArray[1]+'-'+fechaArray[0];
        return nuevo_formato;
    }

    function obtenerNumCollects() {
        //recorrer los elementos del div y coger sus ids
        var retorno = new Array();
        var checkboxes = (jQuery)("#contenedor_pedidos input.marcarEtiquetas:checked");
        for (i = 0; i < checkboxes.length; i++) {
            retorno.push(checkboxes[i].value);
        }
        return retorno;
    }

    function getRow(resp) {
        var row = (jQuery)(resp).parents('tr');
        var retorno = null;
        retorno = {
            'id'            : row.find('td:eq(0) input').val(),
            'oficina'       : row.find('td:eq(6)').text(),
            'productosCEX'  : row.find('td:eq(8) option:selected').val(),
            'bultos'        : row.find('td:eq(9) input').val()
        };
        return retorno;
    }

    function comprobarNumBultos(ordenes) {
        ordenes.find(function(e) {
            if (!(e.bultos >= 1)) {
                alert(envioSinBultos +  e.id);
                (jQuery)('#CEX-loading').addClass('d-none');
                throw new Error(errorDatos);
            }
        });
    }


    function obtenerIdioma(){

            var url=(jQuery)('#urlAjax').val();

            (jQuery).ajax({
                type: "POST",
                url:url,
                data:{
                    'form_key': (jQuery)('input:hidden[name=form_key]').val(),
                    action: 'obtenerIdioma',
              },
              complete: function (msg) {
                var parseMsg = msg.responseText;
                var idioma = parseMsg.replace(/\s+/g, '');
            },
            error: function (msg) {
            }
        });

    }

    function ejecutarCron() {
    var url=(jQuery)('#urlAjax').val();
    (jQuery).ajax({
        type: "POST",
        url: url,
        data:{
            'form_key' : (jQuery)('input:hidden[name=form_key]').val(),
            'action'   : 'ejecutarCron',
        },
        complete: function(msg) {
            console.log(msg);        }
    });
}
