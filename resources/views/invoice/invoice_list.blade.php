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
					<label for="customer_name">Customer Name</label>
					<input type="text" name="customer_name">
				</div>	

				<div class="form-group">
					<label for="invoice_no">Invoice Number</label>
					<input type="text" name="invoice_no" id="invoice_no">
				</div>	

				<div class="form-group">
					<label for="customer_name">Status</label>
					
				</div>	
			</div>
			<hr>
			<div class="reset">
					<input type="reset" name="reset" value="Reset">
					<input type="submit" name="search" value="Search" class="search">
			</div>
		</div>
	</form>	

		<table>
			<thead>
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
									<td>${status}</td>
									<td></td>
									<td></td>

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

		  			let searchDatas = new URLSearchParams({
			  			startDate:startDate,
			  			endDate:endDate,
			  			invoice_no:invoice_no		  			
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


		</script>
</body>
</html>