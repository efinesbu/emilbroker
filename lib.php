<?php
//____________________________________________
function consulting_server()
{
  echo "<ul>";
  foreach ($_SERVER as $key => $value) {
    // code...
    echo "<li>". $key . " => " .  $value . "<br>";
  }
  echo "</ul>";
}

//____________________________________________
function create_db()
{
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
}

//____________________________________________
function connect_db()
{
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
  return $conn;
}

//____________________________________________
function create_table($table='')
{
  if ($table == '') {
    $table = 'communications';
  }
  $conn =  connect_db();
  $query = "CREATE TABLE $table (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        customer_id INT(6) KEY,
        firstname VARCHAR(30) NOT NULL,
        lastname VARCHAR(30) NOT NULL,
        email VARCHAR(50),
        phone VARCHAR(50),
        status VARCHAR(50)  NOT NULL,
        message VARCHAR(50),
        reg_date TIMESTAMP
        )";


  if ($conn->query($sql) === TRUE) {
    echo "Table $table created successfully";
  } else {
    echo "Error creating table: " . $conn->error;
  }
  $conn->close();
}
?>
