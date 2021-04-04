<?php
require_once 'db.php';
require_once 'functions.php';

if (!empty($_POST['director_id'])   &&
    !empty($_POST['title'])    &&
    !empty($_POST['year']))
{
    $director_id   = get_post($conn, 'director_id');
    $title    = get_post($conn, 'title');
    $year     = get_post($conn, 'year');
    $movie_attributes = array("director_id"=>$director_id, "title" => $title,"year" => $year);
    $insert_result = insert_data($conn, "movies", $movie_attributes);
        $_POST = array();
}

$director_list = query_directors($conn);
print_r($director_list);

function get_post($conn, $var)
{
    return $conn->real_escape_string($_POST[$var]);
};


function query_directors($conn)
{
    $directors = array();
    $directors_query = "SELECT * FROM directors";
    $result = $conn->query($directors_query);
    if (!$result) die ("Database access failed");

    $rows = $result->num_rows;
    for ($j = 0; $j < $rows; ++$j) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $director_attr = array(
            "director_id" => $row["id"],
            "name" => $row["name"]
        );
        print_r("Hi!!!:::".$director_attr ."<br>") ;
        array_push($directors, $director_attr);
    }
    return $directors;
}
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
