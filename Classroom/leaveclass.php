<?php session_start();

    include'dblink.php';

    if($_SESSION['s_rights'] == 1){
        $room = $_POST['room'];
        mysql_query("UPDATE rooms SET r_status = '0', b_id = NULL, t_id = NULL, r_sub = NULL, timer = '00:00:00' WHERE room_no = '$room'") or die("Cant update");
        header("Location: FreeClass.php");
    }
    
    if($_SESSION['s_rights'] == 0){
        $sid = $_SESSION['s_id'];
        mysql_query("UPDATE rooms SET r_status = '0', b_id = NULL, t_id = NULL, r_sub = NULL, timer = '00:00:00' WHERE t_id = '$sid'") or die("Cant update sid");
        header("Location: FreeClass.php");
    }
    
?>

