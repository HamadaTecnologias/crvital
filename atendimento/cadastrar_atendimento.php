<?php 
include "bd_connect.php";
$id_empresa = $_POST['id_empresa'];
$metodo_pagamento = $_POST['forma_pagamento'];
$tipo_atendimento = $_POST['tipo_atendimento'];
$tipo_exame = $_POST['tipo_exame'];
$id_medico = $_POST['id_medico'];
$hora_checkout = null;
$data = $_POST['data_atendimento'];
$nome_paciente =$_POST['nome_paciente'];

//DEFININDO PROCEDIMENTOS SELECIONADOS
$ids_procedimentos=null;
if (isset($_POST['id_procedimento']))
    $ids_procedimentos = $_POST['id_procedimento'];


if ($ids_procedimentos !== null) {
    for ($i=0; $i < count($ids_procedimentos) ; $i++) { 
        echo"<p>{$ids_procedimentos[$i]}</p>";
    }
}
// FIM

// DEFININDO HORARIO CHECKIN
$query_hora="SELECT TIME(CURRENT_TIMESTAMP);";
$result = mysqli_query($con,$query_hora);
$hora = mysqli_fetch_assoc($result);
$hora_checkin = $hora['TIME(CURRENT_TIMESTAMP)'];
//FIM


//INSERINDO CHECKIN NO BANCO
$query = "INSERT INTO atendimento(tipo_atendimento,tipo_exame,id_medico,hora_checkin,data,nome_paciente,id_empresa,hora_checkout,metodo_pagamento) values('".$tipo_atendimento."','".$tipo_exame."','".$id_medico."','".$hora_checkin."','".$data."','".$nome_paciente."','".$id_empresa."','".$hora_checkout."','".$metodo_pagamento."')";

if(mysqli_query($con,$query)){
    header('location:atendimento.php?cadastro=true');
}else{
echo"Erro ao iniciar atendimento<br>";
echo mysqli_error($con);
echo "<br>Contate o Suporte";
}   

?>
