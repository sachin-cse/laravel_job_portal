<x-layouts.app>

    @slot('title')
        CareerVibe | Forgot Password
    @endslot
        <section class="section-5">
            <div class="container my-5">
                <div class="py-lg-2">&nbsp;</div>
                <div class="row d-flex justify-content-center">
                    <div class="col-md-5">
                        <div class="card shadow border-0 p-5">
                            <h1 class="h3">Forgot Password</h1>
                            <form action="javascript:void(0);" method="post" id="forgot_password_request">
                                @csrf
                                <div class="mb-3">
                                    <label for="" class="mb-2">Email*</label>
                                    <input type="text" name="email" id="email" class="form-control validate[required,custom[email]]" placeholder="Enter Your Registered Email">
                                </div> 
                                <div class="justify-content-between d-flex show_loader">
                                    <button type="submit" data-url="{{route('send_reset_link')}}" class="btn btn-primary mt-2 forgot-password">Reset Password</button>
                                </div>
                            </form>                    
                        </div>
                        <div class="mt-4 text-center">
                            <p>if have an account? <a  href="{{route('login_view')}}" class="">Login</a></p>
                        </div>
                    </div>
                </div>
                <div class="py-lg-5">&nbsp;</div>
            </div>
        </section>
    </x-layouts.app>