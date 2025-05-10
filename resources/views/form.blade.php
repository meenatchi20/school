

@extends('layout.student_form')	
@section('style')
	<link rel="stylesheet" href="{{asset('css/form_style.css')}}">
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
						<select id="department_name" name="department_name">
							<option value="" disabled selected hidden>Select Department</option>
							<option value="Science">Science</option>
							<option value="Computer Science">Computer Science</option>
							<option value="Biology">Biology</option>
							<option value="History">History</option>
							<option value="Accounts">Accounts</option>
							<option value="Commerce">Commerce</option>
						</select>
					</div>

					<div>
						<label for="toggleVendors" class="label-toggle form-control">
						  click here
						</label>
						<input type="checkbox" id="toggleVendors"  class="hidden-checkbox">
						<div class="toggle-content">
						  <ul>
							<li><input type="checkbox"  name="subject_name[]" id="subject_name" value="tamil"/>Tamil</li>
							<li><input type="checkbox" name="subject_name[]" id="subject_name" value="english" />English</li>
							<li><input type="checkbox" name="subject_name[]" id="subject_name" value="math"/>Math</li>
							<li><input type="checkbox" name="subject_name[]" id="subject_name" value="math"/>Physics</li>
							<li><input type="checkbox" name="subject_name[]" id="subject_name" value="math"/>Chemistry</li>
						  </ul>
						</div>
					  </div>
					  
						<div class="subBtn">
						<input type="submit" name="submit" value="submit">
						<input type="reset" name="reset" value="Reset">
						</div>
					</form>
					@endsection
					
				

