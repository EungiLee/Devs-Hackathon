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

if($_POST["notes"] !== null) {
    $sql = "UPDATE `topics` SET `notes` = '" . $_POST["notes"] . "' WHERE `ordering` = '" . $_POST["benbenorder"] . "'";
	if (mysqli_query($link, $sql)) {
	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($link);
	}
}

if($_POST["lance"] == 1) {
    $sql = "UPDATE `hand` SET `raised` = '1' WHERE `id` = 1";
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
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div id="boxbox" style="display:none"></div>
    <div id="timer">0m 0s</div>
    
    <div id="updater"></div>
    
    <div id="buttons">
    <button onclick="startTimer()" id="startbutton"><img src="stopwatch.png" height="100px"><br>Start</button>
    <button onclick="nextEvent()" id="nextbutton"><img src="next.png" height="75px" width="75px"><br>Next</button>
    <button onclick="previousEvent()" id="prevbutton"><img src="prev.png" height="75px" width="75px"><br>Previous</button>
    
    <form action='index.php' method='post'>
    <input type='hidden' name='lance' value='1'>
    <button type='submit' id='handbutton'><img src="raisehand.png" height="75px" width="75px"><br>Raise Hand</button>
    </form>
    </div>
    <img src="rightarrow.png" id="rightarrow">
    <div class='event dummy'><div class='createdBy'>Natasha</div><div  class='minutes'>5m30s</div><form action='index.php' class='eventdelete' method='post'><input name='benorder' type='hidden' value='" + eventObjects[i]["ordering"] + "'><input type='submit' value='X' class='deleteButton'></form><div class='name'>Secondary State</div></div>
    
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
                
                if(countdown < 0) {
                    $("#overalltime" + currentEvent).css('color', 'red');
                }
                
                document.getElementById("time" + currentEvent).innerHTML = countdown;
            },1000);
          
       } 
        
        setInterval(function() {
           
        },1000);
    function raiseHand() {
        $.post("getHandInfo.php", function(data) {
            console.log(data);
            if(data == true) {
                $("#handRaise" + currentEvent).show();
                setTimeout(function() {
                    $("#handRaise" + currentEvent).hide();
                    $.post("removeHand.php", function(data) {
                        console.log(data);
                    });   
                },5000);
            }
        });
        
    }    
    
    setInterval(function() {
        raiseHand();
    }, 3000);
        
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
            document.getElementById("boxbox").innerHTML = "<button onclick='killBox()'>X</button><h1>" + selectedName + "</h1><h2>" + selectedTime + " seconds scheduled</h2><form action='index.php' method='post'><textarea name='notes'>" + selectedNotes + "</textarea><input type='hidden' value='" + eventObjects[boxNo]["ordering"] + "' name='benbenorder'><input type='submit' value='Update'></form>";
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
                updatedEvents += "<a onclick='expand(" + i + ")'><div class='event'><div class='createdBy'>" + eventObjects[i]["createdBy"] + "</div><div  class='minutes' id='overalltime" + i + "'>" + eventObjects[i]["buffer"] + " <span id='time" + i + "'>" + eventObjects[i]["minutes"] + "</span>s</div><form action='index.php' class='eventdelete' method='post'><input name='benorder' type='hidden' value='" + eventObjects[i]["ordering"] + "'><input type='submit' value='X' class='deleteButton'></form><div id='handRaise" + i + "' class='handraising' style='display:none'>Natasha has raised her hand!</div><div class='name'>" + eventObjects[i]["name"] + "</a></div></div></a><img onclick='showBox(" + i + ")' src='addbutton.png' class='add'><div class='addbox' id='box" + i + "' style='top:" + (60+150*i) + "; display:none;'></div><img src='arrow.png' class='arrow'><br>";
                counting++;
            }
            
            document.getElementById("updater").innerHTML = updatedEvents;
                  
        });
    }
        
    updateItems();
    
    </script>
</body>

</html>