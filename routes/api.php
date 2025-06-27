<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentApiController;
use App\Http\Controllers\AuthApiController;
use App\Http\Controllers\ApiRoleController;
use App\Http\Controllers\ApiMenuController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\ApprovalRejecetController;
use App\Http\Controllers\TempStudentDataController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


	// Route::Post('/register',[StudentAuthController::class,'signUpCreate']);
	// Route::Post('/login',[StudentAuthController::class,'processLogin']);
	// //Route::Post('/register',[StudentAuthController::class,'signUpCreate']);



Route::middleware('auth:api')->group(function () {

  Route::get('list',[StudentApiController::class,'index'])->name('student.list');
  Route::POST('store',[StudentApiController::class,'store'])->name('student.store');
  Route::get('edit/{id}',[StudentApiController::class,'edit'])->name('student.edit');
  Route::put('update/{id}',[StudentApiController::class,'update'])->name('student.update');
  Route::DELETE('delete/{id}',[StudentApiController::class,'destroy'])->name('student.delete');
  Route::GET('search',[StudentApiController::class,'searchField'])->name('search');
  Route::get('export',[StudentApiController::class,'studentExcelExport'])->name('exceldownload');
  Route::get('exportResult', [StudentApiController::class,'ExportStatus'])->name('exportResult');
  Route::get('studentMark', [StudentApiController::class,'studentmarkData'])->name('studentmark');
  Route::POST('implodeexceldata',[StudentApiController::class,'ImportStudentData'])->name('implodeStudentData');
  Route::POST('importexcelmark',[StudentApiController::class,'ImportStudentMark'])->name('implodeStudentData');
  Route::get('/export/{id}', [StudentApiController::class, 'downloadExportedStudentData']);
  Route::post('sendemail',[StudentApiController::class, 'send']);

  Route::get('mark', [StudentApiController::class,'mark'])->name('mark');

   Route::POST('tempstore',[TempStudentDataController::class,'tempStudentStore']);
   Route::get('todoList',[TempStudentDataController::class,'toDoList']);
   Route::post('/students/approve/{id}', [ApprovalRejecetController::class, 'approve']);
   Route::post('/students/reject/{id}', [ApprovalRejecetController::class, 'reject']);
   Route::GET('approvedstudent',[ApprovalRejecetController::class, 'approvedStudent']);

});

 Route::post('signup',[AuthApiController::class,'signUpCreate']);
 Route::post('login',[AuthApiController::class,'login']);
 Route::post('logout',[AuthApiController::class,'logout'])->middleware('auth:api')->name('user.logout');

//ForgetPassword
 Route::post('forgetpassword',[AuthApiController::class,'apiForgetPasswordFormSubmit']);
 Route::post('resetpassword',[AuthApiController::class,'resetPasswordFormSubmit']);

//Api For Roles
 
 //Route::POST('create/role',[ApiRoleController::class, 'create']);
 



//permission assing By SuperAdmin
    Route::middleware(['auth:api'])->group(function () {
      //Menu
      Route::GET('list/menu',[ApiMenuController::class, 'index']);
      Route::POST('create/menu',[ApiMenuController::class, 'create']);
      Route::get('edit/menu/{id}',[ApiMenuController::class, 'edit']);
      Route::PUT('update/menu/{id}',[ApiMenuController::class, 'update']);
      Route::DELETE('delete/menu/{id}',[ApiMenuController::class, 'delete']);
      Route::GET('show/menu/{id}',[ApiMenuController::class, 'show']);

      //Role      
      Route::POST('create/role',[ApiRoleController::class, 'create']);
      Route::GET('list/role',[ApiRoleController::class, 'index']);
      Route::get('edit/role/{id}',[ApiRoleController::class, 'edit']);
      Route::PUT('update/role/{id}',[ApiRoleController::class, 'update']);
      Route::DELETE('delete/role/{id}',[ApiRoleController::class, 'delete']);
      Route::GET('show/role/{id}',[ApiRoleController::class, 'show']);

      Route::post('/assign', [RolePermissionController::class, 'assignPermission']);
      Route::DELETE('/deletepermission/{id}', [RolePermissionController::class, 'deletePermission']);

      
});