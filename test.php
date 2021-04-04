<?php 
  require_once 'db.php';

  if (isset($_POST['delete']) && isset($_POST['id']))
  {
    $id   = get_post($conn, 'id');
    $query  = "DELETE FROM movies WHERE id='$id'";
    $result = $conn->query($query);
    if (!$result) echo "DELETE failed<br><br>";
  }

  if (!empty($_POST['director'])   &&
      !empty($_POST['title'])    &&
      !empty($_POST['release_year'])) 
  {
    $director   = get_post($conn, 'director');
    $title    = get_post($conn, 'title');
    $release_year     = get_post($conn, 'release_year');
    $query    = "INSERT INTO movies(title, director, release_year) VALUES" .
      "('$title', '$director','$release_year')";
    echo "$query";
    $result   = $conn->query($query);
    if (!$result) echo "INSERT failed<br><br>";
  }
 echo "wow<h1>yo</h1>";

 printsomething("Before");
 global $w;
 echo "Cool2: {$w} <br>";

 $w= "what";
 echo "Cool2: {$w} <br>";

 function printsomething($c){
   echo "Cool: {$w}hehe{$c} <br>";
 }
 printsomething("Bottom");
  echo <<<_END
  <form action="test.php" method="post"><pre>
  Director <input type="text" name="director">
     Title <input type="text" name="title">
      Year <input type="text" name="release_year">
           <input type="submit" value="ADD RECORD">
  </pre></form>
_END;

  $query  = "SELECT * FROM movies";
  $result = $conn->query($query);
  if (!$result) die ("Database access failed");

  $rows = $result->num_rows;

  for ($j = 0 ; $j < $rows ; ++$j)
  {
    $row = $result->fetch_array(MYSQLI_NUM);

    $r0 = htmlspecialchars($row[0]);
    $r1 = htmlspecialchars($row[1]);
    $r2 = htmlspecialchars($row[2]);
    $r3 = htmlspecialchars($row[3]);
    
    echo <<<_END
  <pre>
        ID $r0
     Title $r1
  Director $r2
      Year $r3
  </pre>
  <form action='test.php' method='post'>
  <input type='hidden' name='delete' value='yes'>
  <input type='hidden' name='id' value='$r0'>
  <input type='submit' value='DELETE RECORD'></form>
_END;
  }

  $result->close();
  $conn->close();
  function get_post($conn, $var)
  { 
    return $conn->real_escape_string($_POST[$var]);
  };

?>