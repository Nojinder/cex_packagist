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

/*
    SECCION GRABACION MASIVA
 */

var flagGrabacion       = true;
var flagErr             = true;
var flagReimpresion     = true;
var flagErrReimpresion  = true;
var flagResumen         = true;
var flagErrResumen      = true;

function changeCustomOptions(intro){
    intro.setOption('nextLabel', '<i class="fas fa-chevron-right"></i>');
    intro.setOption('prevLabel', '<i class="fas fa-chevron-left"></i>');
    intro.setOption('skipLabel', '<i class="fas fa-times"></i>');
    intro.setOption('doneLabel', '<i class="fas fa-check"></i>');
}

function introjsTourGrabacion(){
    (jQuery)("#contenedor_generar_envio").removeClass('d-none');
    (jQuery)("#contenedor_respuesta_buscador_pedidos").removeClass('d-none');
    (jQuery)("#contenedor_etiquetas_grabacion").removeClass('d-none');
    (jQuery)("#respuesta_buscador_pedidos").removeClass('d-none');
    (jQuery)("#posicion_etiqueta_masiva").removeClass('d-none');
    (jQuery)("#introjsPosicionEtiqueta").removeClass('d-none');
    (jQuery)("#contenedor_errores").removeClass('d-none');

    var tablaMasiva = getTablaMasiva();
 
    if((jQuery)('#grabacionMasiva').length==0){
        (jQuery)('#respuesta_buscador_pedidos').html(tablaMasiva);
        flagGrabacion = false;
    }
    var erroresReimpresion = getTablaErrores('erroresMasiva');

    if((jQuery)('#erroresMasiva').length==0){
        (jQuery)('#contenedor_errores').html(erroresReimpresion);
        flagErr = false;
    }
    setTimeout('introjsTourGrabacionStart();',100);
}

function introjsTourGrabacionStart(){
    requirejs(['IntroJs' ,'IntroJsUtilidades'], function(IntroJs){
      var intro = IntroJs();
      changeCustomOptions(intro);
      intro.setOptions({
          steps: [
          {
              element: document.querySelector('#introjsGrabacionMasiva'),
              intro: introjsGrabacionMasiva
          },
          {
              element: document.querySelector('#fila1'),
              intro: fila1
          },
          {
              element: document.querySelector('#fila2'),
              intro: fila2
          },
          {
              element: document.querySelector('#respuesta_buscador_pedidos'),
              intro: respuesta_buscador_pedidos
          },
          {
              element: document.querySelector('#introjsSeleccionarTodos1'),
              intro: introjsSeleccionarTodos1
          },
          {
              element: document.querySelector('#introjsTipoEtiqueta'),
              intro: introjsTipoEtiqueta
          },
          {
              element: document.querySelector('#introjsPosicionEtiqueta'),
              intro: introjsPosicionEtiqueta
          },
          {
              element: document.querySelector('#introjsGenerarGrabacionEnvio'),
              intro: introjsGenerarGrabacionEnvio
          },
          {
              element: document.querySelector('#erroresMasiva'),
              intro: introJSErroresGrabacionTable
          },
          {
              element: document.querySelector('#introJSerroresMasivaIdOrder'),
              intro: introJSErroresGrabacionIdOrder
          },
          {
              element: document.querySelector('#introJSerroresMasivaMensaje'),
              intro: introJSErroresGrabacionMensaje
          },
          {
              element: document.querySelector('#introJSerroresMasivaEnlace'),
              intro: introJSErroresGrabacionEnlace
          }]
      });
      intro.start();

    intro.oncomplete(function(){
        exitCompleteGrabacion();
    });

    // clicking 'Skip'
    intro.onexit(function(){
        exitCompleteGrabacion();
      });
    });
}

function checkGrabacionIntroJS(){
        if( (jQuery)('#toggleGrabacionIntroJS').prop('checked') ) {
            (jQuery)('#toggleGrabacionIntroJS').addClass('before');
            (jQuery)("#manualInteractivoGrabacion").disabled = false;
            (jQuery)("#manualInteractivoGrabacion").removeClass('d-none');
        }else{
            (jQuery)('#toggleGrabacionIntroJS:before').css('display','none');
            (jQuery)("#manualInteractivoGrabacion").disabled = true;
            (jQuery)("#manualInteractivoGrabacion").addClass('d-none');
        }
}

