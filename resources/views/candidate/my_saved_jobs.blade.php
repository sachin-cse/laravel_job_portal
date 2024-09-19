<x-layouts.app>
    @slot('title')
        Job Portal | My Saved Jobs
    @endslot

    <section class="section-5 bg-2">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item active">My Saved Jobs</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">

                {{-- profile section --}}
                @include('candidate.my_profile')

                {{-- saved jobs section --}}
                <div class="col-lg-9">
                    <div class="card border-0 shadow mb-4 p-3">
                        <div class="card-body card-form">
                            <h3 class="fs-4 mb-1">Saved Jobs</h3>
                            <div class="table-responsive">
                                <table class="table ">
                                    <thead class="bg-light">
                                        <tr>
                                            <th scope="col">Title</th>
                                            <th scope="col">Job Created</th>
                                            <th scope="col">Job Short Description</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="border-0">
                                        @if($savedJobs->count() > 0)
                                            @foreach($savedJobs as $value)
                                                <tr class="active">
                                                    <td>
                                                        <div class="job-name fw-500">{{$value->job_name??''}}</div>
                                                        <div class="info1">{{$value->jobs->job_type??''}} . {{$value->jobs->job_location??''}}</div>
                                                    </td>
                                                    {{-- <td>05 Jun, 2023</td> --}}
                                                    <td>{{date('d M, Y h:i a', strtotime($value->jobs->job_created_at??''))}}</td>
                                                    <td>{{$value->jobs->job_short_description??''}}</td>

                                                    @if($value->jobs->job_status == '1')
                                                        <td>
                                                            <div class="job-status text-capitalize">Active</div>
                                                        </td>
                                                        @elseif($value->jobs->job_status == '2')
                                                        <td>
                                                            <div class="job-status text-capitalize">Pending</div>
                                                        </td>
                                                        @elseif($value->jobs->job_status == '3')
                                                        <td>
                                                            <div class="job-status text-capitalize">Expired</div>
                                                        </td>
                                                    @endif
                                                    <td>
                                                        <div class="action-dots float-end">
                                                            <a href="#" class="" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                            </a>
                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                <li><a class="dropdown-item" href="javascript:void(0)"> <i class="fa fa-eye" aria-hidden="true"></i> View</a></li>
                                                                <li><a class="dropdown-item send_ajax_response" data-url="{{route('handle_my_saved_jobs',['action_type'=>'delete'])}}" data-id="{{$value->id}}" href="javascript:void(0)"><i class="fa fa-trash" aria-hidden="true"></i> Remove</a></li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                                {{-- <tr class="pending">
                                                    <td>
                                                        <div class="job-name fw-500".html Developer</div>
                                                        <div class="info1">Part-time . Delhi</div>
                                                    </td>
                                                    <td>13 Aug, 2023</td>
                                                    <td>20 Applications</td>
                                                    <td>
                                                        <div class="job-status text-capitalize">pending</div>
                                                    </td>
                                                    <td>
                                                        <div class="action-dots float-end">
                                                            <a href="#" class="" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                            </a>
                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                <li><a class="dropdown-item" href="job-detail.html"> <i class="fa fa-eye" aria-hidden="true"></i> View</a></li>
                                                                <li><a class="dropdown-item" href="#"><i class="fa fa-trash" aria-hidden="true"></i> Remove</a></li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="expired">
                                                    <td>
                                                        <div class="job-name fw-500">Full Stack Developer</div>
                                                        <div class="info1">Fulltime . Noida</div>
                                                    </td>
                                                    <td>27 Sep, 2023</td>
                                                    <td>278 Applications</td>
                                                    <td>
                                                        <div class="job-status text-capitalize">expired</div>
                                                    </td>
                                                    <td>
                                                        <div class="action-dots float-end">
                                                            <a href="#" class="" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                            </a>
                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                <li><a class="dropdown-item" href="job-detail.html"> <i class="fa fa-eye" aria-hidden="true"></i> View</a></li>
                                                                <li><a class="dropdown-item" href="#"><i class="fa fa-trash" aria-hidden="true"></i> Remove</a></li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="active">
                                                    <td>
                                                        <div class="job-name fw-500">Developer for IT company</div>
                                                        <div class="info1">Fulltime . Goa</div>
                                                    </td>
                                                    <td>14 Feb, 2023</td>
                                                    <td>70 Applications</td>
                                                    <td>
                                                        <div class="job-status text-capitalize">active</div>
                                                    </td>
                                                    <td>
                                                        <div class="action-dots float-end">
                                                            <a href="#" class="" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                            </a>
                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                <li><a class="dropdown-item" href="job-detail.html"> <i class="fa fa-eye" aria-hidden="true"></i> View</a></li>
                                                                <li><a class="dropdown-item" href="#"><i class="fa fa-trash" aria-hidden="true"></i> Remove</a></li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr> --}}
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>