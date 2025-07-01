
			//File Import Validation
		  	 function validation(){
                    let isValid = true;
                    let student_file = document.getElementById('student_file');
                    let student_file_err = document.getElementById('student_file_err');
                    	if(!student_file){
                    		student_file_err.innerHTML = 'The student file field is required.';
                    		isValid = false;
                    	}
                    	else{
                    		student_file_err.innerHTML = '';
                    	}
                    return isValid;
             }       

		  	//Token
		  	let token = localStorage.getItem('auth_token');
		  	let current_page = 1;
		  	let isSearching = false;

		  //Store StudentData
		 function fetchStudentList(page){ 			 	
			const http = new XMLHttpRequest();
		    http.open('GET', `http://127.0.0.1:8000/api/list?page=${page}`, true);
		    http.setRequestHeader('Authorization' , 'Bearer ' + token);
		    http.setRequestHeader('Accept','application/json'); 
		    	if(!token){
		    		alert('Token has been Expired! Please Login Again');
		    		window.location.href = '/apilogin';
                    return;
		    	}

		    http.onreadystatechange = function () {

		    	if(http.readyState === 4 && http.status === 401){
		      	//alert("Unauthorized");
		      	window.location.href = '/apilogin';
		      	}
		        else if (http.readyState === 4 && http.status === 200) {
		        try {		        	
			          const datas = JSON.parse(http.responseText);
			          const data = datas.data;
			          const meta = datas.meta;
			          const permission = datas.permission;
			          let create =  permission.create;
			          let update =  permission.update;
			          let deletedata =  permission.delete;
			          let pdf =  permission.pdf;
			          let importMark =  permission.importMark; 
			          let importData =  permission.importData;
			          let sendmail =  permission.sendMail;
			          let excelInitiate = permission.excelExport;
			          let user = permission.user;
			          let userPermission = document.getElementById('roleMenuPermission');
			          let userRolePermission = document.getElementById('rolePermission');
			          let userMenuPermission = document.getElementById('menuPermission');
						if(user !== 'SuperAdmin'){
							userPermission.style.display = 'none';
							userRolePermission.style.display = 'none';
							userMenuPermission.style.display = 'none';
						}  

		         //Create Student
		         const createStd = document.getElementById('createData');
				 	if (!create) createStd.style.display = 'none' ;

				// pdf	
				const pdfDownload = document.getElementById('downloadpdf');
				 	if (!pdf) pdfDownload.style.display = 'none' ;
				
				const  stdMark= document.getElementById('mark');
				 	if (!importMark) stdMark.style.display = 'none' ;

				const stdData= document.getElementById('data');
				 	if (!importData) stdData.style.display = 'none' ;

				const mail = document.getElementById('mail');
				 	if (!sendmail) mail.style.display = 'none' ;

				const excel = document.getElementById('excel');
				 	if (!excelInitiate) excel.style.display = 'none' ; 	


				const student_file = document.getElementById('student_file'); 
					if (importMark || importData) { 
					    student_file.style.display = 'block';  // or 'inline' or default value
					} else {
					    student_file.style.display = 'none';
					}

		          console.log(datas);		     

		          studentDataTable(data,deletedata,update); //Store Data in Table		         
		          pagination(meta); //Paginate

		        } catch (error) {
		          console.error('Failed to parse response:', error);
		        }
		      }
		    };

		    http.send();
		  }

		  //StudentDetails Table
		  function studentDataTable(data,deletedata,update){
		   const tbody = document.getElementById('studentTableBody');
		          tbody.innerHTML = ''; // Clear any existing rows

		          let action = document.querySelector('th.action');
		            	if(action) action.style.display = (update || deletedata) ? '' : 'none';

		          data.forEach(student => {
		            	const row = document.createElement('tr');
		            	const department = student.department ? student.department.department_name :'';
		            	const subjectName = student.subject_name?.map(subjects=> subjects.subject_name).join(',');

		            	let editdelete = '';
		            	if(update) {
		            		editdelete += `
		            			<a href="apiedit/${student.id}" id="update"><i class='fa-solid fa-pencil' ></i></a>	`;
		            		}

		            	if(deletedata){
		            		editdelete += `
		            			<button class="button" onclick="myFunction(${student.id})"><i class='fa-solid fa-trash'></i></button>
		            		`
		            	}
		            	const cell = (update || deletedata) ? `<td class="editDel">${editdelete}</td>` : '';

		            	row.innerHTML = `
				              <td>${student.id}</td>
				              <td>${student.first_name}</td>
				              <td>${student.last_name}</td>
				              <td>${student.email}</td>
				              <td>${student.phone_no}</td>
				              <td>${student.age}</td>
				              <td>${department}</td>
				              <td>${subjectName}</td>
				             		${cell}         
				            `;

		            tbody.appendChild(row);
		        });

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
		  			paginateBtn.onclick = () => {
			  			if(isSearching){
			  				searchData(i);
			  			  }	
			  			else {
			  				fetchStudentList(i);
			  			}		  			
		  			}
		  			pagination.appendChild(paginateBtn);
		  		}
		  }

		  //Delete StudentData
		  function myFunction(id){
		  	let confirmation = confirm("Are You Sure You Want To Delete This Record?");
		  		if(confirmation){
		  			deleteStudentData(id);
		  		}
		  		else{
		  			window.location.href = '/apistudentlist';
		  		}
		  }

		  	//Delete StudentData
		  	function deleteStudentData(id){
		  			let deleteRequest = new XMLHttpRequest();
		  			deleteRequest.open('DELETE',`http://127.0.0.1:8000/api/delete/${id}`,true)
		  			deleteRequest.setRequestHeader('Authorization' , 'Bearer ' + token);
		            deleteRequest.setRequestHeader('Accept','application/json');
		            	if(!token){
		            		alert('Token has been Expired! Please Login Again');
		            	}
		            deleteRequest.onload = function(){
		            	if(deleteRequest.status === 200){		            		
		            		alert("StudentData Deleted Sucessfully");
		            		fetchStudentList(current_page);
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

		  		//Logout 
		  		function logOut(){
		  			let logOutRequest = new XMLHttpRequest();
		  			logOutRequest.open('POST','http://127.0.0.1:8000/api/logout',true);
		  			logOutRequest.setRequestHeader('Authorization' , 'Bearer ' + token);
		            logOutRequest.setRequestHeader('Accept','application/json');
		            logOutRequest.onload = function(){
		            	if(!token){
		            		alert('Token expired! Please login again.');
						    window.location.href = '/apilogin';
						    return;
		            	}
		            	if(logOutRequest.status === 200){
		            		
		            		window.location.href = "/apilogin"
		                }else{
		                	console.log("error");
		                }
		            }
		            logOutRequest.send();
		  		}

		  		//Import StudentMark and StudentData		  		
		  		let form =  document.getElementById('importFileForm');	
		  		let successMessage = "";	  					
		  		form.addEventListener('submit', function(event){
		  				event.preventDefault();

		  			if(!validation()){
		  				return;
		  			}
		  			let formdata = event.submitter;//this is for form contains multiple submit buttons 
		  			let formValue = new FormData(form);
		  			let url ='';
		  				if(formdata.value === 'ImportMark'){
		  					url = 'http://127.0.0.1:8000/api/importexcelmark';
		  					successMessage = 'Import StudentMark Successfully';
		  				}	
		  				else if(formdata.value === 'importData'){
		  					url = 'http://127.0.0.1:8000/api/implodeexceldata';
		  					successMessage ='Import StudentData Successfully';
		  				}		  			
		  			let importStudent = new XMLHttpRequest();
		  			importStudent.open("POST",url,true);
		  			importStudent.setRequestHeader("Accept",'application/json');
		  			importStudent.setRequestHeader('Authorization','Bearer '+ token);

		  			importStudent.onload = function(){
		  				if(importStudent.status === 200){
		  				 alert(successMessage);
		  				}else if(importStudent.status === 403){
		  					let authErr = JSON.parse(importStudent.responseText);
		  					let err = authErr.message;
		  					alert(err);
		  				}
		  				else if(importStudent.status === 422){
		  					let importStudentErr = JSON.parse(importStudent.responseText);
		  						if(importStudentErr.errors){
		  							for(let keyErr in importStudentErr.errors){
		  								let errValue = document.getElementById(`${keyErr}_err`);		  								
		  									if(errValue){
		  										errValue.innerHTML = importStudentErr.errors[keyErr];
		  									}
		  							}
		  						}
		  				}
		  			}
		  			importStudent.send(formValue);
		  			})
		  		
		  		
		  		// Excel Export StudentData
		  		function exportInitiated() {		  			
		  				let exportStudentData = new XMLHttpRequest();
		  				exportStudentData.open('GET','http://127.0.0.1:8000/api/export',true);
		  				exportStudentData.setRequestHeader('Authorization','Bearer ' + token);
		  				exportStudentData.setRequestHeader('Accept','application/json');
		  				exportStudentData.onload = function(){
		  					if(exportStudentData.status === 200){
		  						let exportResponse = JSON.parse(exportStudentData.responseText);
		  						alert(exportResponse.message);
		  					}else if(exportStudentData.status === 422){
		  						let exportErrResponse = JSON.parse(exportStudentData.responseText);		
		  						alert(exportErrResponse.error);
		  					}else if(exportStudentData.status === 403){
		  						let exportErrResponse = JSON.parse(exportStudentData.responseText);		
		  						alert(exportErrResponse.message);
		  					}
		  				}	

		  					exportStudentData.onerror = function () {
            					alert('Request failed. Please check your network or server.');
       						 };

		  				exportStudentData.send();		  			
		  		}

		  		//Show Excel Export Status
		  		function exportStatus() {		  			
		  				let exportStudentStatus = new XMLHttpRequest();
		  				exportStudentStatus.open('GET','http://127.0.0.1:8000/api/exportResult',true);
		  				exportStudentStatus.setRequestHeader('Authorization','Bearer ' + token);
		  				exportStudentStatus.setRequestHeader('Accept','application/json');
		  				exportStudentStatus.onload = function(){
		  					if(exportStudentStatus.status === 200){
		  						let exportResponse = JSON.parse(exportStudentStatus.responseText);
		  						let exportData = exportResponse.data;
		  						excelexportTable(exportData);		  							
		  					}else if(exportStudentStatus.status === 422){
		  						let exportErrResponse = JSON.parse(exportStudentStatus.responseText);		  			console.log(exportErrResponse.error);
		  					}
		  				}	

		  					exportStudentStatus.onerror = function () {
            					alert('Request failed. Please check your network or server.');
       						 };

		  				exportStudentStatus.send();		  			
		  		}

		  		//Show Excel Export Status Table
		  		function excelexportTable(exportData){
		  			let excelTableTbody = document.getElementById('excelExportTable');
		  			exportData.forEach(exportDatas => {
		  				let downloadFile = `<a href="storage/exports/${exportDatas.file_name}" download class="pdfDownload">Download</a>`;
		  				let row = document.createElement('tr');

		  				row.innerHTML += `
		  					<td>${exportDatas.id}</td>
		  					<td>${exportDatas.user?.name}</td>
		  					<td>${exportDatas.file_name}</td>
		  					<td>${exportDatas.status}</td>
		  					<td>${exportDatas.initiated_at}</td>
		  					<td>${exportDatas.completed_at ?? ''}</td>
		  					<td>${downloadFile}</td>
		  				`


		  				excelTableTbody.appendChild(row);
		  			})
		  		}

		  		//Modal For Show Excel Export Status Table
		  		document.addEventListener('DOMContentLoaded', function(){
		  			fetchStudentList(current_page);
		  			exportStatus()
                    const modal = document.getElementById('modal');
                    const open = document.getElementById('open');
                    const close = document.getElementById('cancelbtn');

                    open.onclick = () => {
                        modal.style.display = 'block';
                    }

                    close.onclick = () => {
                        modal.style.display = 'none';
                    }
                })



		  	//SearchData And Pdf Download
		   document.getElementById('formSubmit').addEventListener('submit',function(event){
		  		event.preventDefault();
		 		let submitBtn = event.submitter;//this is for form contains multiple submit buttons
				if(submitBtn.id === 'search'){			 				
					let params = searchParams();
					params.append('page',1)
		 			searchData(1);		
		  		}
		  		else if(submitBtn.id === 'downloadpdf'){		  			
		  			let params = searchParams();
		  			params.append('Pdf','Pdf');
					let url = `http://127.0.0.1:8000/api/search?${params.toString()}`;
		  			let pdfDownload = new XMLHttpRequest();
		  			pdfDownload.open("GET",url,true);
		  			pdfDownload.setRequestHeader('Accept','application/pdf');
		  			pdfDownload.setRequestHeader('Authorization','Bearer '+ token);
		  			pdfDownload.responseType = 'blob';

		  			pdfDownload.onload = function(){
		  				if(pdfDownload.status === 200){		  					
		  					const blob = new Blob([pdfDownload.response], { type: 'application/pdf' });
		  				 	let a = document.createElement('a');
		  				 	let url = window.URL.createObjectURL(blob);
		  				 	a.href = url;
		  				 	a.download = 'studentdata.pdf';
		  				 	document.body.appendChild(a); // Append to body (can be removed after click)
					        a.click();
					        document.body.removeChild(a);
		  					console.log('Sucessfully')
		  				}else if(pdfDownload.status === 403){
		  					const reader = new FileReader();
				            reader.onload = function () {				               
				                    const json = JSON.parse(reader.result);
				                    alert(json.message);				                 
				            };
				            reader.readAsText(pdfDownload.response); // Read blob as text
		  				}
		  			}

		  			pdfDownload.send();

		  			}
		  		})

		  		//Search FieldData URL  
		  		function searchParams(){
		  		let search_first = document.getElementById('search_firstname').value;
		  		let search_last = document.getElementById('search_lastname').value;
		  		let search_email = document.getElementById('search_email').value;
		  		let department_id = Array.from(document.getElementById('department_id').selectedOptions).map(
		  							department => department.value );
		  		let subject_name = Array.from(document.querySelectorAll('#subject input[type="checkbox"]:checked')) 
		  							.map(subject => subject.value);		  						
		  		let searchDatas = new URLSearchParams({
		  			search_firstname:search_first,
		  			search_lastname:search_last,
		  			search_email:search_email
		  			});

				department_id.forEach(id => searchDatas.append('department_id[]',id));
				subject_name.forEach(id => searchDatas.append('subject_name[]',id));
					return searchDatas;
		  		}

		  		//Search Logic
		  		function searchData(page=1){
		  			let params = searchParams();
		  			params.set('page', page);
		  		let request = new XMLHttpRequest();
				  		let url = `http://127.0.0.1:8000/api/search?${params.toString()}`;
				  		request.open("GET", url ,true);
				  		request.setRequestHeader('Authorization' , 'Bearer ' + token);
				    	request.setRequestHeader('Accept','application/json')

		    	if(!token){
		    		alert('Token has been Expired! Please Login Again');
		    		return;
		   		 }	

		  		 request.onreadystatechange = function(){
		  		 	   if(request.readyState === 4 && request.status === 200){
		  		 		   let response = JSON.parse(request.responseText);
		  		 		   let data = response.data;
		  		 		   let meta = response.meta;

		  		 		   const permission = response.permission || {};			          
			          	   let update =  permission.update ?? false;
			          	   let deletedata =  permission.delete ?? false;

		  		 		   //Store Search Data
		  		 		    studentDataTable(data,deletedata,update);
		  		 		    pagination(meta);  
							isSearching = true;

							console.log('Update '+update);
							console.log('delete ' + deletedata);
		  		 	   }





		  		 	   
		  		 }

		  		 request.send();
		  }		 