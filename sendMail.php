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
$subject = "Test Message";
$msg = "This is a test message";

$eLog="/tmp/emailError.log";

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
print "Problem sending mail. (size was $originalsize, now $finalsize) See $eLog
";
} else {
print "Mail sent to $email";
}
?>

</body>

</html>
