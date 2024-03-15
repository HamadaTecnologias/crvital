<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/crvital-logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="main-sidebar.css">
    <link rel="stylesheet" href="admin.css">
    <title>CrVital - Página do Administrador</title>
</head>
<body>
    <section class="flex">
    <div class="sidebar">
        <a href="logout.php"><img class="logout-icon" src="assets/logout-icon.png"></a>
        <img class="img-logo" src="assets/crvital-logo.svg">
        <ul>
            <li><a href="#"><img class="icons-main" src="assets/user-icon.png">Usuários</a></li>
            <li><a href="#"><img class="icons-main" src="assets/calendar.png">Atendimentos</a></li>
            <li><a href="#"><img class="icons-main" src="assets/company.png">Empresas</a></li>
            <li><a href="#"><img class="icons-main" src="assets/stetoscope.png">Exames</a></li>
            <li><a href="#"><img class="icons-main" src="assets/doctor.png">Médicos</a></li>
            <li><a href="#"><img class="icons-main" src="assets/report.png">Relatórios</a></li>
        </ul>
    </div>

    <div>
        <h3>Cadastrar Novo Usuário</h3>
        <form action="new_user.php" method="post">
            <label for="new_user_username">Login:</label><br>
            <input type="text" name="new_user_username" placeholder="Digite o usuário"><br>
            <label for="new_user_password">Senha:</label><br>
            <input type="password" name="new_user_password" placeholder="Digite sua senha"><br>

            <h4>Perfil de Usuário</h4>
            <input type="radio" name="new_user_level" value="A"> 
            <label for="adm">Administrador</label><br>

            <input type="radio" name="new_user_level" value="R"> 
            <label for="recepc">Recepção</label><br> 

            <input type="radio" name="new_user_level" value="F"> 
            <label for="financ">Financeiro</label><br> 

            <button type="submit">Cadastrar</button>
        </form>
    </div>

    <div>
        <h3>Usuários Cadastrados</h3>
    </div>

    </section>
</body>
</html>