
<!-- <img style="display: none;" src="/" alt="Smiley face inviseible" height="1" width="1">
<img src="/" alt="Smiley face visible" height="1" width="1">
-->

<!DOCTYPE html>
<head id="ctl00_head1">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>PHP MySQL access test</title>
</head>

<body>
<?php
  echo "<hr>";
  function myhead($id, $data)
  {
      return "<thead><tr><th>$id</th><th>$data</th></tr></thead><tbody>\n";
  }

  function myrow($id, $data)
  {
      return "<tr><td>$id</td><td>$data</td></tr>\n";
  }

  $arr = get_defined_functions();
  echo "<table>";
  echo myhead("name", "value");
  foreach($arr as $idd => $funlist) {
    echo myhead($idd, "functions");
    foreach($funlist as $id => $data)
    echo myrow($id, $data);
  }
  //print_r($arr);
  echo "</tbody></table>";
  echo "<hr>";

//  error_reporting(E_ALL);
  //ini_set("display_errors", 1);
  echo "Starting  . . .  testing <br>";
  echo $_SERVER['PHP_SELF'];
  echo "<br>";
  echo $_SERVER['SERVER_NAME'];
  echo "<br>";
  echo $_SERVER['HTTP_HOST'];
  echo "<br>";
  echo $_SERVER['HTTP_REFERER'];
  echo "<br>";
  echo $_SERVER['HTTP_USER_AGENT'];
  echo "<br>";
  echo $_SERVER['SCRIPT_NAME'];
  echo "<br>";

  $host = "mysql";
  $user = "finecomputing";
  $pd = "sqlKreml1n";
  $database = "consulting";

  $conn  = new mysqli($db, $user, $pd, $database);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error . "<br>");
  }

  echo "Connected successfully<hr>";
  $query = "show databases;";
  $result = $conn->query($query);

   echo "Test $host $user $password $database $query<br>";

   if ($result->num_rows > 0) {
     echo "<ul>";
       // output data of each row
       while($row = $result->fetch_assoc()) {
         foreach ($row as $colname => $colvalue) {
           echo "<li>" . htmlentities("$colname => $colvalue");
         }
       }
      echo "</ul>";
   } else {
       echo "0 results";
   }
   $conn->close();
?>
funection consulting_server(){
  echo "<h2> Consukting server PHP Lib. <h2>";
}
<?php  include 'site_footer.php'; ?>
</body>
</html>
