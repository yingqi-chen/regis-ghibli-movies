<?php

require_once 'db.php';

function create_table($conn, $table_name, $query){
    $result = $conn->query($query);
    if (!$result) {
        die ("Set up data failed");
    }else{
        echo "$table_name Table is ready!<br>";
    }
//    $result->close(); #when do I close result? Do I have to?
}

function insert_data($conn, $table_name, $params_array){
  
    switch($table_name){
      case "movies":
       $stmt = $conn->prepare("INSERT INTO $table_name VALUES(NULL,?,?,?)");
       $stmt->bind_param('iss',$params_array["director_id"], $params_array["title"], $params_array["year"]);
       break;
      case "directors":
       $stmt = $conn->prepare("INSERT INTO $table_name VALUES(NULL,?)");
       $stmt->bind_param('s',$params_array["name"]);
       break;
      case "users":
       $stmt = $conn->prepare("INSERT INTO $table_name VALUES(?,?)");
       $stmt->bind_param('ss', $params_array["username"], $params_array["password"]);
       break;
//      case "characters":
//       $stmt = $conn->prepare("INSERT INTO $table_name VALUES(NULL,?,?,?)");
//       $stmt->bind_param('ssi', $params_array["name"], $params_array["introduction"], $params_array["movie_id"]);
//       break;
    }
 
    if($stmt->execute()){
       echo "success for $table_name";
     } else{
         echo "Something went wrong. Please try again later.";
     }
 
    $stmt->close();
    return true;
 }

function update_data($conn, $table_name, $params_array){

    switch($table_name){
        case "movies":
            $stmt = $conn->prepare("UPDATE $table_name SET director_id=?, title=?, year=? WHERE id=?");
            $stmt->bind_param('issi',$params_array["director_id"], $params_array["title"], $params_array["year"],$params_array["id"] );
            break;
        case "users":
            $stmt = $conn->prepare("INSERT INTO $table_name VALUES(?,?)");
            $stmt->bind_param('ss', $params_array["username"], $params_array["password"]);
            break;
    }

    if($stmt->execute()){
        echo "";
    } else{
        echo "Something went wrong when updating. Please try again later.";
    }

    $stmt->close();
    return true;
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
        $director_attr = array(
            "director_id" => $row["id"],
            "name" => $row["name"]
        );
        array_push($directors, $director_attr);
    }
    return $directors;
}

function query_movies($conn)
{
    $movies = array();
    $movies_query = "SELECT * FROM movies";
    $result = $conn->query($movies_query);
    if (!$result) die ("Database access failed");

    $rows = $result->num_rows;
    for ($j = 0; $j < $rows; ++$j) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $movie_attr = array(
            "movie_id" => $row["id"],
            "title" => $row["title"],
            "director_id"=>$row["director_id"],
            "year" => $row["year"]
        );
        array_push($movies, $movie_attr);
    }
    return $movies;
}

function query_movie($conn, $id)
{
    echo $id;
    $movies_query = "SELECT * FROM movies WHERE id = $id";
    echo $movies_query;
    $result = $conn->query($movies_query);
    if (!$result) {
        die ("No such movie");
    }

    $row = $result->fetch_array(MYSQLI_ASSOC);
    $movie = array(
        "movie_id" => $row["id"],
        "title" => $row["title"],
        "director_id"=>$row["director_id"],
        "year" => $row["year"]
    );
    $result->close();
    return $movie;
}

function get_post($conn, $var)
{
    return $conn->real_escape_string($_POST[$var]);
};
?>