/*
    SECCION REIMPRESION DE ETIQUETAS
 */
function introjsTourReimpresion(){
    (jQuery)('#contenedor_pedidos').removeClass('d-none');
    (jQuery)("#contenedor_pedidos_reimpresion").removeClass('d-none');
    (jQuery)("#contenedor_etiquetas_reimpresion").removeClass('d-none');
    (jQuery)('#introjsPosicionEtiqueta2').removeClass('d-none');
    (jQuery)("#contenedor_errores_reimpresion").removeClass('d-none');

    var tablaReimpresion = getTablaReimpresion();

    if((jQuery)('#reimpresionMasiva').length==0){
        (jQuery)('#contenedor_pedidos_reimpresion').html(tablaReimpresion);
        flagReimpresion = false;
    }

    var tablaErroresReimpresion = getTablaErrores('erroresReimpresion');

    if((jQuery)('#erroresReimpresion').length==0){
        (jQuery)('#contenedor_errores_reimpresion').html(tablaErroresReimpresion);
        flagErrReimpresion = false;
    }

    setTimeout('introjsTourReimpresionStart();',100);
}

function introjsTourReimpresionStart(){
    requirejs(['IntroJs' ,'IntroJsUtilidades'], function(IntroJs){
      var intro = IntroJs();
      changeCustomOptions(intro);
      intro.setOptions({
          steps: [
          {
              element: document.querySelector('#introjsReimpresion'),
              intro: introjsReimpresion
          },
          {
              element: document.querySelector('#fecha_reimpresion'),
              intro: fecha_reimpresion
          },
          {
              element: document.querySelector('#contenedor_pedidos'),
              intro: contenedor_pedidos
          },
          {
              element: document.querySelector('#introjsSeleccionarTodos2'),
              intro: introjsSeleccionarTodos2
          },
          {
              element: document.querySelector('#select_tipo_etiqueta'),
              intro: select_tipo_etiqueta
          },
          {
              element: document.querySelector('#posicion_etiquetas'),
              intro: posicion_etiquetas
          },
          {
              element: document.querySelector('#grabar_etiqueta'),
              intro: grabar_etiqueta
          },
          {
              element: document.querySelector('#erroresReimpresion'),
              intro: introJSErroresGrabacionTable
          },
          {
              element: document.querySelector('#introJSerroresReimpresionIdOrder'),
              intro: introJSErroresGrabacionIdOrder
          },
          {
              element: document.querySelector('#introJSerroresReimpresionMensaje'),
              intro: introJSErroresGrabacionMensaje
          },
          {
              element: document.querySelector('#introJSerroresReimpresionEnlace'),
              intro: introJSErroresGrabacionEnlace
          }]
      });

      intro.start();

        intro.oncomplete(function(){
            exitCompleteReimpresion(); 
        });

        intro.onexit(function(){
            exitCompleteReimpresion(); 
        });
    });
}

function checkReimpresionIntroJS(){
    if( (jQuery)('#toggleReimpresionIntroJS').prop('checked') ) {
        (jQuery)('#toggleReimpresionIntroJS').addClass('before');
       (jQuery)("#manualInteractivoReimpresion").disabled = false;
       (jQuery)("#manualInteractivoReimpresion").removeClass('d-none');
    }else{
        (jQuery)('#toggleReimpresionIntroJS:before').css('display','none');
       (jQuery)("#manualInteractivoReimpresion").disabled = true;
       (jQuery)("#manualInteractivoReimpresion").addClass('d-none');
    }
}

/*
    GENERACION DE RESUMEN DE PEDIDOS
 */
