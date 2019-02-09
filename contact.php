<!DOCTYPE html>
<!-- saved from url=(0032)https://finecomputing.com/broker -->
<html>
  <head id="ctl00_head1">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <?php ini_set('display_errors', 1);
        require 'google_analytic.php';
        require 'dialogs.php';
  ?>
  <link type="text/css" rel="stylesheet" href="broker.css" />

  <!--
  script type="text/javascript" src="Rutenberg%20%C2%B7%20The%20Smart%20Brokers_files/300lo.json"></script>
  <script type="text/javascript" src="Rutenberg%20%C2%B7%20The%20Smart%20Brokers_files/_ate.config_resp"></script>

  -->
  <?php  require 'site_meta.php'; ?>
  <title>Contact New-York Off-Market Real Estate Advisors</title>
</head>
<body class="home"><?php  require 'google_tag.php'; ?>

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
        echo "<h2>Please, fill the form below to check your request status<h3>";
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
          $m = print_r($_POST, $return=true);
          error_log("POST = ". $m . "</br>");
          $requestEventType = NULL;
          if (array_key_exists('event_type', $_POST)) {
            $requestEventType = htmlentities($_POST['event_type']);
          }
          $rows = get_user_seq($user_id, $firstname, $lastname);
          if ($rows != NULL) {
            $rows = $rows[0];
            $event_type = $rows['event_type'];
            error_log("event_type=$event_type : [$requestEventType]</br>");
            if ($requestEventType == 3 ) {
              $rows['event_type'] = $requestEventType;
              save_user_comment($user_id, $firstname, $lastname, $rows, $_POST);
              sendMail($_POST);
            } else {
              show_user_seq($user_id, $firstname, $lastname, $rows);
              $event_type = $rows['event_type'];
              if ($event_type == 2){
                $m  = print_r($rows, $return=true);
                error_log($m . "</br>");
                $adviser_id = $rows['adviser_id'];
                $lastname = $rows['LastName'];
                $firstname = $rows['FirstName'];
                $msg = customer_followup_request($user_id, $adviser_id, $firstname, $lastname);
                print $msg;
              }
            }
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
	<li><a class="active" href="http://realestate.finecomputing.com">Home</a>
  </li><li><a href="contact.php">Contact Us</a>
  </li><li><a href="about.php">About</a>
</li></ul>
<?php
  include 'site_footer.php';
?>
</html>
