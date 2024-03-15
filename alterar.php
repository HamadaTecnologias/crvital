<?php 


    include 'bd_connect.php';
    $id_empresa = $_GET['id_empresa'];


    $query="select nome_empresa,cnpj from empresa where id_empresa=".$id_empresa;
    $empresa = mysqli_query($con,$query);
    $linha = mysqli_fetch_assoc($empresa);


?>


    <h1>Alterar Dados Empresa</h1>
    <form action="confirmar_alteracao.php" method="post">
        <B>Dados Cadastrados</B><br>
            <input type="text" name="id_empresa" value=<?php echo $id_empresa?> > <br>
            <input type="text" name="nome_empresa" value=<?php echo $linha['nome_empresa'] ?>> <br>
            <input type="text" name="cnpj" value=<?php echo $linha['cnpj'] ?>> <br>
        <B>Perfil</B><br>
            <input type=radio name=perfil value="credenciamento"> Credenciamento
            <input type=radio name=perfil value="faturamento"> Faturamento
            <input type=radio name=perfil value="gestao"> Gestão
            <input type=radio name=perfil value="avulso"> Avulso
        <br><B>Metodo de Pagamento<B><br>
            <select name=forma_pagamento>
            <option value=dinheiro>Dinheiro</option>
            <option value=boleto>Boleto</option>
            <option value=faturado>Faturamento</option>
            <option value=credito>Crédito em conta</option>
            <option value=null>Avulso</option>
            </select>
        <br>
        <br>
        <input type="submit" value="alterar">
    </form>