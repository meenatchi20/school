<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    //Excel Import StudentData
    // public function ImportStudentData(ImportStudentRequest $request,CommonService $importStudentData){
    //      $importStudentData->importStudentData($request);
    //      return redirect()->route('student.list')->with('success','file upload successfully');
    // }

   

    //Excel import Student Mark USing PhoneNumber
    // public function ImportStudentMark(Request $request){
    //      $file = $request->file('student_file');
    //      Excel::import(new StudentPhoneNoImport, $file);
    //      return redirect()->route('student.list')->with('success','file upload successfully');
    // }

 // public function downloadPdf(){
    //     $students = Student ::with(['department','subject'])->get();
    //     $pdf = PDF::loadView('student_pdf',compact('students'));
    //     return $pdf->download('student.pdf');
    // }

    // Excel Export StudentData
    // public function studentExcelExport(CommonService $exportStudentData){
    //     return $exportStudentData->exportStudentData();
    // }

    // select * from `student` where exists (select * from `subjects` inner join `student_mapping` on `subjects`.`id` = `student_mapping`.`subject_id` where `student`.`id` = `student_mapping`.`student_id` and `subjects`.`id` in (2,6,1));

    //  let subjects = [];
                          // document.querySelectorAll('input[name="subject_name[]"]:checked').forEach(function(checkbox) {
                          //     subjects.push(checkbox.value);
                          // });


    // let formValue = {
                    //  first_name:document.getElementById('first_name').value, 
                    //  last_name: document.getElementById('last_name').value ,
                    //  email: document.getElementById('email').value,
                    //  phone_no: document.getElementById('phone_no').value,
                    //  age:document.getElementById('age').value,
                    //  department_id:document.getElementById('department_id').value,
                    //  subject_name:Array.from(document.querySelectorAll('input[name="subject_name[]"]:checked')).map(sub => sub.value)
                    // };

        // let getId = window.location.pathname.split('/');
                        // console.log(getId)
                        // return getId[2];

      
        //   // //SearchData And Pdf Download
        //    document.getElementById('formSubmit').addEventListener('submit',function(event){
        //          event.preventDefault();
        //   //         let page = 1
        //   //         let search_first = document.getElementById('search_firstname').value;
        //   //         let search_last = document.getElementById('search_lastname').value;
        //   //         let search_email = document.getElementById('search_email').value;
        //   //         let department_id = Array.from(document.getElementById('department_id').selectedOptions).map(
        //   //                             department => department.value );
        //   //         let subject_name = Array.from(document.querySelectorAll('#subject input[type="checkbox"]:checked')) 
        //   //                             .map(subject => subject.value);
        //   //         // console.log(subject_name)
        //   //         //SearchData URL                    
        //   //         let searchDatas = new URLSearchParams({
        //   //             search_firstname:search_first,
        //   //             search_lastname:search_last,
        //   //             search_email:search_email
        //   //             });

        // //       department_id.forEach(id => searchDatas.append('department_id[]',id));
        // //       subject_name.forEach(id => searchDatas.append('subject_name[]',id));

        //          let submitBtn = event.submitter;//this is for form contains multiple submit buttons

        //      if(submitBtn.id === 'search'){  

        //                  //searchDatas.append('page',1)
        //          let params = searchParams();
        //          params.append('page',1)
        //                  searchData(1);
        // //               let request = new XMLHttpRequest();
        // //               let url = `http://127.0.0.1:8000/api/search?${searchDatas.toString()}`;
        // //               request.open("GET", url ,true);
        // //               request.setRequestHeader('Authorization' , 'Bearer ' + token);
        // //               request.setRequestHeader('Accept','application/json')

        //   //     if(!token){
        //   //         alert('Token has been Expired! Please Login Again');
        //   //         return;
        //   //          }  

        //   //          request.onreadystatechange = function(){
        //   //                if(request.readyState === 4 && request.status === 200){
        //   //                    let response = JSON.parse(request.responseText);
        //   //                    let data = response.data;
        //   //                    let meta = response.meta;
        //   //                    //Store Search Data
        //   //                     studentDataTable(data);
        //   //                     pagination(meta);  
        // //                   isSearching = true;
        //   //                }
        //   //          }

        //   //          request.send();

        //          }
        //          else if(submitBtn.id === 'downloadpdf'){
                    
        //              let params = searchParams();
        //              params.append('Pdf','Pdf');
        //          let url = `http://127.0.0.1:8000/api/search?${params.toString()}`;
        //              let pdfDownload = new XMLHttpRequest();
        //              pdfDownload.open("GET",url,true);
        //              pdfDownload.setRequestHeader('Accept','application/pdf');
        //              pdfDownload.setRequestHeader('Authorization','Bearer '+ token);
        //              pdfDownload.responseType = 'blob';

        //              pdfDownload.onload = function(){
        //                  if(pdfDownload.status === 200){                         
        //                      const blob = new Blob([pdfDownload.response], { type: 'application/pdf' });
        //                      let a = document.createElement('a');
        //                      let url = window.URL.createObjectURL(blob);
        //                      a.href = url;
        //                      a.download = 'studentdata.pdf';
        //                      document.body.appendChild(a); // Append to body (can be removed after click)
        //                  a.click();
        //                  document.body.removeChild(a);
        //                      console.log('Sucessfully')
        //                  }else{
        //                      console.log('wrong')
        //                  }
        //              }

        //              pdfDownload.send();

        //              }
        //          })


    //Email Send
            // public function send(MailRequest $request)
            // {
            //     $data = $request->validate([
            //         'name'    => 'required|string',
            //         'email'   => 'required|email',
            //         'message' => 'required|string',
            //         'file' => 'required|mimes:pdf,doc,xls,csv',
            //     ]);


            //    $name = uniqid('file_',true);
            //    $fileName = $name . '.' . $request->file('file')->extension();
            //    $request->file('file')->storeAs('uploads',$fileName, 'public');
            //    //$request->file('file')->move('file',$fileName);
            //    //dd($fileName);

            //    Mail::to($data['email'])->send(new ContactMail($data,$fileName));

            //    return back()->with('success', 'Your message has been sent!');
            // }



             // $markData = DB::table($tableName)
                //             ->join($student, $student. '.' .$columnName. '='. $tableName. '.' .$tableName)
                //             ->join($subject, $subject. '.' .$columnName. '='. $tableName. '.' .$tableName)
                //             ->select(
                //                 $student. '.' .$columnName,
                //                 $student. '.' .$columnName,
                //                 $tableName. '.' .$columnName,
                //                 $subject. '.' .$columnName,
                //                 $tableName. '.' .$columnName
                //             )->whereIn($whereKey,$wherevalue)
                //             ->get();

               /* $markData = DB::table('student_mark')
                    ->join('student', 'student.id', '=', 'student_mark.student_id')
                    ->join('subjects', 'subjects.id', '=', 'student_mark.subject_id') // Assuming subject table exists
                    ->select(
                        'student.first_name',
                        'student.age',
                        'student_mark.subject_id',
                        'subjects.subject_name',
                        'student_mark.mark'
                    )
                    ->whereIn('student_mark.student_id', [25,50]) // Correct way to use whereIn
                    ->get();*/

                     // $student = $request->input('student');
                // $subject = $request->input('subject');

                // $joins = $request->input('joins'); 



                    // <div class="selectDepartment">
                    //     <label for="role">User Role :</label>
                    //     <select id="role" name="role" class="selectRole">
                    //         <option value="" disabled selected hidden>Select Role</option>
                    //         <option value="1"  {{old('role_id') == 1 ? 'selected' : ''}}>SuperAdmin</option>
                    //         <option value="2"  {{old('role_id') == 2 ? 'selected' : ''}}>Manager</option>
                    //         <option value="3" {{old('role_id') == 3 'selected' : ''}}>Admin</option>
                    //         <option value="4" {{old('role_id') == 4 ? 'selected' : ''}}>User</option>
                            
                    //     </select>
                    // </div>


