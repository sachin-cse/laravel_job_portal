<!DOCTYPE html>
<html class="no-js" lang="en_AU" />
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>{{$title??''}}</title>
	<meta name="description" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1, user-scalable=no" />
	<meta name="csrf-token" content="{{csrf_token()}}" />
	<meta name="HandheldFriendly" content="True" />
	<meta name="pinterest" content="nopin" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
	<link rel="stylesheet" href="{{asset('assets/plugins/validate_engine/css/validationEngine.jquery.css')}}" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}" />

    <link rel="stylesheet" href={{asset('assets/css/toastr.min.css')}}>
	<!-- Fav Icon -->
	<link rel="shortcut icon" type="image/x-icon" href="#" />
</head>
<body data-instant-intensity="mousedown">
	<div id="overlay">
		<div class="cv-spinner">
		  <span class="spinner"></span>
		</div>
	</div>
<header>
	<nav class="navbar navbar-expand-lg navbar-light bg-white shadow py-3">
		<div class="container">
			<a class="navbar-brand" href="{{url('/')}}">CareerVibe</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav ms-0 ms-sm-0 me-auto mb-2 mb-lg-0 ms-lg-4">
					<li class="nav-item">
						<a class="nav-link" aria-current="page" href="{{url('/')}}">Home</a>
					</li>	
					<li class="nav-item">
						<a class="nav-link" aria-current="page" href="{{route('job_apply','find-jobs')}}">Find Jobs</a>
					</li>
					
					<li class="nav-item">
						<a class="nav-link" aria-current="page" href="{{route('user_dashboard')}}">My Profile</a>
					</li>
				</ul>

				
				@if(!\Auth::check())				
				<a class="btn btn-outline-primary me-2" href="{{route('login_view')}}" type="submit">Login</a>
				@else
				<a class="btn btn-outline-primary me-2" href="javascript:void(0);">Hi, {{\Auth::user()->name}}</a>
				@endif

				@php
				$url = !\Auth::check() ? route('login_view'):((\Auth::user()->type??'') == 'candidate' ? route('job_apply','job-apply'):'javascript:void(0);')
				@endphp
				<a class="btn btn-primary" href="{{$url}}" type="submit">{{(\Auth::user()->type??'') == 'candidate' ? 'Apply Job':'Post a Job'}}</a>
			</div>
		</div>
	</nav>
</header>

<main>
    {{ $slot }}
</main>

{{-- register pop up model --}}
<div class="modal fade" id="registerModel" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title pb-0" id="registerModalLabel">Choose User Type</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body d-flex justify-content-center">
			<a class="btn btn-primary mx-2" href="{{route('register', 'candidate')}}">Candidate</a> 
			<a class="btn btn-primary mx-2" href="{{route('register', 'employee')}}">Employee</a>
        </div>
    </div>
    </div>
</div>

{{-- change profile image --}}
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title pb-0" id="exampleModalLabel">Change Profile Picture</h5>
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body">
		  <form action="{{route('handle_profile_update_request','change-profile-image')}}" method="post" id="updateProfileImage">
			@csrf
			  <div class="mb-3">
				  <label for="exampleInputEmail1" class="form-label">Profile Image</label>
				  <input type="file" class="form-control" id="image"  name="image">
			  </div>
			  <div class="d-flex justify-content-end show_loader">
				  <button type="submit" class="btn btn-primary mx-3 loading">Update</button>
				  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			  </div>
			  
		  </form>
		</div>
	  </div>
	</div>
  </div>

<footer class="bg-dark py-3 bg-2">
    <div class="container">
    <p class="text-center text-white pt-3 fw-bold fs-6">© 2023 xyz company, all right reserved</p>
    </div>
</footer> 
<script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.bundle.5.1.3.min.js')}}"></script>
<script src="{{asset('assets/js/toastr.min.js')}}"></script>
<script src="{{asset('assets/js/instantpages.5.1.0.min.js')}}"></script>
<script src="{{asset('assets/js/lazyload.17.6.0.min.js')}}"></script>
<script src="{{asset('assets/js/slick.min.js')}}"></script>
<script src="{{asset('assets/js/lightbox.min.js')}}"></script>
<script src="{{asset('assets/js/sweetAlert.js')}}"></script>
<script src="{{asset('assets/plugins/validate_engine/js/jquery.validationEngine-en.js')}}" type="text/javascript" charset="utf-8"></script>
<script src="{{asset('assets/plugins/validate_engine/js/jquery.validationEngine.js')}}" type="text/javascript" charset="utf-8"></script>
<script src="{{asset('assets/js/common.js')}}"></script>
<script src="{{asset('assets/js/custom.js')}}"></script>
<script>
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]'). attr('content') } });
</script>
</body>
</html>