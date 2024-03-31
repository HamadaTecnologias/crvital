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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/logo-favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/sidebar.css">
    <link rel="stylesheet" href="../assets/css/doctor.css">
    <title>Médicos</title>
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
                                <i class="atual fa-solid fa-location-dot"></i>
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
                <div class="new-doctor">
                <h3>Cadastrar Novo Médico:</h3>
                <form action="new_doctor.php" method="post">
                    <label class="new-doctor-label" for="new_doctor_username">Médico:</label><br>
                    <input class="new-doctor-input" type="text" name="new_doctor_username" placeholder="Digite o nome"><br>

                    <label class="new-doctor-label" for="new_doctor_cpf">CPF:</label><br>
                    <input class="new-doctor-input" type="text" name="new_doctor_cpf" placeholder="Digite o CPF (somente números)"><br>

                    <label class="new-doctor-label" for="new_doctor_nis">NIS:</label><br>
                    <input class="new-doctor-input" type="text" name="new_doctor_nis" placeholder="Digite o número do NIS"><br>

                    <label class="new-doctor-label" for="new_doctor_board">Conselho (SIGLA):</label><br>
                    <input class="new-doctor-input" type="text" name="new_doctor_board" placeholder="Digite a sigla do conselho"><br>

                    <label class="new-doctor-label" for="new_doctor_register_board">Registro no Conselho</label><br>
                    <input class="new-doctor-input" type="text" name="new_doctor_register_board" placeholder="Digite o registro do conselho"><br>

                    <label class="new-doctor-label" for="new_doctor_category">Categoria</label><br>
                    <input class="new-doctor-input" type="text" name="new_doctor_category" placeholder="Digite a categoria"><br>

                    <button type="submit">Cadastrar</button>
                </form>
                </div>

                <div class="registred-doctors">
                <h3>Médicos Cadastrados:</h3>
                <table>
                    <tr>
                        <th>Id</th>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Categoria</th>
                        <th>Ações</th>
                    </tr>
                    <?php
                    function formatCnpjCpf($value)
                    {
                      $CPF_LENGTH = 11;
                      $cnpj_cpf = preg_replace("/\D/", '', $value);
                      
                      if (strlen($cnpj_cpf) === $CPF_LENGTH) {
                        return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf);
                      } 
                      
                      return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
                    }
                    include "../bd_connect.php";
                    $query = "SELECT id_medico, nome_medico, cpf, categoria FROM medico;";
                    $result = mysqli_query($con, $query);
                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $cpf = formatCnpjCpf($row['cpf']);
                            echo "<tr>";
                            echo "<td>" . $row['id_medico'] . "</td>";
                            echo "<td>" . $row['nome_medico'] . "</td>";
                            echo "<td>" . $cpf . "</td>";
                            echo "<td>" . $row['categoria'] . "</td>";
                            echo "<td><a href='delete_doctor.php?id_medico=".$row['id_medico']."'><i class=\"fa-solid fa-trash-can\"></i></a></td>";
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