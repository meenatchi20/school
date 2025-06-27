<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Role List</title>
	<link rel="stylesheet" href="/css/student_list_style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

		<div class="button-container">
    		<a class="studentList" href="/apistudentlist">Student List</a>
    	</div>	

		<h1>Role List</h1>
		<table style="width: 30%;">
			  <thead>
			  		<tr>
						<th>Id</th>
						<th>Role</th>
						<th>Action</th>
					</tr>
			  </thead>
			  <tbody id="roleBody"></tbody>
		</table>
		<script>
				let token = localStorage.getItem('auth_token');
				let tbody = document.getElementById('roleBody');
				document.addEventListener('DOMContentLoaded',function(){
					let httpRequest = new XMLHttpRequest();
					httpRequest.open('GET','http://127.0.0.1:8000/api/list/role',true);
					httpRequest.setRequestHeader('Accept','application/json');
					httpRequest.setRequestHeader('Authorization','Bearer ' + token);

					httpRequest.onload = function(){
						let httpResponse = JSON.parse(httpRequest.responseText);
						let responseData = httpResponse.data;
						responseData.forEach(data => {
							let row = document.createElement('tr');
							row.innerHTML += `
								<td>${data.id}</td>
								<td>${data.role}</td>
								
								<td>
								<div class="editDel">
								<a href="editrole/${data.id}" id="update"><i class='fa-solid fa-pencil' ></i></a>
								<button class="button" onclick="myFunction(${data.id})"><i class='fa-solid fa-trash'></i></button>
								</div>
								</td>  
								                            
							`
							tbody.appendChild(row);
						});
					}
					httpRequest.send();
				})


				//Delete MenuData
		  		function myFunction(id){
		  			let confirmation = confirm("Are You Sure You Want To Delete This Record?");
		  				if(confirmation){
		  					deleteRoleData(id);
		  				}
		  				else{
		  					window.location.href = '/rolelist';
		  				}
		  		}

		  		//Delete MenuData
		  	function deleteRoleData(id){
		  			let deleteRequest = new XMLHttpRequest();
		  			deleteRequest.open('DELETE',`http://127.0.0.1:8000/api/delete/role/${id}`,true)
		  			deleteRequest.setRequestHeader('Authorization' , 'Bearer ' + token);
		            deleteRequest.setRequestHeader('Accept','application/json');
		            	if(!token){
		            		alert('Token has been Expired! Please Login Again');
		            	}
		            deleteRequest.onload = function(){
		            	if(deleteRequest.status === 200){		            		
		            		alert("Role Deleted Sucessfully");

		            	}else if(deleteRequest.status === 403){
		            		let errResponse = JSON.parse(deleteRequest.responseText);
		            		let authErr = errResponse.message
		            		alert(authErr);
		            	}
		            	else if(deleteRequest.status === 422){
		            		let errResponse = JSON.parse(deleteRequest.responseText);
		            		//alert(errResponse.errors);
		            		console.log(errResponse.errors);
		            	}
		            }		       
		            deleteRequest.send();		           
		  	}
		</script>
</body>
</html>