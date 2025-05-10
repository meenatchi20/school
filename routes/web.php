<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentAuthController;
// use App\Http\Controllers\DepartmentController;

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
        });

 Route::controller(StudentAuthController::class)
        ->prefix('signup')
        ->as('')
        ->group(function () {
            Route::get('login','showLoginPage')->middleware('guest')->name('user.login');
            Route::get('page','signUpPage')->middleware('guest')->name('user.signup');
            Route::post('process','signUpCreate')->name('signup.process');
            Route::post('handleLogin','processLogin')->name('authprocess.process');
            Route::get('logout','logout')->middleware('auth')->name('user.logout');
        });     

        // Route::controller(DepartmentController::class)
        // ->prefix('department')
        // ->as('')
        // ->group(function () {
        //     //Route::get('create', 'create')->name('department.create');
        //     Route::POST('store', 'store')->name('department.store');
        // });