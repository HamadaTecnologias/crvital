<?php 
    include 'bd_connect.php';
    $id_empresa = $_POST['id_empresa'];
    $nome_empresa = $_POST['nome_empresa'];
    $cnpj= $_POST["cnpj"];
    $perfil= $_POST["perfil"];
    $forma_pagamento= $_POST["forma_pagamento"];
    $erro = FALSE;
   echo "<br>";
   echo "<br>";

    if(strlen($cnpj)!=14){
        echo "O CNPJ deve possuir 14 números <br>"; $erro=TRUE;
    }
    if(empty($nome_empresa)){
        echo "Digite a Razão Social corretamente. <br>"; $erro=TRUE;
    }
    if(empty($perfil)){
        echo "Selecione ao menos um perfil de credenciamento. <br>"; $erro=TRUE;
    }
    if(!$erro){
        $query = "update empresa set nome_empresa ='".$nome_empresa."', cnpj = '".$cnpj."', perfil = '".$perfil."', forma_pagamento = '".$forma_pagamento."'where id_empresa =".$id_empresa;
        if(mysqli_query($con,$query)){
            echo "Empresa Alterada com sucesso";
        }else{
            echo "Erro ao Alterar o dado: <br>";
            echo mysqli_error($con);
            echo "<br>Contate o Suporte";
        }   
    }
?>
