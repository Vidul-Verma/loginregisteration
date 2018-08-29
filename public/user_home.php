<?php 
    include 'common/header.html'; 
    include_once "../src/app.php";
    if(!isset($_COOKIE['ST']) && !check_token($_COOKIE['ST'])){
        
        //Redirect if not logged in
        header("Location: login.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login System</title>
</head>
<body>
	<h1>Logged In</h1>
</body>
</html>