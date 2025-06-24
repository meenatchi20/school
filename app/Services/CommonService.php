<?php
	namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreUserRequest;
use Maatwebsite\Excel\Facades\Excel;
use Mail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use App\Models\Student;
use App\Models\Department;
use App\Models\Subject;
use App\Models\User; 
use App\Models\StudentMapping;
use App\Models\StudentMark;
use App\Models\RoleModel;


use App\Services\CommonService;
use App\Exports\StudentExport;
use App\Imports\StudentImport;
use App\Jobs\ExportStudentDataJob;
use App\Imports\StudentPhoneNoImport;
use App\Models\studentExportJob;
use PDF;
use Exception;
use App\Mail\ContactMail;

	 

class CommonService {

        //Search StudentData
		public function searchData($request,$paginate=true){
           try {
			$searchFirstName = trim($request['search_firstname'] ?? '');
            $searchLastName = trim($request['search_lastname'] ?? '');
            $searchEmail = trim($request['search_email'] ?? '');
            $department_id = $request['department_id'] ?? [];
            $subject_name = $request['subject_name'] ?? [];
            
           		$responseData = Student::with(['department','subject'])
                    ->when($searchFirstName, function($responseData,$searchFirstName){
                        return $responseData->where('first_name','LIKE','%'.$searchFirstName.'%');
                    })
                     ->when($searchLastName, function($responseData,$searchLastName){
                        return $responseData->where('last_name','LIKE','%'.$searchLastName.'%'); 
                    })

                     ->when($searchEmail, function($responseData,$searchEmail){
                        return $responseData->where('email','LIKE','%'.$searchEmail.'%'); 
                    })
                   
                     ->when($department_id, function($responseData,$department_id){
                        return $responseData->whereIn('department_id',$department_id); 
                    })

                     ->when($subject_name, function($responseData,$subject_name){
                         return  $responseData->whereHas('Subject', function($query) use ($subject_name){
                           $query->whereIn('subjects.id',$subject_name); 
                          });
                        
                    });

                     if(!$paginate){
                        $responseData = $responseData->get();
                     }else{
                        $responseData = $responseData->paginate(5);
                     }

                   	return $responseData;

                   }
                   catch(Exception $e){
                        Log::error('Search Error:' . $e->getMessage());
                   }
            }
               
                

            //Store StudentData
            public function storeStudentData($request){
               try {
                    $student = new Student();
                    $student->first_name = $request['first_name'];
                    $student->last_name = $request['last_name'];
                    $student->email = $request['email'];
                    $student->phone_no = $request['phone_no'];
                    $student->age = $request['age'];
                    $student->department_id = $request['department_id'];
                    $student->save();
                     if (!empty($request['subject_name']) && is_array($request['subject_name'])) {
                       $student->subject()->attach($request['subject_name']); 
                     }
                    

                    return $student;
               } 
               catch(Exception $e){
                        Log::error('Store Data Error:' . $e->getMessage());
                   }   
            }


            //Edit StudentData
            public function editStudentData($id){
                try{
                    $student = Student::with(['department','subject'])->find($id);
                    return $student;
                }
                catch(Exception $e){
                        Log::error('Edit StudentData Error:' . $e->getMessage());
                   }
                }
              
            //Update StudentData  
            public function updateStudentData($request, string $id){
                try{
                    $student = Student::with('subject')->find($id);
                    $student->update($request);
                    $student->department_id = $request['department_id'];
                    $student->subject()->sync($request['subject_name']); 
                    return $student;
                }
                catch(Exception $e){
                        Log::error('UpdateStudent Data Error:' . $e->getMessage());
                   }
              }

            //Delete StudentData
            public function deleteStudentData($id){
               try {
                   $student = Student::find($id);
                    // if (!$student) {
                    //     return null; 
                    // }
                   $student->delete();
                   return $student; 
               }
               catch(Exception $e){
                        Log::error('Delete StudentData Error:' . $e->getMessage());
                   }
		      }

            //Export StudentData Using Job
	        public function exportStudentData(){
                try{
                    //return Excel::download(new StudentExport,'students.csv');
                     $fileName = 'studentdata' . now()->format('Y_m_d_His') . '.csv';
                     $export = studentExportJob::create([
                                'user_id' => Auth::id(),
                                'file_name' => $fileName,
                                'status' => 'initiated',
                                'initiated_at' => now(),
                    ]);
                    //$export = 
                    ExportStudentDataJob::dispatch($export->id);
                    return $export;
                   //return  Excel::download(new StudentExport, $export->file_name);

                }
                    catch(Exception $e){
                        Log::error('Export Student Error:' . $e->getMessage());
                    }
             }

             //Import StudentData
            public function importStudentData($request){
                try{
                    //return  Excel::import(new StudentImport, $request->file('student_file'));
                    $studentData = Excel::import(new StudentImport, $request->file('student_file'));
                    return $studentData;
                }
                catch(Exception $e){
                    Log::error('Import StudentData Error:' . $e->getMessage());
                }
            }

              
             //Get All Department
            public function getAllDepartment(){
                try{
                    return department::all();
                }
                catch(Exception $e){
                    Log::error('GetAllDepartment Error:' . $e->getMessage());
                }
            }

