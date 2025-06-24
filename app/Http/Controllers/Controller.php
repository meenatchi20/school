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
 }
