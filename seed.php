<!-- Create TABLE/INSERT SEED DATA -->

<?php
  require_once 'db.php';
  require_once 'functions.php';
// should refactor the way query is done. Too many repetition.


  $create_movies_table_query = "CREATE TABLE IF NOT EXISTS movies (
    id SMALLINT NOT NULL AUTO_INCREMENT,
    director_id SMALLINT NOT NULL,
    title VARCHAR(128) NOT NULL,
    year CHAR(4) NOT NULL,
    PRIMARY KEY (id)
  )";

$result = $conn->query($create_movies_table_query);
if (!$result) {
  die ("Set up data failed");
}else{
    echo " $table_name Table is ready!<br>";
}


function create_table($conn, $table_name, $query){
  echo "Inside $conn, $table_name, $query";
  $result = $conn->query($query);
  if (!$result) {
    die ("Set up data failed");
  }else{
      echo " $table_name Table is ready!<br>";
  }
}


$create_directors_table_query = "CREATE TABLE IF NOT EXISTS directors (
    id SMALLINT NOT NULL AUTO_INCREMENT,
    name VARCHAR(128) NOT NULL,
    introduction TEXT NOT NULL,
    PRIMARY KEY (id)
  )";

create_table($conn, "directors", $create_directors_table_query);


$create_characters_table_query = "CREATE TABLE IF NOT EXISTS characters (
    id SMALLINT NOT NULL AUTO_INCREMENT,
    name VARCHAR(128) NOT NULL,
    introduction TEXT NOT NULL,
    movie_id SMALLINT NOT NULL,
    PRIMARY KEY (id)
  )";

  
// create_table("movies", $create_movies_table_query);
create_table("characters", $create_characters_table_query);


  echo "Inserting values now...";

// Will have to add validation later


$movie_attribute_array = array("director_id" =>1, "title" => "hih", "year"=>1995);
$director_attribute_array = array("name" => "director", "introduction" => "wwwwaaat");
$character_attribute_array = array("name" => "cha", "introduction" => "ccc", "movie_id"=>1);
insert_data($conn, "directors", $director_attribute_array);
insert_data($conn, "characters", $character_attribute_array);
insert_data($conn, "movies", $movie_attribute_array);


// When should I close connection?? At the end or after every statment?
$conn->close();

?>