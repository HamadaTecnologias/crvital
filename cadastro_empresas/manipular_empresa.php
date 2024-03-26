<?php 

    //variáveis dos dados das empresas
    $id_empresa=$_POST["id_empresa"]??null;
    $nome_empresa = $_POST["nome_empresa"];
    $cnpj= $_POST["cnpj"];
    $perfil= $_POST["perfil"];
    $forma_pagamento= $_POST["forma_pagamento"];
    $erro = FALSE;
    include "../bd_connect.php";

    //tratar dados inseridos
    if(strlen($cnpj)!=14){
        $erro=TRUE;
        header('location:pagina_principal.php?cnpj=true');
    }
    if(empty($nome_empresa)){
        $erro=TRUE;
        header('location:pagina_principal.php?nome=true');
    }
    if(empty($perfil)){
       $erro=TRUE;
        header('location:pagina_principal.php?perfil=true');
    }
    //criando array com os ids das empresas
    $query_valid="select id_empresa from empresa";
    $empresa = mysqli_query($con,$query_valid);
    $ids = array();
    while($linha = mysqli_fetch_assoc($empresa)){
        array_push($ids,$linha['id_empresa']);
    }


    if(!$erro){
        //fazendo busca nos arrays de ids para saber se vamos alterar uma empresa ou cadastrar uma nova
        if (in_array($id_empresa, $ids)) {
            $query = "update empresa set nome_empresa ='".$nome_empresa."', cnpj = '".$cnpj."', perfil = '".$perfil."', forma_pagamento = '".$forma_pagamento."'where id_empresa =".$id_empresa;
            if(mysqli_query($con,$query)){
                header('location:pagina_principal.php?alterado=true');
            }else{
                echo "Erro ao Alterar o dado: <br>";
                echo mysqli_error($con);
                echo "<br>Contate o Suporte";
            }   
        }else{
            $query = "insert into empresa(nome_empresa,cnpj,perfil,forma_pagamento,status) values ('".$nome_empresa."','".$cnpj."','".$perfil."','".$forma_pagamento."','".true."')";
            if(mysqli_query($con,$query)){
                header('location:pagina_principal.php?cadastro=true');
            }else{
            echo"Erro ao cadastrar Empresa<br>";
            echo mysqli_error($con);
            echo "<br>Contate o Suporte";
            }   
        }
    }
    mysqli_close($con);
?>