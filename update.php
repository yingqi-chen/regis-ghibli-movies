<?php
require_once 'config/db.php';
require_once 'helpers/functions.php';
include_once 'helpers/header.php';

session_start();
$username = $_SESSION['username'];

if (!$username){
    header("location: index.php?error=needauthentication");
}

$errorCode = mysql_entities_fix_string($conn, $_GET['error']);
$error = interpretErrorCode($errorCode);


if ($_SERVER["REQUEST_METHOD"] == "GET"){
    $param_id = mysql_entities_fix_string($conn, $_GET["id"]);
    $director_list = query_directors($conn);
    $movie = query_movie($conn, $param_id);
    $display_title = $movie['title'];
    $display_year = $movie['year'];
    $display_wiki = $movie['wiki'];
    $display_image = $movie['image_url'];
    $conn -> close();
}


if (!empty($_POST['director_id'])   &&
    !empty($_POST['title'])    &&
    !empty($_POST['year'])    &&
    !empty($_POST['id']))
{
    $title    = mysql_entities_fix_string($conn, $_POST['title']);
    $director_id = mysql_entities_fix_string($conn, $_POST['director_id']);
    $year = mysql_entities_fix_string($conn, $_POST['year']);
    $id = mysql_entities_fix_string($conn, $_POST['id']);
    $wiki = mysql_entities_fix_string($conn, $_POST['wiki']);
    $image_url = mysql_entities_fix_string($conn, $_POST['image_url']);

    $valid_wiki = validateURL($wiki);
    $valid_image = validateURL($image_url);

if ($valid_image && $valid_wiki ) {
    $valid_wiki = validateURL($wiki);
    $valid_image = validateURL($image_url);

    $movie_attributes = array("director_id" => $director_id, "title" => $title, "year" => $year, "id" => $id, "wiki"=>$wiki, "image_url" => $image_url);

    $update_result = update_data($conn, "movies", $movie_attributes);
    if($update_result){
        header("location: index.php");
        $_POST = array();
    }else{
        echo "Something went wrong. $conn->error Please try again later. <br>";
    }}else{
    header("location: update.php?id=$id&error=notvalidurl");
}
}elseif($_SERVER["REQUEST_METHOD"] == "POST"){
    $id = mysql_entities_fix_string($conn, $_POST['id']);
    header("location: update.php?id=$id&error=emptyrequirefield");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ghibli Wiki</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel='stylesheet' href='style/styles.css'>
</head>
<body>
<div class="wrapper w-50">
    <div class="container">
        <h3 class="text-center" style="color: red"><?php echo $error?> </h3>
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
                <label for="title" class="form-label">Title</label> <br>
                <input type="text" name="title" value="<?php echo $display_title ?>" ><br>
                <label for="year" class="form-label">Year</label> <br>
                <input type="text" name="year" value="<?php echo $display_year ?>" ><br>
                <input type='hidden' name='id' value='<?php echo $param_id ?>'>
                <label for="wiki" class="form-label" >Wiki(optional)</label> <br>
                <input size="80%" type="text" name="wiki" value="<?php echo $display_wiki ?>"><br>
                <label for="image_url" class="form-label">Image(optional)</label> <br>
                <input size="80%" type="text" name="image_url" value="<?php echo $display_image ?>" ><br>
                <br>
                <input type="submit" value="UPDATE RECORD" class="btn btn-outline-secondary btn-sm">
            </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>
</html>