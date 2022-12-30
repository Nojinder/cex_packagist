 var config = {
    map: {
        '*': {
            'boostrap'              : 'CorreosExpress_RegistroDeEnvios/js/bootstrap.min',
            'gijgo'                 : 'CorreosExpress_RegistroDeEnvios/js/gijgo.min',
            'jquery.dataTables'     : 'CorreosExpress_RegistroDeEnvios/js/jquery.dataTables.min',
            'IntroJs'               : 'CorreosExpress_RegistroDeEnvios/js/intro',
            'IntroJsConfigure'      : 'CorreosExpress_RegistroDeEnvios/js/introJS-configure',
            'IntroJsTemplateOrder'  : 'CorreosExpress_RegistroDeEnvios/js/introJS-templateOrder',
            'IntroJsUtilidades'     : 'CorreosExpress_RegistroDeEnvios/js/introJS-utilidades',
            'PNotify'               : 'CorreosExpress_RegistroDeEnvios/js/pnotify.custom.min',
            'PNotify.buttons'       : 'CorreosExpress_RegistroDeEnvios/js/pnotify.buttons',
            'PNotify.confirm'       : 'CorreosExpress_RegistroDeEnvios/js/pnotify.confirm',
            'inicioJs'              : 'CorreosExpress_RegistroDeEnvios/js/inicio',
            'ajustesJs'             : 'CorreosExpress_RegistroDeEnvios/js/ajustes',
            'utilidadesJs'          : 'CorreosExpress_RegistroDeEnvios/js/utilidades',
            'cexorderJs'            : 'CorreosExpress_RegistroDeEnvios/js/cexorder',
        }
    } ,
    paths: {
            'popper'                : 'CorreosExpress_RegistroDeEnvios/js/popper.min',
            'bootstrap'             : 'CorreosExpress_RegistroDeEnvios/js/bootstrap.min',
            'gijgo'                 : 'CorreosExpress_RegistroDeEnvios/js/gijgo.min',
            'jquery.dataTables'     : 'CorreosExpress_RegistroDeEnvios/js/jquery.dataTables.min',          
            'IntroJs'               : 'CorreosExpress_RegistroDeEnvios/js/intro',
            'IntroJsConfigure'      : 'CorreosExpress_RegistroDeEnvios/js/introJS-configure',
            'IntroJsTemplateOrder'  : 'CorreosExpress_RegistroDeEnvios/js/introJS-templateOrder',
            'IntroJsUtilidades'     : 'CorreosExpress_RegistroDeEnvios/js/introJS-utilidades',
            'PNotify'               : 'CorreosExpress_RegistroDeEnvios/js/pnotify.custom.min',
            'PNotify.buttons'       : 'CorreosExpress_RegistroDeEnvios/js/pnotify.buttons',
            'PNotify.confirm'       : 'CorreosExpress_RegistroDeEnvios/js/pnotify.confirm',
            'inicioJs'              : 'CorreosExpress_RegistroDeEnvios/js/inicio',
            'ajustesJs'             : 'CorreosExpress_RegistroDeEnvios/js/ajustes',
            'utilidadesJs'          : 'CorreosExpress_RegistroDeEnvios/js/utilidades',
            'cexorderJs'            : 'CorreosExpress_RegistroDeEnvios/js/cexorder',
    } ,
    shim: {
        'popper': {
            'deps': ['jquery'],
            'exports': 'Popper'
        },
        'bootstrap': {
            'deps': ['jquery', 'popper']
        },
        'gijgo': {
            'deps': ['jquery','bootstrap']
        },
        'jquery.dataTables': {
            'deps': ['jquery','bootstrap']
        },              
        'IntroJs' : {
            'deps': ['jquery','bootstrap']
        },
        'IntroJsConfigure' : {
            'deps': ['jquery','bootstrap','IntroJs']
        },
        'IntroJsTemplateOrder' : {
            'deps': ['jquery','bootstrap','IntroJs']
        },
        'IntroJsUtilidades' : {
            'deps': ['jquery','bootstrap','IntroJs']
        },
        'PNotify' : {
            'deps': ['jquery','bootstrap']
        },
        'inicioJs': {
            'deps': ['jquery','bootstrap', 'PNotify']
        },
        'ajustesJs': {
            'deps': ['jquery','bootstrap', 'PNotify']
        },
        'utilidadesJs': {
            'deps': ['jquery','bootstrap', 'PNotify']
        },
        'cexorderJs': {
            'deps': ['jquery','bootstrap', 'PNotify']
        },
    }
};
