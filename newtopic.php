<?php
require("header.php");
require("functions.php");
?>

<?php
$forchecksql = "SELECT * FROM forums;";
$forcheckresult = mysql_query($forchecksql);
$forchecknumrows = mysql_num_rows($forcheckresult);

if($forchecknumrows == 0) {
	header("Location: " . $config_basedir);
}

if(isset($_GET['id']) == TRUE) {
	if (is_numeric($_GET['id']) == FALSE) {
		$error = 1;
	}
	if(isset($error)) {
		header("Location: " . $config_basedir);
	}
	else {
		$validforum = $_GET['id'];
	}
}
else {
	$validforum = 0;
}

if(isset($_SESSION['USERNAME']) == FALSE) {
	header("Location: " . $config_basedir . "/login.php?ref=newpost&id=" . $validforum);
}

if(isset($_POST['submit'])) {
	if($_POST['subject'] == "" || $_POST['body'] == "") {
		echo "Please enter both subject and body!";
	} elseif($validforum == 0) {
		$topicsql = "INSERT INTO topics(date, user_id, forum_id, subject, body)
		VALUES(NOW()
		, " . $_SESSION['USERID']
		. ", " . $_POST['forum']
		. ", '" . $_POST['subject']
		. "', '" . $_POST['body'] . "');";
	} else {
		$topicsql = "INSERT INTO
		topics(date, user_id, forum_id, subject, body) VALUES(NOW()
		, " . $_SESSION['USERID']
		. ", " . $validforum
		. ", '" . $_POST['subject']
		. "', '" . $_POST['body'] . "');";
	}
	
	mysql_query($topicsql);
	
	/*$messagesql = "INSERT INTO messages(date,
	user_id, topic_id, subject, body) VALUES(NOW()
	, " . $_SESSION['USERID']
	. ", " . mysql_insert_id()
	. ", '" . $_POST['subject']
	. "', '" . $_POST['body']
	. "');";
	
	mysql_query($messagesql);*/
	header("Location: " . $config_basedir . "viewmessages.php?id=" . $topicid);
}
else {
	if($validforum != 0) {
		$namesql = "SELECT name FROM forums ORDER BY name;";
		$nameresult = mysql_query($namesql);
		$namerow = mysql_fetch_assoc($nameresult);
		
		echo "<h2>Post new message to the " . $namerow['name'] . "forum</h2>";
	}
	else {
		"<h2>Post a new message</h2>";
	}
}
?>

<form action="<?php echo pf_script_with_get($_SERVER['SCRIPT_NAME']); ?>" method="POST">
<table>
	<?php
	if($validforum == 0)	{
		$forumssql = "SELECT * FROM forums ORDER BY name;";
		$forumsresult = mysql_query($forumssql);
	}
	?>
	<tr>
		<td>Forum</td>
		<td>
			<select name="forum">
				<?php
				while($forumsrow = mysql_fetch_assoc($forumsresult)) {
					echo "<option value='" . $forumsrow['id'] . "'>" . $forumsrow['name'] . "</option>";
				}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td>Subject</td>
		<td><input type="text" name="subject"></td>
	</tr>
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
require("footer.php");
?>


	
