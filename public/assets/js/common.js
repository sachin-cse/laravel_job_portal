$(document).ready(function(){
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
});