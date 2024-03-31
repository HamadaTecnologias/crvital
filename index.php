<!DOCTYPE html>
<html lang="pt-br">
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
            <img class="img-logo" src="assets/logo-crvital.png">
        </div>
        <div class="login-box">
            <h1 class="green-lyrics">Acesso ao Sistema</h1>
            <form action="login/auth.php" method="post">
                <label class="green-lyrics" for="user">Usuário:</label><br>
                <input type="text" name="user" placeholder="Digite o usuário"><br>
                <label class="green-lyrics" for="senha">Senha:</label><br>
                <input type="password" name="senha" placeholder="Digite sua senha"><br>
                <button type="submit"><img src="assets/log-in.png" alt="login icon">Entrar</button>
                <p class="copywrite">© 2024 Gestão de Consultas (Versão 2024.001.10.03)</p>
            </form>
        </div>

        <div>
            <?php
                if(isset($_GET['erro_login'])) {
                    echo "<p class='error-item'>Usuário ou senha incorretos ou não digitados. Tente novamente!</p>";
                } elseif(isset($_GET['erro_login_access'])) {
                    echo "<p class='error-item'>Acesso não autorizado! Faça login para acessar o sistema.</p>";
                }
                else {
                    echo '';
                }
            ?> 
        </div>
    </div>
   
</body>
</html>