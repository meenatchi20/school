<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Department;
use App\Models\Subject;
use App\Models\StudentMapping;
use App\Models\StudentMark;


use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\ImportStudentRequest;
use App\Http\Requests\MailRequest;
use App\Imports\StudentPhoneNoImport;
use App\Services\CommonService;

use PDF;
use Mail;

use App\Exports\StudentExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StudentImport;
use App\Jobs\ExportStudentDataJob;
use App\Models\studentExportJob;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;
use App\Mail\ContactMail;



class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *///View All User Role 
    public function index(Request $request,Student $student,CommonService $studentData)
    {
            $this->authorize('viewAny', Student::class);
            $students = $studentData->getAllStudentData();
            $departments= $studentData->getAllDepartment();
            $subjects= $studentData->getAllSubjects();
            $exportDatas = $studentData->ExportStatus();
            $searchField = [];
            return view('student_list', compact('students','departments','subjects','searchField','exportDatas'));    
    }
    // Search Field
    //pdf download --> Admin,SuperAdmin
    public function searchField(Request $request,CommonService $searchData){
           
             $searchField = $request->all();
             $departments= $searchData->getAllDepartment();
             $subjects= $searchData->getAllSubjects();
             $exportDatas = $searchData->ExportStatus();
             $students = $searchData->searchData($searchField);
             if ($request->has('Pdf') && $request->input('Pdf') === 'Pdf') {
                 $this->authorize('pdfDownload', Student::class);
                 $students = $searchData->searchData($searchField, $paginate=false);
                 $pdf = PDF::loadView('student_pdf', compact('students'));
                 return $pdf->download('student_filtered.pdf');

             }

             
             return view('student_list',compact('students','searchField','departments','subjects','exportDatas'));
            
        }    
             

    /**
     * Show the form for creating a new resource.
    */
    //User Role -->Admin,SuperAdmin,Manager  
    public function create()
    {
        $this->authorize('create', Student::class);
        $user = [];
        return view('form',compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    //User Role -->Admin,SuperAdmin,Manager 
    public function store(StoreUserRequest $request, CommonService $storeStudentData)
    {
        $this->authorize('create', Student::class);
        $data = $request->validated();
        $students = $storeStudentData->storeStudentData($data);
        return redirect()->route('student.list')->with('success', 'Student added successfully!');

    }   

    
    /**
     * Show the form for editing the specified resource.
     */
    //User Role -->Admin,SuperAdmin,Manager 
    public function edit(string $id,CommonService $editStudentData)
    {
        
        $student = $editStudentData->editStudentData($id);
        $this->authorize('update', $student);
        return view('edit_student_data',compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
     //User Role -->Admin,SuperAdmin,Manager 
    public function update(StoreUserRequest $request, string $id, CommonService $updateStudentData)
    {
        $students = Student::findOrFail($id);
        $this->authorize('update', $students);
        $data =  $request->validated();
        $updateStudentData->updateStudentData($data,$id);
        
        return redirect()->route('student.list')->with('success', 'Student Data Updated  successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    //User Role -->SuperAdmin
    public function destroy(string $id,CommonService $deleteStudentData)
    {
       
        $students = Student::findOrFail($id);
        $this->authorize('delete', $students);

        $student = $deleteStudentData->deleteStudentData($id);
       
        return redirect()->route('student.list')->with('delete-success', "deleted Student Id:{$student}");
        
    }

   

    //Excel Export StudentData
    //User Role -->SuperAdmin/Admin
    public function studentExcelExport(CommonService $exportStudentData){
        $this->authorize('ExcelExport', Student::class);
        $result = $exportStudentData->exportStudentData();
        //dd($result);
        if ($result) {           
            return back()->with('success', 'Export started successfully!');
        } else {
            return back()->with('error', 'Failed to start export. Check logs.');
        }
    }

    //Show Excel Export StudentData
    public function ExportStatus(CommonService $ExportStatus){
        $exportDatas = $ExportStatus->ExportStatus();
        return view('export_studentdata',compact('exportDatas'));
    }

  
    //Show StudentMark Details List
    //User Role -->SuperAdmin,Admin
    public function studentmarkData(CommonService $studentMarks){

        $this->authorize('viewMark', Student::class);
        $data = $studentMarks->studentMark();
        $students = $data['students'];
        $subjectTotals = $data['subjectTotals'];
        $averageSubject = $data['averageSubject'];
        return view('studentMark_detail',compact('students','subjectTotals','averageSubject'));
    }


    //  // Excel Import StudentData
    //User Role -->SuperAdmin,Admin
    public function ImportStudentData(ImportStudentRequest $request,CommonService $importStudentData){
        $studentMark = $request->input('import');

        //dd($studentMark);
        try{
            if($studentMark === 'ImportMark'){
                $this->authorize('markImport', Student::class);
                $importStudentData->importStudentMark($request);
                return redirect()->back()->with('success','file upload successfully');
            }
            elseif($studentMark === 'importData'){
                $this->authorize('studentDataImport', Student::class);
                $importStudentData->importStudentData($request);
                return redirect()->back()->with('success','StudentData upload successfully');
            } 
        }
        catch(Exception $e){
            Log::error('Import Failed:' . $e->getMessage());
            return back()->with('error','Import failed');
        }
    }


            // Contact FormPage
            public function showForm()
                {
                    return view('email.contact_form');
                }  

            //Email Send
            public function send(MailRequest $request, CommonService $mail)
            {
                $this->authorize('sendMail',Student::class);
                $data = $request->validated();
                $mail->sendMail($data);
                return back()->with('success', 'Your message has been sent!');
            }    


       // public function mark(CommonService $mark){
       //  return $mark->mark();

       // }
}






