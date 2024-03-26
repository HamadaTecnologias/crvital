<?php

$user_input = $_POST['user'];
$password = $_POST['password'];

include "../bd_connect.php";
$query = "SELECT name, username, password, level, status FROM users WHERE username = '$user_input'";

$bd_data = mysqli_query($con, $query);
$login = mysqli_fetch_assoc($bd_data);
$level = $login['level'];
$status = $login['status'];

if ($login['username'] == $user_input) {
    if ($login['password'] == $password) {
        if ($login['status'] == true) {
            session_start();
            $_SESSION['user'] = $user_input;
            $_SESSION['level'] = $level;
            $_SESSION['name'] = $login['name'];
        } else {
            throw new Exception('Usuário bloqueado');
        }
    }
}

if($level == 'R'){
    header('Location:main.php');
} elseif($level == 'A'){
    header('Location:../usuario/admin.php');
} elseif($level == 'F'){
    header('Location:financial.php');
} else {
    header('location:index.php?erro_pass=true');
    exit;
}

mysqli_close($con);
?>  