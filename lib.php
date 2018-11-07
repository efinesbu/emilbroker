<?php
function consulting_server()
{
  echo "<ul>";
  foreach ($_SERVER as $key => $value) {
    // code...
    echo "<li>". $key . " => " .  $value . "<br>";
  }
  echo "</ul>";
}
?>
