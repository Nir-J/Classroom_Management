<?php
session_start();
include 'dblink.php';
mysql_close($link);
//unset($_SESSION['error']);
session_unset();

header("Location: index.php");
?>