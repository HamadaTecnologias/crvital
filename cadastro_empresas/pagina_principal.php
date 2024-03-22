<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/crvital-logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/sidebar.css">
    <link rel="stylesheet" href="../assets/css/empresa.css">
    <title>CrVital - Empresas</title>
</head>
<body>
<aside class="sidebar">
        <header class="sidebar-header">
            <button class="sidebar-header-button">
                <span class="sidebar-header-button-span">
                    <a href="../login/logout.php"><img class="logout-icon" src="../assets/logout-icon.png"></a>
                </span>
            </button>
        </header>
        <img class="img-logo" src="../assets/crvital-logo.svg">
        <nav class="sidebar-nav">
            
            <button class="sidebar-nav-button">
                <span class="sidebar-nav-button-span">
                    <a href="../usuario/admin.php"><img class="icons-main" src="../assets/user-icon.png">
                    <span class="sidebar-nav-button-span2">
                        Usuários
                    </span>
                    </a>
                </span>
             </button>

             <button class="sidebar-nav-button">
                <span class="sidebar-nav-button-span">
                    <a href="../atendimento/atendimento.php"><img class="icons-main" src="../assets/calendar.png">
                    <span class="sidebar-nav-button-span2">
                        Atendimentos
                    </span>
                    </a>
                </span>
             </button>

             <button class="sidebar-nav-button">
                <span class="sidebar-nav-button-span">
                    <a href="../cadastro_empresas/pagina_principal.php"><img class="icons-main" src="../assets/company.png">
                    <span class="sidebar-nav-button-span2">
                        Empresas
                    </span>
                    </a>
                </span>
             </button>

             <button class="sidebar-nav-button">
                <span class="sidebar-nav-button-span">
                    <a href="../cadastro_exames/pagina_principal.php"><img class="icons-main" src="../assets/stetoscope.png">
                    <span class="sidebar-nav-button-span2">
                        Procedimentos
                    </span>
                    </a>
                </span>
             </button>

             <button class="sidebar-nav-button">
                <span class="sidebar-nav-button-span">

                    <a href="../medico/doctor.php"><img class="icons-main" src="../assets/doctor.png">

                    <span class="sidebar-nav-button-span2">
                        Médicos
                    </span>
                    </a>
                </span>
             </button>

             <button class="sidebar-nav-button">
                <span class="sidebar-nav-button-span">
                    <a href="../relatorio/relatorio.php"><img class="icons-main" src="../assets/report.png">
                    <span class="sidebar-nav-button-span2">
                        Relatórios
                    </span>
                    </a>
                </span>
             </button>
        </nav>
    </aside>

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
    <?php 
        //RECEBENDO DADOS DE ERROS
        $cnpj_error = $_GET['cnpj']??null;
        $nome_error = $_GET['nome']??null;
        $perfil_error = $_GET['perfil']??null;
    ?>


    <main class="main">
    <?php 
        if ($cnpj_error != false) {?>
            <h3 style="padding:4px;background-color:#9b1a2e;color:white;border-radius:8px;">Confira os 14 números em CNPJ</h3>
       <?php } ?> 

       <?php 
        if ($nome_error != false) {?>
            <h3 style="padding:4px;background-color:#9b1a2e;color:white;border-radius:8px;">Digite a Razão Social</h3>
       <?php } ?> 

       <?php 
        if ($perfil_error != false) {?>
            <h3 style="padding:4px;background-color:#9b1a2e;color:white;border-radius:8px;">Por favor, selecione ao menos um perfil</h3>
       <?php } ?> 

    <h1>Cadastro Empresas</h1>
    <div class="painel">
    <form action="manipular_empresa.php" method="post">
        <div class="form">
            <div class="dados coluna">
            <input style="display:none" name="id_empresa" id="id_empresa" type="number" value="<?=$id_empresa?>"><br>
            <label for="nome_empresa">Razão Social:</label>
            <input placeholder="Digite a Razão Social" name="nome_empresa" id="nome_empresa" type="text" value="<?=$alterar['nome_empresa']?>"><br>
            <label for="cnpj">CNPJ:</label>
            <input placeholder="Digite o CNPJ sem pontos" name="cnpj" id="cnpj" type="text" value="<?=$alterar['cnpj']?>"><br>
            <B>Forma de Pagamento<B><br>
            <select name=forma_pagamento required>
            <option value="">Selecione a Forma de Pagamento</option>
            <option value=Dinheiro>Dinheiro</option>
            <option value=Boleto>Boleto</option>
            <option value=Faturado>Faturamento</option>
            <option value=Credito>Crédito em conta</option>
            <option value=null>Avulso</option>
            </select><br>
            </div>
            <div class="perfil">
            <label for="perfil">Perfil:</label><br>
            <input type=radio name=perfil value="credenciamento"> 
            <label for="perfil">Credenciamento</label><br>
            
            <input type=radio name=perfil value="faturamento"> 
            <label for="perfil">Faturamento</label><br>
            
            <input type=radio name=perfil value="gestao">
            <label for="perfil">Gestão</label><br>
            
            <input type=radio name=perfil value="avulso">
            <label for="perfil">Avulso</label> <br>
            </div>
        </div>
        <div class="button">
        <br>
        <button type="submit" value="cadastrar">Cadastrar</button>
        <button type="submit" value="<?=$id_empresa?>">Confirmar Alteração</button>
        </div>

        </form>

    <?php 
            //Exibindo Empresas na tela
            $query = "select id_empresa,nome_empresa,status from empresa";
            $empresas = mysqli_query($con,$query);?>
            <div class="exibicao">
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
                                <a href='apagar.php?id_empresa=<?= $linha['id_empresa']?>'><i class="fa-solid fa-trash-can"></i></a>
                            </td>
                            <td>
                                <a href='pagina_principal.php?id_empresa=<?=$linha['id_empresa']?>'><i class="fa-solid fa-rotate"></i></a>
                            </td>
                            <?php if($linha['status'] != false){?>
                                <td>
                                    <a href='bloquear.php?id_empresa=<?= $linha['id_empresa']?>'><i class="fa-solid fa-lock-open"></i></a>
                                </td>
                            <?php }else{ ?>
                                <td>
                                <a href='liberar.php?id_empresa=<?= $linha['id_empresa']?>'><i class="fa-solid fa-lock"></i></a>
                                </td>
                            <?php } ?>   
                        </tr>
            </div>
                    <?php } 
                        mysqli_close($con);
                    ?>   
    </div>
    </main>
    <script src="https://kit.fontawesome.com/122585f6ab.js" crossorigin="anonymous"></script>
</body>
</html>