<html>

<head>

<title>New-York Off-Market Real Estate Advisors</title>
<!--
See: https://p10.secure.webhosting.luminate.com/phpmailsetup?ssc=us1
-->
</head>

<body>

<?php
$subject   = htmlentities(trim($_POST["subject"]));
$msg       = htmlentities(trim($_POST["msg"]));
$firstname = htmlentities(trim($_POST["firstname"]));
$lastname  = htmlentities(trim($_POST["lastname"]));
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
    "Role"     => "customer",
    "home"     => "Poquotte"
  );
  error_log("test $user_attr<br>");
  $location =  $_SERVER['REMOTE_ADDR'];
  $user_message = array (
    "message" => $msg,
    "subject" => $subject,
    "host"    => $_SERVER['REMOTE_ADDR']
  );
  $user_id = initial_client_inquiry($user_attr, $user_message);
  if ($firstname != 'test') {
    $emails = get_list_of_admin_email_addr();
    foreach($emails as  $id => $adviser) {
      $adviserFirstName = $adviser['first_name'];
      $adviserLastName = $adviser['last_name'];
      $email = $adviser['email'];
      $adviserId = $adviser['UUID'];
      $locationRequest = location_lookup($location);
      $mailBody = "Dear $adviserFirstName $adviserLastName! <br> We have gotten a message: '$msg' from customer: $firstname $lastname. The message was sent from $locationRequest location. The customer was registered as #$user_id. Please attend $homeAddress/contact_admin.php?user_id=$user_id&adviser_id=$adviserId to review this request";
      mail($email, "Test message from $location: " . $subject, $mailBody);
    }
  }

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
    print "Your message has been registered as <a href='contact.php?user_id=$user_id'>#$user_id</a> and forwarded to FineAssociates, LLC to see how can we help you";
    print "<p>You may check your request status here: <a href='contact.php?user_id=$user_id'>contact.php?user_id=$user_id'</a>. <p> Please, bookmark, and use it to track our progress.";
    print "<hr>Truly yours, FineAssociates.  <br>";
  }
} else {
  include 'site_footer.php';
  die("Dear $firstname $lastname! You have provided no information for us to consider yet. <a href='contact.php'>Please, try again!</a> Thank you!");
}
?>
<?php  include 'site_footer.php'; ?>
</body>
</html>
