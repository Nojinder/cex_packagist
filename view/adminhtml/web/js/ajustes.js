(jQuery)(document).ready(function($) {
  inicializarForms();
  validarRemitente();
  (jQuery)("body").css('overflow-y','scroll');
});

///////////////////////////////////////////////////////////////////
////////////////////////////INICIALIZAR////////////////////////////
///////////////////////////////////////////////////////////////////

function inicializarForms() {
  var url=(jQuery)('#urlAjax').val();
  (jQuery).ajax({
    type: "POST",
    url:url,
    data:{
      'form_key' : (jQuery)('input:hidden[name=form_key]').val(),
      action:'getInitForm',
    },
    showLoader: true,
    complete: function (msg) {
      pintarRespuestaAjax(msg.responseText);
      inicializarDatosUsuario();
    },
    error: function (msg) {
      pintarRespuestaAjax(msg.responseText);
    }
  });
}

function inicializarDatosUsuario() {
  var url=(jQuery)('#urlAjax').val();
  (jQuery).ajax({
    type: "POST",
    url: url,
    data:{
      'form_key' : (jQuery)('input:hidden[name=form_key]').val(),
      action:'getUserConfig',
    },
    showLoader: true,
    complete: function (msg) {
      pintarEstadosFormularioUser(msg.responseText);
    },
    error: function (msg) {
      pintarEstadosFormularioUser(msg.responseText);
    }
  });
}

///////////////////////////////////////////////////////////////////
////////////////////////CODIGO CLIENTE/////////////////////////////
///////////////////////////////////////////////////////////////////

function validarCodigo() {
  if (jQuery("#customer_code").val().length == 9) {
    return true;
  }
  var mensaje = new Array();
  mensaje["title"] = "Error de Código de Cliente";
  mensaje["mensaje"] =
    "El número de dígitos no corresponden con ningún Código Cliente";
  mensaje["type"] = "error";
  pintarNotificacion(mensaje);
  return false;
}

function guardarCodigoCliente() {
  if (document.getElementById("customer_code").checkValidity()) {
    if (validarCodigo()) {
      var url=(jQuery)('#urlAjax').val();
      (jQuery).ajax({
        type: "POST",
        url: url,
        data: {
          'form_key' : (jQuery)('input:hidden[name=form_key]').val(),
          action:'guardarCodigoCliente',
          customer_code: (jQuery)("#customer_code").val(),
        },
        showLoader: true,
        complete: function (msg) {
          pintarRespuestaAjax(msg.responseText);
        },
        error: function (msg) {
          pintarRespuestaAjax(msg.responseText);
        }
      });
      (jQuery)("#customer_code").val("");
      (jQuery)("#code_demand").val("");
    }
  }else{
    requirejs(['pnotify' ,'pnotify.buttons', 'pnotify.confirm'], function(PNotify){
      PNotify.prototype.options.styling = "bootstrap3";
        new PNotify({
        title: titleErrorActualizarCliente,
        text:  textErrorActualizarCliente,
        type:  "error",
        stack: myStack,
      });
    });
  }
}

function animacionBoton(panel) {
    var icono = jQuery(panel).parent().find("span#Cex-arrow i.fas");
    jQuery(icono).toggleClass("fas fa-chevron-up fas fa-chevron-down");
    jQuery(panel).toggleClass("show");
    jQuery(panel).removeClass("in");

  }

function borrarCodigoCliente(customerCodeId) {
  var url=(jQuery)('#urlAjax').val();
  var customerCodeId = customerCodeId;
  requirejs(["pnotify", "pnotify.buttons", "pnotify.confirm"], function (
    PNotify
  ) {
    PNotify.prototype.options.styling = "bootstrap3";
    new PNotify({
      title: confirma_el_borrado,
      text:
        confirma_el_borrado2,
      icon: "fas fa-question-circle",
      hide: false,
      confirm: {
        confirm: true,
      },
      buttons: {
        closer: false,
        sticker: false,
      },
    })
      .get()
      .on("pnotify.confirm", function () {
        jQuery.ajax({
          type: "POST",
          url: url,
          data:
          {
            'form_key' : (jQuery)('input:hidden[name=form_key]').val(),
            action:'borrarCodigoCliente',
            customer_code_id: customerCodeId,
          },
          showLoader: true,
          complete: function (msg) {
            pintarRespuestaAjax(msg.responseText);
          },
          error: function (msg) {
            pintarRespuestaAjax(msg.responseText);
          },
        });
      })
      .on("pnotify.cancel", function () {
        //alert('ok. Chicken, chicken, clocloclo.');
      });
  });
}

// MODAL CODIGO CLIENTE
function pedirCodigoCliente(customerCodeId) {
  // funcion AJAX que lo envie al controlador y que guarde las que tiene que guardar
  var url=(jQuery)('#urlAjax').val();
  var customerCodeId = customerCodeId;
  jQuery.ajax({
    type: "POST",
    url: url,
    data: {
      'form_key' : (jQuery)('input:hidden[name=form_key]').val(),
      action: 'retornarCodigoCliente',
      customer_code_id: customerCodeId,
    },
    complete: function (msg) {
      abrirModalCodigoCliente(msg.responseText);
    },
    error: function (msg) {
    }
  });
}

function actualizarCodigoCliente() {
  var url=(jQuery)('#urlAjax').val();
  var customerCodeId = jQuery("#id_cod_cliente_modal").val();
  var customerCode = jQuery("#codigo_cliente_modal").val();

  if (document.getElementById("codigo_cliente_modal").checkValidity()) {
    jQuery.ajax({
      type: "POST",
      url: url,
      data: {
        'form_key' : (jQuery)('input:hidden[name=form_key]').val(),
        action: 'actualizarCodigoCliente',
        customer_code_id: customerCodeId,
        customer_code: customerCode,
      },
      showLoader: true,
      complete: function (msg) {
        pintarRespuestaAjax(msg.responseText);
      },
      error: function (msg) {
        pintarRespuestaAjax(msg.responseText);
      },
    });
    jQuery("#cerrar_modal_codigo").click();
  }else{
    requirejs(['pnotify' ,'pnotify.buttons', 'pnotify.confirm'], function(PNotify){
      PNotify.prototype.options.styling = "bootstrap3";
        new PNotify({
        title: titleErrorActualizarCliente,
        text:  textErrorActualizarCliente,
        type:  "error",
        stack: myStack,
      });
    });
  }
}

