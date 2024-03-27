<?php
include '../bd_connect.php';

$new_user = $_POST['new_user_username'];
$new_name = $_POST['new_user_full_name'];
$new_password = $_POST['new_user_password'];
$new_level = $_POST['new_user_level'];

$query = "INSERT INTO users (username, password, name, level) VALUES ('$new_user', '$new_password','$new_name', '$new_level')";

if(mysqli_query($con, $query)){
   header('location:admin.php?new_user=true');
} else {
   header('location:admin.php?new_user=false');
}

?>
