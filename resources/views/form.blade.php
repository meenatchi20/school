
@extends('layout.student_form')	
@section('style')
	<link rel="stylesheet" href="{{asset('css/form_style.css')}}">
@endsection	
@section('header')
    @include('header')
@endsection
		@section('content')
						<h1>Employee Registration</h1>
						<form action="{{route('student.store')}}" method="POST" class="form">
                        @csrf
						<label for="first_name">FirstName : </label>
						<input type="text" name="first_name" id="first_name" value="{{old('first_name')}}" placeholder="Enter Your FirstName">
							@if($errors->has('first_name'))
								<span>{{$errors->first('first_name')}}</span>
							@endif
						

						<label for="last_name">LastName : </label>
						<input type="text" name="last_name" id="last_name" value="{{old('last_name')}}" placeholder="Enter Your LastName">
							@if($errors->has('last_name'))
								<span>{{$errors->first('last_name')}}</span>
							@endif
						

						<label for="email">Email : </label>
						<input type="email" name="email" id="email" value="{{old('email')}}" placeholder="Enter Your Email">
							@if($errors->has('email'))
								<span>{{$errors->first('email')}}</span>
							@endif
						

						<label for="phone_no">Phone Number : </label>
						<input type="number" name="phone_no" id="phone_no" value="{{old('phone_no')}}" placeholder="Enter Your PhoneNo">
							@if($errors->has('phone_no'))
								<span>{{$errors->first('phone_no')}}</span>
							@endif
						

						<label for="age">Age : </label>
						<input type="number" name="age" id="age" value="{{old('age')}}" placeholder="Enter Your Age">
							@if($errors->has('age'))
								<span>{{$errors->first('age')}}</span>
							@endif
						<div class="selectDepartment">
						<label for="age">Department :</label>
						<select id="department_id" name="department_id">
							<option value="" disabled selected hidden>Select Department</option>
							<option value="1"  {{old('department_id') == 1 ? 'selected' : ''}}>Biology</option>
							<option value="2"  {{old('department_id') == 2 ? 'selected' : ''}}>Commerce</option>
							<option value="3" {{old('department_id') == 3 ? 'selected' : ''}}>Computer Science</option>
							<option value="4" {{old('department_id') == 4 ? 'selected' : ''}}>History</option>
							<option value="5" {{old('department_id') == 5 ? 'selected' : ''}}>Science</option>
							<option value="6" {{old('department_id') == 6 ? 'selected' : ''}}>Accounts</option>
						</select>
					</div>

					<div>
						<label for="toggleVendors" class="label-toggle form-control">
						  click here
						</label>
						<input type="checkbox" id="toggleVendors"  class="hidden-checkbox">
						<div class="toggle-content">
						  <ul>
							<li><input type="checkbox"  name="subject_name[]" id="subject_1" value="1"
							{{in_array(1,old('subject_name',[])) ? 'checked' : ''}}/>Tamil</li>
							<li><input type="checkbox" name="subject_name[]" id="subject_2" value="2" 
							{{in_array(2,old('subject_name',[])) ? 'checked' : ''}}/>English</li>
							<li><input type="checkbox" name="subject_name[]" id="subject_3" value="3"
							{{in_array(3,old('subject_name',[])) ? 'checked' : ''}}/>Math</li>
							<li><input type="checkbox" name="subject_name[]" id="subject_4" value="4"
							{{in_array(4,old('subject_name',[])) ? 'checked' : ''}}/>Physics</li>
							<li><input type="checkbox" name="subject_name[]" id="subject_5" value="5"
							{{in_array(5,old('subject_name',[])) ? 'checked' : ''}}/>Chemistry</li>
							<li><input type="checkbox" name="subject_name[]" id="subject_6" value="6"
							{{in_array(6,old('subject_name',[])) ? 'checked' : ''}}/>History</li>
							<li><input type="checkbox" name="subject_name[]" id="subject_7" value="7"
							{{in_array(7,old('subject_name',[])) ? 'checked' : ''}}/>Botany</li>
							<li><input type="checkbox" name="subject_name[]" id="subject_8" value="8"
							{{in_array(8,old('subject_name',[])) ? 'checked' : ''}}/>Zoology</li>
						  </ul>
						</div>
					</div>
					  
						<div class="subBtn">
						<input type="submit" name="submit" value="submit">
						<input type="reset" name="reset" value="Reset">
						</div>
					</form>
					@endsection
					
			@section('footer')
   				 @include('footer')
    		@endsection	