function introjsTourResumen(){
    (jQuery)('#contenedor_resumen_pedidos').removeClass('d-none');
    (jQuery)("#contenedor_resumen").removeClass('d-none');
    (jQuery)("#contenedor_errores_resumen").removeClass('d-none');
    (jQuery)("#opcionesResumen").removeClass('d-none');
    (jQuery)("#boton_resumen").removeClass('d-none');

    var tablaResumen = getTablaResumen();

    if((jQuery)('#resumenPedidos').length == 0){
        (jQuery)('#contenedor_resumen_pedidos').html(tablaResumen);
        flagResumen = false;
    }

    var tablaErroresResumen = getTablaErrores('erroresResumen');

    if((jQuery)('#erroresResumen').length==0){
        (jQuery)('#contenedor_errores_resumen').html(tablaErroresResumen);
        flagErrResumen = false;
    }

    setTimeout('introjsTourResumenStart();',100);
}

function introjsTourResumenStart(){
    requirejs(['IntroJs' ,'IntroJsUtilidades'], function(IntroJs){
      var intro = IntroJs();
      changeCustomOptions(intro);
      intro.setOptions({
          steps: [
          {
              element: document.querySelector('#introjsResumen'),
              intro: introjsResumen
          },
          {
              element: document.querySelector('#fechas_resumen'),
              intro: fechas_resumen
          },
          {
              element: document.querySelector('#contenedor_resumen'),
              intro: contenedor_resumen
          },
          {
              element: document.querySelector('#boton_resumen'),
              intro: boton_resumen
          },
          {
              element: document.querySelector('#contenedor_errores_resumen'),
              intro: introJSErroresResumenTable
          },
          {
              element: document.querySelector('#introJSerroresResumenIdOrder'),
              intro: introJSErroresResumenIdOrder
          },
          {
              element: document.querySelector('#introJSerroresResumenMensaje'),
              intro: introJSErroresResumenMensaje
          },
          {
              element: document.querySelector('#introJSerroresResumenEnlace'),
              intro: introJSErroresResumenEnlace
          }]
      });

      intro.start();

      intro.oncomplete(function(){
         exitCompleteResumen()
      });

      intro.onexit(function(){
         exitCompleteResumen()
      });
    });
}

function checkResumenIntroJS(){
    if( (jQuery)('#toggleResumenIntroJS').prop('checked') ) {
        (jQuery)('#toggleResumenIntroJS').addClass('before');
       (jQuery)("#manualInteractivoResumen").disabled = false;
       (jQuery)("#manualInteractivoResumen").removeClass('d-none');
    }else{
        (jQuery)('#toggleResumenIntroJS:before').css('display','none');
       (jQuery)("#manualInteractivoResumen").disabled = true;
       (jQuery)("#manualInteractivoResumen").addClass('d-none');
    }
}

function getTablaMasiva(){
    var cabecera    =   "<table id='grabacionMasiva' style='width:100%' border=1>"+
        "<thead><tr>"+
        "<th>"+idTablaGrab+"</th>"+
        "<th>"+refEnvioTablaGrab+"</th>"+
        "<th>"+estadoTablaGrab+"</th>"+
        "<th>"+clienteTablaGrab+"</th>"+
        "<th>"+fechaTablaGrab+"</th>"+
        "<th>"+numEnvioTablaGrab+"</th>"+
        "<th>"+codOficinaTablaGrab+"</th>"+
        "<th>"+bultosTablaGrab+"</th>"+
        "</tr></thead>";
    var cierre      =   "</table>";
    var elementos   =   '';
    return cabecera + elementos + cierre;
}

function getTablaReimpresion(){
    var cabecera =  "<table id='reimpresionMasiva' style='width:100%' border=1>"+
        "<thead><tr>"+
        "<th>"+idTabla+"</th>"+
        "<th>"+refEnvioTabla+"</th>"+
        "<th>"+codEnvioTabla+"</th>"+
        "<th>"+nomDestinatarioTabla+"</th>"+
        "<th>"+dirDestinatarioTabla+"</th>"+
        "<th>"+fechaCreacionTabla+"</th>"+
        "</tr></thead>";
    var cierre = "</table>";
    var elementos = '';
    return cabecera + elementos + cierre;
}

