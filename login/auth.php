<?php

$user_input = $_POST['user'];
$senha = $_POST['senha'];

include "../bd_connect.php";
$query = "SELECT name, username, password, level, status FROM users WHERE username = '$user_input'";

$bd_data = mysqli_query($con, $query);
$login = mysqli_fetch_assoc($bd_data);
$level = $login['level'];

if($login['username'] === $user_input) {
    if($login['password'] === $senha) {
        session_start();
        $_SESSION['usuario'] = $user_input;
        $_SESSION['nivel'] = $level;
    }
}

if($level == 'R'){
    header('Location:../atendimento/atendimento.php');
} elseif($level == 'A'){
    header('Location:../usuario/admin.php');
} elseif($level == 'F'){
    header('Location:../relatorio/relatorio.php');
} else {
    header('location:../index.php?erro_login=true');
    exit;
}

mysqli_close($con);
?>  