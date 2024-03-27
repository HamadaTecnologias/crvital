<?php

    $host = 'localhost';
    $user = 'crvitalcom_atendimento';
    $password = 'SFJ5MG9HW3vnhTxxDg9U';
    $database = 'crvitalcom_atendimento';

    $con = mysqli_connect($host, $user, $password, $database); //remover daqui se quiser logar que entrou no BD

    // if($con = mysqli_connect($host, $user, $password, $database)){
    //     echo "Database connected successfully!";
    // }

    if (mysqli_connect_error()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
      }
?>
