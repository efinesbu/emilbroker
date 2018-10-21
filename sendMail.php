<html>

<head>

<title>PHP mail() test</title>
<!--
See: https://p10.secure.webhosting.luminate.com/phpmailsetup?ssc=us1
-->
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-53560525-3"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-53560525-3');
</script>
<link type="text/css" rel="stylesheet" href="broker.css" />
</head>
<body>

  <div class="container">
    <form action="sendMail.php", method="POST">

      <label for="fname">First Name</label>
      <input id="fname" name="firstname" placeholder="Your name.." type="text">

      <label for="lname">Last Name</label>
      <input id="lname" name="lastname" placeholder="Your last name.." type="text">

      <label for="country">Country</label>
      <select id="country" name="country">
        <option value="australia" selected="selected">Australia</option>
        <option value="canada">Canada</option>
        <option value="usa">USA</option>
      </select>

      <label for="subject">Subject</label>
      <textarea id="subject" name="subject" placeholder="What do you need?" style="height:200px"></textarea>

      <label for="msg">Message</label>
      <textarea id="msg" name="$msg" placeholder=How can we help you today? ..." style="height:200px"></textarea>

      <input value="Submit" type="submit">

    </form>
  </div>

<?php
$email = "fine@finecomputing.com;efinesbu@gmail.com";
$subject = $_POST["$subject"];
$msg =  $_POST["msg"];

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
print "msg"
";
} else {
print "Mail sent to $email";
print "$msg"
}
?>

</body>

</html>