//get permission set 
    //                 public function getPermissionsByRole($roleId)
    // {
    //     $role = RoleModel::findOrFail($roleId);

    //     $permissions = $role->menusWithPermission->map(function ($menu) {
    //         return [
    //             'menu_id' => $menu->id,
    //             'menu_name' => $menu->menu_name,
    //             'full_access' => (bool) $menu->pivot->full_access,
    //             'read_only_access' => (bool) $menu->pivot->read_only_access,
    //             'hidden' => (bool) $menu->pivot->hidden,
    //         ];
    //     });

    //     return response()->json([
    //         'success' => true,
    //         'role' => $role->role,
    //         'permissions' => $permissions
    //     ]);
    // }



    //delete permission 
    // public function removePermission(Request $request)
    // {
    //     $request->validate([
    //         'role_id' => 'required|exists:role,id',
    //         'menu_id' => 'required|exists:menu,id',
    //     ]);

    //     $user = auth()->user();
    //     if (!$user || !$user->role || $user->role->role !== 'SuperAdmin') {
    //         return response()->json(['error' => 'Unauthorized'], 403);
    //     }

    //     DB::table('role_permission')
    //         ->where('role_id', $request->role_id)
    //         ->where('menu_id', $request->menu_id)
    //         ->delete();

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Permission removed'
    //     ]);
    // }



