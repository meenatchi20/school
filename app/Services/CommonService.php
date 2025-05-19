<?php
	namespace App\Services;
use App\Models\Student;
use App\Models\Department;
use App\Models\Subject;
use App\Models\StudentMapping;
use App\Http\Requests\StoreUserRequest;
use App\Services\CommonService;
use App\Exports\StudentExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StudentImport;
	 

	class CommonService {

		public function searchData($request){
			$searchFirstName = $request['search_firstname'] ??[];
            $searchLastName = $request['search_lastname'] ?? [];
            $searchEmail = $request['search_email'] ?? [];
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
                          $responseData->whereHas('Subject', function($query) use ($subject_name){
                          return $query->whereIn('subjects.id',$subject_name); 
                          });
                        
                    })
                      
                      ->paginate();
                   	return $responseData;
                }


            public function storeStudentData($request){

                    $student = new Student();
                    $student->first_name = $request['first_name'];
                    $student->last_name = $request['last_name'];
                    $student->email = $request['email'];
                    $student->phone_no = $request['phone_no'];
                    $student->age = $request['age'];
                    $student->department_id = $request['department_id'];
                    $student->save();
                    $student->subject()->attach($request['subject_name']); 
                    return $student;
             }


                 public function editStudentData($id){
                    $student = Student::with(['department','subject'])->find($id);
                    return $student;
                }
                
              public function updateStudentData($request, string $id){
                    $student = Student::with('subject')->find($id);
                    $student->update($request);
                    $student->department_id = $request['department_id'];
                    $student->subject()->sync($request['subject_name']); 
                    return;
              }

               public function deleteStudentData($id){
               
                   $student = Student::find($id);
                    // if (!$student) {
                    //     return null; 
                    // }
                   $student->delete();
                   return $student;  
		      }


	           public function exportStudentData(){
                    return Excel::download(new StudentExport,'students.csv');
             }

               public function importStudentData($request){
                    return  Excel::import(new StudentImport, $request->file('student_file'));
             }

              

            public function getAllDepartment(){
                return department::all();
            }

            public function getAllSubjects(){
                return subject::all();
            }

            public function getAllStudentData(){
                return $students = Student ::with(['department','subject'])->paginate(6);
            }
}







?>