<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>StudentMark List</title>
	<link rel="stylesheet" href="/css/student_list_style.css">
   
</head>
<body onload="fetchStudentMark(1)">
				<h1 style="margin-bottom:40px;">StudentMark Detail</h1>	
    				<div class="button-container">
    					<a class="studentList" href="/apistudentlist">Student List</a>
    				</div>	
			<table>
				<tr>		
					<th rowspan="2">Student ID</th>
					<th rowspan="2">StudentName</th>
					<th rowspan="2">DepartmentName</th>
					<th colspan="7">Subject</th>
					<th rowspan="2">Total</th>
					<th rowspan="2">Average</th>
				</tr>
				<tr>
					<th>Tamil</th>
					<th>English</th>
					<th>Maths</th>
					<th>Physics</th>
					<th>Chemistry</th>
					<th>Botany</th>
					<th>Zoology</th>
				</tr>
				<tbody id="studentMark"></tbody>
			</table>
	<!-- Pagination -->
	<div id="paginateButton" class="pagination"></div>
	
	<!-- Subject Total and Average -->
	<div class="subjects">
	   	<div class="subject-block">
	 		<h1>Subject Total</h1>
     		<div id="subject"></div>
 		</div>
 		<div class="subject-block">
    		 <h1>Subject Average</h1>
     		<div id="subjectAvg"></div>
		</div>
    </div> 
			<script>
				let token = localStorage.getItem('auth_token');
				let current_page = 1;
				function fetchStudentMark(page){
					let studentMark = new XMLHttpRequest();
					studentMark.open("GET",`http://127.0.0.1:8000/api/studentMark?page=${page}`,true);
					studentMark.setRequestHeader('Authorization','Bearer '+ token)
					studentMark.setRequestHeader('Accept','application/json');

					studentMark.onload = function(){
						if(studentMark.status === 200){
							let studentMarkResponse = JSON.parse(studentMark.responseText);
							let data = studentMarkResponse.data;
							let meta = data.students;
							console.log(data);
							let student = data.students.data;
							//  student.forEach(mark => {
							// 	console.log(mark.mark.Tamil);
							// });
							studentMarkData(student);
							subject(data);
							avgSubject(data);
							pagination(meta)

						}else if(studentMark.status === 403){
							let studentMarkResponse = JSON.parse(studentMark.responseText);
							alert(studentMarkResponse.message);
						}
					}
					studentMark.send();
			}		

				function studentMarkData(student) {
					let tbody = document.getElementById('studentMark');
					tbody.innerHTML = '';

					student.forEach(studentMarkList => {
						let rowData = document.createElement('tr');
						rowData.innerHTML = `
							<td>${studentMarkList.id}</td>
							<td>${studentMarkList.first_name}</td>
							<td>${studentMarkList.department.department_name}</td>
							<td>${studentMarkList.mark.Tamil}</td>
							<td>${studentMarkList.mark.English}</td>
							<td>${studentMarkList.mark.Maths}</td>
							<td>${studentMarkList.mark.Physics}</td>
							<td>${studentMarkList.mark.Chemistry}</td>
							<td>${studentMarkList.mark.Botany}</td>
							<td>${studentMarkList.mark.Zoology}</td>
							<td>${studentMarkList.total}</td>
						    <td>${studentMarkList.average}</td>
						`;						
						tbody.appendChild(rowData);
					})					
				}

				function subject(data){
					let x = document.getElementById('subject');
					x.innerHTML ='';
					let subjectTotal = data.subjectTotals;
					console.log(subjectTotal);
					let element = document.createElement('h3');
					for(let x in subjectTotal){
						element.innerHTML += x + ":" + subjectTotal[x] + "<br>";
					}
					x.appendChild(element);

				}

				function avgSubject(data){
					let averageSubjects = document.getElementById('subjectAvg');
					averageSubjects.innerHTML ='';
					let subjectTotal = data.averageSubject;
					console.log(subjectTotal);
					let element = document.createElement('h3');
					for(let x in subjectTotal){
						element.innerHTML += x + ":" + subjectTotal[x] + "<br>";
					}
					averageSubjects.appendChild(element);

				}

				//Pagination
		 		 function pagination(meta){
				  		let pagination = document.getElementById('paginateButton');
				  		pagination.innerHTML = "";
				  		for(let i = 1; i <= meta.last_page; i++){
					  		let paginateBtn = document.createElement('button');
					  		paginateBtn.classList.add('paginateBtn');
					  		paginateBtn.textContent = i;

					  		if(i === meta.current_page){
					  			paginateBtn.disabled = true;
					  		}
					  		paginateBtn.onclick = () => fetchStudentMark(i);

					  		pagination.appendChild(paginateBtn);
					 }
				}	  		

			</script>
</body>
</html>