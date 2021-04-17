<!-- Create TABLE/INSERT SEED DATA -->

<?php
  require_once 'db.php';
  require_once 'functions.php';

  $create_movies_table_query = "CREATE TABLE IF NOT EXISTS movies (
    id SMALLINT NOT NULL AUTO_INCREMENT,
    director_id SMALLINT NOT NULL,
    title VARCHAR(128) NOT NULL UNIQUE,
    year YEAR NOT NULL,
    image_url VARCHAR(1000),
    wiki VARCHAR(1000),
    PRIMARY KEY (id)
  )";

$create_directors_table_query = "CREATE TABLE IF NOT EXISTS directors (
    id SMALLINT NOT NULL AUTO_INCREMENT,
    name VARCHAR(128) NOT NULL UNIQUE ,
    PRIMARY KEY (id)
  )";


$create_users_table_query = "CREATE TABLE IF NOT EXISTS users (
    username VARCHAR(32) NOT NULL UNIQUE,
    email VARCHAR (100) NOT NULL UNIQUE, 
    password VARCHAR(255) NOT NULL
  )";

create_table($conn, "movies", $create_movies_table_query );
create_table($conn, "directors", $create_directors_table_query);
create_table($conn, "users", $create_users_table_query);


echo "Inserting values now...<br>";

$movie_attribute_array = array("director_id" =>1, "title" => "Castle in the Sky", "year"=>1986, "image_url"=>"https://upload.wikimedia.org/wikipedia/en/f/f5/Castle_in_the_Sky_%281986%29.png", "wiki"=>"https://en.wikipedia.org/wiki/Castle_in_the_Sky");
$director1_attribute_array = array("name" => "Hayao Miyazaki");
$director2_attribute_array = array("name" => "Isao Takahata");
$director3_attribute_array = array("name" => "Yoshifumi Kondō");
insert_data($conn, "directors", $director1_attribute_array);
insert_data($conn, "directors", $director2_attribute_array);
insert_data($conn, "directors", $director3_attribute_array);
insert_data($conn, "movies", $movie_attribute_array);


$conn->close();

?>