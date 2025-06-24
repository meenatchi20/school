<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/login_style.css">
	<title>Menu</title>
</head>
<body>
		<div class="login-container">
			<p id="menuMsg" style="color: green; text-align: center;"></p>
			<h1>Create Menu</h1>
				<form id="loginForm">
					<label for="menu_name">Menu</label>
					<input type="text" name="menu_name" id="menu_name" placeholder="Create a Menu">
					<span id="menu_name_err"></span>
					<div class="signupBack">
					<input type="submit" name="submit" value="Create" class="submit">
					<a class="reset" href="/apistudentlist">Student List</a>
				</div>
				</form>
		</div>
		<script>
				let token = localStorage.getItem('auth_token');
				document.getElementById('loginForm').addEventListener('submit',function(event){
					event.preventDefault();
				let formValue = new FormData(this);
				let response = new XMLHttpRequest();
				response.open('POST','http://127.0.0.1:8000/api/create/menu',true);
				response.setRequestHeader('Accept','application/json');
				response.setRequestHeader('Authorization','Bearer ' + token);

				response.onload = function(){
					if(response.status === 200){
						let successMeg = JSON.parse(response.responseText);
						let success = successMeg.message;
						document.getElementById('menuMsg').style.color = 'green';
						document.getElementById('menuMsg').innerHTML = success;
						//window.location.href = "/apistudentlist"
					}else if(response.status === 403){
						let errResponse = JSON.parse(response.responseText);
						let responseErr = errResponse.error;
						document.getElementById('menuMsg').style.color = 'red';
						document.getElementById('menuMsg').innerHTML = responseErr;
					}
					else{
						let errMeg = JSON.parse(response.responseText);
						if(errMeg.errors){
							for(let keyErr in errMeg.errors){
								let errValue = document.getElementById(`${keyErr}_err`);
								if(errValue){
									errValue.innerHTML = errMeg.errors[keyErr];
								}
							}
						}
					}
				}
				response.send(formValue);
				});
		</script>
</body>
</html>