//                     <!-- @if(auth()->user()->can('markImport', \App\Models\Student::class) ||
//                 auth()->user()->can('studentDataImport', \App\Models\Student::class))
//             <div class="importSection">
//                 <form action="{{route('implodeStudentData')}}" method="POST" class="importFileForm" enctype="multipart/form-data">
//                     @csrf
//                     <input type="file" name="student_file" class="importStudentFile">
//                     @if($errors->has('student_file'))
//                                 <span>{{$errors->first('student_file')}}</span>
//                             @endif
//                     <button type="submit" class="import" name="import" value="ImportMark">ImportMark</button>
//                     <button type="submit" class="import" value="importData" name="import">importData</button> 
//                      <button type="submit" class="import">Import</button> -->

//                     <!-- studentmark -->
//                 </form>
                 
//             </div>            
//            <!--  @endif
//             @endauth -- -->


                    // <a href="apiedit/${student.id}" id="update"><i class='fa-solid fa-pencil' ></i></a>
                    //           <button class="button" onclick="myFunction(${student.id})"
                    //           ><i class='fa-solid fa-trash'></i></button>








            
//     namespace App\Services;

// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Log;
// use App\Http\Requests\StoreUserRequest;
// use Maatwebsite\Excel\Facades\Excel;
// use Mail;
// use Illuminate\Support\Carbon;
// use Illuminate\Support\Str;
// use Illuminate\Support\Facades\DB;

// use App\Models\Student;
// use App\Models\Department;
// use App\Models\Subject;
// use App\Models\User; 
// use App\Models\StudentMapping;
// use App\Models\StudentMark;
// use App\Models\RoleModel;


// use App\Services\CommonService;
// use App\Exports\StudentExport;
// use App\Imports\StudentImport;
// use App\Jobs\ExportStudentDataJob;
// use App\Imports\StudentPhoneNoImport;
// use App\Models\studentExportJob;
// use PDF;
// use Exception;
// use App\Mail\ContactMail;

     

// class CommonService {

//         //Search StudentData
//         public function searchData($request,$paginate=true){
//            try {
//             $searchFirstName = trim($request['search_firstname'] ?? '');
//             $searchLastName = trim($request['search_lastname'] ?? '');
//             $searchEmail = trim($request['search_email'] ?? '');
//             $department_id = $request['department_id'] ?? [];
//             $subject_name = $request['subject_name'] ?? [];
            
//                 $responseData = Student::with(['department','subject'])
//                     ->when($searchFirstName, function($responseData,$searchFirstName){
//                         return $responseData->where('first_name','LIKE','%'.$searchFirstName.'%');
//                     })
//                      ->when($searchLastName, function($responseData,$searchLastName){
//                         return $responseData->where('last_name','LIKE','%'.$searchLastName.'%'); 
//                     })

//                      ->when($searchEmail, function($responseData,$searchEmail){
//                         return $responseData->where('email','LIKE','%'.$searchEmail.'%'); 
//                     })
                   
//                      ->when($department_id, function($responseData,$department_id){
//                         return $responseData->whereIn('department_id',$department_id); 
//                     })

