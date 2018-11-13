<!DOCTYPE html>

<head id="ctl00_head1"><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>PHP MySQL create db table</title>
</head>

<body>
<?php
  echo "Starting  . . .  testing <br>";
  requre "lib.php";


  $host = "mysql";
  $user = "finecomputing";
  $pd = "sqlKreml1n";
  $database = "consulting";
  $table = "customers";

  $conn  = new mysqli($db, $user, $pd, $database);
 // Check connection

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error . "<br>");
  }

  echo "Connected successfully<hr>";

  $query = "CREATE TABLE $table (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        customer_id INT(6) KEY,
        firstname VARCHAR(30) NOT NULL,
        lastname VARCHAR(30) NOT NULL,
        email VARCHAR(50),
        phone VARCHAR(50),
        status VARCHAR(50)  NOT NULL,,
        message VARCHAR(50),
        reg_date TIMESTAMP
        )";


  if ($conn->query($sql) === TRUE) {
    echo "Table $table created successfully";
  } else {
    echo "Error creating table: " . $conn->error;
  }
  $conn->close();
?>

<?php  include 'site_footer.php'; ?>
</body>
</html>
