<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreTempStudentdata;
use App\Models\User;
use App\Models\Student;
use App\Models\StudentTempData;
use App\Models\ApprovedStudents;
use App\Services\CommonService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Access\AuthorizationException;

class TempStudentDataController extends Controller
{
            //Temp Student Table
            public function tempStudentStore(StoreTempStudentdata $request, CommonService $storeTemp){
                try{
                    // Log::info('request data:', $request->all()); log
                    $data = $request->validated(); 
                    $students = Student::where('email', $data['email'])->first();
                    if($students){
                        $data['action'] = 'edit';
                        $data['student_id'] = $students->id;
                    }else{
                        $data['action'] = 'add';
                    }

                    $user = auth()->user();
                    $data['maker_by'] = $user->role->role; // current user Role
                    $data['maker_at'] = now(); 
                   // Log::info('Data passed to storeTempData:', $data);
                    $saveData = $storeTemp->storeTempData($data);
                    if($saveData) {
                            return response()->json([
                                'success' => true,
                                'message' => 'student Data added successfully',
                                'data' => $saveData,                               
                            ]);
                        }
                        else{
                            return response()->json([
                                'success' => false,
                                'error'=> 'something wrong'
                             ]);
                        } 
              }
              catch(AuthorizationException $e){
                    return response()->json([
                        'success' => false,
                        'message' => 'You are not authorized to Create this student.'
                    ], 403);
                }
            }

            //TempStudent Maker List
            public function toDoList(CommonService $todoList){
                $data = $todoList->toDoListData();
                if($data){
                    return response()->json([
                        'success' => true,
                        'data' => $data
                    ]);
                }else {
                    return response()->json([
                                'success' => false,
                                'error'=> 'something wrong'
                             ]);
                }
            }

            
}
