<?php session_start();
    include 'dblink.php';
    
    if( !isset($_SESSION['usr']))
    {
       header("Location: index.php"); 
    }
    
    $u = $_SESSION['usr'];
    
    $pass = $_POST['password'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    
    /*Password Validation*/
    if(!preg_match("/^[a-zA-Z0-9]{6,30}$/", $pass)) {
        $_SESSION['e_pass'] = 1;
        header("Location: Profile.php");
        exit();
    }
    /*Phone Validation*/
    if(!preg_match("/^[0-9]{10}$/", $phone)) {
        $_SESSION['e_phone'] = 1;
        header("Location: Profile.php");
        exit();
    }
    
    /*Email Validation */
    if(!preg_match("/^[a-zA-Z]+[a-zA-Z0-9]*[@]{1}(gmail|yahoo){1}(.com){1}$/", $email)) {
        $_SESSION['e_email'] = 1;
        header("Location: Profile.php");
        exit();
    }
    
    
    
    $sql = "UPDATE staff SET s_pass='$pass', s_pnumber='$phone', s_email='$email' WHERE s_initial='$u'";
    mysql_query($sql);
    header("Location: Profile.php");
?>
    
