<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/logo-favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/relatorio_empresa.css">
    <title>Relatório Empresa</title>
</head>        
    <?php 
        include "../bd_connect.php";
        $data_inicio = $_GET['data_inicio'];
        $data_fim = $_GET['data_fim'];
        $id_empresa = $_GET['id_empresa'];
        $valor_empresa = 0;
        $error=FALSE;
        if (empty($id_empresa)) {
            $error=TRUE;
        }
        if(empty($data_inicio)){
            $erro=TRUE;
            echo $data_inicio;
        }
        if(empty($data_fim)){
            $erro=TRUE;
            echo $data_fim;
        }
        if ($error!=FALSE) {
            header('location:relatorio.php?error=true');
        }        
    ?>

  

    <?php
        //SELEÇÃO DA DATA DE EMISSÃO
        $query_data = "SELECT DATE_FORMAT(CURDATE(), '%d/%m/%Y')";
        $result_data = mysqli_query($con,$query_data);
        $data = mysqli_fetch_assoc($result_data);
        $data_emissao = $data['DATE_FORMAT(CURDATE(), \'%d/%m/%Y\')'];

        //SOMATÓRIO DO VALOR DE TODOS OS EXAMES POR PERÍODO
        $query_valor_empresa = 
        "SELECT P.valor 
        FROM atendimento A
        INNER JOIN atendimento_procedimento AP ON A.id_atendimento=AP.id_atendimento
        INNER JOIN procedimento P ON P.id_procedimento=AP.id_procedimento
        INNER JOIN empresa E ON E.id_empresa=P.id_empresa
        WHERE A.data BETWEEN '".$data_inicio."' and '".$data_fim."' AND  A.id_empresa=".$id_empresa;  
        $result_valor_empresa = mysqli_query($con,$query_valor_empresa);
        while($linha_valor_empresa = mysqli_fetch_assoc($result_valor_empresa)){
            $valor_empresa = $valor_empresa + $linha_valor_empresa['valor'];
        }

        //QUERY DADOS DA EMPRESA
        $query_dados_empresa="SELECT * FROM empresa WHERE id_empresa = ".$id_empresa.";";
        $result_empresa = mysqli_query($con,$query_dados_empresa);
        $linha_empresa = mysqli_fetch_assoc($result_empresa);
        $cnpj = $linha_empresa['cnpj'];
        $cnpj_formatado = substr($cnpj, 0, 2) . '.' . substr($cnpj, 2, 3) . '.' . substr($cnpj, 5, 3) . '/' . substr($cnpj, 8, 4) . '-' . substr($cnpj, 12, 2);
       
    ?>
