<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login Page</title>
	<link rel="stylesheet" href="css/login_style.css">
</head>
<body>

          <div class="login-container">
			    <h1>Login</h1>			   
		  		<form id="loginForm">
		    		<label for="user_name">Username:</label> 
		    		<input type="text" name="user_name" id="user_name">
		    		<span id="user_name_err"></span>

		    		<label for="user_password">Password:</label> 
		    		<input type="password" name="user_password" id="user_password">
		    		<span id="user_password_err"></span>

		    		<button type="submit" class="login">Login</button>
		    		<div class="actions">
		    			<a href="/apiforgetpassword">Forget Password</a>
		    			<a href="/apisignup">SignUp</a>
		    		</div>
		        </form>
		    </div>
		<script>


			function validation(){

		                    let isValid = true;
		                    let userName = document.getElementById('user_name').value.trim();
		                    let password = document.getElementById('user_password').value.trim();
		                    
		                    let userNameErr = document.getElementById('user_name_err');
		                    let passwordErr = document.getElementById('user_password_err');

		                    //UserName Validation
		                    if(userName === ''){
		                        userNameErr.innerHTML = "UserName Field is Required";
		                        isValid = false;
		                    }else{
		                        userNameErr.innerHTML = "";
		                    }

				            //Password Validation
		                    if (password === '') {
							    passwordErr.innerHTML = "Password field is required";
							    isValid = false;
							} else if (password.length < 5) {
							    passwordErr.innerHTML = "Password must be at least 5 characters";
							    isValid = false;
							} else {
							    passwordErr.innerHTML = "";
							}

		                    return isValid;
		    }



		  	  let token = '';		
			  document.getElementById('loginForm').addEventListener('submit', function (e) {
		      e.preventDefault();

					if(!validation()){
					 return;
					}
		      
		      const formData = new FormData(this);
		      const params = new URLSearchParams(formData).toString();
		      const xhr = new XMLHttpRequest();
		      xhr.open('POST', 'http://127.0.0.1:8000/api/login', true);
		      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		      xhr.setRequestHeader('Accept','application/json'); 
		      xhr.withCredentials = true;

		       

		      xhr.onload = function () {
		      	
		        if (xhr.status === 200) {
		           const response = JSON.parse(xhr.responseText);
		           console.log(response);
                   token = response.token;   
                      
                  
                   if(!token) {
		           alert('Invalid User. Please signUp');
		           return;
		           } 

		          		localStorage.setItem('auth_token', token);// store it 		           
                  alert(response.message);

                  	//clear input Field After Succcessfull
                    document.getElementById('user_name').value = "";
					document.getElementById('user_password').value = ""; 

                  window.location.href = '/apistudentlist'; // redirect 

		        } else if(xhr.status === 422){
		        		let data = JSON.parse(xhr.responseText);
		        		
							if(data.errors){
								for(let keyErr in data.errors){
									let errValue = document.getElementById(`${keyErr}_err`);
									console.log(errValue);
									if(errValue){
										errValue.innerHTML = data.errors[keyErr];
									}									
								}
								
							}														
		          }else {
				    alert('Login failed. Please try again.');
			      }
		     	
		      };
		  
		       xhr.send(params);
		    });

	    </script>
	</body>
</html>
		  