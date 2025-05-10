
@extends('layout.app')
@section('loginStyle')
    <link rel="stylesheet" href="{{asset('css/login_style.css')}}">
@endsection  
@section('main')
           
        <div class="signup-container ">
            <h1>SignUp</h1>
            
            <form action="{{route('signup.process')}}" method="POST">
                @csrf
                <label for="name">UserName</label>
                <input type="text" id="name" name="name" placeholder="Enter Your Name" value="{{old('name')}}">
                @if($errors->has('name'))
							<span>{{$errors->first('name')}}</span>
				@endif

                <label for="mobileNo">Mobile Number</label>
                <input type="tel" id="mobileNo" name="mobileNo" placeholder="Enter Your Mobile Number" value="{{old('mobileNo')}}">
                @if($errors->has('mobileNo'))
							<span>{{$errors->first('mobileNo')}}</span>
				@endif

                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter Your Email" value="{{old('email')}}">
                @if($errors->has('email'))
							<span>{{$errors->first('email')}}</span>
				@endif

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter Your Password" value="{{old('password')}}">
                @if($errors->has('password'))
							<span>{{$errors->first('password')}}</span>
				@endif

                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" value="{{old('password_confirmation')}}" placeholder="Enter Your Confirm Password">
                @if($errors->has('password_confirmation'))
							<span>{{$errors->first('password_confirmation')}}</span>
				@endif
                
                    <button type="submit" class="signUp">SignUp</button>
                    <a class="BackLogin" href="{{route('user.login')}}">Back</a>
                  
            </form>
        </div>
 @endsection
