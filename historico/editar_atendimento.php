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
    <link rel="stylesheet" href="../assets/css/editar_atendimento.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <title>Histórico</title>
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

                <?php if($nivel != 'R') { ?>
                    <a href="../historico/pagina_principal.php">
                        <button class="sidebar-nav-button">
                            <span style="background: #61CE70;">
                                <span class="sidebar-nav-button-span2">
                                    <img class="icons-main" src="../assets/history.png">Histórico
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

        <?php 
            include "../bd_connect.php";
            //RECEBENDO VARIAVEL ID ATENDIMENTO
            $id_atendimento = $_GET['id_atendimento'];           
        ?>
<main class="main"> 
                    
    <?php 

      
                $query_atendimento="SELECT A.data, A.nome_paciente, A.tipo_exame,A.id_empresa, E.nome_empresa,E.cnpj,E.perfil,A.metodo_pagamento,M.id_medico,M.nome_medico
                FROM atendimento A
                INNER JOIN atendimento_procedimento AP ON A.id_atendimento = AP.id_atendimento
                INNER JOIN procedimento P ON P.id_procedimento = AP.id_procedimento
                INNER JOIN empresa E ON E.id_empresa = A.id_empresa
                INNER JOIN medico M ON M.id_medico = A.id_medico
                WHERE A.id_atendimento = ".$id_atendimento;

                $result_atendimento = mysqli_query($con,$query_atendimento);
                $dados = mysqli_fetch_assoc($result_atendimento); 
                $cnpj = formatCnpjCpf($dados['cnpj']) ;
                ?>
    
                
                <div class="checkin">
                
                    <div class="dados">
                    <!-- FORM DE CADASTRO DE ATENDIMENTO -->
                    <form action="alterar_atendimento.php" method="post"> 
                    <input style="display:none" name="id_atendimento" type="number" value="<?=$id_atendimento?>">
                    <!-- DADOS DA EMPRESA SELECIONADA  -->
                        <div class="empresa">
                            <div class="dados_1">
                                <input style="display:none" name="id_empresa" type="number" value="<?=$dados['id_empresa']?>">
                                <label for="nome_empresa">Empresa:</label>
                                <span><?=$dados['nome_empresa']?></span>
                                <label for="perfil">Perfil Credenciamento:</label>
                                <span><?=$dados['perfil']?></span>
                            </div>
                            <div class="dados_2">
                                <label for="cnpj">CNPJ:</label>
                                <span><?=$cnpj?></span>
                                <label for="forma_pagamento">Método de Pagamento:</label>
                                <select name="forma_pagamento" required>
                                    <option value="<?=$dados['metodo_pagamento']?>"><?=$dados['metodo_pagamento']?></option>
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
                                <input placeholder="Digite o nome do Colaborador" name="nome_paciente" type="text" required value="<?=$dados['nome_paciente']?>">
                            </div>
                            <div class="select_dados">    
                            <label for="tipo_exame">Tipo Exame:</label>
                            <select name=tipo_exame required>
                                <option value="<?=$dados['tipo_exame']?>"><?=$dados['tipo_exame']?></option>
                                <option value=Admissional>Admissional</option>
                                <option value=Demissional>Demissional</option>
                                <option value=Monitoramento%Pontual>Monitoramento Pontual</option>
                                <option value=Mudança%de%Risco%Ocupacional>Mudança de Risco Ocupacional</option>
                                <option value=Periódico>Periódico</option>
                                <option value=Retorno%ao%Trabalho>Retorno ao Trabalho</option>
                            </select>
                            <label for="id_medico">Médico Examinador:</label>
                            <select name="id_medico" id="id_medico" required>
                                <option value="<?=$dados['id_medico']?>"><?=$dados['nome_medico']?></option>
                                <?php
                                    $query_medico="select id_medico,nome_medico from medico ORDER BY nome_medico ASC";
                                    $result_medico = mysqli_query($con,$query_medico);
                                    while($linha_medico = mysqli_fetch_assoc($result_medico)){?>                                   
                                        <option value="<?=$linha_medico['id_medico'];?>"><?=$linha_medico['nome_medico'];?></option>
                                <?php } ?>  
                            </select>
                            </div>
                            <div class="data_atendimento">
                                <input name="data_atendimento" type="date" value="<?=$dados['data']?>" required />
                                <span class="validity"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- FIM DADOS ATENDIMENTO  -->
                    <?php 
                            $query_procedimentos="SELECT id_procedimento,nome_procedimento from procedimento WHERE id_empresa=".$dados['id_empresa']." ORDER BY nome_procedimento ASC";
                            $result_procedimento = mysqli_query($con,$query_procedimentos);


                                    
                            $query_procedimento_cadastrado = "SELECT P.id_procedimento,P.nome_procedimento,P.valor 
                            FROM atendimento A
                            INNER JOIN atendimento_procedimento AP ON A.id_atendimento=AP.id_atendimento
                            INNER JOIN procedimento P ON P.id_procedimento=AP.id_procedimento
                            INNER JOIN empresa E ON E.id_empresa=P.id_empresa
                            WHERE A.id_atendimento=".$id_atendimento." ORDER BY P.nome_procedimento ASC";  
                            $result_procedimento_cadastrado = mysqli_query($con,$query_procedimento_cadastrado);

                            //CONTANDO QUANTOS PROCEDIMENTOS TEM CADASTRADOS NO ATENDIMENTO
                            $count_procedimento = array();
                            $query_count = "SELECT P.id_procedimento
                            FROM atendimento A
                            INNER JOIN atendimento_procedimento AP ON A.id_atendimento=AP.id_atendimento
                            INNER JOIN procedimento P ON P.id_procedimento=AP.id_procedimento
                            INNER JOIN empresa E ON E.id_empresa=P.id_empresa
                            WHERE A.id_atendimento=".$id_atendimento; 
                            $result_count = mysqli_query($con,$query_count);
                            while ($linha_count = mysqli_fetch_assoc($result_count)) {
                                array_push($count_procedimento,$linha_count['id_procedimento']);
                            }
                      
                    ?>
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
                        while($procedimento = mysqli_fetch_assoc($result_procedimento)){?>
                        <tr>
                        <td><label for="id_procedimento"><?=$procedimento['nome_procedimento']?></label></td>
                        <td><input type="checkbox" name="id_procedimento[]" value="<?=$procedimento['id_procedimento']?>"></td>
                        </tr>     
                        <?php } ?>                       
                    </tbody>
                    </table>

                    <table>
                    <thead>
                        <tr>
                        <th scope="col">Procedimentos Já Cadastrados</th>
                        <th scope="col">Remover</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        while($procedimento_cadastrado = mysqli_fetch_assoc($result_procedimento_cadastrado)){
                        $id_procedimento = $procedimento_cadastrado['id_procedimento']
                    ?>
                        <tr>
                        <td><label for="id_procedimento"><?=$procedimento_cadastrado['nome_procedimento']?></label></td>
                        <?php if (count($count_procedimento) == 1) {?>
                        <td><a href="#" onclick="alert('Impossível excluir procedimento, favor adicione um novo procedimento antes de excluir este');"><i class="fa-solid fa-trash-can"></i></a></td>
                        <?php }else{?>
                        <td><a href='remover_procedimento.php?id_atendimento=<?=$id_atendimento?>&id_procedimento=<?=$id_procedimento?>'><i class="fa-solid fa-trash-can"></i></a></td>
                        <?php }?>
                        </tr>     
                        <?php } ?>                       
                    </tbody>
                    </table>


                </div>
                <!-- FIM SELEÇÃO PROCEDIMENTOS  -->
            </div>
             <!-- FIM DIV CHECKIN  -->
            <div class="button">
                    <button type="submit" value="cadastrar">Atualizar</button>
            </div>
            </form>
             <!-- FIM DO FORM DE ATUALIZAR-->


</main>

<script src="https://kit.fontawesome.com/122585f6ab.js" crossorigin="anonymous"></script>
<?php
function formatCnpjCpf($value){
        $CPF_LENGTH = 11;
        $cnpj_cpf = preg_replace("/\D/", '', $value);
        if (strlen($cnpj_cpf) === $CPF_LENGTH) {
            return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf);
        } 
        return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
} ?>
</body>
</html>