function abrirModalCodigoCliente(cliente) {
  cliente = JSON.parse(cliente);
  jQuery("#codigo_cliente_modal").val(cliente.customer_code);
  jQuery("#id_cod_cliente_modal").val(cliente.customer_code_id);
  jQuery("#ajustes").addClass("d-none");
  jQuery("#modal_codigo_client").removeClass("d-none");
  jQuery("#CEX-manualInteractivo").addClass("d-none");
  jQuery("#CEX-manualRemitente").addClass("d-none");
  jQuery("#CEX-manualCodigoCliente").removeClass("d-none");
  jQuery("#toggleIntroJS").prop("checked", true);
  //checkIntroJS();
}

function borrarModalCodigoCliente() {
  jQuery("#ajustes").removeClass("d-none");
  jQuery("#modal_codigo_client").removeClass("d-none");
  jQuery("#modal_codigo_client").addClass("d-none");
  jQuery("#CEX-manualRemitente").addClass("d-none");
  jQuery("#CEX-manualCodigoCliente").addClass("d-none");
  jQuery("#CEX-manualInteractivo").removeClass("d-none");
}

///////////////////////////////////////////////////////////////////
////////////////////////////REMITENTES/////////////////////////////
///////////////////////////////////////////////////////////////////

function validarRemitente(){
  var validate = 0;
  jQuery("#formCrearRemt input").each(function () {
      var input = jQuery(this);
      if (input.val() != "" && input.val() != "undefined") {
        jQuery(this).parent().removeClass("has-error");
      } else {
        validate++;
        jQuery(this).parent().addClass("has-error");
      }
      if(validate == 0){
        jQuery('#guardarRemitente').removeClass('disabled');
      }else {
        jQuery('#guardarRemitente').addClass('disabled');
      }
  });
}

jQuery("#formCrearRemt input").keyup(function(event) {
  validarRemitente();
});

function crearRemitente(event) {
       var url=(jQuery)('#urlAjax').val();
      (jQuery).ajax({
        type: "POST",
        url: url,
        data:  {
          'form_key' : (jQuery)('input:hidden[name=form_key]').val(),
          action:'guardarRemitente',
          name: jQuery("#name_sender").val(),
          address: jQuery("#address_sender").val(),
          postcode: jQuery("#postcode_sender").val(),
          city: jQuery("#city_sender").val(),
          iso_code: jQuery("#country_sender").val(),
          contact: jQuery("#contact_sender").val(),
          phone: jQuery("#phone_sender").val(),
          email: jQuery("#email_sender").val(),
          from_hour: jQuery("#fromHH_sender").val(),
          from_minute: jQuery("#fromMM_sender").val(),
          to_hour: jQuery("#toHH_sender").val(),
          to_minute: jQuery("#toMM_sender").val(),
          codigo_cliente: jQuery("#codigo_cliente").val(),
        },
          showLoader:true,
          complete: function (msg) {
            pintarRespuestaAjax(msg.responseText);
            jQuery("#name_sender").val("");
            jQuery("#address_sender").val("");
            jQuery("#postcode_sender").val("");
            jQuery("#city_sender").val("");
            jQuery("#contact_sender").val("");
            jQuery("#phone_sender").val("");
            jQuery("#email_sender").val("");
            jQuery("#fromHH_sender").val("");
            jQuery("#fromMM_sender").val("0");
            jQuery("#toHH_sender").val("");
            jQuery("#toMM_sender").val("0");
          },
          error: function (msg) {
          pintarRespuestaAjax(msg.responseText);
        }
      });

}

// function errorFormulario(){
//   requirejs(['pnotify' ,'pnotify.buttons', 'pnotify.confirm'], function(PNotify){
//     PNotify.prototype.options.styling = "bootstrap3";
//     new PNotify({
//       type:'error',
//       title:'Rellene tods los campos',
//       stack: myStack,
//     });
//   });
// }

function guardarRemitenteDefecto() {
  var senderId = jQuery("#MXPS_DEFAULTSEND").find(":selected").val();
  var url=(jQuery)('#urlAjax').val();
    (jQuery).ajax({
      type: "POST",
      url: url,
      data: {
        'form_key' : (jQuery)('input:hidden[name=form_key]').val(),
        action:'guardarRemitenteDefecto',
        sender_id: senderId,
      },
      showLoader: true,
      complete: function (msg) {
        pintarRespuestaAjax(msg.responseText);
      },
      error: function(msg){

      }
    }
  );
}

function pedirRemitente(senderId) {
  var url=(jQuery)('#urlAjax').val();
  (jQuery).ajax({
    type: "POST",
    url: url,
    data: {
      'form_key' : (jQuery)('input:hidden[name=form_key]').val(),
      action:'retornarRemitente',
      sender_id: senderId,
    },
    showLoader: true,
    complete: function (msg) {
      var remitente = JSON.parse(msg.responseText);
      abrirModalRemitente(remitente);
    },
    error: function(msg){

    }
  });
}

