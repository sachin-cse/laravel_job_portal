<?php

namespace App\Http\Controllers\Job;

use App\Models\JobApply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JobdetailsController extends Controller
{
    //view file
    public function jobDetails(Request $request,$job_slug){
        // get job details
        $get_job_details = JobApply::where(['job_slug' => $job_slug,'job_status'=>1])->first();
        return view('job_details.job_details',compact('get_job_details'));
    }
}
