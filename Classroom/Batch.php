<?php session_start();
    include 'dblink.php';
    
    if( !isset($_SESSION['usr']))
    {
       header("Location: index.php"); 
    }
    $query1 = "Select * from department";
    $result = mysql_query($query1);
    
?>
<!DOCTYPE html>

<html>
    <head>
        <title>NIE-GJB</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/main.css"/>
        <link rel="stylesheet" type="text/css" href="css/Batch.css"/>
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
            <h2> Search Batch </h2>
            <form action="Batch2.php" method="post" class="form">
                <table class="info">
                    <tr>
                        <th> Department: </th>
                        <td><select name="dep">
                                <?php global $result;
                                    while($deps = mysql_fetch_array($result)){
                                        echo"<option value=$deps[0]> $deps[1] </options>";
                                    }
                                ?>
                            </select></td>
                    </tr>
                    <tr>
                        <th> Semester </th>
                        <td><select name='sem'>
                            <?php
                                for($i = 1; $i < 9; $i++){
                                    echo"<option value=$i> $i </option>";
                                }
                            ?>
                        </select></td>
                    </tr>
                    <tr>
                        <th> Section </th>
                        <td><select name='sec'>
                                <option value='A'> A </option>
                                <option value='B'> B </option>
                        </select></td>
                    </tr>
                    <?php if(isset($_SESSION['e_bat'])) if($_SESSION['e_bat'] == 1): $_SESSION['e_bat'] = 0; ?><tr><td></td><td><span class="error"> *Enter valid batch </span></td></tr> <?php endif; ?>
                </table>
                <button> Search </Button>
            </form>
        </div>
    </body>
</html>
