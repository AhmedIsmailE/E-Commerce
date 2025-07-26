<?php
session_start();
if (isset($_SESSION['user_id'])){
    session_unset();
    header("location:login.php");
}
else{
    header("location:login.php");
}

?>