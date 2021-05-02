<?php

require_once 'config/db.php';

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
            $stmt = $conn->prepare("INSERT INTO $table_name VALUES(NULL,?,?,?,?,?)");
            $stmt->bind_param('issss',$params_array["director_id"], $params_array["title"], $params_array["year"], $params_array["image_url"], $params_array["wiki"]);
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

 }

function update_data($conn, $table_name, $params_array){
    switch($table_name){
        case "movies":
            $stmt = $conn->prepare("UPDATE $table_name SET director_id=?, title=?, year=?, wiki=?, image_url=? WHERE id=?");
            $stmt->bind_param('issssi',$params_array["director_id"], $params_array["title"], $params_array["year"],$params_array["wiki"], $params_array["image_url"], $params_array["id"] );
            break;
        case "users":
            $stmt = $conn->prepare("INSERT INTO $table_name VALUES(?,?)");
            $stmt->bind_param('ss', $params_array["username"], $params_array["password"]);
            break;
    }

    if($stmt->execute()){
        $stmt->close();
        return true;
    } else{
        return false;
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
        "year" => $row["year"],
        "wiki" => $row["wiki"],
        "image_url" => $row["image_url"]
    );

    return $movie;
}

function delete_movie($conn, $param_id){
    $sql = "DELETE FROM movies WHERE id = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("i", $param_id);

    if($stmt->execute()){
        if (mysqli_affected_rows($conn) > 0){
            return true;
        }else{
            echo json_encode(array("errorMessage" =>"Movie doesn't exist"));
            return false;
        }
    } else{
        echo json_encode(array("errorMessage" =>"Error: %s.\n", $stmt->error));
        return false;
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

function query_user($conn, $email, $path)
{
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt){
        header("location: $path?error=stmtfailed");
    }else{
        $stmt->bind_param("s", $email);
        if( !$stmt->execute()){
            header("location: $path?error=executionfailed");
        }
    }

    $result=$stmt->get_result();

    if ($result->num_rows>0) {
        return $result->fetch_array(MYSQLI_ASSOC);
    }else{
        if ($path=="login.php"){
            header("location: login.php?error=nouser");
        }
    }
}

function login_user($conn, $email, $password){
//    Check user exists or not
    $user = query_user($conn, $email, "login.php");
    if ($user){
//        check the returned user's password hash match $password, if success, return the user, so FE can deal with it
       if(password_verify($password, $user['password'])){
           session_start();
           $_SESSION['username'] = $user['username'];
           header("location: index.php");
           exit();
       } else{
           header("location: login.php?error=validationfailed");
       }
    }
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
    $result->close();
    $conn->close();
}

function interpret_errorCode($errorCode){
    switch ($errorCode){

        case 'stmtfailed'| 'executionfailed':
            echo "wat";
            return "Sorry there are some problems when we execute this operation. <br> Please sign up or log in first.";

        case 'needauthentication':
            return "Sorry there are some problems when we execute this operation. <br> Please <a href='/signup.php'>sign up</a> or <a href='/login.php'>log in</a>  first.";
        case 'nouser':
            return "User doesn't exist. Please try again.";
        case 'validationfailed':
            return "User/Password pair doesn't exist. Please try again.";
        case 'userexisted':
            return "The email is taken. Please try again.";
        case 'userloggedin':
            return "You are already logged in.";
        case 'emptyrequirefield':
            return "You missed some required field. Please try again.";
        case 'notvalidfield':
        case 'notvalidurl':
            return "The data you input are not valid. Please try again.";
    }
}

function validate_URL($url){
    if ($url && (!filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED))) {
        return false;
    }
    return true;
}

function check_url_for_wiki_and_image($wiki,$image_url){
    if (validate_URL($wiki)&& validate_URL($image_url)){
        return true;
    };
}


