<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Department;
use App\Models\Subject;
use App\Models\StudentMapping;
use App\Http\Requests\StoreUserRequest;
use App\Services\CommonService;
use PDF;
use App\Exports\StudentExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StudentImport;
class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Student $student,CommonService $studentData)
    {
            $students = $studentData->getAllStudentData();
            $departments= $studentData->getAllDepartment();
            $subjects= $studentData->getAllSubjects();
            $searchField = [];
            return view('student_list', compact('students','departments','subjects','searchField'));    
    }
    // Search Field
    public function searchField(Request $request, CommonService $searchData){

             $searchField = $request->all();
             $departments= $searchData->getAllDepartment();
             $subjects= $searchData->getAllSubjects();
             $students = $searchData->searchData($searchField);
             if ($request->has('Pdf') && $request->input('Pdf') === 'Pdf') {
                $pdf = PDF::loadView('student_pdf', compact('students'));
                return $pdf->download('student_filtered.pdf');
             }
        
             return view('student_list',compact('students','searchField','departments','subjects'));
            
        }    
             

    /**
     * Show the form for creating a new resource.
    */
    public function create()
    {
        return view('form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request, CommonService $storeStudentData)
    {
        $data = $request->validated();
        $students = $storeStudentData->storeStudentData($data);
        return redirect()->route('student.list')->with('success', 'Student added successfully!');

    }   

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id,CommonService $editStudentData)
    {
        $student = $editStudentData->editStudentData($id);
        return view('edit_student_data',compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUserRequest $request, string $id, CommonService $updateStudentData)
    {
        $data =  $request->validated();
        $updateStudentData->updateStudentData($data,$id);
        return redirect()->route('student.list')->with('success', 'Student Data Updated  successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id,CommonService $deleteStudentData)
    {
        $student = $deleteStudentData->deleteStudentData($id);
        return redirect()->route('student.list')->with('delete-success', "deleted Student Id:{$student}");
        
    }

    // public function downloadPdf(){
    //     $students = Student ::with(['department','subject'])->get();
    //     $pdf = PDF::loadView('student_pdf',compact('students'));
    //     return $pdf->download('student.pdf');
    // }

    // Excel Export StudentData
    public function studentExcelExport(CommonService $exportStudentData){
        return $exportStudentData->exportStudentData();
    }
    // Excel Import StudentData
    public function ImportStudentData(Request $request,CommonService $importStudentData){
         $importStudentData->importStudentData($request);
         return redirect()->route('student.list')->with('success','file upload successfully');
    }
}






// select * from `student` where exists (select * from `subjects` inner join `student_mapping` on `subjects`.`id` = `student_mapping`.`subject_id` where `student`.`id` = `student_mapping`.`student_id` and `subjects`.`id` in (2,6,1));