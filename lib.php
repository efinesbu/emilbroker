<?php
ini_set('display_errors', 1);
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

  $conn  = new mysqli($host, $user, $pd);

 // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error . "<br>");
  }

  echo "Host $host connected successfully<hr>";

  $query = "CREATE DATABASE $database";
  if ($conn->query($query) === TRUE) {
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

  $conn  = new mysqli($host, $user, $pd, $database);
 // Check connection

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error . "<br>");
  } else {
    error_log( "$database has been connected");
  }
  return $conn;
}
//____________________________________________
function recreate_all_db_tables(){
  create_admin_mail_table();
  create_user_table();
  create_attribute_table();
  create_evttype_table();
}
//____________________________________________
function calculate_seq_per_user($user_id, $event_type){
  $table = "main";
  $conn = connect_db();
  $conn->begin_transaction();
  $sql = "SELECT MAX(event_seq) as seq from $table
                WHERE user_id=$user_id";
                //WHERE user_id=$user_id AND event_type=$event_type";
  error_log("calculate_seq_per_use: $sql <br>");
  $result = $conn->query($sql);
  $row = $result->fetch_array();
  $event_seq  = 1;
  if ($row) {
    $event_seq = $row[0];
    error_log("--> row = $row[1] event_seq= $event_seq<br>");
  }
  $result->free();
  $conn->close();
  return $event_seq;
}
//____________________________________________
function select_user($user_id, $event_seq=0){
  //:param $event_seqL =0 : show all reacords available
  //                   =-1: show th last records available
  //                   > 0: the event_seq record
  $table = "main";
  $conn  = connect_db();
  if ($event_seq === 0) {
    $sql = "SELECT * from $table WHERE user_id = $user_id";
  } elseif ($event_seq === -1) {
    $sql = "SELECT * from $table WHERE user_id = $user_id AND event_seq = (SELECT MAX(event_seq) FROM $table WHERE user_id = $user_id)" ;
  } else {
    $sql = "SELECT * from $table WHERE user_id = $user_id AND event_seq=$event_seq";
  }
  $result = $conn->query($sql);

  while($row = $result->fetch_array())
  {
    $rows[] = $row;
  }
  $result->free();
  $conn->close();
  return $rows;
}
//____________________________________________
function select_user_event($event_id){
  $table = "main";
  $conn  = connect_db();
  $sql = "SELECT * from $table WHERE event_id = $event_id";
  $result = $conn->query($sql);

  while($row = $result->fetch_array())
  {
    $rows[] = $row;
  }
  $result->free();
  $conn->close();
  return $rows;
}
//____________________________________________
function select_user_attr($user_id){
  $table = "attr";
  $conn  = connect_db();
  $sql = "SELECT * from $table WHERE user_id = $user_id";
  error_log("select_user_attr: sql $table:  $sql");
  $rows = array();
  $result = $conn->query($sql);
  if ($result)
    while($row = $result->fetch_array())
    {
      $rows[] = $row;
    }
    $result->free();
    $conn->close();
  return $rows;
}
//____________________________________________
function select_admin_attr($adviser_id){
  $table = "admin_mail";

  $conn  = connect_db();
  $sql = "SELECT * from $table WHERE uuid = $adviser_id";
  error_log("select_admin_attr: sql $table:  $sql");
  $result = $conn->query($sql);
  $rows = array();
  while($row = $result->fetch_array())
  {
    $rows[] = $row;
  }
  $result->free();
  $conn->close();
  $log = print_r($rows, $return=true);
  error_log("select_admin_attr: $log");
  if (!empty($rows)) {
    $rows = $rows[0];
  }
  return $rows;
}
//____________________________________________
function populating_user_table($user)
{
  error_log("user_id  $user<br>");
  $table = "main";
  $conn =  connect_db();
  $last_id = 0;

  $event_type = $user['event_type'];
  $user_id    = $user['user_id'];
  $event_seq  = $user['event_seq'];
  $message    = $conn->escape_string($user['message']);
  $subject    = $conn->escape_string($user['subject']);
  $host       = $user['host'];

  $ref = 'NULL';
  if (array_key_exists('ref', $user)) {
      $ref  = $user['ref'];
  }
  $adviser_id  = 'NULL';
  if (array_key_exists('adviser_id', $user)) {
      $adviser_id  = $user['adviser_id'];
  }
  // Adding the new collator_get_attribute
  $sql =  "INSERT INTO $table (event_type, user_id, event_seq, subject, message, host, ref, adviser_id)
           VALUES ($event_type,  $user_id,  $event_seq,
                   '$subject', '$message', '$host', $ref, $adviser_id)";
  error_log("$sql<br>");
  $result = $conn->query($sql);
  if ($result) {
    $last_id = $conn->insert_id;
    error_log("Table $table created successfully $last_id<br>");
  } else {
    error_log("Error creating table: " . $conn->error . "<br>");
  }
  error_log("Finished! $last_id<br>");
  $conn->close();
  return $last_id;
}
//____________________________________________
function create_user_table()
{
  $table = "main";
  $schema = "event_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            reg_date TIMESTAMP,  -- message date/time
            event_type INT(6)  UNSIGNED NOT NULL, -- event type from
            user_id INT(6) UNSIGNED NOT NULL, -- user id
            adviser_id INT(6) UNSIGNED, -- adviser id NULL means self
            event_seq  INT(6)  UNSIGNED NOT NULL, -- seq for user id
            subject VARCHAR(4000) NOT NULL, -- user's message
            message VARCHAR(4000) NOT NULL, -- user's message
            host VARCHAR(100) NOT NULL, -- IP address where request came from
            ref INT(6) UNSIGNED,  --  to the related event_seq

            FOREIGN KEY (ref) REFERENCES $table(event_id)
            ON UPDATE CASCADE
            ON DELETE RESTRICT
          ";
  echo "schema $schema of $table<br>";
  create_table($table, $schema);
}
//____________________________________________
function create_attribute_table()
{
  $schema = "UUID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            reg_date TIMESTAMP,  -- message date/time
            user_id INT(6) UNSIGNED, -- user id
            attribute_name VARCHAR(40),
            attribute_value VARCHAR(40)
          ";
  echo "schema $schema <br>";
  create_table("attr", $schema);
}
//____________________________________________
function create_admin_mail_table()
{
  $table = "admin_mail";
  $schema = "UUID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            reg_date TIMESTAMP,  -- message date/time
            email VARCHAR(40),
            first_name VARCHAR(40),
            last_name VARCHAR(40)
          ";
  echo "schema $schema <br>";
  create_table($table, $schema);
  populate_admin_table($table);

}
//____________________________________________
function populate_admin_table($table)
{
  echo "Starting repopulating  $table. . . ";
  $conn =  connect_db();

  // Remove all old data first
  $sql = "DELETE FROM $table";
  if ($conn->query($sql) === TRUE) {
      echo "All record of $table table have been removed successfully<br>";
  } else {
      echo "Error: " . $sql . "<br>" . $conn->erro . "<br>";
  }
  // Repopulate the table
  $eventTypes = array("fine@finecomputing.com" => ['first_name' => "Valeri", 'last_name' => 'Fine'],
                      "efinesbu@gmail.com" => ['first_name' => "Emil", 'last_name' => 'Fine'],
                      "genepanasenko@gmail.com"  => ['first_name' => "Gene", 'last_name' => 'Panaseko']
                    );

  foreach ($eventTypes as $mail => $person)
  {
    if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
      echo "Email address '$mail' is considered valid.\n";
      $first_name = $person['first_name'];
      $last_name = $person['last_name'];
      $sql = "INSERT INTO $table (email, first_name, last_name)
              VALUES ('$mail', '$first_name', '$last_name')";
      echo "$sql";
      if ($conn->query($sql) === TRUE) {
          echo "New record created successfully: $id, $mail added to $table<br>";
      } else {
          echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
      }
    } else {
      die("email address $mail is wrong");
    }
  }
  $conn->close();
}

