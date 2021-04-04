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
    $director_id = $row["director_id"];
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
