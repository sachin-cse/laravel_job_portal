<x-layouts.app>
    @slot('title')
        Job Details | {{$get_job_details->job_title??''}}
    @endslot

    <section class="section-4 bg-2">    
        <div class="container pt-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{route('job_apply','find-jobs')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i> &nbsp;Back to Jobs</a></li>
                        </ol>
                    </nav>
                </div>
            </div> 
        </div>
        <div class="container job_details_area">
            <div class="row pb-5">
                <div class="col-md-8">
                    <div class="card shadow border-0">
                        <div class="job_details_header">
                            <div class="single_jobs white-bg d-flex justify-content-between">
                                <div class="jobs_left d-flex align-items-center">
                                    
                                    <div class="jobs_conetent">
                                        <a href="javascript:void(0);">
                                            <h4>{{$get_job_details->job_title??''}}</h4>
                                        </a>
                                        <div class="links_locat d-flex align-items-center">
                                            <div class="location">
                                                <p> 
                                                    <i class="fa fa-map-marker">
                                                    </i> {{$get_job_details->job_location??''}}, India</p>
                                            </div>
                                            <div class="location">
                                                <p> <i class="fa fa-clock-o"></i> {{$get_job_details->job_type??''}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="jobs_right">
                                    <div class="apply_now">
                                        <a class="heart_mark" href="javascript:void(0);"> <i class="fa fa-heart-o" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {!! $get_job_details->job_description??'' !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow border-0">
                        <div class="job_sumary">
                            <div class="summery_header pb-1 pt-4">
                                <h3>Job Summery</h3>
                            </div>
                            <div class="job_content pt-3">
                                <ul>
                                    <li>Published on: <span>{{date('jS,M Y',strtotime($get_job_details->job_created_at??""))}}</span></li>
                                    <li>Vacancy: <span>{{$get_job_details->job_vacany??''}} Position</span></li>
                                    <li>Salary: <span>{{$get_job_details->job_package??''}}</span></li>
                                    <li>Location: <span>{{$get_job_details->job_package??''}}</span></li>
                                    <li>Job Nature: <span> {{$get_job_details->job_type??''}}</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow border-0 my-4">
                        <div class="job_sumary">
                            <div class="summery_header pb-1 pt-4">
                                <h3>Company Details</h3>
                            </div>
                            <div class="job_content pt-3">
                                <ul>
                                    <li>Name: <span>{{$get_job_details->company_name??''}}</span></li>
                                    <li>Locaion: <span>{{$get_job_details->job_location??''}}</span></li>
                                    <li>Webite: <span>{{$get_job_details->company_website??''}}</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>