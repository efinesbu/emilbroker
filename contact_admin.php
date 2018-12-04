<!DOCTYPE html>
<!-- saved from url=(0032)https://finecomputing.com/broker -->
<html><head id="ctl00_head1"><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php require 'google_analytic.php';
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
	<h2>Custiomer's Order Review Request.</h2>
  <?php require 'site_top_menu.php'; ?>
</div>

<div class="container">
  <?php require "libview.php";
    if (count($_GET) > 1 ) {
        if (!array_key_exists('user_id', $_GET)) {
          die("wrong HTML request");
        }
        $user_id = htmlentities($_GET['user_id']);
        if (array_key_exists('reviewer_id', $_GET)) {
          $reviewer_id = htmlentities($_GET['reviewer_id']);
        } else {
          $reviewer_id = 0;
        }
        $adminRows = select_admin_attr($reviewer_id);
        extract($adminRows);
        $customerRows = get_user_attributes($user_id);
        extract($customerRows);
        $mainRows = get_user_seq($user_id, $FirstName, $LastName);
        if (!empty($mainRows)) {
          $customer = $mainRows[0];
          $adviser = $adminRows[0];
          $msg = user_request_to_review($user_id, $FirstName, $LastName, $customer, $adviser);
          print "$msg<hr>";

          $msg = "<div class='container'>";
          $msg .= adviser_comment($user_id, $customer, $adviser) . "</div>";
          print "$msg";

      } else {
        die("no user record has been found");
      }
    } else {
      if (!empty($_POST)) {
        if (array_key_exists('comment', $_POST)) {
          $junk = NULL;
          if (array_key_exists('junk', $_POST)) {
            $junk = htmlentities($_POST['junk']);
          }
          $user_id = htmlentities($_POST['user_id']);
          $adviser_id = htmlentities($_POST['adviser_id']);
          $event_type = htmlentities($_POST['event_type']);
          $comment = htmlentities($_POST['comment']);
          $customerRows = get_user_attributes($user_id);
          if ($customerRows != NULL and $junk != 'junk') {
            $user_id = follow_up_adviser_comment($user_id, $adviser_id, $comment);
            echo "Adviser $adviser_id review for customer $user_id has been recorded<br>";
          }
        } else {
          die("Wrong request!");
        }
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
