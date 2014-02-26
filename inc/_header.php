<?php include '_functions.php'; ?>
<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php if(!empty($pageTitle)) echo $pageTitle." - " ?>Compressed Gas Systems</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Specializing in Corporate and General Aviation parts and repair">
  <meta name="author" content="hello@alyda.me">

	<base href="/">

	<link href="_/css/screen.css" rel="stylesheet" media="all">

	<script src="js/modernizr.min.js"></script>
</head>
<body id="<?= !empty($pageTitle)?clean_url($pageTitle):'' ?>">
<div class="container">
	<header class="row">

		<div class="col-xs-4">
			<h1 hidden>Compressed Gas Systems</h1>
			<a class="logo" href=""><img src="images/logo.svg" alt="Compressed Gas Systems" title="Return to homepage"></a>
		</div>
		<div class="col-xs-8">
			<address class="shadow">
				<span class="phone">(855) 875-2226</span> <span>|</span>
			  <span class="address">13829 Artesia Blvd.
			  											Cerritos, CA 90703</span>
			</address>
			<nav class="navbar">
				<h1 hidden>Main Navigation</h1>
				<ul id="main-nav" class="nav navbar-nav">
	        <li class="<?= ($_SERVER['REQUEST_URI']=="/" || $_SERVER['REQUEST_URI']=="/index.php")?' active':'';?>"><a href="">Home</a></li>
	        <li<?= ($_SERVER['REQUEST_URI']=="/services.php")?' class="active"':'';?>><a href="/services.php">Our Services</a></li>
	        <li<?= ($_SERVER['REQUEST_URI']=="/quotes.php")?' class="active"':'';?>><a href="/quotes.php">Request a Quote</a></li>
	        <!-- this link should go to /blog/category/"specials" but the link from that page is not working  -->
	        <li><a href="/blog/2-5-amerex">Specials</a></li>
	        <li><a href="/blog">Blog</a></li>
	      </ul>
			</nav>
			<div class="navbar visible-lg">
			  <ul id="secondary-nav" class="nav navbar-nav">
			    <li<?= ($_SERVER['REQUEST_URI']=="/certificates.php")?' class="active"':'';?>><a href="/certificates.php">Certificates</a></li>
					<li<?= ($_SERVER['REQUEST_URI']=="/capabilities.php")?' class="active"':'';?>><a href="/capabilities.php">Capabilities</a></li>
					<li<?= ($_SERVER['REQUEST_URI']=="/about-us.php")?' class="active"':'';?>><a href="/about-us.php">About Us</a></li>
					<li<?= ($_SERVER['REQUEST_URI']=="/contact-us.php")?' class="active"':'';?>><a href="/contact-us.php">Contact Us</a></li>
					<li><a href="https://ipn.intuit.com/payNow/start?eId=ea1b387017b052bd&uuId=a4ed49bc-0cf1-40ef-be6b-35c00f2be224" target="_blank" title="Payment will be made via Intuit Payment Network, a trusted 3rd party company. You do not need an account with intuit and CGS will not have access nor record the information you provide here. We honor your privacy!">Online Bill Payment</a></li>
			  </ul>
			</div><!--/.navbar-->

		</div>

	</header>

	<article class="jumbotron" id="we-have-moved" hidden>
    <h1>We have moved!</h1>
    <p class="pull-left">As of August 5th, 2013<br/> <strong>Compressed Gas Systems, LLC.</strong><br/> will be operating at:</p>
    <p><a class="btn btn-warning btn-large pull-right">13829 Artesia Blvd.<br/>Cerritos CA 90703</a></p>
    <p class="h5" style="clear:both;">Please mail all future payments, correspondence and shipments to the address above, thank you.</p>
  </article>