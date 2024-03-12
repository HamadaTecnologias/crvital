<?php

$user = $_POST['user'];
$password = $_POST['password'];

include 'bd_connect.php';
$query = "SELECT name, username, password, level FROM credent WHERE username = '$user'";

$bd_data = mysqli_query($con, $query);
$login = mysqli_fetch_assoc($bd_data);
$level = $login['level'];

if ($login['username'] == $user) {
    if ($login['password'] == $password) {
        session_start();
        $_SESSION['user'] = $user;
        $_SESSION['level'] = $level;
        $_SESSION['name'] = $login['name'];
    }
}

if($level == 'R'){
    //redirecionar para o software com permissões de recepcionista
    header('Location: main.php');
} elseif($level == 'A'){
    header('Location: admin.php');
} elseif($level == 'F'){
    header('Location: financial.php');
} else {
    header('location:index.php?erro_pass=true');
    exit;
}

mysqli_close($con);
?>  