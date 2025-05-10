
@if(session('success'))
    <script>
        alert("{{ session('success') }}");
    </script>
@endif
@extends('layout.student_form')	

    @section('style')
	<link rel="stylesheet" href="{{asset('css/form_style.css')}}">
    @endsection
    @section('content')
            <h1>Employee Details</h1>
          
    <table>
         <tr>
            <th>Id</th>
            <th>first_name</th>
            <th>last_name</th>
            <th>email</th>
            <th>phone number</th>
            <th>age</th>
            {{-- <th>Department</th> --}}
            <th>Action</th>
           
        </tr>

            @foreach ($students as $student)
        <tr>
            <td>{{$student->id}}</td>
            <td>{{$student->first_name}}</td>
            <td>{{$student->last_name}}</td>
            <td>{{$student->email}}</td>
            <td>{{$student->phone_no}}</td>
            <td>{{$student->age}}</td>
           {{-- <td>{{$student->department->department_name}}</td> --}}
            <td>
                <a href="{{route('student.edit',$student->id)}}">edit</a> 
                    <form action="{{route('student.delete',$student->id)}}" method ="POST" onclick="return confirm('Are You Sure You Want To Delete This Record?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit">DELETE</button>
                 </form>
            </td>
           
        </tr>
             @endforeach
    </table>  

         {{-- <div style="margin-top: 20px;">
             {{ $employee->links() }}
        </div> --}}
@endsection


