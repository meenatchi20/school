<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\StudentAuthRequest;
use App\Http\Requests\studentLoginRequest;
use App\Http\Requests\ImportStudentRequest;
use App\Http\Requests\MailRequest;

use App\Models\Student;
use App\Models\User;
use App\Models\Menu;
use App\Models\studentExportJob;

use App\Services\CommonService;
use App\Http\Resources\StudentResource;
use App\Http\Policy\MenuPolicy;

use PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\AuthorizationException;

class StudentApiController extends Controller
{
            //Show Student List
            public function index(Request $request,Student $student,CommonService $studentData)
            {
                 $auth = $this->authorize('viewAny', Student::class);
                 $user = auth()->user();
                 $students = $studentData->getAllStudentData();
                    if($students){
                        return response()->json([
                            'data' =>  StudentResource::collection($students),
                            'meta' =>[
                                'current_page' => $students->currentPage(),
                                'last_page'  => $students->lastPage(),
                                'per_page'  => $students->perPage()
                             ],
                             'message' => $auth,
                             'permission' => [
                                'delete'  => $user->can('delete',new Student()),
                                'create' =>  $user->can('create',Student::class),
                                'update' =>  $user->can('update',new Student()),
                                'mail' =>  $user->can('sendMail',Student::class),
                                'pdf' =>  $user->can('pdfDownload',Student::class),
                                'importData' =>  $user->can('studentDataImport',Student::class),
                                'importMark' =>  $user->can('markImport',Student::class),
                                'excelExport' => $user->can('ExcelExport',Student::class),
                                'sendMail' => $user->can('sendMail',Student::class),
                                'user' => $user->role->role
                               ] 

                        ]);
                       

                    }
                    else{
                        return response()->json([
                            'success' => false,
                            'error'=> 'something wrong'
                         ]);
                    }
            }