function borrarRemitente(senderId) {
  requirejs(['pnotify' ,'pnotify.buttons', 'pnotify.confirm'], function(PNotify){
    PNotify.prototype.options.styling = "bootstrap3";
    new PNotify({
      title: confirma_el_borrado,
      text: confirma_el_borrado_remitente,
      icon: "fas fa-question-circle",
      hide: false,
      confirm: {
        confirm: true,
      },
      buttons: {
        closer: false,
        sticker: false,
      },
    })
      .get()
      .on("pnotify.confirm", function () {
        var url=(jQuery)('#urlAjax').val();
        (jQuery).ajax({
          type: "POST",
          url: url,
          data: {
            'form_key' : (jQuery)('input:hidden[name=form_key]').val(),
            action:'borrarRemitente',
            sender_id: senderId,
          },
          showLoader: true,
          complete: function (msg) {
            pintarRespuestaAjax(msg.responseText);
            location.reload();
          },
          error: function(msg){

          }
        });
      })
      .on("pnotify.cancel", function () {
        //alert('ok. Chicken, chicken, clocloclo.');
      });
  });
}

function validarEditarRemitente(){
  var validate = 0;
  jQuery("#formUpdateRemt input").each(function () {
      var input = jQuery(this);
      if (input.val() != "" && input.val() != "undefined") {
        jQuery(this).parent().removeClass("has-error");
      } else {
        validate++;
        jQuery(this).parent().addClass("has-error");
      }
      if(validate == 0){
        jQuery('#guardar_modal_remitente').removeClass('disabled');
      }else {
        jQuery('#guardar_modal_remitente').addClass('disabled');
      }
  });
}

jQuery("#formUpdateRemt input").keyup(function(event) {
  validarEditarRemitente();
});

function actualizarRemitente() {
  var url=(jQuery)('#urlAjax').val();
  (jQuery).ajax({
    type: "POST",
    url: url,
    data: {
      'form_key' : (jQuery)('input:hidden[name=form_key]').val(),
      action:'actualizarRemitente',
      sender_id: jQuery("#id_modal").val(),
      name: jQuery("#name_sender_modal").val(),
      address: jQuery("#address_sender_modal").val(),
      postcode: jQuery("#postcode_sender_modal").val(),
      city: jQuery("#city_sender_modal").val(),
      iso_code: jQuery("#country_sender_modal").val(),
      contact: jQuery("#contact_sender_modal").val(),
      phone: jQuery("#phone_sender_modal").val(),
      email: jQuery("#email_sender_modal").val(),
      from_hour: jQuery("#fromHH_sender_modal").val(),
      from_minute: jQuery("#fromMM_sender_modal").val(),
      to_hour: jQuery("#toHH_sender_modal").val(),
      to_minute: jQuery("#toMM_sender_modal").val(),
      codigo_cliente_id: jQuery("#remitente_codigo_cliente_modal").val(),
    },
    showLoader: true,
    complete: function (msg) {
      pintarRespuestaAjax(msg.responseText);
    },
    error: function(msg){

    }
  });
  jQuery("#cerrar_modal_remitente").click();
}

function abrirModalRemitente(remitente) {
  jQuery("#id_modal").val(remitente.sender_id);
  jQuery("#name_sender_modal").val(remitente.name);
  jQuery("#address_sender_modal").val(remitente.address);
  jQuery("#postcode_sender_modal").val(remitente.postcode);
  jQuery("#city_sender_modal").val(remitente.city);
  jQuery("#country_sender_modal").val(remitente.iso_code_pais);
  jQuery("#contact_sender_modal").val(remitente.contact);
  jQuery("#phone_sender_modal").val(remitente.phone);
  jQuery("#email_sender_modal").val(remitente.email);
  jQuery("#fromHH_sender_modal").val(remitente.from_hour);
  jQuery("#fromMM_sender_modal").val(remitente.from_minute);
  jQuery("#toHH_sender_modal").val(remitente.to_hour);
  jQuery("#toMM_sender_modal").val(remitente.to_minute);
  jQuery("#remitente_codigo_cliente_modal").val(remitente['customer_code_id']);
  jQuery("#ajustes").addClass("d-none");
  jQuery("#remitente").removeClass("d-none");
  jQuery("#CEX-manualInteractivo").addClass("d-none");
  jQuery("#CEX-manualCodigoCliente").addClass("d-none");
  jQuery("#CEX-manualRemitente").removeClass("d-none");
  jQuery("#toggleIntroJS").prop("checked", true);
  validarEditarRemitente();
}

function borrarModalRemitente() {
  jQuery("#toggleEdicionRemitenteJS").prop("checked", true);
  jQuery("#ajustes").removeClass("d-none");
  jQuery("#remitente").addClass("d-none");
  jQuery("#CEX-manualRemitente").addClass("d-none");
  jQuery("#CEX-manualCodigoCliente").addClass("d-none");
  jQuery("#CEX-manualInteractivo").removeClass("d-none");
}

///////////////////////////////////////////////////////////////////
/////////////////////CONFIGURACION USUARIOS////////////////////////
///////////////////////////////////////////////////////////////////

function editarCredenciales(){
  (jQuery)('#MXPS_USER').val('');
  (jQuery)('#MXPS_PASSWD').val('');
  (jQuery)('#stepUser1').removeClass('d-none');
  (jQuery)('#stepUser2').removeClass('d-none');
  (jQuery)('#stepUser3').addClass('d-none');
  (jQuery)('#guardarCredenciales').removeClass('d-none');
  (jQuery)('#editarCredenciales').addClass('d-none');
}

(jQuery)('#panel_usuario input').keyup(function() {
  validarCredencialesYBultosVacio();
});

function validarCredencialesYBultosVacio(){
  var errores = 0
  var comprobar = ['MXPS_USER','MXPS_PASSWD'];

  for (var i = 0; i < comprobar.length; i++) {
    if((jQuery)('#'+comprobar[i]).val() == ""){
      (jQuery)('#'+comprobar[i]).parent().addClass('has-error');
      errores++;
    }else{
     (jQuery)('#'+comprobar[i]).parent().removeClass('has-error');
    }
  }
  errores == 0 ? (jQuery)('#guardarCredenciales').removeClass('disabled') : (jQuery)('#guardarCredenciales').addClass('disabled');

   if((jQuery)('#MXPS_DEFAULTBUL').val() == ""){
      (jQuery)('#MXPS_DEFAULTBUL').parent().addClass('has-error');
      (jQuery)('#guardarDatosCliente').addClass('disabled')
      errores++;
    }else{
     (jQuery)('#MXPS_DEFAULTBUL').parent().removeClass('has-error');
     (jQuery)('#guardarDatosCliente').removeClass('disabled')
    }
}

