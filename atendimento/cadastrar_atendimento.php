<?php 
include "bd_connect.php";
$id_empresa = $_REQUEST['id_empresa']??null;
$metodo_pagamento = $_POST['forma_pagamento']??null;
$tipo_atendimento = $_POST['tipo_atendimento']??null;
$tipo_exame = $_POST['tipo_exame']??null;
$id_medico = $_POST['id_medico']??null;
$hora_checkout = null;
$data = $_POST['data_atendimento']??null;
$nome_paciente =$_POST['nome_paciente']??null;
$finalizar = $_GET['finalizar']??false;



//DEFININDO PROCEDIMENTOS SELECIONADOS
$id_procedimento=null;
if (isset($_POST['id_procedimento']))
    $id_procedimento = $_POST['id_procedimento'];


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


//EFETUANDO CHECK-IN
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
//FIM CHECK-IN


//EFETUANDO CHECKOUT

// DEFININDO HORARIO CHECKOUT
$query_hora_saida="SELECT TIME_FORMAT(CURTIME(), '%h:%i')";
$result = mysqli_query($con,$query_hora_saida);
$hora_saida = mysqli_fetch_assoc($result);
$hora_checkout = $hora_saida["TIME_FORMAT(CURTIME(), '%h:%i')"];
//FIM HORARIO CHECKOUT
if ($finalizar!=false) {
    $query_checkout = "UPDATE atendimento set hora_checkout='".$hora_checkout."'where id_atendimento =".$id_atendimento;
    mysqli_query($con,$query_checkout);
    header('location:atendimento.php?checkout=true');
}else{
    echo"Erro ao finalizar atendimento<br>";
echo mysqli_error($con);
echo "<br>Contate o Suporte";
}
//FIM CHECKOUT



?>
