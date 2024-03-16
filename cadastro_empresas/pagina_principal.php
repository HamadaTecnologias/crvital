<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Empresas</title>
</head>
<body>

    <?php 
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
            <select name=forma_pagamento>
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
        echo"<br>";
        $query = "select id_empresa,nome_empresa,status from empresa";
        $empresas = mysqli_query($con,$query);
        while($linha = mysqli_fetch_assoc($empresas)){
            echo "<tr>";
            echo "<td>"."Razão Social: "  .$linha['nome_empresa'].  " </td> ";
            echo "<td>"."<a href='apagar.php?id_empresa=".$linha['id_empresa']."'>Apagar</a>". " </td> ";
            echo "<td>"."<a href='pagina_principal.php?id_empresa=".$linha['id_empresa']."'>Alterar</a> </td>";
            if($linha['status'] != false){
                echo"Liberado";
                echo "<a href='bloquear.php?id_empresa=".$linha['id_empresa']."'>Bloquear</a><br>";
            }else{ 
                echo"Bloqueado";
                echo "<a href='liberar.php?id_empresa=".$linha['id_empresa']."'>Liberar</a><br>";
            } 
            echo"</tr>";
        }
        mysqli_close($con);
    ?>



</body>
</html>