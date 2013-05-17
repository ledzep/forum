<?php
require("header.php");
?>

<h2>Register</h2>
To register on the <?php echo 
$config_forumsname; ?>, fill in the form below. 
<form action="<?php echo $_SERVER['SCRIPT_NAME']?>" method="POST">
<table>
	<tr>
		<td>Username</td>
		<td><input type="text" name="username" value="<?php if(isset($_POST['username'])){ echo htmlentities($_POST['username']); } ?>" /></td>
	</tr>
	<tr>
		<td>Password</td>
		<td><input type="password" name="password" value="<?php if(isset($_POST['password'])){ echo htmlentities($_POST['password']); } ?>" /></td>
	</tr>
	<tr>
		<td>Email</td>
		<td><input type="text" name="email" value="<?php if(isset($_POST['email'])){ echo htmlentities($_POST['email']); } ?>" /></td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" name="submit" value="Register!"></td>
	</tr>
</table>
</form>

<?php
if(isset($_POST['submit'])) {
	$user = ($_POST['username']);
	$pass = ($_POST['password']);
	$email = ($_POST['email']);
	$token = sha1($pass);
	if($user == "" || $pass == "" || $email == "") {
		echo "please enter all fields";
	}
	
	else {
		echo "Your account has been made, <br /> please verify it by clicking the activation link that has been send to your email.";
		
		$hash = md5( rand(0,1000) );
			
		$sqlinsert = "INSERT INTO users (username, password, email, hash) VALUES('$user', '$token', '$email', '$hash');";
		mysql_query($sqlinsert);
		$to      = $email; //Send email to our user
		$subject = 'Signup | Verification'; //// Give the email a subject 
		$message = '

		Thanks for signing up!
		Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
			
		------------------------
		Username: '.$user.'
		Password: '.$pass.'
		------------------------

		Please click this link to activate your account:
		http://127.0.0.1/sites/forum/verify1.php?email='.$email.'&hash='.$hash.'

		'; // Our message above including the link
						
		$headers = 'From:foobar452@gmail.com' . "\r\n"; // Set from headers
		mail($to, $subject, $message, $headers); // Send the email
	}
}
?>

<?php
require("footer.php");
?>


		
					 
			
