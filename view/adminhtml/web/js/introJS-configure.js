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

function changeCustomOptions(intro){
    intro.setOption('nextLabel', '<i class="fas fa-chevron-right"></i>');
    intro.setOption('prevLabel', '<i class="fas fa-chevron-left"></i>');
    intro.setOption('skipLabel', '<i class="fas fa-times"></i>');
    intro.setOption('doneLabel', '<i class="fas fa-check"></i>');
}


function introConfiguracionTPL(){
    setTimeout('checkIntroConfiguracionTPL();',100);
}

function checkIntroConfiguracionTPL(){
	if((jQuery)('#panel_codigo_cliente').attr('style') !== 'display: none;'){
        (jQuery)("#step2").click();
    }
    if((jQuery)('#panel_remitentes').attr('style') !== 'display: none;'){
        (jQuery)("#step3").click();
    }
    if((jQuery)('#panel_usuario').attr('style') !== 'display: none;'){
        (jQuery)("#step4").click();
    }
    if((jQuery)('#panel_metodos_cron').attr('style') !== 'display: none;'){
        (jQuery)("#step5").click();
    }
    if((jQuery)('#panel_productos_cex').attr('style') !== 'display: none;'){
        (jQuery)("#step6").click();
    }
    if((jQuery)('#panel_relacion_trans').attr('style') !== 'display: none;'){
        (jQuery)("#step7").click();
    }
    if((jQuery)('#panel_soporte').attr('style') !== 'display: none;'){
        (jQuery)("#step8").click();
    }

      requirejs(['IntroJs' ,'IntroJsConfigure'], function(IntroJs){
        var intro = IntroJs();
        var checkLog = (jQuery)('#MXPS_CHECK_LOG').prop('checked');
        (jQuery)("#acordeonSoporte").removeClass('d-none');
        changeCustomOptions(intro);
        intro.setOptions({
            steps: [
            {
                element: document.querySelector('#step1'),
                intro: step1
            },
            {
                element: document.querySelector('#step2'),
                intro: step2
            },
            {
                element: document.querySelector('#step3'),
                intro: step3
            },
            {
                element: document.querySelector('#step4'),
                intro: step4
            },
            {
                element: document.querySelector('#step5'),
                intro: step5
            },
            {
                element: document.querySelector('#step6'),
                intro: step6
            },
            {
                element: document.querySelector('#step7'),
                intro: step7
            },
            {
                element: document.querySelector('#step8'),
                intro: step8
            }]
        });
        intro.start();
        intro.onexit(function(){
            if(!checkLog){
                (jQuery)("#acordeonSoporte").addClass('d-none');
            }
        });
    });
    //(jQuery)('.introjs-skipbutton').hide();
}

function checkIntroConfiguracionUsuario(){
    setTimeout('introConfiguracionUsuario();',100);
}

function introConfiguracionUsuario(){
    comportamientoToggle((jQuery)('#panel_usuario'));
    requirejs(['IntroJs' ,'IntroJsConfigure'], function(IntroJs){
        var intro = IntroJs();
        changeCustomOptions(intro);
        intro.setOptions({
            steps: [
            {
                element: document.querySelector('#stepUser0'),
                intro: stepUser3
            },
            {
                element: document.querySelector('#stepUser6'),
                intro: stepUser6
            },
            {
                element: document.querySelector('#stepUser8'),
                intro: stepUser8
            },
            {
                element: document.querySelector('#refEtiquetas'),
                intro: refEtiquetas
            },
            {
                element: document.querySelector('#stepUser7'),
                intro: stepUser7
            },
            {
                element: document.querySelector('#stepUser9'),
                intro: stepUser9
            },
            {
                element: document.querySelector('#stepUserLog'),
                intro: stepUserLog
            },
            {
                element: document.querySelector('#stepUser10'),
                intro: stepUser10
            },
            {
                element: document.querySelector('#obserEtiqueta'),
                intro: obserEtiqueta
            },
            {
                element: document.querySelector('#trackNumber'),
                intro: trackNumber
            },
            {
                element: document.querySelector('#stepUser11'),
                intro: stepUser11
            },
            {
                element: document.querySelector('#stepUser12'),
                intro: stepUser12
            },
            {
                element: document.querySelector('#stepUser14'),
                intro: stepUser14
            },
            {
                element: document.querySelector('#stepUser13'),
                intro: stepUser13
            },
            {
                element: document.querySelector('#guardarDatosCliente'),
                intro: guardarDatosCliente
            }]
        });
        intro.start();
    });
}

