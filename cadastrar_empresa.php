<?php 

$nome_empresa = $_POST["nome_empresa"];
$cnpj= $_POST["cnpj"];
$perfil= $_POST["perfil"];
$metodo_pagamento= $_POST["metodo_pagamento"];
$erro = FALSE;


include 'bd_connect.php';

echo"<br>";
echo"<br>";

    if(strlen($cnpj)!=14)
        {echo "O CNPJ deve possuir 14 números <br>"; $erro=TRUE;}
    if(empty($nome_empresa))
        {echo "Digite a Razão Social corretamente. <br>"; $erro=TRUE;}
    if(empty($perfil))
        {echo "Selecione ao menos um perfil de credenciamento. <br>"; $erro=TRUE;}
    if(!$erro)
        {echo "Todos os dados foram digitados corretamente! <br>";}

    $query = "insert into empresa(nome_empresa,cnpj,perfil,forma_pagamento,status) values ('".$nome_empresa."','".$cnpj."','".$perfil."','".$metodo_pagamento."','".true."')";

    if(mysqli_query($con,$query)){
        echo "Empresa Cadastrada com sucesso";
    }else{
        echo"Erro ao cadastrar Empresa";
    }
    

    mysqli_close($con);
?>