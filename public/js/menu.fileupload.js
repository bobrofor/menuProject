define(['jquery', 'jquery.fileupload'], function ($) {

    'use strict';








    $('input#fileupload').fileupload({
        url: 'menu/upload',
        type: 'POST',
        dataType: 'json',
        formData:function () {
            return [];
        },
        done: function (e, data) {
                $('<p/>').html(
                    "<div id='"+data._response.result.id +"' class='panel panel-default col-lg-3'>" +
                        "<div class='panel-heading'>"+
                            "<a class='delete-upload btn btn-xs btn-danger'data-method='delete' data-href='/menu/upload/id/"+data._response.result.id+"'" +
                    "data-id ='"+data._response.result.id+"'>" +

                                "<i class='fa fa-trash-o'></i>"+
                            "</a>"+
                        "</div>"+
                        "<div class='panel-body'>" +
                            "<img style='height:100px' " +
                                "src='" + data._response.result.path +
                            "' class ='img-polaroid'/>" +
                        " </div> " +
                    "</div>").appendTo('#files');



        }
    });








    //
    //<div id="<?php echo  $media['id']?>" class="panel panel-default col-lg-3">
    //    <div class="panel-heading">
    //
    //    <a  class='delete-media btn btn-xs btn-danger '
    //data-href="<?= $this->url('media', 'crud',
    //        ['id' => $media['id']]) ?>"
    //data-id="<?php echo $media['id']?>"
    //data-method="delete">
    //    <i class="fa fa-trash-o"></i>
    //    </a>
    //    </div>
    //    <div class="panel-body">
    //    <a href="<?= $this->baseUrl($media->file) ?>"
    //class="thumbnail bluz-preview">
    //    <img style="height:80px"
    //src="<?= $this->baseUrl($media->preview ?: $media->file) ?>"
    //class="img-polaroid"
    //alt="<?= $media->title ?>"/>
    //    </a>
    //    </div>
    //    </div>

$('div#files').on('click','a.delete-upload',function(){

    var $params = $(this).data();

    if(confirm('Are you sure?'))
    {
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






    var $savedMedia=$('div#saved-media');
    //.find('a.delete-media').

    $savedMedia.on('click','a.delete-media',function(data){

        var $params = $(this).data(),
            $this=$(this);

        if(confirm('Are you sure?'))
        {
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