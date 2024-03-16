<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/crvital-logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="main-sidebar.css">
    <link rel="stylesheet" href="doctor.css">
    <title>CrVital - Página do Médico</title>
</head>
<body>
    <section class="flex">
        <div class="sidebar">
            <a href="logout.php"><img class="logout-icon" src="assets/logout-icon.png"></a>
            <img class="img-logo" src="assets/crvital-logo.svg">
            <ul>
                <li><a href="admin.php"><img class="icons-main" src="assets/user-icon.png">Usuários</a></li>
                <li><a href="#"><img class="icons-main" src="assets/calendar.png">Atendimentos</a></li>
                <li><a href="#"><img class="icons-main" src="assets/company.png">Empresas</a></li>
                <li><a href="#"><img class="icons-main" src="assets/stetoscope.png">Exames</a></li>
                <li><a href="doctor.php"><img class="icons-main" src="assets/doctor.png">Médicos</a></li>
                <li><a href="#"><img class="icons-main" src="assets/report.png">Relatórios</a></li>
            </ul>
        </div>

    <div class="middle">
    <div class="new-user">
        <h3>Cadastrar Novo Médico:</h3>
        <form action="" method="post">
            <label for="new_doctor_username">Médico:</label><br>
            <input type="text" name="new_doctor_username" placeholder="Digite o nome"><br>

            <label for="new_doctor_cpf">CPF:</label><br>
            <input type="text" name="new_doctor_cpf" placeholder="Digite o CPF"><br>

            <label for="new_doctor_nis">NIS:</label><br>
            <input type="text" name="new_doctor_nis" placeholder="Digite o número do NIS"><br>

            <label for="new_doctor_board">Conselho (SIGLA):</label><br>
            <input type="text" name="new_doctor_board" placeholder="Digite a sigla do conselho"><br>

            <label for="new_doctor_category">Categoria</label><br>
            <input type="text" name="new_doctor_category" placeholder="Digite a categoria"><br>

            <button type="submit">Cadastrar</button>
        </form>
    </div>
    </div>
    </section>
</body>
</html>