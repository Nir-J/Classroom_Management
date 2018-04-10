<?php session_start();
    include 'dblink.php';
    
    if( !isset($_SESSION['usr']))
    {
       header("Location: index.php"); 
    }
        
    $u = $_SESSION['usr'];
    $s_info = "SELECT * FROM staff, department WHERE s_initial = '$u' AND staff.d_id = department.d_id";
    $result_info = mysql_query($s_info) or die("Cannot retrieve Profile info");
    $v = mysql_fetch_array($result_info);
?>

<!DOCTYPE html>

<html>
    <head>
        <title>NIE-GJB</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/main.css"/>
        <link rel="stylesheet" type="text/css" href="css/Profile.css"/>
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
            <h2> Profile Information </h2>
            <?php
                global $v;
                $id = $v[0];
                $uname = $v[1];
                $initial = $v[2];
                $pass = $v[3];
                $phone = $v[4];
                $email = $v[5];
                $dep = $v[9];
                    
            ?>
            <form action="profile_input.php" method="post" class="form">
                <table class="info">
                    <tr>
                        <th> Name </th>
                        <td> <?php echo"$uname" ?> </td>
                    </tr>
                    <tr>
                        <th> Username </th>
                        <td> <?php echo"$initial" ?> </td>
                    </tr>
                    <tr>
                        <th> Change Password </th>
                        <td> <input type="password" name="password" value="<?php echo $pass ?>"> </td>
                        <td><?php if(isset($_SESSION['e_pass'])) if($_SESSION['e_pass'] == 1): $_SESSION['e_pass'] = 0; ?><span class="error"> *Enter valid password (6 - 30 length) </span><?php endif; ?></td>
                    </tr>
                    <tr>
                        <th> Phone </th>
                        <td> <input type="text" value="<?php echo $phone ?>" name="phone"> </td>
                        <td><?php if(isset($_SESSION['e_phone'])) if($_SESSION['e_phone'] == 1): $_SESSION['e_phone'] = 0; ?><span class="error"> *Enter valid Phone number </span><?php endif; ?></td>
                    </tr>
                    <tr>
                        <th> Email </th>
                        <td> <input type="text" value="<?php echo $email ?>" name="email"> </td>
                        <td><?php if(isset($_SESSION['e_email'])) if($_SESSION['e_email'] == 1): $_SESSION['e_email'] = 0; ?><span class="error"> *Enter valid email address (gmail/yahoo) </span><?php endif; ?></td>
                    </tr>
                    <tr>
                        <th> Department </th>
                        <td> <?php echo"$dep" ?> </td>
                    </tr>
                </table>
                <button> Update </Button
            </form>
        </div>
    </body>
</html>