function checkIntroCodigoCliente(){
    setTimeout('introCodigoCliente();',100);
}

function introCodigoCliente(){
    var panel=(jQuery)('#panel_codigo_cliente');
    comportamientoToggle(panel);
    (jQuery)('#saved_codes').removeClass('d-none');

    requirejs(['IntroJs' ,'IntroJsConfigure'], function(IntroJs){
        var intro = IntroJs();
        changeCustomOptions(intro);
        intro.setOptions({
            steps: [
            {
                element: document.querySelector('#customer_code'),
                intro: customer_code
            },
            {
                element: document.querySelector('#guardar_cod_cliente'),
                intro: guardar_cod_cliente
            },
            {
                element: document.querySelector('#saved_codes'),
                intro: saved_codes
            }]
        });

        intro.start();
    });
}

function checkIntroRemitente(){
    setTimeout('introRemitente();',100);
}

function introRemitente(){
    var panel=(jQuery)('#panel_remitentes');
    comportamientoToggle(panel);

    requirejs(['IntroJs' ,'IntroJsConfigure'], function(IntroJs){
        var intro = IntroJs();
        changeCustomOptions(intro);
        intro.setOptions({
            steps: [
            {
                element: document.querySelector('#div_codigo_cliente'),
                intro: div_codigo_cliente
            },
            {
                element: document.querySelector('#datosRemitente'),
                intro: datosRemitente
            },
            {
                element: document.querySelector('#bloqueHoraDesdeHasta'),
                intro: bloqueHoraDesdeHasta
            },
            {
                element: document.querySelector('#guardarRemitente'),
                intro: guardarRemitente
            },
            {
                element: document.querySelector('#cancelar'),
                intro: cancelar
            },
            {
                element: document.querySelector('#tableSavedSenders'),
                intro: tableSavedSenders
            },
            {
                element: document.querySelector('#MXPS_DEFAULTSEND'),
                intro: MXPS_DEFAULTSEND
            },
            {
                element: document.querySelector('#literalGuardarRemitenteDefecto'),
                intro: literalGuardarRemitenteDefecto
            }
            ]
        });
        intro.start();
    });
}

function checkIntroProductosCEX(){
    var panel=(jQuery)('#panel_productos_cex');

    panel.css({'display':'block','visibility':'hidden'});
    var alturaHeight=panel.height();
    panel.css({'display':'','visibility':''});
    comportamientoToggle(panel);
    setTimeout('introProductosCEX();',100);
    (jQuery)('.introjs-helperLayer').css('height',alturaHeight+'px');
    (jQuery)('.introjs-tooltipReferenceLayer').height(alturaHeight);
}

function introProductosCEX(){

    requirejs(['IntroJs' ,'IntroJsConfigure'], function(IntroJs){
        var intro = IntroJs();
        changeCustomOptions(intro);
        intro.setOptions({
            steps: [
            {
                element: document.querySelector('#panel_productos_cex'),
                intro: panel_productos_cex
            },
            {
                element: document.querySelector('#guardarProductosCex'),
                intro: literalGuardarProductosCex
            }]
        });
        intro.start();
    });
}

function checkIntroZonasTransportistas(){
    setTimeout('introZonasTransportistas();',100);
}

function introZonasTransportistas(){
    var panel=(jQuery)('#panel_relacion_trans');
    comportamientoToggle(panel);

    requirejs(['IntroJs' ,'IntroJsConfigure'], function(IntroJs){
        var intro = IntroJs();
        changeCustomOptions(intro);
        intro.setOptions({
            steps: [
            {
                element: document.querySelector('#panel_relacion_trans'),
                intro: panel_relacion_trans
            },
            {
                element: document.querySelector('#nombreCarriers'),
                intro: nombreCarriers
            },
            {
                element: document.querySelector("select[id*='nombreProductos']"),
                intro: nombreProductos
            },
            {
                element: document.querySelector('#nombreCarriersProductos'),
                intro: nombreCarriersProductos
            },
            {
                element: document.querySelector('#guardarTransportistas'),
                intro: guardarTransportistas
            }]
        });
        intro.start();
    });
}

