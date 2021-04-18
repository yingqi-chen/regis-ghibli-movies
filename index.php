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
         session_start();
         print_r("$_SESSION");
         $username = $_SESSION['username'];
        if (isset($_SESSION['username'])){
          echo $username;
        } else{
            echo "user is not here";
        }
        $query = "SELECT * FROM movies";
        $result = $conn->query($query);
        if (!$result){
            die("Failed to grab result");
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

            if ($director){
                $director_name = $director["director_name"];
            }else{
                $director_name = "unknown";
            }

            echo <<<_INFO
             <div class="card col-lg-4 col-sm-6 my-2">
             <img class="card-img-top" src="https://flxt.tmsimg.com/assets/p158931_p_v10_aa.jpg" alt="$title">
             <div class="card-body">
                 <h5 class="card-title">$title</h5>
                 <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
             </div>
             <ul class="list-group list-group-flush">
                 <li class="list-group-item">Director: $director_name </li>
                 <li class="list-group-item">Year: $year  </li>
             </ul>
             <div class="card-body">
                 <a href='/update.php?id=$id' class="card-link">Update</a>
                 <a href='/delete.php?id=$id' class="card-link">Delete</a>
             </div>
         </div>                
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
    <a href='/create.php' class='my-3 btn btn-primary'>Click me to create new movie!</a>
  </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>
</html>

