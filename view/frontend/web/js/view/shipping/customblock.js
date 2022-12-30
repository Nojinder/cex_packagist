var customLink;
var component;
var variableGlobal;
define(
    [
    'uiComponent',
    'jquery',
    'ko',
    'mage/url'
    ],
    function(Component, $, ko, urlBuilder) {
        'use strict';
        customLink = urlBuilder.build('registrodeenviosfront/frontend/Ajax');
        component = Component.extend({
            defaults: {
                template: 'CorreosExpress_RegistroDeEnvios/shipping/customblock.phtml'
            },
            initialize: function () {
                var self = this;
                this._super();
            }
        });
        return component;
    });


(jQuery)(document).ready(init);


function init(){
    setTimeout(recursiva,2000);
}

function recursiva(){
    let elemento = document.getElementById('co-shipping-method-form');
    if(elemento==null){
        setTimeout(recursiva,1000);
    }
    else{
        mostrarBotonBuscador();
        activarDesactivarBotonFinCompra();
        elemento.addEventListener('change', function() {
            mostrarBotonBuscador();
            activarDesactivarBotonFinCompra();
        });
    }
}

function mostrarBotonBuscador(){
    var componenteChecked=retornarComponenteChecked();
    if(componenteChecked == 'cexEntregaOficina_cexEntregaOficina'){
        (jQuery)('#contenedorOficinas').removeClass('d-none');
        (jQuery)('#contenedorBoton').removeClass('d-none');
        (jQuery)('#botonBuscador').removeClass('d-none');
    }else{
        variableGlobal="";
        (jQuery)('#infoOficinas').html("");
        (jQuery)('#contenedorOficinas').addClass('d-none');
        (jQuery)('#contenedorBoton').addClass('d-none');
        (jQuery)('#botonBuscador').addClass('d-none');
    }
}

function activarDesactivarBotonFinCompra(){
    var componenteChecked=retornarComponenteChecked();
    var elemento = comprobarSelectorBotonFinCompra();
    if(componenteChecked == 'cexEntregaOficina_cexEntregaOficina'){
        if(variableGlobal=="" || typeof variableGlobal === 'undefined'){
            elemento.prop('disabled',true);
        }else{
            elemento.prop('disabled',false);
        }
    }else{
       elemento.prop('disabled',false);
    }
}

function retornarComponenteChecked(){
     var componenteChecked=(jQuery)('#checkout-shipping-method-load input[type=radio]:checked').val();
     return componenteChecked;
}

function comprobarSelectorBotonFinCompra(){
    var arraySelectoresBoton = [(jQuery)('.amasty'),
                                (jQuery)('.continue')
                          ];
    var a="";
    for(var i = 0 ; i<arraySelectoresBoton.length ; i++){
        a = arraySelectoresBoton[i].length;
        if(a > 0){
            return arraySelectoresBoton[i];
        }
    }
    return null;
}


function abrirModal(){
    (jQuery).ajax({
        type: "POST",
        url: customLink,
        dataType: 'json',
        data:{
            'action':'abrirModal',
            'form_key' : (jQuery)('input:hidden[name=form_key]').val(),
        },
        showLoader: true,
        complete: function(msg) {
            (jQuery)('#buscador_ofiCabecera').html(msg.responseText);
            (jQuery)('#card_buscador').removeClass('d-none');
            (jQuery)('#buscador_ofi').removeClass('d-none');
            (jQuery)('#buscador_ofiCabecera').removeClass('d-none');
            (jQuery)('#buscador_ofiCabecera').addClass('d-flex');
            (jQuery)('html,body').animate({
                scrollTop: (jQuery)("#CEX").offset().top-200
            }, 'slow');
            validaModal();
        },
        error: function(msg){
        }
    });
}

function cerrarModal() {
    (jQuery)('#card_buscador').addClass('d-none');
    (jQuery)('#buscador_ofi').addClass('d-none');
    (jQuery)('#buscador_ofiCabecera').addClass('d-none');
    (jQuery)('#buscador_ofiCabecera').removeClass('d-flex');
    activarDesactivarBotonFinCompra();
}

function validaModal(){
    let codigo_postal_ofi   = document.getElementById('codigo_postal_ofi');
    let poblacion_ofi       = document.getElementById('poblacion_ofi');

    codigo_postal_ofi.addEventListener('keyup', function() {
        activarBotonModal();

    });
    poblacion_ofi.addEventListener('keyup', function() {
        activarBotonModal();
    });
}

function activarBotonModal(){
    if(((jQuery)('#codigo_postal_ofi').val() === '' && (jQuery)('#poblacion_ofi').val() === '') ){
        (jQuery)('#buscar_oficina').prop('disabled', true);
        (jQuery)('#spanModalOficina').removeClass('d-none');
    }else{
        (jQuery)('#buscar_oficina').prop('disabled', false);
        (jQuery)('#spanModalOficina').addClass('d-none');
    }
}

function buscarOficina(){
    (jQuery).ajax({
        type: "POST",
        url: customLink,
        dataType: 'json',
        data:{
            'action':'procesarCurlOficinaRest',
            'cod_postal':(jQuery)('#codigo_postal_ofi').val(),
            'poblacion' :(jQuery)('#poblacion_ofi').val(),
            'form_key' : (jQuery)('input:hidden[name=form_key]').val(),
        },
        showLoader: true,
        complete: function(msg) {
            pintarOficinasModal(msg.responseText);
            (jQuery)('#tab_oficinas').removeClass("d-none");
        },
        error: function(msg){
        }
    });
}



function pintarOficinasModal(msg) {
    var oficinas = JSON.parse(msg);
    oficinas = oficinas['oficinas'];
    var tabla = '';
    tabla += '<thead><tr>';
    tabla += '<th>Cod Oficina</th>';
    tabla += '<th>CP</th>';
    tabla += '<th>Direcci&oacute;n</th>';
    tabla += '<th>Nombre</th>';
    tabla += '<th>Poblaci&oacute;n</th>';
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
        tabla += '<td><button type="button" class="CEX-btn CEX-button-blue" onclick="setCodigoOficina(' + concatenado +');">Seleccionar</button>';
        tabla += '</tr>'
    }
    tabla += '</tbody>';
    (jQuery)('#tabla_oficinas').html(tabla);
    (jQuery)('#contenedor_tab_oficinas').removeClass("d-none");
}



function setCodigoOficina(concatenado){
    variableGlobal = concatenado;
    var split = concatenado.split("#!#");
    var codigofi = split[0];

    (jQuery).ajax({
        type: "POST",
        url: customLink,
        dataType: 'json',
        data:{
            'action'                    :'guardarOficinaOrden',
            'codigo_oficina'            :codigofi,
            'texto_oficina'             :concatenado,
            'form_key'                  : (jQuery)('input:hidden[name=form_key]').val()
        },
        showLoader: true,
        complete: function(msg) {
            (jQuery)('#contenedorOficinas').html(msg.responseText);
            cerrarModal();

        },
        error: function(msg){
        }
    });
}










