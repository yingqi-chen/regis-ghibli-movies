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
            $stmt = $conn->prepare("INSERT INTO $table_name VALUES(?,?, ?)");
            $stmt->bind_param('sss', $params_array["username"], $params_array["email"], $params_array["password"]);
            break;
    }



    return $stmt->execute();

//
//    if($stmt->execute()){
//       echo "Success for inserting data into $table_name <br>";
//     } else{
//       echo "Something went wrong. $conn->error Please try again later. <br>";
//     }
//
//
//    $stmt->close();

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

function delete_movie($conn, $param_id){
    $sql = "DELETE FROM movies WHERE id = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("i", $param_id);

    if($stmt->execute()){
        header("location: index.php");
        exit();
    } else{
        echo "DELETE failed";
    }
}

function mysql_entities_fix_string($conn, $string)
{
    $string = trim($string);
    $string = stripslashes($string);
    $string = htmlspecialchars($string);
    return $conn->real_escape_string($string);

}

function validate_username($field)
{
    if ($field.trim() == "") return "Username cannot be empty.\n";
    else if (strlen($field) < 5)
        return "Usernames must be at least 5 characters.\n";
    else if (preg_match("/[^a-zA-Z0-9_-]/", $field))
        return "Only a-z, A-Z, 0-9, - and _ allowed in Usernames.\n";
    return "";
}

function validate_password($field)
{
    if ($field.trim() == "") return "Password cannot be empty.\n";
    else if (strlen($field) < 6)
        return "Passwords must be at least 6 characters.\n";
    return "";
}


function validate_email($field)
{
    if ($field.trim() == "") return "Email cannot be empty.\n";
    else if (((!(strpos($field, '@') > 0)) && (!(strpos($field, '.')>0))) || preg_match("/[^a-zA-Z0-9.@_-]/", $field))
        return "The Email address is invalid.\n";
    return "";
}

function login_user($conn, $email, $password){
//    Check user exists or not
    $user_exists = check_user_exists($conn, $email);
    if ($user_exists){
//        check the returned user's password hash match $password, if success, return the user, so FE can deal with it
//          Go to index
    }else{
//        go back login page with error in the GET
    }

}

?>