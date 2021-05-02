<?php

$username = $_SESSION['username'];
if ($username){
    header("location: index.php?error=userloggedin");
}