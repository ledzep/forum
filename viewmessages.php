<?php

require("config.php");

if (isset($_GET['id']) == TRUE) {
	if (is_numeric($_GET['id']) == FALSE) {
		$error = 1;
	}
	
	if (isset($error)) {
		header("Location: " . $config_basedir);
	}
	else  {
		$validtopic = $_GET['id'];
	}
}
else {
	$validtopic = 0;
}
?>

<?php
require("header.php");

$topicsql = "SELECT topics.subject, topics.forum_id, forums.name
	FROM topics, forums WHERE topics.forum_id = forums.id
	AND topics.id = " . $validtopic . ";";
$topicresult = mysql_query($topicsql);
$topicrow = mysql_fetch_assoc($topicresult);

echo "<h2>" . $topicrow['subject'] . "</h2>";
echo "<a href='index.php'>" . $config_forumsname . "</a> > <a href='viewforum.php?id=" . $topicrow['forum_id'] ."'>" . $topicrow['name'] . "</a><br /><br />";

$topicsql = "SELECT topics.*, users.username
	FROM topics, users WHERE topics.user_id
	= users.id AND topics.id = " . $validtopic . " ORDER BY topics.date;";

$topicresult = mysql_query($topicsql);
$topicrow = mysql_fetch_assoc($topicresult);
echo "<table>";
echo "<tr><td><strong>Posted by <i>"
. $topicrow['username'] . "</i> on "
. date("D jS F Y g.iA", strtotime($topicrow['date']))
. " - <i>" . $topicrow['subject']
. "</i></strong></td></tr>";
echo "<tr><td>" . $topicrow['body']. "</td></tr>";
echo "<tr></tr>";

echo "<tr><td>[<a href='reply.php?id=" . $validtopic .
"'>reply</a>]</td></tr>";
echo "</table>";

$threadsql = "SELECT messages.*, users.username, topics.subject
	FROM messages, users, topics WHERE messages.user_id 
	= users.id AND messages.topic_id = " . $validtopic . " ORDER BY messages.date;";

$threadresult = mysql_query($threadsql);

echo "<table>";

while($threadrow = mysql_fetch_assoc($threadresult)) {
	echo "<tr><td><strong>Re: <i>"
	. $threadrow['subject'] . "</i> by <i>" . $threadrow['username']
	. "</i></strong></td></tr>";
	echo nl2br("<tr><td>" . $threadrow['replies']. "</td></tr>");
	echo "<tr></tr>";
}
echo "</table>";
	

/*$topicsql = "SELECT topics.*, users.username
	FROM topics, users WHERE topics.user_id
	= users.id AND topics.id = " . $validtopic . " ORDER BY topics.date;";

$topicresult = mysql_query($topicsql);

echo "<table>";

while($topicrow = mysql_fetch_assoc($topicresult)) {
	echo "<tr><td><strong>Posted by <i>"
	. $topicrow['username'] . "</i> on "
	. date("D jS F Y g.iA", strtotime($topicrow['date']))
	. " - <i>" . $topicrow['subject']
	. "</i></strong></td></tr>";
	echo "<tr><td>" . $topicrow['body']. "</td></tr>";
	echo "<tr></tr>";
}

echo "<tr><td>[<a href='reply.php?id=" . $validtopic .
"'>reply</a>]</td></tr>";
echo "</table>";*/
?>

<?php
require("footer.php");
?>


