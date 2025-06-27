<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\StudentTempData;
use App\Models\ApprovedStudents;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Services\CommonService;
use Mail;

class ApprovalRejecetController extends Controller
{
    //Approved Student data
    public function approve($id, CommonService $studentData){
        $user = auth()->user();
        $tempStudent = $studentData->StudentTempData($id);
        
        if (!$tempStudent) {
            return response()->json([
                'success' => false,
                'message' => 'Temp student not found.'
            ], 404);
        }

        if($tempStudent->status === 'Approved'){
            return response()->json([
                'success'=>false,
                'message' => 'This student has already been approved.'
            ],400);
        }
        
        
        $student = $studentData->storeStudentData($tempStudent);
        $approvedStudent = $studentData->approvedStudentStore($tempStudent,$user);

        if (!$approvedStudent) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to store approved student.'
            ], 500);
        }

         // Update temp data status to 'approved'
            $tempStudent->status = 'approved';
            $tempStudent->save();

        // $tempStudent->delete(); 
         return response()->json([
            'success' => true,
            'message' => 'Student approved and saved to main table.',
            'student' => $approvedStudent,
            'user' => $user->email
        ]);
    }


        //reject Student data
        public function reject($id, CommonService $studentTempData)
        {
            $user = auth()->user();
            $userMail = $user->email;

            $response = $studentTempData->rejectStudentById($id, $userMail);

            return response()->json([
                'success' => $response['success'],
                'message' => $response['message']
            ], $response['status']);
        }


        //Show Approved Details for UI
        public function approvedStudent(CommonService $stuentData){
             $student = $stuentData->approvedStudentData();
             if($student){
                return response()->json([
                    'success' => true,
                    'data' => $student
                ]);
             }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Not Found In Student Details'
                ]);
             }
        }

}
