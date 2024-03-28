<?php

    $host = 'localhost';
    $user = 'root';
    $password = '';
    $database = 'crvital';

    $con = mysqli_connect($host, $user, $password, $database); //remover daqui se quiser logar que entrou no BD

    // if($con = mysqli_connect($host, $user, $password, $database)){
    //     echo "Database connected successfully!";
    // }

    if (mysqli_connect_error()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
      }
?>



<!-- $query = "SELECT A.data,A.nome_paciente,P.nome_procedimento,P.valor,E.nome_empresa,E.perfil,E.cnpj FROM atendimento A
        INNER JOIN atendimento_procedimento AP ON A.id_atendimento=AP.id_atendimento
        INNER JOIN procedimento P ON  P.id_procedimento=AP.id_procedimento
        INNER JOIN empresa E ON E.id_empresa=E.id_empresa
        WHERE E.id_empresa =".$id_empresa."AND A.data BETWEEN '".$data_inicio."' and '".$data_fim."'"; -->