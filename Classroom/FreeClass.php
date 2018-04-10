<?php session_start();
    include 'dblink.php';
    
    if( !isset($_SESSION['usr']))
    {
       header("Location: index.php"); 
    }
    $query1 = "Select * from department";
    $result = mysql_query($query1);
    
    /* Automatic clearing of class */
    
    date_default_timezone_set('Asia/Kolkata');
    $time = date("H:i:s");
    $timee = mysql_query("SELECT room_no, timer from rooms WHERE timer <> '00:00:00'") or die("Timer not working");
    while($resultt = mysql_fetch_array($timee)){
        $dif = strtotime( $time ) - strtotime( $resultt[1] );
        $min = $dif / 60;
        if($min > 55){
            mysql_query("UPDATE rooms SET r_status = '0', b_id = NULL, t_id = NULL, r_sub = NULL, timer = '00:00:00' WHERE room_no = '$resultt[0]'") or die("Cant update");
        }
    }
    
    /* Timetable automation */
    
    $day = date('l');
    $rooms;
    $i = 0;
    
   if($time < "16:30:00" && $time > "15:25:00"){
        $timeslot = "nine";
    }
    elseif($time < "15:25:00" && $time > "14:30:00"){
        $timeslot = "eight";
    }
    elseif($time < "14:30:00" && $time > "12:35:00"){
        $timeslot = "seven";
    }
    elseif($time < "12:35:00" && $time > "11:40:00"){
        $timeslot = "six";
    }
    elseif($time < "11:40:00" && $time > "10:45:00"){
        $timeslot = "five";
    }
    elseif($time < "10:45:00" && $time > "09:20:00"){
        $timeslot = "four";
    }
    elseif($time < "09:20:00" && $time > "08:25:00"){
        $timeslot = "three";
    }
    elseif($time < "08:25:00" && $time > "07:30:00"){
        $timeslot = "two";
    }
    elseif($time < "07:30:00" && $time > "06:30:00"){
        $timeslot = "one";
    }
    else{
        $timeslot = "error";
    }
    if($timeslot != "error"){
       $ta1 = "SELECT room_no FROM rooms WHERE r_status = 0 AND room_no IN ( SELECT b_room FROM batch WHERE b_id IN ( SELECT time_bid FROM timetable WHERE day = '$day' AND $timeslot = 'free'))";
        $taresult = mysql_query($ta1) or die("ta1 error");
        while($room1 = mysql_fetch_array($taresult)){
            $rooms[$i++] = $room1[0];
        }

        $ta2 = "SELECT room_no from rooms WHERE r_status = 0 AND room_no NOT IN ( SELECT b_room FROM batch)";
        $taresult2 = mysql_query($ta2) or die("ta2 error");
        while($room2 = mysql_fetch_array($taresult2)){
            $rooms[$i++] = $room2[0];
        }
        sort($rooms); 
    }
        
?>

 <!DOCTYPE html>

<html>
    <head>
        <title>NIE-GJB</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/main.css"/>
        <link rel="stylesheet" type="text/css" href="css/FreeClass.css"/>
    </head>
    <body class="body">
        <header class="mainHeader"> 
            
            <img src="images/logo.GIF" alt="Logo">
            <h1>NIE Golden Jubliee Block</h1> 
        
            <nav>
                <div id="nav1"><ul>
                    <li><a href="FreeClass.php">Class</a></li>
                    <li><a href="Batch.php">Batch</a></li>
                    <li><a href="Teachers.php">Teacher</a></li>
                    <li><a href="Complaints.php">Complaint</a></li>
                </ul></div>
                <div id="nav2"><ul>
                    <li><a href="Profile.php">Profile</a></li>
                    <li><a href="indexout.php">Logout</a></li>
                </ul></div>
            </nav>
        </header>

        <div class="mainContent">
            
            <div id="take">
                <h2> Take Class <?php if(isset($_SESSION['roombooked'])) if($_SESSION['roombooked'] == 1): $_SESSION['roombooked'] = 0; ?> - Success! <?php endif; ?></h2>
                <form action="takeclass.php" method="post" class="take_form">
                    <?php if(isset($_SESSION['e_sub'])) if($_SESSION['e_sub'] == 1): $_SESSION['e_sub'] = 0; ?><span class="error"> *Enter correct subject code </span> <?php endif; ?>
                    <?php if(isset($_SESSION['e_teach'])) if($_SESSION['e_teach'] == 1): $_SESSION['e_teach'] = 0; ?><span class="error"> *Enter correct teacher initial </span> <?php endif; ?>
                    <?php if(isset($_SESSION['e_free'])) if($_SESSION['e_free'] == 1): $_SESSION['e_free'] = 0; ?><span class="error"> *Room not empty </span> <?php endif; ?>
                    <?php if(isset($_SESSION['e_batch'])) if($_SESSION['e_batch'] == 1): $_SESSION['e_batch'] = 0; ?><span class="error"> *Batch not found </span> <?php endif; ?>
                    <?php if(isset($_SESSION['e_dup'])) if($_SESSION['e_dup'] == 1): $_SESSION['e_dup'] = 0; ?><span class="error"> *Batch already busy </span> <?php endif; ?>
                    <?php if(isset($_SESSION['e_dupb'])) if($_SESSION['e_dupb'] == 1): $_SESSION['e_dupb'] = 0; ?><span class="error"> *Duplicate batch </span> <?php endif; ?>
                    <?php if(isset($_SESSION['e_dupt'])) if($_SESSION['e_dupt'] == 1): $_SESSION['e_dupt'] = 0; ?><span class="error"> *Duplicate teacher </span> <?php endif; ?>
                    <table class="info">
                    <tr>
                        <th> Department: </th>
                        <th> Semester: </th>
                        <th> Section: </th>
                        <th> Subject: </th>
                    </tr>
                    <tr>
                        <td><select name="dep">
                                <?php global $result;
                                    while($deps = mysql_fetch_array($result)){
                                        echo"<option value=$deps[0]> $deps[1] </options>";
                                    }
                                ?>
                        </select></td>
                        <td><select name='sem'>
                            <?php
                                for($i = 1; $i < 9; $i++){
                                    echo"<option value=$i> $i </option>";
                                }
                            ?>
                        </select></td>
                        <td><select name='sec'>
                                <option value='A'> A </option>
                                <option value='B'> B </option>
                        </select></td>
                        <td> <input type="text" name="sub" placeholder="Subject Code"> </td>
                    </tr>
                    <tr>
                        <?php if($_SESSION['s_rights'] == 1): ?>
                        <th> Teacher Initial </th>
                        <th> <input type="text" name="teacher" placeholder="Optional"> </th>
                        <?php endif; ?>
                        <th> Free class </th>
                        <th><select name="room">
                                <option value="0"> </option>
                                <?php global $rooms;
                                foreach($rooms as $a){
                                    echo "<option value=$a> $a </option> ";
                                }
                            ?>    
                        </select></th>
                    </tr>
                </table>
                    <button> Take Class </Button>
                    
                </form>
            </div>
            <div id ="leave">
                <h2> Leave class </h2>
                <form action="leaveclass.php" method="post" class="leave_form">
                    <?php if($_SESSION['s_rights'] == 1): ?>
                    <input type="text" name="room" placeholder="Room Number">
                    <?php endif; ?>
                    <button> Leave </button>
                </form>
            </div>
            <div id ="search">
                <h2> Search Room </h2>
                <form action="roomsearch.php" method="post" class="leave_form">
                    <input type="text" name="room" placeholder="Room Number">
                    <button> Search </button>
                </form>
            </div>
        </div>
    </body>
</html>
