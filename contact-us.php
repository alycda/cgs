<?php
date_default_timezone_set('America/Los_Angeles');
error_reporting(E_ALL);

session_start();

function getRealIp() {
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {  //check ip from share internet
		$ip=$_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  //to check ip is pass from proxy
		$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip=$_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}

function writeLog($where) {
	$ip = getRealIp(); // Get the IP from superglobal
	$host = gethostbyaddr($ip);    // Try to locate the host of the attack
	$date = date("d M Y");

	// create a logging message with php heredoc syntax
	$logging = <<<LOG
	\n
<< Start of Message >>
	There was a hacking attempt on your form. \n
	Date of Attack: {$date}
	IP-Adress: {$ip} \n
	Host of Attacker: {$host}
	Point of Attack: {$where}
<< End of Message >>
LOG;
// Awkward but LOG must be flush left

	// open log file
	if($handle = fopen('hacklog.log', 'a')) {

		fputs($handle, $logging);  // write the Data to file
		fclose($handle);           // close the file

	} else {  // if first method is not working, for example because of wrong file permissions, email the data
		$to = 'alyda@me.com';
		$subject = 'HACK ATTEMPT';
		$header = 'Bcc: brian@compressedgassystems.com, brian@cgs.aero, jennifer@cgs.aero, web@cgs.aero' . "\r\n";
		$header .= 'From: web@alyda.me';
		if (mail($to, $subject, $logging, $header)) {
			echo "Sent notice to admin.";
		}
	}
}

function verifyFormToken($form) {

	// check if a session is started and a token is transmitted, if not return an error
	if(!isset($_SESSION[$form.'_token'])) {
		return false;
	}

	// check if the form is sent with token in it
	if(!isset($_POST['token'])) {
		return false;
	}

	// compare the tokens against each other if they are still the same
	if ($_SESSION[$form.'_token'] !== $_POST['token']) {
		return false;
	}

	return true;
}

function generateFormToken($form) {

	// generate a token from an unique value, took from microtime, you can also use salt-values, other crypting methods...
	$token = md5(uniqid(microtime(), true));

	// Write the generated token to the session variable to check it against the hidden field when the form is sent
	$_SESSION[$form.'_token'] = $token;

	return $token;
}

// VERIFY LEGITIMACY OF TOKEN
if (verifyFormToken('contact-form')) { //if(!empty($_POST)) {

	// Building a whitelist array with keys which will send through the form, no others would be accepted later on
  $whitelist = array('token', 'company', 'contact', 'email', 'message' );

  // Building an array with the $_POST-superglobal
  foreach ($_POST as $key=>$item) {

    // Check if the value $key (fieldname from $_POST) can be found in the whitelisting array, if not, die with a short message to the hacker
		if (!in_array($key, $whitelist)) {

			writeLog('Unknown form fields: '.$key);
			die("Hack-Attempt detected. Please use only the fields in the form");

		}
  }

  // PREPARE THE BODY OF THE MESSAGE

	$message = '<html><body><table style="width:480; margin: 0 auto;"><tr><td>';

	$message .='<table rules="all" style="border-color: #666;" cellpadding="10" width="480">';
	$message .='  <tr style="background: #eee;"> <td width="150"><strong>Company Name:</strong> </td> <td width="330"><strong>' . strip_tags($_POST['company']) . '</strong></td> </tr>';
	$message .='  <tr> <td><strong>Contact Name</strong></td> <td>' . strip_tags($_POST['contact']) . '</td> </tr>';
	$message .='  <tr> <td><strong>e-mail</strong></td> <td>' . strip_tags($_POST['email']) . '</td> </tr>';
	$message .='    <tr> <td valign="top"><strong>Notes / Other Requirements:</strong></td><td>' . strip_tags($_POST['message']) . '</td>';
	$message .='  </tr> </table>';
	$message .='<br/><br/>';
	$message .='<table rules="all" style="border-color: #666;" cellpadding="10" width="480">';
	$message .='  <tr style="background: #eee;"> <td width="150" colspan="2"><strong>Debug:</strong> </td> </tr>';
	$message .='  <tr> <td width="150"><strong>IP:</strong> </td> <td width="330">' . getRealIp() . '</td> </tr>';
	$message .='  <tr> <td><strong>Browser / OS:</strong><br/>(appears to be) </td> <td>' . $_SERVER['HTTP_USER_AGENT'] . '</td> </tr>';
	$message .='</table>';

	$message .= "</td></tr></table></body></html>";

	//  MAKE SURE THE "FROM" EMAIL ADDRESS DOESN'T HAVE ANY NASTY STUFF IN IT
	$pattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/i";
	if (preg_match($pattern, trim(strip_tags($_POST['email'])))) {
		$cleanedFrom = trim(strip_tags($_POST['email']));

		$to = 'alyda@me.com';
		$subject = 'Request a Quote';
		$headers = "From: " . $_POST['contact'] . " < " . $_POST['email'] . " >\r\n";
		$headers .= "Reply-To: " . $_POST['email'] . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

	  if (mail($to, $subject, $message, $headers)) {
	    $message = '<div class="alert alert-success">Your message has been sent. </div>'; //<button class="btn btn-default btn-xs pull-right">clear fields</button>
	  } else {
	    $message = '<div class="alert alert-danger">There was a problem sending the email.</div>';
	    //die();
	  }

	} else {
		$message =  '<div class="alert alert-danger">The email address you entered (' . $_POST["email"] . ') is invalid. Please try again!</div>';
		//die();
	}


} else {
	// print_r($_SESSION);
	// if (!isset($_SESSION[$form.'_token'])) {
	// } else {
		// echo "Hack-Attempt detected. Got ya!.";
		// writeLog('Formtoken');
	// }
}

// generate a new token for the $_SESSION superglobal and put them in a hidden field
$newToken = generateFormToken('contact-form');

$pageTitle = 'Contact Us';
include 'inc/_header.php'; ?>

<style>
	.jumbotron {
		font-size: 18px;
	}
</style>

<ul class="breadcrumb">
	<li><a href="/">home</a></li>
	<li>contact us</li>
</ul>

<?php if(!empty($message)) {
    echo $message;
} ?>

	<!-- <section class="jumbotron">
		<header>
		<h1 hidden>Services</h1>
		<span class="jumbo text-center">Tell us when <em>you</em> want it!</span>
		<em class="h4 text-center">Specializing in Corporate and General Aviation</em>
		</header>
		<div class="row">
			<div class="col-6 col-lg-3 alpha">
				<a href="services.php#oxygen-bottles"><img class="centered" src="images/oxygen.png" alt="Oxygen Bottles"></a>
				<h4>Oxygen Bottles</h4>
				<p class="small">CGS has the capability to hydro test, overhaul, and repair almost any walk-around or fixed-system oxygen bottle. <a class="more" href="services.php#oxygen-bottles">learn more</a></p></div>
			<div class="col-6 col-lg-3">
				<a href="services.php#portable-fire-extinguishers"><img class="centered" src="images/fire.png" alt="Portable Fire Extinguishers"></a>
				<h4>Fire Extinguishers</h4>
				<p class="small">CGS sells and services Halon 1211 and liquid extinguishers for use in the cockpit and cabin. <a class="more" href="services.php#portable-fire-extinguishers">learn more</a></p></div>
			<div class="col-6 col-lg-3">
				<a href="services.php#fixed-system-fire-bottles"><img class="centered" src="images/fixed.png" alt="Fixed-System Fire Extinguishers"></a>
				<h4>Fixed-System<br/> Fire Extinguishers</h4>
				<p class="small">We can overhaul the most common fire bottles found in corporate &amp; commercial aviation. <a class="more" href="services.php#fixed-system-fire-bottles">learn more</a></p></div>
			<div class="col-6 col-lg-3 omega">
				<a href="services.php#pneumatic-bottles"><img class="centered" src="images/pneumatic.png" alt="Pneumatic Bottles"></a>
				<h4>Pneumatic Bottles</h4>
				<p class="small">All types of blow down, life raft, and other pneumatic reservoirs can be hydro tested quickly and professionally. <a class="more" href="services.php#pneumatic-bottles">learn more</a></p></div>
		</div>
	</section> -->
	<section class="jumbotron">
		<h1 hidden>Info</h1>
		<div class="row">
      <div class="col-6 col-lg-4">
        <h2>Contact <span style="color:#428bca">CGS</span></h2>
        <p style="border-right: 1px solid #ccc;
height: 150px; width:300px;">	Phone: (855) 875-2226<br/>
Fax: (888) 694-7240<br/>
e-mail: <a href="mailto:brian@cgs.aero">brian@cgs.aero</a></p>
      </div>
      <div class="col-6 col-lg-4">
        <h2>Find <span style="color:#428bca">CGS</span></h2>
				<p style="border-right: 1px solid #ccc;
 width:300px;">
					13829 Artesia Blvd.<br/> Cerritos, CA 90703<br/><br/>
				<span class="h3">Hours</span><br/>
Monday - Friday<br/>
8:00AM - 5:00PM PST</p>
     	</div>
			<div class="col-lg-4">
<h2>A.O.G. Contact Info</h2>
<p>e-mail: <a href="mailto:brian@cgs.aero">brian@cgs.aero</a>   <br/>
Dial <strong>855-875-2226</strong>x1 after hours to be connected with a representative.
<br/><br/><br/>
24/7 A.O.G. Service <strong>ANYTIME</strong>
				</p>
      </div>
    </div>
</section>
<section class="content">
    <div class="row">
    	<div class="col-lg-4">
    		<form role="form" action="contact-us.php" method="post">
    			<input type="hidden" name="token" value="<?php echo $newToken; ?>">
				  <div class="form-group">
				    <label for="">Company</label>
				    <input type="text" class="form-control" name="company" placeholder="Company Name" value="<?=!empty($_POST['company'])?$_POST['company']:'';?>" required>
				  </div>
				  <div class="form-group">
				    <label for="">Contact</label>
				    <input type="text" class="form-control" name="contact" placeholder="Contact Name" value="<?=!empty($_POST['contact'])?$_POST['contact']:'';?>" required>
				  </div>
				  <div class="form-group">
				    <label for="">Email address</label>
				    <input type="email" class="form-control" name="email" placeholder="Enter email" value="<?=!empty($_POST['email'])?$_POST['email']:'';?>" required>
				  </div>
					<textarea class="form-control" name="message" rows="3" required><?=!empty($_POST['message'])?$_POST['message']:'Questions / Comments';?></textarea>
<br>
				  <button type="submit" class="btn btn-default">Submit</button>
				</form>
    	</div>
    	<div class="col-lg-8">
    		<iframe width="780" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=13829+Artesia+Blvd&amp;aq=&amp;sll=33.873363,-118.037672&amp;sspn=0.008721,0.010257&amp;t=m&amp;ie=UTF8&amp;hq=&amp;hnear=13829+Artesia+Blvd,+Cerritos,+California+90703&amp;ll=33.882459,-118.036423&amp;spn=0.024939,0.036478&amp;z=14&amp;iwloc=A&amp;output=embed"></iframe><br /><small><a href="https://maps.google.com/maps?f=q&amp;source=embed&amp;hl=en&amp;geocode=&amp;q=13829+Artesia+Blvd&amp;aq=&amp;sll=33.873363,-118.037672&amp;sspn=0.008721,0.010257&amp;t=m&amp;ie=UTF8&amp;hq=&amp;hnear=13829+Artesia+Blvd,+Cerritos,+California+90703&amp;ll=33.882459,-118.036423&amp;spn=0.024939,0.036478&amp;z=14&amp;iwloc=A" style="color:#0000FF;text-align:left;">View Larger Map</a></small>
    	</div>
    </div>

		<!-- use .md files to edit -->

		<p hidden>P.O. Box 15187, Long Beach, CA 90815<br/>
			 Shipping: 13829 Artesia Blvd. Cerritos, CA 90703<br/>
			 Phone: 855-875-2226<br/>
			 Fax: 888-694-7240<br/>
		</p>
	</section>
<?php include 'inc/_footer.php'; ?>