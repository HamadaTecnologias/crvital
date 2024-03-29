<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="script.js" defer></script>
    <link rel="stylesheet" href="../assets/css/relatorio-empresa.css">
    <link rel="stylesheet" href="../assets/css/teste-relatorio-empresa.css">
    <title>Relatório Empresa</title>
</head>
<body>            
    <?php 
        include "../bd_connect.php";
        $data_inicio = $_GET['data_inicio'];
        $data_fim = $_GET['data_fim'];
        $id_empresa = $_GET['id_empresa'];
        $error=FALSE;
        if ($id_empresa == null) {
            $error=TRUE;
        }
        if ($error!=FALSE) {
            header('location:relatorio.php?error=true');
        }        
    ?>

    <div id="content">

    <header>
        <div>
            <img class="img" src="../assets/crvital-logo.svg">
        </div>
        <h1>Relação de Exames Realizados</h1>
        <div class="column">
            <p><strong>Período:</strong> <?= $data_inicio; ?> a <?= $data_fim; ?></p>
            <p><strong>Data de Emissão:</strong></p>
    </div>
    </header>

    <div class="main-empresa">
        <?php
            $query="SELECT * FROM empresa WHERE id_empresa = ".$id_empresa.";";
            $result = mysqli_query($con,$query);
            $linha = mysqli_fetch_assoc($result);
        ?>
        <div class="empresa">
            <h2><strong>Empresa: </strong><?= $linha['nome_empresa']; ?></h2>
            <h3 class="cnpj"><strong>CNPJ:</strong> <?= $linha['cnpj']; ?></h3>
            <p><strong>Perfil: </strong><?= $linha['perfil']; ?></p>
            <p><strong>Método de Pagamento: </strong><?= $linha['forma_pagamento']; ?></p>
        </div>
    </div>

    <div>
        <div class="exame">
            <p class="subheader"><strong>Tipo de Exame</strong>: Admissional</p>
            <p class="subheader"><strong>Total</strong>: 2</p>
        </div>
        <hr class="exame-separator">
    </div>

    <table>
            <thead>
                <tr>
                <th>Colaborador</th>
                <th>Procedimento</th>
                <th>Valor</th>
                <th>Realizado em</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $query="SELECT A.data, A.nome_paciente, P.nome_procedimento, P.valor
                    FROM atendimento A
                    INNER JOIN atendimento_procedimento AP ON A.id_atendimento = AP.id_atendimento
                    INNER JOIN procedimento P ON P.id_procedimento = AP.id_procedimento
                    WHERE A.id_empresa = ".$id_empresa." AND A.data BETWEEN '".$data_inicio."' AND '".$data_fim."'
                    ORDER BY A.data ASC;";


                    $result = mysqli_query($con,$query);

                    while($linha = mysqli_fetch_assoc($result)){ ?>
                        <tr>
                            <td>
                                <?= $linha['nome_paciente']; ?>
                            </td>
                            <td>
                                <?= $linha['nome_procedimento']; ?>
                            </td>
                            <td>
                            <?= $linha['valor']; ?>
                            </td>
                            <td>
                                <?= $linha['data']; ?>
                            </td>
                        </tr>
                    <?php //FECHANDO WHILE
                        } ?>  
            </tbody>
    </table>
    </div>
    <button id="generate-pdf">GERAR PDF</button>
</body>
</html>