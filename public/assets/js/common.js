$(document).ready(function(){
    
    // get session variable
    if($('#session_messages').val() != ''){

        if($('#session_messages').attr('data-msg-type') == 'error'){
            toastr.error($('#session_messages').val());
        }else if($('#session_messages').attr('data-msg-type') == 'success'){
            toastr.success($('#session_messages').val());
        }else if($('#session_messages').attr('data-msg-type') == 'warning'){
            toastr.warning($('#session_messages').val());
        }else if($('#session_messages').attr('data-msg-type') == 'info'){
            toastr.info($('#session_messages').val());
        }

    }
    
    // end session message
    $(document).on('click', '.delete_details', function(){
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
            Swal.fire({
                title: title,
                text: text,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: true,
            }).then((result) => {
                if (result.isConfirmed) {
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
                }
            });
          
        }
    });

    // show details
    $(document).on('click', '.show_details', function(){
        var dataId = $(this).attr('data-id');
        var dataUrl = $(this).attr('data-url');

        var dataTitle = $(this).attr('data-title');

        if(dataId != '' && dataUrl != ''){
            $('#modal-body').html('');
            $.ajax({
                url: dataUrl,
                type: 'POST',
                dataType: 'json',
                data:{id:dataId},
                success:function(response){
                    console.log(response.status);
                    if(response.status != null){
                        $('#modal-body').append(`
                            <p>Company Name:${response.status.jobs.company_name}</p>
                            <p>Job Title:${response.status.jobs.job_title}</p>
                            <p>Job Location:${response.status.jobs.job_location}</p>
                            <p>Job Mode:${response.status.jobs.job_mode}</p>
                            <p>Job Package:${response.status.jobs.job_package}</p>
                            <p>Job Type:${response.status.jobs.job_type}</p>

                            ${response.status.jobs.job_experience != null ? `<p>Job Experience:${response.status.jobs.job_experience}</p>`:''}

                            ${response.status.jobs.job_technologies != null ? `<p>Job Technologies:${response.status.jobs.job_technologies}</p>`:''}

                            ${response.status.jobs.job_description != null ? `<p>Job Type:${response.status.jobs.job_type}</p>`:''}
                            ${response.status.jobs.job_end_time != null ? `<h4>Job End Date:${response.status.jobs.job_end_time}</h4>`:''}

                            ${response.status.jobs.job_end_time != null ? `<p>Job Notice Period:${response.status.jobs.job_notice_period}</p>`:''}

                        `)
                    }

                    $('#open_modal').modal('show');
                }
            });
        }
    });

    // forgot password
    $(document).on('click','.forgot-password',function(){
        // get dynamic form id
        var getformId = $(this).parents().find('form').attr('id');
        $("#"+getformId).validationEngine({
            onValidationComplete: function (form, valid) {
                if (valid) {
                    var email = $('#email').val(); //get users email    
                    var dataUrl = $(this).attr('data-url');
                    if(email != ''){
                        $.ajax({
                            url: dataUrl,
                            type: 'POST',
                            dataType: 'json',
                            data:{email:email},
                            success:function(response){
                                if(response.status == 'success'){
                                    toastr.success(response.msg);
                                }else{
                                    toastr.error(response.msg);
                                }
                            }
                        });
                    }
                }
            }
        });
    });

    // reset password
    $(document).on('click','.reset-password',function(){

        var new_password = $('#new_password').val();  //get new password
        var confirm_password = $('#confirm_password').val();


        var dataUrl = $(this).attr('data-url');
        
            $.ajax({
                url: dataUrl,
                type: 'POST',
                dataType: 'json',
                data:{new_password:new_password,confirm_password:confirm_password},
                success:function(response){
                    if(response.status == 'success'){
                        toastr.success(response.msg);
                        setTimeout(function(){
                            window.location.href = response.redirectUrl
                        },1000)
                    }else{
                        toastr.error(response.msg);
                    }
                }
            });
        
    });
});