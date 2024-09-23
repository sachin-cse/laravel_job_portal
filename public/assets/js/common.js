$(document).ready(function(){
    $(document).on('click', '.send_ajax_response', function(){
        var dataId = $(this).data('id');
        var dataUrl = $(this).data('url');
        var text = "Do You want to remove this";
        var title = "Are you sure?";

        if($(this).data('text') != ''){
            text = $(this).data('text')
        }

        if($(this).data('title') != ''){
            title = "Hare Krishna"; //pass your desire message
        }

        if(typeof dataId != 'undefined' && typeof dataUrl != 'undefined'){
            swal({
                title: title,
                text: text,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: true,
            }, function (isConfirm) {
                if (!isConfirm) return;
                $.ajax({
                    url: dataUrl,
                    type: 'POST',
                    dataType: 'json',
                    data:{id:dataId},
                    success:function(response){
                        if(response.status == 'success'){
                            toastr.success(response.msg);

                            setTimeout(function(){
                                window.location.reload(true);
                            },1000)
                        }else{
                            toastr.error(response.msg);
                        }
                    }
                });
            });
          
        }
    });
});