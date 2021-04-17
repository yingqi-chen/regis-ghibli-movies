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
    echo "No fail";
}else{
    echo "<h3>$fail</h3>";

}

// if ($fail == "")
// {
//   echo "No fail";

//     // This is where you would enter the posted fields into a database,
//     // preferably using hash encryption for the password.
// //    header("location: index.php");
// }
?>