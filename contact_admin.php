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
<?php  require 'site_meta.php'; ?>
<title>New-York Off-Market Real Estate Advisors</title>
</head>
<body class="home"><?php  require 'google_tag.php'; ?>

<div class="topnav">
	<a class="active" href="http://realestate.finecomputing.com">Home</a>
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
        if (array_key_exists('adviser_id', $_GET)) {
          $adviser_id = htmlentities($_GET['adviser_id']);
        } else {
          $adviser_id = 0;
        }
        $adminRows = select_admin_attr($adviser_id);
        $customerRows = get_user_attributes($user_id);
        extract($customerRows);
        $mainRows = get_user_seq($user_id, $FirstName, $LastName);
        if (!empty($mainRows)) {
          $customer = $mainRows[0];
          $adviser = $adminRows;
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
            $last_id = follow_up_adviser_comment($user_id, $adviser_id, $comment);
            echo "Adviser $adviser_id review for customer $user_id has been recorded as $last_id<br>";
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
	<li><a class="active" href="http://realestate.finecomputing.com">Home</a>
  </li><li><a href="contact.php">Contact Us</a>
  </li><li><a href="about.php">About</a>
</li></ul>
<?php
  include 'site_footer.php';
?>
</html>
