 @extends('layout.student_form')    
@section('style')
        <link rel="stylesheet" href="{{asset('css/contact_form.css')}}">
@endsection

<h1>RESET PASSWORD FORM</h1>

                <form action="{{route('submitresetpassword',['token' => $token])}}" method="POST" class="resetForm">
                 @csrf
                <input type="hidden" name="token" value="{{$token}}">    
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter Your Email">

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter Your Password">
                
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Enter Your Confirm Password">

               <input type="submit" value="Submit">                              