//____________________________________________
function get_list_of_admin_email_addr($table="admin_mail")
{
  $conn  = connect_db();
  $sql = "SELECT * from $table WHERE 1";
  $result = $conn->query($sql);
  while($row = $result->fetch_array())
  {
    $rows[] = $row;
  }
  $result->free();
  $conn->close();

  //$mail_list = implode(",", $rows);
  $m = print_r($rows, $return=true);
  error_log("mail_list $m");
  return $rows;
}

//____________________________________________
function create_evttype_table()
{
  $schema = "event_type INT(6) UNSIGNED PRIMARY KEY,
            event_desc VARCHAR(40)
          ";
  echo "schema $schema <br>";
  create_table("evttype", $schema);
  populate_evttype_table();
}
//____________________________________________
function populate_evttype_table()
{
  echo "Starting repopulating . . . ";
  $table = "evttype";
  $conn =  connect_db();

  // Remove all old data first
  $sql = "DELETE FROM $table";
  if ($conn->query($sql) === TRUE) {
      echo "All record have been removed successfully<br>";
  } else {
      echo "Error: " . $sql . "<br>" . $conn->erro . "<br>";
  }
  // Repopulate the table
  $eventTypes = array("Client Inquiry",
                      "Advisor Reply",
                      "Notification to Advisor Sent",
                      "Default Reply"
                   );

  foreach ($eventTypes as $id => $type)
  {
    $sql = "INSERT INTO $table (event_type, event_desc)
            VALUES ($id+1, '$type')";
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully: $id, $type  added to $table<br>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
    }
  }
  $conn->close();
}

