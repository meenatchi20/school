<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<link rel="stylesheet" href="/css/contact_form.css">
</head>
<body>
		<h1>Contact Page</h1>
		<form id="form" class="form" enctype="multipart/form-data">

			<label for="name">Name : </label>
			<input type="text" name="name" id="name"  placeholder="Enter Your FirstName">
			<span id="name_err"></span>

			<label for="email">Email : </label>
			<input type="email" name="email" id="email"  placeholder="Enter Your Email">
			<span id="email_err"></span>

			<label for="message">Message</label>
			<textarea name="message" id="message" rows="4" column="5"></textarea>
			<span id="message_err"></span>

			<input type="file" name="file" id="file" multiple>
			<span id="file_err"></span>

			<div class="submit">
				<input type="submit" value="submit">
				<a  class="employeeData" href="/apistudentlist">Back</a>
			</div>
		</form>

		<script>

				function validation(){
					let isValid = true;

					let name = document.getElementById('name').value;
					let email = document.getElementById('email').value;
					let message = document.getElementById('message').value;
					let file = document.getElementById('file').value;

					let name_err = document.getElementById('name_err');
					let email_err = document.getElementById('email_err');
					let message_err = document.getElementById('message_err');
					let file_err = document.getElementById('file_err');

					//Name Field
					if(name === ''){
						name_err.innerHTML = 'Please Enter Your Name';
						isValid = false;
					}else{
						name_err.innerHTML = '';
					}
					//Email Validation 
		            const emailval = /^([a-zA-Z0-9._]+)@([a-zA-Z0-9]+)\.([a-zA-Z]{2,10})$/;
		                if(email === ''){
		                    email_err.innerHTML = "Email Field is Required";
		                    isValid = false;
		                }else if(!emailval.test(email)){
		                    email_err.innerHTML =" InValid Email";
		                    isValid = false;
		                }else{
		                   email_err.innerHTML = "";
		                }

		            //Message Field
					if (message === '') {
						message_err.textContent = 'Please enter a message';
						isValid = false;
					}else{
						message_err.textContent  = '';
					}
					//File Validation
					if(!file || file.files.length === 0){
                    	file_err.innerHTML = 'The student file field is required.';
                    	isValid = false;
                    }
                    else{
                    	file_err.innerHTML = '';
                    }

					return isValid;
					
				}

				let token = localStorage.getItem('auth_token');
				document.getElementById('form').addEventListener('submit',function(e){
					e.preventDefault();

					if(!validation()){
						return;
					}

				let formValue = new FormData(this);

				let mailResponse = new XMLHttpRequest();
				mailResponse.open('POST','http://127.0.0.1:8000/api/sendemail',true);
				mailResponse.setRequestHeader('Authorization','Bearer ' + token);
				mailResponse.setRequestHeader('Accept','application/json');

				if(!token){
		            alert('Token has been Expired! Please Login Again');
		        }

				mailResponse.onload = function(){
					if(mailResponse.status === 200){
						let messageData = JSON.parse(mailResponse.responseText);
						alert(messageData.message);
						document.getElementById('form').reset();						
					}else if(mailResponse.status === 422){
						let errResponse = JSON.parse(mailResponse.responseText);
							if(errResponse.errors){
								for(let keyErr in errResponse.errors){
									let errValue = document.getElementById(`${keyErr}_err`);
										if(errValue){
											errValue.innerHTML = errResponse.errors[keyErr];
										}
								}
							} 

					}else{
						alert('Uploaded Failed');
					}
				}

				mailResponse.send(formValue);
				})
		</script>
</body>
</html>

					
                        
						



