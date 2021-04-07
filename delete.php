<?php
require_once 'db.php';
require_once 'functions.php';

$param_id = mysql_entities_fix_string($conn, $_GET["id"]);


if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    if (!empty($id)) {
      delete_movie($conn, $id);
    }else{
        die("Try again, the id of the movie is not valid.");
    }

}

$conn->close();
?>

<h2>Are you sure you want to delete?</h2>
<form action='delete.php' method='post'>
    <input type='hidden' name='delete' value='yes'>
    <input type='hidden' name='id' value="<?php echo $param_id; ?>">
    <input type='submit' value='DELETE RECORD'>
</form>

