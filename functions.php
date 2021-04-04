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
       echo "movies table";
       $stmt = $conn->prepare("INSERT INTO $table_name VALUES(NULL,?,?,?)");
       $stmt->bind_param('iss', $d, $t, $y);
       $d = $params_array["director_id"];
       $t = $params_array["title"];
       $y = $params_array["year"];
       break;
      case "directors":
       echo "d table";
       $stmt = $conn->prepare("INSERT INTO $table_name VALUES(NULL,?,?)");
       $stmt->bind_param('ss', $n, $i);
       $n = $params_array["name"];
       $i = $params_array["introduction"];
       break;
      case "characters":
       echo "c table";
       $stmt = $conn->prepare("INSERT INTO $table_name VALUES(NULL,?,?,?)");
       $stmt->bind_param('ssi', $n, $i, $m);
       $n = $params_array["name"];
       $i = $params_array["introduction"];
       $m = $params_array["movie_id"];
       break;
    }
 
    if($stmt->execute()){
       echo "Successfully inserted into $table_name!<br>";
     } else{
         echo "Something went wrong. Please try again later.";
     }
 
    $stmt->close();
 }

?>