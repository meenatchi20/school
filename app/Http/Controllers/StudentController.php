<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Department;
use App\Models\Subject;
use App\Models\StudentMapping;
use App\Http\Requests\StoreUserRequest;
class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Student $student)
    {
        //$student = Student :: paginate(2);
        $students = Student ::with('department')->get();
        return view('student_list', compact('students'));
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
    public function store(StoreUserRequest $request)
    {
        //dd($request->all());
         
         $data = $request->validated();
         //department table
         $department = Department::firstOrCreate([
            'department_name' => $data['department_name']
        ]);

        // $subject = $data['subject_name'];
        // $subjectid = [];
        // foreach($subject as $subjects) {
        //     $subject = Subject::firstOrCreate(['subject_name' => $subjects]);
        //     $subjectid[] = $subject->id;

        // }

       
      //  $data = $request->validated();
        $student = new Student();
        $student->first_name = $data['first_name'];
        $student->last_name = $data['last_name'];
        $student->email = $data['email'];
        $student->phone_no = $data['phone_no'];
        $student->age = $data['age'];
        $student->department_id = $department['id'];
        $student->save();

        $std_mapping = StudentMapping::firstOrCreate([
            'student_id' => $student->id,
            'department_id' => $department->id
        ]);
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
    public function edit(string $id)
    {
        $student = Student::find($id);

        return view('edit_student_data',compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUserRequest $request, string $id)
    {
        $data =  $request->validated();
        $student = Student::find($id);
        $student->update($data);
        return redirect()->route('student.list')->with('success', 'Student Data Updated  successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::find($id);
        $student->delete();
        return redirect()->route('student.list')->with('delete-success', "deleted Student Id:$id");
        //print the delete employee data
       // $deletedData = $employee->toArray();
        //dd($deletedData);
    }
}
