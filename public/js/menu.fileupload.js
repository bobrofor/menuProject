define(['jquery', 'jquery.fileupload'], function ($) {

    'use strict';


    $('input#fileupload').fileupload({
        url: 'menu/upload',
        type: 'POST',
        dataType: 'json',
        formData: function () {
            return [];
        },
        done: function (e, data) {
            $('#files').append(
                "<div id='" + data._response.result.id + "' class='panel panel-default col-lg-3'>" +
                "<div class='panel-heading'>" +
                "<a class='btn btn-xs btn-danger'data-method='delete' data-href='/menu/upload/id/" + data._response.result.id + "'" +
                "data-id ='" + data._response.result.id + "'>" +

                "<i class='fa fa-trash-o'></i>" +
                "</a>" +
                "</div>" +
                "<div class='panel-body'>" +
                "<img style='height:100px' " +
                "src='" + data._response.result.path +
                "' class ='img-polaroid'/>" +
                " </div> " +
                "</div>");


        }
    });


    $('div#files').on('click', 'a.delete-upload', function () {

        var $params = $(this).data();

        if (confirm('Are you sure?')) {
            $.ajax({
                url: $params.href,
                type: $params.method,

                success: function () {
                    $('div#files')
                        .find('#' + $params.id)
                        .remove()
                }
            })
        }


    });


    var $savedMedia = $('div#saved-media');

    $savedMedia.on('click', 'a.delete-media', function (data) {

            var $params = $(this).data(),
                $this = $(this);

            if (confirm('Are you sure?')) {
                $.ajax({
                        url: $params.href,
                        type: $params.method,
                        success: function () {
                            $savedMedia
                                .find('#' + $params.id)
                                .remove()
                        }
                    }
                )
            }
        }
    )


});