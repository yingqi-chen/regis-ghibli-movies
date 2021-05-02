<?php

  require_once "vendor/autoload.php";

  $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ ."/../");
  $dotenv->load();

  $host = 'localhost';
  $database = 'ghibli_movies';
  $user = $_ENV["DB_USER"];
  $pass = $_ENV["DB_PASSWORD"];

  $conn = new mysqli($host, $user, $pass, $database);

  if($conn->connect_error){
      die("ERROR: Could not connect. " .$conn->connect_error);
  };


?>