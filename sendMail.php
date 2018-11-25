<html>

<head>

<title>PHP mail() test</title>
<!--
See: https://p10.secure.webhosting.luminate.com/phpmailsetup?ssc=us1
-->
</head>

<body>

<?php
//$email = "fine@finecomputing.com;efinesbu@gmail.com;gpanasenko@moseco.com";
require 'lib.php';
$email = "fine@finecomputing.com;efinesbu@gmail.com";
$subject = htmlentities($_POST["subject"]);
$msg = htmlentities($_POST["msg"]);
$firstname =  htmlentities($_POST["firstname"]);
$lastname = htmlentities($_POST["lastname"]);
if ($lastname == ''  and $firstname == '') {
  $firstname = "Customer";
}
if ($subject != '' and $msg!='') {
  $eLog="/logs/emailError.log";

  //Get the size of the error log
  //ensure it exists, create it if it doesn't
  $fh= fopen($eLog, "a+");
  fclose($fh);
  $originalsize = filesize($eLog);
  $user_attr = array (
    "FirstName" => $firstname,
    "LastName" => $lastname,
    "Role"     => "client",
    "home" => "Poquotte"
  );
  echo "test $user_attr<br>";
  $user_message = array (
    "message" => $msg,
    "subject" => $subject,
    "host"    => $_SERVER['REMOTE_ADDR']
  );
  echo "server name: " .$user_message["host"] . ": $msg<br>";

  $user_id = initial_client_inquiry($user_attr, $user_message);
  $msg = "$msg<br> user_id registred as $user_id";
  echo "server name" . $user_id ." " . $msg . "<br>";
  mail($email, "Test message" . $subject, $msg);

  /*
  * NOTE: PHP caches file status so we need to clear
  * that cache so we can get the current file size
  */

  clearstatcache();
  $finalsize = filesize($eLog);

  //Check if the error log was just updated
  if ($originalsize != $finalsize) {
    print "Problem sending mail. (size was $originalsize, now $finalsize) See $eLog";
    print "$msg";
  } else {
    $dt = date(DATE_RFC2822);
    print "Dear $firstname $lastname! <br>";
    print "On $dt we received your [$subject] request.  <br>";
    print "Your message has been registred as <a href='contact.php?user_id=$user_id'>#$user_id</a> and forwarded to FineAssociates, LLC to see how can we help you<br>";
    print "To check your request status here <a href='contact.php?user_id=$user_id'>contact.php?user_id=$user_id'</a>, please, bookmark, and use it to click to track our progress.";
    print "Truly yours, FineAssociates.  <br>";
    print "<br>";
    print "$dt <br>";
  }
} else {
  include 'site_footer.php';
  die("Dear $firstname $lastname! You have provided no information for us to consider yet. <a href='contact.php'>Please, try again!</a> Thank you!");
}
?>
<?php  include 'site_footer.php'; ?>
</body>
</html>