function checkIntroOpcionesCron(){
    setTimeout('introOpcionesCron();',100);
}

function introOpcionesCron(){
    var panel=(jQuery)('#panel_metodos_cron');
    comportamientoToggle(panel);
    (jQuery)('#MXPS_SAVEDSTATUS').click();

    var checkLog = (jQuery)('#MXPS_CHECK_LOG').prop('checked');
    (jQuery)("#botonesLogCron").removeClass('d-none');

    requirejs(['IntroJs' ,'IntroJsConfigure'], function(IntroJs){
        var intro = IntroJs();
        changeCustomOptions(intro);
        intro.setOptions({
            steps: [
            {
                element: document.querySelector('#panel_metodos_cron'),
                intro: introPanelCron
            },
            {
                element: document.querySelector('#datosCron'),
                intro: datosCron
            },
            {
                element: document.querySelector('#MXPS_SAVEDSTATUS_SPAN'),
                intro: MXPS_SAVEDSTATUS
            },
            {
                element: document.querySelector('#MXPS_TRACKINGCEX_SPAN'),
                intro: MXPS_TRACKINGCEX
            },
            {
                element: document.querySelector('#MXPS_CHANGESTATUS_SPAN'),
                intro: MXPS_CHANGESTATUS_SPAN
            },
            {
                element: document.querySelector('#generarArchivoCronLog'),
                intro: generarArchivoCronLog
            },
            {
                element: document.querySelector('#generarArchivoPeticionCron'),
                intro: generarArchivoPeticionCron
            },
            {
                element: document.querySelector('#generarArchivoRespuestaCron'),
                intro: generarArchivoRespuestaCron
            },
            {
                element: document.querySelector('#guardarDatosCron'),
                intro: literalGuardarDatosCron
            }
            ]
        });
        intro.start();
        intro.onexit(function(){
            if(!checkLog){
                (jQuery)("#botonesLogCron").addClass('d-none');
            }
        });
    });
    (jQuery)('#MXPS_SAVEDSTATUS').click();
}

function checkIntroJS(){
    if( (jQuery)('#toggleIntroJS').prop('checked') ) {
        document.getElementById("manualInteractivo").disabled = false;
        (jQuery)('#manualInteractivo').removeClass('disabled');
        (jQuery)('#manualInteractivo').removeClass('d-none');
        document.getElementById("iconCodigoCliente").style.pointerEvents = "auto";
        document.getElementById("iconCodigoCliente").style.display = 'inline';
        document.getElementById("iconRemitente").style.pointerEvents = "auto";
        document.getElementById("iconRemitente").style.display = 'inline';
        document.getElementById("iconConfiguracionUsuario").style.pointerEvents = "auto";
        document.getElementById("iconConfiguracionUsuario").style.display = 'inline';
        document.getElementById("iconCron").style.pointerEvents = "auto";
        document.getElementById("iconCron").style.display = 'inline';
        document.getElementById("iconProductos").style.pointerEvents = "auto";
        document.getElementById("iconProductos").style.display = 'inline';
        document.getElementById("iconRelacionTransportistas").style.pointerEvents = "auto";
        document.getElementById("iconRelacionTransportistas").style.display = 'inline';
        document.getElementById("iconSoporte").style.pointerEvents = "auto";
        document.getElementById("iconSoporte").style.display = 'inline';
    }else{
        document.getElementById("manualInteractivo").disabled = true;
        (jQuery)('#manualInteractivo').addClass('disabled');
        (jQuery)('#manualInteractivo').addClass('d-none');
        document.getElementById("iconCodigoCliente").style.pointerEvents = "none";
        document.getElementById("iconCodigoCliente").style.display = "none";
        document.getElementById("iconRemitente").style.pointerEvents = "none";
        document.getElementById("iconRemitente").style.display = "none";
        document.getElementById("iconConfiguracionUsuario").style.pointerEvents = "none";
        document.getElementById("iconConfiguracionUsuario").style.display = "none";
        document.getElementById("iconCron").style.pointerEvents = "none";
        document.getElementById("iconCron").style.display = "none";
        document.getElementById("iconProductos").style.pointerEvents = "none";
        document.getElementById("iconProductos").style.display = "none";
        document.getElementById("iconRelacionTransportistas").style.pointerEvents = "none";
        document.getElementById("iconRelacionTransportistas").style.display = "none";
        document.getElementById("iconSoporte").style.pointerEvents = "none";
        document.getElementById("iconSoporte").style.display = "none";
    }
}

