<?php
$query = "SELECT * FROM movies";
$result = $conn->query($query);
if (!$result){
    die("No result is available.");
}

$rows = $result->num_rows;


for($j = 0; $j < $rows; ++$j){
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $director_id = mysql_entities_fix_string($conn, $row["director_id"]);
    $id = mysql_entities_fix_string($conn, $row["id"]);
    //    has to explicitly pass conn bc the scope is available outside of the grab_director_info session
    $director = grab_director_info($conn, $director_id);
    $title = mysql_entities_fix_string($conn, $row['title']);
    $year = mysql_entities_fix_string($conn, $row["year"]);
    $image = mysql_entities_fix_string($conn, $row["image_url"]);
    $wiki = mysql_entities_fix_string($conn, $row["wiki"]);

    if ($director){
        $director_name = $director["director_name"];
    }else{
        $director_name = "unknown";
    }

    if (empty($image)){
        $image = "https://prod3.agileticketing.net/images/user/fsc_2553/fs_my_neighbor_totoro_800.jpg";
    }

    echo <<<_INFO
                 <div class="card col-lg-4 col-sm-6 my-2">
                 <div class="image">
                     <img class="card-img-top" src="$image" alt="$title">
                 </div>
                     <div class="card-body">
                         <h5 class="card-title">$title</h5>
                     </div>
                     <ul class="list-group list-group-flush">
                         <li class="list-group-item">Director: $director_name </li>
                         <li class="list-group-item">Year: $year  </li>
                     </ul>
                     <div class="card-body">
                         <a href='/update.php?id=$id' class="btn btn-outline-secondary card-link">Update</a>
                         <a href='/delete.php?id=$id' class="btn btn-outline-secondary card-link">Delete</a>
_INFO;
    echo ($wiki? ("<a href='$wiki' class='btn btn-outline-secondary card-link'>Wiki</a>"):NULL);
    echo "</div></div>";

}

?>