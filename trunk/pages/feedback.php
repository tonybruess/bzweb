<h3>Feedback</h3>
<?php
if($_POST)
{
	date_default_timezone_set("America/Chicago");
	$to = 'tony@bzextreme.com';
	
	$ip = $_SERVER['REMOTE_ADDR'];
	$domain = $_SERVER['HTTP_HOST'];
	
	$subject = "$name has feedback on bzweb";
	$date = date("m-j-Y") . ' around ' . date("g:i A");
	$headers = 'From: BZWeb Feedback <noreply@bzextreme.com>' . "\r\n";
	
	$name = stripslashes($_SESSION['callsign']);
	$email = stripslashes($_POST['email']);
	$why = stripslashes($_POST['why']);
	$message = stripslashes($_POST['feedback']);
	
	$messagefinal = "Name: $name\n\nEmail: $email\n\nWhy: $why\n\nMessage: \n\n$message\n\n Sent on $date from IP $ip at $domain";
	
	if(mail($to,$subject,$messagefinal,$headers)){
		echo "Thanks! Your feedback was received. If you have more feedback, click <a href=\"?p=feedback\">here</a>.";
	}
	else
	{
		echo "ERROR: Could not send feedback. Please click <a href=\"?p=feedback\">here</a>.";
	}
}
else
{
?>
<div id="info"><p>Please give feedback! Bugs, feature requests, or things that don't work are all welcome.</p></div>
<form method="post">
Name: <?php echo $_SESSION['callsign']; ?>
<br><br>
Email: <input type="text" name="email">
<br><br>
Host: <?php echo $_SERVER['HTTP_HOST']; ?> 
<br><br>
Reason for feedback:
<select name="why">
	<option>Feature Request</option>
	<option>Bug</option>
	<option>Question</option>
</select>
<br><br>
Feedback:
<br>
<textarea name="feedback" rows="10" cols="30"></textarea>
<br><br>
<input type="submit" value="Send">
</form>
<?php
}
?>