//______________________________________________________________
function save_user_comment($user_id, $firstname, $lastname, $user, $post){
  $m = print_r($user, $return=true);
  error_log('save_user_comment: '. $m . "</br>");
  extract($user);
  $next_event_seq = calculate_seq_per_user($user_id, $event_type);

  $user = array('event_type' => $event_type,
               'user_id'     => $user_id,
               'event_seq'   => $next_event_seq + 1,
               'message'     => htmlentities($post['msg']),
               'subject'     => htmlentities($post['subject']),
               'host'        => $host,
               'ref'         => $ref
             );
  error_log("2. populating main table with $user: " . $user['user_id'] . ' '. $user['event_seq'] . "<br>");
  $last_id = populating_user_table($user);
  return $user_id;

}
//_________________________________________________
function adding_new_user($attribute, $value, $user_id)
{
  $table = "attr";
  error_log("$table $user_id $attribute <br>");
  $conn = connect_db();
  if ($user_id===0) {
    $conn->begin_transaction();
    $sql = "SELECT MAX(user_id) as user from $table";
    error_log("$sql <br>");
    $result = $conn->query($sql);
    $row = $result->fetch_row();
    if ($row) {
      error_log("--> $row[1] <br>");
      $user_id = $row[0] + 1;
    }
    $result->free();
  }
  error_log("user_id  $user_id<br>");
  // Adding the new collator_get_attribute
  $sql =  "INSERT INTO $table (user_id, attribute_name, attribute_value)
           VALUES ($user_id, '$attribute', '$value')";
  error_log("$sql<br>");
  $result = $conn->query($sql);
  if ($result) {
    error_log("Table $table created successfully");
  } else {
    error_log("Error creating table: " . $conn->error . "<br>");
  }
  error_log("Finished!<br>");
  $conn->commit();
  $conn->close();
  return $user_id;
}
//____________________________________________
function initial_client_inquiry($user_attr, $client_message){
  // 1. populating attr table
  error_log("1. populating attr table<br>");

  $this_event_type = 1;
  $attrCounter = 0;
  $next_user_id = 0;
  foreach($user_attr as $attr_name => $attr_value){
    error_log("initial_client_inquiry $attr_name  $attr_value <br>");
    if ($attrCounter === 0) {
       $next_user_id =  adding_new_user($attr_name, $attr_value, 0);
    } else {
      adding_new_user($attr_name, $attr_value, $next_user_id);
    }
    $attrCounter = $attrCounter + 1;
  }
  // 2. populating main table
  $next_event_seq = calculate_seq_per_user($next_user_id, $this_event_type);

  $user = array('event_type' => $this_event_type,
               'user_id'     => $next_user_id,
               'event_seq'   => $next_event_seq + 1,
               'message'     => $client_message['message'],
               'subject'     => $client_message['subject'],
               'host'        => $client_message['host']
             );
  error_log("2. populating main table with $user: " . $user['user_id'] . ' '. $user['event_seq'] . "<br>");
  $last_id = populating_user_table($user);
  return $user['user_id'];
}
//_______________________________________________________________
function calculate_ref_event_id($user_id, $event_seq)
{
    $conn = connect_db();
    $table = "main";
    $conn = connect_db();
    $conn->begin_transaction();
    $sql = "SELECT event_id as id from $table
                  WHERE user_id=$user_id and event_seq=$event_seq";
    error_log("calculate_seq_per_use: $sql <br>");
    $result = $conn->query($sql);
    $row = $result->fetch_array();
    $event_id  = 0;
    if ($row) {
      $event_id = $row[0];
      error_log("--> row = $row[1] event_id= $event_id<br>");
    }
    $result->free();
    $conn->close();
    return $event_id;
}
//_______________________________________________________________
function follow_up_adviser_comment($user_id, $adviser_id, $comment)
{
  $next_event_seq = calculate_seq_per_user($user_id, NULL);
  $event_id = calculate_ref_event_id($user_id, $next_event_seq);
  $this_event_type = 2;
  $host =  $_SERVER['REMOTE_ADDR'];
  $user = array('event_type' => $this_event_type,
               'user_id'     => $user_id,
               'event_seq'   => $next_event_seq +1 ,
               'message'     => $comment,
               'subject'     => "adviser review",
               'host'        => $host,
               'adviser_id'  => $adviser_id,
               'ref'         => $event_id
             );
  $last_id = populating_user_table($user);
  return $last_id;
}
//_______________________________________________________________
function create_table($table='', $schema='')
{
  if ($table == '') {
    $table = 'communications';
  }
  $conn =  connect_db();
  $conn->begin_transaction();
  $query = "DROP TABLE IF EXISTS $table";
  if ($conn->query($query) === TRUE) {
    echo "Table $table has been dropped<br>";
  } else {
    echo "Error dropping table: " . $conn->error . "<br>";
  }

  $query = "CREATE TABLE $table (". $schema  ." )";

  if ($conn->query($query) === TRUE) {
    echo "Table $table created successfully <br>";
  } else {
    error_log("Error creating [$table] table: " . $conn->error . "<br>");
  }
  $conn->commit();
  $conn->close();
}

