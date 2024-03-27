<?php
include '../bd_connect.php';

$username = $_GET['user'];
$query = "UPDATE users SET status = true WHERE username = '$username'";

if(mysqli_query($con,$query)){
    header('location:admin.php?user_unblocked=true');
}else{
    header('location:admin.php?user_blocked=false');
}
?>