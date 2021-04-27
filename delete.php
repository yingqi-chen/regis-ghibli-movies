<?php
// Headers that allows being queried from everywhere, receiving json, post method
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

require_once 'config/db.php';
require_once 'helpers/functions.php';

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));
$id = $data->id;

// Delete post
if (!empty($id)) {
    if(delete_movie($conn, $id)){
            echo json_encode(
                array("message"=>"Deleted Successfully!")
            );
            }
    }else{
    echo json_encode(array("errorMessage" =>"ID is not valid"));
}








