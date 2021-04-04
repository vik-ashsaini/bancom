<!DOCTYPE html>
<html>
<head>
	<title>bnacom assignment</title>
	<meta charset="UTF-8" />
    <meta name="viewport"  content="width=device-width, initial-scale=1.0" />
	<style type="text/css">
		body{
			margin: 0;
			padding: 0;
		}
		.search{
			margin-top: 80px;
			margin-left: 15%;
			display: inline-flex;
			justify-content: center;
		}
		.search input
		{
			width: 600px;
		}
		.search-btn img
		{
			width: 50px;
			height: 40px;
		}
		.output{
			padding-top: 20px;
			margin-left: 15%;
		}
	</style>
</head>
<body>
	<h1 style="background-color: #000000;color: #fff; margin-top: 50px;">Companies House</h1>
	<div class="search">
		<input type="text" name="name" id="name" placeholder="Search for a company or a officer">
		<button class="search-btn"><img src="search-icon.png" alt="img"></i></button>
	</div>
	<br>
	<div id="output" class="output"></div>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<script type="text/javascript">

		function fetchitem(p){
			let myHeaders = new Headers();
			myHeaders.append("Authorization", "93f7c7b2-199e-426e-8ced-cf2ee43ac509");

			let requestOptions = {
			    method: 'GET',
				headers: myHeaders
			};
			console.log(typeof(p));
			if(typeof p !== 'string')
			{
				var az=p.toString();
				//console.log(typeof(az))
				if(az.length<8)
				{
				 	az='0'+az;
				}
			}
			else
			{
				console.log(typeof(p));
			}
			

			fetch(`https://api.company-information.service.gov.uk/company/${az}`, requestOptions)
			    .then(response => response.json())
				.then(result => showitems(result))
				.catch(error => console.log('error', error));

			showitems = company => {
				  const resultDiv = document.querySelector('#output');
				  //companies.forEach(company => {
				    const companytitle = document.createElement('a');
				    
				    const companydetails = document.createElement('p');
				    const companyaddress = document.createElement('p');

				    var tmp=company.company_number;
				    
				    companytitle.setAttribute('href',`javascript:fetchitem(${tmp});`);
				    companytitle.innerText = company.company_name;
				    companydetails.innerText = company.company_number;
				    companyaddress.innerText = company.registered_office_address;
				    resultDiv.append(companytitle);
				    resultDiv.append(companydetails);
				    resultDiv.append(companyaddress);
				 // });
				}
		}

		$(document).ready(function()
		{
			$('button').click(function()
			{
				var myHeaders = new Headers();
				myHeaders.append("Authorization", "93f7c7b2-199e-426e-8ced-cf2ee43ac509");

				var requestOptions = {
				  method: 'GET',
				  headers: myHeaders,
				  redirect: 'follow'
				};

				var a=$("input").val();

				fetch(`https://api.company-information.service.gov.uk/search/companies?q=${a}`, requestOptions)
				  .then(response => response.json())
				  .then(result => showresult(result.items))
				  .catch(error => console.log('error', error));
//result.items[0].title

				showresult = companies => {
				  const resultDiv = document.querySelector('#output');
				  companies.forEach(company => {
				    const companytitle = document.createElement('a');
				    
				    const companydetails = document.createElement('p');
				    const companyaddress = document.createElement('p');

				    var tmp=company.company_number;
				    let a=tmp.toString();
				   // console.log(a);

				    companytitle.setAttribute('href',`javascript:fetchitem(${a});`);
				    companytitle.innerText = company.title;
				    companydetails.innerText = company.company_number;
				    companyaddress.innerText = company.address.locality;

				    resultDiv.append(companytitle);
				    resultDiv.append(companydetails);
				    resultDiv.append(companyaddress);
				  });
				}

				
			})	
		});
	</script>
</body>
</html>