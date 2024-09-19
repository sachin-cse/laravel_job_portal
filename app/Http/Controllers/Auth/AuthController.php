<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct(User $user){
        $this->user = $user;
    }
    //register view
    public function index(Request $request, $user_type){
        // dd($request->method());
        if(view()->exists($user_type.'.register')){
            return view($user_type.'.register');
        }
        throw new Exception($user_type.'.register does not exist');
    }

    // login view
    public function login_view(Request $request){
        return view('frontend.login');
    }

    // handle register request
    public function handleRegisterrequest(Request $request){
        if($request->method() == 'POST' && $request->ajax()){
            switch($request->user_type){
                case 'candidate':
                    $rules = [
                        'name'=>'required|regex:/^[a-zA-Z ]+$/u',
                        'email'=>'required|email|unique:users,email',
                        'username'=>'required|regex:/^(?=.*[0-9])[a-zA-Z0-9@]+$/u|unique:users,username',
                        'mobile'=>'required|numeric|digits_between:10,15|unique:users,mobile',
                        'designation'=>'required',
                        'password'=>'required|max:8',
                        'cpassword'=>'required|same:password'
                    ];
                    break;

                    case 'employee':
                        $rules = [
                            'name'=>'required|regex:/^[a-zA-Z ]+$/u',
                            'email'=>'required|email|unique:users,email',
                            'username'=>'required|regex:/^(?=.*[0-9])[a-zA-Z0-9@]+$/u|unique:users,username',
                            'mobile'=>'required|numeric|digits_between:10,15|unique:users,mobile',
                            'designation'=>'required',
                            'company_name' => 'required',
                            'password'=>'required|max:8',
                            'cpassword'=>'required|same:password'
                        ];
                        break;

            }

            try{
                $validator = Validator::make($request->all(), $rules, [
                    'name.required'=>'Please enter your name',
                    'name.regex'=>'Please enter your valid name',
                    'email.required'=>'Please enter your email address',
                    'email.email'=>'Please enter your valid email address',
                    'email.unique'=>'This email has already taken',
                    'mobile.required'=>'Please enter your mobile number',
                    'mobile.numeric'=>'Please enter your valid mobile number',
                    'mobile.digits_between'=>'Mobile number must be 10 to 15 characters long',
                    'mobile.unique'=>'This mobile number has already taken',
                    'username.required'=>'Please enter your username',
                    'username.regex'=>'Username must be alphanumeric',
                    'username.unique'=>'This username has already taken',
                    'designation.required'=>'Please enter your designation',
                    'company_name.required'=>'Please enter your company name',
                    'password.required'=>'Please enter your password',
                    'password.max'=>'Password maximum 8 characters long',
                    'cpassword.required'=>'Please enter your confirm  password',
                    'cpassword.same'=>'Password and confirm password did not match'
                ]);

                if($validator->fails()){
                    throw new Exception($validator->errors()->first());
                }
                $request->merge(['type'=>$request->user_type]);
                $user = new User;
                $user->fill($request->all());
                if($user->saveOrFail()){
                    return response()->json(['status'=> 201, 'message'=>'Registration successfully', 'redirectUrl'=>route('login_view')]);
                }
            } catch(Exception $e){
                // dd($e);
                return response()->json(['status'=> 200,'flag'=>'error', 'message'=>$e->getMessage()]);
            }
        }
    }

    // handle login request
    public function handleLoginrequest(Request $request){
        $rules = [
            'emailorusername'=>'required',
            'password'=>'required',
        ];

        $validator = Validator::make($request->all(), $rules, [
            'emailorusername.required'=>'Please enter your email or username',
            'password.required'=>'Please enter your password',
        ]);

        try{
            if($validator->fails()){
                throw new \Exception($validator->errors()->first());
            }
            // $credential && Hash::check($request->get('password'), $credential->password) && Auth::loginUsingId($credential->id)
            $credential = $this->user->where('email', $request->emailorusername)->orWhere('username',$request->emailorusername)->first();
            if($credential && Hash::check($request->get('password'), $credential->password) && Auth::loginUsingId($credential->id)){
                return response()->json([
                    'status'=>200,
                    'message'=>'You have logged in successfully',
                    'redirectUrl'=>route('user_dashboard')
                ]);
            }else{
                return response()->json([
                    'status'=>200,
                    'flag'=>'error',
                    'message'=>'Invalid credentials',
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'status'=>200,
                'flag'=>'error',
                'message'=>$e->getMessage(),
            ]);
        }
    }



    // logout user
    public function handleLogoutrequest(Request $request){
        try{
            Auth::logout();
                return response()->json([
                    'status' => 200,
                    'message' => 'User logout successfully',
                    'returnUrl'=>route('login_view')
                ]);
            
        }
        catch(Exception $e){
            return response()->json([
                'status' => 200,
                'flag'=>'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
