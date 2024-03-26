<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/crvital-logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/sidebar.css">
    <link rel="stylesheet" href="../assets/css/exames.css"> 
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <title>Procedimentos</title>
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
        //RECEBENDO DADOS DE ERROS
        $valor_error = $_GET['valor']??null;
        $nome_error = $_GET['nome']??null;
    ?>


    <main class="main">
    <?php 
        if ($valor_error != false) {?>
            <h3 style="text-align:center;padding:4px;background-color:#9b1a2e;color:white;border-radius:8px;">Digite um Valor</h3>
       <?php } ?> 

       <?php 
        if ($nome_error != false) {?>
            <h3 style="text-align:center;padding:4px;background-color:#9b1a2e;color:white;border-radius:8px;">Digite o Procedimento</h3>
       <?php } ?> 
        <?php 
            //RECEBENDO VARIAVEL ID_EMPRESA DO SELECT PHP_SELF
            $id_empresa= $_GET['id_empresa']??null;
            include 'bd_connect.php';
        ?>
            <!-- SELETOR DE EMPRESAS -->
        <div class="forms">
            <div class="seletor-empresa">
            <form action="<?=$_SERVER['PHP_SELF']?>" method="get">
                <select name="id_empresa" id="id_empresa" required>
                    <option value="">Selecione uma Empresa</option>
                    <?php
                        $query="select id_empresa,nome_empresa from empresa ORDER BY nome_empresa ASC";
                        $empresas = mysqli_query($con,$query);
                        while($linha = mysqli_fetch_assoc($empresas)){?>
                            <option value="<?=$linha['id_empresa'];?>"><?=$linha['nome_empresa'];?></option>
                    <?php } ?>  
                </select>
                <br>
                <br>
                <button type="submit" value="selecionar">Selecionar</button>             
            </form>
            </div>
            

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
            <div class="dados-procedimentos">
            <form action="procedimentos.php" method="post">
                <input style="display:none" name="id_procedimento" id="id_procedimento" type="number" value="<?=$id_procedimento?>">
                <input style="display:none" name="id_empresa" id="id_empresa" type="number" value="<?=$id_empresa?>">
                <label for="nome_procedimento">Procedimento:</label><br>
                <input name="nome_procedimento" id="nome_procedimento" placeholder="Digite o Procedimento" type="text" value="<?=$alterar['nome_procedimento']?>"><br>
                <label for="Valor">Valor:</label><br>
                <input name="valor" id="valor" placeholder="Digite o Valor" type="text"  value="<?=$alterar['valor']?>"><br><br>
                <button type="submit" value="inserir">Inserir</button>
                <button type="submit" value="alterar">Confirmar Alteração</button>
            </form> 
            </div>   
        </div>

            <!-- VERSÃO 2 DA EXIBIÇÃO DE PROCEDIMENTOS -->
            <?php 
                if ($id_empresa!=null) {
                    // DESCOBRINDO NOME DA EMPRESA
                    $query_empresa="select nome_empresa from empresa where id_empresa=".$id_empresa;
                    $n_empresa = mysqli_query($con,$query_empresa);
                    $linha_empresa = mysqli_fetch_assoc($n_empresa); 
                    //BUSCANDO PROCEDIMENTOS DA EMPRESA
                    $query = "select id_procedimento,nome_procedimento,valor from procedimento where id_empresa=".$id_empresa;
                    $procedimentos = mysqli_query($con,$query);?>
                
                <div class="exibicao">
                <h3>A Empresa <?=$linha_empresa['nome_empresa']?> está selecionada</h3>
                <br>
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
                                    <?="R$ ".$linha['valor']; ?>
                                </td>
                                <td>
                                    <a href='apagar.php?id_procedimento=<?= $linha['id_procedimento']?>&id_empresa=<?=$id_empresa?>'>
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
                </div>
            <?php 
                } 
                mysqli_close($con);
            ?>
    </main>
    <script>
        $(document).ready(function() {
            $('#id_empresa').select2();
        });
    </script>
    <script src="https://kit.fontawesome.com/122585f6ab.js" crossorigin="anonymous"></script>
</body>
</html>


