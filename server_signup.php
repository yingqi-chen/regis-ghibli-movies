<?php

require_once 'config/db.php';
require_once 'helpers/functions.php';
include_once 'helpers/header.php';


if ($_POST['submit']){
    if (isset($_POST['username'])) {
        $username = mysql_entities_fix_string($conn, $_POST['username']);
    }
    if (isset($_POST['password'])) {
        $password = mysql_entities_fix_string($conn, $_POST['password']);
    }
    if (isset($_POST['email'])) {
        $email = mysql_entities_fix_string($conn, $_POST['email']);
    }

    $fail = '';
    $fail .= validate_username($username);
    $fail .= validate_password($password);
    $fail .= validate_email($email);

    $redirect_path = "signup.php";


    if ($fail == ""){
        $hash     = password_hash($password, PASSWORD_DEFAULT);
        $user_attributes = array(
            "username" => $username,
            "email" => $email,
            "password" => $hash
        );
        $user_exists = query_user($conn, $email, $redirect_path);
        if($user_exists){
            header("location: $redirect_path?error=userexisted");
        }
        $insert_result = insert_data($conn, "users", $user_attributes);
        if($insert_result){
            header("location: login.php");
            $_POST = array();
        }else{
            echo"<h3>> Insert failed.</h3><br>";
            echo "<a href='signup.php'>Try to sign up again.</a>";
        }
    }else{
        echo <<<_ERRORDISPLAY
        <div class="text-center my-3">
            <h3>$fail</h3>
            <a class="btn btn-danger" href='signup.php'>Try to sign up again.</a>
        </div>
_ERRORDISPLAY;
    }
}else{
    header("location: signup.php");
    exit();
}

?>

