<?php
session_start();
include_once "header.php";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ghibli Wiki</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <style type="text/css">
        .wrapper{
            margin: 6% auto ;
        }
        .button-wrapper{
            height: 25%;
            width: 100%;
        }
        #ghibli-video{
            height: 500px;
            width:100%; 
        }
    </style>
</head>
<body>

<div class="wrapper w-50">
<div class="container">
    <h1 class="text-center mb-5">Welcome to the Ghibli World!</h1>
    <h3 class="my-3">What is Ghibli studio? 👇</h3>
    <iframe 
        id="ghibli-video"
        src="https://www.youtube.com/embed/ABrmmsJWfzk" 
        title="ghibli-video-intro" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    <h3 class="mt-5 mb-3" >What movies do we have here already? 👀</h3>
    <div class="row">
        <?php
            require_once 'db.php';
            require_once 'functions.php';
            $query = "SELECT * FROM movies";
            $result = $conn->query($query);
            if (!$result){
                die("No result is available.");
            }

            $rows = $result->num_rows;


            for($j = 0; $j < $rows; ++$j){
                $row = $result->fetch_array(MYSQLI_ASSOC);
                $director_id = mysql_entities_fix_string($conn, $row["director_id"]);
                $id = mysql_entities_fix_string($conn, $row["id"]);
            //    has to explicitly pass conn bc the scope is available outside of the grab_director_info session
                $director = grab_director_info($conn, $director_id);
                $title = mysql_entities_fix_string($conn, $row['title']);
                $year = mysql_entities_fix_string($conn, $row["year"]);
                $image = mysql_entities_fix_string($conn, $row["image_url"]);
                $wiki = mysql_entities_fix_string($conn, $row["wiki"]);

                if ($director){
                    $director_name = $director["director_name"];
                }else{
                    $director_name = "unknown";
                }

                if (empty($image)){
                    $image = "https://prod3.agileticketing.net/images/user/fsc_2553/fs_my_neighbor_totoro_800.jpg";
                }

                echo <<<_INFO
                 <div class="card col-lg-4 col-sm-6 my-2">
                     <img class="card-img-top" src="$image" alt="$title">
                     <div class="card-body">
                         <h5 class="card-title">$title</h5>
                     </div>
                     <ul class="list-group list-group-flush">
                         <li class="list-group-item">Director: $director_name </li>
                         <li class="list-group-item">Year: $year  </li>
                     </ul>
                     <div class="card-body">
                         <a href='/update.php?id=$id' class="card-link">Update</a>
                         <a href='/delete.php?id=$id' class="card-link">Delete</a>
_INFO;
                    echo ($wiki? ("<a href='$wiki' class='card-link'>Delete</a>"):NULL);
                    echo "</div></div>";

            }

?>
    </div>
    <a href='/create.php' class='my-3 btn btn-primary'>Click me to create new movie!</a>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>
</html>