<body>    
    <header>
        <div class="img">
            <img src="../assets/logo-crvital-horizontal.png" alt="logo">
        </div>  
        <div class="titulo-header">
            <div class="border">
                <div class="subtitulo-header">
                    <h4>CNPJ: <?= $cnpj_formatado; ?></h4>
                    <h4>Perfil: <?= strtoupper($linha_empresa['perfil'])?></h4>
                </div> 
                <div class="subtitulo-header">  
                    <h4>Pagamento: <?= strtoupper($linha_empresa['forma_pagamento']); ?></h4>
                    <h4>Emitido em: <?=$data_emissao?></h4>                 
                </div> 
                <div class="subtitulo-header">
                    <h4>Período de: <?= date('d/m/Y', strtotime($data_inicio)); ?> à <?= date('d/m/Y', strtotime($data_fim)); ?></h4>
                </div>
            </div>
        </div>
        
    </header>
    <h2><?=strtoupper($linha_empresa['nome_empresa'])?></h2>
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
                    $tituloA=FALSE;
                    $tituloD=FALSE;
                    $tituloMP=FALSE;
                    $tituloMRO=FALSE;
                    $tituloP=FALSE;
                    $tituloRT=FALSE;
                    $query="SELECT A.id_atendimento,A.data, A.nome_paciente, A.tipo_exame, P.nome_procedimento, P.valor
                    FROM atendimento A
                    INNER JOIN atendimento_procedimento AP ON A.id_atendimento = AP.id_atendimento
                    INNER JOIN procedimento P ON P.id_procedimento = AP.id_procedimento
                    WHERE A.id_empresa = ".$id_empresa." AND A.data BETWEEN '".$data_inicio."' AND '".$data_fim."'
                    ORDER BY A.tipo_exame ASC;";
                    $result = mysqli_query($con,$query);
                    $ids = array();
                    while($linha = mysqli_fetch_assoc($result)){ 
                        if (!in_array($linha['id_atendimento'], $ids)) {
                            switch ($linha['tipo_exame']) {
                                case 'Admissional':
                                    if ($tituloA == FALSE) {
                                        echo"<th>Tipo Exame: ADMISSIONAL</th>";
                                    }
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
                                                    echo"R$ ".$linha_valor['valor']."<br>";
                                                }
                                            ?>
                                    </td>
                                    <td>
                                    <?= date('d/m/Y', strtotime($linha['data'])); ?>
                                    </td>
                                </tr>
                                
                                <?php
                                $tituloA = TRUE; 
                                break;
                                case 'Demissional':
                                    if ($tituloD == FALSE) {
                                        echo"<th>Tipo Exame: DEMISSIONAL</th>";
                                    }
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
                                                    echo"R$ ".$linha_valor['valor']."<br>";
                                                }
                                            ?>
                                    </td>
                                    <td>
                                    <?= date('d/m/Y', strtotime($linha['data'])); ?>
                                    </td>
                                </tr>    
                                <?php
                                $tituloD = TRUE; 
                                break;
                                case 'Monitoramento Pontual': 
                                    if ($tituloMP == FALSE) {
                                        echo"<th>Tipo Exame: MONITORAMENTO PONTUAL</th> ";
                                    }
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
                                                    echo"R$ ".$linha_valor['valor']."<br>";
                                                }
                                            ?>
                                    </td>
                                    <td>
                                    <?= date('d/m/Y', strtotime($linha['data'])); ?>
                                    </td>
                                </tr>
                                <?php
                                $tituloMP=TRUE; 
                                break;
                                case 'Mudança de Risco Ocupacional': 
                                    if ($tituloMRO == FALSE) {
                                        echo"<th>Tipo Exame: MUDANÇA DE RISCO OCUPACIONAL</th>";
                                    }
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
                                                    echo"R$ ".$linha_valor['valor']."<br>";
                                                }
                                            ?>
                                    </td>
                                    <td>
                                    <?= date('d/m/Y', strtotime($linha['data'])); ?>
                                    </td>
                                </tr>     
                                <?php
                                $tituloMRO=TRUE; 
                                break;
                                case 'Periódico': 
                                    if ($tituloP == FALSE) {
                                        echo"<th>Tipo Exame: PERIÓDICO</th>";
                                    }
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
                                                    echo"R$ ".$linha_valor['valor']."<br>";
                                                }
                                            ?>
                                    </td>
                                    <td>
                                    <?= date('d/m/Y', strtotime($linha['data'])); ?>
                                    </td>
                                </tr>           
                                <?php
                                $tituloP=TRUE; 
                                break;
                                default: 
                                        if ($tituloRT==FALSE) {
                                            echo"<th>Tipo Exame: RETORNO AO TRABALHO</th>";
                                        }
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
                                                    echo"R$ ".$linha_valor['valor']."<br>";
                                                }
                                            ?>
                                    </td>
                                    <td>
                                    <?= date('d/m/Y', strtotime($linha['data'])); ?>
                                    </td>
                                </tr>
                                <?php 
                                $tituloRT=TRUE;
                                break;
                                ?>
                                    
                            
                

                <?php 
                            } // FECHANDO SWITH CASE
                        } //FECHANDO O IF
                        array_push($ids,$linha['id_atendimento']);
                    } //FECHANDO WHILE
                ?>  
            </tbody>

                <th>
                <?="O valor total do período é: R$ ".number_format($valor_empresa,2,",",".");?>
                </th>

    </table>

<!-- <script>window.print();</script> -->
</body>
</html>