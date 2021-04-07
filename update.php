<?php
require_once 'db.php';
require_once 'functions.php';

if (!empty($_POST['director_id'])   &&
    !empty($_POST['title'])    &&
    !empty($_POST['year'])    &&
    !empty($_POST['id']))
{
    $title    = mysql_entities_fix_string($conn, $_POST['title']);
    $director_id = mysql_entities_fix_string($conn, $_POST['director_id']);
    $year = mysql_entities_fix_string($conn, $_POST['year']);
    $id = mysql_entities_fix_string($conn, $_POST['id']);
    $movie_attributes = array("director_id" => $director_id, "title" => $title, "year" => $year, "id" => $id);
    $update_result = update_data($conn, "movies", $movie_attributes);
    if($update_result){
        header("location: index.php");
        $_POST = array();
    }else{
        echo "Something went wrong. $conn->error Please try again later. <br>";
    }
}

$director_list = query_directors($conn);
$param_id = mysql_entities_fix_string($conn, $_GET["id"]);
$movie = query_movie($conn, $param_id);
$display_title = $movie['title'];
$display_year = $movie['year'];

$conn -> close();
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
        .form-wrapper{
            width: 50%;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div class="wrapper w-50">
    <div class="container">
        <h2 class="text-center my-5">Update movie <?php echo "$display_title here"?></h2>
        <div class="form-wrapper">
            <form action="update.php" method="post">
                <label for="director_id" class="form-label">Director</label>
                <select class="form-select form-select-sm" name='director_id' size="1">
                    <?php
                    foreach($director_list as $index=> $director){
                        $select_id = $director['director_id'];
                        $display_name = $director['name'];
                        echo "<option value=$select_id>$display_name</option>";
                    }
                    ?>
                </select><br>
                <label for="title" class="form-label" >Title</label> <br>
                <input type="text" name="title" value="<?php echo $display_title ?>" ><br>
                <label for="year" class="form-label">Year</label> <br>
                <input type="text" name="year" value="<?php echo $display_year ?>" ><br>
                <input type='hidden' name='id' value='<?php echo $param_id ?>'>
                <br>
                <input type="submit" value="UPDATE RECORD" class="btn btn-outline-secondary btn-sm">
            </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>
</html>