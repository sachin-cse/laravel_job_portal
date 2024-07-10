<x-layouts.app>

@slot('title')
    Job Portal | {{ucfirst(Auth::user()->type)}} Dashboard
@endslot

<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
                        <li class="breadcrumb-item active">Account Settings</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <div class="card border-0 shadow mb-4 p-3">
                    <div class="s-body text-center mt-3">
                        
                        <img src="{{\Auth::user()->profile_photo_path ? asset('assets/candidate_profile/thumb_profile/'.\Auth::user()->profile_thumb_image):asset('assets/candidate_profile/profile_image.jpg')}}" alt="avatar"  class="rounded-circle img-fluid" style="width: 150px;">
                        <h5 class="mt-3 pb-0">{{ucfirst(Auth::user()->name)}}</h5>
                        <p class="text-muted mb-1 fs-6">{{ucfirst(Auth::user()->designation)}}</p>
                        <div class="d-flex justify-content-center mb-2">
                            <button data-bs-toggle="modal" data-bs-target="#exampleModal" type="button" class="btn btn-primary">Change Profile Picture</button>
                        </div>
                    </div>
                </div>
                <div class="card account-nav border-0 shadow mb-4 mb-lg-0">
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush ">
                            <li class="list-group-item d-flex justify-content-between p-3">
                                <a href="account.html">Account Settings</a>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                <a href="post-job.html">Post a Job</a>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                <a href="my-jobs.html">My Jobs</a>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                <a href="job-applied.html">Jobs Applied</a>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                <a href="saved-jobs.html">Saved Jobs</a>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                <a href="javascript:void(0);" data-url="{{route('handle_logout_request')}}" class="logoutUser">Logout</a>
                            </li>                                                                                                               
                        </ul>
                    </div>
                </div>
            </div>
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