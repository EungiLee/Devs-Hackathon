<?php
    $link = mysqli_connect('warriors88.powwebmysql.com', 'llne', 'benmatech', 'devs_hackathon'); 
	if (!$link) { 
    	die('Could not connect: ' . mysql_connect_error()); 
	} 
	
	$sql = "SELECT * FROM `hand` WHERE `id` = 1";
    $result = mysqli_query($link, $sql);
	$row = mysqli_fetch_assoc($result);
    echo $row["raised"];
?>