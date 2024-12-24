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

            $jobs = $jobApply->with('savedJobs')->get();

            $returnHTML = view('job_apply',compact('jobs'))->render();// or method that you prefere to return data + RENDER is the key here
            
            return response()->json( array('success' => true, 'html'=>$returnHTML) );
        }
    }
}
