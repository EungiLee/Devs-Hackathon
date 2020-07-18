<?php
    $link = mysqli_connect('warriors88.powwebmysql.com', 'llne', 'benmatech', 'devs_hackathon'); 
	if (!$link) { 
    	die('Could not connect: ' . mysql_connect_error()); 
	} 
	
	$sql = "SELECT * FROM `topics` ORDER BY `ordering` ASC";
	$result = mysqli_query($link, $sql);

    while($row = mysqli_fetch_assoc($result)) {
        echo json_encode($row) . "~~~";
    }
?>