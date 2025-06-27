<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<link rel="stylesheet" href="/css/student_list_style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<body>

	<!-- Header Section -->
	<header>
			<div class="header">
		      	<div class="employee">    		     
		        	<a class="addEmployee" href="/addstudent" id="createData">Add Students</a>
		    		<a class="employeeData" href="/apistudentlist"> Students List</a>
		    		<a href="/apistudentmark" class="studentMarkList">StudentMarkList</a>
		    		<a href="/apicontactmail" class="ContactPage" id="mail">Contact Page</a>
		    		<a href="/assignpermission" id="roleMenuPermission" class="addEmployee">Role Permission</a>
		    		<a href="/apimenu" class="addEmployee" id="menuPermission">Menu</a>
		    		<a href="/apirole" class="addEmployee" id="rolePermission">Role</a>
		    		<a href="/todolist" class="addEmployee" >TodoList</a>
		    		<a href="/approved/list" class="addEmployee">Approved List</a>
		    	</div>
		    	<button type="button" onclick="logOut()" class="logout">Logout</button>
			</div>
	</header>

	<!-- Search Section -->
			<h1>Student Data</h1>
			<form id="formSubmit">
			<div class="searchForm">
			<input type="search" name="search_firstname" id="search_firstname" placeholder="Enter Your FirstName">	
			<input type="search" name="search_lastname" id="search_lastname" placeholder="Enter Your LastName">
			<input type="search" name="search_email" id="search_email" placeholder="Enter Your Email">

			<!-- Search Department Data -->
			<div class="department-wrapper">
              	<label for="toggleDepartment" class="departmentlabel-toggle form-control">
                	Select Department
            	</label>
            	<input type="checkbox" id="toggleDepartment" class="hiddendepartment-checkbox">
            	<div class="departmentToggle-content">	
					<select id="department_id" name="department_id[]" multiple>
						<option value="1">Biology</option>
						<option value="2">Commerce</option>
						<option value="3">Computer Science</option>
						<option value="4">History</option>
						<option value="5">Science</option>
						<option value="6">Accounts</option>
					</select>
			 	</div>
    		</div>
    		<!-- Search Subject Data -->
    <div class="subject-wrapper">
            	<label for="toggleSubject" class="label-toggle form-control">
                 	Select Subject
            	</label>
            <input type="checkbox" id="toggleSubject" class="hidden-checkbox">
            <div class="toggle-content">
                <ul id="subject">                 
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

			<button type="submit" class="search" id="search">Search</button>
			<a href="/apistudentlist" class="clear">Clear</a>	
			</div>	

			 <!-- Pdf Download -->
			<div class="download-section">
                    <button type="submit" name="Pdf" value="Pdf" class="downloadpdf" id="downloadpdf"><i class="fa-solid fa-download"></i>DownLoadPdf</button>
                <div class="excelBtn" id="excel">                  
                   <button type="button"  class="excelReport" onclick="exportInitiated()" >Initiated Report Download</button>
                   <span id="open" class="openIcon"><i class="fa-solid fa-circle-info"></i></span>
                </div>       
            </div>
        </form>    

			<!-- Import StudentData And StudentMark -->
			<div class="importSection">
                <form class="importFileForm" enctype="multipart/form-data" id="importFileForm">                   
                    <input type="file" name="student_file" id="student_file" class="importStudentFile">
                    <span id="student_file_err"></span>
                    <button type="submit" id="mark" class="import" name="import" value="ImportMark">ImportMark</button>
                    <button type="submit" id="data" class="import" value="importData" name="import">importData</button> 
                </form>                
            </div>

	<!-- StudentList Table -->
			<table>
				<thead>
					<tr>
						<th>ID</th>
						<th>FirstName</th>
						<th>LastName</th>
						<th>Email</th>
						<th>PhoneNo</th>
						<th>Age</th>
						<th>Department</th>
						<th>Subject</th>
						<th class="action">Action</th>
					</tr>
				</thead>
				<tbody id="studentTableBody"></tbody>
			</table>

		<!-- Pagination -->
		<div id="paginateButton" class="pagination"></div>	

		<!-- Show Excel Export Status -->
		<div class="wrapper-modal" id="modal">
            <div class="container">
                <i class="fa-solid fa-xmark close" id="cancelbtn"></i>
                    <h1>Initiated Report</h1>
                        <table>
                            <tr>
                                <th>ID</th>
                                <th>UserName</th>
                                <th>FileName</th>
                                <th>Status</th>
                                <th>Initiated_at</th>
                                <th>Completed_at</th>
                                <th>Download</th>
                            </tr>

                    <tbody id="excelExportTable"></tbody>       
                               
                    </table>
            </div>
        </div>


		<!-- Footer Section -->
		<footer>
		  		<a href="" class="footerText">@CopyRight UnfieldUX.com All rights reserved.2024 </a>
    			<div class="social-icon">
			        <i class="fa-brands fa-twitter"></i>
			        <i class="fa-brands fa-facebook"></i>
			        <i class="fa-brands fa-youtube"></i>
			        <i class="fa-brands fa-google"></i>
    			</div>
		  </footer>


		  <script src="/script/student.js"></script>
		  
		</body>
</html>
