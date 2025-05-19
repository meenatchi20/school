<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StudentExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Student::with(['department','subject'])->get();
    }


    public function Headings():array
    {

        return [
            'ID',
            'FirstName',
            'LastName',
            'Email',
            'Mobile No',
            'Age',
            'Department Name',
            'Subject Name'
           
        ];
    }


    public function map($student):array
    {
        return [

            $student->id,
            $student->first_name,
            $student->last_name,
            $student->email,
            $student->phone_no,
            $student->age,
            $student->department?->department_name ?? '',
             $student->subject->pluck('subject_name')->implode(', ')
        ];

    }

}
