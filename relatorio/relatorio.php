<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/crvital-logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/sidebar.css">
    <link rel="stylesheet" href="../assets/css/relatorio.css">
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
            <img class="img-logo" src="../assets/logo-crvital.png">
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

    <main class="main">
        <?php 
            include "bd_connect.php";
        ?>

        <h1>Relatórios</h1>

       <div class="filtros">
        <form action="gerar_relatorio.php" method="post">
            <div class="main-filters">
                <div class="radio_filtro">
                    <h3>Filtros Principais:</h3>
                    <label class="new-report-label" for="empresa">
                    <input type="radio" name="filtro_principal" value="empresa">
                    Empresa</label>
                    <label class="new-report-label" for="periodo">
                    <input type="radio" name="filtro_principal" value="periodo">
                    Período</label>
                    <label class="new-report-label" for="medico">
                    <input type="radio" name="filtro_principal" value="medico">
                    Médico</label>
                </div>
                <div class="date">
                    <label class="beggining" for="start_date">Data de Início:</label>
                    <input class="input-date" name="data_inicio" type="date" value="0000-00-00"/>
                    <label class="end" for="end_date">Data do Fim:</label>
                    <input class="input-date" name="data_fim" type="date" value="0000-00-00"/>
                </div>
            </div>
            <div class="secondary-filters">
                <div class="select_empresa">
                    <h3>Filtro por Empresa:</h3>
                    <select name="id_empresa" id="id_empresa">
                        <option value="">Selecione uma Empresa</option>
                        <?php
                            $query="select id_empresa,nome_empresa from empresa ORDER BY nome_empresa ASC";
                            $result = mysqli_query($con,$query);
                            while($empresa = mysqli_fetch_assoc($result)){?>
                                <option value="<?=$empresa['id_empresa'];?>"><?=$empresa['nome_empresa'];?></option>
                        <?php } ?>  
                    </select>
                </div>
                <div class="select_medico">
                    <h3>Filtro por Médico:</h3>
                    <select name="id_medico" id="id_medico">
                        <option value="">Selecione um Médico</option>
                        <?php
                            $query="select id_medico,nome_medico from medico ORDER BY nome_medico ASC";
                            $result = mysqli_query($con,$query);
                            while($medico = mysqli_fetch_assoc($result)){?>
                                <option value="<?=$medico['id_medico'];?>"><?=$medico['nome_medico'];?></option>
                        <?php } ?>  
                    </select>
                </div>
            </div>
    </div>
    <button type="submit">Gerar Relatório</button>
    </form>
</main>

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
</body>
</html>