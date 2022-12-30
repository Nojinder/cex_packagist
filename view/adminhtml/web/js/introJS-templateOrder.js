/**
 * NOTICE OF LICENSE
 *
 * This file is licenced under the Software License Agreement.
 * With the purchase or the installation of the software in your application
 * you accept the licence agreement.
 *
 * You must not modify, adapt or create derivative works of this source code
 *
 *  @author    CorreosExpress/Departamento de integracion y desarrollo
 *  @copyright 2015-2018 Correos Express - Grupo Correos
 *  @license   LICENSE.txt
 *  @email peticiones@correosexpress.com
 */
var section1 = '<div id="CEX">' +
    '<div id="history" className="row mt-3 mx-1 d-none">' +
        '<div className="entry-edit">' +
            '<div className="entry-edit-head">' +
                '<h4 className="icon-head head-products">' +
                    '<?php echo __("Histórico de envios");?></h4>' +
            '</div>' +
        '</div>' +
    '<div className="col-12 col-md-12 col-lg-12 p-0 rounded CEX-overflow-y-hidden">';

var tabla = '<table id="tabla_historico" border="1" class="table w-100">'+
    '<thead>' +
        '<tr>' +
        '<th>Seguimiento</th>' +
        '<th>Fecha</th>' +
        '<th>Ref.Pedido</th>' +
        '<th>Tipo</th>' +
        '<th>Identificador</th>' +
        '<th>Recogida desde</th>' +
        '<th>Fecha de Recogida</th>' +
        '<th>Hora Recogida desde</th>' +
        '<th>Hora Recogida hasta</th>' +
        '<th>Estado</th>' +
        '<th>Acciones</th>' +
        '</tr>' +
    '</thead>' +
    '<tbody>' +
        '<tr>' +
            '<td><span id="introjsCheckEnvios"><input type="checkbox" id="" value="" class="marcarPedidos form-control my-auto"></span><a href="#">CorreosExpress</a></td>' +
            '<td>aaaa-mm-dd</td>' +
            '<td>0</td>' +
            '<td>Envio</td>' +
            '<td><div id="introjsIdentificador">0000000000000000</div></td>' +
            '<td>Sede Recogida</td>' +
            '<td></td>' +
            '<td></td>' +
            '<td></td>' +
            '<td>Grabado</td>' +
            '<td>' +
            '<span id="introjsIconoReimprimir"><a href="#" class="ml-3"><i class="fa fa-print"></i></a></span>' +
            '<span id="introjsIconoBorrarEnvio" class="ml-3"><a href="#"><i class="fa fa-trash"></i></a></span>' +
            '</td>' +
        '</tr>' +
    '</tbody>' +
    '<tfoot>' +
        '<tr>' +
            '<th>Seguimiento</th>' +
            '<th>Fecha</th>' +
            '<th>Ref.Pedido</th>' +
            '<th>Tipo</th>' +
            '<th>Identificador</th>' +
            '<th>Recogida desde</th>' +
            '<th>Fecha de Recogida</th>' +
            '<th>Hora Recogida desde</th>' +
            '<th>Hora Recogida hasta</th>' +
            '<th>Estado</th>' +
            '<th>Acciones</th>' +
        '</tr>' +
    '</tfoot>' +
    '</table>';

var selectEtiquetas =
    '<div id="introjsCaracteristicasEtiquetasReimpresion" class="col-12">' +
        '<div class="row">' +
            '<div id="introjsTipoEtiquetasReimpresion" class="form-group col-6 col-xs-6">' +
                '<label for="select_etiqueta_reimpresion">Tipo de etiquetass</label>' +
                    '<select class="form-control" id="select_etiqueta_reimpresion">' +
                        '<option disabled>Seleccione el tipo de Etiqueta</option>' +
                        '<option value="1">Adhesiva</option>' +
                        '<option value="2">Medio folio</option>' +
                        '<option value="3">Térmica</option>' +
                    '</select>' +
            '</div>' +
            '<div id="introjsPosicionEtiquetasReimpresion" class="form-group col-6 col-xs-6">' +
                '<label for="posicion_etiqueta_reimpresion">Posición de etiqueta</label>' +
                    '<select class="form-control" id="posicion_etiqueta_reimpresion">' +
                        '<option disabled>Seleccione la posición de la Etiqueta</option>' +
                    '</select>' +
            '</div>' +
        '</div>' +
    '</div>';
