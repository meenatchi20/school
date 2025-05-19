<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\Department;
use App\Models\Subject;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        //dd($rows->first()->keys());
        foreach($rows as $row){

             $departmentId = Department::where('department_name',$row['departmentname'])->first();

             $subject = $row['subjectname'];
             $subjectname = explode(',',$subject);
             $subjectname = Subject::whereIn('subject_name',$subjectname)->pluck('id');
            
             $student = Student::updateOrCreate(
                ['email' => $row['email']],
            ['first_name' =>$row['firstname'],
            'last_name' =>$row['lastname'],
            'email' =>$row['email'],
            'phone_no' =>$row['mobileno'],
            'age' => $row['age'],
            'department_id' => $departmentId ? $departmentId->id : ''
        ]
    );
             $student->subject()->sync($subjectname);

        }
        
    }
}
