<?php session_start();
    include 'dblink.php';
    
    if( !isset($_SESSION['usr']))
    {
       header("Location: index.php"); 
    }
    $dep = $_POST['dep'];
    $sem = $_POST['sem'];
    $sec = $_POST['sec'];
    
    $query1 = "SELECT * FROM batch WHERE d_id = '$dep' AND b_section = '$sec' AND b_sem = '$sem'";
    $result1 = mysql_query($query1)or die("Cant retrieve");
    $v = mysql_fetch_array($result1);
    
    $rowcount = mysql_num_rows($result1);
    if($rowcount != 1){
        $_SESSION['e_bat'] = 1;
        header("Location: Batch.php");
        exit();
    }
    
    $query2 ="SELECT d_name FROM department WHERE d_id = '$dep'";
    $result2 = mysql_query($query2);
    $dname = mysql_fetch_array($result2);
    
    $query3 = "SELECT room_no from rooms WHERE b_id = '$v[0]'";
    $result3 = mysql_query($query3);
    if(mysql_num_rows($result3) == 1){
        $v2 = mysql_fetch_array($result3);
        $cur_room = $v2[0];
    }
    else{
        $cur_room = "NULL";
    }    
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
                global $v, $dname, $cur_room;
            ?>
            <h2> Batch Information </h2>
            <div class="side">
                <table class="info">
                    <tr>
                        <th> Department </th>
                        <td> <?php echo"$dname[0]" ?> </td>
                    </tr>
                    <tr>
                        <th> Semester </th>
                        <td> <?php echo"$v[3]" ?> </td>
                    </tr>
                    <tr>
                        <th> Section </th>
                        <td> <?php echo"$v[2]" ?> </td>
                    </tr>
                    <tr>
                        <th> Batch Strength </th>
                        <td> <?php echo"$v[4]" ?> </td>
                    </tr>
                    <tr>
                        <th> CR Name </th>
                        <td> <?php echo"$v[5]" ?> </td>
                    </tr>
                    <tr>
                        <th> CR Number </th>
                        <td> <?php echo"$v[6]" ?> </td>
                    </tr>
                    <tr>
                        <th> Assigned Class </th>
                        <td> <?php echo"$v[8]" ?> </td>
                    </tr>
                    <tr>
                        <th> Current class </th>
                        <td> <?php echo"$cur_room" ?> </td>
                    </tr>
                </table>
                
                
            </div>
            <div class="timeimage">
                <div class="responsive">
                    <div class="img">
                        <?php echo'<img src="data:image/png;base64,'.base64_encode($v[7]). '"/>'; ?>
                        <div class="desc">Timetable</div>
                    </div>
                </div>

                <div class="clearfix"></div>

                <!-- The Modal -->
                <div id="myModal" class="modal">
                  <span class="close">×</span>
                  <img class="modal-content" id="img01">
                  <div id="caption"></div>
                </div>
            </div>
            <script src="js/Image.js"></script>

        </div>
    </body>
</html>
