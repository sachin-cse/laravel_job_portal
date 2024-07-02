<?php

namespace App\Http\Controllers\Candidate;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rules\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CandidateConrtoller extends Controller
{
    public function __construct(User $user){
        $this->user = $user;
    }
    //profile update request
    public function handleUpdaterequest(Request $request, $action_type){
        if($request->method() == 'POST' && $request->ajax()){
            switch($action_type){
                case 'change-profile-image':
                    $rules = [
                        'image'=>'required|mimes:jpg,png,jpeg|max:1024'
                    ];
                break;
            }
            $validator = \Validator::make($request->all(), $rules, [
                'image.required'=>'Please upload your profile image',
                'image.mimes'=>"Please upload only jpeg,jpg and png file",
                'image.max'=>"Profile photo size not more than 1MB"
            ]);
            try{
                if($validator->fails()){
                    throw new Exception($validator->errors()->first());
                }

                if($action_type == 'change-profile-image'){
                    $file = $request->file('image');
                    $profileName = $file->getClientOriginalName();
                    $filename = \Auth::user()->id.'_'.$profileName;
                    $file->move('assets/candidate_profile/', $filename);

                    // create a thumbnail image
                    $manager = new ImageManager(Driver::class);
                    $image = $manager->read(public_path('assets/candidate_profile/'.$filename));
                    $image->cover(150,150);
                    $image->toPng()->save(public_path('assets/candidate_profile/thumb_profile/'.$filename));

                    // delete old profile
                    \File::delete(public_path('assets/candidate_profile/'.\Auth::user()->profile_photo_path));
                    \File::delete(public_path('assets/candidate_profile/thumb_profile/'.\Auth::user()->profile_photo_path));

                    $this->user->where('id', \Auth::user()->id)->update(['profile_photo_path'=>$filename]);
                    return response()->json(
                    ['status'=>200, 'message'=>"profile photo updated successfully"]
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
}
