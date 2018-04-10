<?php session_start();
 include 'dblink.php';

if(isset($_POST['username'])){
        
        $username = $_POST['username'];
        $password = $_POST['password'];
        $_SESSION['usr'] = $username;
        $_SESSION['pass'] = $password;
        $sql = "SELECT s_pass, s_id, s_rights FROM staff WHERE s_initial = '$username'";
        $result = mysql_query($sql) or die('Cant execute');
        $values = mysql_fetch_array($result);
        $count = mysql_num_rows($result);
        if($password == $values[0] && $count == 1){
            $_SESSION['s_rights'] = $values[2];
            $_SESSION['s_id'] = $values[1];
            header("Location: FreeClass.php");
        }
        else{
             $_SESSION['error'] = 1;
             header("Location: Index.php");
        }
}
?>