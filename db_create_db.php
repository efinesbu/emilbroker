<!DOCTYPE html>

<head id="ctl00_head1">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>PHP MySQL create db test</title>
</head>

<body>
<?php
  echo "--- Starting  . . .  testing <br>";
  // require "lib.php";
  require "libview.php";
  //$s =  template("$who came from $where", ['who'=>"Vinni", 'where' => 'New-York']);
  //echo $s;
  //create_admin_mail_table();
  recreate_all_db_tables();
  exit();
  /*
  $test_attr = array (
    "FirstName" => "Artiom",
    "LastName" => "Fine",
    "home" => "Poquotte"
  );
  echo "test $test_attr";
  $test_message = array (
    "message" => "Free launch wanted",
    "subject" => "Looking for free lunch here",
    "host" =>  '192.168.1.1',
  );
  $last_id = initial_client_inquiry($test_attr, $test_message);
  echo "last_id $last_id<br>";
  $rows = select_user(14);
  foreach($rows as $row){
        echo "row -> $row<br>";
    foreach($row as $k => $v){
      echo "$k => $v<br>";
    }
  }

  $rows = select_user_attr(14);
  foreach($rows as $row){
        echo "row -> $row<br>";
    foreach($row as $k => $v){
      echo "$k => $v<br>";
    }
  }
*/
?>
<?php  include 'site_footer.php'; ?>
</body>
</html>
