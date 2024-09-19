$(document).ready(function(){
    $(document).on('click', '.send_ajax_response', function(){
        var dataId = $(this).data('id');
        var dataUrl = $(this).data('url');
        
        if(typeof dataId != 'undefined' && typeof dataUrl != 'undefined'){
            $.ajax({
                url: dataUrl,
                type: 'POST',
                dataType: 'json',
                data:{id:dataId},
                success:function(response){
                    console.log(response);
                }
            });
        }
    });
});