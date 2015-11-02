define(['jquery', 'jquery.fileupload'], function ($) {

    'use strict';


    $('body')
    //file upload
        .on('click', 'input.fileupload', function () {


            $(this).fileupload({
                url: 'menu/upload',
                type: 'POST',
                dataType: 'json',
                formData: function () {
                    return [];
                },
                done: function (e, data) {

                    $('#files').append(
                        "<div class='panel panel-default col-lg-3'>" +
                            "<div class='panel-heading'>" +
                                "<a class='delete-media btn btn-xs btn-danger'" +
                                    "data-href='/menu/upload/id/" + data._response.result.id + "' >" +
                                        "<i class='fa fa-trash-o'></i></a></div>" +
                            "<div class='panel-body'>" +
                                "<img style='height:100px' " +
                                    "src='" + data._response.result.path +
                                    "' class ='img-polaroid'/>" +
                            "</div> " +
                        "</div>");
                }
            });


        })

        //delete media
        .on('click', 'a.delete-media', function () {

            var $params = $(this).data(),
                $this = $(this);

            if (confirm('Are you sure?')) {

                $.ajax({
                    url: $params.href,
                    type: 'delete',
                    success: function () {
                        $this.parent().parent().remove();
                    }
                })
            }


        });


});