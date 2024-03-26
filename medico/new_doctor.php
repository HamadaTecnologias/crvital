<?php
include "../bd_connect.php";

$new_doctor = $_POST['new_doctor_username'];
$new_cpf = $_POST['new_doctor_cpf'];
$new_nis = $_POST['new_doctor_nis'];
$new_board = $_POST['new_doctor_board'];
$new_register_board = $_POST['new_doctor_register_board'];
$new_category = $_POST['new_doctor_category'];

$query = "INSERT INTO medico (nome_medico, cpf, nis, sigla_conselho, registro_conselho, categoria) VALUES ('$new_doctor', '$new_cpf','$new_nis', '$new_board', '$new_register_board', '$new_category')";

if(mysqli_query($con, $query)){
   header('location:doctor.php?new_doctor=true');
} else {
   header('location:doctor.php?new_doctor=false');
}

?>