//                      ->when($subject_name, function($responseData,$subject_name){
//                          return  $responseData->whereHas('Subject', function($query) use ($subject_name){
//                            $query->whereIn('subjects.id',$subject_name); 
//                           });
                        
//                     });

//                      if(!$paginate){
//                         $responseData = $responseData->get();
//                      }else{
//                         $responseData = $responseData->paginate(5);
//                      }

//                     return $responseData;

//                    }
//                    catch(Exception $e){
//                         Log::error('Search Error:' . $e->getMessage());
//                    }
//             }
               
                

//             //Store StudentData
//             public function storeStudentData($request){
//                try {
//                     $student = new Student();
//                     $student->first_name = $request['first_name'];
//                     $student->last_name = $request['last_name'];
//                     $student->email = $request['email'];
//                     $student->phone_no = $request['phone_no'];
//                     $student->age = $request['age'];
//                     $student->department_id = $request['department_id'];
//                     $student->save();
//                      if (!empty($request['subject_name']) && is_array($request['subject_name'])) {
//                        $student->subject()->attach($request['subject_name']); 
//                      }
                    

//                     return $student;
//                } 
//                catch(Exception $e){
//                         Log::error('Store Data Error:' . $e->getMessage());
//                    }   
//             }


//             //Edit StudentData
//             public function editStudentData($id){
//                 try{
//                     $student = Student::with(['department','subject'])->find($id);
//                     return $student;
//                 }
//                 catch(Exception $e){
//                         Log::error('Edit StudentData Error:' . $e->getMessage());
//                    }
//                 }
              
//             //Update StudentData  
//             public function updateStudentData($request, string $id){
//                 try{
//                     $student = Student::with('subject')->find($id);
//                     $student->update($request);
//                     $student->department_id = $request['department_id'];
//                     $student->subject()->sync($request['subject_name']); 
//                     return $student;
//                 }
//                 catch(Exception $e){
//                         Log::error('UpdateStudent Data Error:' . $e->getMessage());
//                    }
//               }

//             //Delete StudentData
//             public function deleteStudentData($id){
//                try {
//                    $student = Student::find($id);
//                     // if (!$student) {
//                     //     return null; 
//                     // }
//                    $student->delete();
//                    return $student; 
//                }
//                catch(Exception $e){
//                         Log::error('Delete StudentData Error:' . $e->getMessage());
//                    }
//               }

//             //Export StudentData Using Job
//             public function exportStudentData(){
//                 try{
//                     //return Excel::download(new StudentExport,'students.csv');
//                      $fileName = 'studentdata' . now()->format('Y_m_d_His') . '.csv';
//                      $export = studentExportJob::create([
//                                 'user_id' => Auth::id(),
//                                 'file_name' => $fileName,
//                                 'status' => 'initiated',
//                                 'initiated_at' => now(),
//                     ]);
//                     //$export = 
//                     ExportStudentDataJob::dispatch($export->id);
//                     return $export;
//                    //return  Excel::download(new StudentExport, $export->file_name);

//                 }
//                     catch(Exception $e){
//                         Log::error('Export Student Error:' . $e->getMessage());
//                     }
//              }

//              //Import StudentData
//             public function importStudentData($request){
//                 try{
//                     //return  Excel::import(new StudentImport, $request->file('student_file'));
//                     $studentData = Excel::import(new StudentImport, $request->file('student_file'));
//                     return $studentData;
//                 }
//                 catch(Exception $e){
//                     Log::error('Import StudentData Error:' . $e->getMessage());
//                 }
//             }

              
//              //Get All Department
//             public function getAllDepartment(){
//                 try{
//                     return department::all();
//                 }
//                 catch(Exception $e){
//                     Log::error('GetAllDepartment Error:' . $e->getMessage());
//                 }
//             }

//             //Get All Subject
//             public function getAllSubjects(){
//                 try{
//                     return subject::all();
//                 }

//                 catch(Exception $e){
//                     Log::error('GetAllSubjects Error:' . $e->getMessage());
//                 }
//             }

