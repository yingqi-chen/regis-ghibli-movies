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

?>