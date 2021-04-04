<?php

  $host = 'localhost';
  $database = 'ghibli_movies';
  $user = 'regis';
  $pass = 'MSSEregis2021~';

  $conn = new mysqli($host, $user, $pass, $database);

  if($conn->connect_error){
      die("ERROR: Could not connect. " .$conn->connect_error);
  };


?>