function guardarCredenciales(){
  var url=(jQuery)('#urlAjax').val();
  (jQuery).ajax({
      type: "POST",
      url: url,
      data: {
          'form_key' : (jQuery)('input:hidden[name=form_key]').val(),
          'action': 'validarCredenciales',
          'user' : (jQuery)('#MXPS_USER').val(),
          'pass' : (jQuery)('#MXPS_PASSWD').val()
      },
      showLoader: true,
      success: function(validation) {
          val=JSON.parse(validation);
          if (val.validacion){
            pintarNotificacion(val.mensaje);
              (jQuery).ajax({
                  type: "POST",
                  url: url,
                  data: {
                      'form_key' : (jQuery)('input:hidden[name=form_key]').val(),
                      'action': 'guardarCredenciales',
                      'MXPS_USER' : (jQuery)('#MXPS_USER').val(),
                      'MXPS_PASSWD' : (jQuery)('#MXPS_PASSWD').val()
                  },
                  success: function(msg) {
                      pintarRespuestaAjax(msg);
                      inicializarDatosUsuario();
                  },
                  error: function(msg) {
                      pintarRespuestaAjax(msg);
                  }
              });
          }else{
              pintarNotificacion(val.mensaje);
          }
      },
      error: function(validation) {
          return false;
      }
  });
}

function guardarDatosUser() {
  var url=(jQuery)('#urlAjax').val();

  var checkLog = (jQuery)('#MXPS_CHECK_LOG').prop('checked');
  mostrarOcultarLog(checkLog);

  var formdata = new FormData();
        formdata.append('form_key', (jQuery)('input:hidden[name=form_key]').val());
        formdata.append('action', 'guardarCustomerOptions');
        var MXPS_DEFAULTBUL= (jQuery)('#MXPS_DEFAULTBUL').val();
        MXPS_DEFAULTBUL=MXPS_DEFAULTBUL.replace(/^0+/, '');
        formdata.append('MXPS_WSURL', (jQuery)('#MXPS_WSURL').val());
        formdata.append('MXPS_WSURLREC', (jQuery)('#MXPS_WSURLREC').val());
        formdata.append('MXPS_WSURLSEG', (jQuery)('#MXPS_WSURLSEG').val());
        formdata.append('MXPS_ENABLEWEIGHT', (jQuery)('#MXPS_ENABLEWEIGHT').prop('checked'));
        formdata.append('MXPS_DEFAULTKG', (jQuery)('#MXPS_DEFAULTKG').val());
        formdata.append('MXPS_CHECK_LOG', checkLog);
        formdata.append('MXPS_ENABLESHIPPINGTRACK', (jQuery)('#MXPS_ENABLESHIPPINGTRACK').prop('checked'));
        formdata.append('MXPS_DEFAULTBUL', MXPS_DEFAULTBUL);
        formdata.append('MXPS_DEFAULTPDF', (jQuery)('#MXPS_DEFAULTPDF').find(":selected").val());
        formdata.append('MXPS_DEFAULTPAYBACK', (jQuery)('#MXPS_DEFAULTPAYBACK').find(":selected").val());
        formdata.append('MXPS_DEFAULTDELIVER', (jQuery)('#MXPS_DEFAULTDELIVER').find(":selected").val());
        formdata.append('MXPS_LABELSENDER', (jQuery)('#MXPS_LABELSENDER').prop('checked'));
        if((jQuery)('#MXPS_LABELSENDER').prop('checked')){
            formdata.append('MXPS_LABELSENDER_TEXT',(jQuery)('#MXPS_LABELSENDER_TEXT').val());
        }
        else {
            formdata.append('MXPS_LABELSENDER_TEXT',' ');
        }
        formdata.append('MXPS_NODATAPROTECTION', (jQuery)('#MXPS_NODATAPROTECTION').prop('checked'));
        formdata.append('MXPS_DATAPROTECTIONVALUE', (jQuery)('#MXPS_DATAPROTECTIONVALUE').find(":selected").val());
        formdata.append('MXPS_CHECKUPLOADFILE', (jQuery)('#MXPS_CHECKUPLOADFILE').prop('checked'));
        formdata.append('MXPS_OBSERVATIONS', (jQuery)('#MXPS_OBSERVATIONS').prop('checked'));
        formdata.append('MXPS_TRACKING', (jQuery)('#MXPS_TRACKING').prop('checked'));
        formdata.append('MXPS_REFETIQUETAS', (jQuery)('#MXPS_REFETIQUETAS').find(":selected").val());

  (jQuery).ajax({
    type: "POST",
    url: url,
    data: formdata,
    processData: false,
    contentType: false,
    showLoader: true,
    success: function (msg) {
      pintarRespuestaAjax(msg);
    },
    error: function (msg) {

    }
  });
}

(jQuery)('#MXPS_CHECKUPLOADFILE').click(function(event) {
  mostrarFormLogo(' ');
});

(jQuery)('#MXPS_UPLOADFILE').click(function(event) {
  cambiarImagen(event);
});

(jQuery)('#MXPS_UPLOADFILE').change(function(event) {
  cambiarImagen(event);
});

function mostrarFormLogo(url) {
  if ((jQuery)('#MXPS_CHECKUPLOADFILE').prop('checked') == true) {
    if((jQuery)('#mostrarImagenLogo').hasClass('d-none')){
      (jQuery)('#MXPS_UPLOADFILE').click();
      (jQuery)('#mostrarLogo').removeClass('d-none');
      (jQuery)('#mostrarImagenLogo').removeClass('d-none');
      (jQuery)('#mostrarLogo').addClass('d-flex');
      (jQuery)("#imagenLogoEtiqueta").attr("src", url);
    }
  } else {
    (jQuery)('#mostrarLogo').addClass('d-none');
    (jQuery)('#mostrarImagenLogo').addClass('d-none');
    (jQuery)('#mostrarLogo').removeClass('d-flex');
    eliminarImagen();
  }
}

