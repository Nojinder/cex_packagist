    define(['jquery','domReady!'], function($) {
            inicializar();
            inicioHistorico();
            declareDatePicker();
        }(jQuery)
    );

    window.onload = function() {
        document.getElementById("cex_fecha_entrega").min = fechaHoy();
        document.getElementById("cex_fecha_entrega").max = fechaHoy() + 30;
        document.getElementById("cex_fecha_entrega").value = fechaHoy();
    }

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

     function convertirFormato(locale){
        switch(locale){
            case "es_ES":
            case "pt_PT":
                return "dd/MM/yyyy";
            break;
            case "en_US":
            case "en_GB":
                return "MM/dd/yyyy";
            break;
            default:
                return "dd/MM/yyyy";
            break;
        }
    }

    function declareDatePicker(){
        var locale = obtenerIdioma();
         requirejs(['jquery','mage/translate','mage/calendar'], (function($,$trans,$cal){
                (jQuery)('#cex_fecha_entrega').calendar({
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

                (jQuery)('#cex_fecha_entrega  + button.ui-datepicker-trigger').css('right', '3%');
                (jQuery)('#cex_fecha_entrega  + button.ui-datepicker-trigger').css('top', '5%');
            })
        );
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

    function inicializar() {
        var url=(jQuery)('#urlAjax').val();
        var id=(jQuery)('#idOrder').val();
        (jQuery)('[name=custom_tab]').parent().css('display','none');
        (jQuery).ajax({
            type: "POST",
            url: url,
            data:{
                'form_key' : (jQuery)('input:hidden[name=form_key]').val(),
                'action'   :'cexFormOrderTemplate',
                'id'       : id

            },
            showLoader: true,
            complete: function (msg) {
                var retorno = JSON.parse(msg.responseText);
                var datosRemitente = retorno.datosRemitente;
                if(retorno.tipoCron === "ajax"){
                    ejecutarCron();
                }

                if (datosRemitente === "") {
                        var html = "<div class='messages'>"+
                                    "<div class='message message-warning warning'>"+
                                        "<div data-ui-id='messages-message-warning'>"+msg_noRemitente+"</div>"+
                                    "</div>"+
                                "</div>";
                    (jQuery)('#order-messages').append(html);

                }else if(retorno.esCex === false || retorno.esCex === 'false'){
                    var html = "<div class='messages'>"+
                                    "<div class='message message-warning warning'>"+
                                        "<div data-ui-id='messages-message-warning'>"+msg_noMapped+"</div>"+
                                    "</div>"+
                                "</div>";
                    (jQuery)('#order-messages').append(html);

                }else{

                    (jQuery)('[name=custom_tab]').parent().css('display','');
                    (jQuery)('#mostrarForm').show();
                    pintarRespuestaAjax(msg.responseText);
                    mostrarCheck();
                    if ((jQuery)('#cex_select_modalidad_envio').val() == 44) {
                        (jQuery)('#cex_entrega_oficina').prop('checked', 'checked');
                    }
                    mostrarBoton();
                    mostrarCodigoAt();
                }
            },
            error: function (msg) {
                pintarRespuestaAjax(msg.responseText);
            }
        });
    }

    function pintarRespuestaAjax(msg) {
        var retorno = JSON.parse(msg);
        if (retorno.selectCodCliente != 'undefined' && retorno.selectCodCliente != null)
            selectCodigosCliente(retorno.selectCodCliente);

        if (retorno.selectRemitentes != 'undefined' && retorno.selectRemitentes != null) {
            (jQuery)('#cex_select_remitentes').html(retorno.selectRemitentes);
        }

        if (retorno.selectDestinatarios != 'undefined' && retorno.selectDestinatarios != null) {
            (jQuery)('#cex_select_destinatarios').html(retorno.selectDestinatarios);
        }

        if (retorno.productos != 'undefined' && retorno.productos != null)
            (jQuery)('#cex_select_modalidad_envio').html(retorno.productos);

        if (retorno.paises != 'undefined' && retorno.paises != null){
            (jQuery)('#cex_select_paises').html(retorno.paises);
            (jQuery)('#cex_select_paises').val(retorno.paisOrden);
            //$('#select_paises').val(retorno.datosEnvio.country).change();
        }

        if (retorno.mensaje != 'undefined' && retorno.mensaje != null)
            pintarNotificacion(retorno.mensaje);

        if (retorno.datosRemitente != 'undefined' && retorno.datosRemitente != null){
            pintarInformacionRemitente(retorno.datosRemitente, retorno.paises);
            (jQuery)('#cex_select_codigos_cliente').val(retorno.datosRemitente.id_customer_code);
        }

        if (retorno.etiquetaDefecto != 'undefined' && retorno.etiquetaDefecto != null) {
            (jQuery)('#cex_select_etiqueta').val(retorno.etiquetaDefecto);
            pintarSelectPosicion();
             (jQuery)('#select_etiqueta_reimpresion').val(retorno.etiquetaDefecto);
            pintarSelectPosicionReimpresion();
        }

        if (retorno.metodoEnvio != 'undefined' && retorno.metodoEnvio != null)
            (jQuery)('#cex_select_modalidad_envio').val(retorno.metodoEnvio);

        if (retorno.referenciaOrder != 'undefined' && retorno.referenciaOrder != null)
            (jQuery)('#cex_referencia_envio').val(retorno.referenciaOrder);

        if (retorno.datosEnvio != 'undefined' && retorno.datosEnvio != null){
            pintarInformacionEnvio(retorno.datosEnvio);
        }
        //fijo_valido(retorno.datosEnvio);

        if (retorno.contrareembolso != 'undefined' && retorno.contrareembolso != null) {
            (jQuery)('#cex_contrareembolso').prop('checked', 'checked');
            (jQuery)('#cex_valor_contrareembolso').val(retorno.contrareembolso);
        }

        if (retorno.manual != 'undefined' &&
            retorno.manual != null &&
            retorno.manual != '' &&
            retorno.manual != 0) {
                (jQuery)('#advanced-sortables').prepend(retorno.manual);
        }

        if(retorno.datosOficina != 'undefined' && retorno.datosOficina != null ){
                (jQuery)('#cex_span_codigo_oficina').text(retorno.datosOficina.codigo_oficina);
                (jQuery)('#cex_span_text_oficina').text(retorno.datosOficina.texto_oficina);
                (jQuery)('#cex_span_text_oficina').show();
        }

        if (retorno.peso != 'undefined' &&
            retorno.peso != null &&
            retorno.peso != '' &&
            retorno.peso != 0) {
            (jQuery)('#cex_kilos').val(retorno.peso);
        }

        if (retorno.unidadMedida != 'undefined' && retorno.unidadMedida != null) {
                (jQuery)('#cex_unidadMedida').prepend(retorno.unidadMedida);
                (jQuery)('#cex_kilos').attr('placeholder',retorno.unidadMedida.toUpperCase());
            }
    }

    function pintarInformacionRemitente(pago,paises) {
        var str = pago.phone;
        if (str != "" && str != null) {
            var phone = str.replace('+', '00');
        } else {
            var phone = '';
        }

        (jQuery)('#cex_nombre_remitente').val(pago.name);
        (jQuery)('#cex_persona_contacto_rem').val(pago.contact);
        (jQuery)('#cex_direccion_recogida').val(pago.address);
        (jQuery)('#cex_codigo_postal_rem').val(pago.postcode);
        (jQuery)('#cex_poblacion').val(pago.city);
        (jQuery)('#cex_telefono').val(phone);
        (jQuery)('#cex_email_remitente').val(pago.email);
        //Asignar rango horario
        (jQuery)('#cex_desdeh').val(pago.from_hour);
        (jQuery)('#cex_desdem').val(pago.from_minute);
        (jQuery)('#cex_hastah').val(pago.to_hour);
        (jQuery)('#cex_hastam').val(pago.to_minute);
        //valor del select de codigo cliente
        (jQuery)('#cex_select_codigos_cliente').val(pago.id_cod_cliente);
        //valor del select de remitente
        (jQuery)('#cex_select_remitentes').val(pago.id_sender);
        //bultos y kg por defecto
        (jQuery)('#cex_bultos').val(pago.bultos_defecto);
        (jQuery)('#cex_kilos').val(pago.kg_defecto);
        //cehck superior izq
        (jQuery)("#cex_copia_remitente").prop('checked', true);
        //el numero de referencia es el id del post
        //(jQuery)('#referencia_envio').val(getQueryVariable('post'));
        //codigo del pais
        (jQuery)('#cex_select_paisrte').html(paises);
        (jQuery)("#cex_select_paisrte").val(pago.iso_code);

    }

    function fijo_valido(envio) {
        var RegExPattern = /^(00[0-9]{2})?(8|9)[0-9]{8}$/;
        var telefono = envio.phone;
        var phone;
        if (telefono != "" && telefono != null) {
            phone = telefono.replace('+', '00');
            if (phone.match(RegExPattern) && (phone != '')) {
                (jQuery)('#cex_telefono_fijo').val(phone);
            } else {
                (jQuery)('#cex_telefono_movil').val(phone);;
            }
        }
    }

    function pintarInformacionEnvio(envio) {
        //fijo_valido(envio);
        /*var oficina = envio.oficina;
        if (oficina != null && oficina != '') {
            var split_oficina = oficina.split("#!#");
            (jQuery)('#entrega_oficina').prop('checked', true);
            (jQuery)('#span_codigo_oficina').html(split_oficina[0]);
            (jQuery)('#span_text_oficina').html(oficina);
            mostrarCheck();
            mostrarBoton();
        }*/
        (jQuery)('#cex_nombre_destinatario').val(envio.first_name + ' ' + envio.last_name);
        (jQuery)('#cex_persona_contacto_dest').val(envio.company);
        (jQuery)('#cex_direccion').val(envio.address+ ' ' +envio.address2);
        (jQuery)('#cex_codigo_postal_dest').val(envio.postcode);
        (jQuery)('#cex_ciudad').val(envio.city);
        (jQuery)('#cex_email_destinatario').val(envio.email);
        (jQuery)('#cex_observaciones_entrega').val(envio.customer_message);
        (jQuery)('#cex_select_paises').val(envio.country);
        (jQuery)('#cex_telefono_destinatario').val(envio.telf);
    }

    function getQueryVariable(variable) {
        var query = window.location.search.substring(1);
        var vars = query.split("&");
        for (var i = 0; i < vars.length; i++) {
            var pair = vars[i].split("=");
            if (pair[0] == variable) {
                return pair[1];
            }
        }
        return false;
    }

    function pintarSelectPosicion(){
        var option= "";
        switch((jQuery)("#cex_select_etiqueta").val()){
            case '1':
                (jQuery)("#introjsPosicionEtiquetas").removeClass('d-none');
                option+="<option value='1'>1</option>"+
                        "<option value='2'>2</option>"+
                        "<option value='3'>3</option>";
                break;
            case '2':
                (jQuery)("#introjsPosicionEtiquetas").removeClass('d-none');
                option+="<option value='1'>1</option>"+
                        "<option value='2'>2</option>";
                break;
            case '3':
                (jQuery)("#introjsPosicionEtiquetas").addClass('d-none');
                option+="<option value='1'>1</option>";
                break;
        }
        (jQuery)("#cex_posicion_etiqueta").html(option);
    }


    function generarEtiqueta(numCollect, etiqueta){
        var nombre = 'CEX_Order_' + numCollect   +'.pdf';
        (jQuery)("#etiqueta").attr("download", nombre);
        (jQuery)("#etiqueta").attr("href", "data:application/pdf;base64," + etiqueta);
        (jQuery)("#etiqueta")[0].click();
        sleep(5000);
        location.reload();
    }

    function sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    function esUnaDevolucion() {
        if (!(jQuery)('#cex_es_devolucion').prop('checked')) {
            //auxiliar < == destinatario
            var auxnombredestinatario = (jQuery)('#cex_nombre_destinatario').val();
            var auxpersonacontactodest = (jQuery)('#cex_persona_contacto_dest').val();
            var auxdireccion = (jQuery)('#cex_direccion').val();
            var auxcodigopostaldest = (jQuery)('#cex_codigo_postal_dest').val();
            var auxciudad = (jQuery)('#cex_ciudad').val();
            //var auxtelefonofijo = (jQuery)('#telefono_fijo').val();
            var auxtelefonofijo = (jQuery)('#cex_telefono_destinatario').val();
            var auxemaildestinatario = (jQuery)('#cex_email_destinatario').val();
            var auxpaisdestinatario = (jQuery)('#cex_select_paises option:selected').val();

            //destinatario   <=== remitente
            (jQuery)('#cex_nombre_destinatario').val((jQuery)('#cex_nombre_remitente').val());
            (jQuery)('#cex_persona_contacto_dest').val((jQuery)('#cex_persona_contacto_rem').val());
            (jQuery)('#cex_direccion').val((jQuery)('#cex_direccion_recogida').val());
            (jQuery)('#cex_codigo_postal_dest').val((jQuery)('#cex_codigo_postal_rem').val());
            (jQuery)('#cex_ciudad').val((jQuery)('#cex_poblacion').val());
            //(jQuery)('#telefono_fijo').val((jQuery)('#telefono').val());
            (jQuery)('#cex_telefono_destinatario').val((jQuery)('#cex_telefono').val());
            (jQuery)('#cex_email_destinatario').val((jQuery)('#cex_email_remitente').val());
            (jQuery)('#cex_select_paises').val((jQuery)('#cex_select_paisrte option:selected').val()).change();


            //(jQuery)('#telefono_movil').val();

            //remitente  <=== axiliar
            (jQuery)('#cex_nombre_remitente').val(auxnombredestinatario);
            (jQuery)('#cex_persona_contacto_rem').val(auxpersonacontactodest);
            (jQuery)('#cex_direccion_recogida').val(auxdireccion);
            (jQuery)('#cex_codigo_postal_rem').val(auxcodigopostaldest);
            (jQuery)('#cex_poblacion').val(auxciudad);
            (jQuery)('#cex_telefono').val(auxtelefonofijo);
            (jQuery)('#cex_email_remitente').val(auxemaildestinatario);
            (jQuery)('#cex_select_paisrte').val(auxpaisdestinatario).change();

            //si la ultima letra ye una d, la quitamos que la pusimos nosotros
            var referencia = (jQuery)('#cex_referencia_envio').val();
            var ultimaLetra = referencia.slice(referencia.length - 1, referencia.length);
            if (ultimaLetra == 'd') {
                referencia = referencia.slice(0, referencia.length - 1);
                (jQuery)('#cex_referencia_envio').val(referencia);
            }
            (jQuery)('#cex_grabar_recogida').prop('checked',false);
        } else {
            //auxiliar    <=== remitente
            var auxnombreremitente = (jQuery)('#cex_nombre_remitente').val();
            var auxpersonacontactorem = (jQuery)('#cex_persona_contacto_rem').val();
            var auxdireccionrecogida = (jQuery)('#cex_direccion_recogida').val();
            var auxcodigopostalrem = (jQuery)('#cex_codigo_postal_rem').val();
            var auxpoblacion = (jQuery)('#cex_poblacion').val();
            var auxtelefono = (jQuery)('#cex_telefono').val();
            var auxemailremitente = (jQuery)('#cex_email_remitente').val();
            var auxpaisremitente = (jQuery)('#cex_select_paisrte option:selected').val();
            var auxpaisdestinatario = (jQuery)('#cex_select_paises option:selected').val();

            //remitente  <=== destinatario
            (jQuery)('#cex_nombre_remitente').val((jQuery)('#cex_nombre_destinatario').val());
            (jQuery)('#cex_persona_contacto_rem').val((jQuery)('#cex_persona_contacto_dest').val());
            (jQuery)('#cex_direccion_recogida').val((jQuery)('#cex_direccion').val());
            (jQuery)('#cex_codigo_postal_rem').val((jQuery)('#cex_codigo_postal_dest').val());
            (jQuery)('#cex_poblacion').val((jQuery)('#cex_ciudad').val());
            //(jQuery)('#telefono').val((jQuery)('#telefono_fijo').val());
            (jQuery)('#cex_telefono').val((jQuery)('#cex_telefono_destinatario').val());
            (jQuery)('#cex_email_remitente').val((jQuery)('#cex_email_destinatario').val());
            (jQuery)('#cex_select_paisrte').val(auxpaisdestinatario).change();


            //destinatario   <=== auxiliar
            (jQuery)('#cex_nombre_destinatario').val(auxnombreremitente);
            (jQuery)('#cex_persona_contacto_dest').val(auxpersonacontactorem);
            (jQuery)('#cex_direccion').val(auxdireccionrecogida);
            (jQuery)('#cex_codigo_postal_dest').val(auxcodigopostalrem);
            (jQuery)('#cex_ciudad').val(auxpoblacion);
            //(jQuery)('#telefono_fijo').val(auxtelefono);
            (jQuery)('#cex_telefono_destinatario').val(auxtelefono);
            (jQuery)('#cex_email_destinatario').val(auxemailremitente);
            (jQuery)('#cex_select_paises').val(auxpaisremitente).change();
                                      //si ye una devolucion, concatenamos la d a la referencia
            (jQuery)('#cex_referencia_envio').val((jQuery)('#cex_referencia_envio').val() + 'd');
            (jQuery)('#cex_grabar_recogida').prop('checked',true);
        }
    }

    function pedirRemitente() {
        var id = (jQuery)('#cex_select_remitentes').find(":selected").val();
        if ((jQuery)('#cex_copia_remitente').prop('checked')) {
            var url=(jQuery)('#urlAjax').val();
            (jQuery).ajax({
                type: "POST",
                url: url,
                data:{
                    'form_key' : (jQuery)('input:hidden[name=form_key]').val(),
                    'action':'retornarRemitente',
                    'id' : (jQuery)('#cex_select_remitentes').val()
                },
                showLoader: true,
                complete: function(msg) {
                    var remitente = msg.responseJSON;
                    (jQuery)('#cex_nombre_remitente').val(remitente.name);
                    (jQuery)('#cex_persona_contacto_rem').val(remitente.contact);
                    (jQuery)('#cex_direccion_recogida').val(remitente.address);
                    (jQuery)('#cex_codigo_postal_rem').val(remitente.postcode);
                    (jQuery)('#cex_poblacion').val(remitente.city);
                    (jQuery)('#cex_telefono').val(remitente.phone);
                    (jQuery)('#cex_email_remitente').val(remitente.email);
                    (jQuery)('#cex_select_codigos_cliente').val(remitente.id_cod_cliente);
                    (jQuery)("#cex_select_paisrte").val(remitente.iso_code);
                    (jQuery)('#cex_desdeh').val(remitente.from_hour);
                    (jQuery)('#cex_desdem').val(remitente.from_minute);
                    (jQuery)('#cex_hastah').val(remitente.to_hour);
                    (jQuery)('#cex_hastam').val(remitente.to_minute);
                    mostrarCodigoAt();
                }
            });
        }
    }

    function pedirDestinatario() {
        var tipo = (jQuery)('#cex_select_destinatarios').find(":selected").val();
        (jQuery).ajax({
            type: "POST",
            url: 'admin-ajax.php',
            data: {
                'form_key' : (jQuery)('input:hidden[name=form_key]').val(),
                'action': 'cex_retornar_destinatario',
                'tipo': tipo,
                'id': getQueryVariable('post')
                //'nonce': (jQuery)('#cex-nonce').val(),
            },
            showLoader: true,
            complete: function(msg) {
                var remitente = JSON.parse(msg);
                (jQuery)('#cex_nombre_destinatario').val(remitente.name);
                (jQuery)('#cex_persona_contacto_dest').val(remitente.contact);
                (jQuery)('#cex_direccion').val(remitente.address);
                (jQuery)('#cex_codigo_postal_dest').val(remitente.postcode);
                (jQuery)('#cex_ciudad').val(remitente.city);
                //(jQuery)('#telefono_fijo').val(remitente.phone);
                (jQuery)('#cex_telefono_destinatario').val(remitente.phone);
            },
            error: function(msg) {
            }
        });
    }

    function pedirPrecioPedido() {
        if ((jQuery)('#cex_entrega_oficina').prop('checked') && (jQuery)('#cex_contrareembolso').prop('checked')) {
            alert(error_opcion_servicio);
            (jQuery)("#cex_contrareembolso").prop('checked', false);
        }else{
            //si esta checkeado, hago la peticion, sino quito el valor
            if ((jQuery)('#cex_contrareembolso').prop('checked')) {
                var url=(jQuery)('#urlAjax').val();
                var id=(jQuery)('#idOrder').val();
                (jQuery).ajax({
                    type: "POST",
                    url: url,
                    data:{
                        action:'retornarPrecioPedido',
                        id : id
                    },
                    showLoader: true,
                    complete: function(msg) {
                        //alert(transport.responseText);
                        (jQuery)('#cex_valor_contrareembolso').val(msg.responseText.trim());
                    }
                });
            } else {
                (jQuery)('#cex_valor_contrareembolso').val('');
            }

        }

    }

    function mostrarCheck() {
        if ((jQuery)('#cex_select_modalidad_envio').val() == 44) {
            (jQuery)('#cex_informacion_oficina').removeClass('d-none');
            if ((jQuery)('#cex_span_codigo_oficina').text() == '') {
                (jQuery)('#grabar_envio').attr('disabled', 'disabled');
                (jQuery)('#grabar_envio').addClass('disabled');
            }
        } else if ((jQuery)('#cex_select_modalidad_envio').val() != 44) {
            (jQuery)('#cex_entrega_oficina').prop('checked', false);
            (jQuery)('#cex_span_codigo_oficina').text('');
            (jQuery)('#cex_buscador_oficina').addClass('d-none');
            (jQuery)('#cex_informacion_oficina').addClass('d-none');
            (jQuery)('#grabar_envio').removeClass('d-none');
            (jQuery)('#grabar_envio').removeAttr('disabled');
            (jQuery)('#grabar_envio').removeClass('disabled');
        }
    }

    function mostrarBoton() {
        if ((jQuery)('#cex_entrega_oficina').prop('checked') && !(jQuery)('#cex_contrareembolso').prop('checked')) {
            (jQuery)('#buscador_oficina').removeClass('d-none');
        }
        if ((jQuery)('#cex_entrega_oficina').prop('checked') && (jQuery)('#cex_contrareembolso').prop('checked')) {
            alert(error_opcion_contrareembolso);
            (jQuery)("#cex_entrega_oficina").prop('checked', false);

        }
        if (!(jQuery)('#cex_entrega_oficina').prop('checked')) {
            (jQuery)('#buscador_oficina').addClass('d-none');
        }
    }
/*
DEPRECADO
    function desactivaCheck() {
        if (document.getElementById('entrega_sabado').checked && (jQuery)('#select_modalidad_envio').val() != 62) {
            (jQuery)("#entrega_sabado").prop('checked', false);
        }
    }
*/
    function comprobarMetodo() {
        var myStack = {
            "dir1": "down",
            "dir2": "right",
            "push": "top"
        };

        //Paq14 es el producto de envio los sabados ( IDBC => 62 )
        var contenido = (jQuery)('#cex_select_modalidad_envio').val();
        var iso_code = (jQuery)('#cex_select_paises').val();

        if (document.getElementById('cex_entrega_sabado').checked) {
            switch(contenido){
                case '13':
                case '93':
                case '76':
                case '77':
                break;
                case 63:
                    if(iso_code != "ES"){
                        var literal = error_entrega_sabados
                        alert(literal);
                        (jQuery)("#cex_entrega_sabado").prop("checked",false);
                    }
                break;
                default:
                    var literal = error_entrega_sabados
                    alert(literal);
                    (jQuery)("#cex_entrega_sabado").prop("checked",false);
                break;
            }
        }
    }

    function buscarOficina(){
        var codPostal   = (jQuery)('#cex_codigo_postal_ofi').val();
        var poblacion   = (jQuery)('#cex_poblacion_ofi').val();

        if(codPostal == '' && poblacion == ''){
            pintarNotificacionError(validaBuscarOficina);
        }else {
            var url = (jQuery)('#urlAjax').val();
            (jQuery).ajax({
                type: "POST",
                url: url,
                dataType: 'json',
                data: {
                    'form_key': (jQuery)('input:hidden[name=form_key]').val(),
                    'action': 'procesarCurlOficinaRest',
                    'cod_postal': (jQuery)('#cex_codigo_postal_ofi').val(),
                    'poblacion': (jQuery)('#cex_poblacion_ofi').val()
                },
                showLoader: true,
                complete: function (msg) {
                    pintarOficinasModal(msg.responseText);
                    (jQuery)('#tab_oficinas').removeClass("d-none");
                },
                error: function (msg) {
                }
            });
        }
	}

    function pintarOficinasModal(msg) {
        var oficinas = JSON.parse(msg);
        oficinas = oficinas['oficinas'];
        var tabla = '';
        tabla += '<thead><tr>';
        tabla += '<th>'+cod_oficina+'</th>';
        tabla += '<th>'+cp+'</th>';
        tabla += '<th>'+direccion+'</th>';
        tabla += '<th>'+nombre+'</th>';
        tabla += '<th>'+poblacion+'</th>';
        tabla += '<th></th>';
        tabla += '</tr></thead>';
        tabla += '<tbody>';
        for (i = 0; i < oficinas.length; i++) {
            var concatenado = "'" + oficinas[i].codigoOficina + "#!#" +
                oficinas[i].direccionOficina + "#!#" +
                oficinas[i].nombreOficina + "#!#" +
                oficinas[i].codigoPostalOficina + "#!#" +
                oficinas[i].poblacionOficina + "'";
            tabla += '<tr>';
            tabla += '<td>' + oficinas[i].codigoOficina + '</td>';
            tabla += '<td>' + oficinas[i].codigoPostalOficina + '</td>';
            tabla += '<td>' + oficinas[i].direccionOficina + '</td>';
            tabla += '<td>' + oficinas[i].nombreOficina + '</td>';
            tabla += '<td>' + oficinas[i].poblacionOficina + '</td>';
            tabla += '<td><button type="button" class="CEX-btn CEX-button-blue" onclick="setCodigoOficina(' + concatenado +
                ');">'+seleccionar+'</button>';
            tabla += '</tr>'
        }
        tabla += '</tbody>';
        (jQuery)('#tabla_oficinas').html(tabla);
        (jQuery)('#contenedor_tab_oficinas').removeClass("d-none");

    }

    function setCodigoOficina(concatenado) {
        var split = concatenado.split("#!#");
        var codigofi = split[0];
        (jQuery)('#cex_span_codigo_oficina').html(codigofi);
        (jQuery)('#cex_span_text_oficina').html(concatenado);
        (jQuery)('#grabar_envio').removeAttr('disabled');
        (jQuery)('#grabar_envio').removeClass('disabled');
        (jQuery)('#grabar_envio').removeClass('d-none');
        cerrarModal();
    }
    function validarDatos(){
        (jQuery)('#grabar_envio').attr('disabled', 'disabled');
        (jQuery)('#grabar_envio').addClass('disabled');
        if(!(jQuery)('#respuestaWS').hasClass('d-none')){
            (jQuery)('#respuestaWS').addClass('d-none');
            (jQuery)('#respuestaWS').html();
        }
        validarDestinoEnvio();
    }

    function validarDestinoEnvio(){
            var postcode_receiver       = (jQuery)('#cex_codigo_postal_dest').val();
            var postcode_rem            = (jQuery)('#cex_codigo_postal_rem').val();
            var contenidoText           = (jQuery)('#cex_select_modalidad_envio').text();
            var contenidoVal            = (jQuery)('#cex_select_modalidad_envio').val();
            var iso_code                = (jQuery)('#cex_select_paises').val();
            //var iso_code                = (jQuery)('#select_paises option:selected').val();
            var modificacionAutomatica  = 0;

            if(postcode_receiver.search('-') !== -1){
                // ELIMINAMOS DEL CODIGO POSTAL PORTUGUES LOS ULTIMOS TRES DIGITOS
                var split = postcode_receiver.split("-");
                (jQuery)('#cex_codigo_postal_dest').val(split[0]);
            }
            if(postcode_rem.search('-') !== -1){
                // ELIMINAMOS DEL CODIGO POSTAL PORTUGUES LOS ULTIMOS TRES DIGITOS
                var split = postcode_rem.split("-");
                (jQuery)('#cex_codigo_postal_rem').val(split[0]);
            }

            var myStack = {"dir1":"down", "dir2":"right", "push":"top"};
            grabarEnvio(modificacionAutomatica);

    }

    function grabarEnvio(modificacionAutomatica = 0) {

        (jQuery)('#cex_referencia_envio').removeClass('is-invalid');

        if ((jQuery)('#cex_select_modalidad_envio').val() == 44 && (jQuery)('#cex_telefono_movil').val() == '') {

            (jQuery)('#respuestaWS').html(
                "<span class='alert alert-danger mt-3 rounded-2 d-block'>"+introducir_telefono_movil+"</span>"
            );
            (jQuery)('#respuestaWS').removeClass('d-none');
        } else if ((jQuery)('#cex_bultos').val() == 0 || (jQuery)('#cex_bultos').val() == null || (jQuery)('#cex_bultos').val() == '') {

            (jQuery)('#respuestaWS').html(
                "<span class='alert alert-danger mt-3 rounded-2 d-block'>"+numero_butos+"</span>"
            );
            (jQuery)('#respuestaWS').removeClass('d-none');
        } else if ((jQuery)('#cex_referencia_envio').val() == ''){
                (jQuery)('#respuestaWS').html("<span class='alert alert-danger mt-3 rounded-2 d-block'>"+errorReferencia+"</span>");
                (jQuery)('#respuestaWS').removeClass('d-none');
                (jQuery)('#cex_referencia_envio').addClass('is-invalid');
                (jQuery)('#grabar_envio').removeAttr('disabled');
                (jQuery)('#grabar_envio').removeClass('disabled');
        } else {
        /*
            var telefono_destinatario = '';
            var telefono_destinatario2 = '';
            if ((jQuery)('#telefono_movil').val() !== '' && (jQuery)('#telefono_movil').val() !== null) {
                telefono_destinatario = (jQuery)('#telefono_movil').val();
                if ((jQuery)('#telefono_fijo').val() !== '' && (jQuery)('#telefono_fijo').val() !== null) {
                    telefono_destinatario2 = (jQuery)('#telefono_fijo').val();
                } else
                    $telefono_destinatario2 = '';
            } else if ((jQuery)('#telefono_fijo').val() !== '' && (jQuery)('#telefono_fijo').val() !== null && (jQuery)(
                    '#telefono_movil').val() == '' || (jQuery)('#telefono_movil').val() == null) {
                telefono_destinatario = ' ';
                telefono_destinatario2 = (jQuery)('#telefono_fijo').val();
            } else if ((jQuery)('#telefono_movil').val() !== '' && (jQuery)('#telefono_movil').val() !== null && (jQuery)(
                    '#telefono_fijo').val() == '' || (jQuery)('#telefono_fijo').val() == null) {
                telefono_destinatario = (jQuery)('#telefono_movil').val();
                telefono_destinatario2 = ' ';
            } else {
                telefono_destinatario = ' ';
                telefono_destinatario2 = ' ';
            }*/
            var telefono_destinatario = '';
            var telefono_destinatario2 = '';
            if ((jQuery)('#cex_telefono_destinatario').val() !== '' && (jQuery)('#cex_telefono_destinatario').val() !== null) {
                telefono_destinatario = (jQuery)('#cex_telefono_destinatario').val();
            }

            if ((jQuery)('#cex_desdeh').val() < 10) {
                var desdeh = '0' + parseInt((jQuery)('#cex_desdeh').val());
            } else {
                var desdeh=parseInt((jQuery)('#cex_desdeh').val());
            }

            if ((jQuery)('#cex_desdem').val()<10 || (jQuery)('#cex_desdem').val()=='00') {
                var desdem='0'+parseInt((jQuery)('#cex_desdem').val());
            } else {
                var desdem=parseInt((jQuery)('#cex_desdem').val());
            }

            if ((jQuery)('#cex_hastah').val()<10) {
                var hastah='0'+parseInt((jQuery)('#cex_hastah').val());
            } else {
                var hastah=parseInt((jQuery)('#cex_hastah').val());
            }

            if ((jQuery)('#cex_hastam').val()<10 || (jQuery)('#cex_desdem').val()=='00') {
                var hastam='0'+parseInt((jQuery)('#cex_hastam').val());
            } else {
                var hastam=parseInt((jQuery)('#cex_hastam').val());
            }
            if (document.getElementById('cex_contrareembolso').checked) {
                var contrareembolso = (jQuery)('#cex_valor_contrareembolso').val();
            } else {
                var contrareembolso = 0;
            }

            var myStack = {
                "dir1": "down",
                "dir2": "right",
                "push": "top"
            };

            requirejs(['pnotify' ,'pnotify.buttons', 'pnotify.confirm'], function(PNotify){
              PNotify.prototype.options.styling = "bootstrap3";
            new PNotify({
                title: confirma_la_operacion,
                text: guardar_datos_pedido,
                icon: 'fas fa-question-circle',
                hide: false,
                stack: myStack,
                confirm: {
                    confirm: true
                },
                buttons: {
                    closer: false,
                    sticker: false
                }
            }).get().on('pnotify.confirm', function() {
                var fechaEntregaArray=(jQuery)('#cex_fecha_entrega').val().split("-");
                var fechaEntregaArray2=(jQuery)('#cex_fecha_entrega').val().split("/");
                if(fechaEntregaArray.length>1){
                    var fechaEntrega=fechaEntregaArray[2]+'-'+fechaEntregaArray[1]+'-'+fechaEntregaArray[0];
                }else if(fechaEntregaArray2.length>1){
                    var fechaEntrega=fechaEntregaArray2[2]+'-'+fechaEntregaArray2[1]+'-'+fechaEntregaArray2[0];
                }

                var url=(jQuery)('#urlAjax').val();
                var id=(jQuery)('#idOrder').val();
                (jQuery).ajax({
                    type: "POST",
                    url: url,
                    dataType: 'json',
                    data:{
                        'form_key' : (jQuery)('input:hidden[name=form_key]').val(),
                        'action':'cexFormPedido',
                        'id': id,
                        //primera columna
                        'loadSender': (jQuery)('#cex_select_remitentes').val(),
                        'name_sender': (jQuery)('#cex_nombre_remitente').val(),
                        'contact_sender': (jQuery)('#cex_persona_contacto_rem').val(),
                        'address_sender': (jQuery)('#cex_direccion_recogida').val(),
                        'postcode_sender': (jQuery)('#cex_codigo_postal_rem').val(),
                        'city_sender': (jQuery)('#cex_poblacion').val(),
                        'country_sender': (jQuery)('#cex_select_paisrte :selected').text(),
                        'iso_code_remitente': (jQuery)('#cex_select_paisrte').val(),
                        'phone_sender': (jQuery)('#cex_telefono').val(),
                        'email_sender': (jQuery)('#cex_email_remitente').val(),
                        //'enviarEtiquetaMail'        :(jQuery)('#enviar_etiqueta').prop('checked'),
                        'grabar_recogida': (jQuery)('#cex_grabar_recogida').prop('checked'),
                        'note_collect': (jQuery)('#cex_observaciones_recogida').val(),
                        //segunda columna
                        'loadReceiver': (jQuery)('#cex_es_devolucion').prop('checked'),
                        'name_receiver': (jQuery)('#cex_nombre_destinatario').val(),
                        'contact_receiver': (jQuery)('#cex_persona_contacto_dest').val(),
                        'address_receiver': (jQuery)('#cex_direccion').val(),
                        'postcode_receiver': (jQuery)('#cex_codigo_postal_dest').val(),
                        'city_receiver': (jQuery)('#cex_ciudad').val(),
                        'phone_receiver1': telefono_destinatario,
                        //movil , en caso de que no haya, el que haya
                        'phone_receiver2': telefono_destinatario2, //fijo
                        'email_receiver': (jQuery)('#cex_email_destinatario').val(),
                        'country_receiver': (jQuery)('#cex_select_paises :selected').text(),
                        'note_deliver': (jQuery)('#cex_observaciones_entrega').val(),
                        //tercera columna
                        'id_codigo_cliente': (jQuery)('#cex_select_codigos_cliente').val(),
                        'codigo_cliente': (jQuery)('#cex_select_codigos_cliente :selected').text(),
                        'codigo_solicitante': 'M' + (jQuery)('#cex_select_codigos_cliente :selected').text(),
                        'datepicker': fechaEntrega,
                        //'datepicker': (jQuery)('#fecha_entrega').val().replace('/','-'),
                        'fromHH_sender': desdeh,
                        'fromMM_sender': desdem,
                        'toHH_sender': hastah,
                        'toMM_sender': hastam,
                        'ref_ship': (jQuery)('#cex_referencia_envio').val(),
                        'desc_ref_1': (jQuery)('#cex_descripcion1').val(),
                        'desc_ref_2': (jQuery)('#cex_descripcion2').val(),
                        'selCarrier': (jQuery)('#cex_select_modalidad_envio').val(),
                        'nombre_modalidad': (jQuery)('#cex_select_modalidad_envio :selected').text(),
                        'deliver_sat': (jQuery)('#cex_entrega_sabado').prop('checked'),
                        'iso_code': (jQuery)('#cex_select_paises').val(),
                        'entrega_oficina': (jQuery)('#cex_entrega_oficina').prop('checked'),
                        'codigo_oficina': (jQuery)('#cex_span_codigo_oficina').text(),
                        'text_oficina': (jQuery)('#cex_span_text_oficina').text(),
                        'payback_val': contrareembolso,
                        'insured_value': (jQuery)('#cex_valor_asegurado').val(),
                        'bultos': (jQuery)('#cex_bultos').val(),
                        'kilos': (jQuery)('#cex_kilos').val(),
                        'contrareembolso': (jQuery)('#cex_contrareembolso').prop('checked'),
                        'modificacionAutomatica'    :modificacionAutomatica,
                        //etiqueta
                        'tipoEtiqueta': (jQuery)('#cex_select_etiqueta').val(),
                        'at_portugal': (jQuery)('#cex_at_portugal').val(),
                        'posicionEtiqueta': (jQuery)('#cex_posicion_etiqueta').val()
                        //'nonce': (jQuery)('#cex-nonce').val(),
                    },
                    showLoader: true,
                    complete: function(msg) {
                        var response=msg.responseText.trim();
                        pintarNotificacion(response);
                        (jQuery)('#grabar_envio').removeAttr('disabled');
                        (jQuery)('#grabar_envio').removeClass('disabled');
                        location.href = '#grabar_envio';
                    },
                    error: function(msg) {
                        (jQuery)('#grabar_envio').removeAttr('disabled');
                        (jQuery)('#grabar_envio').removeClass('disabled');
                        location.href = '#grabar_envio';
                    }
                });
            }).on('pnotify.cancel', function() {
                (jQuery)('#grabar_envio').removeAttr('disabled');
                (jQuery)('#grabar_envio').removeClass('disabled');
            });
          });
        }
    }

    function pintarNotificacion(msg) {
        var aux = JSON.parse(msg);
        var recogida = '';
        var envio = '';

        if(aux.resultado == 0){
            envio += "<span class='alert alert-danger mt-3 rounded-2 d-block'>"+aux.mensajeRetorno+"</span>";
        }else{
            if(aux.mensajeRetorno == ""){
                recogida += "<span class='alert alert-success mt-3 rounded-2 d-block'>"+aux.literalRecogida+"</span>";
                envio += "<span class='alert alert-success mt-3 rounded-2 d-block'>"+aux.literalEnvio+"</span>";
                generarEtiqueta(aux.numCollect, aux.etiqueta);
            }else{
                envio += "<span class='alert alert-danger mt-3 rounded-2 d-block'>"+aux.mensajeRetorno+"</span>";
            }
        }
        (jQuery)('#respuestaWS').html(recogida + envio);
        (jQuery)('#respuestaWS').removeClass('d-none');
    }

    function mostrarBuscador() {
        (jQuery)('body').css('overflow-y','hidden');
        (jQuery)('#buscador_ofi').removeClass('d-none');
        (jQuery)('html,body').animate({
                scrollTop: (jQuery)("#buscador_ofiContent").offset().top-200
            }, 'slow');
    }

    function cerrarModal() {
        (jQuery)('body').css('overflow-y','auto');
        (jQuery)('#buscador_ofi').addClass("d-none");
        (jQuery)('#contenedor_tab_oficinas').addClass('d-none');
    }

    function selectCodigosCliente(select){
        var elementos = '';
        var literal = "No hay códigos de cliente disponibles";

        if(select != undefined || select.length > 0 ){
            select.forEach(function(element){
                elementos +="<option value='"+element['customer_code_id']+"'>"+element['customer_code']+"</option>";
            });
        }else{
            elementos +="<option value=' '>"+literal+"</option>";
        }
        (jQuery)('#cex_select_codigos_cliente').html(elementos);
    }

    window.onclick = function(event) {
        if (event.target == document.getElementById('buscador_ofi')) {
            (jQuery)('#buscador_ofi').addClass("d-none");
            (jQuery)('#grabar_envio').removeClass('d-none');
        }

    }

    /************HISTORICO************/



function inicioHistorico() {
    var body = (jQuery)("body");
    var url=(jQuery)('#urlAjax').val();
    (jQuery).ajax({
        type: "POST",
        url: url,
        data:{
            'form_key' : (jQuery)('input:hidden[name=form_key]').val(),
            'action'   : 'retornarSavedshipsOrden',
            'id'       : (jQuery)('#idOrder').val()
        },
        showLoader: true,
        complete: function(msg) {
            pintarTablaHistorico(msg.responseText);
        }
    });
}

    function pintarTablaHistorico(msg){

        var retorno = JSON.parse(msg);
        if(retorno != '' && retorno != null){
            (jQuery)('#tabla_historico').html(retorno);
            (jQuery)('#history').removeClass('d-none');
            (jQuery)('#boton_reimprimir').removeClass('d-none');
        }else{
            (jQuery)('#history').addClass('d-none');
            (jQuery)('#boton_reimprimir').addClass('d-none');
        }
    }

    function borrarPeticionEnvio(num_ship , num_collect) {
        requirejs(['pnotify' ,'pnotify.buttons', 'pnotify.confirm'], function(PNotify){
            PNotify.prototype.options.styling = "bootstrap3";
            new PNotify({
                title: confirma_el_borradoOrden,
                text:  borrar_datos,
                icon: 'fas fa-question-circle',
                hide: false,
                stack: myStack,
                confirm: {
                    confirm: true
                },
                buttons: {
                    closer: false,
                    sticker: false
                },
            }).get().on('pnotify.confirm', function() {
                    var body = (jQuery)("body");
                    var url  =(jQuery)('#urlAjax').val();
                    (jQuery).ajax({
                        type: "POST",
                        url: url,
                        dataType: 'json',
                        data:{
                            'form_key'   : (jQuery)('input:hidden[name=form_key]').val(),
                            'action'     : 'cexFormPedidoBorrar',
                            'num_ship'   : num_ship,
                            'num_collect': num_collect
                        },
                    showLoader: true,
                    complete: function(msg) {
                        pintarMensaje(msg.responseJSON.mensaje,'Borrado','success');
                        location.reload();
                    }
                });
            }).on('pnotify.cancel', function() {
            });
        });
    }

    var myStack = {
      dir1: "down",
      dir2: "right",
      push: "top",
  };

    function pintarMensaje(msg,title,type) {
      requirejs(['pnotify' ,'pnotify.buttons', 'pnotify.confirm'], function(PNotify){
        PNotify.prototype.options.styling = "bootstrap3";
        new PNotify({
          title: title,
          text: msg,
          type: type,
          stack: myStack,
        });
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

    function mostrarCodigoAt(){
        var paisDestino = (jQuery)('#cex_select_paises :selected').text();
        var paisOrigen = (jQuery)('#cex_select_paisrte :selected').text();
        if(paisOrigen == 'Portugal' || paisDestino == 'Portugal'){
            (jQuery)('#cex_introjsAtPortugal').removeClass('d-none');
        }else{
            (jQuery)('#cex_introjsAtPortugal').addClass('d-none');
        }
    }

    function pintarSelectPosicionReimpresion(){
        var option= "";
        switch((jQuery)("#select_etiqueta_reimpresion").val()){
            case '1':
                (jQuery)("#introjsPosicionEtiquetasReimpresion").removeClass('d-none');
                option+="<option value='1'>1</option>"+
                        "<option value='2'>2</option>"+
                        "<option value='3'>3</option>";
                break;
            case '2':
                (jQuery)("#introjsPosicionEtiquetasReimpresion").removeClass('d-none');
                option+="<option value='1'>1</option>"+
                        "<option value='2'>2</option>";
                break;
            case '3':
                (jQuery)("#introjsPosicionEtiquetasReimpresion").addClass('d-none');
                option+="<option value='1'>1</option>";
                break;
        }
        (jQuery)("#posicion_etiqueta_reimpresion").html(option);
    }

    function generarEtiquetasReimpresionOrder(numCollect,event) {
        event.preventDefault();
        (jQuery)('#CEX-loading').removeClass('d-none');
        (jQuery)('#erroresReimpresion').addClass('d-none');

        var numCollect      = obtenerNumCollects(numCollect);
        if (numCollect === false){
            pintarNotificacionVacio();
            return;
        }
        var tipoEtiqueta    = (jQuery)('#select_etiqueta_reimpresion').val();
        var posicion        = (jQuery)("#posicion_etiqueta_reimpresion").val();
        var url = (jQuery)('#urlAjax').val();
        (jQuery).ajax({
            type: "POST",
            url: url,
            data: {
                'form_key'          : (jQuery)('input:hidden[name=form_key]').val(),
                'action'            : 'generarEtiquetasReimpresion',
                'numCollect'        : numCollect,
                'tipoEtiqueta'      : tipoEtiqueta,
                'posicion'          : posicion,
                'tipoReimpresion'   : 2
            },
            showLoader: true,
            success: function(msg) {
                msg = JSON.parse(msg);

                if(msg.etiquetas != false){
                    msg.etiquetas.forEach(function(etiqueta){
                        generarEtiquetaRest(etiqueta);
                    });
                }else{
                    pintarNotificacionError(errorReimpresionOrden);
                    pintarErroresReimpresion(msg.errores);
                }
            },
            error: function(msg) {
                (jQuery)('#CEX-loading').addClass('d-none');
            }
        });
    }

    function pintarNotificacionVacio(){
        (jQuery)('#CEX-loading').addClass('d-none');
        requirejs(['pnotify' ,'pnotify.buttons', 'pnotify.confirm'], function(PNotify){
            PNotify.prototype.options.styling = "bootstrap3";
            new PNotify({
                title: selectEnvioOrder,
                type: 'error',
                stack: myStack
            });
        });
    }

    function quitarRepetidos(numCollect){
        var retorno = numCollect.filter(function(item,index,array) {
            return array.indexOf(item) === index;
        });
        return retorno;
    }

    function pintarErroresReimpresion(mensajeRetorno){
        let alert = "<span class='alert alert-danger mt-3 rounded-2 d-block'>"+mensajeRetorno+"</span>";
        (jQuery)('#erroresReimpresion').html(alert);
        (jQuery)('#erroresReimpresion').removeClass('d-none');
    }

    function obtenerNumCollectsHistorico() {
        var retorno     = new Array();
        var checkboxes  = (jQuery)("#tabla_historico input.marcarEtiquetas:checked");
        for (i = 0; i < checkboxes.length; i++) {
            retorno.push(checkboxes[i].value);
        }
        return retorno;
    }

    function obtenerNumCollects(numCollect){
        var retorno;
        if(numCollect == false){
            numCollect = obtenerNumCollectsHistorico();
            if (numCollect.length == 0) {
                return false;
            }
            retorno = quitarRepetidos(numCollect);
        }else{
            retorno = [numCollect];
        }
        return retorno;
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

    function generarEtiquetaRest(etiqueta){
        var numCollect = (jQuery)('#cex_referencia_envio').val();
        var nombre = 'CEX_Order_' + numCollect   +'.pdf';
        (jQuery)("#etiqueta").attr("download", nombre);
        (jQuery)("#etiqueta").attr("href", "data:application/pdf;base64," + etiqueta);
        (jQuery)("#etiqueta")[0].click();
        location.reload();
    }
