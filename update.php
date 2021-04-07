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

<form action="update.php" method="post"><pre>

 <?php
     echo  "Title     <input type='text'' name ='title' value=$display_title><br>";
     echo  " Year      <input type='text' name='year' value=$display_year><br>";
     echo "<input type='hidden' name='id' value='$param_id'> ";
     echo  "Director   <select name='director_id' size='1'>";
                 foreach($director_list as $index=> $director){
                     $select_id = $director['director_id'];
                     $display_name = $director['name'];
                     echo "<option value=$select_id>$display_name</option>";
                 }
 ?>
        </select>
        <br>

     <input type="submit" value="UPDATE RECORD">

  </pre></form>