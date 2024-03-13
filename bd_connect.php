<?php

    $host = 'localhost';
    $user = 'root';
    $password = '';
    $database = 'crvital';

    if($con = mysqli_connect($host, $user, $password, $database)){
        echo "Conectado com sucesso!";
    }

    if (mysqli_connect_error()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
      }
  
?>
