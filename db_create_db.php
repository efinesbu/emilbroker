<!DOCTYPE html>

<head id="ctl00_head1"><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>PHP MySQL create db test</title>
</head>

<body>
<?php
  echo "Starting  . . .  testing <br>";

  $host = "mysql";
  $user = "finecomputing";
  $pd = "sqlKreml1n";
  $database = "consulting";

  $conn  = new mysqli($db, $user, $pd);
 // Check connection

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error . "<br>");
  }

  echo "Connected successfully<hr>";

  $query = "CREATE DATABASE $database;";
  if ($conn->query($sql) === TRUE) {
      echo "Database created successfully";
  } else {
      echo "Error creating database: " . $conn->error;
  }
  $conn->close();
?>

<?php  include 'site_footer.php'; ?>
</body>
</html>
