<?php

namespace App\Http\Controllers\Auth;

use DB;
use Mail;
use Cookie;
use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\ForgotPasswordMail;
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
                    return response()->json(['status'=> 201, 'message'=>__('messages.register.success'), 'redirectUrl'=>route('login_view')]);
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

                // set remember me cookie
                if($request->has('remember_me')){
                    \Cookie::queue('remember_emailorusername', $request->emailorusername);
                    \Cookie::queue('remember_password', $request->get('password'));
                }else{
                    \Cookie::queue(\Cookie::forget('remember_emailorusername'));
                    \Cookie::queue(\Cookie::forget('remember_password'));
                }
                
                return response()->json([
                    'status'=>200,
                    'message'=>__('messages.login.success'),
                    'redirectUrl'=>route('user_dashboard')
                ]);
            }else{
                return response()->json([
                    'status'=>200,
                    'flag'=>'error',
                    'message'=>__('messages.login.error'),
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
                    'message' => __('messages.logout.success'),
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

    // handle forgot password request
    public function forgotPasswordView(Request $request){
        return view('frontend.forgot_password');
    }

    // handle change password request
    public function handleForgotPassword(Request $request){
        if($request->ajax() && $request->method() == 'POST'){
            $data = $request->all(); //get data from request

            // check email registered or not
            try{
                $checkEmailExistance = $this->user->where(['email'=>$data['email']??''])->count();

                if($checkEmailExistance <= 0){
                    return sendAjaxRequest('error', __('messages.forgotpassword.emailExist'));
                }else{

                    // default time set
                    date_default_timezone_set('Asia/Kolkata');

                    // generate token
                    $token = (bin2hex(random_bytes(5)));
                    Mail::to($data['email'])->send(new ForgotPasswordMail([
                       'token' => $token]));

                    \DB::table('password_reset_tokens')->insert(
                        ['email' => $data['email'], 'token' => $token, 'generated_at'=>date("Y-m-d h:i:s")]
                    );

                    return sendAjaxRequest('success', 'Reset Link send your registered email address', route('login_view'));
                }
            }
            catch(Exception $e){
                return sendAjaxRequest('error', $e->getMessage());
            }
        }
    }

    // reset link view
    public function resetLinkView(Request $request, $token){
        return view('frontend.reset_password',compact('token'));
    }

    // handle reset password 
    public function handleResetPassword(Request $request, $token){
        
        $rules = [
            'new_password'=>'required|min:8|max:16',
            'confirm_password' => 'required|same:new_password',
        ];

        $validate = Validator::make($request->all(), $rules, [
            'new_password.required'=>'Please enter your new password',
            'new_password.min'=>'Password must be minimum 8 character long',
            'new_password.max'=>'Password must be maximum 16 character long',
        ]);


        if($validate->fails()){
            return sendAjaxRequest('error',$validate->errors()->first());
        }

        try{
            // check token exist or not
            if(!empty($token)){
                $checkToken = DB::table('password_reset_tokens')->where(['token'=>$token])->exists();
                if($checkToken){


                    // default time set
                    date_default_timezone_set('Asia/Kolkata');

                    $getToken = DB::table('password_reset_tokens')->where(['token'=>$token])->first();

                    // check token time
                    $getTime = date('h:i:s', strtotime($getToken->generated_at.'+2 hours'));

                    $getCurrentTime = date('h:i:s', time());

                    if($getTime >= $getCurrentTime){
                        // reset password
                        $this->user->where(['email'=>$getToken->email??''])->update([
                            'password'=>Hash::make($request->new_password)
                        ]);

                        // reset password token blank 
                        DB::table('password_reset_tokens')->where(['token'=>$token])->update([
                            'token'=>NULL,
                        ]);

                        return sendAjaxRequest('success', 'Password reset successfully', route('login_view'));
                    }else{
                        return sendAjaxRequest('error', 'Reset link has been expired');
                    }

                }else{
                    return sendAjaxRequest('error', 'Token does not exist');
                }
            }
        }catch(Exception $e){
            return sendAjaxRequest('error', $e->getMessage());
        }
    }
}
