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
        echo json_encode(array("error"=>"Delete failed", "error_message" =>"Movie doesn't exist" ));
    } else{
        echo json_encode(array("error"=>"Delete failed","error_message" =>"Failed due to unexpected error."));
        header('HTTP/1.1 500 Internal Server Error');
    }}else{
    echo json_encode(array("error"=>"Delete failed","error_message" =>"ID is not valid"));

}








