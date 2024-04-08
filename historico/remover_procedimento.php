<?php 
include "../bd_connect.php";
$id_atendimento = $_GET['id_atendimento'];
$id_procedimento = $_GET['id_procedimento'];



$query_id_atendimento_procedimento = "SELECT id_atendimento_procedimento FROM atendimento_procedimento WHERE id_atendimento=".$id_atendimento." AND id_procedimento=".$id_procedimento;
$result_id_atendimento_procedimento = mysqli_query($con,$query_id_atendimento_procedimento);
$id= mysqli_fetch_assoc($result_id_atendimento_procedimento);



$query_delete_cadastro_procedimento = "DELETE FROM atendimento_procedimento WHERE id_atendimento_procedimento=".$id['id_atendimento_procedimento'];


if(mysqli_query($con,$query_delete_cadastro_procedimento)){
    header('location:editar_atendimento.php?delete=true&id_atendimento='.$id_atendimento);
}else{
echo"Erro ao iniciar atendimento<br>";
echo mysqli_error($con);
echo "<br>Contate o Suporte";
}   

?>