var botonReimprimir =
    '<div id="introjsBotonReimprimir" class="col-12 col-xs-12">' +
        '<button id="boton_reimprimir" class="CEX-btn CEX-button-yellow mx-auto my-3" name="boton_reimprimir">' +
            'Reimprimir' +
        '</button>' +
    '</div>';
var section2        = '</div></div>';

var section         = section1+tabla+selectEtiquetas+botonReimprimir+section2;

function changeCustomOptions(intro){
    intro.setOption('nextLabel', '<i class="fas fa-chevron-right"></i>');
    intro.setOption('prevLabel', '<i class="fas fa-chevron-left"></i>');
    intro.setOption('skipLabel', '<i class="fas fa-times"></i>');
    intro.setOption('doneLabel', '<i class="fas fa-check"></i>');
}

function introjsOrder(){
    if((jQuery)('#tabla_historico').find("#tablaHijo").length == 0){
        (jQuery)("#history").removeClass('d-none');
        //(jQuery)('#tabla_historico').html(section);
        (jQuery)('#mostrarForm').append(section);

    }

    if ((jQuery)("#cex_select_etiqueta").val()=='3') {
        (jQuery)("#introjsPosicionEtiquetas").removeClass('d-none');
    }

    if ((jQuery)("#select_etiqueta_reimpresion").val()=='3') {
        (jQuery)("#introjsPosicionEtiquetasReimpresion").removeClass('d-none');
    }

    //(jQuery)("#introjsPosicionEtiquetas").removeClass('d-none');
    //(jQuery)("#introjsPosicionEtiquetasReimpresion").removeClass('d-none');
    //(jQuery)("#boton_reimprimir").removeClass('d-none');

    setTimeout('introTemplateOrder();',100);
}


