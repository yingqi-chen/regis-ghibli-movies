<?php

require_once 'db.php';
require_once 'functions.php';

if (isset($_POST['username']) && isset($_POST['password']))
{
//sanitize input
// check username is unique
//    call add user
//    Then right away sign in user
    $username = mysql_fix_string($conn, $_POST['username']);
    $password = mysql_fix_string($conn, $_POST['password']);
    $pw_hash = password_hash($password, PASSWORD_DEFAULT);
    $user_attributes = array("username" => $username, "password" => $pw_hash);

    $result = insert_data($conn, "users", $user_attributes);
}


function mysql_entities_fix_string($conn, $string)
{
    return htmlentities(mysql_fix_string($conn, $string));
}

function mysql_fix_string($conn, $string)
{
    if (get_magic_quotes_gpc()) $string = stripslashes($string);
    return $conn->real_escape_string($string);
}





echo <<<_END
<form action="signup.php" method="post">
      <div>
        <label>Username</label>
        <input type='text' maxlength='16' name='user' value='$username'/>
      </div>
      <div>
        <label>Password</label>
        <input type='text' maxlength='16' name='pass' value='$password'/>
      </div>
      <div>
        <label></label>
        <input type='submit' value='Sign Up'>
      </div>
    </form>
_END;

?>