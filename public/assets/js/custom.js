$(document).ready(function(){
    var lazyLoadInstance = new LazyLoad({elements_selector:"img.lazy, video.lazy, div.lazy, section.lazy, header.lazy, footer.lazy,iframe.lazy"});

    $(document).on('click', '.user_type_model', function(){
        $('#registerModel').modal('show');
    });

    // toastr option
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "2500",
      };

    $.validator.addMethod(
        "regex",
        function(value, element, regexp) {
          var re = new RegExp(regexp);
          return this.optional(element) || re.test(value);
        }
    );

    $('#registerUser').validate({
        rules:{
            name:{
                required:true,
                regex:'^[a-zA-Z ]+$'
            },
            email:{
                required:true,
                email:true,
            },
            username:{
                required:true,
                regex:'^(?=.*[0-9])[a-zA-Z0-9@]+$'
            },
            mobile:{
                required:true,
                regex:'^[0-9]+$',
                minlength:10,
                maxlength:15,
            },
            designation:{
                required:true,
            },
            company_name:{
                required:$('#hidden_user').val() == 'employee'?true:false 
            },
            password:{
                required:true,
                minlength: 8,
                maxlength: 8
            },
            cpassword:{
                required:true
            }
        },
        messages:{
            name:{
                required:"Please enter your first name",
                regex:"Please enter your valid name"
            },
            email:{
                required:"Please enter your email address",
                email:"Please enter a valid email address"
            },
            username:{
                required:"Please enter your username",
                regex:"Username must be alphanumeric",
            },
            mobile:{
                required:"Please enter your mobile number",
                regex:"Please enter your valid mobile number",
                minlength:"mobile number at least {0} characters long",
                maxlength:"mobile number at most {0} characters long",
            },
            designation:{
                required:"Please enter your designation",
            },
            company_name:{
                required:"Please enter your company name",
            },
            password:{
                required:"Please enter your password",
                minlength:"Please enter at least {0} characters long",
                maxlength:"Please enter maximum {0} characters long"
            },
            cpassword:{
                required:"Please enter your confirm password"
            }
        },
        submitHandler: function(form) {
            $('.show_loader').find('button').replaceWith('<button class="btn btn-primary mt-2" type="submit">Register<i class="fa fa-spinner fa-spin" style="font-size:24px"></i></button>');
            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                success: function(response) {
                    console.log(response);
                    if(response.status==201 && response.flag !== 'error'){
                        toastr.success(response.message);
                        setTimeout(function() {
                            window.location.href = response.redirectUrl;
                        }, 1000);
                    } else{
                        toastr.error(response.message);
                    }
                },
                complete:function(){
                    $('.show_loader').find('button').replaceWith('<button class="btn btn-primary mt-2" type="submit">Register</button>');
                }           
            });
        }
    });

    // login request
    $('#loginRequest').validate({
        rules:{
            emailorusername:{
                required:true
            },
            password:{
                required:true
            }
        },
        messages:{
            emailorusername:{
                required:"Please enter your email or username"
            },
            password:{
                required:"Please enter your password",
            }
        },
        submitHandler: function(form) {
            $('.show_loader').find('button').replaceWith('<button class="btn btn-primary mt-2" type="submit">Login <i class="fa fa-spinner fa-spin" style="font-size:24px"></i></button>');
            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                beforeSend: function(){
                    $
                },
                success: function(response) {
                    console.log(response);
                    if((response.status==200) && response.flag !== 'error'){
                        toastr.success(response.message);
                        setTimeout(function() {
                            window.location.href=response.redirectUrl;
                        }, 1000);
                    } else{
                        toastr.error(response.message);
                    }
                },
                complete:function(){
                    $('.show_loader').find('button').replaceWith('<button class="btn btn-primary mt-2" type="submit">Login</button>');
                }           
            });
        }
    });

    // logout user
    $('.logoutUser').on('click', function(e){   
        e.preventDefault();
        var Url = $(this).attr('data-url');
        $.ajax({
            url: Url,
            type: 'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(response){
                // alert(JSON.stringify(response));
                if((response.status == 200) && response.error !== 'error'){
                    toastr.success(response.message);
                    setTimeout(function() {
                        window.location.href = response.returnUrl;
                    }, 2000);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr, textStatus, errorThrown) {
                toastr.error('Error: ' + errorThrown);
            }
        });
    });

    // candidate change profile image
    $.validator.addMethod('extension', function (value, element, param) {
        var files = element.files;
        if(files && files.length > 0){
            var filename = files[0].name;

            if(filename && filename.length > 0){
                var lastdot = filename.lastIndexOf('.');
                var ext = filename.substring(lastdot + 1);
                if($.inArray(ext, ['jpg', 'png', 'jpeg']) != -1){
                    return true;
                } else{
                    return false;
                }
            }
        }
        return true;
    });

    $('#updateProfileImage').validate({
        rules:{
            image:{
                required:true,
                extension:true
            }
        },
        messages:{
            image:{
                required:"Please upload your profile image",
                extension: "allowed file extension only jpg, jpeg and png format",
            }
        },
        submitHandler: function(form) {
            var formData = new FormData(form);
            $.ajax({
                url: form.action,
                type: form.method,
                contentType: 'multipart/form-data',
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                beforeSend:function(){
                    $('.show_loader').find('.loading').replaceWith('<button class="btn btn-primary mx-3" type="submit">Update<i class="fa fa-spinner fa-spin" style="font-size:24px"></i></button>');
                },
                success: function(response) {
                    // alert(JSON.stringify(response));
                    if((response.status==200) && response.flag !== 'error'){
                        toastr.success(response.message);
                        setTimeout(function(){
                            window.location.reload(true);
                            $('.show_loader').find('.loading').replaceWith('<button class="btn btn-primary mx-3 fff" type="submit">Update</button>');
                        },1000)
                    } else {
                        toastr.error(response.message);
                        $('.show_loader').find('.loading').replaceWith('<button class="btn btn-primary mx-3 ggg" type="submit">Update</button>');
                    }
                },
                complete:function(){
                    $('.show_loader').find('.loading').replaceWith('<button class="btn btn-primary mx-3" type="submit">Update</button>');
                }           
            });
        }
    });

    // update candidate data
    $('#updateProfile').validate({
        rules:{
            name:{
                required:true,
                regex:'^[a-zA-Z ]+$'
            },
            designation:{
                required:true,
            },
            mobile:{
                required:true,
                regex:'^[0-9]+$',
                minlength:10,
                maxlength:15,
            }
        },
        messages:{
            name:{
                required:"Please enter your name",
                regex:"Please enter your valid name"
            },
            mobile:{
                required:"Please enter your mobile number",
                regex:"Please enter your valid mobile number",
                minlength:"mobile number at least {0} characters long",
                maxlength:"mobile number at most {0} characters long",
            },
            designation:{
                required:"Please enter your designation",
            }
        },
        submitHandler: function(form) {
            $('.show_loader').find('button').replaceWith('<button class="btn btn-primary mx-3" type="submit">Update <i class="fa fa-spinner fa-spin" style="font-size:24px"></i></button>');
            $.ajax({
                url: form.action,
                type: form.method,
                dataType:'json',
                data: $('form').serialize(),
                success: function(response) {
                    // alert(JSON.stringify(response));
                    if((response.status==200) && response.flag !== 'error'){
                        toastr.success(response.message);
                        setTimeout(function(){
                            window.location.reload(true);
                        },1000)
                    } else {
                        toastr.error(response.message);
                    }
                },
                complete:function(){
                    $('.show_loader').find('button').replaceWith('<button class="btn btn-primary mx-3" type="submit">Update</button>');
                }           
            });
        }
    });

    // candidate change password
    $('#changePassword').validate({
        rules:{
            old_password:{
                required:true,
            },
            new_password:{
                required:true,
                minlength: 8,
                maxlength: 8
            },
            confirm_password:{
                required:true,
            }
        },
        messages:{
            old_password:{
                required:"Please enter your old password",
            },
            new_password:{
                required:"Please enter your new password",
                minlength:"Please enter at least {0} characters long",
                maxlength:"Please enter maximum {0} characters long"
            },
            confirm_password:{
                required:"Please enter your confirm password",
            }
        },
        submitHandler: function(form) {
            $('.show_loader').find('button').replaceWith('<button class="btn btn-primary" type="submit">Update <i class="fa fa-spinner fa-spin" style="font-size:24px"></i></button>');
            $.ajax({
                url: form.action,
                type: form.method,
                dataType:'json',
                data: $('form').serialize(),
                success: function(response) {
                    // alert(JSON.stringify(response));
                    if((response.status==200) && response.flag !== 'error'){
                        toastr.success(response.message);
                        setTimeout(function(){
                            window.location.reload(true);
                        },1000)
                    } else {
                        toastr.error(response.message);
                    }
                },
                complete:function(){
                    $('.show_loader').find('button').replaceWith('<button class="btn btn-primary" type="submit">Update</button>');
                }           
            });
        }
    });

    // add to favorite job
    $(document).on('click','.add-to-favorite i',function(){
        if($(this).hasClass('fa fa-heart-o') || $(this).hasClass('fa fa-heart')){
            var data_id = $(this).attr('data-id');
            var data_url = $(this).attr('data-url');
            var parentId = $(this).parent().attr('id');
            $.ajax({
                type: 'POST',
                url: data_url,
                headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                dataType: 'json',
                data:{id:data_id},
                beforeSend: function(){
                    $("#overlay").fadeIn(300);　
                },
                success:function(response){
                    if(response.status == 200){
                        $('#'+parentId).addClass('check').find('i').removeClass('fa-heart-o').addClass('fa-heart');
                        toastr.success(response.message);
                    }else if(response.status == 403){
                        toastr.error(response.message);
                    }else if(response.status == 'info'){
                        toastr.info(response.message);
                    }else{
                        toastr.error(response.message);
                    }
                },

                complete: function(){
                    setTimeout(function(){
                        $("#overlay").fadeOut(300);
                    },150);
                },
            });
        }
    });

    // delete by id using ajax
});



