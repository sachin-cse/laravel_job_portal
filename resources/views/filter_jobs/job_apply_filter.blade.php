@if($jobs->count() > 0)
    @foreach($jobs as $value)
        <div class="col-md-4">
            <div class="card border-0 p-3 shadow">
                <div class="card-body">
                    <div class="title-wrap">
                        <h3 class="border-0 fs-5 pb-2 mb-0">{{$value->job_title??''}}</h3>

                        @if($value->savedJobs->count() > 0)
                            @foreach($value->savedJobs as $getFlag)
                                @if(($getFlag->flag??0) == '1' && \Auth::user()->id == ($getFlag->user_id??0))
                                    <span class="add-to-favorite check"><i class="fa fa-heart" data-id="{{$value->id}}" data-url="{{route('saved_job')}}"></i>
                                    </span>
                                    @else
                                    <span class="add-to-favorite" id="savejob_{{$value->id}}">
                                        <i class="fa fa-heart-o" data-id="{{$value->id}}" data-url="{{route('saved_job')}}"></i>
                                    </span>
                                @endif
                            @endforeach
                        @else
                                <span class="add-to-favorite" id="savejob_{{$value->id}}">
                                    <i class="fa fa-heart-o" data-id="{{$value->id}}" data-url="{{route('saved_job')}}"></i>
                                </span>
                        @endif
                    </div>
                    <div class="card-content">
                        <p>{{$value->job_short_description??''}}</p>
                        <div class="bg-light p-3 border">
                            <p class="mb-0">
                                <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                                <span class="ps-1">{{$value->job_location??''}}</span>
                            </p>
                            <p class="mb-0">
                                <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                <span class="ps-1">{{$value->job_mode??''}}</span>
                            </p>
                            <p class="mb-0">
                                <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                                <span class="ps-1">{{$value->job_package??''}}</span>
                            </p>
                        </div>

                        <div class="d-grid mt-3">
                            <div class="d-flex justify-content-between">
                                <a href="javascript:void(0);" class="btn btn-success btn-lg">Apply Job</a>
                                <a href="{{route('job_details',$value->job_slug)}}" class="btn btn-primary btn-lg">Job Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif