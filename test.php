<?php 
  require_once 'db.php';
  require_once 'functions.php';

  query_directors($conn);

  if (isset($_POST['delete']) && isset($_POST['id']))
  {
    $id   = get_post($conn, 'id');
    $query  = "DELETE FROM movies WHERE id='$id'";
    $result = $conn->query($query);
    if (!$result) echo "DELETE failed<br><br>";
  }

  if (!empty($_POST['director_id'])   &&
      !empty($_POST['title'])    &&
      !empty($_POST['year']))
  {
    $director_id   = get_post($conn, 'director_id');
    $title    = get_post($conn, 'title');
    $year     = get_post($conn, 'year');
    $movie_attributes = array("director_id"=>$director_id, "title" => $title,"year" => $year);
    $insert_result = insert_data($conn, "movies", $movie_attributes);
    if ($insert_result) {
        $_POST = array();

    }
  }

  echo <<<_END
  <form action="test.php" method="post"><pre>
  Director <input type="text" name="director_id">
     Title <input type="text" name="title">
      Year <input type="text" name="year">
           <input type="submit" value="ADD RECORD">
  </pre></form>
_END;

$query  = "SELECT * FROM movies";
$result = $conn->query($query);
if (!$result) die ("Database access failed");

$rows = $result->num_rows;

for($j = 0; $j < $rows; ++$j){

    $row = $result->fetch_array(MYSQLI_ASSOC);
    $director_id = $row["director_id"];
    $id = $row["id"];

//    has to explicitly pass conn bc the scope is available outside of the grab_director_info session
    $director = grab_director_info($conn, $director_id);
    if ($director){
        $director_name = $director["director_name"];
    }else{
        $director_name = "unknown";
    }

    echo "<strong>Director</strong>: <br>", $director_name, "<br>";
    echo "<strong>Title</strong>: <br>", htmlspecialchars($row["title"]), "<br>";
    echo "<strong>Year</strong>: <br>", htmlspecialchars($row["year"]), "<br>";
    echo "<br>";

    echo <<<_DELETE
      <form action='test.php' method='post'>
      <input type='hidden' name='delete' value='yes'>
      <input type='hidden' name='id' value='$id'>
      <input type='submit' value='DELETE RECORD'></form>
_DELETE;
  }

  $result->close();
  $conn->close();
  function get_post($conn, $var)
  { 
    return $conn->real_escape_string($_POST[$var]);
  };

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

function query_directors($conn)
{
    $directors = array();
    $directors_query = "SELECT * FROM directors";
    $result = $conn->query($directors_query);
    if (!$result) die ("Database access failed");

    $rows = $result->num_rows;
    for ($j = 0; $j < $rows; ++$j) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $director_id = $row["id"];
        $name = $row["name"];


        $result->close();
        $conn->close();
    }

}
