<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <style type="text/css">
        .wrapper{
            margin: 6% auto ;
        }
        .form-wrapper{
            width: 50%;
            margin: 0 auto;
            padding-left: 15%;
        }
        .button-middle{
            width: 50%;
            padding-left: 18%;
        }
    </style>
    <script src="validation.js"></script>
</head>
<body>
<div class="wrapper w-50">
    <div class="container">
        <h2 class="text-center my-5">Sign up</h2>
        <p class="text-center h5 my-5">So you can start to create, update, delete movies for the website!</p>
        <div class="form-wrapper">
            <form action="authentication.php" method="post" onSubmit="return validate(this)">
                <label for="username" class="form-label">Username</label><br>
                <input type="text" name="username"><br>
                <label for="password" class="form-label">Password</label> <br>
                <input type="password" name="password"><br>
                <label for="email" class="form-label">Email</label> <br>
                <input type="text" name="email"><br>
                <br>
                <div class="button-middle"><input type="submit" value="Sign up" class="btn btn-outline-secondary btn-sm" ></div>
            </form>
        </form>
        </div>
        <h2 class="text-center my-5">Log In</h2>
        <p class="text-center h5 my-5">Log in to create and update movies that you like.</p>
        <div class="form-wrapper">
            <form action="authentication.php" method="post" onSubmit="return validate(this)">
                <label for="password" class="form-label">Password</label> <br>
                <input type="password" name="password"><br>
                <label for="email" class="form-label">Email</label> <br>
                <input type="text" name="email"><br>
                <br>
                <div class="button-middle"><input type="submit" value="Sign up" class="btn btn-outline-secondary btn-sm" ></div>
            </form>
            </form>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>
</html>

