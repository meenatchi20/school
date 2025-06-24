<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Mail;
use App\Services\CommonService;
use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;


class ForgetPasswordController extends Controller
      {
        //Forget Form Page
        public function ForgetPasswordForm() {
            return view('auth.forget_password_form');
        }

        //store email,token in password Reset Table
        public function ForgetPasswordFormSubmit(ForgetPasswordRequest $request, CommonService $ForgetPassword){

            $data = $request->validated();
            $forgetPassword = $ForgetPassword->ForgetPasswordFormSubmit($data);
            return back()->with('success','we have shared a reset password link  to email');
        }

        //Reset Password Form
        public function resetPasswordForm($token) {
            return view('auth.reset_password_form',['token' => $token]);
        }

        //Reset Password Process
        public function resetPasswordFormSubmit(ResetPasswordRequest $request, CommonService $resetPassword){
               $data = $request->validated();
               $data['token'] = $request->route('token');
               $resetPassword = $resetPassword->resetPasswordFormSubmit($data); 
               if(!$resetPassword)  { 
                return redirect()->back()->with('error', 'Invalid or expired token.');
               }
               return redirect()->route('user.login')->with('success','your password changed');

             }


              //Api-Reset Password Form
        public function apiResetPasswordForm($token) {
            return view('auth.api_resetPassword_form',['token' => $token]);
        }


        

}
