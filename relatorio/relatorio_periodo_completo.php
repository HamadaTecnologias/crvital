<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="../assets/logo-favicon.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/relatorio_periodo.css">
    <title>Relatório por período</title>
</head>


<?php 
        include "../bd_connect.php";       
        $data_inicio = $_GET['data_inicio'];
        $data_fim = $_GET['data_fim'];
        $valor_geral = 0;
        $erro = FALSE;
        if(empty($data_inicio)){
            $erro=TRUE;
            echo $data_inicio;
        }
        if(empty($data_fim)){
            $erro=TRUE;
            echo $data_fim;
        }
        if ($erro != FALSE) {
            header('location:relatorio.php?error=true');
        }
        //SELEÇÃO DA DATA DE EMISSÃO
        $query_data="SELECT DATE_FORMAT(CURDATE(), '%d/%m/%Y')";
        $result_data = mysqli_query($con,$query_data);
        $data = mysqli_fetch_assoc($result_data);
        $data_emissao = $data["DATE_FORMAT(CURDATE(), '%d/%m/%Y')"];

        //SOMATÓRIO DO VALOR DE TODOS OS EXAMES POR PERÍODO
        $query_valor_geral = 
        "SELECT P.valor 
        FROM atendimento A
        INNER JOIN atendimento_procedimento AP ON A.id_atendimento=AP.id_atendimento
        INNER JOIN procedimento P ON P.id_procedimento=AP.id_procedimento
        INNER JOIN empresa E ON E.id_empresa=P.id_empresa
        WHERE A.data BETWEEN '".$data_inicio."' and '".$data_fim."'";  
        $result_valor_geral = mysqli_query($con,$query_valor_geral);
        while($linha_valor_geral = mysqli_fetch_assoc($result_valor_geral)){
            $valor_geral = $valor_geral + $linha_valor_geral['valor'];
        }                                                        
    ?>

