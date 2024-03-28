<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="script.js" defer></script>
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <div id="content">

            <?php 
            include "../bd_connect.php";
            $data_inicio = $_GET['data_inicio'];
            $data_fim = $_GET['data_fim'];
            ?>
            <table>
                <thead>
                    <tr>
                    <th scope="col">Empresa</th>
                    <th scope="col">Colaborador</th>
                    <th scope="col">Médico Atendente</th>
                    <th scope="col">Exame</th>
                    <th scope="col">Check-in</th>
                    <th scope="col">Finalizar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($consulta = $_SESSION){ ?>
                        <tr>
                            <td>
                                <?= $consulta['nome_empresa']; ?>
                            </td>
                            <td>
                                <?= $consulta['nome_paciente']; ?>
                            </td>
                            <td>
                            <?= $consulta['nome_medico']; ?>
                            </td>
                            <td>
                                <?= $consulta['tipo_exame']; ?>
                            </td>
                            <td>
                            <?= $consulta['hora_checkin']; ?>
                            </td>
                            <td>
                            <a href='cadastrar_atendimento.php?finalizar=true&id_atendimento=<?= $consulta['id_atendimento']; ?>'>FINALIZAR</a>
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