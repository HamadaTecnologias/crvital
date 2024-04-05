<?php 

    //variáveis dos dados dos procedimentos
    $id_empresa=$_POST["id_empresa"]??null;
    $id_procedimento=$_POST["id_procedimento"]??null;
    $nome_procedimento = $_POST["nome_procedimento"];
    $valor= $_POST["valor"];
    $erro = FALSE;
    $alterar = $_POST['alterar']??false;
    include "../bd_connect.php";
    //tratar dados inseridos
    if(empty($nome_procedimento)){
        header('location:pagina_principal.php?nome=true');
        $erro=TRUE;
    }

    if(empty($valor)){
        header('location:pagina_principal.php?valor=true');
        $erro=TRUE;
    }

    //criando array com os ids dos procedimentos
    $query_valid="select id_procedimento from procedimento";
    $procedimento = mysqli_query($con,$query_valid);
    $ids = array();
    while($linha = mysqli_fetch_assoc($procedimento)){
        array_push($ids,$linha['id_procedimento']);
    }
    if ($alterar == false) {
        //TRATANDO PROCEDIMENTOS COM O MESMO NOME
        $query_procedimento_cadastrado = "SELECT id_procedimento,nome_procedimento FROM procedimento WHERE nome_procedimento='".$nome_procedimento."'";
        $result_procedimento_cadastrado = mysqli_query($con,$query_procedimento_cadastrado);
        $procedimento_cadastrado = mysqli_fetch_assoc($result_procedimento_cadastrado);
        if (!empty($procedimento_cadastrado['id_procedimento'])) {
            $erro=TRUE;
            header('location:pagina_principal.php?existe=true&id_empresa='.$id_empresa);
        }
        
        if (!empty($procedimento_cadastrado['nome_procedimento'])) {
            $erro=TRUE;
            header('location:pagina_principal.php?existe=true&id_empresa='.$id_empresa);
        }
        // FIM TRATANDO PROCEDIMENTOS COM O MESMO NOME
    }



    if(!$erro){
        //fazendo busca nos arrays de ids para saber se vamos alterar um procedimento ou cadastrar um novo
        if (in_array($id_procedimento, $ids)) {
            $query = "update procedimento set nome_procedimento ='".$nome_procedimento."', valor = '".$valor."'where id_procedimento =".$id_procedimento;
            if(mysqli_query($con,$query)){
                header('location:pagina_principal.php?atualizado=true&id_empresa='.$id_empresa);
            }else{
                echo "Erro ao Alterar Procedimento: <br>";
                echo mysqli_error($con);
                echo "<br>Contate o Suporte";
            }   
        }else{
            $query = "insert into procedimento(nome_procedimento,valor,id_empresa) values ('".$nome_procedimento."','".$valor."','".$id_empresa."')";
            if(mysqli_query($con,$query)){
                header('location:pagina_principal.php?cadastrado=true&id_empresa='.$id_empresa);
            }else{
            echo"Erro ao cadastrar Procedimento<br>";
            echo mysqli_error($con);
            echo "<br>Contate o Suporte";
            }   
        }
    }
    mysqli_close($con);
?>