<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="/css/student_list_style.css">
	<title>ToDo List</title>
</head>
<body>
		<div class="button-container">
    		<a class="studentList" href="/apistudentlist">Student List</a>
    	</div>	
    	
		<h1>ToDo List</h1>
		<table style="width:60%;">
			<thead>
				<tr>
					<th>Student Id</th>
					<th>Action</th>
					<th>Maker_by</th>
					<th>Maker_at</th>
					<th>Actions</th>					
				</tr>
			</thead>
			
			<tbody id="listBody"></tbody>	
		</table>

		<script>
				let token = localStorage.getItem('auth_token');
				let tbody = document.getElementById('listBody');
				document.addEventListener('DOMContentLoaded',function(){
					let response = new XMLHttpRequest();
					response.open('GET','http://127.0.0.1:8000/api/todoList',true);
					response.setRequestHeader('Accept','application/json');
					response.setRequestHeader('Authorization','Bearer ' + token);

					response.onload = function(){
						if(response.status === 200){
						let responseData = JSON.parse(response.responseText);
						let data = responseData.data;
						data.forEach(list => {
							let row = document.createElement('tr');
							row.innerHTML += `
								<td>${list.student_id}</td>
								<td>${list.action}</td>
								<td>${list.maker_by}</td>
								<td>${list.maker_at}</td>
								<td><button onclick="approve(${list.student_id})">Approval</button>
								<button onclick="reject(${list.student_id})">Reject</button></td>
							`
							tbody.appendChild(row);
						});
				}
					}

					response.send();
				});


				// Approve button handler
                 function approve(id) {
           			 const xhr = new XMLHttpRequest();
            		 xhr.open('POST', `http://127.0.0.1:8000/api/students/approve/${id}`, true);
            		 xhr.setRequestHeader('Content-Type', 'application/json');
            		 xhr.setRequestHeader('Authorization', 'Bearer ' + localStorage.getItem('auth_token'));
            		 xhr.onload = function () {
		                if (xhr.status === 200) {
		                	let successRes = JSON.parse(xhr.responseText);
		                	let response = successRes.message;
		                    alert(response);
		                    location.reload(); // reload list
		                } else if(xhr.status === 400) {
		                    let errRes = JSON.parse(xhr.responseText);
		                	let response = errRes.message;
		                    alert(response);
		                }
            		};
            		xhr.send();
       			 }

       			 // Approve button handler
                 function reject(id) {
           			 const xhr = new XMLHttpRequest();
            		 xhr.open('POST', `http://127.0.0.1:8000/api/students/reject/${id}`, true);
            		 xhr.setRequestHeader('Content-Type', 'application/json');
            		 xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            		 xhr.onload = function () {
		                if (xhr.status === 200) {
		                    alert('Student request rejected! Please Check Mail');
		                    location.reload(); // reload list
		                } else if(xhr.status === 422) {
		                   let responseErr = JSON.parse(xhr.responseText);
		                   let error = responseErr.error;
		                   alert(error);
		                }
            		};
            		xhr.send();
       			 }

		</script>
</body>
</html>