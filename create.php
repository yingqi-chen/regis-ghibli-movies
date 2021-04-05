<?php
require_once 'db.php';
require_once 'functions.php';

if (!empty($_POST['director_id'])   &&
    !empty($_POST['title'])    &&
    !empty($_POST['year']))
{
    $title    = mysql_entities_fix_string($conn, 'title');
    $title_available = check_title($conn, $title);
    if ($title_available){
        $director_id   = mysql_entities_fix_string($conn, 'director_id');
        $year     = mysql_entities_fix_string($conn, 'year');
        $movie_attributes = array("director_id"=>$director_id, "title" => $title,"year" => $year);
        $insert_result = insert_data($conn, "movies", $movie_attributes);
        $_POST = array();
        header("location: index.php");
    }else{
        die("The movie with this title is already created.");
    }

}

$director_list = query_directors($conn);

?>

<h1>Create your favorite Ghibli movies here!</h1>
<form action="create.php" method="post"><pre>
     Title    <input type="text" name="title">
      Year    <input type="text" name="year">
     Director <select name='director_id' size="1">
             <?php
               foreach($director_list as $index=> $director){
                  $select_id = $director['director_id'];
                  $display_name = $director['name'];
                   echo "<option value=$select_id>$display_name</option>";
                  }
            ?>
        </select>
        <br>
     <input type="submit" value="ADD RECORD">

  </pre></form>
