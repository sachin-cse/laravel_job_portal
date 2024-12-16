<x-layouts.app>

@slot('title')
    CareerVibe | login
@endslot

{{-- session messages --}}
@foreach(array_keys(\Session::all()) as $key)
    @if(in_array($key,['error','success','warning','info']))
    <input type="hidden" value = "{{\Session::get($key??'')}}" id="session_messages" data-msg-type="{{$key??''}}">
    @endif
@endforeach
    <section class="section-5">
        <div class="container my-5">
            <div class="py-lg-2">&nbsp;</div>
            <div class="row d-flex justify-content-center">
                <div class="col-md-5">
                    <div class="card shadow border-0 p-5">
                        <h1 class="h3">Login</h1>
                        <form action="{{route('handle_login_request')}}" method="post" id="loginRequest">
                            @csrf
                            <div class="mb-3">
                                <label for="" class="mb-2">Email*</label>
                                <input type="text" name="emailorusername" id="emailorusername" class="form-control" placeholder="Email or Username">
                            </div> 
                            <div class="mb-3">
                                <label for="" class="mb-2">Password*</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password">
                            </div> 
                            <div class="justify-content-between d-flex show_loader">
                            <button class="btn btn-primary mt-2" type="submit">Login</button>
                                <a href="{{route('forgot_password')}}" class="mt-3">Forgot Password?</a>
                            </div>
                        </form>                    
                    </div>
                    <div class="mt-4 text-center">
                        <p>Do not have an account? <a  href="javascript:void(0);" class="user_type_model">Register</a></p>
                    </div>
                </div>
            </div>
            <div class="py-lg-5">&nbsp;</div>
        </div>
    </section>
</x-layouts.app>
