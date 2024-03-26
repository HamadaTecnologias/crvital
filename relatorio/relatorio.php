<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/crvital-logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/sidebar.css">
    <link rel="stylesheet" href="../assets/css/relatorio.css">
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

    <main class="main">
        <div class="report-title">
            <h1>Relatórios</h1>
        </div>
        <form class="flex-form" action="">
            <div class="main-filters">
                <h3>Filtros Principais:</h3>
                <input type="radio" name="new_report_option" value="empresa">
                <label class="new-report-label" for="empresa">Empresa</label><br>
                <input type="radio" name="new_report_option" value="periodo">
                <label class="new-report-label" for="periodo">Período</label><br>
                <input type="radio" name="new_report_option" value="medico">
                <label class="new-report-label" for="medico">Médico</label>
            </div>
            <div class="date">
                <label class="beggining" for="start_date">Data de Início:</label><br>
                <input class="input-date" name="start-date" type="date" value="0000-00-00" /><br>
                <label class="end" for="end_date">Data do Fim:</label><br>
                <input class="input-date" name="end-date" type="date" value="0000-00-00" />
            </div>
            <div class="secondary-filters">
                <h3>Filtro por Empresa:</h3>
            </div>
        </form>
    </main>


</body>
</html>