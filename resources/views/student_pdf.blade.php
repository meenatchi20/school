@extends('layout.student_form') 
    @section('style')
    <link rel="stylesheet" href="{{public_path('css/student_list_style.css')}}">
    @endsection
    
    @section('content')
    <h1>Students Details</h1>
<table>
         <tr>
            <th>Id</th>
            <th>first_name</th>
            <th>last_name</th>
            <th>email</th>
            <th>phone number</th>
            <th>age</th>
             <th>Department</th>
            <th>Subject</th> 
           
           
        </tr>

            @foreach ($students as $student)
        <tr>
            <td> {{$student->id}} </td>
            <td> {{$student->first_name}} </td>
            <td> {{$student->last_name}} </td>
            <td> {{$student->email}} </td>
            <td> {{$student->phone_no}} </td>
            <td> {{$student->age}} </td>
            <td> {{$student->department?->department_name }} </td>  
            <td>
                @foreach($student->subject as $subject)
                    {{ $subject->subject_name }}<br>
                @endforeach
            </td>
        </tr>
             @endforeach
    </table>  
    @endsection