function checkEdicionRemitenteJS(){
    if( (jQuery)('#toggleRemitenteJS').prop('checked') ) {
        document.getElementById("manualRemitente").disabled = false;
        (jQuery)('#manualRemitente').removeClass('disabled');
    }else{
        document.getElementById("manualRemitente").disabled = true;
        (jQuery)('#manualRemitente').addClass('disabled');
    }
}
function buttonIntroEdicionRemitente(){
    setTimeout('introEdicionRemitente();',100);
}

function introEdicionRemitente(){
    requirejs(['IntroJs' ,'IntroJsConfigure'], function(IntroJs){
        var intro = IntroJs();
        changeCustomOptions(intro);
        intro.setOptions({
            steps: [
            {
                element: document.querySelector('#remitente_codigo_cliente_modal'),
                intro: remitente_codigo_cliente_modal
            },
            {
                element: document.querySelector('#EdicionHoraDesde'),
                intro: EdicionHoraDesde
            },
            {
                element: document.querySelector('#EdicionHoraHasta'),
                intro: EdicionHoraHasta
            },
            {
                element: document.querySelector('#EdicionHoras'),
                intro: EdicionHoras
            },
            {
                element: document.querySelector('#guardar_modal_remitente'),
                intro: guardar_modal_remitente
            },
            {
                element: document.querySelector('#cerrar_modal_remitente'),
                intro: cerrar_modal_remitente
            }
            ]
        });
        intro.start();
    });
}

function checkEdicionCodigoClienteJS(){
    if( (jQuery)('#toggleCodigoClienteJS').prop('checked') ) {
        document.getElementById("manualCodigoCliente").disabled = false;
        (jQuery)('#manualCodigoCliente').removeClass('disabled');
    }else{
        document.getElementById("manualCodigoCliente").disabled = true;
        (jQuery)('#manualCodigoCliente').addClass('disabled');
    }
}
function buttonIntroEdicionCodigoCliente(){
    setTimeout('introEdicionCodigoCliente();',100);
}

function introEdicionCodigoCliente(){
    requirejs(['IntroJs' ,'IntroJsConfigure'], function(IntroJs){
        var intro = IntroJs();
        changeCustomOptions(intro);
        intro.setOptions({
            steps: [
            {
                element: document.querySelector('#codigo_cliente_modal'),
                intro: customer_code_modal
            },
            {
                element: document.querySelector('#guardar_modal_codigo'),
                intro: guardar_cod_cliente_modal
            },
            {
                element: document.querySelector('#cerrar_modal_codigo'),
                intro: cerrar_cod_cliente_modal
            }]
        });

        intro.start();
    });
}

function checkIntroSoporte(){
    setTimeout('introSoporte();',100);
}

function introSoporte(){
    var panel=(jQuery)('#panel_soporte');
    comportamientoToggle(panel);

    requirejs(['IntroJs' ,'IntroJsConfigure'], function(IntroJs){
        var intro = IntroJs();
        changeCustomOptions(intro);
        intro.setOptions({
            steps: [
            {
                element: document.querySelector('#panel_soporte'),
                intro: panel_soporte
            },
            {
                element: document.querySelector('#buttonHistorico'),
                intro: buttonHistorico
            }]
        });
        intro.start();
    });
}

function comportamientoToggle(panel){
    requirejs(['IntroJs' ,'IntroJsConfigure'], function(IntroJs){

        if(!(jQuery)(panel).hasClass('show')){
            var icono = (jQuery)(panel).parent().find('span#Cex-arrow i.fas');
            (jQuery)(panel).addClass('show');
            (jQuery)(icono).toggleClass('fas fa-chevron-up fas fa-chevron-down');
        }
    });

}

