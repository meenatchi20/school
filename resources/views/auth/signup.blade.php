
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
                
                <!-- <div class="selectDepartment">
                        <label for="role">User Role :</label>
                        <select id="role" name="role" class="selectRole">
                            <option value="" disabled selected hidden>Select Role</option>
                            <option value="SuperAdmin"  {{old('role') == 'SuperAdmin' ? 'selected' : ''}}>SuperAdmin
                            </option>
                            <option value="Admin"  {{old('role') == 'Admin' ? 'selected' : ''}}>Admin</option>
                            <option value="User" {{old('role') == 'User' ? 'selected' : ''}}>User</option>
                            <option value="Manager" {{old('role') == 'Manager' ? 'selected' : ''}}>Manager</option>
                            
                        </select>
                    </div> -->

                 <div class="selectDepartment">
                         <label for="role_id">User Role :</label>
                        <select id="role_id" name="role_id" class="selectRole">
                            <option value="" disabled selected hidden>Select Role</option>
                            <option value="1"  {{old('role_id') == 1 ? 'selected' : ''}}>SuperAdmin</option>
                            <option value="2"  {{old('role_id') == 2 ? 'selected' : ''}}>Admin</option>
                             <option value="3" {{old('role_id') == 3 ? 'selected' : ''}}>Manager</option>
                             <option value="4" {{old('role_id') == 4 ? 'selected' : ''}}>User</option>
                            
                         </select>
                     </div>    
                    <div class="signupBack">
                    <button type="submit" class="signUp">SignUp</button>
                    <a class="BackLogin" href="{{route('user.login')}}">Back</a>
                    </div>
            </form>
        </div>
 @endsection
