<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Empresas</title>
</head>
<body>

    <?php
        //Recebendo dados para alterar 
        include 'bd_connect.php';
        $id_empresa = $_GET['id_empresa']??null;
        $alterar['nome_empresa']=null;
        $alterar['cnpj']=null;
        if ($id_empresa !=null) {
            $query="select nome_empresa,cnpj from empresa where id_empresa=".$id_empresa;
            $empresa = mysqli_query($con,$query);
            $alterar = mysqli_fetch_assoc($empresa);
        }

    ?>
    <h1>Cadastro Empresas</h1>
        <form action="manipular_empresa.php" method="post">
            <input style="visibility:hidden" name="id_empresa" id="id_empresa" type="number" value="<?=$id_empresa?>"><br>
            <label for="nome_empresa">Razão Social:</label>
            <input name="nome_empresa" id="nome_empresa" type="text" value="<?=$alterar['nome_empresa']?>">
            <label for="cnpj">CNPJ:</label>
            <input name="cnpj" id="cnpj" type="text" value="<?=$alterar['cnpj']?>">
            <br>
            <br>
            <B>Perfil</B><br>
            <input type=radio name=perfil value="credenciamento"> Credenciamento
            <input type=radio name=perfil value="faturamento"> Faturamento
            <input type=radio name=perfil value="gestao"> Gestão
            <input type=radio name=perfil value="avulso"> Avulso
            <br>
            <br>
            <B>Forma de Pagamento<B><br>
            <select name=forma_pagamento required>
            <option value="">Selecione a Forma de Pagamento</option>
            <option value=dinheiro>Dinheiro</option>
            <option value=boleto>Boleto</option>
            <option value=faturado>Faturamento</option>
            <option value=credito>Crédito em conta</option>
            <option value=null>Avulso</option>
            </select>
            <br>
            <br>
            <br>
            <button type="submit" value="cadastrar">cadastrar</button>
            <button type="submit" value="<?=$id_empresa?>">confirmar alteração</button>
        </form>
        <br>
        <br>
        <br>

    <?php 
            //Exibindo Empresas na tela
            echo"<br>";
            $query = "select id_empresa,nome_empresa,status from empresa";
            $empresas = mysqli_query($con,$query);?>
            <table>
                <thead>
                    <tr>
                    <th scope="col">Razão Social</th>
                    <th scope="col">Apagar</th>
                    <th scope="col">Alterar</th>
                    <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($linha = mysqli_fetch_assoc($empresas)){ ?>
                        <tr>
                            <td>
                                <?= $linha['nome_empresa']; ?>
                            </td>
                            <td>
                                <a href='apagar.php?id_empresa=<?= $linha['id_empresa']?>'>Apagar</a>
                            </td>
                            <td>
                                <a href='pagina_principal.php?id_empresa=<?=$linha['id_empresa']?>'>Alterar</a>
                            </td>
                            <?php if($linha['status'] != false){?>
                                <td>
                                    <p>Liberado  </p>
                                </td> 
                                <td>
                                    <a href='bloquear.php?id_empresa=<?= $linha['id_empresa']?>'>Bloquear</a>
                                </td>
                            <?php }else{ ?>
                                <td>  
                                <p>Bloqueado  </p>
                                </td>
                                <td>
                                <a href='liberar.php?id_empresa=<?= $linha['id_empresa']?>'>Liberarr</a>
                                </td>
                            <?php } ?>   
                        </tr>
                    <?php } 
                        mysqli_close($con);
                    ?>   
</body>
</html>