            //Store STudent Data 
            public function store(StoreUserRequest $request, CommonService $storeStudentData){
            
            try{
                $this->authorize('create', Student::class);
                $data = $request->validated();                 
                $students = $storeStudentData->storeStudentData($data);
                        if($students) {
                            return response()->json([
                                'success' => true,
                                'message' => 'student Data added successfully',
                                'data' => $students
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

            //Edit studentdata 
             public function edit(string $id,CommonService $editStudentData){
            try{          

                $student = $editStudentData->editStudentData($id);
                $this->authorize('update',$student);
                    if($student){
                        return response()->json([
                            'success' => true,
                            'data' => $student
                        ]);
                    }
                    else{
                         return response()->json([
                            'success' => false,
                            'error'=> 'something wrong'
                         ]);
                    }
                }catch(AuthorizationException $e){
                    return response()->json([
                        'success'=>false,
                        'message' => 'You are not authorized to Edit this student.'
                    ],403);
                }   
            }

            //Update StudentData 
             public function update(StoreUserRequest $request, string $id, CommonService $updateStudentData)
                {
                try{
                    $students = Student::findOrFail($id);
                    $this->authorize('update', $students);
                    $data =  $request->validated();
                
                        $student = $updateStudentData->updateStudentData($data,$id);
                        if($student){
                        return response()->json([
                        'success' => 'true',
                        'message' => 'Updated successfully',
                        'data' => $student
                        ]);
                    }else {
                        return response()->json([
                        'success' => false,
                        'error'=> 'something wrong'
                        ]);
                    }
                }catch(AuthorizationException $e){
                    return response()->json([
                        'success' => false,
                        'message' => 'You are not authorized to Update this student.'
                    ], 403);

                }
                
            }

            

            
            //student Data export Excel
             public function studentExcelExport(CommonService $exportStudentData){
            try{
                $this->authorize('ExcelExport', Student::class);
                $result = $exportStudentData->exportStudentData();
                if ($result) {
                    return response()->json([
                            'success' => true,
                            'message' => 'student data successfully exported in excel',
                            'Data' => $result
                            
                        ]);
                }
                else {
                        return response()->json([
                            'success' => false,
                            'error' =>'Request failed. Please check your network or server'
                        ]);
                    }
                }catch(AuthorizationException $e){
                    return response()->json([
                        'success' => false,
                        'message' => 'You are not authorized to Export this student.'
                    ],403);
                }    
            }

            //Show Excel Export Status(user,Status)
             public function ExportStatus(CommonService $ExportStatus){
                $exportDatas = $ExportStatus->ExportStatus();
                if($exportDatas){
                    return response()->json([
                        'success'=>true,
                        'data'=>$exportDatas
                    ]);
                }
                else{
                    return response()->json([
                    'success'=>false,
                    'error'=>'Request failed. Please check your network or server'
                   ]); 
                }
            }

            //Show Student Mark List
             public function studentmarkData(CommonService $studentMarks){
                try{
                $this->authorize('viewMark', Student::class);
                $data = $studentMarks->studentMark();
                if($data){
                    return response()->json([
                        'success'=>true,
                        'data'=> $data

                    ]);
                }
                else{
                    return response()->json([
                        'success' => false,
                        'error' => 'something wrong'
                    ]);
                }
               }catch(AuthorizationException $e){
                    return response()->json([
                        'success' => false,
                        'message' => 'You are not authorized to Show this student Mark.'
                    ],403);
               }
            } 

             //Import Student Mark(PhoneNo) Using Excel 
            public function ImportStudentMark(ImportStudentRequest $request,CommonService $importStudentData){
                 try{  
                    $importMark = $importStudentData->importStudentMark($request);
                    $this->authorize('markImport',Student::class);
                            if($importMark){
                                return response()->json([
                                    'success'=>true,
                                    'data'=> 'Student Mark Imported Successfully'
                                ]);
                            }
                            else{
                                return response()->json([
                                    'success' => false,
                                    'error' => 'something wrong'
                                ]);
                            }
                     }catch(AuthorizationException $e){
                         return response()->json([
                                 'success' => false,
                                 'message' => 'You are not authorized! So You Does Not Import student Mark.'
                         ],403);
                     }       
              }

             //Import Student Data Using Excel 
             public function ImportStudentData(ImportStudentRequest $request,CommonService $importStudentData){ try{       
                        $importData = $importStudentData->importStudentData($request);
                        $this->authorize('studentDataImport', Student::class);
                        if($importData){
                                    return response()->json([
                                        'success'=>true,
                                        'data'=> $importData
                                    ]);
                                 }
                            else{
                                return response()->json([
                                    'success' => false,
                                    'error' => 'something wrong'
                                ]);
                            }
                     }catch(AuthorizationException $e){
                        return response()->json([
                                 'success' => false,
                                 'message' => 'You are not authorized! So You Does Not Import student Data.'
                         ],403);
                     }   
                 }

            //Search StudentData
             public function searchField(Request $request,CommonService $searchDatas){

                     $searchField = $request->all();
                     try{
                     $students = $searchDatas->searchData($searchField);
                     $searchdata = $request->input('Pdf');

                     if ( $searchdata == 'Pdf') {
                         $this->authorize('pdfDownload', Student::class);
                         $students = $searchDatas->searchData($searchField, $paginate=false);
                         $pdf = PDF::loadView('student_pdf', compact('students'));
                        
                         return response($pdf->output(), 200, [
                                'Content-Type' => 'application/pdf',
                                'Content-Disposition' => 'inline; filename="studentdata.pdf"'
                            ]);
                     };

                        
                    // Permission check
                    $user = auth()->user();
                    $permission = [
                        'update' =>  $user->can('update',new Student()),
                        'delete'  => $user->can('delete',new Student()),
                    ];      
                    return response()->json([
                        'data' => StudentResource::collection($students),
                        'meta' =>[
                                'current_page' => $students->currentPage(),
                                'last_page'  => $students->lastPage(),
                                'per_page'  => $students->perPage()
                             ],
                        'permission' => $permission
                    ]);
                          
                       
                  

                       }catch(AuthorizationException $e){
                            return response()->json([
                            'success' => false,
                            'message' => 'You are not authorized to Download this studentData.'
                        ], 403);

                       }   
             }
            
             //Delete StudentData
              public function destroy(string $id,CommonService $deleteStudentData){
                try{
                   $student = Student::findOrFail($id);
                   $this->authorize('delete', $student);
                   $student = $deleteStudentData->deleteStudentData($id);
                   
                   if($student){
                        return response()->json([
                            'message' => 'studentdata is deleted successsfully',
                            'student_id' => $id
                        ]);
                   }else{
                        return response()->json([
                            'errors' => 'studentdata is not Delete! please try again',
                            'student_id' => $id,
                            'data' => $data
                        ]);
                   }
               }catch (AuthorizationException $e) {
                    return response()->json([
                        'success' => false,
                        'message' => 'You are not authorized to delete this student.'
                    ], 403);

                }

            }

              

        public function downloadExportedStudentData($id)
        {
                    try{
                    $this->authorize('downloadExportedStudentData', Student::class);
                    $export = studentExportJob::find($id);

                    if (!$export || $export->status !== 'completed') {
                        return response()->json(['error' => 'File not ready'], 404);
                    }

                    $filePath = storage_path('app/public/exports/' . $export->file_name);

                    if (!file_exists($filePath)) {
                        return response()->json(['error' => 'File not found'], 404);
                    }

                    return response()->download($filePath, $export->file_name, [
                        'Content-Type' => 'text/csv',
                        'Content-Disposition' => 'attachment; filename="' . $export->file_name . '"',
                       
                    ]);

                 }catch(AuthorizationException $e){
                    return response()->json([
                        'success' => false,
                        'message' => 'You are not authorized to Export this student.'
                    ],403);
                 }   
        }

       
         //Email Send
         public function send(MailRequest $request, CommonService $mail)
            {
            try{
                $this->authorize('sendMail', Student::class);
                $data = $request->validated();
                $data['file'] = $request->file('file');
                $email = $mail->sendMail($data);
                if($email){
                    return response()->json([
                        'success' => true,
                        'message' => 'Your message has been sent!Please Check Your Email',
                        'data' => $email
                    ]);
                }else{
                    return response()->json([
                    'success'=>false,
                    'error'=>'Request failed. Please check your network or server'
                   ]); 
                }

            }catch(AuthorizationException $e){
                return response()->json([
                        'success' => false,
                        'message' => 'You are not authorized to send Email this student.'
                    ],403);
            }

            }    



                // //StudentMark
                // public function mark(Request $request){

                // $tableName = $request->input('tableName');
                // $columnName = $request->input('columnName');
                // $wherevalue = $request->input('wherevalue');
                // $whereKey = $request->input('whereKey');

                // $markData = DB::table($tableName)->select($columnName)
                // ->whereIn($whereKey,$wherevalue)
                // ->get();
               
                //     if($markData){
                //         return response()->json([
                //             'message' => $markData,
                //              // 'query' => $markDataQuery
                //         ]);
                //      }
                // }



                
}
