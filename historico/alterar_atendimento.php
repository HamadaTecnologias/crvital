<?php 
include "../bd_connect.php";
$id_atendimento = $_POST['id_atendimento']??null;
$id_empresa = $_POST['id_empresa']??null;
$metodo_pagamento = $_POST['forma_pagamento']??null;
$nome_paciente =$_POST['nome_paciente']??null;
//RETIRANDO % DO TIPO EXAME
$tipo_exame_antes = $_POST['tipo_exame']??null;
$tipo_exame = str_replace("%", " ", "$tipo_exame_antes");
//FIM RETIRANDO % DO TIPO EXAME
$id_medico = $_POST['id_medico']??null;
$data = $_POST['data_atendimento']??null;
$telefone = $_POST['telefone']??null;








    //DEFININDO PROCEDIMENTOS SELECIONADOS
    $id_procedimento=null;
    if (isset($_POST['id_procedimento']))
        $id_procedimento = $_POST['id_procedimento'];
    //FIM DEFININDO PROCEDIMENTOS SELECIONADOS


    //QUERY PARA EFETUAR ALTERAÇÃO
    $query = "UPDATE atendimento SET tipo_exame ='".$tipo_exame."', id_medico = ".$id_medico.", data = '".$data."', nome_paciente = '".$nome_paciente."',telefone = '".$telefone."',metodo_pagamento = '".$metodo_pagamento."' WHERE id_atendimento = ".$id_atendimento;

     //ISERINDO NOVOS PROCEDIMENTOS
    if(mysqli_query($con,$query)){
        if ($id_procedimento !== null) {
            for ($i=0; $i < count($id_procedimento) ; $i++) { 
                $procedimento = $id_procedimento[$i];
                //QUERY PARA INSERIR ID ATENDIMENTO E ID PROCEDIMENTO NA TABELA ATENDIMENTO_PROCEDIMENTO
                $query_ida_idp = "INSERT INTO atendimento_procedimento(id_atendimento,id_procedimento) values('".$id_atendimento."','".$procedimento."')";
                mysqli_query($con,$query_ida_idp);
            }
        }
    header('location:editar_atendimento.php?alterado=true&id_atendimento='.$id_atendimento);
    }else{
    echo"Erro ao iniciar atendimento<br>";
    echo mysqli_error($con);
    echo "<br>Contate o Suporte";
    }   



?>
