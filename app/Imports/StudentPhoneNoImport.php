<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Student;
use App\Models\Subject;
use App\Models\StudentMark;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentPhoneNoImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
            foreach($rows as $row){
                $mobile = $row['mobileno'];
                $student = Student::where('phone_no',$mobile)->first();
                $subjects = Subject::all();
                if($student){
                foreach ($subjects as $subject) {

                    $exists = StudentMark::where('student_id', $student?->id)
                                 ->where('subject_id', $subject->id)
                                 ->exists();
                    if(!$exists){
                     $studentMark = StudentMark::create([
                    
                    'student_id' => $student?->id,
                    'subject_id' => $subject?->id,
                    'mark' => rand(10,100),

                ]);
            }

         }
     }
    }
}
}
