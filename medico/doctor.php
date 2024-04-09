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
                        <span style="background: #61CE70;">
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

        <!-- Recebendo dados do médico para alterar -->
        <?php
            include "../bd_connect.php";
            $id_medico = $_GET['id_medico']??null;
            $alterar['nome_medico'] =null;
            $alterar['cpf'] =null;
            $alterar['nis'] =null;
            $alterar['sigla_conselho'] =null;
            $alterar['registro_conselho'] =null;
            $alterar['categoria'] =null;
            if($id_medico !=null){
                $query = "SELECT nome_medico, cpf, nis, sigla_conselho, registro_conselho, categoria from medico where id_medico=".$id_medico;
                $medico = mysqli_query($con, $query);
                $alterar = mysqli_fetch_assoc($medico);
            }
        ?>

        <main class="main">
                <div class="new-doctor">
                <h3>Cadastrar Novo Médico:</h3>
                <form action="manipular_medico.php" method="post">
                    <input style="display:none" name="id_medico" id="id_medico" type="number" value="<?=$id_medico?>"><br>
                    <label class="new-doctor-label" for="new_doctor_username">Médico:</label><br>
                    <input class="new-doctor-input" type="text" id="nome_medico" name="nome_medico" placeholder="Digite o nome" value="<?=$alterar['nome_medico']?>"><br>


                    <label class="new-doctor-label" for="new_doctor_cpf">CPF:</label><br>
                    <input class="new-doctor-input" type="text" id="cpf" name="cpf" placeholder="Digite o CPF (somente números)" value="<?=$alterar['cpf']?>"><br>

                    <label class="new-doctor-label" for="new_doctor_nis">NIS:</label><br>
                    <input class="new-doctor-input" type="text" id="nis" name="nis" placeholder="Digite o número do NIS" value="<?=$alterar['nis']?>"><br>

                    <label class="new-doctor-label" for="new_doctor_board">Conselho (SIGLA):</label><br>
                    <input class="new-doctor-input" type="text" id="sigla_conselho" name="sigla_conselho" placeholder="Digite a sigla do conselho" value="<?=$alterar['sigla_conselho']?>"><br>


                    <label class="new-doctor-label" for="new_doctor_register_board">Registro no Conselho</label><br>
                    <input class="new-doctor-input" type="text" id="registro_conselho" name="registro_conselho" placeholder="Digite o registro do conselho" value="<?=$alterar['registro_conselho']?>"><br>

                    <label class="new-doctor-label" for="new_doctor_category">Categoria</label><br>
                    <input class="new-doctor-input" type="text" id="categoria" name="categoria" placeholder="Digite a categoria" value="<?=$alterar['categoria']?>"><br>


                    <button type="submit" name="cadastrar" value="true">Cadastrar</button>
                    <button style="background-color:red;"type="submit" value="<?=$id_medico?>">Confirmar Alteração</button>
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
                        <th>Apagar</th>
                        <th>Alterar</th>
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
                            echo "<td><a href='doctor.php?id_medico=".$row['id_medico']."'><i class=\"fa-solid fa-rotate\"></i></a></td>";
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