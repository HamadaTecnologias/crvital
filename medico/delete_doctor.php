<?php
include 'bd_connect.php';
$id_medico = $_GET['id_medico'];

$query = "DELETE FROM medico WHERE id_medico = '$id_medico'";

if(mysqli_query($con,$query)){
    header('location:doctor.php?doctor_deleted=true');
}else{
    header('location:doctor.php?erro_deleted=true');
}
mysqli_close($con);
?>