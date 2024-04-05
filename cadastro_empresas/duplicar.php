<?php 
include "../bd_connect.php";
$id_empresa = $_GET['id_empresa'];
//DESCOBRINDO DADOS DA EMRPESA ORIGINAL
$query_empresa_original = 
"SELECT nome_empresa,cnpj,perfil,forma_pagamento
FROM empresa 
WHERE id_empresa=".$id_empresa;
$result_empresa_original = mysqli_query($con,$query_empresa_original);
$linha_dados_empresa= mysqli_fetch_assoc($result_empresa_original);
$nome_empresa_original = $linha_dados_empresa['nome_empresa'];
$nome_empresa_copia = $nome_empresa_original . " COPIA";
$cnpj_empresa_copia = $linha_dados_empresa['cnpj'];
$perfil_empresa_copia = $linha_dados_empresa['perfil'];
$pagamento_empresa_copia = $linha_dados_empresa['forma_pagamento'];
//FIM DESCOBRINDO DADOS DA EMPRESA ORIGINAL

// QUERY PARA INSERIR EMPRESA COPIADA
$query_inserir_copia = "INSERT INTO empresa(nome_empresa,cnpj,perfil,forma_pagamento,status) values ('".$nome_empresa_copia."','".$cnpj_empresa_copia."','".$perfil_empresa_copia."','".$pagamento_empresa_copia."','".true."')";
//FIM QUERY PARA INSERIR EMRPESA COPIADA

if(mysqli_query($con,$query_inserir_copia)){
    //QUERY PARA DESCOBRIR O ID DA EMPRESA COPIADA
    $query_id_empresa_copia = "SELECT id_empresa FROM empresa WHERE nome_empresa ='".$nome_empresa_copia."'";
    $result_id_empresa_copia = mysqli_query($con,$query_id_empresa_copia);
    $linha_id_empresa_copia = mysqli_fetch_assoc($result_id_empresa_copia);
    $id_empresa_copiada = $linha_id_empresa_copia['id_empresa'];
    //FIM QUERY PARA DESCOBRIR ID DA EMPRESA COPIADA

    //QUERY PARA BUSCAR OS PROCEDIMENTOS DA EMPRESA ORIGINAL
    $query_procedimentos = "SELECT nome_procedimento,valor FROM procedimento WHERE id_empresa=".$id_empresa;
    $result_procedimento = mysqli_query($con,$query_procedimentos);
    //FIM QUERY PARA BUSCAR OS PROCEDIMENTOS DA EMPRESA ORIGINAL

    //INSERINDO OS PROCEDIMENTOS DA EMRPESA ORIGINAL NA EMPRESA COPIADA
    while($linha_procedimento = mysqli_fetch_assoc($result_procedimento)){
        //QUERY PARA INSERIR PROCEDIMENTOS NA EMPRESA COPIADA
        $query_inserir_procedimento = "INSERT INTO procedimento(nome_procedimento,valor,id_empresa) values ('".$linha_procedimento['nome_procedimento']."','".$linha_procedimento['valor']."','".$id_empresa_copiada."')";
        mysqli_query($con,$query_inserir_procedimento);
    }
    //FIM DA INSERÇÃO DOS PROCEDIMENTOS NA EMPRESA COPIADA
    header('location:pagina_principal.php?copia=true');
}else{
echo"Erro ao cadastrar Empresa<br>";
echo mysqli_error($con);
echo "<br>Contate o Suporte";
}   






?>