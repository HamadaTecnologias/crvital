<?php 
include "../bd_connect.php";
$id_atendimento = $_GET['id_atendimento'];
$data_inicio = $_GET['data_inicio'];
$data_fim = $_GET['data_fim'];
$id_empresa = $_GET['id_empresa'];

$query_delete = "DELETE FROM atendimento WHERE id_atendimento=".$id_atendimento;
if (mysqli_query($con,$query_delete)) {
    header('location:historico-periodo.php?data_inicio='.$data_inicio.'&data_fim='.$data_fim.'&id_empresa='.$id_empresa);
}else{
    echo"Erro ao iniciar atendimento<br>";
    echo mysqli_error($con);
    echo "<br>Contate o Suporte";
    }   
?>