
@if(session('success'))
    <script>
        alert("{{ session('success') }}");
    </script>
@endif
@extends('layout.app')
@section('loginStyle')
    <link rel="stylesheet" href="{{asset('css/login_style.css')}}">
@endsection  
    @section('main')
        <div class="login-container">
            <h1>Login</h1>
            <form action="{{route('authprocess.process')}}" method="POST" >
                @csrf
                <label for="user_name">UserName:</label>
                <input type="text" id="user_name" name="user_name" placeholder="Enter Your Name">
                @if($errors->has('user_name'))
                <span>{{$errors->first('user_name')}}</span>
                 @endif

                <label for="user_password">UserPassword:</label>
                <input type="password" id="user_password" name="user_password" placeholder="Enter Your Password">
                @if($errors->has('user_password'))
                <span>{{$errors->first('user_password')}}</span>
                 @endif

                <button>Login</button>
                <div class="actions">
                    <a href="">Forget Password</a>
                    <a href="{{route('user.signup')}}">SignUp</a>
                </div>
            </form> 
        </div>
    @endsection
