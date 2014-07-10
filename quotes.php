<?php date_default_timezone_set('America/Los_Angeles');
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
		$to = 'web@cgs.aero';
		$subject = 'HACK ATTEMPT';
		$header = 'Bcc: brian@compressedgassystems.com, brian@cgs.aero, jennifer@cgs.aero' . "\r\n";
		$header .= 'From: web@cgs.aero';
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
if (verifyFormToken('form1')) { //if(!empty($_POST)) {

	// Building a whitelist array with keys which will send through the form, no others would be accepted later on
  $whitelist = array('token', 'company-name', 'contact-name', 'phone', 'fax', 'email', 'street-address', 'street-address2', 'city', 'state', 'zip', 'country', 'oem-part-number', 'serial-number', 'alternate-part-number', 'quantity', 'service', 'cylinder-mfg-date', 'required-delivery', 'certification', 'condition', 'notes', 'type' );

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
	$message .='  <tr style="background: #eee;"> <td width="150"><strong>Company Name:</strong> </td> <td width="330"><strong>' . strip_tags($_POST['company-name']) . '</strong></td> </tr>';
	$message .='  <tr> <td><strong>Contact Name</strong></td> <td>' . strip_tags($_POST['contact-name']) . '</td> </tr>';
	$message .='  <tr> <td><strong>Phone Number</strong></td> <td>' . strip_tags($_POST['phone']) . '</td> </tr>';
	$message .='  <tr> <td><strong>Fax</strong></td> <td>' . strip_tags($_POST['fax']) . '</td> </tr>';
	$message .='  <tr> <td><strong>e-mail</strong></td> <td>' . strip_tags($_POST['email']) . '</td> </tr>';
	$message .='  <tr> <td><strong>Address</strong></td> <td>' . strip_tags($_POST['street-address']) .

	(!empty($_POST['street-address2'])?'<br/>'.$_POST['street-address2']:'')

	. '<br/>' . strip_tags($_POST['city']) . ', ' . strip_tags($_POST['state']) . ' ' . strip_tags($_POST['zip']) . '<br/>' . strip_tags($_POST['country']) . '</td> </tr>';
	$message .='</table>';


	$message .='<br/><br/>';
	$message .='<table rules="all" style="border-color: #666;" cellpadding="10" width="480">';
	$message .='  <tr style="background: #eee;"> <td colspan="2"><strong>' . strip_tags($_POST['type']) . ':</strong> on <span style="float:right">' . date("F jS, Y") . '</span></td> </tr>';
	$message .='    <tr> <td width="200"><strong>OEM Part Number:</strong> </td> <td width="400">' . strip_tags($_POST['oem-part-number']) . '</td> </tr>';
	$message .='    <tr> <td><strong>Serial Number:</strong> </td> <td>' . strip_tags($_POST['serial-number']) . '</td> </tr>';
	$message .='    <tr> <td><strong>Alternate Part Number:</strong> </td> <td>' . strip_tags($_POST['alternate-part-number']) . '</td> </tr>';
	$message .='    <tr> <td><strong>Quantity:</strong> </td> <td>' . strip_tags($_POST['quantity']) . '</td> </tr>';



 if( $_POST['type'] == 'Request for Service' ) {

		$message .='    <tr> <td><strong>Service Required:</strong> </td> <td>';
		for($i = 0; $i < count($_POST['service']); $i++) {
	    $message .= $_POST['service'][$i].', ';
		}
		$message .=     '</td> </tr>';
		$message .='    <tr> <td><strong>Cylinder Mfg. Date:</strong> </td> <td>' . strip_tags($_POST['cylinder-mfg-date']) . '</td> </tr>';
		$message .='    <tr> <td><strong>Certification Required:</strong> </td> <td>' . strip_tags($_POST['certification']) . '</td> </tr>';

 } else if ( $_POST['type'] == 'Request for Parts' ) {

		$message .='    <tr> <td><strong>Condition:</strong> </td> <td>';
		for($i = 0; $i < count($_POST['condition']); $i++) {
	    $message .= $_POST['condition'][$i].', ';
		}
		$message .=     '</td> </tr>';

 }



	$message .='    <tr> <td><strong>Required Delivery:</strong> </td> <td>' . strip_tags($_POST['required-delivery']) . ' Working Days</td> </tr>';

	$message .='    <tr> <td valign="top"><strong>Notes / Other Requirements:</strong></td><td>' . strip_tags($_POST['notes']) . '</td>';
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

			$to = 'web@cgs.aero';
			$subject = 'Request a Quote';

			$headers = "From: " . $_POST['contact-name'] . " < " . $_POST['email'] . " >\r\n";
			$headers .= "Reply-To: " . $_POST['email'] . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			$headers .= "Bcc: brian@compressedgassystems.com, brian@cgs.aero, jennifer@cgs.aero\r\n";

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
$newToken = generateFormToken('form1');

$pageTitle = 'Request a Quote';
include 'inc/_header.php'; ?>

<ul class="breadcrumb">
	<li><a href="/">home</a></li>
	<li>quotes</li>
</ul>

<section class="content">

<?php if(!empty($message)) {
    echo $message;
} ?>

<h1 class="hide">Quotes</h1>

<div class="panel-group" id="accordion">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
          Request Service
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse">
      <div class="panel-body">
        <!-- <h2 class="">Request Service</h2> -->
	<div class="row">
	<form class="form-horizontal col-lg-8" action="quotes.php" method="post">
	<input type="hidden" name="token" value="<?php echo $newToken; ?>">
		<fieldset>
  	  <legend>Company Information</legend>
		  <div class="form-group">
		    <label for="input" class="col-lg-4 control-label">Company Name</label>
		    <div class="col-lg-8">
		      <input type="text" class="form-control" name="company-name" placeholder="Company Name" value="<?=!empty($_POST['company-name'])?$_POST['company-name']:'';?>" required>
		    </div>
		  </div>
			<div class="form-group">
		    <label for="input" class="col-lg-4 control-label">Contact Name</label>
		    <div class="col-lg-8">
		      <input type="text" class="form-control" name="contact-name" placeholder="Contact Name" value="<?=!empty($_POST['contact-name'])?$_POST['contact-name']:'';?>" required>
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="input" class="col-lg-4 control-label">Phone Number</label>
		    <div class="col-lg-8">
		      <input type="tel" class="form-control" name="phone" placeholder="Phone Number" value="<?=!empty($_POST['phone'])?$_POST['phone']:'';?>" required>
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="input" class="col-lg-4 control-label">Fax</label>
		    <div class="col-lg-8">
		      <input type="tel" class="form-control" name="fax" placeholder="Fax" value="<?=!empty($_POST['fax'])?$_POST['fax']:'';?>">
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="input" class="col-lg-4 control-label">Email</label>
		    <div class="col-lg-8">
		      <input type="email" class="form-control" name="email" placeholder="e-mail" value="<?=!empty($_POST['email'])?$_POST['email']:'';?>" required>
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="input" class="col-lg-4 control-label">Address</label>
		    <div class="col-lg-8">
		      <input type="text" class="form-control" name="street-address" placeholder="Street Address" value="<?=!empty($_POST['street-address'])?$_POST['street-address']:'';?>" required>
          <input type="text" class="form-control" name="street-address2" value="<?=!empty($_POST['street-address2'])?$_POST['street-address2']:'';?>" placeholder="suite, unit...">
          <input type="text" class="form-control" name="city" placeholder="city" value="<?=!empty($_POST['city'])?$_POST['city']:'';?>" required>
		    </div>
		    <span class="col-lg-4"></span>
		    <div class="col-lg-8 form-inline">
		      <input type="text" class="form-control" name="state" maxlength="2" placeholder="State" value="<?=!empty($_POST['state'])?$_POST['state']:'';?>">
          <input type="text" class="form-control" name="zip" maxlength="5" placeholder="Zip" value="<?=!empty($_POST['zip'])?$_POST['zip']:'';?>" required>
          <input type="text" class="form-control" name="country" placeholder="Country" value="<?=!empty($_POST['country'])?$_POST['country']:'';?>" required>
		    </div>
		  </div>
		</fieldset>

		<fieldset>
    	<legend>Product Information</legend>
    	<div class="form-group">
		    <label for="input" class="col-lg-4 control-label">Oem Part Number</label>
		    <div class="col-lg-8">
		      <input type="text" class="form-control" name="oem-part-number" placeholder="Oem Part Number" value="<?=!empty($_POST['oem-part-number'])?$_POST['oem-part-number']:'';?>" required>
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="input" class="col-lg-4 control-label">Serial Number</label>
		    <div class="col-lg-8">
		      <input type="text" class="form-control" name="serial-number" placeholder="Serial Number" value="<?=!empty($_POST['serial-number'])?$_POST['serial-number']:'';?>" required>
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="input" class="col-lg-4 control-label">Alternate Part Number</label>
		    <div class="col-lg-8">
		      <input type="text" class="form-control" name="alternate-part-number" placeholder="Alternate Part Number" value="<?=!empty($_POST['alternate-part-number'])?$_POST['alternate-part-number']:'';?>" required>
		    </div>
		  </div>
		</fieldset>

		<fieldset>
    <legend>Service Request</legend>
			<div class="form-group">
		    <label for="input" class="col-lg-4 control-label">Quantity</label>
		    <div class="col-lg-8">
		      <input type="number" min="1" class="form-control" name="quantity" placeholder="Quantity" value="<?=!empty($_POST['quantity'])?$_POST['quantity']:'';?>" required>
		    </div>
		  </div>
		  <div class="form-group">
		  	<label for="input" class="col-lg-4 control-label">Service Required</label>
		    <div class="col-lg-8">

				  <label class="checkbox-inline">
					  <input type="checkbox" name="service[]" value="Inspect"> Inspect
					</label>
					<label class="checkbox-inline">
					  <input type="checkbox" name="service[]" value="Repair"> Repair
					</label>
					<label class="checkbox-inline">
					  <input type="checkbox" name="service[]" value="Overhaul"> Overhaul
					</label>
					<label class="checkbox-inline">
					  <input type="checkbox" name="service[]" value="Hydrostatic Test"> Hydrostatic Test
					</label>
					<label class="checkbox-inline">
					  <input type="checkbox" name="service[]" value="Functional Check"> Functional Check
					</label>
		    </div>
		  </div>

			<div class="form-group">
		    <label for="input" class="col-lg-4 control-label">Cylinder Mfg. Date</label>
		    <div class="col-lg-8">
		      <input type="date" class="form-control" name="cylinder-mfg-date" placeholder="MM/DD/YYYY" value="<?=!empty($_POST['cylinder-mfg-date'])?$_POST['cylinder-mfg-date']:'';?>" required>
		    </div>
		  </div>
			<div class="form-group">
		    <label for="input" class="col-lg-4 control-label">Required Delivery</label>
		    <div class="col-lg-8">
		      <input type="number" min="1" class="form-control" name="required-delivery" placeholder="working days" value="<?=!empty($_POST['required-delivery'])?$_POST['required-delivery']:'';?>" required>
		    </div>
		  </div>
		  <div class="form-group">
		  	<label for="input" class="col-lg-4 control-label">Certification Required</label>
		    <div class="col-lg-8">
				  <label class="radio-inline"><!-- radios but have same name to work -->
					  <input type="radio" name="certification" value="FAA 8130-3"> FAA 8130-3
					</label>
					<label class="radio-inline">
					  <input type="radio" name="certification" value="EASA dual-release"> EASA dual-release
					</label>
					<label class="radio-inline">
					  <input type="radio" name="certification" value="CoC only"> CoC only
					</label>
					<label class="radio-inline">
					  <input type="radio" name="certification" value="Test Data Sheet Only"> Test Data Sheet Only
					</label>
					<label class="radio-inline">
					  <input type="radio" name="certification" value="No Certification Required"> No Certification Required
					</label>
		    </div>
		  </div>
			<div class="form-group">
		    <label for="input" class="col-lg-4 control-label">Notes / Other Requirements</label>
		    <div class="col-lg-8">
		      <textarea class="form-control" name="notes" rows="12"></textarea>
		      <br/>
		      <input type="hidden" name="type" value="Request for Service">
		      <button type="submit" class="btn btn-default">Submit</button>
		    </div>
		  </div>
		</fieldset>
	</form>

</div>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
          Request Parts
        </a>
      </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse">
      <div class="panel-body">
        <div class="row">

	<!-- <h2>Request Parts</h2> -->
	<form class="form-horizontal col-lg-8" action="quotes.php" method="post">
		<input type="hidden" name="token" value="<?php echo $newToken; ?>">
		<fieldset>
  	  <legend>Company Information</legend>
		  <div class="form-group">
		    <label for="input" class="col-lg-4 control-label">Company Name</label>
		    <div class="col-lg-8">
		      <input type="text" class="form-control" name="company-name" placeholder="Company Name" value="<?=!empty($_POST['company-name'])?$_POST['company-name']:'';?>" required>
		    </div>
		  </div>
			<div class="form-group">
		    <label for="input" class="col-lg-4 control-label">Contact Name</label>
		    <div class="col-lg-8">
		      <input type="text" class="form-control" name="contact-name" placeholder="Contact Name" value="<?=!empty($_POST['contact-name'])?$_POST['contact-name']:'';?>" required>
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="input" class="col-lg-4 control-label">Phone Number</label>
		    <div class="col-lg-8">
		      <input type="tel" class="form-control" name="phone" placeholder="Phone Number" value="<?=!empty($_POST['phone'])?$_POST['phone']:'';?>" required>
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="input" class="col-lg-4 control-label">Fax</label>
		    <div class="col-lg-8">
		      <input type="tel" class="form-control" name="fax" placeholder="Fax" value="<?=!empty($_POST['fax'])?$_POST['fax']:'';?>">
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="input" class="col-lg-4 control-label">Email</label>
		    <div class="col-lg-8">
		      <input type="email" class="form-control" name="email" placeholder="e-mail" value="<?=!empty($_POST['email'])?$_POST['email']:'';?>" required>
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="input" class="col-lg-4 control-label">Address</label>
		    <div class="col-lg-8">
		      <input type="text" class="form-control" name="street-address" placeholder="Street Address" value="<?=!empty($_POST['street-address'])?$_POST['street-address']:'';?>" required>
          <input type="text" class="form-control" name="street-address2" value="<?=!empty($_POST['street-address2'])?$_POST['street-address2']:'';?>" placeholder="suite, unit...">
          <input type="text" class="form-control" name="city" placeholder="city" value="<?=!empty($_POST['city'])?$_POST['city']:'';?>" required>
		    </div>
		    <span class="col-lg-4"></span>
		    <div class="col-lg-8 form-inline">
		      <input type="text" class="form-control" name="state" maxlength="2" placeholder="State" value="<?=!empty($_POST['state'])?$_POST['state']:'';?>">
          <input type="text" class="form-control" name="zip" maxlength="5" placeholder="Zip" value="<?=!empty($_POST['zip'])?$_POST['zip']:'';?>" required>
          <input type="text" class="form-control" name="country" placeholder="Country" value="<?=!empty($_POST['country'])?$_POST['country']:'';?>" required>
		    </div>
		  </div>
		</fieldset>

		<fieldset>
    	<legend>Product Information</legend>
    	<div class="form-group">
		    <label for="input" class="col-lg-4 control-label">Oem Part Number</label>
		    <div class="col-lg-8">
		      <input type="text" class="form-control" name="oem-part-number" placeholder="Oem Part Number" value="<?=!empty($_POST['oem-part-number'])?$_POST['oem-part-number']:'';?>" required>
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="input" class="col-lg-4 control-label">Serial Number</label>
		    <div class="col-lg-8">
		      <input type="text" class="form-control" name="serial-number" placeholder="Serial Number" value="<?=!empty($_POST['serial-number'])?$_POST['serial-number']:'';?>" required>
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="input" class="col-lg-4 control-label">Alternate Part Number</label>
		    <div class="col-lg-8">
		      <input type="text" class="form-control" name="alternate-part-number" placeholder="Alternate Part Number" value="<?=!empty($_POST['alternate-part-number'])?$_POST['alternate-part-number']:'';?>" required>
		    </div>
		  </div>
		</fieldset>

		<fieldset>
			<legend>Parts / Outright Purchase</legend>
    	<div class="form-group">
		    <label for="input" class="col-lg-4 control-label">Quantity</label>
		    <div class="col-lg-8">
		      <input type="number" min="1" class="form-control" name="quantity" placeholder="Quantity" value="<?=!empty($_POST['quantity'])?$_POST['quantity']:'';?>" required>
		    </div>
		  </div>

			<div class="form-group">
		  	<label for="input" class="col-lg-4 control-label">Condition</label>
		    <div class="col-lg-8">

				  <label class="checkbox-inline">
					  <input type="checkbox" name="condition[]" value="fn"> FN
					</label>
					<label class="checkbox-inline">
					  <input type="checkbox" name="condition[]" value="oh"> OH
					</label>
					<label class="checkbox-inline">
					  <input type="checkbox" name="condition[]" value="sv"> SV
					</label>
					<label class="checkbox-inline">
					  <input type="checkbox" name="condition[]" value="sr"> AR
					</label>
					<label class="checkbox-inline">
					  <input type="checkbox" name="condition[]" value="any"> Any
					</label>
		    </div>
		  </div>

		  <div class="form-group">
		    <label for="input" class="col-lg-4 control-label">Required Delivery</label>
		    <div class="col-lg-8">
		      <input type="number" min="1" class="form-control" name="required-delivery" placeholder="working days" value="<?=!empty($_POST['required-delivery'])?$_POST['required-delivery']:'';?>" required>
		    </div>
		  </div>

		  <div class="form-group">
		    <label for="input" class="col-lg-4 control-label">Notes / Other Requirements</label>
		    <div class="col-lg-8">
		      <textarea class="form-control" name="notes" rows="12"></textarea>
		      <br/>
		      <input type="hidden" name="type" value="Request for Parts">
		      <button type="submit" class="btn btn-default">Submit</button>
		    </div>
		  </div>

		</fieldset>
	</form>
	</div>
      </div>
    </div>
  </div>
</div>
















<!-- use js to ensure email address is valid -->




</section>

<script src="_/js/jquery-1.9.1.js"></script>

    <!-- Twitter Bootstrap -->
    <script src="_/vendor/twitter-bootstrap/js/bootstrap.js"></script>

<?php include 'inc/_footer.php'; ?>
