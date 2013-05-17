<?php

session_start();

require("config.php");

$db = mysql_connect($dbhost, $dbuser, $dbpassword);
mysql_select_db($dbdatabase, $db);

?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $config_forumsname; ?></title>
		<link rel="stylesheet" href="stylesheet.css" type="text/css" />
	</head>
	<body>
		<div id="header">
			<h1 align="center"><?php echo $config_forumsname; ?></h1>
			[<a href="index.php">Home</a>]
			&bull;
			
			<?php
			if(isset($_SESSION['USERNAME']) == TRUE) {
				echo "[<a href='logout.php'>Logout (" . $_SESSION['USERNAME'] . ")</a>] &bull;";
			}  
			else {
				echo "[<a href='login.php'>Log in</a>] &bull;";
				echo " [<a href='register1.php'>Sign up</a>] &bull;";
			}
			?>
			
			[<a href="newtopic.php">New Topic</a>]
		</div>
		<div id="main">

