<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deletar Usuário</title>
</head>
<body>
    <?php
    include '../bd_connect.php';
    $username = $_GET['user'];

    $query = "DELETE FROM users WHERE username = '$username'";

    if(mysqli_query($con,$query)){
        header('location:admin.php?user_deleted=true');
    }else{
        header('location:admin.php?erro_deleted=true');
    }
    mysqli_close($con);
    ?>
</body>
</html>