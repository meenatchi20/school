<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentAuthController;
use App\Http\Controllers\MailController;
use App\Mail\ContactMail;
use App\Http\Controllers\ForgetPasswordController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});




Route::controller(StudentController::class)

        ->prefix('student')
        ->as('')
        ->middleware(['auth'])
        ->group(function () {
            Route::get('create', 'create')->name('student.create');
            Route::POST('store', 'store')->name('student.store');
            Route::get('list','index')->name('student.list');
            Route::get('edit/{id}','edit')->name('student.edit');
            Route::put('update/{id}','update')->name('student.update');
            Route::DELETE('delete/{id}','destroy')->name('student.delete');
            Route::GET('search','searchField')->name('search');
            // Route::get('downloadpdf','downloadPdf')->name('pdfdownload');
            Route::get('downloadexcel','studentExcelExport')->name('exceldownload');

            // Route::POST('implodeMarkExcel','ImportStudentMark')->name('implodeexcel');
             Route::POST('implodeexcel','ImportStudentData')->name('implodeStudentData');

             Route::get('exportResult', 'ExportStatus')->name('exportResult');
             Route::get('studentMark', 'studentmarkData')->name('studentmark');

             //Email Send 
               Route::get('contactpage','showForm')->name('showForm');
               Route::POST('contact','send')->name('send.email');
        });

 Route::controller(StudentAuthController::class)
        ->prefix('signup')
        ->as('')
        ->group(function () {
            Route::get('login','showLoginPage')->middleware('guest')->name('user.login');
            Route::post('handleLogin','processLogin')->name('authprocess.process');
            Route::get('page','signUpPage')->middleware('guest')->name('user.signup');
            Route::post('process','signUpCreate')->name('signup.process');
            Route::get('logout','logout')->middleware('auth')->name('user.logout');
        });     

   

  //forget Password
  Route::GET('forgetpassword',[ForgetPasswordController::class,'ForgetPasswordForm'])->name('forget.password');
  Route::POST('forgetpassword',[ForgetPasswordController::class,'ForgetPasswordFormSubmit'])->name('forgetpassword');

  //reset Password
  Route::GET('resetpassword/{token}',[ForgetPasswordController::class,'resetPasswordForm'])->name('reset.password');
  Route::POST('resetpassword/{token}',[ForgetPasswordController::class,'resetPasswordFormSubmit'])->name('submitresetpassword');





  //Api-LoginPage
  Route::get('apilogin', function () {
    return view('api_studentdata.api_login');
  });

  //Api-StudentList
  Route::get('apistudentlist', function () {
    return view('api_studentdata.api_studentlist');
  });

  //Api-SignUp
 Route::get('apisignup', function () {
    return view('api_studentdata.api_signup');
  })->name('signup');


//Api-Add Student
 Route::get('addstudent', function () {
    return view('api_studentdata.api_addstudent_data');
  });

//Api-ForgetPassword
  Route::get('apiforgetpassword', function () {
    return view('api_studentdata.api_forgetpassword');
  });

//Api-Reset Password
Route::get('apiresetpassword/{token}', function ($token) {
    return view('api_studentdata.api_resetPassword', ['token' => $token]);
})->name('api-resetpassword');


//Api-Edit Student
 Route::get('apiedit/{id}', function () {
    return view('api_studentdata.api_edit_studentdata');
  });

 //Api-StudentMark
  Route::get('apistudentmark', function () {
    return view('api_studentdata.api_studentmark');
  });


//Api- ContactPage Email
  Route::get('apicontactmail',function(){
    return view('api_studentdata.api_contactmail');
  });

  //Api- Menu Page
  Route::get('apimenu',function(){
    return view('api_studentdata.api_menuform');
  });

//Api- Menu Page
  Route::get('apirole',function(){
    return view('api_studentdata.api_roleform');
  });

//Api- Menu Page
  Route::get('assignpermission',function(){
    return view('api_studentdata.role_assign_permission');
  });

  // Api - Menu List page
  Route::get('menulist',function(){
    return view('api_studentdata.api_menulist');
  });

  //Api - Edit Menu
   Route::get('editmenu/{id}',function(){
    return view('api_studentdata.api_edit_menu');
  });

// Api - Role List page
  Route::get('rolelist',function(){
    return view('api_studentdata.api_role_list');
  });

  //Api - Edit Role
  Route::get('editrole/{id}',function(){
    return view('api_studentdata.api_edit_role');
  });

  //ToDo List
   Route::get('todolist',function(){
    return view('api_studentdata.api_todo_list');
  });

 //Approved List
   Route::get('approved/list',function(){
    return view('api_studentdata.approved_student_list');
  });