//             //Get All StudentData
//             public function getAllStudentData(){
//                 try{
//                     return $students = Student ::with(['department','subject'])->paginate(5);
//                   }
//                   catch(Exception $e){
//                         Log::error('GetAllStudentData Error:' . $e->getMessage());
//                    }
                
//             }

//             ////Show Excel Export StudentData
//             public function ExportStatus() {
//                 try{
//                  $exportDatas = studentExportJob::with('user')->orderBy('created_at','desc')->get();
//                  return $exportDatas;
//                 }
//                 catch(Exception $e){
//                     Log::error('ExportStatus Error:' . $e->getMessage());
//                 }
//             }

//             //Import StudentMobileNumber Use Excel
//             public function importStudentMark($request){
//                 try{
//                    //return  Excel::import(new StudentPhoneNoImport,  $request->file('student_file'));
//                    $studentPhone =  Excel::import(new StudentPhoneNoImport,  $request->file('student_file'));
//                     return $studentPhone;
//                 }catch(Exception $e){
//                      Log::error('Import StudentMark Error:' . $e->getMessage());
//                 }
//             }


//             //Show StudentMark Details List
//              public function studentMark() {
//                 try {
//                 //Get All Subject Total
//                 $subjectTotals = [];
//                 $count = [];
//                 $allStudents = Student::whereHas('subjectMarks')->with('subjectMarks')->get();

//                 foreach ($allStudents as $student) {
//                         foreach ($student->subjectMarks as $subject) {
//                         $name = $subject->subject_name;
//                         $mark = $subject->pivot->mark;

//                         if (!isset($subjectTotals[$name])) {
//                             $subjectTotals[$name] = 0;
//                             $count[$name] = 0;
//                         }

//                         $subjectTotals[$name] += $mark;
//                         $count[$name]++;
//                     }
//                 }

//                     $averageSubject = [];
//                     foreach($subjectTotals as $name => $total){
//                         $averageSubject[$name] = number_format($total/$count[$name],2);
//                     }

//                     //Get All StudentMark With Paginate
//                 $students = Student::whereHas('subjectMarks')->with(['department','subjectMarks'])->paginate(6);
//                         foreach($students as $student){
//                             $marks = [];
//                                 foreach($student->subjectMarks as $subject) {
//                                     $marks[$subject->subject_name] = $subject->pivot->mark;
//                                 }
//                             $total = array_sum($marks);
//                             $average = number_format($total / count($marks), 2);
//                             $student->mark = $marks;
//                             $student->total = $total;
//                             $student->average = $average;
//                          }

//                     return [
//                     'students'=> $students,
//                     'subjectTotals' => $subjectTotals,
//                     'averageSubject' => $averageSubject
//                     ];
//                 }
//                 catch(Exception $e){
//                     Log::error('studentMark Error:' . $e->getMessage());

//                 }
//              }

//               //SignUp Process
//                 public function signUpCreate($request){

//                         $userLogin = new User();
//                         $userLogin->name = $request['name'];
//                         $userLogin->mobileNo = $request['mobileNo'];
//                         $userLogin->email = $request['email'];
//                         $userLogin->password = Hash::make($request['password']);
//                         // $userLogin->role = $request['role'];
//                         $userLogin->role_id = $request['role_id'];
//                         $userLogin->save();
//                         return $userLogin;
//                }

//                 public function login($request){
//                     $data = [
//                         'name' => $request['user_name'],
//                         'password' => $request['user_password']
//                     ];
//                     return $data;
//                    }   
           


//             // public function export(){
//             //     return Excel::download(new StudentExport,'students.csv');
//             // }


//             //forgetPassword
//             public function ForgetPasswordFormSubmit($request){

//                     $token = Str::random(40);
//                     DB::table('password_reset_tokens')->updateOrInsert(
//                         ['email' => $request['email']], 
//                         [
//                             'token' => $token,
//                             'created_at' => Carbon::now()
//                         ]
//                     );

//                     Mail::send('email.reset_password',['token' => $token],function($data) use ($request){
//                             $data->to($request['email']);
//                             $data->subject('Reset Password');
//                     });

//                     return true;
//             }

//             //Reset Password Process
//              public function resetPasswordFormSubmit($request){

