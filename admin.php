<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/crvital-logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="main-sidebar.css">
    <!-- <link rel="stylesheet" href="admin.css">  -->
    <link rel="stylesheet" href="admin-2.css">   
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

    <div class="middle">
    <div class="new-user">
        <h3>Cadastrar Novo Usuário:</h3>
        <form action="new_user.php" method="post">
            <label class="new-user-label" for="new_user_username">Login:</label><br>
            <input class="new-user-input" type="text" name="new_user_username" placeholder="Digite o usuário"><br>

            <label class="new-user-label" for="new_user_full_name">Nome:</label><br>
            <input class="new-user-input" type="text" name="new_user_full_name" placeholder="Digite seu nome completo"><br>

            <label class="new-user-label" for="new_user_password">Senha:</label><br>
            <input class="new-user-input" type="password" name="new_user_password" placeholder="Digite sua senha"><br>

            <h4>Perfil de Usuário:</h4>
            <input type="radio" name="new_user_level" value="A"> 
            <label for="adm">Administrador</label><br>

            <input type="radio" name="new_user_level" value="R"> 
            <label for="recepc">Recepção</label><br> 

            <input type="radio" name="new_user_level" value="F"> 
            <label for="financ">Financeiro</label><br> 

            <button type="submit">Cadastrar</button>
        </form>
    </div>

    <div class="registred-users">
    <h3>Usuários Cadastrados:</h3>
    <table>
        <tr>
            <th>Username</th>
            <th>Name</th>
            <th>Level</th>
            <th colspan="3">Ações</th>
        </tr>
        <?php
        include 'bd_connect.php';
        $query = "SELECT * FROM users";
        $result = mysqli_query($con, $query);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['username'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['level'] . "</td>";
                echo "<td><a href='delete_user.php?user=".$row['username']."'>Excluir</a></td>";
                if($row['status']!= false){
                    echo "<td><a href='block_user.php?user=".$row['username']."'>Bloquear</a></td>";
                } else {
                    echo "<td><a href='unblock_user.php?user=".$row['username']."'>Desbloquear</a></td>";
                }
                echo "</tr>";
            }
        } else {
            echo "Erro ao recuperar os usuários.";
        }
        ?>
    </table>
    </div>
    </div>
    </section>
</body>
</html>