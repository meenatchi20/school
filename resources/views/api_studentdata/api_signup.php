<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SignUp Form</title>
    <link rel="stylesheet" href="/css/login_style.css">
</head>
<body>
                <div class="signup-container">
                <h1>SignUp Form</h1>
                <form id="signUpForm">             
                <label for="name">UserName</label>
                <input type="text" id="name" name="name" placeholder="Enter Your Name">
                <span id="name_err"></span>

                <label for="mobileNo">Mobile Number</label>
                <input type="tel" id="mobileNo" name="mobileNo" placeholder="Enter Your Mobile Number">
                 <span id="mobileNo_err"></span>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter Your Email">
                <span id="email_err"></span>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter Your Password">
                 <span id="password_err"></span>

                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation">
                 <span id="password_confirmation_err"></span>

                <div class="selectDepartment">
                        <label for="role_id">User Role :</label>
                        <select id="role_id" name="role_id" class="selectRole">
                            <option value="" disabled selected hidden>Select Role</option>
                            <option value="1">SuperAdmin</option>
                            <option value="2">Admin</option>                           
                            <option value="3">Manager</option>
                            <option value="4">User</option>
                            
                        </select>
                    </div>
                <span id="role_err"></span> 
                   
                    <div class="signupBack">
                    <button type="submit" class="signUp">SignUp</button>
                    <a class="BackLogin" href="/apilogin">Back</a>
                    </div>
            </form>
        </div>

        <script>

                function validation(){
                    let isValid = true;
                    let name = document.getElementById('name').value.trim();
                    let mobileNo = document.getElementById('mobileNo').value.trim();
                    let email = document.getElementById('email').value.trim();
                    let password = document.getElementById('password').value;
                    let password_confirmation = document.getElementById('password_confirmation').value;
                    let role = document.getElementById('role_id').value;

                    let fnameErr = document.getElementById('name_err');
                    let mobileErr = document.getElementById('mobileNo_err');
                    let emailErr = document.getElementById('email_err');
                    let passwordErr = document.getElementById('password_err');
                    let passwordConfirmErr = document.getElementById('password_confirmation_err');
                    let roleErr = document.getElementById('role_err');

                    //Name Validation
                    if(name === ''){
                        fnameErr.innerHTML = "name field is Required";
                        isValid = false;
                    }else{
                        fnameErr.innerHTML = "";
                    }

                    //Mobile Validation
                    const mobilePattern = /^\d{10}$/;
                    if(mobileNo === ""){
                        mobileErr.innerHTML = "Mobile Field is required";
                         isValid = false;
                    }else if(!mobilePattern.test(mobileNo)){
                        mobileErr.innerHTML = "Mobile Number  Must Contain 10 Digits";
                        isValid = false;
                    }else{
                        mobileErr.innerHTML = "";
                    }


                    //Email Validation 
                    const emailval = /^([a-zA-Z0-9._]+)@([a-zA-Z0-9]+)\.([a-zA-Z]{2,10})$/;
                    if(email === ''){
                        emailErr.innerHTML = "Email Field is Required";
                        isValid = false;
                    }else if(!emailval.test(email)){
                        emailErr.innerHTML =" InValid Email";
                        isValid = false;
                    }else{
                        emailErr.innerHTML = "";
                    }
                   
                   //Password Validation
                    if(password.length < 5){
                        passwordErr.innerHTML = "password Contain Minimum 5 Character";
                         isValid = false;
                    }else if(password === ''){
                         passwordErr.innerHTML = "Password Field is Required";
                          isValid = false;
                    }else if(password != password_confirmation){
                         passwordErr.innerHTML = "Password Does Not Match";
                          isValid = false;
                    }
                    else{
                        passwordErr.innerHTML ="";
                    }

                    //ConfirmPassword Validation
                    if(password_confirmation === ''){
                         passwordConfirmErr.innerHTML = "Password Field is Required";
                        isValid = false;
                     } else{
                        passwordConfirmErr.innerHTML = "";
                     }

                     //User Role Validation
                     if(role === ''){
                        roleErr.innerHTML = "User role Field is Required";
                        isValid = false;
                     }else{
                         roleErr.innerHTML ="";
                     }


                     return isValid;
                }

                document.getElementById('signUpForm').addEventListener('submit',function (e) {
                   e.preventDefault();
                   
                   if(!validation()){
                        return;
                    }

                let formData = new FormData(this);
                //let params = new URLSearchParams(formData).toString();

                let signup = new XMLHttpRequest();
                signup.open("POST",'http://127.0.0.1:8000/api/signup',true);
                // signup.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                signup.setRequestHeader('Accept','application/json'); 

                signup.onload = function() {
                        if(signup.status === 200){
                             let signUpResponse = JSON.parse(signup.responseText);
                             alert(signUpResponse.message)                
                             window.location.href = '/apilogin';
                        }else if(signup.status === 422){
                            let errResponse = JSON.parse(signup.responseText);
                            if(errResponse.errors){
                                for(let keyErr in errResponse.errors){
                                    let errorValue = document.getElementById(`${keyErr}_err`);
                                    if(errorValue){
                                        errorValue.innerHTML = errResponse.errors[keyErr];
                                    }
                                }
                            }
                        }
                }

                signup.send(formData);
                })
        </script>
</body>
</html>

                