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
    <link rel="stylesheet" href="../assets/css/atendimento.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <title>Atendimentos</title>
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
                        <span style="background: #61CE70;">
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


                    <a href="../historico/pagina_principal.php">
                        <button class="sidebar-nav-button">
                            <span class="sidebar-nav-button-span">
                                <span class="sidebar-nav-button-span2">
                                    <img class="icons-main" src="../assets/history.png">Histórico
                                </span>
                            </span>
                        </button>
                    </a>

                    
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
            include "../bd_connect.php";
            //RECEBENDO VARIAVEL ID_EMPRESA DO SELECT PHP_SELF
            $id_empresa= $_GET['id_empresa']??null;
            $error_procedimento = $_GET['error_procedimento']??false;
            $apagar = $_GET['apagar']??false;
            $id_excluir = $_GET['id_excluir']??null;
        ?>
        <?php 
        if ($error_procedimento != false) {?>
            <h3 style="text-align:center;padding:4px;background-color:#9b1a2e;color:white;">Escolha ao menos um Procedimento</h3>
        <?php } ?>
        


        <main class="main"> 

        <?php 
        if ($apagar != false) {?>
        <div class="confirmar_exclusao">            
            <h3>Deseja confirmar exclusão do atendimento?</h3>
            <div class="confirm">
                <a href='../atendimento/deletar_atendimento.php?id_atendimento=<?=$id_excluir?>'>SIM</a>
                <a href="atendimento.php">NÃO</a>
            </div>
        </div>
        <?php } ?> 

            <!-- FORM DE SELECT DE EMPRESA -->
            <form action="<?=$_SERVER['PHP_SELF']?>" method="get">
                <select name="id_empresa" id="id_empresa" required>
                    <option value="">Selecione uma Empresa</option>
                    <?php
                        $query="SELECT id_empresa,nome_empresa,cnpj from empresa WHERE status=true ORDER BY nome_empresa ASC";
                        $empresas = mysqli_query($con,$query);
                        while($linha = mysqli_fetch_assoc($empresas)){
                            $cnpj_select = formatCnpjCpf($linha['cnpj']) ;?>
                            <option value="<?=$linha['id_empresa'];?>"><?=$linha['nome_empresa']." CNPJ: ".$cnpj_select;?></option>
                    <?php } ?>  
                </select>   
                <button type="submit" value="selecionar">Selecionar</button>           
            </form>
            <!--FIM FORM DE SELECT DE EMPRESA -->        
               
                <!-- IF PARA MOSTRAR CAMPOS CHECKIN -->
    <?php 

        if ($id_empresa!=null) {
                $query_empresa="select nome_empresa,cnpj,perfil,forma_pagamento from empresa where id_empresa=".$id_empresa;
                $dados_empresas = mysqli_query($con,$query_empresa);
                $linha_empresa = mysqli_fetch_assoc($dados_empresas); 
                $cnpj = formatCnpjCpf($linha_empresa['cnpj']) ;
                ?>
    
                
                <div class="checkin">
                
                    <div class="dados">
                    <!-- FORM DE CADASTRO DE ATENDIMENTO -->
                    <form action="cadastrar_atendimento.php" method="post">  
                    <!-- DADOS DA EMPRESA SELECIONADA  -->
                        <div class="empresa">
                            <div class="dados_1">
                                <input style="display:none" name="id_empresa" type="number" value="<?=$id_empresa?>">
                                <label for="nome_empresa">Empresa:</label>
                                <span><?=$linha_empresa['nome_empresa']?></span>
                                <label for="perfil">Perfil Credenciamento:</label>
                                <span><?=$linha_empresa['perfil']?></span>
                            </div>
                            <div class="dados_2">
                                <label for="cnpj">CNPJ:</label>
                                <span><?=$cnpj?></span>
                            <label for="forma_pagamento">Método de Pagamento:</label>
                            <select name="forma_pagamento" required>
                                <option value="<?=$linha_empresa['forma_pagamento']?>"><?=$linha_empresa['forma_pagamento']?></option>
                                <option value=Dinheiro>Dinheiro</option>
                                <option value=Boleto>Boleto</option>
                                <option value=Faturado>Faturamento</option>
                                <option value=Credito>Crédito em conta</option>
                            </select>
                        </div>               
                    </div>
                    <!-- FIM DADOS DA EMPRESA SELECIONADA  -->
                    <!-- DADOS ATENDIMENTO  -->
                    <div class="atendimento">
                        <div class="dados_atendimento">
                            <div class="colaborador">
                                <label for="nome_paciente">Colaborador:</label>
                                <input placeholder="Digite o nome do Colaborador" name="nome_paciente" type="text" required value="">
                                <label for="telefone">Telefone:</label>
                                <input placeholder="DDD + número" name="telefone" type="text" required value="">
                            </div>
                            <div class="select_dados">    
                            <label for="tipo_exame">Tipo Exame:</label>
                            <select name=tipo_exame required>
                                <option value="">Selecione um tipo de Exame</option>
                                <option value=Admissional>Admissional</option>
                                <option value=Demissional>Demissional</option>
                                <option value=Monitoramento%Pontual>Monitoramento Pontual</option>
                                <option value=Mudança%de%Risco%Ocupacional>Mudança de Risco Ocupacional</option>
                                <option value=Periódico>Periódico</option>
                                <option value=Retorno%ao%Trabalho>Retorno ao Trabalho</option>
                            </select>
                            <label for="id_medico">Médico Examinador:</label>
                            <select name="id_medico" id="id_medico" required>
                                <option value="">Selecione um Profissional</option>
                                <?php
                                    $query="select id_medico,nome_medico from medico ORDER BY nome_medico ASC";
                                    $medicos = mysqli_query($con,$query);
                                    while($linha = mysqli_fetch_assoc($medicos)){?>
                                        <option value="<?=$linha['id_medico'];?>"><?=$linha['nome_medico'];?></option>
                                <?php } ?>  
                            </select>
                            </div>
                            <div class="data_atendimento">
                                <input name="data_atendimento" type="date" value="0000-00-00" required />
                                <span class="validity"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- FIM DADOS ATENDIMENTO  -->
                    <?php 
                        if ($id_empresa!=null) {
                        $query="SELECT id_procedimento,nome_procedimento from procedimento WHERE id_empresa=".$id_empresa." ORDER BY nome_procedimento ASC";
                        $resultado = mysqli_query($con,$query);?>
                <!-- SELEÇÃO PROCEDIMENTOS  -->
                <div class="procedimentos">
                    <table>
                    <thead>
                        <tr>
                        <th scope="col">Procedimentos</th>
                        <th scope="col">Adicionar</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        while($procedimento = mysqli_fetch_assoc($resultado)){?>
                        <tr>
                        <td><label for="id_procedimento"><?=$procedimento['nome_procedimento']?></label></td>
                        <td><input type="checkbox" name="id_procedimento[]" value="<?=$procedimento['id_procedimento']?>"></td>
                        </tr>     
                        <?php } ?>  
                        <?php } ?> 
                    </tbody>
                    </table>
                </div>
                <!-- FIM SELEÇÃO PROCEDIMENTOS  -->
            </div>
             <!-- FIM DIV CHECKIN  -->
            <div class="button">
                    <button type="submit" value="cadastrar">Iniciar Atendimento</button>
            </div>
            </form>
             <!-- FIM DO FORM DE CHECK-IN -->
<?php }?>
<!-- FIM IF PARA MOSTRAR CAMPOS CHECKIN -->

