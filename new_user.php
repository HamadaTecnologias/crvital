<?php
include 'bd_connect.php';

$new_user = $_POST['new_user_username'];
$new_password = $_POST['new_user_password'];
$new_level = $_POST['new_user_level'];

$query = "INSERT INTO users (username, password, level) VALUES ('$new_user', '$new_password', '$new_level')";

// if(mysqli_query($con, $query)){
//    $query2 = "INSERT INTO clients (name, address, phone, username) VALUES ('$nome', '$endereco', '$telefone', '$usuario')";

//    if(mysqli_query($con, $query2)){
//       header('location:admin.php?new_user=true');
//    } else {
//       header('location:admin.php?new_user=false');
//       exit;
//    }

// } else {
//    header('location:admin.php?new_user=false');
// }


?>
