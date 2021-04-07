<?php
require_once 'db.php';
require_once 'functions.php';

print_r($_POST);
$param_id = mysql_entities_fix_string($conn, $_GET["id"]);


if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    if (!empty($id)) {
        print_r("what is wrong here");
      delete_movie($conn, $id);
    }else{
        echo "what is this here $id <br>";
        die("Try again, the id of the movie is not valid.");
    }
    print_r("what is wrong2");

}

//$result->close();
//$conn->close();
?>

<h2>Are you sure you want to delete?</h2>
<form action='delete.php' method='post'>
    <input type='hidden' name='delete' value='yes'>
    <input type='hidden' name='id' value="<?php echo $param_id; ?>">
    <input type='submit' value='DELETE RECORD'>
</form>

