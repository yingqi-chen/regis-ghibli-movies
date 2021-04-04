<?php // convert.php
$f = $c = '';

if (isset($_POST['f'])) $f = sanitizeString($_POST['f']);
if (isset($_POST['c'])) $c = sanitizeString($_POST['c']);
if (isset($_POST)) $v = $_POST;

//if (is_numeric($f))
//{
//    $c = intval((5 / 9) * ($f - 32));
//    $out = "$f &deg;f equals $c &deg;c";
//}
//elseif(is_numeric($c))
//{
//    $f = intval((9 / 5) * $c + 32);
//    $out = "$c &deg;c equals $f &deg;f";
//}
//else $out = "";

$out1 = $v;
$out2 = $c;

foreach($_POST as $pp)
foreach($pp as $key => $value)
        echo "wow{$key}: {$value} <br>";


echo <<<_END
<html>
  <head>
    <title>Temperature Converter</title>
  </head>
  <body>
    <pre>
      Enter either Fahrenheit or Celsius and click on Convert

      <b>$out1</b>


      <form method="post" action="">
        Fahrenheit <input type="text" name="f" size="7">
           Celsius <input type="text" name="c" size="7">
                   <input type="submit" value="Convert">
        Vegetables
<select name="veg[]" size="5" multiple="multiple">
  <option value="Peas">Peas</option>
  <option value="Beans">Beans</option>
  <option value="Carrots">Carrots</option>
  <option value="Cabbage">Cabbage</option>
  <option value="Broccoli">Broccoli</option>
</select>
      </form>
    </pre>
  </body>
</html>
_END;

function sanitizeString($var)
{
    $var = stripslashes($var);
    $var = strip_tags($var);
    $var = htmlentities($var);
    echo $var;

    return $var;
  }
?>