<?php session_start();
    include 'dblink.php';
    
    if( !isset($_SESSION['usr']))
    {
       header("Location: index.php"); 
    }

$sql = "SELECT * FROM complaints";
$result = mysql_query($sql) or die("Cannot execute");

if(isset($_POST['ctype'])){
    $room = $_POST['Room_no'];
    $type = $_POST['ctype'];
    if($type == 1){
        $info = $_POST['complaint'];
        $sql1 = "INSERT INTO complaints (c_info) values ('$info')";
        $result1 = mysql_query($sql1) or die("Cannot insert into complaints table");
        $sql2 = "SELECT c_id FROM complaints ORDER BY c_id DESC LIMIT 1";
        $result2 = mysql_query($sql2);
        $row = mysql_fetch_array($result2);
        $type = $row[0];
    }
    $sql3 = "SELECT c1, c2, c3, count FROM rooms WHERE room_no ='$room'";
    $result3 = mysql_query($sql3) or die("Cannot retrieve complaints info");
    $row1 = mysql_fetch_array($result3);
    
    $count = $row1[3];
    switch($count){
        case 0: $c_input = "UPDATE rooms SET c1='$type' WHERE room_no ='$room'";
                mysql_query($c_input);
                $count = $count + 1;
                break;
        case 1: $c_input = "UPDATE rooms SET c2='$type' WHERE room_no ='$room'";
                mysql_query($c_input);
                $count = $count + 1;
                break;
        case 2: $c_input = "UPDATE rooms SET c3='$type' WHERE room_no ='$room'";
                mysql_query($c_input);
                $count = $count + 1;
                break;
        default: $count = -1; 
    }
    if($count != $row1[3] && $count != -1){
        $c_incr = "UPDATE rooms SET count='$count' WHERE room_no='$room'";
        mysql_query($c_incr);
    }
}

//if(isset($_POST['delroom'])){
//    $del_flag = 1;
//    $droom = $_POST['delroom'];
//    $drq1 = "SELECT c1, c2, c3, count FROM rooms WHERE room_no = '$droom'";
//    $drr1 = mysql_query($drq1) or die("drr1 error");
//    $dc = mysql_num_rows($drr1);
//    if($dc != 1){
//        $del_flag = "error";
//    }
//    $c = mysql_fetch_array($drr1);
//}
?>



<!DOCTYPE html>
<html>
    <head>
        <title>NIE-GJB</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/main.css"/>
        <link rel="stylesheet" href="css/Complaints.css"/>
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
            <div id="show">
                <nav class="inside_nav">Search complaint </nav>
                <form class="search_form" action="Complaints2.php" method="post">
                    <p>
                        Search by: 
                    </p>
                    <p>
                        <input class="radio" type="radio" name="choice" value="room" checked="1"> Room
                        <input class="radio" type ="radio" name="choice" value="complaint"> Complaint
                    </p>
                    <?php if(isset($_SESSION['e_complaint1'])) if($_SESSION['e_complaint1'] == 1): $_SESSION['e_complaint1'] = 0; ?><span class="error"> *Room not found </span> <?php endif; ?>
                    <?php if(isset($_SESSION['e_complaint2'])) if($_SESSION['e_complaint2'] == 1): $_SESSION['e_complaint2'] = 0; ?><span class="error"> *Complaint not found </span> <?php endif; ?>
                    <p>
                        <input id="search" type="text" placeholder="Search" name="search_query">
                    </p>
                    <button>Search</button>
                </form>
            </div>
            <div id="add">
                <nav class="inside_nav"> Add complaint </nav>
                <form class="complaint_form" action="complaints.php" method="post">
                    <p>Room No: <input type="text" placeholder="Ex: 406" name ="Room_no"/></p>
                    <br>
                        <?php
                            global $result;
                            echo "<select name =\"ctype\" size=\"1\">";
                            while ($values = mysql_fetch_array($result)) {
                                echo "<option value='$values[0]'> $values[1] </option>";
                            }
                            echo "</select>";
                        ?>
                    <br>
                    <textarea id="comp_text" rows="4" cols="50" name="complaint" placeholder="Write your own complaint."></textarea>
                    <?php 
                        global $count; 
                        if($count == -1) 
                            echo "<p class=error> *Complaints limit reached. Couldn't add </p>"; 
                    ?>
                    <p><button>Submit</button></p>
                </form>
            </div>
          
        </div>
    </body>
</html>