function abrirBuscarImagen(){
  (jQuery)("#MXPS_UPLOADFILE").click();
}

function eliminarImagen(){
  var urlAjax = (jQuery)('#urlAjax').val();
  var formdata = new FormData();

  formdata.append('form_key', (jQuery)('input:hidden[name=form_key]').val());
  formdata.append('action', 'eliminarLogo');
  (jQuery).ajax({
    type: "POST",
    url: urlAjax,
    data: formdata,
    processData: false,
    contentType: false,
    showLoader: true,
    success: function (msg) {
      pintarRespuestaAjax(msg);
      (jQuery)('#MXPS_CHECKUPLOADFILE').prop('checked',false);
      (jQuery)('#mostrarLogo').addClass('d-none');
      (jQuery)('#mostrarImagenLogo').addClass('d-none');
      (jQuery)('#mostrarLogo').removeClass('d-flex');
    },
    error: function (msg) {
    }
  });
}

function cambiarImagen(e){
  if(e.target.files.length <= 0){
    (jQuery)('#divImagenLogo').addClass('d-none');
    (jQuery)('#MXPS_CHECKUPLOADFILE').prop('checked',false);
    return;
  }else{
    (jQuery)('#divImagenLogo').removeClass('d-none');
    (jQuery)('#MXPS_CHECKUPLOADFILE').prop('checked',true);
    var fileSize = e.target.files[0].size;
    var sizekiloByte = parseInt(fileSize / 1024);

    if (sizekiloByte > 400) {
      requirejs(['pnotify' ,'pnotify.buttons', 'pnotify.confirm'], function(PNotify){
        PNotify.prototype.options.styling = "bootstrap3";
        new PNotify({
          title: titleErrorTamañoImagen,
          text:  textErrorTamañoImagen,
          type:  "error",
          stack: myStack,
        });
      });
      return;
    }
    var url = URL.createObjectURL(e.target.files[0]);
    var urlAjax = (jQuery)('#urlAjax').val();
    var random = Math.floor(Math.random() * 100);
    pintarImagen(url);
    var formdata = new FormData();

    formdata.append('form_key', (jQuery)('input:hidden[name=form_key]').val());
    formdata.append('action', 'guardarImagenLogo');
    formdata.append('MXPS_UPLOADFILE', (jQuery)('#MXPS_UPLOADFILE').prop("files")[0]);
    formdata.append('MXPS_CHECKUPLOADFILE', (jQuery)('#MXPS_CHECKUPLOADFILE').prop('checked'));
    (jQuery).ajax({
      type: "POST",
      url: urlAjax,
      data: formdata,
      processData: false,
      contentType: false,
      showLoader: true,
      success: function (msg) {
        pintarRespuestaAjax(msg);
        if(msg.imagenLogo){
          var random = Math.floor(Math.random() * 100);
          pintarImagen(msg.imagenLogo);
        }
      },
      error: function (msg) {

      }
    });
  }
}

function pintarImagen(url){
    var img = "<img class='img-logo w-50' id='imagenLogoEtiqueta' src='"+url+"'>";
    var iconos = '<div class="row d-block"><div class="col"><i class="fas fa-file-upload fa-2x ml-3 mt-2 CEX-text-blue" data-toogle="tooltip" title="Subir una nueva imagen" onclick="abrirBuscarImagen();"></i></div><div class="col"><i class="fas fa-trash-alt fa-2x ml-3 mt-2 text-danger" data-toogle="tooltip" title="Eliminar Imagen" onclick="eliminarImagen();"></i></div></div><a href="" title=""></a>';
    (jQuery)('#divImagenLogo').html(img+iconos);
}

///////////////////////////////////////////////////////////////////
////////////////////////////CRON///////////////////////////////////
///////////////////////////////////////////////////////////////////

function show(){
  (jQuery)("#shb_cex").toggleClass('d-none');
}


function ejecutarCron() {
    var body = (jQuery)("body");
    var url=(jQuery)('#urlAjax').val();
    (jQuery).ajax({
    type: "POST",
    url: url,
    data: {
      'form_key' : (jQuery)('input:hidden[name=form_key]').val(),
      action:'ejecutarCron'
    },
    onComplete: function(msg) {
      console.log(msg);
    },
    error: function(msg) {
    console.log(msg);
    }
  });
}

function guardarDatosCronCex() {
  var url=(jQuery)('#urlAjax').val();
  (jQuery).ajax({
    type: "POST",
    url: url,
    data: {
     'form_key' : (jQuery)('input:hidden[name=form_key]').val(),
      action:'guardarDatosCron',
      MXPS_RECORDSTATUS: jQuery("#MXPS_RECORDSTATUS").val(),
      MXPS_SAVEDSTATUS: jQuery("#MXPS_SAVEDSTATUS").prop("checked"),
      MXPS_TRACKINGCEX: jQuery("#MXPS_TRACKINGCEX").prop("checked"),
      MXPS_CHANGESTATUS: jQuery("#MXPS_CHANGESTATUS").prop("checked"),
      MXPS_SENDINGSTATUS: jQuery("#MXPS_SENDINGSTATUS").find(":selected").val(),
      MXPS_DELIVEREDSTATUS: jQuery("#MXPS_DELIVEREDSTATUS").find(":selected").val(),
      MXPS_CANCELEDSTATUS: jQuery("#MXPS_CANCELEDSTATUS").find(":selected").val(),
      MXPS_RETURNEDSTATUS: jQuery("#MXPS_RETURNEDSTATUS").find(":selected").val(),
      MXPS_CRONTYPE: jQuery("#MXPS_CRONTYPE").find(":selected").val(),
    },
    showLoader: true,
    success: function (msg) {
      pintarRespuestaAjax(msg);
    },
    error: function (msg) {
    }
  });
}

