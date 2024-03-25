<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/crvital-logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/login.css">
    <title>CrVital - Login</title>
</head>
<body>

    <div class="container">
        <div>
            <img class="img-logo" src="assets/crvital-logo.svg">
        </div>
        <div class="login-box">
            <h1 class="green-lyrics">Acesso ao Sistema</h1>
            <form action="login/auth.php" method="post">
                <label class="green-lyrics" for="user">Usuário:</label><br>
                <input type="text" name="user" placeholder="Digite o usuário"><br>
                <label class="green-lyrics" for="password">Senha:</label><br>
                <input type="password" name="password" placeholder="Digite sua senha"><br>
                <button type="submit"><img src="assets/log-in.png" alt="login icon">Entrar</button>
                <p class="copywrite">© 2024 Gestão de Consultas (Versão 2024.001.10.03)</p>
            </form>
        </div>
    </div>
   
</body>
</html>