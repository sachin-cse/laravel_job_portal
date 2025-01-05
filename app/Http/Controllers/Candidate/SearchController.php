<?php

namespace App\Http\Controllers\Candidate;

use ModelFactory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    //handle search request
    public function handleSearchRequest(Request $request){

        if($request->ajax() && $request->method() == 'POST'){
            // import model
            $jobApply = ModelFactory::getModels('JobApply');

            $jobs = $jobApply->with('savedJobs')->orderBy('job_created_at',$request->order)->get();

            $returnHTML = view('filter_jobs.job_apply_filter',compact('jobs'))->render();

            return sendAjaxRequest('success',null ,null,$returnHTML);
        }
    }
}
