<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/crvital-logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/sidebar.css">
    <link rel="stylesheet" href="../assets/css/atendimento.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <title>CrVital - Página Inicial</title>
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
            include 'bd_connect.php';
            //RECEBENDO VARIAVEL ID_EMPRESA DO SELECT PHP_SELF
            $id_empresa= $_GET['id_empresa']??null;
        ?>

        <main class="main"> 
            <!-- FORM DE SELECT DE EMPRESA -->
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
                <button type="submit" value="selecionar">Selecionar</button>           
            </form>
            <!--FIM FORM DE SELECT DE EMPRESA -->     
            
            <!-- IF PARA MOSTRAR CAMPOS CHECKIN -->
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
                        <div class="tipo">
                            <label for="tipo_atendimento">Tipo Atendimento:</label>
                            <label for="tipo_atendimento">
                            <input type=radio name=tipo_atendimento value="credenciado">
                            Credenciado</label>
                            <label for="tipo_atendimento"><input type=radio name=tipo_atendimento value="avulso"> 
                            Avulso</label>
                        </div>
                        <div class="dados_atendimento">
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
                            <script src="script.js"></script>
                            <div class="hora">
                                <label for="hora">Horario Check-in</label>
                                <span id="time">12:00:00</span>       
                                <input name="data_atendimento" type="date" value="0000-00-00" />
                            </div> 
                        </div>
                    </div>
                    <div class="colaborador">
                        <label for="nome_paciente">Colaborador:</label>
                        <input placeholder="Digite o nome do Colaborador" name="nome_paciente" type="text" value="">
                    </div>
                </div>
                <!-- FIM DADOS ATENDIMENTO  -->
                    <?php 
                        if ($id_empresa!=null) {
                        $query="select id_procedimento,nome_procedimento from procedimento WHERE id_empresa=".$id_empresa;
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
            $query_ativos = "SELECT id_atendimento,nome_paciente,tipo_exame,hora_checkin,nome_medico,nome_empresa 
            FROM atendimento 
            INNER JOIN medico ON atendimento.id_medico = medico.id_medico 
            INNER JOIN empresa ON atendimento.id_empresa = empresa.id_empresa 
            WHERE hora_checkout=0;";
            $result = mysqli_query($con,$query_ativos);?>
            <table>
                <thead>
                    <tr>
                    <th scope="col">Empresa</th>
                    <th scope="col">Colaborador</th>
                    <th scope="col">Médico Atendente</th>
                    <th scope="col">Exame</th>
                    <th scope="col">Check-in</th>
                    <th scope="col">Finalizar</th>
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
</body>
</html>