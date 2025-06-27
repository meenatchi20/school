<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="/css/login_style.css">
	<title>Role</title>
</head>
<body onload="editRoleData()">

		<div class="login-container">
			<p id="roleMsg" style="color: green; text-align: center;"></p>
			<h1>Update Role</h1>
				<form id="loginForm">
					<label for="role">Role</label>
					<input type="text" name="role" id="role" placeholder="Create a Role">
					<span id="role_err"></span>
					<div class="signupBack">
					<input type="submit" name="submit" value="Update" class="submit">
					<a class="reset" href="/rolelist">Back</a>
				</div>
				</form>
		</div>
		<script>
				//Get Id In the Url
            		function getId(){           		  
            			const pathSegments = window.location.pathname.split('/');
									const id = pathSegments[pathSegments.length - 1];
									return id;
									console.log(id);
            	 	}

            		function editRoleData(){
            		    let token = localStorage.getItem('auth_token');
            				let id = getId();
            				console.log(id);

            		let editData = new XMLHttpRequest();
            		editData.open("GET",`http://127.0.0.1:8000/api/edit/role/${id}`,true);
            		editData.setRequestHeader('Authorization' , 'Bearer ' + token);
		    	    	editData.setRequestHeader('Accept','application/json')

		    	    editData.onload = function () {
		    	    		if (editData.status === 200) {
        						let student = JSON.parse(editData.responseText);
        						let data = student.data;
        					console.log(student);

        					document.getElementById('role').value = data.role;
        				}
        			}
        			editData.send();
        		}


        		document.getElementById('loginForm').addEventListener('submit',function(e){
            			e.preventDefault();
            		//debugger;
            		
            		let token = localStorage.getItem('auth_token');
            		let formValue = new FormData(this);            	
            		let id = getId(); //Get Id in Url

            		let updateData = new XMLHttpRequest();
            		updateData.open("POST",`http://127.0.0.1:8000/api/update/role/${id}`,true);
            		updateData.setRequestHeader('Authorization' , 'Bearer ' + token);
            		updateData.setRequestHeader('Accept','application/json');
            		updateData.setRequestHeader('X-HTTP-Method_Override','PUT')

            		updateData.onload = function() {
            		     if(updateData.status === 200){
            				let response = JSON.parse(updateData.responseText);
            				console.log(response);
            				alert("Updated Successfully");
            				window.location.href = '/rolelist';
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