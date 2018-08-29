<?php 
    include 'common/header.html'; 
    include_once "../src/app.php";
    if(isset($_COOKIE['ST']) && check_token($_COOKIE['ST'])){
        
        //Redirect if logged in
        header("Location: user_home.php");
    }
?>
<link rel="stylesheet" href="css/login_register.css">
<div class="wrapper">
    <div class="form-signin">       
        <h3 class="form-heading">Login</h3>
        <div class="form-group">
            <label for="email_input">Email</label>
            <input id="email_input" type="text" class="form-control" placeholder="Email" autofocus/>
        </div>
        <div class="form-group">
            <label for="password_input">Password</label>
            <input id="password_input" type="password" class="form-control" placeholder="Password">       
        </div>
        <button class="btn btn-lg btn-block" type="Submit" id="login_button" style="background-color: #343a40;color: white;">Login</button>
    </div>      
    <div style="padding-top: 20px;text-align: center;">
        Don't have an account? <a href="register.php">Register Now</a>
    </div>
</div>
    <br>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>


<script src="js/app.js"></script>
<script>
$(document).ready(function(){
    function getFromData(){
        var data = new Object();
        data.email = $("#email_input").val();
        data.password = $("#password_input").val();
        return data;
    }

    function makeAjaxRequest(d){
        jQuery.ajax({
            method: "POST",
            url: "api/auth",
            processData: false,
            contentType: "application/json",
            data: d,

            success: function(r){
                console.log(r);
                var response = jQuery.parseJSON(r);
                if (response.status == "success") {
                    setCookie("ST",response.token);
                    alert("Logged in successfully");
                    $(location).attr('href','user_home.php');
                }
            },
            error: function(r){
                alert("Incorrect email or password");
            },

            complete: function(r){
            }
        });
    }

    $("#login_button").click(function(){
        var data = JSON.stringify(getFromData());
        makeAjaxRequest(data);
    });
    
    $(document).keypress(function(e){
        if (e.which == 13) {
            var data = JSON.stringify(getFromData());
            makeAjaxRequest(data);
        }
    });
});
</script>