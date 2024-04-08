<?php 
include "../bd_connect.php";
$id_empresa = $_POST['id_empresa']??null;
$metodo_pagamento = $_POST['forma_pagamento']??null;
//RETIRANDO % DO TIPO EXAME
$tipo_exame_antes = $_POST['tipo_exame']??null;
$tipo_exame = str_replace("%", " ", "$tipo_exame_antes");
//FIM RETIRANDO % DO TIPO EXAME
$id_medico = $_POST['id_medico']??null;
$hora_checkout = '00:00';
$data = $_POST['data_atendimento']??null;
$nome_paciente =$_POST['nome_paciente']??null;
$finalizar = $_GET['finalizar']??false;
$id_atendimento = $_GET['id_atendimento']??null;



// IF PARA DETERMINAR SE É CHECKIN OU CHECKOUT
if ($finalizar!=false) {
    //EFETUANDO CHECKOUT
    // DEFININDO HORARIO CHECKOUT
    $query_hora_saida="SELECT TIME_FORMAT(CURTIME(), '%H:%i')";
    $result = mysqli_query($con,$query_hora_saida);
    $hora_saida = mysqli_fetch_assoc($result);
    $hora_checkout = $hora_saida["TIME_FORMAT(CURTIME(), '%H:%i')"];
    //FIM HORARIO CHECKOUT
    $query_checkout = "UPDATE atendimento set hora_checkout='".$hora_checkout."'where id_atendimento =".$id_atendimento;
    if (mysqli_query($con,$query_checkout)) {
        header('location:atendimento.php?checkout=true');
    }else{
        echo"Erro ao finalizar atendimento<br>";
    echo mysqli_error($con);
    echo "<br>Contate o Suporte";
    }
    //FIM CHECKOUT    
}else{
    //DEFININDO PROCEDIMENTOS SELECIONADOS

    $id_procedimento=null;
    if (isset($_POST['id_procedimento']))
        $id_procedimento = $_POST['id_procedimento'];


    // DEFININDO HORARIO CHECKIN
    $query_hora="SELECT TIME_FORMAT(CURTIME(), '%H:%i')";
    $result = mysqli_query($con,$query_hora);
    $hora = mysqli_fetch_assoc($result);
    $hora_checkin = $hora["TIME_FORMAT(CURTIME(), '%H:%i')"];
    //FIM


    //QUERY PARA EFETUAR CHECKIN 
    $query = "INSERT INTO atendimento(tipo_exame,id_medico,hora_checkin,data,nome_paciente,id_empresa,hora_checkout,metodo_pagamento) values('".$tipo_exame."','".$id_medico."','".$hora_checkin."','".$data."','".$nome_paciente."','".$id_empresa."','".$hora_checkout."','".$metodo_pagamento."')";

    //QUERY PARA DESCOBRIR O ULTIMO CHECKIN EFETUADO
    $query_idcheckin = "SELECT id_atendimento FROM atendimento WHERE hora_checkin='".$hora_checkin."' AND data='".$data."' AND nome_paciente='".$nome_paciente."'";


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
}

?>
