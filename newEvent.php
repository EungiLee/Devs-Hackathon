<?php

$link = mysqli_connect('warriors88.powwebmysql.com', 'llne', 'benmatech', 'devs_hackathon'); 
	if (!$link) { 
    	die('Could not connect: ' . mysql_connect_error()); 
	} 

$sql = "INSERT INTO `topics` (name,minutes) VALUES ('" . $_POST["name"] . "','" . $_POST["minutes"] . "')";
if (mysqli_query($link, $sql)) {
		echo "New article created successfully.<br>";
	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($link);
}

header('Location: http://loganmellow.com/devsHackathon/');
die();
?>