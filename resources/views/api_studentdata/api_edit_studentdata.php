<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit StudentData</title>
	<link rel="stylesheet" href="/css/form_style.css">
</head>
<body onload="editStudentData()">
		        <h1>Student Registration</h1>
                <form class="form" id="editForm">              
                   
                <label for="first_name">FirstName : </label>
                <input type="text" name="first_name" id="first_name" value="" placeholder="Enter Your FirstName"><br>
                <span id ="first_name_err"></span>	

                <label for="last_name">LastName : </label>
                <input type="text" name="last_name" id="last_name" value="" placeholder="Enter Your LastName"><span id ="last_name_err"></span>	
                

                <label for="email">Email : </label>
                <input type="email" name="email" id="email" value="" placeholder="Enter Your Email">
               	<span id ="email_err"></span>

                <label for="phone_no">Phone Number : </label>
                <input type="number" name="phone_no" id="phone_no" value="" placeholder="Enter Your PhoneNo">
                <span id ="phone_no_err"></span>
						

                <label for="age">Age : </label>
                <input type="number" name="age" id="age" value="" placeholder="Enter Your Age">
                <span id ="age_err"></span>

              <div class="selectDepartment">
                <label for="age">Department :</label>
                <select id="department_id" name="department_id">
                  <option value="" disabled> Select Department</option>
                  <option value="1">Biology</option>
                  <option value="2">Commerce</option>
                  <option value="3">Computer Science</option>
                  <option value="4">History</option>
                  <option value="5">Science</option>
                  <option value="6">Accounts</option>
                </select>
              </div>
              <span id ="department_id_err"></span>


              <div>
                <label for="toggleVendors" class="label-toggle form-control">
                  click here
                </label>
                <input type="checkbox" id="toggleVendors"  class="hidden-checkbox">
                <div class="toggle-content">
                  <ul>
                  <li><input type="checkbox"  name="subject_name[]" id="subject_1" value="1">Tamil</li>
                  <li><input type="checkbox" name="subject_name[]" id="subject_2" value="2">English</li>
                  <li><input type="checkbox" name="subject_name[]" id="subject_3" value="3">Math</li>
                  <li><input type="checkbox" name="subject_name[]" id="subject_4" value="4">Physics</li>
                  <li><input type="checkbox" name="subject_name[]" id="subject_5" value="5">Chemistry</li>
                  <li><input type="checkbox" name="subject_name[]" id="subject_7" value="7">Botany</li>
                  <li><input type="checkbox" name="subject_name[]" id="subject_8" value="8">Zoology</li>
                  </ul>
                </div>
                </div>
                <span id ="subject_name_err"></span>

                <div class="subBtn">
                <input type="submit" name="submit" value="Update">
                <!-- {{-- <a  class="employeeData"href="{{route('employee.table')}}">Back</a> --}} -->
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
            		//Get Id In the Url
            		function getId(){           		  
            			const pathSegments = window.location.pathname.split('/');
									const id = pathSegments[pathSegments.length - 1]; // "40"
									return id;
									console.log(id);
            	 	}

            		function editStudentData(){
            		    let token = localStorage.getItem('auth_token');
            				let id = getId();
            				console.log(id);

            		let editData = new XMLHttpRequest();
            		editData.open("GET",`http://127.0.0.1:8000/api/edit/${id}`,true);
            		editData.setRequestHeader('Authorization' , 'Bearer ' + token);
		    	    	editData.setRequestHeader('Accept','application/json')

		    	    editData.onload = function () {
		    	    		if (editData.status === 200) {
        						let student = JSON.parse(editData.responseText);
        						let data = student.data;
        					console.log(student);
        					
					        document.getElementById('first_name').value = data.first_name || '';
					        document.getElementById('last_name').value = data.last_name || '';
					        document.getElementById('email').value = data.email || '';
					        document.getElementById('phone_no').value = data.phone_no || '';
					        document.getElementById('age').value = data.age || '';
					        document.getElementById('department_id').value = data.department_id || '';

					    
					      	console.log('Subject',data.subject);
							  data.subject.forEach(subjects => {
							    let checkbox = document.querySelector(`input[name="subject_name[]"][value="${subjects.id}"]`);
									    if (checkbox) {
									      checkbox.checked = true;
									    }
							  });						

        				}else if(editData.status === 403){
        						alert('You are not authorized to perform this action.');
        						window.location.href = '/apistudentlist';
        				}
		    	    };

		    	    editData.send(); 
            	}

            		document.getElementById('editForm').addEventListener('submit',function(e){
            			e.preventDefault();
            		//debugger;
            		
            		if(!validation()){
            			return;
            		}	

            		let token = localStorage.getItem('auth_token');
            		let formValue = new FormData(this);            	
            		let id = getId(); //Get Id in Url

            		let updateData = new XMLHttpRequest();
            		updateData.open("POST",`http://127.0.0.1:8000/api/update/${id}`,true);
            		updateData.setRequestHeader('Authorization' , 'Bearer ' + token);
            		updateData.setRequestHeader('Accept','application/json');
            		updateData.setRequestHeader('X-HTTP-Method_Override','PUT')

            		updateData.onload = function() {
            		     if(updateData.status === 200){
            						let response = JSON.parse(updateData.responseText);
            						console.log(response);
            						alert("Updated Successfully");
            						window.location.href = '/apistudentlist';
            				} 
            				else if(updateData.status === 422){
												let errResponse = JSON.parse(updateData.responseText);
														if(errResponse.errors){
																for(let keyErr in errResponse.errors){
																			let errValue = document.getElementById(`${keyErr}_err`);
																					if(errValue){
																							errValue.innerHTML = errResponse.errors[keyErr];
																					}
																}
													}           			
            			 }
            			else{
            				alert('Uploaded Failed')
            			}
            	}
            		updateData.send(formValue);

            		});
            </script>
</body>
</html>