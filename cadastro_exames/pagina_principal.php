<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/crvital-logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/minoro-sidebar.css">
    <link rel="stylesheet" href="../assets/css/exames.css"> 
    <title>CrVital - Procedimentos</title>
</head>
<body>
    <aside class="sidebar">
        <header class="sidebar-header">
            <button class="sidebar-header-button">
                <span class="sidebar-header-button-span">
                    <a href="logout.php"><img class="logout-icon" src="../assets/logout-icon.png"></a>
                </span>
            </button>
        </header>
        <img class="img-logo" src="../assets/crvital-logo.svg">
        <nav class="sidebar-nav">
            
            <button class="sidebar-nav-button">
                <span class="sidebar-nav-button-span">
                    <a href="#"><img class="icons-main" src="../assets/user-icon.png">
                    <span class="sidebar-nav-button-span2">
                        Usuários
                    </span>
                    </a>
                </span>
             </button>

             <button class="sidebar-nav-button">
                <span class="sidebar-nav-button-span">
                    <a href="#"><img class="icons-main" src="../assets/calendar.png">
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
                    <a href="#"><img class="icons-main" src="../assets/doctor.png">
                    <span class="sidebar-nav-button-span2">
                        Médicos
                    </span>
                    </a>
                </span>
             </button>

             <button class="sidebar-nav-button">
                <span class="sidebar-nav-button-span">
                    <a href="#"><img class="icons-main" src="../assets/report.png">
                    <span class="sidebar-nav-button-span2">
                        Relatórios
                    </span>
                    </a>
                </span>
             </button>
        </nav>
    </aside>

    <main class="main">
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
                                    <a href='apagar.php?id_procedimento=<?= $linha['id_procedimento']?>'>
                                    <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href='pagina_principal.php?id_procedimento=<?=$linha['id_procedimento']?>&id_empresa=<?=$id_empresa?>'>
                                    <i class="fa-solid fa-rotate"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
            <?php 
                } 
                mysqli_close($con);
            ?>
    </main>
    <script src="https://kit.fontawesome.com/122585f6ab.js" crossorigin="anonymous"></script>
</body>
</html>


