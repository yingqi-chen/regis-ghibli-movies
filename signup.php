<?php
session_start();

require_once 'config/db.php';
require_once 'helpers/functions.php';
include_once 'helpers/header.php';
include_once 'helpers/check_not_authorized.php';
include_once 'helpers/read_errors.php';


if (!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['email'])){
    $password = mysql_entities_fix_string($conn, $_POST['password']);
    $email    = mysql_entities_fix_string($conn, $_POST['email']);
    $username = mysql_entities_fix_string($conn, $_POST['username']);

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
            echo"<h3> Insert failed.</h3><br>";
            echo "<a href='signup.php'>Try to sign up again.</a>";
        }
    }else{
        header("location: signup.php?error=notvalidfield");
    }

}elseif($_SERVER["REQUEST_METHOD"] == "POST"){
    header("location: signup.php?error=emptyrequirefield");
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel='stylesheet' href='style/styles.css'>
    <script src="js/validation.js"></script>
</head>
<body>
<div class="wrapper w-50">
    <div class="container">
        <h2 class="text-center my-5">Sign up</h2>
        <p class="text-center h5 my-5">So you can start to create, update, delete movies for the website!</p>
        <div class="auth-form-wrapper">
            <form action="signup.php" method="post" onSubmit="return validateSignUp(this)">
                <label for="username" class="form-label">Username</label><br>
                <input type="text" name="username"><br>
                <label for="password" class="form-label">Password</label> <br>
                <input type="password" name="password"><br>
                <label for="email" class="form-label">Email</label> <br>
                <input type="text" name="email"><br>
                <input type="hidden" name="submit" value="true">
                <br>
                <div class="button-middle"><input type="submit" value="Sign up" class="btn btn-outline-secondary btn-sm" ></div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>
</html>

