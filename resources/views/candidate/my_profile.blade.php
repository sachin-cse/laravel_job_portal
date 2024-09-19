<div class="col-lg-3">
    <div class="card border-0 shadow mb-4 p-3">
        <div class="s-body text-center mt-3">
            
            <img src="{{\Auth::user()->profile_photo_path ? asset('assets/profile_image/thumb_profile/'.\Auth::user()->profile_thumb_image):asset('assets/profile_image/profile_image.jpg')}}" alt="avatar"  class="rounded-circle img-fluid" style="width: 150px;">
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
                    <a href="{{route('user_dashboard')}}">Account Settings</a>
                </li>

                @if(\Auth::check() && \Auth::user()->type != 'candidate')
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                    <a href="post-job.html">Post a Job</a>
                </li>
                @endif

                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                    <a href="my-jobs.html">My Jobs</a>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                    <a href="job-applied.html">Jobs Applied</a>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                    <a href="{{route('my_saved_jobs')}}">Saved Jobs</a>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                    <a href="javascript:void(0);" data-url="{{route('handle_logout_request')}}" class="logoutUser">Logout</a>
                </li>                                                                                                               
            </ul>
        </div>
    </div>
</div>