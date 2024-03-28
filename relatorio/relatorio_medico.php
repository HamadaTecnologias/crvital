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
    <?php 
        include "../bd_connect.php";
        $data_inicio = $_GET['data_inicio'];
        $data_fim = $_GET['data_fim'];
        $id_medico = $_GET['id_medico'];
        if ($id_medico = null) {
            echo"Escolha ao menos um medico";
        };
    ?>
    <div id="content">

    </div>
    
</body>
</html>