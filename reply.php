<?php
require("header.php");
require("functions.php");
?>

<form action="<?php echo pf_script_with_get($_SERVER['SCRIPT_NAME']); ?>" method="POST">
<table>
	<!--<tr>
		<td>Subject</td>
		<td><input type="text" name="subject"></td>
	</tr>-->
	<tr>
		<td>Body</td>
		<td><textarea name="body" rows="10" cols="50"></textarea></td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" name="submit" value="Post!"></td>
	</tr>
</table>
</form>


<?php
if(isset($_GET['id']) == TRUE) {
	if (is_numeric($_GET['id']) == FALSE) {
		$error = 1;
	}
	if(isset($error)) {
		header("Location: " . $config_basedir);
	}
	else {
		$validtopic = $_GET['id'];
	}
}
else {
	header("Location: " . $config_basedir);
}

if(isset($_SESSION['USERNAME']) == FALSE) {
	header("Location: " . $config_basedir . "/login.php?reply&id = " . $validtopic);
}

if(isset($_POST['submit'])) {
	if(/*$_POST['subject'] == "" ||*/ $_POST['body'] == "") {
		echo "Please enter body!";
	}
	else {
		$messagesql = "INSERT INTO messages(date,
		user_id, topic_id, replies) VALUES(NOW()
		, " . $_SESSION['USERID']
		. ", " . $validtopic
		. ", '" . $_POST['body']
		. "');";
		
		mysql_query($messagesql);
		header("Location: " . $config_basedir . "viewmessages.php?id=" . $validtopic);
	}
}
else {
	// code will go here
}
?>

<?php
require("footer.php");
?>

