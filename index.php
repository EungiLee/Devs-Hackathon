<?php
$link = mysqli_connect('warriors88.powwebmysql.com', 'llne', 'benmatech', 'devs_hackathon'); 
	if (!$link) { 
    	die('Could not connect: ' . mysql_connect_error()); 
	} 

if($_POST["name"] !== null) {
    $sql = "INSERT INTO `topics` (name,minutes) VALUES ('" . $_POST["name"] . "','" . $_POST["minutes"] . "')";
    if (mysqli_query($link, $sql)) {
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($link);
    }
}

?>

<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div id="updater"></div>
    
    
    <div id="createNewEvent">
        <form id="eventSubmit" action="index.php" method="post">
            <input type="text" name="name" placeholder="Subject Name" class="textField" id="title"><br>
            <input type="text" name="minutes" placeholder="Duration" class="textField" id="title">
            <input type="submit" class="button">
        </form>
    </div>
    
    <script>
    let updatedEvents = "";
        
    function updateItems() {
        $.post("fetch.php", function(data) {
            updatedEvents = "";
            
            eventObjects = data.split("~~~");
            eventObjects.pop();
            for(let i = 0; i < eventObjects.length; i++) {
                eventObjects[i] = JSON.parse(eventObjects[i]);
            }
            console.log(eventObjects);
            
            for(let i = 0; i < eventObjects.length; i++) {
                updatedEvents += "<div class='event'><span class='minutes'>" + eventObjects[i]["minutes"] + "</span><span class='name'>" + eventObjects[i]["name"] + "</span><div class='createdBy'>" + eventObjects[i]["createdBy"] + "</div></div>";
            }
            
            document.getElementById("updater").innerHTML = updatedEvents;
                  
        });
    }
        
    updateItems();
        
    //setInterval(function() {    
   //     updateItems();
   // }, 3000); 
    
    </script>
</body>

</html>