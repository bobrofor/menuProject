/**
 * Configuration example
 * @author Anton Shevchuk
 */
/*global define,require*/
require.config({
    // why not simple "js"? Because IE eating our minds!
    baseUrl: '/js',
    // if you need disable JS cache
    urlArgs: "bust=" + (new Date()).getTime(),
    paths: {
        "": './bootstrap',
        "jquery": './vendor/jquery',
        "jquery-ui": './vendor/jquery-ui',
        "redactor": './../redactor/redactor',
        "redactor.imagemanager": './../redactor/plugins/imagemanager',
        // see more at https://cdnjs.com/
        "underscore": '//cdnjs.cloudflare.com/ajax/libs/underscore.js/1.7.0/underscore-min',
        "backbone": '//cdnjs.cloudflare.com/ajax/libs/backbone.js/1.1.2/backbone-min',
        "jquery.fileupload":'./../jquery.fileupload/js/jquery.fileupload',
        "jquery.fileupload-process":'./../jquery.fileupload/js/jquery.fileupload-process',
        "jquery.fileupload-image":'./../jquery.fileupload/js/jquery.fileupload-image',

        "menu.fileupload":'./menu.fileupload',
        "jquery.ui.widget":'./../jquery.fileupload/js/vendor/jquery.ui.widget'
    },
    shim: {
        "bootstrap": {
            deps: ['jquery'],
            exports: '$.fn.popover'
        },
        "backbone": {
            deps: ['underscore', 'jquery'],
            exports: 'Backbone'
        },
        "redactor": {
            deps: ['jquery'],
            exports: '$.fn.redactor'
        },
        "redactor.imagemanager": {
            deps: ['redactor', 'jquery'],
            exports: 'RedactorPlugins'
        },
        "underscore": {
            exports: '_'
        },
        "jquery-ui": {
            deps: ['jquery'],
            exports: '$.ui'
        }
    },
    enforceDefine: true
});

require(['bluz', 'bluz.ajax', 'bootstrap']);