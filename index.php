<h1>Check out these great movies!</h1>

<?php
 require_once 'db.php';

if (isset($_POST['delete']) && isset($_POST['id'])){
    $id = $_POST['id'];
    $query  = "DELETE FROM movies WHERE id='$id'";
    $result = $conn->query($query);
    if (!$result) {
        echo "DELETE failed<br>";
    }
}

echo <<<_END
  <form action="create.php" method="post"><pre>
  Director <input type="text" name="director">
     Title <input type="text" name="title">
      Year <input type="text" name="year">
           <input type="submit" value="ADD RECORD">
  </pre></form>
_END;

$query = "SELECT * FROM movies";
$result = $conn->query($query);
if (!$result){
    die("Failed to grab result.");
}

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
      <form action='index.php' method='post'>
      <input type='hidden' name='delete' value='yes'>
      <input type='hidden' name='id' value='$id'>
      <input type='submit' value='DELETE RECORD'></form>
_DELETE;

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
