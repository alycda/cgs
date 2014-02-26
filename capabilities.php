<?php
$pageTitle = 'Capabilities';
include 'inc/_header.php'; ?>
<ul class="breadcrumb">
	<li><a href="/">home</a></li>
	<li>capabilities</li>
</ul>

<style>
	#search {
		width:300px; margin-top:6px; margin-left:36px;
	}

	.btn-group {
		margin-top: 6px;
	}
	.fixed {position:fixed; top:0;
		width: 1170px;}
	.absolute {
		position: absolute;
		top: 0;
		width: 100%;
	}

	h3 {clear: left;}

	.content article h3 {
		/*border-bottom: 1px solid #ccc;*/
		/*line-height: 2em;*/

	} .content article h3 span {
		padding: 5px 10px;
		background-color: #fff;
		border-top-left-radius: 6px;
		border-top-right-radius: 6px;
		border: 1px solid #ddd;

	}

	article ul{
		clear: both;
		margin-left: 0;
		padding-left: 0;
	}
	article li {
		list-style-type: none;
		/*width:274px;*/
		/*float:left;*/
		padding: 6px 6px 6px 36px;
		/*border-radius: 6px;*/
		margin: 1px;
		font-size: 16px;

		/*border-right: 1px solid #bbb;*/
		/*border-bottom: 1px solid #bbb;*/
		/*border-top: 1px solid #eee;*/
		/*border-left: 1px solid #eee;*/

		/*border: 1px solid #e6e6e6;*/

		/*border-left: 8px solid #e6e6e6;*/
	}

	article li:hover {
		/*background-color: #eee;*/
		/*font-weight: bold;*/
		/*border-left: 8px solid;*/
	}

	dl {
		/*border-bottom: 1px solid #ccc;*/
		/*padding-bottom: 18px;*/
		position: relative;

		margin-top: 0; padding-top: 18px;
	} dl span {
		float: left;
		margin-left: 220px;
		border-left: 1px solid;
		padding-left: 16px;
		margin-right: 18px;
		/*border-radius: 6px;*/
		border-top-right-radius: 6px;
		border-bottom-right-radius: 6px;
	} dl span:hover {
		background-color: #eee;
	} dt, dd {

	} dt {
		position: absolute;
		height: 100%;
		width: 200px;
	text-transform: uppercase;
		/*border-right: 1px solid;*/
	} dd.lead {
		float: left;
		margin-bottom: 0;
		padding: 0 3px;
	} dd:hover {
		/*font-weight: bold;*/
		/*text-decoration: underline;*/
		background-color: #5bc0de;
		color: #fff;
		border-radius: 6px;
	} dd:after {
		content: ", ";
	} /*dd:last-child:before { content: "and "; }*/
	dd:last-child:after { content: "."; }




	#navbar {
		background: #00aeef;
		color: #fff;
	}

	#navbar > div > ul > li > a {
		color: #fff;
	}




</style>

<section class="content" style="position: relative;">
	<h1 hidden>Capabilities</h1>









<!-- <ul class="nav nav-tabs">
  <li class="active"><a href="#"><h3 id="fire-extinguisher" class="text-primary" style="margin: 0;">Fire Extinguisher</h3></a></li>
</ul>
<div style="background:#fff; border-left: 1px solid #dddddd; border-right: 1px solid #dddddd;border-top-right-radius: 6px;">
	<dl class="clearfix" style="margin-top: 0; padding-top: 18px;"><dt class="h4 text-muted" style="padding-left: 18px;
text-align: right;">Amerex</dt><span style="margin-right: 18px;"><dd class="lead">344</dd><dd class="lead">344T</dd><dd class="lead">345</dd><dd class="lead">352 Series</dd><dd class="lead">352T</dd><dd class="lead">354</dd><dd class="lead">355</dd><dd class="lead">355T</dd><dd class="lead">357</dd><dd class="lead">361</dd><dd class="lead">369</dd><dd class="lead">371</dd><dd class="lead">372</dd><dd class="lead">A352 Series</dd><dd class="lead">A354 Series</dd><dd class="lead">B352</dd><dd class="lead">B355</dd><dd class="lead">B355T</dd><dd class="lead">B371</dd><dd class="lead">C352</dd><dd class="lead">C352TS</dd><dd class="lead">C354</dd><dd class="lead">C354TS</dd><dd class="lead">Model 344</dd><dd class="lead">Model 352</dd><dd class="lead">Model 352T</dd><dd class="lead">Model 354</dd><dd class="lead">Model 355</dd><dd class="lead">Model 357</dd><dd class="lead">Model 358</dd><dd class="lead">Model 361</dd><dd class="lead">Model 369</dd><dd class="lead">Model 371</dd><dd class="lead">Model A352</dd></span></dl>

