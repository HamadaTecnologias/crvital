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


var_dump($_POST['id_procedimento']);

echo"<br>";
//DEFININDO PROCEDIMENTOS SELECIONADOS
$id_procedimento=null;
if (isset($_POST['id_procedimento']))
    $id_procedimento = $_POST['id_procedimento'];


// if ($id_procedimento !== null) {
//     for ($i=0; $i < count($id_procedimento) ; $i++) { 
//         $procedimento = $id_procedimento[$i];
//         echo $procedimento;
//     }
// }
// FIM

// DEFININDO HORARIO CHECKIN
$query_hora="SELECT TIME_FORMAT(CURTIME(), '%h:%i')";
$result = mysqli_query($con,$query_hora);
$hora = mysqli_fetch_assoc($result);
$hora_checkin = $hora["TIME_FORMAT(CURTIME(), '%h:%i')"];
//FIM


//QUERY PARA EFETUAR CHECKIN 
$query = "INSERT INTO atendimento(tipo_atendimento,tipo_exame,id_medico,hora_checkin,data,nome_paciente,id_empresa,hora_checkout,metodo_pagamento) values('".$tipo_atendimento."','".$tipo_exame."','".$id_medico."','".$hora_checkin."','".$data."','".$nome_paciente."','".$id_empresa."','".$hora_checkout."','".$metodo_pagamento."')";

//QUERY PARA DESCOBRIR O ULTIMO CHECKIN EFETUADO
$query_idcheckin = "SELECT id_atendimento FROM atendimento WHERE hora_checkin='".$hora_checkin."' AND data='".$data."';";
//QUERY DISABLING FOREIGN KEY CHECKS
$query_disable = "SET FOREIGN_KEY_CHECKS=0;";


if(mysqli_query($con,$query)){
    $result = mysqli_query($con,$query_idcheckin);
    $id = mysqli_fetch_assoc($result);
    if ($id_procedimento !== null) {
        for ($i=0; $i < count($id_procedimento) ; $i++) { 
            $procedimento = $id_procedimento[$i];
            //QUERY PARA INSERIR ID ATENDIMENTO E ID PROCEDIMENTO NA TABELA ATENDIMENTO_PROCEDIMENTO
            $query_ida_idp = "INSERT INTO atendimento_procedimento(id_atendimento,id_procedimento) values('".$id['id_atendimento']."','".$procedimento."')";
            mysqli_query($con,$query_ida_idp);
        }
    }
header('location:atendimento.php?checkin=true');
}else{
echo"Erro ao iniciar atendimento<br>";
echo mysqli_error($con);
echo "<br>Contate o Suporte";
}   




?>
