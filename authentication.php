<?php

require_once 'db.php';
require_once 'functions.php';

print_r($_POST);


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
print("34what is going on: $fail");
$fail .= validate_password($password);
print("56what is going on: $fail");
$fail .= validate_email($email);

print("78what is going on: $fail");

if ($fail == ""){
    $hash     = password_hash($password, PASSWORD_DEFAULT);
    $user_attributes = array(
        "username" => $username,
        "email" => $email,
        "password" => $hash
    );
    print_r($user_attributes);
    $insert_result = insert_data($conn, "users", $user_attributes);
    if($insert_result){
        header("location: index.php");
        $_POST = array();
    }else{
        echo "Insert failed. <br>";
    }
}else{
    echo "<h3>$fail</h3>";

}
?>

<script>alert("hello")</script>
