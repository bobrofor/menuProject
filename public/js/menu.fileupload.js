define(['jquery', 'jquery.fileupload'], function ($) {

    'use strict';

    $('input#fileupload').fileupload({
        url: 'menu/upload',
        dataType: 'json',
        done: function (e, data) {
            $('#files').html('');
            $.each(data._response.result, function (index, file) {
                $('<p/>').html('<img  style="height:100px" class="img-thumbnail" src="' + file.path + '" />')
                    .appendTo('#files');
            });
        }
    });


});