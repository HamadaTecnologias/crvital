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
    <link rel="stylesheet" href="../assets/css/admin.css">   
    <title>Usuários</title>
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
                        <span style="background: #61CE70;">                    
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
                            <span class="sidebar-nav-button-span">
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
                <div class="new-user">
                    <h3>Cadastrar Novo Usuário:</h3>
                    <form action="new_user.php" method="post">
                        <label class="new-user-label" for="new_user_username">Login:</label><br>
                        <input class="new-user-input" type="text" name="new_user_username" placeholder="Digite o usuário"><br>

                        <label class="new-user-label" for="new_user_full_name">Nome:</label><br>
                        <input class="new-user-input" type="text" name="new_user_full_name" placeholder="Digite seu nome e sobrenome"><br>

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

                <?php
                    function mapearParaPapel($permissao) {
                        $mapa = array(
                            'A' => 'Administrador',
                            'F' => 'Financeiro',
                            'R' => 'Recepcionista'
                        );
                        return isset($mapa[$permissao]) ? $mapa[$permissao] : '';
                    }
                ?>

                <div class="registred-users">
                <table>
                    <?php
                    include '../bd_connect.php';
                    $query = "SELECT * FROM users";
                    $result = mysqli_query($con, $query);
                    ?>
                    <div class="registred-users">
                        <h3>Usuários Cadastrados:</h3>
                        <table>
                            <tr>
                                <th>Login</th>
                                <th>Nome</th>
                                <th>Papel</th>
                                <th colspan="3">Ações</th>
                            </tr>
                            <?php
                            if ($result) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $row['username'] . "</td>";
                                    echo "<td>" . $row['name'] . "</td>";
                                    echo "<td>" . mapearParaPapel($row['level']) . "</td>";
                                    echo "<td><a href='delete_user.php?user=".$row['username']."'><i class=\"fa-solid fa-trash-can\"></i></a></td>";
                                    if($row['status'] != false) {
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