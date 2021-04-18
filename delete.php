<?php
require_once 'db.php';
require_once 'functions.php';
include_once "header.php";

session_start();

if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    if (!empty($id)) {
      delete_movie($conn, $id);
    }else{
        die("Try again, the id of the movie is not valid.");
    }
}else{
    $param_id = mysql_entities_fix_string($conn, $_GET["id"]);
    $movie = query_movie($conn, $param_id);
    $name = $movie['title'];
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>Ghibli Wiki</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <style type="text/css">
        .wrapper{
            margin: 6% auto ;
        }
        .button-wrapper{
            width: 30%;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div class="wrapper w-50">
    <div class="container">
        <h2 class="text-center my-5">Are you sure you want to delete <?php echo $name ?>?</h2>
        <form action='delete.php' method='post'>
            <input type='hidden' name='delete' value='yes'>
            <input type='hidden' name='id' value="<?php echo $param_id; ?>">
            <div class="button-wrapper row gx-2">
                <a href="index.php" class="col-5 btn btn-outline-primary btn-sm">Go Back</a>
                <input type='submit' value='DELETE RECORD' class="col-5 btn btn-outline-danger btn-sm"/>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>
</html>
