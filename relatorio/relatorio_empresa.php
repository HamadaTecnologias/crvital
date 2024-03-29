<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="script.js" defer></script>
    <link rel="stylesheet" href="../assets/css/relatorio-empresa.css">
    <title>Relatório Empresa</title>
</head>
<body>            
    <?php 
        include "../bd_connect.php";
        $data_inicio = $_GET['data_inicio'];
        $data_fim = $_GET['data_fim'];
        $id_empresa = $_GET['id_empresa'];
        if ($id_empresa = null) {
            echo"Escolha ao menos uma empresa";
        };
    ?>

    <div id="content">

    <header>
        <div>
            <img class="img" src="../assets/crvital-logo.svg">
        </div>
        <h1>Relação de Exames Realizados</h1>
    </header>


    <div class="main-empresa">
        <div class="empresa">
            <h2><span>Empresa:</span> AUTO LOTAÇÃO INGA LTDA</h2>
            <h3><span>CNPJ:</span> 30.074.561/0001-04</h3>
            <h4>Período: 01/01/2023 a 31/01/2023</h4>
            <h5><span>Data de Emissão:</span> 14/03/24</h5>
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
                    $query = "SELECT A.data,A.nome_paciente,P.nome_procedimento,P.valor,E.nome_empresa,E.perfil,E.cnpj,E.forma_pagamento  
                    FROM atendimento A
                    INNER JOIN atendimento_procedimento AP ON A.id_atendimento=AP.id_atendimento
                    INNER JOIN procedimento P ON  P.id_procedimento=AP.id_procedimento
                    INNER JOIN empresa E ON E.id_empresa=E.id_empresa
                    WHERE E.id_empresa=".$id_empresa." AND A.data BETWEEN '".$data_inicio."' and '".$data_fim."' 
                    ORDER BY E.nome_empresa ASC, A.data ASC;";

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
                            <td>
                                <?= $linha['nome_empresa']; ?>
                            </td>
                        </tr>
                    <?php //FECHANDO WHILE
                        } ?>  
                ?>
            </tbody>
    </table>

    <!-- <div>
        <div class="exame">
            <p class="subheader"><strong>Tipo de Exame</strong>: Demissional</p>
            <p class="subheader"><strong>Total</strong>: 7</p>
        </div>
        <hr class="exame-separator">
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Departamento</th>
                <th>Posição</th>
                <th>Data de Admissão</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>16216</td>
                <td>JORGE ANDERSON FERREIRA CORDEIRO</td>
                <td>Tráfego</td>
                <td>Motorista</td>
                <td>06/01/2023</td>
            </tr>
            <tr>
                <td>16229</td>
                <td>DERVAL DOS SANTOS FILHO</td>
                <td>Movimentação</td>
                <td>Movimentador II</td>
                <td>06/01/2023</td>
            </tr>
            <tr>
                <td>738</td>
                <td>WENDREON BERNARDO DA SILVA FERREIRA</td>
                <td>CCO - Monitoramento</td>
                <td>Auxiliar de Operação</td>
                <td>11/01/2023</td>
            </tr>
            <tr>
                <td>15535</td>
                <td>FRANCISCO JOSE GOMES</td>
                <td>Tráfego</td>
                <td>Motorista</td>
                <td>19/01/2023</td>
            </tr>
            <tr>
                <td>16180</td>
                <td>HELTON MOTA DE BARROS</td>
                <td>Tráfego</td>
                <td>Motorista</td>
                <td>19/01/2023</td>
            </tr>
            <tr>
                <td>15601</td>
                <td>WELLERSON RODRIGUES DA SILVA CABRAL</td>
                <td>Movimentação</td>
                <td>Movimentador II</td>
                <td>26/01/2023</td>
            </tr>
            <tr>
                <td>16101</td>
                <td>JEFERSON FERREIRA DOS SANTOS</td>
                <td>Tráfego</td>
                <td>Inspetor</td>
                <td>31/01/2023</td>
            </tr>
        </tbody>
    </table>

    <div>
        <div class="exame">
            <p class="subheader"><strong>Tipo de Exame</strong>: Retorno ao Trabalho</p>
            <p class="subheader"><strong>Total</strong>: 1</p>
        </div>
        <hr class="exame-separator">
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Departamento</th>
                <th>Posição</th>
                <th>Data de Admissão</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>242</td>
                <td>JOSE FERNANDO RIBEIRO</td>
                <td>Tráfego</td>
                <td>Motorista</td>
                <td>23/01/2023</td>
            </tr>
        </tbody>
    </table> -->
<!-- 
    <h3 class="total">Total de Exames Realizados pela Empresa: 10</h3>
    </div> -->
    
</body>
</html>