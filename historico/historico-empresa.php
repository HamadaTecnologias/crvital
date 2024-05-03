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
    <link rel="stylesheet" href="../assets/css/historico-empresa.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <title>Histórico</title>
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

                <?php if($nivel != 'F') { ?>
                    <a href="../historico/pagina_principal.php">
                        <button class="sidebar-nav-button">
                            <span style="background: #61CE70;">
                                <span class="sidebar-nav-button-span2">
                                    <img class="icons-main" src="../assets/history.png">Histórico
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
       <?php 
            include "../bd_connect.php";
            $data_inicio =$_GET['data_inicio'];
            $data_fim = $_GET['data_fim'];
            $id_empresa = $_GET['id_empresa']
        ?>
        
            <?php 
            $query_ativos = "SELECT A.id_atendimento,A.nome_paciente,A.telefone,A.tipo_exame,A.data,M.nome_medico,E.nome_empresa 
            FROM atendimento A
            INNER JOIN medico M ON A.id_medico = M.id_medico 
            INNER JOIN empresa E ON A.id_empresa = E.id_empresa 
            WHERE A.id_empresa=".$id_empresa." AND A.data BETWEEN '".$data_inicio."' and '".$data_fim."' ORDER BY data ASC";
            $result = mysqli_query($con,$query_ativos);
            ?>
        <div class="painel">
            <table>
                <thead>
                    <tr>
                    <th scope="col">Empresa</th>
                    <th scope="col">Colaborador</th>
                    <th scope="col">Telefone</th>
                    <th scope="col">Médico Examinador</th>
                    <th scope="col">Exame</th>
                    <th scope="col">Data</th>
                    <th scope="col">Editar</th>
                    <th scope="col">Deletar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($consulta = mysqli_fetch_assoc($result)){ ?>
                        <tr>
                            <td>
                                <?= $consulta['nome_empresa']; ?>
                            </td>
                            <td>
                                <?= $consulta['nome_paciente']; ?>
                            </td>
                            <td>
                                <?= tel($consulta['telefone']); ?>
                            </td>
                            <td>
                                <?= $consulta['nome_medico']; ?>
                            </td>
                            <td>
                                <?= $consulta['tipo_exame']; ?>
                            </td>
                            <td>
                                <?= date('d/m/Y', strtotime($consulta['data'])) ?>
                            </td>
                            <td>
                                <a href='editar_atendimento.php?id_atendimento=<?= $consulta['id_atendimento']; ?>'>EDITAR</a>
                            </td>
                            <td>
                                <a href='deletar_atendimento.php?id_atendimento=<?=$consulta['id_atendimento']?>&data_inicio=<?=$data_inicio?>&data_fim=<?=$data_fim?>'><i class="fa-solid fa-trash-can"></i></a>
                            </td>
                        </tr>
                    <?php //FECHANDO WHILE
                        } 
                        mysqli_close($con);
                    ?>  
                </tbody>
            </table> 
        </div>
       
</main>

<script>
    $(document).ready(function() {
        $('#id_empresa').select2();
    });
</script>
<script src="https://kit.fontawesome.com/122585f6ab.js" crossorigin="anonymous"></script>
<?php
function formatCnpjCpf($value){
        $CPF_LENGTH = 11;
        $cnpj_cpf = preg_replace("/\D/", '', $value);
        if (strlen($cnpj_cpf) === $CPF_LENGTH) {
            return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf);
        } 
        return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
} 
function tel($number){
    $number="(".substr($number,0,2).") ".substr($number,2,-4)." - ".substr($number,-4);
    // primeiro substr pega apenas o DDD e coloca dentro do (), segundo subtr pega os números do 3º até faltar 4, insere o hifem, e o ultimo pega apenas o 4 ultimos digitos
    return $number;
}
?>
</body>
</html>