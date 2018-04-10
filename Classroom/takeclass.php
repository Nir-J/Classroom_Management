<?php session_start();
    include 'dblink.php';
    
    date_default_timezone_set('Asia/Kolkata');
    $time = date("H:i:s");
    
    $dep = $_POST['dep'];
    $sem = $_POST['sem'];
    $sec = $_POST['sec'];
    $sub = strtoupper($_POST['sub']);
    $teacher = $_SESSION['usr'];
    
    /* If teacher specified */
    if(isset($_POST['teacher'])){
        if($_POST['teacher'] != NULL){
            $teacher = $_POST['teacher'];
            $query = "SELECT * FROM staff WHERE s_initial = '$teacher'";
            $result = mysql_query($query);
            $count = mysql_num_rows($result);
            if($count != 1){
                $_SESSION['e_teach'] = 1;
                header("Location: FreeClass.php");
                exit();
            }
        }
    }
    
    $query = "SELECT * FROM staff WHERE s_initial = '$teacher'";
    $result = mysql_query($query);
    $val = mysql_fetch_array($result);
    $tid = $val[0];
    
    $query1 = "SELECT * FROM subject WHERE sub_id = '$sub'";
    $result1 = mysql_query($query1);
    $count = mysql_num_rows($result1);
    if($count != 1){
        $_SESSION['e_sub'] = 1;
        header("Location: FreeClass.php");
        exit();
    }
    
    $query2 = "SELECT b_id, b_room FROM batch WHERE b_sem='$sem' AND b_section='$sec' AND d_id='$dep'";
    $result2 = mysql_query($query2) or die("Cant exec");
    $check = mysql_num_rows($result2);
    if($check != 1){
        $_SESSION['e_batch'] = 1;
        header('Location: FreeClass.php');
        exit();
    }
    $val2 = mysql_fetch_array($result2);
    $bid = $val2[0];
    $room = $val2[1];
    
    $cq1 = "SELECT * FROM rooms WHERE b_id = '$bid'";
    $cr1 = mysql_query($cq1);
    $countb = mysql_num_rows($cr1);
    if($countb == 1){
        $_SESSION['e_dupb'] = 1;
        header("Location: FreeClass.php");
        exit();
    }
    
    $cr2 = "SELECT * FROM rooms WHERE t_id = '$tid'";
    $cr2 = mysql_query($cr2) or die("cr2 error");
    $countt = mysql_num_rows($cr2);
    
    if($countt == 1){
        $_SESSION['e_dupt'] = 1;
        header("Location: FreeClass.php");
        exit();
    }
    /*If room specified */
    if(isset($_POST['room'])){
        if($_POST['room'] != 0){
            $room = $_POST['room'];
        }
    }
    
    
    $query3 = "SELECT * FROM rooms WHERE room_no = '$room'";
    $result3 = mysql_query($query3) or die("Second");
    $val3 = mysql_fetch_array($result3);
    if($val3[2] != 0){  
        $_SESSION['e_free'] = 1;
        header("Location: FreeClass.php");
        exit();
    }
    
    
    if($val3[2] == 0 || $val3[2] == 1){
        $query4 = "UPDATE rooms SET b_id = '$bid', r_status ='2', r_sub = '$sub', t_id = '$tid', timer = '$time' WHERE room_no = '$room'";
        $result4 = mysql_query($query4) or die("result4 error");
        $_SESSION['roombooked'] = 1;
        header("Location: FreeClass.php");
    }
?>
