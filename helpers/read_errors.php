<?php
$errorCode = mysql_entities_fix_string($conn, $_GET['error']);
$error = interpretErrorCode($errorCode);
?>
<h3 class='text-center mt-5' style='color: red'><?php echo $error?> </h3>