<body>

    <header>
        <div class="img">
            <img src="../assets/logo-crvital-horizontal-verde.png" alt="logo">
            <h1>Relatório de Atendimento</h1>
        </div> 
        <div class="nome-empresa">
            <h2>Período de: <?= date('d/m/Y', strtotime($data_inicio)); ?> à <?= date('d/m/Y', strtotime($data_fim)); ?></h2>  
            <h4>Emitido em: <?=$data_emissao?> </h4>
        </div> 
        <div class="titulo-header">
                    <?="O valor total dos procedimentos do período é: R$ ".number_format($valor_geral,2,",",".")?>
        </div>
    </header>
    
            <table>
                <thead>
                    <tr>
                    <th scope="col">Colaborador</th>
                    <th scope="col">Procedimento</th>
                    <th scope="col">Valores</th>
                    <th scope="col">Realizado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $query = "SELECT A.id_atendimento,A.data,A.nome_paciente,A.id_empresa,E.nome_empresa,E.perfil,E.cnpj,A.hora_checkin,A.hora_checkout
                        FROM atendimento A
                        INNER JOIN atendimento_procedimento AP ON A.id_atendimento=AP.id_atendimento
                        INNER JOIN procedimento P ON  P.id_procedimento=AP.id_procedimento
                        INNER JOIN empresa E ON E.id_empresa=P.id_empresa
                        WHERE  A.data BETWEEN '".$data_inicio."' and '".$data_fim."'
                        ORDER BY E.nome_empresa ASC, A.nome_paciente ASC;";
                        $result = mysqli_query($con,$query);
                        $ids_atendimento = array();
                        $ids_empresa = array();
                        while($linha = mysqli_fetch_assoc($result)){ 
                            
                            
                            if (!in_array($linha['id_atendimento'], $ids_atendimento)) {
                                if (!in_array($linha['id_empresa'], $ids_empresa)) {
                                    $cnpj = formatCnpjCpf($linha['cnpj']);
                                    //VALOR DOS PROCEDIMENTOS POR EMPRESA
                                    $valor_empresa = 0;
                                    $query_valor_empresa = "SELECT P.valor 
                                    FROM atendimento A
                                    INNER JOIN atendimento_procedimento AP ON A.id_atendimento=AP.id_atendimento
                                    INNER JOIN procedimento P ON P.id_procedimento=AP.id_procedimento
                                    INNER JOIN empresa E ON E.id_empresa=P.id_empresa
                                    WHERE A.data BETWEEN '".$data_inicio."' and '".$data_fim."' AND  A.id_empresa=".$linha['id_empresa'];  
                                    $result_valor_empresa = mysqli_query($con,$query_valor_empresa);
                                    while($linha_valor_empresa = mysqli_fetch_assoc($result_valor_empresa)){
                                        $valor_empresa = $valor_empresa + $linha_valor_empresa['valor'];
                                    }


                                    echo"<th class='quebra'>".$linha['nome_empresa']."</th>";
                                    echo"<th> CNPJ: ".$cnpj."</th>";
                                    echo"<th>R$ ".number_format($valor_empresa,2,",",".")."</th>";
                                    array_push($ids_empresa,$linha['id_empresa']);
                                }
                    ?>          

                                <tr>
                                    <td class="nome-paciente">
                                        <?= $linha['nome_paciente']; ?>
                                    </td>
                                    <td>
                                        <?php 
                                            $query_nome_procedimento = "SELECT P.nome_procedimento
                                            FROM atendimento A
                                            INNER JOIN atendimento_procedimento AP ON A.id_atendimento=AP.id_atendimento
                                            INNER JOIN procedimento P ON P.id_procedimento=AP.id_procedimento
                                            INNER JOIN empresa E ON E.id_empresa=P.id_empresa
                                            WHERE A.data BETWEEN '".$data_inicio."' and '".$data_fim."' AND  A.id_atendimento=".$linha['id_atendimento']." ORDER BY P.nome_procedimento ASC";  
                                            $result_nome = mysqli_query($con,$query_nome_procedimento);
                                            while($linha_nome = mysqli_fetch_assoc($result_nome)){
                                            echo  $linha_nome['nome_procedimento']."<br>";
                                    }?>
                                    </td>
                                    <td>
                                        <?php 
                                            $query_valor_procedimento = "SELECT P.valor 
                                            FROM atendimento A
                                            INNER JOIN atendimento_procedimento AP ON A.id_atendimento=AP.id_atendimento
                                            INNER JOIN procedimento P ON P.id_procedimento=AP.id_procedimento
                                            INNER JOIN empresa E ON E.id_empresa=P.id_empresa
                                            WHERE A.data BETWEEN '".$data_inicio."' and '".$data_fim."' AND  A.id_atendimento=".$linha['id_atendimento']." ORDER BY P.nome_procedimento ASC";    
                                            $result_valor = mysqli_query($con,$query_valor_procedimento);
                                            while($linha_valor = mysqli_fetch_assoc($result_valor)){
                                            echo"R$ ".$linha_valor['valor']."<br>";
                                        }?>
                                    </td>
                                    <td>
                                        
                                        <?= date('d/m/Y', strtotime($linha['data'])); ?>
                                        <td style="text-align: center">
                                        <?= date('H:i', strtotime($linha['hora_checkin'])); ?>
                                            <p>às</p>
                                            <?= date('H:i', strtotime($linha['hora_checkout'])); ?>
                                        </td>
                               

                                    </td> 
                                </tr>                             
                                
                    <?php 
                            } //FECHANDO O IF
                            array_push($ids_atendimento,$linha['id_atendimento']);                   
                        } //FECHANDO WHILE
                    ?>   
                </tbody>
            </table> 
<script>window.print();</script>
<?php
function formatCnpjCpf($value){
        $CPF_LENGTH = 11;
        $cnpj_cpf = preg_replace("/\D/", '', $value);
        if (strlen($cnpj_cpf) === $CPF_LENGTH) {
            return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf);
        } 
        return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
} ?>
</body>
</html>