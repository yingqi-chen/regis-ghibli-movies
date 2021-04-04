<h1>Check out these great movies!</h1>

<?php
 require_once 'db.php';

 $query = "SELECT * FROM movies";
 $result = $conn->query($query);
 if (!$result){
     die("Failed to grab result.");
 }

$rows = $result->num_rows;

for($j = 0; $j < $rows; ++$j){
    $row = $result->fetch_array(MYSQLI_ASSOC);
    echo "<strong>Director</strong>: <br>", htmlspecialchars($row["director"]), "<br>";
    echo "<strong>Title</strong>: <br>", htmlspecialchars($row["title"]), "<br>";
    echo "<strong>Year</strong>: <br>", htmlspecialchars($row["release_year"]), "<br>";
    echo "<br>";
}

$result->close();
$conn->close();

?>
