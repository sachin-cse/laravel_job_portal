<x-layouts.app>

    @slot('title')
        CareerVibe | Reset Password
    @endslot
        <section class="section-5">
            <div class="container my-5">
                <div class="py-lg-2">&nbsp;</div>
                <div class="row d-flex justify-content-center">
                    <div class="col-md-5">
                        <div class="card shadow border-0 p-5">
                            <h1 class="h3">Reset Password</h1>
                            <form action="javascript:void(0);" method="post" id="reset_password_request">
                                @csrf

                                <div class="mb-3">
                                    <label for="" class="mb-2">New Password<span class="text-danger">*</span></label>
                                    <input type="text" name="new_password" id="new_password" class="form-control" placeholder="New Password">
                                </div> 

                                <div class="mb-3">
                                    <label for="" class="mb-2">Confirm Password<span class="text-danger">*</span></label>
                                    <input type="text" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm Password">
                                </div>

                                <div class="justify-content-between d-flex show_loader">
                                    <a href="javascript:void(0);" data-url="{{route('handle_reset_password',$token)}}" class="btn btn-primary mt-2 reset-password">Reset Password</a>
                                </div>

                            </form>                    
                        </div>
                    </div>
                </div>
                <div class="py-lg-5">&nbsp;</div>
            </div>
        </section>
    </x-layouts.app>