<?php
    $id_medico = $_POST['id_medico'];
    $cadastrar = $_POST['cadastrar']??false;
    $nome_medico = $_POST["nome_medico"];
    $nis= $_POST["nis"];
    $sigla_conselho = $_POST["sigla_conselho"];
    $registro_conselho = $_POST["registro_conselho"];
    $categoria = $_POST["categoria"];
    $erro=FALSE;
    include "../bd_connect.php";

    if (empty($nome_medico)) {
        $erro=TRUE;
        header('location:doctor.php?nome=true');
    }
    if (empty($categoria)){
        $erro=TRUE;
        header('location:doctor.php?categoria=true');
    }

    $query_valid="select id_medico from medico";
    $medico = mysqli_query($con,$query_valid);
    $ids = array();
    while($linha = mysqli_fetch_assoc($medico)){
        array_push($ids,$linha['id_medico']);
    }

    //tratar médico com mesmo nome?
    // if ($cadastrar == true) {
    //     $query_medico_cadastrado = "SELECT id_medico,nome_medico from medico WHERE nome_medico like '%".$nome_medico."%'";
    //     $result_medico_cadastrado = mysqli_query($con,$query_medico_cadastrado);
    //     $medico_cadastrado = mysqli_fetch_assoc($result_medico_cadastrado);
    //     if (!empty($medico_cadastrado['id_medico'])) {
    //         $erro=TRUE;
    //         header('location:pagina_principal.php?existe=true');
    //     }
        
    //     if (!empty($medico_cadastrado['nome_medico'])) {
    //         $erro=TRUE;
    //         header('location:pagina_principal.php?existe=true');
    //     }
    // }

    if(!$erro){
        if (in_array($id_medico, $ids)) {
            $query = "update medico set nome_medico ='".$nome_medico."', nis = '".$nis."', sigla_conselho = '".$sigla_conselho."', registro_conselho = '".$registro_conselho."', categoria = '".$categoria."' where id_medico =".$id_medico;
            if(mysqli_query($con,$query)){
                header('location:doctor.php?alterado=true');
            }else{
                echo "Erro ao Alterar o dado: <br>";
                echo mysqli_error($con);
                echo "<br>Contate o Suporte";
            }   
        }else{
            $query = "insert into medico(nome_medico,nis,conselho,registro_conselho,categoria) values ('".$nome_medico."','".$nis."','".$conselho."','".$registro_conselho."','".$categoria."')";
            if(mysqli_query($con,$query)){
                header('location:doctor.php?cadastrado=true');
            }else{
                echo "Erro ao Cadastrar o dado: <br>";
                echo mysqli_error($con);
                echo "<br>Contate o Suporte";
            }
        }
    }







?>