            //Get All Subject
            public function getAllSubjects(){
                try{
                    return subject::all();
                }

                catch(Exception $e){
                    Log::error('GetAllSubjects Error:' . $e->getMessage());
                }
            }

            //Get All StudentData
            public function getAllStudentData(){
                try{
                    return $students = Student ::with(['department','subject'])->paginate(5);
                  }
                  catch(Exception $e){
                        Log::error('GetAllStudentData Error:' . $e->getMessage());
                   }
                
            }

            ////Show Excel Export StudentData
            public function ExportStatus() {
                try{
                 $exportDatas = studentExportJob::with('user')->orderBy('created_at','desc')->get();
                 return $exportDatas;
                }
                catch(Exception $e){
                    Log::error('ExportStatus Error:' . $e->getMessage());
                }
            }

            //Import StudentMobileNumber Use Excel
            public function importStudentMark($request){
                try{
                   //return  Excel::import(new StudentPhoneNoImport,  $request->file('student_file'));
                   $studentPhone =  Excel::import(new StudentPhoneNoImport,  $request->file('student_file'));
                    return $studentPhone;
                }catch(Exception $e){
                     Log::error('Import StudentMark Error:' . $e->getMessage());
                }
            }


            //Show StudentMark Details List
             public function studentMark() {
                try {
                //Get All Subject Total
                $subjectTotals = [];
                $count = [];
                $allStudents = Student::whereHas('subjectMarks')->with('subjectMarks')->get();

                foreach ($allStudents as $student) {
                        foreach ($student->subjectMarks as $subject) {
                        $name = $subject->subject_name;
                        $mark = $subject->pivot->mark;

                        if (!isset($subjectTotals[$name])) {
                            $subjectTotals[$name] = 0;
                            $count[$name] = 0;
                        }

                        $subjectTotals[$name] += $mark;
                        $count[$name]++;
                    }
                }

                    $averageSubject = [];
                    foreach($subjectTotals as $name => $total){
                        $averageSubject[$name] = number_format($total/$count[$name],2);
                    }

                    //Get All StudentMark With Paginate
                $students = Student::whereHas('subjectMarks')->with(['department','subjectMarks'])->paginate(6);
                        foreach($students as $student){
                            $marks = [];
                                foreach($student->subjectMarks as $subject) {
                                    $marks[$subject->subject_name] = $subject->pivot->mark;
                                }
                            $total = array_sum($marks);
                            $average = number_format($total / count($marks), 2);
                            $student->mark = $marks;
                            $student->total = $total;
                            $student->average = $average;
                         }

                    return [
                    'students'=> $students,
                    'subjectTotals' => $subjectTotals,
                    'averageSubject' => $averageSubject
                    ];
                }
                catch(Exception $e){
                    Log::error('studentMark Error:' . $e->getMessage());

                }
             }

              //SignUp Process
                public function signUpCreate($request){

                        $userLogin = new User();
                        $userLogin->name = $request['name'];
                        $userLogin->mobileNo = $request['mobileNo'];
                        $userLogin->email = $request['email'];
                        $userLogin->password = Hash::make($request['password']);
                        // $userLogin->role = $request['role'];
                        $userLogin->role_id = $request['role_id'];
                        $userLogin->save();
                        return $userLogin;
               }

                public function login($request){
                    $data = [
                        'name' => $request['user_name'],
                        'password' => $request['user_password']
                    ];
                    return $data;
                   }   
           


            // public function export(){
            //     return Excel::download(new StudentExport,'students.csv');
            // }


            //forgetPassword
            public function ForgetPasswordFormSubmit($request){

                    $token = Str::random(40);
                    DB::table('password_reset_tokens')->updateOrInsert(
                        ['email' => $request['email']], 
                        [
                            'token' => $token,
                            'created_at' => Carbon::now()
                        ]
                    );

                    Mail::send('email.reset_password',['token' => $token],function($data) use ($request){
                            $data->to($request['email']);
                            $data->subject('Reset Password');
                    });

                    return true;
            }

            //Reset Password Process
             public function resetPasswordFormSubmit($request){

                    $reset_password = DB::table('password_reset_tokens')
                                          ->where('email',$request['email'])
                                          ->where('token', $request['token'])
                                          ->first();

                         if (!$reset_password) {
                            return false;
                          }           

                        User::where('email',$request['email'])
                        ->update(['password' => Hash::make($request['password'])
                        ]);

                        DB::table('password_reset_tokens')->where('email',$request['email'])->delete();

                     return true;   
              } 


            //forgetPassword
            public function apiForgetPasswordFormSubmit($request){

                    $token = Str::random(40);
                    DB::table('password_reset_tokens')->updateOrInsert(
                        ['email' => $request['email']], 
                        [
                            'token' => $token,
                            'created_at' => Carbon::now()
                        ]
                    );

                    Mail::send('api_studentdata.mail_resetpassword',['token' => $token],function($data) use ($request){
                            $data->to($request['email']);
                            $data->subject('Reset Password');
                    });

                    return true;
            }

            public function sendMail($request){

               $name = uniqid('file_',true);
               $fileName = $name . '.' . $request['file']->extension();
               $request['file']->storeAs('uploads',$fileName, 'public');
               //$request->file('file')->move('file',$fileName);
               //dd($fileName);

               Mail::to($request['email'])->send(new ContactMail($request,$fileName));
               return true;
               
            }   

 }

?>