//                     $reset_password = DB::table('password_reset_tokens')
//                                           ->where('email',$request['email'])
//                                           ->where('token', $request['token'])
//                                           ->first();

//                          if (!$reset_password) {
//                             return false;
//                           }           

//                         User::where('email',$request['email'])
//                         ->update(['password' => Hash::make($request['password'])
//                         ]);

//                         DB::table('password_reset_tokens')->where('email',$request['email'])->delete();

//                      return true;   
//               } 


//             //forgetPassword
//             public function apiForgetPasswordFormSubmit($request){

//                     $token = Str::random(40);
//                     DB::table('password_reset_tokens')->updateOrInsert(
//                         ['email' => $request['email']], 
//                         [
//                             'token' => $token,
//                             'created_at' => Carbon::now()
//                         ]
//                     );

//                     Mail::send('api_studentdata.mail_resetpassword',['token' => $token],function($data) use ($request){
//                             $data->to($request['email']);
//                             $data->subject('Reset Password');
//                     });

//                     return true;
//             }

//             public function sendMail($request){

//                $name = uniqid('file_',true);
//                $fileName = $name . '.' . $request['file']->extension();
//                $request['file']->storeAs('uploads',$fileName, 'public');
//                //$request->file('file')->move('file',$fileName);
//                //dd($fileName);

//                Mail::to($request['email'])->send(new ContactMail($request,$fileName));
//                return true;
               
//             }   



//             public function storeTempData(){
                
//             }

//  }


                        // 'maker' => [
                        //             'student_id' => $saveData->id,
                        //             'action' => $action,
                        //             'maker_by' => $user->role->role,
                        //             'maker_at' => now()
                        //         ]







                    

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Models\Student;
// use App\Models\StudentTempData;
// use App\Models\ApprovedStudents;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Log;
// use Illuminate\Support\Facades\DB;
// use App\Services\CommonService;
// use Mail;

// class ApprovalRejecetController extends Controller
// {
//     public function approve($id, CommonService $studentData){
//         $user = auth()->user();
//         $tempStudent = StudentTempData::find($id);

//         if (!$tempStudent) {
//             return response()->json([
//                 'success' => false,
//                 'message' => 'Temp student not found.'
//             ], 404);
//         }

//         if($tempStudent->status === 'Approved'){
//             return response()->json([
//                 'success'=>false,
//                 'message' => 'This student has already been approved.'
//             ],400);
//         }
        
        
//         $student = $studentData->storeStudentData($tempStudent);

//          // Update temp data status to 'approved'
//             $tempStudent->status = 'approved';
//             $tempStudent->save();

//         // $tempStudent->delete(); 
//          return response()->json([
//             'success' => true,
//             'message' => 'Student approved and saved to main table.',
//             'student' => $student,
//             'user' => $user->email
//         ]);
//     }


//     public function reject($id){
//           $user = auth()->user();
//           $userMail = $user->email;
//           $tempStudent = StudentTempData::find($id); 

//           if (!$tempStudent) {
//             return response()->json([
//                 'success' => false,
//                 'message' => 'Temp student not found.'
//             ], 404);
//         }
         
//             if($tempStudent->status !== 'Approved'){
//               $tempStudent->update(['status' => 'Rejected']);

//               Mail::send('api_studentdata.api_reject_data_mail', ['student' => $tempStudent], function($message) use ($userMail){
//                             $message->to($userMail);
//                             $message->subject('Student Data Rejected');
//                     });

//              return response()->json([
//                 'success' => true,
//                 'message' => 'Student request rejected And Mail Send',
//                 ]);
//               } 

//              return response()->json([
//                 'success' => false,
//                 'error' => 'Student is already approved. Cannot reject.'
//             ],422);
//     }


// }


                    
                      // customerData.addEventListener('change', function () {
                    //      if (this.value) {
                    //          isSearching = true;
                    //          searchData(1);
                    //      }
                    //  });

                    // ->when($inVoiceStatus, function($searchData, $inVoiceStatus) {
                    //     return $searchData->whereHas('status', function ($q) use ($inVoiceStatus) {
                    //         $q->where('invoice_status', 'LIKE', '%' . $inVoiceStatus . '%');
                    //     });
                    // });

 }
