<x-layouts.app>
@slot('title')
    Job Portal | Candidate Register
@endslot
    <section class="section-5">
        <div class="container my-5">
            <div class="py-lg-2">&nbsp;</div>
            <div class="row d-flex justify-content-center">
                <div class="col-md-5">
                    <div class="card shadow border-0 p-5">
                        <h1 class="h3 text-center">Candidate Register</h1>
                        <form action="{{route('handle_register_request')}}" method="post" id="registerUser">
                            @csrf
                            <div class="mb-3">
                                <label for="" class="mb-2">Name*</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name">
                                <input type="hidden" name="user_type" value="candidate">
                            </div> 
                            <div class="mb-3">
                                <label for="" class="mb-2">Email*</label>
                                <input type="text" name="email" id="email" class="form-control" placeholder="Enter Email">
                            </div> 
                            <div class="mb-3">
                                <label for="" class="mb-2">Username*</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Enter Username">
                            </div>
                            <div class="mb-3">
                                <label for="" class="mb-2">Mobile*</label>
                                <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Enter mobile number">
                            </div> 
                            <div class="mb-3">
                                <label for="" class="mb-2">Designation*</label>
                                <input type="text" name="designation" id="designation" class="form-control" placeholder="Enter designation">
                            </div>   
                            <div class="mb-3">
                                <label for="" class="mb-2">Password*</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password">
                            </div> 
                            <div class="mb-3">
                                <label for="" class="mb-2">Confirm Password*</label>
                                <input type="password" name="cpassword" id="cpassword" class="form-control" placeholder="Enter Confirm Password">
                            </div> 
                            <button class="btn btn-primary mt-2" type="submit">Register</button>
                        </form>                    
                    </div>
                    <div class="mt-4 text-center">
                        <p>Have an account? <a  href="login.html">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