<div style="background: rgb(255,255,255); /* Old browsers */
background: -moz-linear-gradient(top, rgba(255,255,255,1) 0%, rgba(255,255,255,1) 40%, rgba(230,230,230,1) 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(255,255,255,1)), color-stop(40%,rgba(255,255,255,1)), color-stop(100%,rgba(230,230,230,1))); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top, rgba(255,255,255,1) 0%,rgba(255,255,255,1) 40%,rgba(230,230,230,1) 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top, rgba(255,255,255,1) 0%,rgba(255,255,255,1) 40%,rgba(230,230,230,1) 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top, rgba(255,255,255,1) 0%,rgba(255,255,255,1) 40%,rgba(230,230,230,1) 100%); /* IE10+ */
background: linear-gradient(to bottom, rgba(255,255,255,1) 0%,rgba(255,255,255,1) 40%,rgba(230,230,230,1) 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#e6e6e6',GradientType=0 ); /* IE6-9 */ height:64px;"></div>

</div> -->
















<?php

$json = file_get_contents('http://cgs/data/json.php');
// $json = file_get_contents('http://cgs.aero/data/capabilities.json');

$j = json_decode($json, true);

foreach ($j as $h2 => $nomenclature) {

	echo "<h2 hidden>".$h2."</h2>";

	foreach($nomenclature as $h3 => $manufacturers) { ?>

	<ul class="nav nav-tabs">
		<li class="active" style="padding:0"><a href="#"><h3 id="<?= clean_url($h3); ?>" class="text-primary" style="margin: 0;"><?= $h3 ?></h3></a></li>
	</ul>

	<div style="background:#fff; border-left: 1px solid #dddddd; border-right: 1px solid #dddddd;border-top-right-radius: 6px;">

<?php
		foreach ($manufacturers as $mfg => $parts) {
			echo '<dl class="clearfix">';
			echo '<dt class="h4 text-muted text-right">'.$mfg.'</dt>';
			echo '<span>';
			foreach ($parts as $key => $part) {
				echo '<dd class="lead">'.$part.'</dd>';
			}
			echo '</span>';
			echo "</dl>";
		} ?>

		<div style="background: rgb(255,255,255); /* Old browsers */
background: -moz-linear-gradient(top, rgba(255,255,255,1) 0%, rgba(255,255,255,1) 40%, rgba(230,230,230,1) 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(255,255,255,1)), color-stop(40%,rgba(255,255,255,1)), color-stop(100%,rgba(230,230,230,1))); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top, rgba(255,255,255,1) 0%,rgba(255,255,255,1) 40%,rgba(230,230,230,1) 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top, rgba(255,255,255,1) 0%,rgba(255,255,255,1) 40%,rgba(230,230,230,1) 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top, rgba(255,255,255,1) 0%,rgba(255,255,255,1) 40%,rgba(230,230,230,1) 100%); /* IE10+ */
background: linear-gradient(to bottom, rgba(255,255,255,1) 0%,rgba(255,255,255,1) 40%,rgba(230,230,230,1) 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#e6e6e6',GradientType=0 ); /* IE6-9 */ height:64px;"></div>
	</div><br/>

<?php
	}

} ?>



