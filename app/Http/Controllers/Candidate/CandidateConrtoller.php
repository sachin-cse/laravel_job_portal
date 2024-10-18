<?php

namespace App\Http\Controllers\Candidate;

use Exception;
use TypeError;
use App\Models\User;
use App\Models\JobApply;
use App\Models\SaveJobs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManager;
use Illuminate\Validation\Rules\File;
use Intervention\Image\Drivers\Gd\Driver;

class CandidateConrtoller extends Controller
{
    public function __construct(User $user, JobApply $JobApply, SaveJobs $SaveJobs){
        $this->user = $user;
        $this->jobApply = $JobApply;
        $this->SaveJobs = $SaveJobs;
    }
    //profile update request
    public function handleUpdaterequest(Request $request, $action_type){
        // dd($action_type);
        if($request->method() == 'POST' && $request->ajax()){
            switch($action_type){
                case 'change-profile-image':
                    $rules = [
                        'image'=>'required|mimes:jpg,png,jpeg|max:1024'
                    ];
                break;
                case 'update-profile':
                    $rules = [
                        'name'=>'required|regex:/^[a-zA-Z ]+$/u',
                        'mobile'=>'required|numeric|digits_between:10,15|unique:users,mobile,'.$request->canId.',id,deleted_at,NULL',
                        'designation'=>'required',
                        // 'password'=>'required|max:8',
                        // 'cpassword'=>'required|same:password'
                    ];
                break;

                case 'change-password':
                    $rules = [
                        'old_password'=>'required',
                        'new_password'=>'required|max:8',
                        'confirm_password'=>'required|same:new_password'
                    ];
                break;
            }
            $validator = \Validator::make($request->all(), $rules, [
                'image.required'=>'Please upload your profile image',
                'image.mimes'=>"Please upload only jpeg,jpg and png file",
                'image.max'=>"Profile photo size not more than 1MB",
                'name.required'=>'Please enter your name',
                'name.regex'=>'Please enter your valid name',
                'mobile.required'=>'Please enter your mobile number',
                'mobile.numeric'=>'Please enter your valid mobile number',
                'mobile.digits_between'=>'Mobile number must be 10 to 15 characters long',
                'mobile.unique'=>'This mobile number has already taken',
                'designation.required'=>'Please enter your designation',
                'old_password.required'=>'Please enter your old password',
                'new_password.required'=>'Please enter your new password',
                'new_password.max'=>'Password maximum 8 characters long',
                'confirm_password.required'=>'Please confirm your password',
                'confirm_password.same'=>'Confirm password must be same as your new password',
            ]);
            try{
                if($validator->fails()){
                    throw new Exception($validator->errors()->first());
                }

                if($action_type == 'change-profile-image'){
                    $file = $request->file('image');
                    $profileName = $file->getClientOriginalName();
                    $filename = \Auth::user()->id.'_'.$profileName;
                    $file->move('assets/profile_image/', $filename);

                    // create a thumbnail image
                    $manager = new ImageManager(Driver::class);
                    $image = $manager->read(public_path('assets/profile_image/'.$filename));
                    $image->cover(150,150);
                    $image->toPng()->save(public_path('assets/profile_image/thumb_profile/'.$filename));

                   $profileThumbimage = explode('.', $filename);

                    // delete old profile
                    \File::delete(public_path('assets/profile_image/'.\Auth::user()->profile_photo_path));
                    \File::delete(public_path('assets/profile_image/thumb_profile/'.\Auth::user()->profile_photo_path));

                    $this->user->where('id', \Auth::user()->id)->update(['profile_photo_path'=>$filename]);
                    $this->user->where('id', \Auth::user()->id)->update(['profile_thumb_image'=>$profileThumbimage[0].'.png']);
                    return response()->json(
                    ['status'=>200, 'message'=>"profile photo updated successfully"]
                    );
                }
                if($action_type == "update-profile"){
                    $this->user->where('id', \Auth::user()->id)->update(['name'=>$request->name, 'mobile'=>$request->mobile, 'designation'=>$request->designation]);    
                    return response()->json(
                        ['status'=>200, 'message'=>"profile updated successfully"]
                    );
                }

                if($action_type == "change-password"){
                    if(!Hash::check($request->old_password, \Auth::user()->password)){
                        throw new Exception("Current Password is invalid");
                    }

                    if(strcmp($request->input('old_password'), $request->new_password) == 0){
                        throw new Exception("New Password cannot be same as your current password");
                    }

                    $this->user->where('id', \Auth::user()->id)->update(['password'=>Hash::make($request->new_password)]);
                    return response()->json(
                        ['status'=>200, 'message'=>"Password updated successfully"]
                    );
                }
            }
            catch(Exception $e){
                return response()->json(
                    ['status'=>200, 'flag'=>'error', 'message'=>$e->getMessage()]
                );
            }
        }
    }

    // apply job
    public function jobApply(Request $request){
        $getJobsData = $this->jobApply->with('savedJobs')->get();
        return view('job_apply',['jobs'=>$getJobsData??'']);
    }

    // saved job
    public function savedJob(Request $request){
        if(\Auth::check()){

            // check job save or not
            $checkExist = $this->SaveJobs->where(['job_id'=>$request->id])->exists();

            if($checkExist){
                return response()->json(['status'=>'info', 'message'=>'This Job already in your favorites list']);
            }
            //get job details
            $getDetails = $this->jobApply->where(['id'=> $request->id, 'job_status'=>1])->first();

            $data = [
                'job_id'=>$request->id,
                'job_name'=>$getDetails->job_title,
                'job_description'=>$getDetails->job_short_description,
                'user_id'=>\Auth::user()->id,
                'flag'=>'1'
            ];
             // insert data in saved job
            $saveWishdata = $this->SaveJobs;
            $saveWishdata->fill($data);

            try{
                if($saveWishdata->save()){
                    return response()->json(['status'=>'200', 'message'=>'Job saved successfully']);
                }
            }catch(Exception $e){
                    return response()->json(['status'=>'404', 'message'=>$e->getMessage()]);
            }


        }else{
            return response()->json(['status'=>'403', 'message'=>'Please login first']);
        }
    }

    // my saved jobs
    public function MySavedJobs(Request $request){
        $savedJobs = $this->SaveJobs->with('jobs')->get();
        return view('candidate.my_saved_jobs', compact('savedJobs'));
    }

    // handle saved jobs request
    public function handleMySavedJobRequest(Request $request, $action_type){
       if($request->method() && $request->ajax()){
            $data = $request->all();
            // dd($data);
            if($action_type == 'delete'){
                try{

                    if($data['id'] > 0){
                        $delete_save_jobs = $this->SaveJobs->find($data['id']);
                        $delete_save_jobs->delete();
                        return sendAjaxRequest('success', 'Data deleted successfully');
                    }else{
                        throw new Exception('id does not exist');
                    }
                }
                catch(Exception $e){
                    return sendAjaxRequest('error', $e->getMessage());
                }
            }

            if($action_type == 'view-details'){
                $get_details = $this->SaveJobs->with('jobs')->where(['id'=>$data['id']])->first();
                return sendAjaxRequest($get_details);
            }
       }
    }
}
