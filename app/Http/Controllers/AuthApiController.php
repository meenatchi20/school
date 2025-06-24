<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Mail;
use App\Http\Requests\StudentAuthRequest;
use App\Http\Requests\studentLoginRequest;
use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Services\CommonService;


class AuthApiController extends Controller
{
            //Login 
            public function login(studentLoginRequest $request,CommonService $login){
                $data = $request->validated();
                $loginData = $login->login($data);
                if(!Auth::attempt($loginData)){
                    return response([
                        'error'=> 'Invalid Details'
                    ]);
                }

                $token = auth()->user()->createToken('ApiToken')->accessToken;
               
                    return response()->json([
                        'message'=> 'login successfully',
                        'data' => auth()->user(),
                        'token' => $token
                    ]);
             
                }

            //SignUp
            public function signUpCreate(StudentAuthRequest $request,CommonService $signUp){
                $datas = $request->validated();
                $data = $signUp->signUpCreate($datas);
                if($data){
                return response()->json([
                    'success' => true,
                    'message' => 'signup successfully',
                    'data' => $data
                    ]);
                }
                else {
                    return response([
                        'success' => false,
                        'error'=> 'something wrong'
                    ]);
                }
            }

            //Logout 
            public function logout(Request $request){
               $request->user()->token()->revoke();

                return response()->json([
                    'success' => true,
                    'message' => 'User logged out successfully.'
                ]);
            }  

        //ForgetPassword  API
        public function apiForgetPasswordFormSubmit(ForgetPasswordRequest $request, CommonService $ForgetPassword){

            $data = $request->validated();
            $ForgetPassword = $ForgetPassword->apiForgetPasswordFormSubmit($data);
           if($ForgetPassword){
                return response()->json([
                    'success' => true,
                    'message' => 'we have shared a reset password link to email',
                ]);
            }else{
                return response()->json([
                    'success' =>false,
                    'message' => 'The Request Not Send Please try again',
                ]);
            } 
            
        }

            public function resetPasswordFormSubmit(ResetPasswordRequest $request, CommonService $resetPassword){
               $data = $request->validated();
               $data['token'] = $request->token;
               $reset_password =  $resetPassword->resetPasswordFormSubmit($data);    
               if($reset_password){
                return response()->json([
                        'success' => true,
                        'message' => "reset password successfully"
                ]);
             }else{
                 return response()->json([
                        'success' => false,
                        'message' => "something Error! please Try Again"
                ]);
             }

           }

}
