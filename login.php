<?php
session_start();

require_once 'config/db.php';
require_once 'helpers/functions.php';
include_once 'helpers/header.php';
include_once 'helpers/check_not_authorized.php';
include_once 'helpers/read_errors.php';

if (!empty($_POST['email']) && !empty($_POST['password'])){
    $password = mysql_entities_fix_string($conn, $_POST['password']);
    $email = mysql_entities_fix_string($conn, $_POST['email']);

    $fail = '';
    $fail .= validate_password($password);
    $fail .= validate_email($email);

    if ($fail == ""){
        login_user($conn, $email, $password);
    }else{
        header("location: login.php?error=notvalidfield");
    }

}elseif($_SERVER["REQUEST_METHOD"] == "POST"){
    header("location: login.php?error=emptyrequirefield");
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
                <h2 class="text-center my-5">Log In</h2>
                <p class="text-center h5 my-5">Log in to create and update movies that you like.</p>
                <div class="auth-form-wrapper">
                    <form action="login.php" method="post" onSubmit="return validateLogIn(this)">
                        <label for="email" class="form-label">Email</label> <br>
                        <input type="text" name="email"><br>
                        <label for="password" class="form-label">Password</label> <br>
                        <input type="password" name="password"><br>
                        <input type="hidden" name="submit" value="true">
                        <br>
                        <div class="button-middle"><input type="submit" value="Log In" class="btn btn-outline-secondary btn-sm" ></div>
                    </form>
                    </form>
                </div>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
            </div>
    </body>
</html>

