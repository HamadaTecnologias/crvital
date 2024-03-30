<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="script.js" defer></script>
    <link rel="shortcut icon" href="../assets/crvital-logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/relatorio-empresa.css">
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
        <?php
            $query_data = "SELECT DATE_FORMAT(CURDATE(), '%d/%m/%Y')";
            $result_data = mysqli_query($con,$query_data);
            $data = mysqli_fetch_assoc($result_data);
            $data_emissao = $data['DATE_FORMAT(CURDATE(), \'%d/%m/%Y\')'];

        ?>
        <div>
            <img class="img" src="../assets/crvital-logo.svg">
        </div>
        <h1>Relação de Exames Realizados</h1>
        <div class="column">
            <p><strong>Período:</strong> <?= date('d/m/Y', strtotime($data_inicio)); ?> a <?= date('d/m/Y', strtotime($data_fim)); ?></p>
            <p><strong>Data de Emissão: </strong><?= $data_emissao ?></p>
    </div>
    </header>

    <div class="main-empresa">
        <?php
            $query="SELECT * FROM empresa WHERE id_empresa = ".$id_empresa.";";
            $result = mysqli_query($con,$query);
            $linha = mysqli_fetch_assoc($result);
            $cnpj = $linha['cnpj'];
            $cnpj_formatado = substr($cnpj, 0, 2) . '.' . substr($cnpj, 2, 3) . '.' . substr($cnpj, 5, 3) . '/' . substr($cnpj, 8, 4) . '-' . substr($cnpj, 12, 2);
        ?>
        <div class="empresa">
            <h2><strong>Empresa: <?= strtoupper($linha['nome_empresa']); ?></strong></h2>
            <h3><strong>CNPJ:</strong> <?= $cnpj_formatado; ?></h3>
            <p><strong>Perfil: </strong><?= strtoupper($linha['perfil']); ?></p>
            <p><strong>Método de Pagamento: </strong><?= strtoupper($linha['forma_pagamento']); ?></p>
        </div>
    </div>

    <div>
        <div class="exame">
            <p class="subheader"><strong>Tipo de Exame:</strong></p>
        </div>
    </div>

    <table>
            <thead>
                <tr>
                <th>Colaborador</th>
                <th>Procedimento</th>
                <th>Valor</th>
                <th>Realizado em:</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $query="SELECT A.id_atendimento,A.data, A.nome_paciente, P.nome_procedimento, P.valor
                    FROM atendimento A
                    INNER JOIN atendimento_procedimento AP ON A.id_atendimento = AP.id_atendimento
                    INNER JOIN procedimento P ON P.id_procedimento = AP.id_procedimento
                    WHERE A.id_empresa = ".$id_empresa." AND A.data BETWEEN '".$data_inicio."' AND '".$data_fim."'
                    ORDER BY A.data ASC;";
                    $result = mysqli_query($con,$query);
                    $ids = array();
                    while($linha = mysqli_fetch_assoc($result)){ 
                        if (!in_array($linha['id_atendimento'], $ids)) {
                ?>   
                        <tr>
                            <td>
                                <?= $linha['nome_paciente']; ?>
                            </td>
                            <td>
                                    <?php 
                                        $query_nome_procedimento = "SELECT P.nome_procedimento,P.valor 
                                        FROM atendimento A
                                        INNER JOIN atendimento_procedimento AP ON A.id_atendimento=AP.id_atendimento
                                        INNER JOIN procedimento P ON P.id_procedimento=AP.id_procedimento
                                        INNER JOIN empresa E ON E.id_empresa=P.id_empresa
                                        WHERE A.id_atendimento=".$linha['id_atendimento']." AND A.data BETWEEN '".$data_inicio."' and '".$data_fim."' ORDER BY E.nome_empresa ASC, A.data ASC;";  
                                        $result_nome = mysqli_query($con,$query_nome_procedimento);
                                        while($linha_nome = mysqli_fetch_assoc($result_nome)){
                                            echo  $linha_nome['nome_procedimento']."<br>";
                                        }
                                    ?>
                            </td>
                            <td>
                                    <?php 
                                        $query_valor_procedimento = "SELECT P.nome_procedimento,P.valor 
                                        FROM atendimento A
                                        INNER JOIN atendimento_procedimento AP ON A.id_atendimento=AP.id_atendimento
                                        INNER JOIN procedimento P ON P.id_procedimento=AP.id_procedimento
                                        INNER JOIN empresa E ON E.id_empresa=P.id_empresa
                                        WHERE A.id_atendimento=".$linha['id_atendimento']." AND A.data BETWEEN '".$data_inicio."' and '".$data_fim."' ORDER BY E.nome_empresa ASC, A.data ASC;";  
                                        $result_valor = mysqli_query($con,$query_valor_procedimento);
                                        while($linha_valor = mysqli_fetch_assoc($result_valor)){
                                            echo $linha_valor['valor']."<br>";
                                        }
                                    ?>
                            </td>
                            <td>
                                <?= $linha['data']; ?>
                            </td>
                        </tr>
                <?php 
                        } //FECHANDO O IF
                        array_push($ids,$linha['id_atendimento']);
                    } //FECHANDO WHILE
                ?>  
            </tbody>
    </table>
    </div>
    <button id="generate-pdf">GERAR PDF</button>
</body>
</html>