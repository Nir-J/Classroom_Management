<?php session_start();
    include 'dblink.php';
    
    if( !isset($_SESSION['usr']))
    {
       header("Location: index.php"); 
    }
    $choice = $_POST['choice'];
?>
<!DOCTYPE html>

<html>
    <head>
        <title>NIE-GJB</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/main.css"/>
        <link rel="stylesheet" type="text/css" href="css/Complaints2.css"/>
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
                global $choice;
                if($choice == "room"):
                    $room_no = $_POST['search_query'];
                    $query = "SELECT c1, c2, c3 FROM rooms WHERE room_no = '$room_no'";
                    $result = mysql_query($query) or die("Cannot retrieve 1");
                    $count = mysql_num_rows($result);
                    if($count != 1){
                        $_SESSION['e_complaint1'] = 1;
                        header("Location: Complaints.php");
                        exit();
                    }
                    $comp = mysql_fetch_array($result);
                    $query2 = "SELECT c_info FROM complaints WHERE c_id = '$comp[0]' OR c_id = '$comp[1]' OR c_id = '$comp[2]'";
                    $result2 = mysql_query($query2) or die("Cannot retrieve 2");
            ?>
            <h2>Room Number: <?php echo"$room_no" ?></h2>
            <table class="info">
                    <tr>
                        <th> Number </th>
                        <th> Complaints </th>
                    </tr>
                    <?php $i=0; while ($complaint = mysql_fetch_array($result2)): $i++; ?>
                    <tr>
                        <td> <?php echo"$i"?> </td>
                        <td> <?php echo"$complaint[0]" ?> </td>
                    </tr>
                    <?php endwhile; ?>
            </table>
            <?php elseif($choice == "complaint"): 
                            $c_info = $_POST['search_query'];
                            $query4 = "SELECT c_id FROM complaints WHERE c_info = '$c_info'";
                            $result4 = mysql_query($query4);
                            $count1 = mysql_num_rows($result4);
                            if($count1 != 1){
                                $_SESSION['e_complaint2'] = 1;
                                header("Location: Complaints.php");
                                exit();
                            }
                            $c_id = mysql_fetch_array($result4);
                            $query3 = "SELECT room_no FROM rooms WHERE c1 = '$c_id[0]]' OR c2 ='$c_id[0]]' OR c3 = '$c_id[0]]'";
                            $result3 = mysql_query($query3) or die("Cannot retrieve 3");
            ?>
            <h2>Complaint: <?php echo"$c_info"; ?></h2>
            <table class="info">
                    <tr>
                        <th> Floor </th>
                        <th> Room </th>
                    </tr>
                    <?php  while ($rooms = mysql_fetch_array($result3)): ?>
                    <tr>
                        <td> <?php $f = floor($rooms[0]/100)-1; echo "$f";?> </td>
                        <td> <?php echo"$rooms[0]" ?> </td>
                    </tr>
                    <?php endwhile; ?>
            </table>
            <?php endif; ?>
            
        </div>
    </body>
</html>

