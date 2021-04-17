<?php

require_once 'db.php';
require_once 'functions.php';

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
    echo "<h3>$fail</h3>";
}
?>

