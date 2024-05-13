<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="../assets/logo-favicon.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/relatorio_periodo.css">
    <title>Relatório por procedimento</title>
</head>


<?php 
        include "../bd_connect.php";       
        $data_inicio = $_GET['data_inicio'];
        $data_fim = $_GET['data_fim'];
        $nome_procedimento = $_GET['nome_procedimento'];
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
        // $query_valor_geral = 
        // "SELECT P.valor 
        // FROM atendimento A
        // INNER JOIN atendimento_procedimento AP ON A.id_atendimento=AP.id_atendimento
        // INNER JOIN procedimento P ON P.id_procedimento=AP.id_procedimento
        // INNER JOIN empresa E ON E.id_empresa=P.id_empresa
        // WHERE A.data BETWEEN '".$data_inicio."' and '".$data_fim."'";  
        // $result_valor_geral = mysqli_query($con,$query_valor_geral);
        // while($linha_valor_geral = mysqli_fetch_assoc($result_valor_geral)){
        //     $valor_geral = $valor_geral + $linha_valor_geral['valor'];
        // }                                                        
    ?>

<body>

    <header>
        <div class="img">
            <img src="../assets/logo-crvital-horizontal.png" alt="logo">
        </div>  
        <div class="titulo-header">
                <h2>Período de: <?= date('d/m/Y', strtotime($data_inicio)); ?> à <?= date('d/m/Y', strtotime($data_fim)); ?></h2>           
                <div class="subtitulo-header">
                    <h4>Relação por procedimento</h4>
                    <h4>Emitido em: </h4>
                    <?=$data_emissao?>
                </div>
        </div>
    </header>
    
            <table>
                <thead>
                    <tr>
                    <th scope="col">Colaborador</th>
                    <th scope="col">Médico Examinador</th>
                    <th scope="col">Valores</th>
                    <th scope="col">Realizado em</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $query = "SELECT A.id_atendimento,A.data,A.nome_paciente,A.id_empresa,E.nome_empresa,M.nome_medico,E.cnpj,P.nome_procedimento
                        FROM atendimento A
                        INNER JOIN atendimento_procedimento AP ON A.id_atendimento=AP.id_atendimento
                        INNER JOIN procedimento P ON  P.id_procedimento=AP.id_procedimento
                        INNER JOIN medico M ON  M.id_medico=A.id_medico
                        INNER JOIN empresa E ON E.id_empresa=P.id_empresa
                        WHERE P.nome_procedimento like '%".$nome_procedimento."%' AND  A.data BETWEEN '".$data_inicio."' and '".$data_fim."'
                        ORDER BY E.nome_empresa ASC;";
                        $result = mysqli_query($con,$query);
                        $ids_atendimento = array();
                        $ids_empresa = array();
                        while($linha = mysqli_fetch_assoc($result)){ 
                            
                            
                            if (!in_array($linha['id_atendimento'], $ids_atendimento)) {
                                if (!in_array($linha['id_empresa'], $ids_empresa)) {
                                    $cnpj = formatCnpjCpf($linha['cnpj']);
                                    echo"<th class='quebra'>".$linha['nome_empresa']."</th>";
                                    echo"<th> CNPJ: ".$cnpj."</th>";
                                    array_push($ids_empresa,$linha['id_empresa']);
                                }
                    ?>          

                                <tr>
                                    <td>
                                        <?= $linha['nome_paciente']; ?>
                                    </td>
                                    <td>
                                        <?= $linha['nome_medico']; ?>
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