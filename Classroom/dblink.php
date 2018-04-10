<?php
    $user = "nj";
    $pass = "nj390";
    $db = "classroom";
    $host = "localhost";
    
    $link = mysql_connect($host, $user, $pass) or die('Could not connect' . mysql_error());
    $db_selected = mysql_select_db($db) or die('Database not selected');
?>   

