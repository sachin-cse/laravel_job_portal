<x-layouts.app>

@slot('title')
    Job Portal | My Account
@endslot

<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item active">Account Settings</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">

            {{-- profile section --}}
            @include('candidate.my_profile')
            {{-- end profile section --}}
            
            <div class="col-lg-9">
                <div class="card border-0 shadow mb-4">
                    <div class="card-body  p-4">
                        <h3 class="fs-4 mb-1">My Profile</h3>
                        <form action="{{route('handle_profile_update_request','update-profile')}}" method="post" id="updateProfile">
                                @csrf
                            <input type="hidden" value="{{\Auth::user()->id??0}}" name="canId">
                            <div class="mb-4">
                                <label for="" class="mb-2">Name*</label>
                                <input type="text" placeholder="Enter Name" name="name" class="form-control" value="{{\Auth::user()->name??''}}">
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Email*</label>
                                <input type="text" placeholder="Enter Email" value="{{\Auth::user()->email??''}}" class="form-control" {{\Auth::user()->email ? 'readonly':''}}>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Designation*</label>
                                <input type="text" placeholder="Designation" name="designation" class="form-control" value="{{\Auth::user()->designation??''}}">
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Mobile*</label>
                                <input type="text" placeholder="Mobile" name="mobile" class="form-control" value="{{\Auth::user()->mobile??''}}">
                            </div>
                            <div class="d-flex justify-content show_loader">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div> 
                        </form>                       
                    </div>
                </div>

                <div class="card border-0 shadow mb-4">
                    <div class="card-body p-4">
                        <h3 class="fs-4 mb-1">Change Password</h3>
                        <form action="{{route('handle_profile_update_request','change-password')}}" method="post" id="changePassword">
                                @csrf
                            <div class="mb-4">
                                <label for="" class="mb-2">Current Password*</label>
                                <input type="password" placeholder="Old Password" class="form-control" name="old_password" value="{{old('old_password')}}">
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">New Password*</label>
                                <input type="password" placeholder="New Password" class="form-control" name="new_password">
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Confirm Password*</label>
                                <input type="password" placeholder="Confirm Password" class="form-control" name="confirm_password">
                            </div> 
                            <div class="d-flex justify-content show_loader">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>                       
                    </div>
                </div>                
            </div>
        </div>
    </div>
</section>

</x-layouts.app>