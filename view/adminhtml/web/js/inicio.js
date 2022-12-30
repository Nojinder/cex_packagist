function revisar(e) {
    var input = (jQuery)(e);
    input.parent().removeClass('has-error');
    if (!(input.attr('onkeypress'))) {
        input.removeAttr('onclick');
    } else {
        input.removeAttr('onkeypress');
    }
}

function sendForm(event) {
    event.preventDefault();
    var telefono = CEXvalidateTelefono((jQuery)('#telefono').val());
    var correo = CEXvalidateCorreo((jQuery)('#correoelectronico').val());
    var politica = CEXvalidatePolitica();
    if ((jQuery)('#nombre').val() != '' && (jQuery)('#telefono').val() != '' && (jQuery)('#correoelectronico').val() !=
        '' && (jQuery)('#politica').prop('checked')) {
        if (telefono == true && correo == true && politica == true) { 
            requirejs(['pnotify' ,'pnotify.buttons', 'pnotify.confirm'], function(PNotify){           
            PNotify.prototype.options.styling = "bootstrap3";
            new PNotify({
                title: 'Confirma la operación',
                text: '¿Estás seguro querer que le visite un comercial?',
                icon: 'fas fa-question-circle',
                type: 'warning',
                hide: false,
                confirm: {
                    confirm: true
                },
                buttons: {
                    closer: false,
                    sticker: false
                }
            }).get().on('pnotify.confirm', function() {
                    (jQuery).ajax({
                            type: "POST",
                            crossDomain: true,
                            dataType: "jsonp",
                            url: 'https://webto.salesforce.com/servlet/servlet.WebToLead?encoding=UTF-8',
                            data: {
                                'company': (jQuery)('#compania').val(),
                                'first_name': (jQuery)('#nombre').val(),
                                'last_name': '',
                                'phone': (jQuery)('#telefono').val(),
                                'email': (jQuery)('#correoelectronico').val(),
                                '00Nb00000040JtK': (jQuery)('#observaciones').val(),
                                'lead_source': (jQuery)('#lead_source').val(),
                                '00Nb00000040KMY': (jQuery)('#00Nb00000040KMY').val(),
                                'URL': (jQuery)('#URL').val(),
                                'oid': (jQuery)('#oid').val(),
                                //'nonce': ''
                            },
                            success: function(msg) {
                                if (msg.readyState == 4 && msg.status == 200) { 
                                    (jQuery)('#CEX-form_info').prepend('<div class="alert alert-success">LA PETICIÓN HA SIDO CURSADA<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');                                   
									//alert('LA PETICIÓN HA SIDO CURSADA');

                                } else {
                                    (jQuery)('#CEX-form_info').prepend('<div class="alert alert-danger">EN ESTOS MOMENTOS NO SE HA PODIDO CURSAR LA PETICIÓN<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');                                   
                                   //alert('EN ESTOS MOMENTOS NO SE HA PODIDO CURSAR LA PETICIÓN');
                                }
                            },
                            error: function(msg) {
                                if (msg.readyState == 4 && msg.status == 200) {
                                    (jQuery)('#CEX-form_info').prepend('<div class="alert alert-success">LA PETICIÓN HA SIDO CURSADA<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');                                   
                                    //alert('LA PETICIÓN HA SIDO CURSADA');
                                } else {
                                    (jQuery)('#CEX-form_info').prepend('<div class="alert alert-danger">EN ESTOS MOMENTOS NO SE HA PODIDO CURSAR LA PETICIÓN<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');                                   
                                    //alert('EN ESTOS MOMENTOS NO SE HA PODIDO CURSAR LA PETICIÓN');
                                }
                            }
                        });
                    }).on('pnotify.cancel', function() {
                    //alert('ok. Chicken, chicken, clocloclo.');
                });
                });
            }
            else {
                CEXmarcarErrores(telefono, correo, politica);
            }
        } else {
            CEXmarcarErrores(telefono, correo, politica);
        }
    }

    function mostrar() {
        document.getElementById('informacion_comercial').style.display = 'block';
    }

    var myStack = {
        "dir1": "down",
        "dir2": "right",
        "push": "top"
    };

    function pintarNotificacion(msg) {
        requirejs(['pnotify' ,'pnotify.buttons', 'pnotify.confirm'], function(PNotify){  
            PNotify.prototype.options.styling = "bootstrap3";
            new PNotify({
                title: msg.title,
                text: msg.mensaje,
                type: msg.type,
                stack: myStack
            });
        });
    }

    function CEXvalidateTelefono(telefono) {
        if (!(isNaN(telefono)) && telefono.length == 9) {
            return true;
        } else {
            return false;
        }
    }

    function CEXvalidateCorreo(correo) {
        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!regex.test(correo)) {
            return false;
        } else {
            return true;
        }
    }

    function CEXvalidatePolitica() {
        if (!(jQuery)('#politica').prop('checked')) {
            return false;
        } else {
            return true;
        }
    }

    function CEXmarcarErrores(telefono = false, correo = false, politica = false) {
        if ((jQuery)('#telefono').val() == '' || telefono == false) {
            (jQuery)('#telefono').parent().addClass('has-error');
        } else {
            (jQuery)('#telefono').parent().removeClass('has-error');
            (jQuery)('#telefono').parent().addClass('has-success');
        }
        if ((jQuery)('#correoelectronico').val() == '' || correo == false) {
            (jQuery)('#correoelectronico').parent().addClass('has-error');
        } else {
            (jQuery)('#correoelectronico').parent().removeClass('has-error');
            (jQuery)('#correoelectronico').parent().addClass('has-success');
        }
        if ((jQuery)('#nombre').val() == '') {
            (jQuery)('#nombre').parent().addClass('has-error');
        } 
        if ((!(jQuery)('#politica').prop('checked') && !(jQuery)('#politica').prop('checked')) || politica == false) {
            (jQuery)('#politica').parent().addClass('has-error');
        } else {
            (jQuery)('#politica').parent().removeClass('has-error');
            (jQuery)('#politica').parent().addClass('has-success');
        }
        if ((jQuery)(".has-error").length > 0) {
            (jQuery)(".has-error").each(function() {
                var input = (jQuery)(this).find('input');
                if (input.attr('type') == 'checkbox') {
                    input.attr('onclick', 'revisar(this)');
                } else {
                    input.attr('onkeypress', 'revisar(this)');
                }
            });
        }
    }