<!-- <div id="navbar" class="navbar absolute" role="navigation">
        <div class="navbar-header">
          <span class="h2" style="line-height:.2em;display:inline-block;float:left;padding-right:36px;">Capabilities</span>
        </div>
        <div class="bs-js-navbar-scrollspy">

          <ul class="nav navbar-nav">
            <li class="dropdown">
            <a href="#" id="fireDropDown" class="dropdown-toggle" data-toggle="dropdown">Fire <b class="caret"></b></a>
            <ul class="dropdown-menu" role="menu" aria-labelledby="fireDropDown">
              <li><a href="#fire-extinguisher" tabindex="-1">Fire Extinguishers</a></li>
              <li><a href="#fire-extinguisher-potty-bottle" tabindex="-1">Potty Bottle</a></li>
              <li><a href="#h20-fire-extinguisher" tabindex="-1">H20 Fire Extinguishers</a></li>
            </ul>
          </li>

          <li class="dropdown">
            <a href="#" id="oxygenDropDown" class="dropdown-toggle" data-toggle="dropdown">Oxygen <b class="caret"></b></a>
            <ul class="dropdown-menu" role="menu" aria-labelledby="oxygenDropDown">
              <li><a href="#four" tabindex="-1">Cylinder Assemblies</a></li>
              <li><a href="#five" tabindex="-1">Regulator</a></li>
              <li><a href="#six" tabindex="-1">Valve</a></li>
              <li class="divider"></li>
              <li><a href="#cylinder-valve-assy" tabindex="-1">Cylinder &amp; Valve Assembly</a></li>
							<li><a href="#demand-oxygen-regulator" tabindex="-1">Demand Oxygen Regulator</a></li>
              <li><a href="#eight" tabindex="-1">port oxygen assembly</a></li>
            </ul>
          </li>

          <li class="dropdown">
            <a href="#" id="pneumaticDropDown" class="dropdown-toggle" data-toggle="dropdown">Pneumatic <b class="caret"></b></a>
            <ul class="dropdown-menu" role="menu" aria-labelledby="pneumaticDropDown">
              <li><a href="#air-cylinder-assy" tabindex="-1">Air Cylinder Assembly</a></li>
              <li><a href="#air-reservoir" tabindex="-1">Air Reservoir</a></li>
              <li><a href="#emergency-power-reservoir" tabindex="-1">Emergency Power Reservoir</a></li>
            </ul>
          </li>

					<li><a href="#cylinder-only">Cylinder</a></li>
					</ul>
					<input id="search" type="text" class="form-control pull-left" placeholder="Search for part number">
			    <button id="submit" type="submit" class="btn btn-default pull-left" style=" margin-top:6px;">Search</button>

					<a href="pdf/capabilities.pdf" class="btn btn-default navbar-btn pull-right">Download PDF</a>
        </div>
      </div> -->



			</section>



<!-- add 'back to top' link -->

<script src="_/js/jquery-1.9.1.js"></script>
    <!-- Twitter Bootstrap -->
    <script src="_/vendor/twitter-bootstrap/js/bootstrap.js"></script>
<script type="text/javascript">
$('body').scrollspy({ target: '#navbar' })

	jQuery("document").ready(function($){


if (navigator.appName=="Opera") {
	document.getElementById("search").disabled = true;
	document.getElementById("submit").disabled = true;
}


    var nav = $('#navbar');

    $(window).scroll(function () {
        if ($(this).scrollTop() > 256) {
            nav.addClass("fixed");
            nav.removeClass("absolute");
        } else {
            nav.removeClass("fixed");
            nav.addClass("absolute");
        }
    });


    $( "button[type='submit']" ).click(function(){
    	//window.find($("#search").val(),false,false,true);

    	str = $("#search").val();

			if (str == "") {
			  alert ("Please enter a search term.");
			  return;
			}

    	findString( str );
     })

//search page for text
var TRange=null;

function findString (str) {

 if (parseInt(navigator.appVersion)<4) return;
 var strFound;
 if (window.find) {

  // CODE FOR BROWSERS THAT SUPPORT window.find

  strFound=self.find(str);
  if (!strFound) {
   strFound=self.find(str,0,1);
   while (self.find(str,0,1)) continue;
  }
 }
 else if (navigator.appName.indexOf("Microsoft")!=-1) {

  // EXPLORER-SPECIFIC CODE

  if (TRange!=null) {
   TRange.collapse(false);
   strFound=TRange.findText(str);
   if (strFound) TRange.select();
  }
  if (TRange==null || strFound==0) {
   TRange=self.document.body.createTextRange();
   strFound=TRange.findText(str);
   if (strFound) TRange.select();
  }
 }
 else if (navigator.appName=="Opera") {
  alert ("Sorry, Opera does not support this search feature. Please use your browser's built-in search function by pressing CTRL+F (or CMD +F on a mac).");
  return;
 }
 if (!strFound) alert ("String '"+str+"' not found!")
 return;
}


	});

</script>

<?php include 'inc/_footer.php'; ?>