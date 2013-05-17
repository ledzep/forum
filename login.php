<?php
require("header.php");
require("functions.php");
?>

<form action="<?php echo pf_script_with_get($_SERVER['SCRIPT_NAME']); ?>" method="POST">
<table>
	<tr>
		<td>Username</td>
		<td><input type="text" name="username"></td>
	</tr>
	<tr>
		<td>Password</td>
		<td><input type="password" name="password"></td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" name="submit" value="Login!"></td>
	</tr>
</table>
</form>

<?php
if(isset($_POST['submit'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	$temp = sha1($password);
	$sql = "SELECT * FROM users WHERE username = '$username' AND password = '$temp';";
	$result = mysql_query($sql);
	$numrows = mysql_num_rows($result);
	
	if($numrows == 1) {
		$row = mysql_fetch_assoc($result);
		if($row['active'] == 1) {
			$_SESSION['USERNAME'] = $row['username'];
			$_SESSION['USERID'] = $row['id'];
			
			switch($_GET['ref']) {
				case "newpost":
				if(isset($_GET['id']) == FALSE) {
					header("Location: " . $config_basedir . "/newtopic.php");
				}
				else {
					header("Location: " . $config_basedir . "/newtopic.php?id=" . $_GET['id']);
				}
				break;
				
				case "reply":
				if(isset($_GET['id']) == FALSE) {
					header("Location: " . $config_basedir . "/newtopic.php");
				}
				else {
					header("Location: " . $config_basedir . "/newtopic.php?id=" . $_GET['id']);
				}
				break;
				
				default:
				header("Location: " . $config_basedir);
				break;
			}
		}
		else {
			echo "This account is not verified yet. You were emailed a link to verify the account. Please click on the link in the email to continue.";
		}
	}
	else {
		header("Location: " . $config_basedir . "/login.php?error=1");
	}
}
else {
	if(isset($_GET['error'])) {
		echo "Incorrect login, please try again!";
		echo "<br />";
		echo "<br />";
	}
}
?>
Don't have an account? Go and <a href="register1.php">Register</a>!<br><br>
				
<?php
require("footer.php");
?>



