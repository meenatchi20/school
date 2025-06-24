<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Student Registration</title>
	<link rel="stylesheet" href="css/form_style.css">
</head>
<body>
			            <h1>Student Registration</h1>
						<form class="form" id="studentRegister">
                       
						<label for="first_name">FirstName : </label>
						<input type="text" name="first_name" id="first_name"  placeholder="Enter Your FirstName">
						<span id ="first_name_err" ></span>	

						<label for="last_name">LastName : </label>
						<input type="text" name="last_name" id="last_name"  placeholder="Enter Your LastName">
						<span id ="last_name_err" ></span>	

						<label for="email">Email : </label>
						<input type="email" name="email" id="email" placeholder="Enter Your Email">
						<span id ="email_err" ></span>	

						<label for="phone_no">Phone Number : </label>
						<input type="number" name="phone_no" id="phone_no" placeholder="Enter Your PhoneNo">
						<span id ="phone_no_err" ></span>	

						<label for="age">Age : </label>
						<input type="number" name="age" id="age" placeholder="Enter Your Age">
						<span id ="age_err" ></span>

						<div class="selectDepartment">
						<label for="department_id">Department :</label>
						<select id="department_id" name="department_id">
							<option value="" disabled selected hidden>Select Department</option>
							<option value="1">Biology</option>
							<option value="2">Commerce</option>
							<option value="3">Computer Science</option>
							<option value="4">History</option>
							<option value="5">Science</option>
							<option value="6">Accounts</option>
						</select>
					</div>
					<span id ="department_id_err" ></span>

					<div>
						<label for="toggleVendors" class="label-toggle form-control">
						  click here
						</label>
						<input type="checkbox" id="toggleVendors"  class="hidden-checkbox">
						<div class="toggle-content">
						  <ul>
							<li><input type="checkbox"  name="subject_name[]" id="subject_1" value="1"
							/>Tamil</li>
							<li><input type="checkbox" name="subject_name[]" id="subject_2" value="2" 
							/>English</li>
							<li><input type="checkbox" name="subject_name[]" id="subject_3" value="3"
							/>Math</li>
							<li><input type="checkbox" name="subject_name[]" id="subject_4" value="4"
							/>Physics</li>
							<li><input type="checkbox" name="subject_name[]" id="subject_5" value="5"
							/>Chemistry</li>							
							<li><input type="checkbox" name="subject_name[]" id="subject_7" value="7"
							/>Botany</li>
							<li><input type="checkbox" name="subject_name[]" id="subject_8" value="8"
							/>Zoology</li>
						  </ul>
						</div>
					</div>
					<span id ="subject_name_err" ></span>
					  
						<div class="subBtn">
						<input type="submit" name="submit" value="submit">
						<input type="reset" name="reset" value="Reset">
						</div>
					</form>

					<script>

						function validation(){

		                    let isValid = true;
		                    let firstName = document.getElementById('first_name').value.trim();
		                    let lastName = document.getElementById('last_name').value.trim();
		                    let email = document.getElementById('email').value.trim();
		                    let phone = document.getElementById('phone_no').value.trim();
		                    let age = document.getElementById('age').value.trim();
		                    let department = document.getElementById('department_id').value;
		                    let subject = document.getElementById('subject_name');

		                    //Error Message
		                    let fnameErr = document.getElementById('first_name_err');
		                    let lnameErr = document.getElementById('last_name_err');
		                    let emailErr = document.getElementById('email_err');
		                    let phoneErr = document.getElementById('phone_no_err');
		                    let ageErr = document.getElementById('age_err');
		                    let departmentErr = document.getElementById('department_id_err');
		                    let subjectErr = document.getElementById('subject_name_err');

		                     //FirstName Validation
		                    if(firstName === ''){
		                        fnameErr.innerHTML = "FirstName Field is Required";
		                        isValid = false;
		                    }else{
		                        fnameErr.innerHTML = "";
		                    }
		                    //LastName Validation
		                    if(lastName === ''){
		                        lnameErr.innerHTML = "LastName Field is Required";
		                        isValid = false;
		                    }else{
		                        lnameErr.innerHTML = "";
		                    }

		                    //Mobile Validation
		                    const mobilePattern = /^\d{10}$/;
		                    if(phone === ""){
		                        phoneErr.innerHTML = "Mobile Field is required";
		                         isValid = false;
		                    }else if(!mobilePattern.test(phone)){
		                        phoneErr.innerHTML = "Mobile Number  Must Contain 10 Digits";
		                        isValid = false;
		                    }else{
		                        phoneErr.innerHTML = "";
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

		                    //Age Validation
		                    if(age === ''){
		                    	ageErr.innerHTML = "Age Field Is Required";
		                    	isValid = false;
		                    }else{
		                    	ageErr.innerHTML = "";
		                    }

		                    //Department Validation
		                    if(department === ''){
		                    	departmentErr.innerHTML = "Department Field Is Required";
		                    	isValid = false;
		                    }

		                    return isValid;

		             }


							let token = localStorage.getItem('auth_token');
							document.getElementById('studentRegister').addEventListener('submit', function(e){
								e.preventDefault();

								if(!validation()){
									return;
								}

								let data = this;
								let formdata = new FormData(data);
								
								let studentData = new XMLHttpRequest();
								studentData.open("POST",'http://127.0.0.1:8000/api/store',true);
								studentData.setRequestHeader('Authorization','Bearer ' + token);
								studentData.setRequestHeader('Accept','application/json');
								//studentData.setRequestHeader('Content-Type','application/json');

								studentData.onload = function(){
									if(studentData.status === 200) {
										alert('StudentData Add successfully')                
                                        window.location.href = '/apistudentlist';
									}else if(studentData.status === 422){
										let data = JSON.parse(studentData.responseText);
										if(data.errors){
											for(let keyErr in data.errors){
											let errValue = document.getElementById(`${keyErr}_err`);
											if(errValue){
												errValue.innerHTML = data.errors[keyErr];
											}
										}
									}
								}else if(studentData.status === 403){
									let data = JSON.parse(studentData.responseText);
									alert(data.message);									
								}
								studentData.send(formdata);
								}
							})
					</script>
</body>
</html>                      

                        