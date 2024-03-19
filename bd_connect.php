<?php

    $host = 'localhost';
    $user = 'root';
    $password = '';
    $database = 'crvitalnovo';

    $con = mysqli_connect($host, $user, $password, $database); //remover daqui se quiser logar que entrou no BD
    echo $database;

    // if($con = mysqli_connect($host, $user, $password, $database)){
    //     echo "Database connected successfully!";
    // }

    if (mysqli_connect_error()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
      }
?>
