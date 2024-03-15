<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Empresas</title>
</head>
<body>


    <h1>Cadastro Empresas</h1>
        <form action="cadastrar_empresa.php" method="post">
            <label for="nome_empresa">Razão Social:</label>
            <input name="nome_empresa" id="nome_empresa" type="text">
            <label for="cnpj">CNPJ:</label>
            <input name="cnpj" id="cnpj" type="text">
    
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
            <button type="submit">cadastrar</button>
        </form>


<br>
<br>
<br>

    <?php 
        include 'bd_connect.php';
        echo"<br>";
        $query = "select id_empresa,nome_empresa,status from empresa";
        $empresas = mysqli_query($con,$query);
    
        while($linha = mysqli_fetch_assoc($empresas)){
            echo "Razão Social: "  .$linha['nome_empresa'].  " | ";
            echo "<a href='apagar.php?id_empresa=".$linha['id_empresa']."'>Apagar</a>". " | ";
            echo "<a href='alterar.php?id_empresa=".$linha['id_empresa']."'>Alterar</a> <br>";
            if($linha['status'] != false){
                echo"Liberado";
                echo "<a href='bloquear.php?id_empresa=".$linha['id_empresa']."'>Bloquear</a><br>";
            }else{ 
                echo"Bloqueado";
                echo "<a href='liberar.php?id_empresa=".$linha['id_empresa']."'>Liberar</a><br>";
            }
            
        }
    
        mysqli_close($con);
    
    ?>



</body>
</html>