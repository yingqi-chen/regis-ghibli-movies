<?php

require_once 'config/db.php';
require_once 'helpers/functions.php';
include_once 'helpers/header.php';


if ($_POST['submit']){
    if (isset($_POST['password'])) {
        $password = mysql_entities_fix_string($conn, $_POST['password']);
    }
    if (isset($_POST['email'])) {
        $email = mysql_entities_fix_string($conn, $_POST['email']);
    }

    $fail = '';
    $fail .= validate_password($password);
    $fail .= validate_email($email);

    if ($fail == ""){
        $login_result = login_user($conn, $email, $password);
    }else{
        echo <<<_ERRORDISPLAY
        <div class="text-center my-3">
            <h3>$fail</h3>
            <a class="btn btn-danger" href='login.php'>Try to log in again.</a>
        </div>
_ERRORDISPLAY;
    }
}else{
    header("location: login.php");
    exit();
}

?>

