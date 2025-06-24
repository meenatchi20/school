@if(session('success'))
    <script>
        alert("{{ session('success') }}");
    </script>
@endif


@extends('layout.student_form')	

@section('style')
	<link rel="stylesheet" href="{{asset('css/contact_form.css')}}">

@endsection	
		@section('content')
						<h1>Contact Page</h1>
						<form action="{{route('send.email')}}" method="POST" class="form" enctype="multipart/form-data">
                         @csrf
						<label for="name">Name : </label>
						<input type="text" name="name" id="name"  placeholder="Enter Your FirstName">
						@if($errors->has('name'))
							<span>{{$errors->first('name')}}</span>
						@endif

						<label for="email">Email : </label>
						<input type="email" name="email" id="email"  placeholder="Enter Your Email">
						@if($errors->has('email'))
							<span>{{$errors->first('email')}}</span>
						@endif

						<label for="message">Message</label>
						<textarea name="message" id="message" rows="4" column="5">
						</textarea>
						@if($errors->has('message'))
							<span>{{$errors->first('message')}}</span>
						@endif

						<input type="file" name="file" id="file" multiple>
						@if($errors->has('file'))
							<span>{{$errors->first('file')}}</span>
						@endif
						
						<div class="submit">
						<input type="submit" value="submit">
						<a  class="employeeData" href="{{route('student.list')}}">Back</a>
						</div>
		@endsection



