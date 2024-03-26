<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/crvital-logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/sidebar.css">
    <link rel="stylesheet" href="../assets/css/admin.css">   
    <title>Usuários</title>
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
                            <th>Login</th>
                            <th>Nome</th>
                            <th>Permissão</th>
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
                                echo "<td><a href='delete_user.php?user=".$row['username']."'><i class=\"fa-solid fa-trash-can\"></i></a></td>";
                                if($row['status']!= false){
                                    echo "<td><a class='block' href='block_user.php?user=".$row['username']."'><i class=\"fa-solid fa-lock-open\"></a></td>";
                                } else {
                                    echo "<td><a class='unblock' href='unblock_user.php?user=".$row['username']."'><i class=\"fa-solid fa-lock\"></i></a></td>";
                                }
                                echo "</tr>";
                            }
                        } else {
                            echo "Erro ao recuperar os usuários.";
                        }
                        ?>
                    </table>
                </div>
        </main>
<script src="https://kit.fontawesome.com/122585f6ab.js" crossorigin="anonymous"></script>
</body>
</html>