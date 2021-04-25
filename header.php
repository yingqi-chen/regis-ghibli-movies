<?php
session_start();
$username = $_SESSION['username'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ghibli Wiki</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script>
        function randomIndex(){
            return Math.floor(Math.random() * 6);
        }
        function changeTheme(){
            let colors = ["#FADBD8", "#e3f2fd", "#D5F5E3", "#E8DAEF", "#FCF3CF", "#EDBB99"];
            let color = colors[randomIndex()];
            document.getElementsByTagName("nav")[0].style.backgroundColor = color;
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #D5F5E3 ">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Ghibli Wiki</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse d-flex" id="navbarSupportedContent">
            <a href="create.php" class="btn btn-outline-secondary me-auto">Create a movie</a>
            <div>
            <?php
                if($username){
                    echo <<<_USERLOGGEDIN
                    <span class='navbar-text'>Welcome back $username! </span>
                    <a href='signout.php' class='btn btn-outline-secondary'>Log out</a>
_USERLOGGEDIN;
                }else{
                    echo <<<_USERNOTLOGGEDIN
                        <a href="signup.php" class="btn btn-outline-secondary">Sign Up</a>
                        <a href='login.php' class='btn btn-outline-secondary'>Log In</a>
_USERNOTLOGGEDIN;
                }
            ?>
            <button class="btn btn-outline-primary" onclick="changeTheme()">Change a random color!</button>
            </div>
        </div>
    </div>
</nav>
</body>
</html>




