<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class StudentAuthController extends Controller
{
    public function showLoginPage()
    {
        return view('auth.login');
    }

    public function signUpPage()
    {
        return view('auth.signup');
    }

    public function signUpCreate(Request $request){
        $request->validate([
            'name' => 'required',
            'mobileNo' => 'required|unique:users,mobileNo|numeric',
            'email' => 'required|unique:users,email|email',
            'password' =>'required|confirmed|min:5|max:15'
        ]);

        $data = $request->all();
        $userLogin = new User();
        $userLogin->name = $data['name'];
        $userLogin->mobileNo = $data['mobileNo'];
        $userLogin->email = $data['email'];
        $userLogin->password = Hash::make($data['password']);

        $userLogin->save();

        return redirect()->route('user.login')->with('success','signUp Successfully');
    }

    public function processLogin(Request $request)
    {
       // try{
        $request->validate([
        'user_name' => 'required',
        'user_password' =>'required|min:5|max:15'
         ]);

       $data = [
        'name' => $request->user_name,
        'password' => $request->user_password
       ];

       
        if(Auth::attempt($data)){
            return redirect()->route('student.list');
        }else {
            echo "hii";
        }
    }
    // catch(Exception $e){
    //     echo $e->getMessage();
    // }

  
   // }


   public function logout(){
        Auth::logout();
        return redirect()->route('user.login');
   }
}
