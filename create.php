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
        array_push($directors, $director_attr);

        $result->close();
    }
    return $directors;
}
?>


<form action="create.php" method="post"><pre>
  Director <input type="text" name="director_id">
     Title <input type="text" name="title">
      Year <input type="text" name="year">
           <input type="submit" value="ADD RECORD">
  </pre></form>

<datalist id='links'>

</datalist>
