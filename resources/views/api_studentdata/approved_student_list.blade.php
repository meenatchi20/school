<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="/css/student_list_style.css">
	<title>Approoved List</title>
</head>
<body>
		<div class="button-container">
    		<a class="studentList" href="/apistudentlist">Student List</a>
    	</div>	
    	
		<h1>Approved List</h1>
		<table style="width:60%;">
			<thead>
				<tr>

					<th>Student Id</th>
					<th>Action</th>
					<th>Maker_by</th>
					<th>Maker_at</th>
					<th>Approved_by</th>
					<th>Approved_at</th>					
				</tr>
			</thead>
			
			<tbody id="listBody"></tbody>	
		</table>

		<script>
				let token = localStorage.getItem('auth_token');
				let tbody = document.getElementById('listBody');
				document.addEventListener('DOMContentLoaded',function(){
					let response = new XMLHttpRequest();
					response.open('GET','http://127.0.0.1:8000/api/approvedstudent',true);
					response.setRequestHeader('Accept','application/json');
					response.setRequestHeader('Authorization','Bearer ' + token);

					response.onload = function(){
						if(response.status === 200){
						let responseData = JSON.parse(response.responseText);
						let data = responseData.data;
						data.forEach(list => {
							let row = document.createElement('tr');
							row.innerHTML += `
								
								<td>${list.temp_student_id}</td>
								<td>${list.action}</td>
								<td>${list.maker_by}</td>
								<td>${list.maker_at}</td>
								<td>${list.approved_by}</td>
								<td>${list.approved_at}</td>
							`
							tbody.appendChild(row);
						});
				}
					}

					response.send();
				});



		</script>
</body>
</html>