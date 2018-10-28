<html>

<head>

<title>PHP mail() test</title>
<!--
See: https://p10.secure.webhosting.luminate.com/phpmailsetup?ssc=us1
-->
</head>

<body>

<?php
$email = "fine@finecomputing.com;efinesbu@gmail.com";
$subject = htmlentities($_POST["subject"]);
$msg = htmlentities($_POST["msg"]);
$firstname =  htmlentities($_POST["firstname"]);
$lastname = htmlentities($_POST["lastname"]);
if ($lastname == ''  and $firstname == '') {
  $firstname = "Customer";
}
$eLog="/logs/emailError.log";

//Get the size of the error log
//ensure it exists, create it if it doesn't
$fh= fopen($eLog, "a+");
fclose($fh);
$originalsize = filesize($eLog);

mail($email,$subject,$msg);

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
  // date(DATE_RFC2822);
  print "Dear $firstname $lastname! <br>";
  print "On $dt we received your [$subject] request.  <br>";
  print "You message has been forwarded to [$email] to see how can we help you<br>";
  print "Truly yours, FineAssociates.  <br>";
  print "<br>";
  print "$dt <br>";
}
?>

</body>

</html>
