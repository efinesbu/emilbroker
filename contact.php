<!DOCTYPE html>
<!-- saved from url=(0032)https://finecomputing.com/broker -->
<html><head id="ctl00_head1"><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php ini_set('display_errors', 1);
      require 'google_analytic.php';
      require 'dialogs.php';
?>
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
<p></p>
<div class="container">
  <?php  require "libview.php";
    if (count($_GET) != 0) {
      $user_id = htmlentities($_GET['user_id']);
      $rows = get_user_attributes($user_id);
      if ($rows != NULL) {
        $msg = log_customer($user_id);
        print "$msg";
      } else {
        die("Sorry! No customer has been registered under $user_id yet.<br> Please fix your request or <a href='contact.php'> contact us</a> for assistance");
      }
    } else {
      $user_id = 0;
      $user_id_found = array_key_exists('user_id', $_POST);
      if (count($_POST) != 0)
      {
        if ($user_id_found) {

          $user_id   = htmlentities($_POST['user_id']);
          $lastname  = htmlentities($_POST['lastname']);
          $firstname = htmlentities($_POST['firstname']);

          $rows = get_user_seq($user_id, $firstname, $lastname);
          if ($rows != NULL) {
            show_user_seq($user_id, $firstname, $lastname, $rows[0]);
          }
        } else {
          require "sendMail.php";
        }
      } else {
        $user_id_found = 0;
      }
      if ($user_id_found === 0)
      {
        print "<hr><h3>Contact Us: </h3><hr><p></p>";
        $msg = initial_request();
        echo "$msg";
      }
      print '</div>';
      print '<p></p>';
}
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
