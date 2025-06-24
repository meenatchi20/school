<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/form_style.css">
	<title>Role Permission</title>
	<style>
		.errMeg {
			color: red;
		}
	</style>
</head>
<body>
		<h1>Role Permission</h1>
		<p id="permissionMsg" style="color: green; text-align: center;"></p>
		<form id="permission" class="form">
		<label>Select Role</label>
		<select id="role_id" name="role_id">
				<option value="" disabled selected hidden>Select Role</option>
				<option value="1">SuperAdmin</option>
				<option value="2">Admin</option>
				<option value="3">Manager</option>
				<option value="4">User</option>
		</select>
		<span id="role_id_err" class="errMeg"></span>
		<br>

		<label>Select Menu</label>
		<select id="menu_id" name="menu_id">
				<option value="" disabled selected hidden>Select Menu</option>
				<option value="1">Students Create</option>
				<option value="2">Students Update</option>
				<option value="3">Students DataImport</option>
				<option value="4">Students ExcelExport</option>
		</select>
		<span id="menu_id_err" class="errMeg"></span>
		<br>

		<div class="radioBtn">
			<label class="radioLabel">Select Permission</label>
		<div class="radioOption">
			<input type="radio" id="full_access" name="access" value="full_access">
			<label for="full_access" class="radioLabel">full_access</label>
		</div>
		<div class="radioOption">		
			<input type="radio" id="read_only_access" name="access" value="read_only_access">
			<label for="read_only_access" class="radioLabel">read_only_access</label>
		</div>
		<div class="radioOption">
			<input type="radio" id="hidden" name="access" value="hidden">
			<label for="hidden" class="radioLabel">hidden</label>
		</div>
	</div>

	<div class="subBtn">
		<input type="submit" name="submit">
		<input type="reset" name="Reset" value="Reset">
		<a href="apistudentlist" class="studentList">StudentList</a>
	</div>
		

		</form>
		<script>
				let token = localStorage.getItem('auth_token');
			document.getElementById('permission').addEventListener('submit', function(event){
				event.preventDefault();
				
				let selectedAccess = document.querySelector('input[name="access"]:checked');
				let formValue= {
					role_id:document.getElementById('role_id').value,
					menu_id:document.getElementById('menu_id').value,
					full_access:false,
                    read_only_access:false,
    				hidden:false
				}
				if(selectedAccess){
					formValue[selectedAccess.value] = true;
				}

				console.log(formValue);

				let http = new XMLHttpRequest();
				http.open('POST','http://127.0.0.1:8000/api/assign',true);
				http.setRequestHeader('Accept','application/json');
				http.setRequestHeader('Authorization','Bearer ' + token);
				http.setRequestHeader('Content-Type','application/json');

				http.onload = function(){
					if(http.status === 200){
						let response = JSON.parse(http.responseText);
						let res = response.message;
						document.getElementById('permissionMsg').style.color = 'green';
						document.getElementById('permissionMsg').innerHTML = res;
					
					}else if(http.status === 403){
						let response = JSON.parse(http.responseText);
						let responseErr = response.error;
						document.getElementById('permissionMsg').style.color = 'red';
						document.getElementById('permissionMsg').innerHTML = responseErr;
					}else if(http.status === 422){
						let response = JSON.parse(http.responseText);
						if(response.errors){
							for(let keyErr in response.errors){
								let errValue = document.getElementById(`${keyErr}_err`);
								if(errValue){
									errValue.innerHTML = response.errors[keyErr];
								}
							}
						}
					}
				
				}
				 
        http.send(JSON.stringify(formValue)); 

			});
		</script>
				
</body>
</html>
