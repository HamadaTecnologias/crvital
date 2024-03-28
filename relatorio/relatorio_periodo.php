<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="script.js" defer></script>
    <link rel="stylesheet" href="../assets/css/relatorio_periodo.css">
    <title>Document</title>
</head>
<body>
    <div id="content">

    <?php 
        include "../bd_connect.php";
        
        $data_inicio = $_GET['data_inicio'];
        $data_fim = $_GET['data_fim'];
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
            echo"Confira as datas selecionadas";
        }

        $query_hora="SELECT TIME_FORMAT(CURTIME(), '%H:%i')";
        $result = mysqli_query($con,$query_hora);
        $hora = mysqli_fetch_assoc($result);
        $hora_emissao = $hora["TIME_FORMAT(CURTIME(), '%H:%i')"];
       
        //criando array com os ids das empresas
        $query_valid="select id_empresa from empresa";
        $empresa = mysqli_query($con,$query_valid);
        $ids = array();
        while($linha = mysqli_fetch_assoc($empresa)){
            array_push($ids,$linha['id_empresa']);
        }

        
    ?>
            <table>
                <thead>
                    <tr>
                    <th scope="col">Colaborador</th>
                    <th scope="col">Procedimento</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Realizado em</th>
                    <th scope="col">Empresa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $query = "SELECT A.id_atendimento,A.data,A.nome_paciente,P.nome_procedimento,P.valor,E.nome_empresa,E.perfil,E.cnpj 
                        FROM atendimento A
                        INNER JOIN atendimento_procedimento AP ON A.id_atendimento=AP.id_atendimento
                        INNER JOIN procedimento P ON  P.id_procedimento=AP.id_procedimento
                        INNER JOIN empresa E ON E.id_empresa=P.id_empresa
                        WHERE  A.data BETWEEN '".$data_inicio."' and '".$data_fim."'
                        ORDER BY E.nome_empresa ASC, A.data ASC;";

                        $query_procedimento = "SELECT P.nome_procedimento,P.valor 
                        FROM atendimento A
                        INNER JOIN atendimento_procedimento AP ON A.id_atendimento=AP.id_atendimento
                        INNER JOIN procedimento P ON p.ide_procedimento=AP.id_procedimento
                        INNER JOIN empresa E ON E.id_empresa=P.id_empresa
                        WHERE A.id_atendimento=".$linha['id_atendimento']." AND A.data BETWEEN '".$data_inicio."' and '".$data_fim."' ORDER BY E.nome_empresa ASC, A.data ASC;";

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
                </tbody>
            </table> 



    </div>
    <button id="generate-pdf">GERAR PDF</button>
</body>
</html>