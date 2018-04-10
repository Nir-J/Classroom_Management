<?php session_start();
    include 'dblink.php';
    
    if( !isset($_SESSION['usr']))
    {
       header("Location: index.php"); 
    }
    $flag = 0;
    if(isset($_POST['teacher'])){
        $initial = $_POST['teacher'];
        $query = "SELECT * FROM staff WHERE s_initial = '$initial'";
        $result = mysql_query($query);
        $count = mysql_num_rows($result);
        if($count != 1){
            $_SESSION['e_ini'] = 1;
            header("Location: Teachers.php");
            exit();
        }
        $flag = 1;
        $t_info = mysql_fetch_array($result);
        $query1 = "SELECT room_no FROM rooms WHERE t_id = '$t_info[0]'";
        $result1 = mysql_query($query1);
        $room = mysql_fetch_array($result1);
        $query2 = "SELECT d_name FROM department WHERE d_id = \"$t_info[d_id]\"";
        $result2 = mysql_query($query2);
        $dep = mysql_fetch_array($result2);
    }


?>
<!DOCTYPE html>

<html>
    <head>
        <title>NIE-GJB</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/main.css"/>
        <link rel="stylesheet" type="text/css" href="css/Teachers.css"/>
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
            <a href="../../../Users/Niranjan/Desktop/Classroom.pptx"></a>
            <h2> Teacher info </h2>
            <?php global $flag; if($flag == 0): ?>
            <form class="search_form" method="post" action="Teachers.php">
                <table class="info">
                    <tr>
                        <th> Teacher Initial: </th>
                        <td> <input type="text" name="teacher"> </td>
                    </tr>
                    <?php if(isset($_SESSION['e_ini'])) if($_SESSION['e_ini'] == 1): $_SESSION['e_ini'] = 0; ?><tr><td></td><td><span class="error"> *Enter valid initial </span></td></tr> <?php endif; ?>
                </table> 
                <button> Search </button>
            </form>
            <?php endif; ?>
            <?php if($flag == 1):
                global $room, $dep, $t_info; 
            ?>
                <table class="info">
                    <tr>
                        <th> Name </th>
                        <td> <?php echo"$t_info[1]" ?> </td>
                    </tr>
                    <tr>
                        <th> Initial </th>
                        <td> <?php echo"$t_info[2]" ?> </td>
                    </tr>
                    <tr>
                        <th> Phone </th>
                        <td> <?php echo"$t_info[4]" ?> </td>
                    </tr>
                    <tr>
                        <th> Email </th>
                        <td> <?php echo"$t_info[5]" ?> </td>
                    </tr>
                    <tr>
                        <th> Department </th>
                        <td> <?php echo"$dep[0]" ?> </td>
                    </tr>
                    <tr>
                        <th> Current class </th>
                        <td> <?php echo"$room[0]" ?> </td>
                    </tr>
                </table>
                
            
            <?php endif; ?>
        </div>
    </body>
</html>
