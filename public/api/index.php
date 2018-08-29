<?php
ini_set('display_errors', 1);

include_once '../../src/app.php';
require_once '../../src/DB.php';


$db = new DB();

function createuser($db,$postBody){

    $email = $postBody->email;

    if($db->query("SELECT email FROM users WHERE email=:email",array(":email"=>$email))){
        echo '{"status":"error","message":"email already used"}';
        http_response_code(403);
    } else {
        $first_name = $postBody->first_name;
        $last_name = $postBody->last_name;
        $org = $postBody->org;
        $desig = $postBody->desig;

        $password = $postBody->password;
        $password_hash = password_hash($password,PASSWORD_BCRYPT);

        $datetime = date("Y-m-d H:i:s");

        $db->query("INSERT INTO users(email,password,first_name,last_name,org,desig,creation_time,active) VALUES (:email,:password_hash,:first_name,:last_name,:org,:desig,:creation_time,:active)",array(
                ":email"=>$email,
                ":password_hash"=>$password_hash,
                ":first_name"=>$first_name,
                ":last_name"=>$last_name,
                ":org"=>$org,
                ":desig"=>$desig,
                ":creation_time"=>$datetime,
                ":active"=>'1'
            ));

        echo json_encode(array("status"=>"success","message"=>"account created successfully"));
        http_response_code(200);
    }
}

function auth($db,$postBody){

    $email = $postBody->email;
    $password = $postBody->password;

    $token = get_token($email,$password);
    if (!$token) {
        echo json_encode(array("status"=>"error","message"=>"incorrect user name or password"));
        http_response_code(403);
    } else {
        echo json_encode(array("status"=>"success","token"=>$token));
        http_response_code(200);
    }
}

function checktoken($db,$postBody){

    $token = $postBody->token;
 
    if (!check_token($token)) {
        echo json_encode(array("status"=>"error","message"=>"token invalid or expired"));
        http_response_code(403);
    } else {
        echo json_encode(array("status"=>"success","message"=>"token is valid"));
        http_response_code(200);
    }
}

if($_SERVER['REQUEST_METHOD'] == "GET"){
    switch ($_GET['url']) {
        case 'API_ENDPOINT':
            break;
    }
} else if($_SERVER['REQUEST_METHOD'] == "POST"){

        $postBody = file_get_contents("php://input");
        $postBody = json_decode($postBody);
        
        switch ($_GET['url']) {
            case 'createuser':
                createuser($db,$postBody);
                break;
            case 'auth':
                auth($db,$postBody);
                break;
            case 'checktoken':
                checktoken($db,$postBody);
                break;
        }
        
} else {
    http_response_code(405);
}