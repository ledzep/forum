<?php
require("header.php");
?>

<?php
if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])) {
	$email = ($_GET['email']);
	$hash = ($_GET['hash']);
	
	$sql = "SELECT id FROM users WHERE hash = '" . $hash . "' AND email = '" . $email . "';";
	$result = mysql_query($sql);
	$numrows = mysql_num_rows($result);
	
	if($numrows == 1) {
		$row = mysql_fetch_assoc($result);
		
		$sqlupdate = "UPDATE users SET active = 1 WHERE id = " . $row['id'];
		$result = mysql_query($sqlupdate);
		
		echo "Your account has now been verified.<br />
		You can now <a href='login.php'>log in</a>";
	}
	
	else {
		echo "This account could not be verified!";
	}
}
?>

<?php
require("footer.php");
?>