<!-- ATENDIMENTOS ATIVOS -->
            <div class="atendimentos_ativos">
            <?php 
            $query_ativos = "SELECT A.id_atendimento,A.nome_paciente,A.tipo_exame,A.hora_checkin,M.nome_medico,E.nome_empresa 
            FROM atendimento A
            INNER JOIN medico M ON A.id_medico = M.id_medico 
            INNER JOIN empresa E ON A.id_empresa = E.id_empresa 
            WHERE A.hora_checkout='00:00'
            ORDER BY A.hora_checkin ASC";
            $result = mysqli_query($con,$query_ativos);?>
            <table>
                <thead>
                    <tr>
                    <th scope="col">Empresa</th>
                    <th scope="col">Colaborador</th>
                    <th scope="col">Médico Examinador</th>
                    <th scope="col">Exame</th>
                    <th scope="col">Check-in</th>
                    <th scope="col">Finalizar</th>
                    <th scope="col">Editar</th>
                    <th scope="col">Excluir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($consulta = mysqli_fetch_assoc($result)){ ?>
                        <tr>
                            <td>
                                <?= $consulta['nome_empresa']; ?>
                            </td>
                            <td>
                                <?= $consulta['nome_paciente']; ?>
                            </td>
                            <td>
                            <?= $consulta['nome_medico']; ?>
                            </td>
                            <td>
                                <?= $consulta['tipo_exame']; ?>
                            </td>
                            <td>
                            <?= $consulta['hora_checkin']; ?>
                            </td>
                            <td>
                            <a href='cadastrar_atendimento.php?finalizar=true&id_atendimento=<?= $consulta['id_atendimento']; ?>'>FINALIZAR</a>
                            </td>
                            <td>
                            <a href='../historico/editar_atendimento.php?id_atendimento=<?=$consulta['id_atendimento'];?>'>EDITAR</a>
                            </td>
                            <td>
                            <a href='atendimento.php?apagar=true&id_excluir=<?=$consulta['id_atendimento']?>'>EXCLUIR</a>
                            </td>
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
<script>
    $(document).ready(function() {
        $('#id_empresa').select2();
    });
</script>
<script src="https://kit.fontawesome.com/122585f6ab.js" crossorigin="anonymous"></script>
<?php 
//FUNÇÃO PARA FORMATAR CNPJ
        function formatCnpjCpf($value){
            $CPF_LENGTH = 11;
            $cnpj_cpf = preg_replace("/\D/", '', $value);
            if (strlen($cnpj_cpf) === $CPF_LENGTH) {
                return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf);
            } 
            return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
        }
//FIM FUNÇÃO PARA FORAMTAR CNPJ
?>
</body>
</html>