<?php
$link = mysqli_connect('warriors88.powwebmysql.com', 'llne', 'benmatech', 'devs_hackathon'); 
	if (!$link) { 
    	die('Could not connect: ' . mysql_connect_error()); 
	}

$sql = "UPDATE `hand` SET `raised` = '0' WHERE `id` = 1";
	if (mysqli_query($link, $sql)) {
	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($link);
	}

?>