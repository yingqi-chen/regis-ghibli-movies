<?php
//require_once 'db.php';
//require_once 'functions.php';
//include_once "header.php";
//
//session_start();
//$username = $_SESSION['username'];
//if (!$username){
//    header("location: index.php?error=needauthentication");
//    return ("You are not allowed to do this operation");
//}
//
//
//if (isset($_POST['delete'])) {
//    $id = $_POST['id'];
//
//    if (!empty($id)) {
//      return ("The id I got is: $id");
//    }else{
//      return ("Try again, the id of the movie is not valid.");
//    }
//}else{
//    $param_id = mysql_entities_fix_string($conn, $_GET["id"]);
//    $movie = query_movie($conn, $param_id);
//    $name = $movie['title'];
//}
//
//return json_encode(array("message" => "testing"));
//
//$conn->close();
//?>


<?php
// Headers that allows being queried from everywhere, receiving json, post method
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

require_once 'db.php';
require_once 'functions.php';

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));
$id = $data->id;

// Delete post

if (!empty($id)) {
    $result = delete_movie($conn, 15);
    if($result){
        if (mysqli_affected_rows($conn) > 0){
            echo json_encode(
                array("message"=>"Deleted Successfully!")
            );
        };
        echo json_encode(array("error_message" =>"Movie doesn't exist \n", "error"=>"Delete failed"));
    } else{
        echo json_encode(array("error_message" =>"errorsssss \n", "error"=>"Delete failed"));
    }}else{
    echo json_encode(array("error_message" =>"2 errorsssss \n", "error"=>"Delete failed"));

}

//    if($result){
//        echo json_encode(
//            array("message"=>"Deleted Successfully!")
//        );
//    }else{
//        echo json_encode(
//            array("error"=>"Delete failed")
//        );
//    }
//}else{
//    echo json_encode(array("error"=>"id is not valid."));
//}


//else{
//    $param_id = mysql_entities_fix_string($conn, $_GET["id"]);
//    $movie = query_movie($conn, $param_id);
//    $name = $movie['title'];
//}





