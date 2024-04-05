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
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/logo-favicon.png" type="image/x-icon">
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
                            </span>
                        </button>
                    </a>
                <?php } ?>

                <?php if($nivel != 'F') { ?>
                    <a href="../cadastro_exames/pagina_principal.php">
                    <button class="sidebar-nav-button">
                        <span style="background: #61CE70;">
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
    width: 400px ;
}
.confirm a{
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
        //RECEBENDO VARIAVEL ID_EMPRESA DO SELECT PHP_SELF
        $id_empresa= $_GET['id_empresa']??null;
        include "../bd_connect.php";
        //RECEBENDO DADOS DE ERROS
        $valor_error = $_GET['valor']??null;
        $nome_error = $_GET['nome']??null;
        $apagar = $_GET['apagar']??false;
        $id_procedimento = $_GET['id_procedimento']??null;
        $atualizado = $_GET['atualizado']??null;
        $cadastrado = $_GET['cadastrado']??null;
        $excluido = $_GET['excluido']??null;
        $existe = $_GET['existe']??null;
    ?>


    <main class="main">
        <?php 
        if ($existe!= false) {?>
            <h3 style="text-align:center;padding:4px;background-color:#9b1a2e;color:white;border-radius:8px;">Procedimento Já Cadastrado</h3>
        <?php } ?> 
        <?php 
        if ($excluido!= false) {?>
            <h3 style="text-align:center;padding:4px;background-color:#9b1a2e;color:white;border-radius:8px;">Procedimento Excluido Com Sucesso</h3>
        <?php } ?> 
        <?php 
        if ($cadastrado != false) {?>
            <h3 style="text-align:center;padding:4px;background-color:#9b1a2e;color:white;border-radius:8px;">Procedimento Cadastrado Com Sucesso</h3>
        <?php } ?> 
        <?php 
        if ($atualizado != false) {?>
            <h3 style="text-align:center;padding:4px;background-color:#9b1a2e;color:white;border-radius:8px;">Procedimento Atualizado Com Sucesso</h3>
        <?php } ?> 
        <?php 
        if ($valor_error != false) {?>
            <h3 style="text-align:center;padding:4px;background-color:#9b1a2e;color:white;border-radius:8px;">Digite um Valor</h3>
        <?php } ?> 

       <?php 
        if ($nome_error != false) {?>
            <h3 style="text-align:center;padding:4px;background-color:#9b1a2e;color:white;border-radius:8px;">Digite o Procedimento</h3>
       <?php } ?> 

       <?php 
        if ($apagar != false) {?>
        <div class="confirmar_exclusao">            
            <h3>Deseja confirmar exclusão do procedimento?</h3>
            <div class="confirm">
                <a href='apagar.php?id_procedimento=<?= $id_procedimento?>&id_empresa=<?=$id_empresa?>'>SIM</a>
                <a href='pagina_principal.php?id_empresa=<?=$id_empresa?>'>NÃO</a>
            </div>
        </div>
        <?php } ?> 

            <!-- SELETOR DE EMPRESAS -->
        <div class="forms">
            <div class="seletor-empresa">
            <form action="<?=$_SERVER['PHP_SELF']?>" method="get">
                <select name="id_empresa" id="id_empresa" required>
                    <option value="">Selecione uma Empresa</option>
                    <?php
                        $query="select id_empresa,nome_empresa,cnpj from empresa ORDER BY nome_empresa ASC";
                        $empresas = mysqli_query($con,$query);
                        while($linha = mysqli_fetch_assoc($empresas)){
                            $cnpj_select = formatCnpjCpf($linha['cnpj']) ;?>
                            <option value="<?=$linha['id_empresa'];?>"><?=$linha['nome_empresa']." CNPJ: ".$cnpj_select;?></option>
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
                <button type="submit" name="alterar" value="true">Confirmar Alteração</button>
            </form> 
            </div>   
        </div>

            <!-- VERSÃO 2 DA EXIBIÇÃO DE PROCEDIMENTOS -->
            <?php 
                if ($id_empresa!=null) {
                    // DESCOBRINDO NOME DA EMPRESA
                    $query_empresa="select nome_empresa,cnpj from empresa where id_empresa=".$id_empresa;
                    $n_empresa = mysqli_query($con,$query_empresa);
                    $linha_empresa = mysqli_fetch_assoc($n_empresa); 
                    //BUSCANDO PROCEDIMENTOS DA EMPRESA
                    $query = "select id_procedimento,nome_procedimento,valor from procedimento where id_empresa=".$id_empresa." ORDER BY nome_procedimento ASC";
                    $procedimentos = mysqli_query($con,$query);
                    $cnpj = formatCnpjCpf($linha_empresa['cnpj']) ;
                    ?>
                
                <div class="exibicao">
                <h3><?=$linha_empresa['nome_empresa']?></h3>
                <h3><?=$cnpj?></h3>
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
                                    <a href='pagina_principal.php?apagar=true&id_procedimento=<?= $linha['id_procedimento']?>&id_empresa=<?=$id_empresa?>'>
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
<?php 
function formatCnpjCpf($value){
    $CPF_LENGTH = 11;
    $cnpj_cpf = preg_replace("/\D/", '', $value);
    if (strlen($cnpj_cpf) === $CPF_LENGTH) {
        return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf);
    } 
    return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
}
?>
</body>
</html>


