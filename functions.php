<?php

require_once 'db.php';

function create_table($conn, $table_name, $query){
    $result = $conn->query($query);
    if (!$result) {
        die ("Set up data failed");
    }else{
        echo "$table_name Table is ready!<br>";
    }
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
    }
 
    if($stmt->execute()){
       echo "Success for inserting data into $table_name <br>";
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
    $movies_query = "SELECT * FROM movies WHERE id = $id";
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
    return $movie;
}

function mysql_entities_fix_string($conn, $string)
{
    return htmlentities(mysql_fix_string($conn, $string));
}

function mysql_fix_string($conn, $string)
{
    if (get_magic_quotes_gpc()) $string = stripslashes($string);
    return $conn->real_escape_string($string);
}

function check_title($conn, $title){
    $movies_query = "SELECT * FROM movies WHERE title = $title";
    $result = $conn->query($movies_query);
    if ($result) return false;
    return true;
}

?>