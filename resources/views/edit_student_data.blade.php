
@extends('layout.student_form')
@section('style')
	<link rel="stylesheet" href="{{asset('css/form_style.css')}}">
@endsection	
@section('content')		
                <h1>Employee Registration</h1>
                <form action="{{route('student.update',$student->id)}}" method="POST" class="form">
                    @method('PUT')
                    @csrf
                <label for="first_name">FirstName : </label>
                <input type="text" name="first_name" id="first_name" value="{{$student->first_name}}" placeholder="Enter Your FirstName"><br>
                @if($errors->has('first_name'))
								<span>{{$errors->first('first_name')}}</span>
							@endif
						

                <label for="last_name">LastName : </label>
                <input type="text" name="last_name" id="last_name" value="{{$student->last_name}}" placeholder="Enter Your LastName"><br>
                @if($errors->has('last_name'))
								<span>{{$errors->first('last_name')}}</span>
							@endif
						

                <label for="email">Email : </label>
                <input type="email" name="email" id="email" value="{{$student->email}}" placeholder="Enter Your Email"><br>
                @if($errors->has('email'))
								<span>{{$errors->first('email')}}</span>
							@endif

                <label for="phone_no">Phone Number : </label>
                <input type="number" name="phone_no" id="phone_no" value="{{$student->phone_no}}" placeholder="Enter Your PhoneNo"><br>
                @if($errors->has('phone_no'))
								<span>{{$errors->first('phone_no')}}</span>
							@endif
						

                <label for="age">Age : </label>
                <input type="number" name="age" id="age" value="{{$student->age}}" placeholder="Enter Your Age"><br>
                @if($errors->has('age'))
								<span>{{$errors->first('age')}}</span>
							@endif
                <div class="subBtn">
                <input type="submit" name="submit" value="Update">
                {{-- <a  class="employeeData"href="{{route('employee.table')}}">Back</a> --}}
                </div>
            </form>
    @endsection		


