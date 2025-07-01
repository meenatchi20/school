<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Invoice List</title>
	<link rel="stylesheet" type="text/css" href="/css/invoice_table.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body onload="getInvoiceList(1)">
		<header>
			<h3>sales Invoice</h3>
			<div>
				<a href="" class="create-note">Credit Note</a>
				<a href="" class="group-invoice">Group Invoice</a>
				<a href="" class="create">+Create</a>
			</div>
		</header>

		<div>
			<div class="invoice-search">
				<p>Sales Invoice List</p>	
				<i class="fa-solid fa-magnifying-glass"></i>
			</div>

		<form id="formSubmit">
			<div class="form-row">
				<div class="form-group">
					<label for="startDate">Start Date</label>
					<input type="date" name="startDate" id="startDate">
				</div>

				<div class="form-group">
					<label for="endDate">End Date</label>
					<input type="date" name="endDate" id="endDate">
				</div>

				<div class="form-group">
					<label for="customer_id">Customer Name</label>
					<select name="customer_id" id="customer_id">
						<option value="" disabled selected hidden>Select Customer Name</option>
					</select>
				</div>	

				<div class="form-group">
					<label for="invoice_no">Invoice Number</label>
					<input type="text" name="invoice_no" id="invoice_no" placeholder="Enter Invoice Number">
				</div>	

				<div class="form-group">
					<label for="invoice_status">Status</label>
					<select name="invoice_status" id="invoice_status">
						<option value="" disabled selected hidden>Select Status</option>
					</select>
				</div>	
			</div>
			<hr>
			<div class="reset">
					<!-- <input type="reset" name="reset" value="Reset"> -->
					<a href="/invoice/list" class="clear">Reset</a>
					<input type="submit" name="search" value="Search" class="search">
			</div>
		</div>
	</form>	

		<table>
			<thead>
				<tr>
					<th colspan="9" style="text-align:right;"><button class="export" id="exportBtn">Export</button></th>
				</tr>
				<tr>
					<th>Invoice Id</th>
					<th>Invoice Number</th>
					<th>Invoice Date</th>
					<th>Due Date</th>
					<th>Total Value</th>
					<th>Balance</th>
					<th>Status</th>
					<th>Email Status</th>
					<th>Action</th>
				</tr>
			</thead>	
			<tbody id="involiceList"></tbody>		
		</table>

		<!-- Pagination -->
		<div id="paginateButton" class="pagination"></div>

		<script>
				let token = localStorage.getItem('auth_token');
				let listBody = document.getElementById('involiceList');
				let current_page = 1;
		  		let isSearching = false;


		  		//Invoice List Show
			  	function getInvoiceList(page){
			  		let invoiceRequest = new XMLHttpRequest();
			  		invoiceRequest.open('GET',`http://127.0.0.1:8000/api/invoicedata?page=${page}`,true);
			  		invoiceRequest.setRequestHeader('Accept','application/json');
					invoiceRequest.setRequestHeader('Authorization','Bearer ' + token);

					invoiceRequest.onload = function(){
						if(invoiceRequest.status === 200){
							let invoiceData = JSON.parse(invoiceRequest.responseText);
							let data = invoiceData.data;
							let meta = invoiceData.meta;
							console.log(meta);
							console.log(data);

							listBody.innerHTML = '';
							invoiceTable(data);
							pagination(meta);
						}
					}

					invoiceRequest.send();
			  	};

			  	//Invoice List table
			  	function invoiceTable(data){
			  	data.forEach(list => {
								let row = document.createElement('tr');
								const status = list.invoice_status ? list.invoice_status.status :'';
								const total = list.total_amount !== null ? list.total_amount : '_';
            					const balance = list.balance_amount !== null ? list.balance_amount : '_';
            					const due_date= list.invoice_due_date !== null ? list.invoice_due_date : '_';

								row.innerHTML += `
									<td>${list.invoice_id}</td>
									<td>${list.invoice_no}</td>
									<td>${list.invoice_date}</td>
									<td>${due_date}</td>
									<td>${total}</td>
									<td>${balance}</td>
									<td><div class="status">${status}</div></td>
									<td><span class="mail-status">${list.email_send_status}</span></td>
									<td><button class="button" onclick="myFunction(${list.invoice_id})"><i class='fa-solid fa-trash'></i></button></td>

								`
								listBody.appendChild(row);
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
		  			//paginateBtn.onclick = () => getInvoiceList(i);
		  			paginateBtn.onclick = () => {
			  			if(isSearching){
			  				searchData(i);
			  			  }	
			  			else {
			  				getInvoiceList(i);
			  			}		  			
		  			}
		  			pagination.appendChild(paginateBtn);
		  		}
		  }

		  document.getElementById('formSubmit').addEventListener('submit',function(event){
		  		event.preventDefault();
		  		searchData(1);

		  	});
		  //Search FieldData URL  
		  		function searchParams(){
		  			let startDate = document.getElementById('startDate').value;
		  			let endDate = document.getElementById('endDate').value;
		  			let invoice_no = document.getElementById('invoice_no').value;
		  			let invoice_status = document.getElementById('invoice_status').value;
		  			let customer_id = document.getElementById('customer_id').value;

		  			let searchDatas = new URLSearchParams({
			  			startDate:startDate,
			  			endDate:endDate,
			  			invoice_no:invoice_no,
			  			invoice_status:invoice_status,
			  			customer_id:customer_id			
		  			});

					return searchDatas;
		  		}

		  		//Search Logic
		  		function searchData(page=1){
		  			let params = searchParams();
		  			params.set('page', page);
		  		let request = new XMLHttpRequest();
				  		let url = `http://127.0.0.1:8000/api/searchinvoice?${params.toString()}`;
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

		  		 		    //Store Search Data
		  		 		   listBody.innerHTML = '';
		  		 		    invoiceTable(data);
		  		 		    pagination(meta);  
							isSearching = true;

							
		  		 	   }
		  		 	}
		  		 	request.send();
		  		 }	


		 //invoice Status
		 document.addEventListener('DOMContentLoaded', function(){ 	
		 let invoiceStatus = document.getElementById('invoice_status');		 	
			const http = new XMLHttpRequest();
		    http.open('GET', 'http://127.0.0.1:8000/api/invoicestatus', true);
		    http.setRequestHeader('Authorization' , 'Bearer ' + token);
		    http.setRequestHeader('Accept','application/json'); 
		    	if(!token){
		    		alert('Token has been Expired! Please Login Again');
		    		window.location.href = '/apilogin';
                    return;
		    	}

		    http.onreadystatechange = function () {

		    	if(http.readyState === 4 && http.status === 401){
		      		window.location.href = '/apilogin';
		      	}
		        else if(http.readyState === 4 && http.status === 200){		        		        	
			          const datas = JSON.parse(http.responseText);
			          const data = datas.data;  
			          data.forEach(status => {
			          	  let option = document.createElement('option');
			          	  option.value = status.invoice_status_id;
			          	  option.textContent = status.invoice_status;

			          	  invoiceStatus.appendChild(option);
			          })

		        }
		    };

		    http.send();
		  });

		 //Customer Deatils
		 document.addEventListener('DOMContentLoaded', function(){ 	
		 let customerData = document.getElementById('customer_id');		 	
			const http = new XMLHttpRequest();
		    http.open('GET', 'http://127.0.0.1:8000/api/customer/list', true);
		    http.setRequestHeader('Authorization' , 'Bearer ' + token);
		    http.setRequestHeader('Accept','application/json'); 
		    	if(!token){
		    		alert('Token has been Expired! Please Login Again');
		    		window.location.href = '/apilogin';
                    return;
		    	}

		    http.onreadystatechange = function () {

		    	if(http.readyState === 4 && http.status === 401){
		      		window.location.href = '/apilogin';
		      	}
		        else if(http.readyState === 4 && http.status === 200){		        		        	
			          const datas = JSON.parse(http.responseText);
			          const data = datas.data;  
			          data.forEach(customer => {
			          	  let option = document.createElement('option');
			          	  option.value = customer.customer_id;
			          	  option.textContent = customer.customer_name;

			          	  customerData.appendChild(option);
			          });

		        }
		    };

		    http.send();
		  });

		 	//Delete InvoiceData
		  function myFunction(id){
		  	let confirmation = confirm("Are You Sure You Want To Delete This Record?");
		  		if(confirmation){
		  			deleteInvoiceData(id);
		  		}
		  		else{
		  			window.location.href = '/invoice/list';
		  		}
		  }


		  //Delete StudentData
		  	function deleteInvoiceData(id){
		  			let deleteRequest = new XMLHttpRequest();
		  			deleteRequest.open('DELETE',`http://127.0.0.1:8000/api/delete/invoicedata/${id}`,true)
		  			deleteRequest.setRequestHeader('Authorization' , 'Bearer ' + token);
		            deleteRequest.setRequestHeader('Accept','application/json');
		            	if(!token){
		            		alert('Token has been Expired! Please Login Again');
		            	}
		            deleteRequest.onload = function(){
		            	if(deleteRequest.status === 200){		            		
		            		alert("InvoiceData Deleted Sucessfully");
		            		getInvoiceList(current_page);
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

		  	//Excel Export 
		  	document.getElementById('exportBtn').addEventListener('click', function () {
			    const xhr = new XMLHttpRequest();
			    const url = 'http://127.0.0.1:8000/api/invoice/export'; 

			    xhr.open('GET', url, true);
			    xhr.setRequestHeader('Accept', 'application/csv'); 
			    xhr.setRequestHeader('Authorization','Bearer ' + token);
			    xhr.responseType = 'blob';
			     xhr.withCredentials = true; 

			     xhr.onload = function () {
			        if (xhr.status === 200) {
			            const blob = new Blob([xhr.response], { type: 'application/csv' }); 
			            const downloadUrl = URL.createObjectURL(blob);

			            const a = document.createElement('a');
			            a.href = downloadUrl;
			            a.download = 'invoiceData.csv'; // Change to .xlsx if needed
			            document.body.appendChild(a);
			            a.click();
			            document.body.removeChild(a);
			        } else {
			            alert('Failed to download file. Status: ' + xhr.status);
			        }
			    };

    xhr.onerror = function () {
        alert('Network error occurred while trying to download the file.');
    };

    xhr.send();
});
		</script>
</body>
</html>