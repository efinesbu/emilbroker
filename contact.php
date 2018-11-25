<!DOCTYPE html>
<!-- saved from url=(0032)https://finecomputing.com/broker -->
<html><head id="ctl00_head1"><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php  require 'google_analytic.php'; ?>
<link type="text/css" rel="stylesheet" href="broker.css" />

<!--
script type="text/javascript" src="Rutenberg%20%C2%B7%20The%20Smart%20Brokers_files/300lo.json"></script>
<script type="text/javascript" src="Rutenberg%20%C2%B7%20The%20Smart%20Brokers_files/_ate.config_resp"></script>

-->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="description"><meta name="author">
<meta name="keywords" content="real,estate,new-york,usa,united,states,america,manhattan,brooklyn,long island,Queens">
<meta name="keywords" content="home,apartment,co-op,condo,listing,new,new listing,new development,development,">
<meta name="keywords" content="property, market,upper,east,west,south,east,Upper East Side,Upper West side,Tribeca, FIDI,">
<meta name="keywords" content="Midtown, Midtown Manhattan, Chelsea,Hudson Yards,Hudson,Yards,Central, park,lower">
<meta name="keywords" content="Central, park,NOLO, development,for sale, residential, properties, investment, sale, buy, foreclosures,public">
<title>
  Private NYC OMRE Advisors
</title>
</head>
<body class="home">

<div class="topnav">
	<a class="active" href="http://consulting.finecomputing.com">Home</a>
	<a href="contact.php"></a>
	<a href="about.php"></a>
</div>

<div class="center">
	<h2>Contact Private NYC <a title="Off-Market Properties Aren't Listed" href="aboutoffmarket.php">Off-Market</a>
    Real Estate (OMRE) Advisors</h2>
  <?php require 'site_top_menu.php'; ?>
</div>
<?php require 'our_team.php'; ?>
</div>
<p></p>
<div class="container">
  <?php
    if (count($_GET) != 0) {
      $user_id = $_GET['user_id'];
      print "<p><span class='error'>* required field</span></p>";
      print "<form action='contact.php', method='post'>";

      print "<label for='user_id'>Registration Number</label><span class='error'>*";
      print "<input id='user_id' name='user_id' readonly value='$user_id' type='text'>";

      print "<label for='fname'>First Name</label><span class='error'>*";
      print "<input id='fname' name='firstname' placeholder='Your name from your previous $user_id-th request...' type='text' required>";

      print "<label for='lname'>Last Name</label><span class='error'>*";
      print "<input id='lname' name='lastname' placeholder='Your last name from your previous $user_id-th request...' type='text' required>";

      print "<input value='Submit' type='submit'>";
    } else {
      if (count($_POST) != 0) {
        echo count($_POST);
        if (array_key_exists('user_id', $_POST)) {
          require "libview.php";
          $user_id = $_POST['user_id'];
          $lastname = $_POST['lastname'];
          $firstname = $_POST['firstname'];
          echo "libview.php<hr>";
          show_last_seq($user_id, $firstname, $lastname);
        } else {
          require "sendMail.php";
        }
      }
      if (!array_key_exists('user_id', $_POST))  {
        print "<hr><h3>Contact Us: </h3><hr><p></p>" ;

        print '
        <p><span class="error">* required field</span></p>
        <form action="contact.php", method="post">

          <label for="fname">First Name</label>
          <input id="fname" name="firstname" placeholder="Your name.." type="text">

          <label for="lname">Last Name</label>
          <input id="lname" name="lastname" placeholder="Your last name.." type="text">

          <!-- <label for="ticket #">Account #, if available</label><span class="error">*
           <textarea id="ticket" name="ticket" placeholder="Enter ticket # to review reply" style="height:40px"></textarea>
          -->
          <label for="subject">Subject</label><span class="error">*
          <textarea id="subject" name="subject" placeholder="What are looking for?" required style="height:40px"></textarea>

          <label for="Message">Message</label><span class="error">*
          <textarea id="msg" name="msg" placeholder="How can we help you today?" required style="height:100px"></textarea>

          <input value="Submit" type="submit">

        </form>
      </div>
      <p></p>';
}}
?>
<ul class="bottomnav">
	<li><a class="active" href="http://consulting.finecomputing.com">Home</a>
  </li><li><a href="contact.php">Contact Us</a>
  </li><li><a href="about.php">About</a>
</li></ul>
<?php
  include 'site_footer.php';
?>
</html>