//_______________________________________________________________
function sendMail($user){
  $subject   = htmlentities($user["subject"]);
  $msg       = htmlentities($user["msg"]);
  $firstname = htmlentities($user["firstname"]);
  $lastname  = htmlentities($user["lastname"]);
  if ($lastname == ''  and $firstname == '') {
    $firstname = "Customer";
  }
  $adviser_id = 1;
  if (array_key_exists('adviser_id', $user)) {
    $adviser_id = htmlentities($user['adviser_id']);
  }
  $adviser = select_admin_attr($adviser_id);

  if ($subject != '' and $msg!='') {
    $eLog="/logs/emailError.log";

    //Get the size of the error log
    //ensure it exists, create it if it doesn't
    $fh= fopen($eLog, "a+");
    fclose($fh);
    $originalsize = filesize($eLog);
    $location =  $_SERVER['REMOTE_ADDR'];
    if ($firstname != 'test') {
      $emails = get_list_of_admin_email_addr();
      foreach($emails as  $id => $adviser) {
        $adviserFirstName = $adviser['first_name'];
        $adviserLastName = $adviser['last_name'];
        $email = $adviser['email'];
        $adviserId = $adviser['UUID'];
        $mailBody = "Dear $adviserFirstName $adviserLastName! <br> We have gotten a message: '$msg' from customer: $firstname $lastname. The customer was registered as #$user_id http://ip-api.com/#$location $location location</a>. Please attend https://www.finecomputing.com/consulting/contact_admin.php?user_id=$user_id&adviser_id=$adviserId to review this request";
        mail($email, "Test message from $location:" . $subject, $mailBody);
      }
    }

    //
    // NOTE: PHP caches file status so we need to clear
    // that cache so we can get the current file size
    //

    clearstatcache();
    $finalsize = filesize($eLog);

    //Check if the error log was just updated
    if ($originalsize != $finalsize) {
      print "Problem sending mail. (size was $originalsize, now $finalsize) See $eLog";
      print "$msg";
    } else {
      $dt = date(DATE_RFC2822);
      print "Dear $firstname $lastname! <br>";
      print "On $dt we received your new $subject.  <br>";
      print "Your comment has been forwarded to our adviser to address. <br>";
      print "<p>You may check your request status here: <a href='contact.php?user_id='$user_id'>contact.php?user_id=$user_id</a>. <p> Please, bookmark, and use it to track our progress.";
      print "<hr>Truly yours, FineAssociates.  <br>";
    }
  }
}

?>
