<?php

include_once 'DB.php';

function get_token($email,$password){
	$db = new DB();
    $user = $db->query("SELECT * FROM users WHERE email=:email",array(":email"=>$email));
    
    if(!$user){
        return 0;//USER DOES NOT EXISTS
    } else {
        $user = $user[0];
        $password_hash = $user['password'];

        if(!password_verify($password,$password_hash)){
            return 0;//PASSWORD INVALID
        } else {
            $cstrong = true;
            $token = bin2hex(openssl_random_pseudo_bytes(64,$cstrong));
            $user_id = $user['id'];
            $datetime = date("Y-m-d H:i:s");

            $db->query("INSERT INTO user_login_tokens (token,user_id,created_at) VALUES (:token,:user_id,:created_at)",array(":token"=>hash("sha256",$token),":user_id"=>$user_id,"created_at"=>$datetime));
            return $token;//LOGIN SUCCESS
        } 
	}
}



function check_token($token){
    $db = new DB();
    $yesterday = DateTime::createFromFormat("Y-m-d H:i:s", date("Y-m-d H:i:s"))->modify('-1 day')->format("Y-m-d H:i:s");
    
    if($res = $db->query("SELECT * FROM user_login_tokens WHERE token =:token AND created_at >=:yesterday",array(":token"=>hash("sha256",$token),":yesterday"=>$yesterday))){
		return 1; // token is valid
	} else {
		return 0;//no token exists
	}
}
