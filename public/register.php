<?php 
    include 'common/header.html'; 
?>
<link rel="stylesheet" href="css/login_register.css">
<div class="wrapper">
	<div class="form-signin">       
	    <h3 class="form-heading">Register</h3>
		<div class="form-group">
			<label for="email_input">Email</label>
			<input type="text" id="email_input" class="form-control" placeholder="Email" required="" autofocus/>
		</div>

		<div class="form-group">
			<label for="password_input">Password</label>
			<input id="password_input" type="password" class="form-control" placeholder="Password"/>     		  
		</div>

		<div class="form-group">
			<label for="cnf_password_input">Confirm Password</label>
			<input id="cnf_password_input" type="password" class="form-control" placeholder="Password">  		  
		</div>

		<hr>

		<div class="form-group">
			<label for="first_name_input">First Name</label>
			<input type="text" id="first_name_input" class="form-control" placeholder="First Name"/>
		</div>
		
		<div class="form-group">
			<label for="last_name_input">Last Name</label>
			<input type="text" id="last_name_input" class="form-control" placeholder="Last Name"/>
		</div>

		<div class="form-group">
			<label for="org_input">Organisation</label>
			<input type="text" id="org_input" class="form-control" placeholder="Organisation"/>
		</div>

		<div class="form-group">
			<label for="desig_input">Designation</label>
			<input type="text" id="desig_input" class="form-control" placeholder="Designation"/>
		</div>
		<button class="btn btn-lg btn-block" type="button" id="register_button" style="background-color: #343a40;color: white;">Register</button>
	</div>			
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>



<script>
$(document).ready(function(){

	function getFromData(){
		var data = new Object();
		data.email = $("#email_input").val();
		data.password = $("#password_input").val();
		data.first_name = $("#first_name_input").val();
		data.last_name = $("#last_name_input").val();
		data.org = $("#org_input").val();
		data.desig = $("#desig_input").val();
		return data;
	}
	
	function makeAjaxRequest(d){
		jQuery.ajax({
			method: "POST",
			url: "api/createuser",
			processData: false,
			contentType: "application/json",
			data: d,

			success: function(r){
				console.log(r);
				var response = jQuery.parseJSON(r);
				if (response.status == "success") {
					alert("Success");
					$(location).attr('href','login.php')
				} else {
					alert("Error");
					$(location).attr('href','login.php')
				}
			},
			error: function(r){
			},

			complete: function(r){
			}
        });
	}

	$("#register_button").click(function(){
		var data = JSON.stringify(getFromData());
		makeAjaxRequest(data);
	});
});
</script>
