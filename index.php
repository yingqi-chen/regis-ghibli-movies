<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ghibli Wiki</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="row"></div>
    <h1>Check out these great movies!</h1>
    <div class="row">
    <?php
     require_once 'db.php';
     require_once 'functions.php';
     print_r($_POST);


    echo "break";

    echo "<button><a href='/create.php'>Click me to create new movie!</a></button><br><br>";

    $query = "SELECT * FROM movies";
    $result = $conn->query($query);
    if (!$result){
        die("Failed to grab result");
    }
    echo "break";

    $rows = $result->num_rows;

    for($j = 0; $j < $rows; ++$j){
        $row = $result->fetch_array(MYSQLI_ASSOC);
        print_r($row);
        $director_id = mysql_entities_fix_string($conn, $row["director_id"]);
        $id = mysql_entities_fix_string($conn, $row["id"]);
    //    has to explicitly pass conn bc the scope is available outside of the grab_director_info session
        $director = grab_director_info($conn, $director_id);
        $title = mysql_entities_fix_string($conn, $row['title']);
        $year = mysql_entities_fix_string($conn, $row["year"]);

        if ($director){
            $director_name = $director["director_name"];
        }else{
            $director_name = "unknown";
        }
        echo <<<_INFO
          Director: $director_name <br>
          Title: $title<br>
          Year: $year  <br>
          <br>
          <a href='/update.php?id=$id'>Update this movie!</a><br>
          <a href='/delete.php?id=$id'>Delete this movie!</a><br>
         
_INFO;


    }

    function grab_director_info($conn, $director_id){
        $grab_director_query = "SELECT * FROM directors WHERE id = $director_id ";
        $result = $conn->query($grab_director_query);
        if (!$result){
            return null;
        }else{
            $row = $result->fetch_array(MYSQLI_ASSOC);
            return array(
                "director_name" => htmlspecialchars($row["name"]),
                "director_introduction" => htmlspecialchars($row["introduction"])
            );
        }
    }

    $result->close();
    $conn->close();
    ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

</body>
</html>