function getTablaResumen(){
    var cabecera = "<table id='resumenPedidos' style='width:100%' border=1>" +
            "<thead><tr>" +
            "<th>"+idTabla +"</th>" +
            "<th>"+refEnvioTabla+"</th>" +
            "<th>"+codEnvioTabla +"</th>" +
            "<th>"+nomDestinatarioTabla +"</th>" +
            "<th>"+dirDestinatarioTabla  +"</th>" +
            "<th>"+fechaCreacionTabla  +"</th>" +
            "</tr></thead>";
    var cierre = "</table>";
    var elementos = '';
    return cabecera + elementos + cierre;
}

function getTablaErrores(nombreTabla){
    var cabecera    =   "<h4>"+erroresReimpresionCabecera+"</h4>";
    cabecera        +=  "<table id='"+nombreTabla+"' class='table w-100'>" +
        "<thead><tr>" +
        "<th>"+erroresReimpresionIdOrder+"</th>" +
        "<th>"+erroresReimpresionMensaje+"</th>" +
        "<th>"+erroresReimpresionEnlace+"</th>" +
        "</tr></thead>";
    var finTabla    =   "</table>";
    var contenido   =   "<tr><td id='introJS"+nombreTabla+"IdOrder'>000</td>" +
        "<td id='introJS"+nombreTabla+"Mensaje'>Descripcion del Error</td>" +
        "<td id='introJS"+nombreTabla+"Enlace'>"+literalEnlaceError+"</td></tr>"+
        "<tr><td>00</td>" +
        "<td>El envío 000000000000000 no existe para el cliente 000000000</td>" +
        "<td>IR AL PEDIDO 00</td></tr>";

    return cabecera + contenido + finTabla;
}

function exitCompleteGrabacion(){
    if(flagGrabacion == false){
        (jQuery)("#contenedor_generar_envio").addClass('d-none');
        (jQuery)("#contenedor_etiquetas_grabacion").addClass('d-none');
        (jQuery)("#respuesta_buscador_pedidos").addClass('d-none');
        (jQuery)("#contenedor_respuesta_buscador_pedidos").addClass('d-none');
        (jQuery)("#respuesta_buscador_pedidos").html('');
        flagGrabacion = true;
    }

    if(flagErr == false){
        (jQuery)('#contenedor_errores').addClass('d-none');
        (jQuery)('#contenedor_errores').html('');
        flagErr = true;
    }

    if((jQuery)("#select_tipo_etiqueta2").val() == '3'){
        (jQuery)("#introjsPosicionEtiqueta").addClass('d-none');
    }
}

function exitCompleteReimpresion(){
    if(flagReimpresion == false){
        (jQuery)('#contenedor_pedidos').addClass('d-none');
        (jQuery)('#contenedor_pedidos_reimpresion').addClass('d-none');
        (jQuery)('#contenedor_pedidos_reimpresion').html('');
        (jQuery)("#contenedor_etiquetas_reimpresion").addClass('d-none');
        flagReimpresion = true;
    }

    if(flagErrReimpresion == false){
        (jQuery)('#contenedor_errores_reimpresion').addClass('d-none');
        (jQuery)('#contenedor_errores_reimpresion').html('');
        flagErrReimpresion = true;
    }

    if((jQuery)("#select_tipo_etiqueta").val() == '3'){
        (jQuery)("#introjsPosicionEtiqueta2").addClass('d-none');
    }
}

function exitCompleteResumen(){
    if(flagResumen == false){
        (jQuery)('#contenedor_resumen').addClass('d-none');
        (jQuery)('#contenedor_resumen_pedidos').addClass('d-none');
        (jQuery)('#contenedor_resumen_pedidos').html('');
        (jQuery)("#marcarResumen").removeClass('d-none');
        flagResumen = true;
    }

    if(flagErrResumen == false){
        (jQuery)('#contenedor_errores_resumen').addClass('d-none');
        (jQuery)('#contenedor_errores_resumen').html('');
        flagErrResumen = true;
    }
}