///////////////////////////////////////////////////////////////////
/////////////////////////PRODUCTOS/////////////////////////////////
///////////////////////////////////////////////////////////////////

function guardarProductosCex() {
  var url=(jQuery)('#urlAjax').val();
  nodosActivos = "";
  var checkeds = jQuery(".check_productos");

  for (i = 0; i < checkeds.length; i++) {
    if (checkeds[i].checked) {
      nodosActivos += checkeds[i].value + ";";
    }
  }
  nodosActivos = nodosActivos.substr(0, nodosActivos.length - 1);
  if(nodosActivos == ""){
    var msg = {
      title  : guardarProd,
      mensaje: unProducto,
      type   : 'error'
    };
   pintarNotificacion(msg);
   return false;
  }
  (jQuery).ajax({
    type: "POST",
    url: url,
    data: {
      'form_key' : (jQuery)('input:hidden[name=form_key]').val(),
      action:'guardarProductosCex',
      nodos_activos: nodosActivos,
    },
    showLoader: true,
    complete: function (msg) {
      pintarRespuestaAjax(msg.responseText);
      location.reload();
    },
  });
}

///////////////////////////////////////////////////////////////////
////////////////////MAPEAR TRANSPORTISTAS//////////////////////////
///////////////////////////////////////////////////////////////////

function mapear_transportistas() {
  var transportistas = jQuery("#transportistas").serializeArray();
  if(transportistas == ""){
    var msg = {
      title  : guardarTransport,
      mensaje: unTransport,
      type   : 'error'
    };
   pintarNotificacion(msg);
   return false;
  }
  var url=(jQuery)('#urlAjax').val();
  (jQuery).ajax({
    type: "POST",
    url: url,
    data: {
      'form_key' : (jQuery)('input:hidden[name=form_key]').val(),
      action:'guardarMapeoTransportistas',
      formulario: JSON.stringify(transportistas)
    },
    showLoader: true,
    complete: function (msg) {
        pintarRespuestaAjax(msg.responseText);
      },
    }
  );
}

///////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////

function pintarEstadosFormularioUser(msg) {
  retorno = JSON.parse(msg);
  // INPUTS
  if(retorno.MXPS_USER !='' && retorno.MXPS_USER !='*****' && retorno.MXPS_PASSWD!=''){
    (jQuery)('#cex_account_title').html('<i id="cex_account_connect" class="fas fa-check-circle mr-2"></i> '+cuenta_conectada);
    (jQuery)('#cex_username').html('<strong>'+usuario+'</strong> '+retorno.MXPS_USER);
    (jQuery)('#cex_passw').html('<strong>Password:</strong> '+retorno.MXPS_PASSWD);
    (jQuery)('#MXPS_USER').val('');
    (jQuery)('#MXPS_PASSWD').val('');
    (jQuery)('#stepUser1').addClass('d-none');
    (jQuery)('#stepUser2').addClass('d-none');
    (jQuery)('#stepUser3').removeClass('d-none');
    (jQuery)('#guardarCredenciales').addClass('d-none');
    (jQuery)('#editarCredenciales').removeClass('d-none');
  }
  jQuery("#MXPS_WSURL").val(retorno.MXPS_WSURL);
  jQuery("#MXPS_WSURLREC").val(retorno.MXPS_WSURLREC);
  jQuery("#MXPS_WSURLSEG").val(retorno.MXPS_WSURLSEG);
  jQuery("#MXPS_DEFAULTKG").val(retorno.MXPS_DEFAULTKG);
  jQuery("#MXPS_DEFAULTBUL").val(retorno.MXPS_DEFAULTBUL);
  jQuery("#MXPS_RECORDSTATUS").val(retorno.MXPS_RECORDSTATUS);
  jQuery("#MXPS_SENDINGSTATUS").val(retorno.MXPS_SENDINGSTATUS);
  jQuery("#MXPS_DELIVEREDSTATUS").val(retorno.MXPS_DELIVEREDSTATUS);
  jQuery("#MXPS_CANCELEDSTATUS").val(retorno.MXPS_CANCELEDSTATUS);
  jQuery("#MXPS_RETURNEDSTATUS").val(retorno.MXPS_RETURNEDSTATUS);
  jQuery("#MXPS_CRONTYPE").val(retorno.MXPS_CRONTYPE);
  jQuery("#MXPS_REFETIQUETAS").val(retorno.MXPS_REFETIQUETAS);

  //CHECKBOXES
  if (retorno.MXPS_ENABLEWEIGHT == "true") {
    jQuery("#MXPS_ENABLEWEIGHT").prop("checked", "checked");
    mostrarPesoDefecto();
  } else {
    jQuery("#MXPS_ENABLEWEIGHT").prop("checked", null);
  }
  if (retorno.MXPS_CHECK_LOG == "true") {
    (jQuery)("#MXPS_CHECK_LOG").prop("checked", "checked");
    mostrarOcultarLog(true);
  } else {
    (jQuery)("#MXPS_CHECK_LOG").prop("checked", null);
    mostrarOcultarLog(false);
  }
  if (retorno.MXPS_ENABLESHIPPINGTRACK == "true") {
    jQuery("#MXPS_ENABLESHIPPINGTRACK").prop("checked", "checked");
  } else {
    jQuery("#MXPS_ENABLESHIPPINGTRACK").prop("checked", null);
  }
  if (retorno.MXPS_LABELSENDER == "true") {
    jQuery("#MXPS_LABELSENDER").prop("checked", "checked");
    jQuery("#MXPS_LABELSENDER_TEXT").val(retorno.MXPS_LABELSENDER_TEXT);
  } else {
    jQuery("#MXPS_LABELSENDER").prop("checked", null);
  }
  mostrarRemitenteAlternativo();
  if (retorno.MXPS_CHECKUPLOADFILE == "true") {
    jQuery("#MXPS_CHECKUPLOADFILE").prop("checked", "checked");
    if((jQuery)('#mostrarImagenLogo').hasClass('d-none')){
          (jQuery)('#mostrarLogo').removeClass('d-none');
          (jQuery)('#mostrarImagenLogo').removeClass('d-none');
          (jQuery)('#mostrarLogo').addClass('d-flex');
          (jQuery)("#imagenLogoEtiqueta").attr("src", retorno.MXPS_UPLOADFILE);
      }
  } else {
    jQuery("#MXPS_CHECKUPLOADFILE").prop("checked", null);
    (jQuery)('#mostrarLogo').addClass('d-none');
    (jQuery)('#mostrarImagenLogo').addClass('d-none');
    (jQuery)('#mostrarLogo').removeClass('d-flex');
  }

  if (retorno.MXPS_TRACKINGCEX == "true") {
    jQuery("#MXPS_TRACKINGCEX").prop("checked", "checked");
    activarCambioEstado();
  } else {
    jQuery("#MXPS_TRACKINGCEX").prop("checked", null);
    activarCambioEstado();
  }
  if (retorno.MXPS_NODATAPROTECTION == "true") {
    jQuery("#MXPS_NODATAPROTECTION").prop("checked", "checked");
    jQuery("#proteccionDatos").removeClass("d-none");
  } else {
    jQuery("#MXPS_NODATAPROTECTION").prop("checked", null);
  }
  jQuery(
    "#MXPS_DATAPROTECTIONVALUE option[value=" +
      retorno.MXPS_DATAPROTECTIONVALUE +
      "]"
  ).prop("selected", "selected");
  if (retorno.MXPS_SAVEDSTATUS == "true") {
    jQuery("#MXPS_SAVEDSTATUS").prop("checked", "checked");
    jQuery("#estado_grabacion").removeClass("d-none");
  } else {
    jQuery("#MXPS_SAVEDSTATUS").prop("checked", null);
    jQuery("#estado_grabacion").addClass("d-none");
  }
  if (retorno.MXPS_CHANGESTATUS == "true") {
    jQuery("#MXPS_CHANGESTATUS").prop("checked", "checked");
    jQuery("#estados_cron").removeClass("d-none");
  } else {
    jQuery("#MXPS_CHANGESTATUS").prop("checked", null);
    jQuery("#estados_cron").addClass("d-none");
  }

  if (retorno.MXPS_OBSERVATIONS == "true") {
    jQuery("#MXPS_OBSERVATIONS").prop("checked", "checked");
  } else {
    jQuery("#MXPS_OBSERVATIONS").prop("checked", null);
  }

  if (retorno.MXPS_TRACKING == "true") {
    jQuery("#MXPS_TRACKING").prop("checked", "checked");
  } else {
    jQuery("#MXPS_TRACKING").prop("checked", null);
  }

  //selects inferiores
  jQuery("#MXPS_DEFAULTPDF").val(retorno.MXPS_DEFAULTPDF);
  jQuery("#MXPS_DEFAULTPAYBACK").val(retorno.MXPS_DEFAULTPAYBACK);

  validarCredencialesYBultosVacio();
}

