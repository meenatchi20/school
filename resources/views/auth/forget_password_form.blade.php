@extends('layout.student_form')	
@section('style')
		<link rel="stylesheet" href="{{asset('css/contact_form.css')}}">
@endsection

	<h1>Forget Password</h1>
	@if(session('success'))
		<div class="successMsg">{{session('success')}}</div>
   @endif
<form action="forgetpassword" method="Post" class="forgetForm">
	@csrf
		<label for="email">Email</label>
		<input type="email" name="email" id="email" placeholder="enter your email">
		@if($errors->has('email'))
			<span>{{$errors->first('email')}}</span>
		@endif
		<input type="submit" value="submit">
</form>