<?php
$link = mysqli_connect('warriors88.powwebmysql.com', 'llne', 'benmatech', 'devs_hackathon'); 
	if (!$link) { 
    	die('Could not connect: ' . mysql_connect_error()); 
	} 

if($_POST["name"] !== null) {

    $sql = "INSERT INTO `topics` (`name`,`minutes`,`createdBy`,`ordering`) VALUES ('" . $_POST["name"] . "','" . $_POST["minutes"] . "','Logan','" . $_POST["benjamin"] . "')";
    if (mysqli_query($link, $sql)) {
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($link);
    }
}

if($_POST["benorder"] !== null) {
    $sql = "DELETE FROM `topics` WHERE `ordering` = '" . $_POST["benorder"] . "'";
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
    <div id="boxbox" style="display:none"></div>
    <div id="timer">00:00</div>
    <button onclick="startTimer()" id="startbutton">Start</button>
    <div id="updater"></div>
    <button onclick="nextEvent()">next</button>
    <button onclick="previousEvent()">previous</button>
    
    <script>
        let currentEvent = 0;
        function nextEvent() {
        currentEvent += 1;
       }
        function previousEvent() {
        currentEvent -= 1;
       }
       function startTimer() {
           // Get today's date and time
            let startTime = new Date().getTime();

            let distance = 0;
            let currentTime = 0;
            let minutes = 0;
            let seconds = 0;
            
            setInterval(function() {
                currentTime = new Date().getTime();
                distance = currentTime - startTime;
                
             minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
             document.getElementById("timer").innerHTML = minutes + "m " + seconds + "s ";

                countdown = document.getElementById("time" + currentEvent).innerHTML;
                countdown -= 1;
                document.getElementById("time" + currentEvent).innerHTML = countdown;
            },1000);
          
       } 
        
        
        
        
    function showBox(boxNo) {
        $("#box" + boxNo).show();
        document.getElementById("box" + boxNo).innerHTML = '<form id="eventSubmit" action="index.php" method="post"><input type="text" name="name" placeholder="Subject Name" class="textField" id="title"><br><br><input type="text" name="minutes" placeholder="Duration" class="textField" id="title"><br><br><input type="hidden" name="benjamin" value="' + ((boxNo*10)+15) + '"><input type="submit" value="Add" class="button"></form>';
 
    }   
        
    function killBox() {
        $("#boxbox").hide();
    }
        
    function expand(boxNo) {
        $.post("fetch.php", function(data) {
            updatedEvents = "";
            counting = 0; 
            eventObjects = data.split("~~~");
            eventObjects.pop();
            for(let i = 0; i < eventObjects.length; i++) {
                eventObjects[i] = JSON.parse(eventObjects[i]);
            }
            let selectedName = eventObjects[boxNo]["name"];
            let selectedTime = eventObjects[boxNo]["minutes"];
            let selectedNotes = eventObjects[boxNo]["notes"];
            $("#boxbox").show();
            document.getElementById("boxbox").innerHTML = "<button onclick='killBox()'>X</button><h1>" + selectedName + "</h1><h2>" + selectedTime + "</h2><textarea>" + selectedNotes + "</textarea>";
        });
    }    
        
    let updatedEvents = "";
        
    function updateItems() {
        $.post("fetch.php", function(data) {
            updatedEvents = "";
            counting = 0; 
            eventObjects = data.split("~~~");
            eventObjects.pop();
            for(let i = 0; i < eventObjects.length; i++) {
                eventObjects[i] = JSON.parse(eventObjects[i]);
            }
            
            for(let i = 0; i < eventObjects.length; i++) {
                updatedEvents += "<a onclick='expand(" + i + ")'><div class='event'><div class='createdBy'>" + eventObjects[i]["createdBy"] + "</div><div  class='minutes' id='time" + i + "'>" + eventObjects[i]["minutes"] + "</div><form action='index.php' class='eventdelete' method='post'><input name='benorder' type='hidden' value='" + eventObjects[i]["ordering"] + "'><input type='submit' value='X'></form><div class='name'>" + eventObjects[i]["name"] + "</a></div></div><img onclick='showBox(" + i + ")' src='addbutton.png' class='add'><div class='addbox' id='box" + i + "' style='top:" + (60+150*i) + "; display:none;'></div></a><br>";
                counting++;
            }
            
            document.getElementById("updater").innerHTML = updatedEvents;
                  
        });
    }
        
    updateItems();
    
    </script>
</body>

</html>