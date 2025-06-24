<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>ForgetPassword</title>
	<link rel="stylesheet" href="css/contact_form.css">
</head>
<body>
			<span id="email_msg"></span>
			<form class="forgetForm" id="forgetForm">
		         <label for="email">Email</label>
		         <input type="email" name="email" id="email" placeholder="enter your email">
		         
		         <input type="submit" value="submit">
            </form>

            <script>
            		document.getElementById('forgetForm').addEventListener('submit', function(e){
            			e.preventDefault();

            		let email = document.getElementById('email_msg');
            		let form = new FormData(this);
            		let forgetRequest = new XMLHttpRequest();
            		forgetRequest.open('POST','http://127.0.0.1:8000/api/forgetpassword',true);

            		forgetRequest.onload = function(){

            			if(forgetRequest.status === 200){
            				let data = JSON.parse(forgetRequest.responseText);
            				
            				email.style.color = 'green';
            				email.style.textAlign = 'center';
            				email.innerHTML = data.message;
            				//alert(data.message)
            			}

            			
            		}
            		forgetRequest.send(form);
            		})
            </script>
</body>
</html>