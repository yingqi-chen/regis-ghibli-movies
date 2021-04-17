<?php

require_once 'db.php';
require_once 'functions.php';

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


if ($fail == ""){
    $hash     = password_hash($password, PASSWORD_DEFAULT);
    $user_attributes = array(
        "username" => $username,
        "email" => $email,
        "password" => $hash
    );
    $insert_result = insert_data($conn, "users", $user_attributes);
    print_r($insert_result);
    if($insert_result){
        header("location: index.php");
        $_POST = array();
    }else{
        echo"<h3>> Insert failed.</h3><br>";
    }
}else{
    echo "<h3>$fail</h3>";

}
?>

