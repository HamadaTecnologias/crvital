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
    <link rel="stylesheet" href="../assets/css/relatorio.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <title>Relatórios</title>
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
                            <span style="background: #61CE70;">
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

    <main class="main">
        <?php 
            include "../bd_connect.php";
        ?>

        <h1>Relatórios</h1>

       <div class="filtros">
        <form action="filtro.php" method="post">
            <div class="main-filters">
                <div class="main-filter">
                    <div class="radio_filtro">
                        <h3>Relatório</h3>
                        <label class="new-report-label" for="empresa">
                        <input type="radio" name="filtro_principal" value="empresa">
                        Empresa</label>
                        <label class="new-report-label" for="periodo">
                        <input type="radio" name="filtro_principal" value="periodo">
                        Período</label>
                        <label class="new-report-label" for="medico">
                        <input type="radio" name="filtro_principal" value="medico">
                        Médico</label>
                        <label class="new-report-label" for="procedimento">
                        <input type="radio" name="filtro_principal" value="procedimento">
                        Procedimento</label>
                    </div>
                    <div class="date">
                        <label class="beggining" for="start_date">Data de Início:</label>
                        <input class="input-date" name="data_inicio" type="date" value="0000-00-00"/>
                        <label class="end" for="end_date">Data do Fim:</label>
                        <input class="input-date" name="data_fim" type="date" value="0000-00-00"/>
                    </div>
                </div>
                <div class="tipo-relatorio">
                    <label class="new-report-label" for="parcial">
                    <input type="radio" name="filtro_relatorio" value="parcial">
                    Parcial</label>
                    <label class="new-report-label" for="completo">
                    <input type="radio" name="filtro_relatorio" value="completo">
                    Completo</label>
                </div>
            </div>
            <div class="secondary-filters">
                <div class="select_empresa">
                    <h3>Filtro por Empresa:</h3>
                    <select name="id_empresa" id="id_empresa">
                        <option value="">Selecione em caso de "Relatório por Empresa"</option>
                        <?php
                            $query="SELECT id_empresa,nome_empresa,cnpj FROM empresa WHERE status=true ORDER BY nome_empresa ASC";
                            $result = mysqli_query($con,$query);
                            while($empresa = mysqli_fetch_assoc($result)){
                                $cnpj_select = formatCnpjCpf($empresa['cnpj']) ;?>
                                <option value="<?=$empresa['id_empresa'];?>"><?=$empresa['nome_empresa']." CNPJ: ".$cnpj_select;?></option>

                        <?php } ?>  
                    </select>
                </div>
                <div class="select_medico">
                    <h3>Filtro por Médico:</h3>
                    <select name="id_medico" id="id_medico">
                        <option value="">Selecione em caso de "Relatório por Médico"</option>
                        <?php
                            $query="select id_medico,nome_medico from medico ORDER BY nome_medico ASC";
                            $result = mysqli_query($con,$query);
                            while($medico = mysqli_fetch_assoc($result)){?>
                                <option value="<?=$medico['id_medico'];?>"><?=$medico['nome_medico'];?></option>
                        <?php } ?>  
                    </select>
                </div>
                <div class="select_procedimento">
                    <h3>Filtro por Procedimento:</h3>
                    <select name="nome_procedimento" id="nome_procedimento">
                        <option value="">Selecione em caso de "Relatório por Procedimento"</option>
                        <option value="ACIDO FENILGLIXILICO">ACIDO FENILGLIXILICO</option>
                        <option value="ACIDO HIPURICO">ACIDO HIPURICO</option>
                        <option value="ACIDO MANDELICO">ACIDO MANDELICO</option>
                        <option value="ACIDO METIL HIPURICO">ACIDO METIL HIPURICO</option>
                        <option value="ACIDO TRANS TRANS MUCONICO">ACIDO TRANS TRANS MUCONICO</option>
                        <option value="ACUIDADE VISUAL">ACUIDADE VISUAL</option>
                        <option value="ANAMNESE OCUPACIONAL">ANAMNESE OCUPACIONAL</option>
                        <option value="ANTI HAV">ANTI HAV</option>
                        <option value="AUDIOMETRIA TONAL">AUDIOMETRIA TONAL</option>
                        <option value="AVALIAÇÃO PSICOSSOCIAL">AVALIAÇÃO PSICOSSOCIAL</option>
                        <option value="CARBOXIHEMOGLOBINA">CARBOXIHEMOGLOBINA</option>
                        <option value="ECG">ECG</option>
                        <option value="ESPIROMETRIA">ESPIROMETRIA</option>
                        <option value="GGT">GGT</option>
                        <option value="GLICEMIA">GLICEMIA</option>
                        <option value="HEMOGRAMA COMPLETO">HEMOGRAMA COMPLETO</option>
                        <option value="RAIO X TORAX OIT">RAIO X TORAX OIT</option>
                        <option value="TESTE ROMBERG">TESTE ROMBERG</option>
                        <option value="TOXICOLÓGICO">TOXICOLÓGICO</option>
                    </select>
                </div>
            </div>
    </div>
    <button type="submit"><img src="../assets/download.png">Gerar Relatório</button>
    </form>
</main>

<script>
    $(document).ready(function() {
        $('#nome_procedimento').select2();
    });
</script>
<script>
    $(document).ready(function() {
        $('#id_empresa').select2();
    });
</script>
<script>
    $(document).ready(function() {
        $('#id_medico').select2();
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
} ?>
</body>
</html>