function mostrarPesoDefecto() {
  if (jQuery("#MXPS_ENABLEWEIGHT").prop("checked") == true) {
    jQuery("#pesodefecto").removeClass("d-none");
  } else {
    jQuery("#pesodefecto").addClass("d-none");
  }
}

function mostrarOcultarLog(activado){
  if(activado || activado == "true"){
    (jQuery)("#botonesLogCron").removeClass('d-none');
    (jQuery)("#acordeonSoporte").removeClass('d-none');
  }else{
    (jQuery)("#botonesLogCron").addClass('d-none');
    (jQuery)("#acordeonSoporte").addClass('d-none');
  }
}

function mostrarProteccionDatos() {
  if (jQuery("#MXPS_NODATAPROTECTION").prop("checked") === true) {
    jQuery("#proteccionDatos").removeClass("d-none");
  } else {
    jQuery("#proteccionDatos").addClass("d-none");
  }
}

function activarCambioEstado() {
  if (jQuery("#MXPS_TRACKINGCEX").prop("checked") == true) {
    jQuery("#MXPS_CHANGESTATUS").prop("disabled", false);
  } else {
    jQuery("#MXPS_CHANGESTATUS").prop("checked", false);
    jQuery("#MXPS_CHANGESTATUS").prop("disabled", true);
    mostrarEstadosCron();
  }
}

function mostrarEstadosCron() {
  if (jQuery("#MXPS_CHANGESTATUS").prop("checked") == true) {
    jQuery("#estados_cron").removeClass("d-none");
  } else {
    jQuery("#estados_cron").addClass("d-none");
    jQuery("#MXPS_SENDINGSTATUS").prop("selectedIndex", 0);
    jQuery("#MXPS_DELIVEREDSTATUS").prop("selectedIndex", 0);
    jQuery("#MXPS_CANCELEDSTATUS").prop("selectedIndex", 0);
    jQuery("#MXPS_RETURNEDSTATUS").prop("selectedIndex", 0);
  }
}

function mostrarEstadoGrabacion() {
  if (jQuery("#MXPS_SAVEDSTATUS").prop("checked") == true) {
    jQuery("#estado_grabacion").removeClass("d-none");
  } else {
    jQuery("#estado_grabacion").addClass("d-none");
    jQuery("#MXPS_RECORDSTATUS").prop("selectedIndex", 0);
  }
}

