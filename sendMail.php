<html>

<head>

<title>PHP mail() test</title>
<!--
See: https://p10.secure.webhosting.luminate.com/phpmailsetup?ssc=us1
-->
</head>

<body>

<?php
$email = "fine@finecomputing.com;efinesbu@gmail.com;gpanasenko@moseco.com";
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
    print "Your message has been forwarded to FineAssociates, LLC to see how can we help you<br>";
    print "Truly yours, FineAssociates.  <br>";
    print "<br>";
    print "$dt <br>";
  }
} else {
  include 'site_footer.php';
  die("$firstname $lastname. No information has been provided to consider yet. Please, try again! Thank you!");
}
?>
<?php  include 'site_footer.php'; ?>
</body>
</html>
