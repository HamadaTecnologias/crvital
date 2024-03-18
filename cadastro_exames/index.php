<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
        <br>
        <br>
        <br> 
    <?php 
        //RECEBENDO VARIAVEL ID_EMPRESA DO SELECT PHP_SELF
        $id_empresa= $_GET['id_empresa']??null;
        include 'bd_connect.php';
    ?>
        <!-- SELETOR DE EMPRESAS -->
        <form action="<?=$_SERVER['PHP_SELF']?>" method="get">
            <select name="id_empresa" id="id_empresa" required>
                <option value="">Selecione uma empresa</option>
                <?php
                    $query="select id_empresa,nome_empresa from empresa ORDER BY nome_empresa ASC";
                    $empresas = mysqli_query($con,$query);
                    while($linha = mysqli_fetch_assoc($empresas)){?>
                        <option value="<?=$linha['id_empresa'];?>"><?=$linha['nome_empresa'];?></option>
                  <?php } ?>  
            </select>
            <button type="submit" value="selecionar">Selecionar</button>             
        </form>

        <br>
        <br>
        <br>

        <?php 
            // RECEBENDO VALORES PARA ALTERAR
            $id_procedimento = $_GET['id_procedimento']??null;
            $alterar['nome_procedimento']=null;
            $alterar['valor']=null;
            if ($id_procedimento !=null) {
                $query="select nome_procedimento,valor from procedimento where id_procedimento=".$id_procedimento;
                $procedimento_para_alterar = mysqli_query($con,$query);
                $alterar = mysqli_fetch_assoc($procedimento_para_alterar);
            }
        ?>
        <!-- FORM PARA INSERIR E CONFIRMAR ALTERAÇÃO -->
        <form action="procedimentos.php" method="post">
            <input style="visibility:hidden" name="id_procedimento" id="id_procedimento" type="number" value="<?=$id_procedimento?>">
            <input style="visibility:hidden" name="id_empresa" id="id_empresa" type="number" value="<?=$id_empresa?>"><br>
            <label for="nome_procedimento">Procedimento:</label>
            <input name="nome_procedimento" id="nome_procedimento" type="text" value="<?=$alterar['nome_procedimento']?>">
            <label for="Valor">Valor:</label>
            <input name="valor" id="valor" type="text" value="<?=$alterar['valor']?>">
            <br>
            <br>
            <button type="submit" value="inserir">Inserir</button>
            <button type="submit" value="alterar">Confirmar Alteração</button>
        </form>

        <br>
        <br>
        <br>


        <!-- VERSÃO 2 DA EXIBIÇÃO DE PROCEDIMENTOS -->
        <?php 
            if ($id_empresa!=null) {
                // DESCOBRINDO NOME DA EMPRESA
                $query_empresa="select nome_empresa from empresa where id_empresa=".$id_empresa;
                $n_empresa = mysqli_query($con,$query_empresa);
                $linha_empresa = mysqli_fetch_assoc($n_empresa);
                echo"A Empresa ".$linha_empresa['nome_empresa']." está selecionada <br>";
                //BUSCANDO PROCEDIMENTOS DA EMPRESA
                $query = "select id_procedimento,nome_procedimento,valor from procedimento where id_empresa=".$id_empresa;
                $procedimentos = mysqli_query($con,$query);?>
                <table>
                    <thead>
                        <tr>
                        <th scope="col">Procedimento</th>
                        <th scope="col">Valor</th>
                        <th scope="col">Apagar</th>
                        <th scope="col">Alterar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($linha = mysqli_fetch_assoc($procedimentos)){ ?>
                            <tr>
                            <td scope="row">
                                <?= $linha['nome_procedimento']; ?>
                            </td>
                            <td>
                                <?=$linha['valor']; ?>
                            </td>
                            <td>
                                <a href='apagar.php?id_procedimento=<?= $linha['id_procedimento']?>'>Apagar</a>
                            </td>
                            <td>
                                <a href='index.php?id_procedimento=<?=$linha['id_procedimento']?>&id_empresa=<?=$id_empresa?>'>Alterar</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>

        <?php 
            } 
            mysqli_close($con);
        ?>

</body>
</html>


