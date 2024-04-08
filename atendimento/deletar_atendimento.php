<?php 
include "../bd_connect.php";
$id_atendimento = $_GET['id_atendimento'];
$data_inicio = $_GET['data_inicio'];
$data_fim = $_GET['data_fim'];

$query_delete = "DELETE FROM atendimento WHERE id_atendimento=".$id_atendimento;
if (mysqli_query($con,$query_delete)) {
    header('location:atendimento.php?excluido=true');
}else{
    echo"Erro ao iniciar atendimento<br>";
    echo mysqli_error($con);
    echo "<br>Contate o Suporte";
    }   
?>