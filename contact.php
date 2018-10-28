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
	<h2>Contact Private NYC Off-Market Real Estate (OMRE) Advisors</h2>
	<span>
		<a class="conf" href="privacypolicy.html" title="See our privacy policy">Confidentiality</a> |
		<a href="fee.php" title="Low fee guarantee">Lower Fees</a>|
		<a href="selection.php" title="See our selection">Catered Selection</a> |
		<a href="experience.php" title="our adviser are &gt;20years here">20+ Years Experience</a> |
		<a href="inter.php" title="Oversea clients are welcome">International</a>
		</span>
	</div>
</div>
<div class="main">
<p>
Our Realtors team has been successfully advising both domestic and
international clients on Residential and Commercial Real Estate
transactions.
</p><p>
We have access to some of the Best off market properties available in the New York Metro Area.
</p>
<p>
We would love to work with you and help you with your next property acquisition or disposition.
We will be honored to work hard representing your best interests.
</p>
</div>

<div class="container">
  <?php
   if (count($_POST) != 0) {
     require 'sendMail.php';
   }
   print "<hr><p></p>" ;
  ?>
  <form action="contact.php", method="post">

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
    <textarea id="subject" name="subject" placeholder="What are looking for?" style="height:40px"></textarea>

    <label for="Message">Message</label>
    <textarea id="msg" name="msg" placeholder="How can we help you today?" style="height:100px"></textarea>

    <input value="Submit" type="submit">

  </form>
</div>

<ul class="bottomnav">
	<li><a class="active" href="http://consulting.finecomputing.com">Home</a>
	</li><li><a href="about.php">About</a>
</li></ul>
<?php
  include 'site_footer.php';
?>
</html>