function datosCronErrores(contenedor) {
  var validate = {};
  contenedor.forEach(function (value) {
    if (!jQuery("#" + value).hasClass("d-none")) {
      jQuery("#" + value + " select").each(function () {
        var select = jQuery(this);
        if (
          select.val() != "" &&
          select.val() != "undefined" &&
          select.val() != null
        ) {
          validate[this.name] = true;
          jQuery(this).parent().removeClass("has-error");
        } else {
          validate[this.name] = false;
          jQuery(this).parent().addClass("has-error");
        }
      });
    } else {
      return false;
    }
  });
  return validate;
}
function mostrarRemitenteAlternativo() {
  if ((jQuery)('#MXPS_LABELSENDER').prop('checked') == true) {
    (jQuery)('#remitenteAlt').removeClass('d-none');
  } else {
    (jQuery)('#remitenteAlt').addClass('d-none');
    (jQuery)('#MXPS_LABELSENDER_TEXT').val("");
  }
}

// ZONAS DE ENV&Iacute;O

// EVENTOS ANIMACIONES MENSAJES DE ERROR Y COSAS VARIAS


function pintarRespuestaAjax(msg) {

  var retorno = JSON.parse(msg);
  jQuery("#resultados").css("display", "block");
  jQuery("#id_version").append(retorno.version);
  //comprobamos si mostrar boton actualizar
  if (retorno.botonUpdate === "actualizar") {
    jQuery("#ejecutarUpdateButton").removeClass("d-none");
  } else {
    jQuery("#ejecutarUpdateButton").addClass("d-none");
  }

  if (retorno.remitentes != "undefined" && retorno.remitentes != null)
    jQuery("#savedsenders").html(retorno.remitentes);

  if (retorno.codigos != "undefined" && retorno.codigos != null) {
    jQuery("#saved_codes").html(retorno.codigos);
    if (retorno.codigos.length > 0) {
      jQuery("#saved_codes").removeClass("d-none");
    } else {
      jQuery("#saved_codes").addClass("d-none");
    }
  } else {
    jQuery("#saved_codes").empty();
  }

  if (
    retorno.selectCodCliente != "undefined" &&
    retorno.selectCodCliente != null
  )
    jQuery("#codigo_cliente").html(retorno.selectCodCliente);

  if (
    retorno.selectRemitentes != "undefined" &&
    retorno.selectRemitentes != null
  )
    jQuery("#MXPS_DEFAULTSEND").html(retorno.selectRemitentes);

  if (retorno.productos != "undefined" && retorno.productos != null)
    jQuery("#productos_cex").html(retorno.productos);

  if (retorno.selectEstados != "undefined" && retorno.selectEstados != null) {
    jQuery("#MXPS_RECORDSTATUS").html(retorno.selectEstados);
    jQuery("#MXPS_SENDINGSTATUS").html(retorno.selectEstados);
    jQuery("#MXPS_DELIVEREDSTATUS").html(retorno.selectEstados);
    jQuery("#MXPS_CANCELEDSTATUS").html(retorno.selectEstados);
    jQuery("#MXPS_RETURNEDSTATUS").html(retorno.selectEstados);
  }

  if (
    retorno.selectReferencias != "undefined" &&
    retorno.selectReferencias != null
  ) {
    jQuery("#MXPS_REFETIQUETAS").html(retorno.selectReferencias);
  }

  if (retorno.active_gateways != "undefined" && retorno.active_gateways != null) {
    jQuery("#MXPS_DEFAULTPAYBACK").html(retorno.active_gateways);
  }

  if (retorno.selectTransportistas != "undefined" && retorno.selectTransportistas != null) {
    jQuery("#transportistas").html(retorno.selectTransportistas);
  }

  if (retorno.mensaje != "undefined" && retorno.mensaje != null)
    pintarNotificacion(retorno.mensaje);

  //comprobar si viene habilitado o no para habilitar el boton.
  if (
    retorno.selectCodCliente != "undefined" &&
    retorno.selectCodCliente != null
  ) {
    if (retorno.selectCodCliente.indexOf("disabled") != -1) {
      jQuery("#guardarRemitente").prop("disabled", true);
      jQuery("#guardarRemitenteMsn").removeClass("d-none");
    } else {
      jQuery("#guardarRemitente").prop("disabled", false);
      jQuery("#guardarRemitenteMsn").addClass("d-none");
    }
  }

  if (retorno.unidadMedida != "undefined" && retorno.unidadMedida != null) {
    jQuery("#unidadMedida").append("(" + retorno.unidadMedida + ")");
  }


}

function generar_archivos(nombre_archivo) {
  var url=(jQuery)('#urlAjax').val();
  (jQuery).ajax({
    type: "POST",
    url: url,
    data: {
      'form_key' : (jQuery)('input:hidden[name=form_key]').val(),
      action:'generarCron',
      nombre : nombre_archivo,
    },
    showLoader: true,
    complete: function (msg) {
        (jQuery)("#descarga").attr("download", nombre_archivo);
        (jQuery)("#descarga").attr("href", "data:text/plain;msg.responseText," + msg.responseText);
        (jQuery)("#descarga")[0].click();
      },
    }
  );
}

function generarLogBBDD(nombre_archivo) {
  var url=(jQuery)('#urlAjax').val();
  var nombre = (jQuery)("#datos_tablas").val();

  (jQuery).ajax({
    type: "POST",
    url: url,
    data: {
      'form_key' : (jQuery)('input:hidden[name=form_key]').val(),
      action:'generarLogSoporte',
      nombre: nombre,
    },
    showLoader: true,
    complete: function (msg) {
        (jQuery)("#descargaBBDD").attr("download", nombre);
        (jQuery)("#descargaBBDD").attr("href", "data:text/plain;msg.responseText," + msg.responseText);
        (jQuery)("#descargaBBDD")[0].click();
      },
    }
  );
}


var myStack = {
  dir1: "down",
  dir2: "right",
  push: "top",
};

function pintarNotificacion(msg) {
  requirejs(['pnotify' ,'pnotify.buttons', 'pnotify.confirm'], function(PNotify){
    PNotify.prototype.options.styling = "bootstrap3";
    new PNotify({
      title: msg.title,
      text: msg.mensaje,
      type: msg.type,
      stack: myStack,
    });
  });
}
