
@extends('layout.student_form')
@section('style')
	<link rel="stylesheet" href="{{asset('css/form_style.css')}}">
@endsection	
@section('header')
           @include('header')
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

              <div class="selectDepartment">
                <label for="age">Department :</label>
                <select id="department_id" name="department_id">
                  <option value="" disabled  {{ $student->department_name ? '' : 'selected'}}selected hidden>Select Department</option>
                  <option value="1" {{$student->department_id  == 1 ? 'selected' : ''}}>Biology</option>
                  <option value="2" {{$student->department_id  == 2 ? 'selected' : ''}}>Commerce</option>
                  <option value="3" {{$student->department_id  == 3 ? 'selected' : ''}}>Computer Science</option>
                  <option value="4" {{$student->department_id  == 4 ? 'selected' : ''}}>History</option>
                  <option value="5" {{$student->department_id  == 5 ? 'selected' : ''}} >Science</option>
                  <option value="6" {{$student->department_id  == 6 ? 'selected' : ''}}>Accounts</option>
                </select>
              </div>


              <div>
                <label for="toggleVendors" class="label-toggle form-control">
                  click here
                </label>
                <input type="checkbox" id="toggleVendors"  class="hidden-checkbox">
                <div class="toggle-content">
                  <ul>
                  <li><input type="checkbox"  name="subject_name[]" id="subject_1" value="1" {{$student->subject->contains('id',1) ? 'checked' : ''}}/>Tamil</li>
                  <li><input type="checkbox" name="subject_name[]" id="subject_2" value="2"  {{$student->subject->contains('id',2) ? 'checked' : ''}}/>English</li>
                  <li><input type="checkbox" name="subject_name[]" id="subject_3" value="3" {{$student->subject->contains('id',3) ? 'checked' : ''}}/>Math</li>
                  <li><input type="checkbox" name="subject_name[]" id="subject_4" value="4" {{$student->subject->contains('id',4) ? 'checked' : ''}}/>Physics</li>
                  <li><input type="checkbox" name="subject_name[]" id="subject_5" value="5" {{$student->subject->contains('id',5) ? 'checked' : ''}}/>Chemistry</li>
                  <li><input type="checkbox" name="subject_name[]" id="subject_6" value="6" {{$student->subject->contains('id',6) ? 'checked' : ''}}/>History</li>
                  <li><input type="checkbox" name="subject_name[]" id="subject_7" value="7" {{$student->subject->contains('id',7) ?'checked' : ''}}/>Botany</li>
                  <li><input type="checkbox" name="subject_name[]" id="subject_8" value="8" {{$student->subject->contains('id',8) ? 'checked' : ''}}/>Zoology</li>
                  </ul>
                </div>
                </div>

                <div class="subBtn">
                <input type="submit" name="submit" value="Update">
                {{-- <a  class="employeeData"href="{{route('employee.table')}}">Back</a> --}}
                </div>
            </form>
    @endsection		


@section('footer')
           @include('footer')
        @endsection 
