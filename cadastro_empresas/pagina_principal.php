<?php
    session_start();
    $user_input = $_SESSION['usuario'];
    $nome_usuario = $_SESSION['name'];
    $nivel = $_SESSION['nivel'];

    if (!isset($_SESSION['usuario'])){
        header('Location:../index.php?erro_login_access=true');
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/crvital-logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/sidebar.css">
    <link rel="stylesheet" href="../assets/css/empresa.css">
    <title>Empresas</title>
</head>
<body>
<aside class="sidebar">
            <header class="sidebar-header">
                <img class="img-logo" src="../assets/logo-crvital.png">
            </header>
            
            <nav class="sidebar-nav">
                <?php if($nivel != 'R' && $nivel != 'F') { ?>
                    <a href="../usuario/admin.php">
                        <button class="sidebar-nav-button">
                            <span class="sidebar-nav-button-span">
                                <span class="sidebar-nav-button-span2">
                                    <img class="icons-main" src="../assets/user-icon.png">Usuários
                                </span>
                            </span>
                        </button>
                    </a>
                <?php } ?>
                <?php if($nivel != 'F') { ?>
                    <a href="../cadastro_empresas/pagina_principal.php">
                        <button class="sidebar-nav-button">
                            <span class="sidebar-nav-button-span">
                                <span class="sidebar-nav-button-span2">
                                    <img class="icons-main" src="../assets/company.png">Empresas
                                </span>
                            </span>
                        </button>
                    </a>
                <?php } ?>
                    
                <?php if($nivel != 'F') { ?>
                    <a href="../atendimento/atendimento.php">
                        <button class="sidebar-nav-button">
                            <span class="sidebar-nav-button-span">
                                <span class="sidebar-nav-button-span2">
                                    <img class="icons-main" src="../assets/calendar.png">Atendimentos
                                </span>
                                <i class="atual fa-solid fa-location-dot"></i>
                            </span>
                        </button>
                    </a>
                <?php } ?>

                <?php if($nivel != 'F') { ?>
                    <a href="../cadastro_exames/pagina_principal.php">
                        <button class="sidebar-nav-button">
                            <span class="sidebar-nav-button-span">
                                <span class="sidebar-nav-button-span2">
                                    <img class="icons-main" src="../assets/stetoscope.png">Procedimentos
                                </span>
                            </span>
                        </button>
                    </a>
                <?php } ?>

                <?php if($nivel != 'F') { ?>
                    <a href="../medico/doctor.php">
                        <button class="sidebar-nav-button">
                            <span class="sidebar-nav-button-span">
                                <span class="sidebar-nav-button-span2">
                                    <img class="icons-main" src="../assets/doctor.png">Médicos
                                </span>
                            </span>
                        </button>
                    </a>
                <?php } ?>

                <?php if($nivel != 'R') { ?>
                    <a href="../relatorio/relatorio.php">
                        <button class="sidebar-nav-button">
                            <span class="sidebar-nav-button-span">
                                <span class="sidebar-nav-button-span2">
                                    <img class="icons-main" src="../assets/report.png">Relatórios
                                </span>
                            </span>
                        </button>
                    </a>
                <?php } ?>
                    
                <a href="../login/logout.php">
                    <button class="sidebar-nav-button">
                        <span class="sidebar-nav-button-span">
                            <span class="sidebar-nav-button-span2">
                                <img class="icons-main" src="../assets/logout-icon.png">Logout
                            </span>
                        </span>
                    </button>
                </a>
                <p style="margin-top:10px; margin-bottom:10px; color:white;"><strong>Usuário:</strong> <?=$nome_usuario?></p>
            </nav>
            
        </aside>
<style>
.confirmar_exclusao{
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background-color:rgba(102, 102, 102, 0.37);
    border: 0.8px solid black;
    border-radius: 4px;
    padding: 15px;
    gap: 5px;
}
.confirmar_exclusao a{
    display: inline-block; 
    text-decoration: none;
    background-color: var(--red-logo);
    border-radius: 8px;
    padding: 5px; 
    color: white;
    max-width: 100%; 
    box-sizing: border-box; 
}
</style>

    <?php
        //Recebendo dados para alterar 
        include "../bd_connect.php";
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
        $apagar = $_GET['apagar']??false;
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
        <?php 
        if ($apagar != false) {?>
        <div class="confirmar_exclusao">            
            <h3>Deseja confirmar exclusão da empresa?</h3>
            <a href='apagar.php?id_empresa=<?=$id_empresa?>'>CONFIRMAR</a>
        </div>
        <?php } ?> 

    <h1>Nova Empresa</h1>
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
            <label for="perfil">Perfil:</label>
            <label for="perfil">
            <input type=radio name=perfil value="credenciamento"> 
            Credenciamento
            </label>
            <label for="perfil">
            <input type=radio name=perfil value="faturamento">
            Faturamento 
            </label>
            <label for="perfil">
            <input type=radio name=perfil value="gestao">
            Gestão
            </label>
            <label for="perfil">
            <input type=radio name=perfil value="avulso">
            Avulso
            </label> 
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
                                <a href='pagina_principal.php?apagar=true&id_empresa=<?=$linha['id_empresa']?>'><i class="fa-solid fa-trash-can"></i></a>
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
                    <?php //FECHANDO WHILE
                        } 
                        mysqli_close($con);
                    ?>  
                </tbody>
            </table> 
            </div>
    </div>
    </main>
<script src="https://kit.fontawesome.com/122585f6ab.js" crossorigin="anonymous"></script>
</body>
</html>