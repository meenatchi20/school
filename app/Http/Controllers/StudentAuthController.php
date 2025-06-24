<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RoleUser;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\CommonService;
use App\Http\Requests\StudentAuthRequest;
use App\Http\Requests\studentLoginRequest;

class StudentAuthController extends Controller
{
        //Login Page
        public function showLoginPage()
        {
            return view('auth.login');
        }

        //SignUp Page
        public function signUpPage()
        {
            return view('auth.signup');
        }

        //SignUp Process
        public function signUpCreate(StudentAuthRequest $request,CommonService $signUp){
            $datas = $request->validated();
            $data = $signUp->signUpCreate($datas);
            return redirect()->route('user.login')->with('success','signUp Successfully');
        }

        //Login Process
        public function processLogin(studentLoginRequest $request,CommonService $login){
        

            $data = $request->validated();
            $loginData = $login->login($data);
             
            if(Auth::attempt($loginData)){
                return redirect()->route('student.list')->with('success','login Successfully');
            }else {
              return back()->withErrors([
                        'user_name' => 'please enter valid UserName',
                        'user_password' => 'please enter valid Password',
                    ]);
            }
        }

        //Logout
       public function logout(){
            Auth::logout();
            return redirect()->route('user.login');
       }
}
