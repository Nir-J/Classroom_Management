<?php session_start();
    include 'dblink.php';
    
    if( !isset($_SESSION['usr']))
    {
       header("Location: index.php"); 
    }
    $room = $_POST['room'];
    
    $query1 = "SELECT * FROM rooms WHERE room_no = '$room'";
    $result1 = mysql_query($query1)or die("Cant retrieve");
    $v = mysql_fetch_array($result1);
    $rower = mysql_num_rows($result1);
    if($rower != 1){
        header("Location: FreeClass.php");
        exit(0);
    }
    
    $query2 ="SELECT s_name FROM staff WHERE s_id = '$v[3]'";
    $result2 = mysql_query($query2);
    $tname = mysql_fetch_array($result2);
    
    $query3 = "SELECT d_id, b_section, b_sem from batch WHERE b_id = '$v[4]'";
    $result3 = mysql_query($query3);
    $batch = mysql_fetch_array($result3);

    $query4 = "SELECT d_name FROM department WHERE d_id = '$batch[0]'";
    $result4 = mysql_query($query4);
    $depart = mysql_fetch_array($result4);
?>
<!DOCTYPE html>

<html>
    <head>
        <title>NIE-GJB</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/main.css"/>
        <link rel="stylesheet" type="text/css" href="css/Batch2.css"/>
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
            <?php
                global $v, $tname, $batch, $depart;
                switch($v[2]){
                    case 0: $status = "Free"; break;
                    case 1: $status = "Scheduled"; break;
                    case 2: $status = "Occupied"; break;
                }
            ?>
            <h2> Class Information </h2>
            <div class="side">
                <table class="info">
                    <?php if($status == "Occupied"): ?>
                    <tr>
                        <th> Department </th>
                        <td> <?php echo"$depart[0]" ?> </td>
                    </tr>
                    <tr>
                        <th> Semester </th>
                        <td> <?php echo"$batch[2]" ?> </td>
                    </tr>
                    <tr>
                        <th> Section </th>
                        <td> <?php echo"$batch[1]" ?> </td>
                    </tr>
                    <tr>
                        <th> Teacher Name </th>
                        <td> <?php echo"$tname[0]" ?> </td>
                    </tr>
                    <tr>
                        <th> Subject </th>
                        <td> <?php echo"$v[5]" ?> </td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <th> Room Status </th>
                        <td> <?php echo"$status" ?> </td>
                    </tr>
                </table>
                
                
           
        </div>
    </body>
</html>