function introTemplateOrder(){
    requirejs(['IntroJs' ,'IntroJsTemplateOrder'], function(IntroJs){

        var codAt = (jQuery)("#introjsAtPortugal").hasClass('d-none');

        if(codAt){
            (jQuery)("#introjsAtPortugal").removeClass('d-none');
        }

        var intro = IntroJs();
        changeCustomOptions(intro);
        intro.setOptions({
            steps: [
            {
                element: document.querySelector('#introjsFormRemitente'),
                intro: introjsFormRemitente
            },
            {
                element: document.querySelector('#introjsCopiarRemitente'),
                intro: introjsCopiarRemitente
            },
            {
                element: document.querySelector('#introjsRemitente'),
                intro: introjsRemitente
            },
            {
                element: document.querySelector('#introjsValoresRemitente'),
                intro: introjsValoresRemitente
            },
            {
                element: document.querySelector('#introjsObservacionesRemitente'),
                intro: introjsObservacionesRemitente
            },
            {
                element: document.querySelector('#introjsFormDestinatario'),
                intro: introjsFormDestinatario
            },
            {
                element: document.querySelector('#introjsDevolucion'),
                intro: introjsDevolucion
            },
            {
                element: document.querySelector('#introjsValoresDestinatario'),
                intro: introjsValoresDestinatario
            },
            {
                element: document.querySelector('#introjsPaisDestino'),
                intro: introjsPaisDestino
            },
            {
                element: document.querySelector('#introjsObservacionesEntrega'),
                intro: introjsObservacionesEntrega
            },
            {
                element: document.querySelector('#introjsFormExtra'),
                intro: introjsFormExtra
            },
            {
                element: document.querySelector('#introjsCodCliente'),
                intro: introjsCodCliente
            },
            {
                element: document.querySelector('#introjsRefEnvio'),
                intro: introjsRefEnvio
            },
            {
                element: document.querySelector('#introjsAtPortugal'),
                intro: introjsAtPortugal
            },
            {
                element: document.querySelector('#introjsFechaEntrega'),
                intro: introjsFechaEntrega
            },
            {
                element: document.querySelector('#introjsHHMM'),
                intro: introjsHHMM
            },
            {
                element: document.querySelector('#introjsBultosKilos'),
                intro: introjsBultosKilos
            },
            {
                element: document.querySelector('#introjsContrareembolso'),
                intro: introjsContrareembolso
            },
            {
                element: document.querySelector('#introjsValorContrareembolso'),
                intro: introjsValorContrareembolso
            },
            {
                element: document.querySelector('#introjsValorAsegurado'),
                intro: introjsValorAsegurado
            },
            {
                element: document.querySelector('#introjsModalidadEnvio'),
                intro: introjsModalidadEnvio
            },
            {
                element: document.querySelector('#introjsTipoEtiquetas'),
                intro: introjsTipoEtiquetas
            },
            {
                element: document.querySelector('#introjsPosicionEtiquetas'),
                intro: introjsPosicionEtiquetas
            },
            {
                element: document.querySelector('#cex_grabar_recogida'),
                intro: cex_grabar_recogida
            },
            {
                element: document.querySelector('#grabar_envio'),
                intro: grabar_envio
            },
            {
                element: document.querySelector('#tabla_historico'),
                intro: tabla_historico
            },
            {
                element: document.querySelector('#introjsCheckEnvios'),
                intro: introjsCheckEnvios
            },
            {
                element: document.querySelector('#introjsIdentificador'),
                intro: introjsIdentificador
            },
            {
                element: document.querySelector('#introjsIconoReimprimir'),
                intro: introjsIconoReimprimir
            },
            {
                element: document.querySelector('#introjsIconoBorrarEnvio'),
                intro: introjsIconoBorrarEnvio
            },
            {
                element: document.querySelector('#introjsCaracteristicasEtiquetasReimpresion'),
                intro: introjsCaracteristicasEtiquetasReimpresion
            },
            {
                element: document.querySelector('#introjsTipoEtiquetasReimpresion'),
                intro: introjsTipoEtiquetasReimpresion
            },
            {
                element: document.querySelector('#introjsPosicionEtiquetasReimpresion'),
                intro: introjsPosicionEtiquetasReimpresion
            },
            {
                element: document.querySelector('#introjsBotonReimprimir'),
                intro: introjsBotonReimprimir
            }
            ]
        });
        intro.start();
        intro.oncomplete(function(){
            exitCompleteOrder();
        });

        // clicking 'Skip'
        intro.onexit(function(){
            exitCompleteOrder();
        });
    });
}

function checkIntroJS(){
    if( (jQuery)('#toggleIntroJS').prop('checked') ) {
        (jQuery)('#toggleIntroJS').addClass('before');
        (jQuery)("#manualInteractivoOrder").disabled = false;
        (jQuery)("#manualInteractivoOrder").removeClass('d-none');
    }else{
        (jQuery)('#toggleIntroJS').css('display','none');
        (jQuery)("#manualInteractivoOrder").disabled = true;
        (jQuery)("#manualInteractivoOrder").addClass('d-none');

    }
}

function exitCompleteOrder(){
    if ((jQuery)("#select_etiqueta_reimpresion").val()=='3') {
        (jQuery)("#introjsPosicionEtiquetasReimpresion").addClass('d-none');
    }

    if((jQuery)('#tabla_historico').find("#tablaHijo").length == 0) {
        (jQuery)('#history').remove();
    }

    if ((jQuery)("#cex_select_etiqueta").val()=='3') {
        (jQuery)("#introjsPosicionEtiquetas").addClass('d-none');
    }

    if((jQuery)('#cex_select_paises').val() != "PT" && (jQuery)('#cex_select_paisrte').val() != "PT"){
        (jQuery)('#introjsAtPortugal').addClass("d-none");
    }
}
