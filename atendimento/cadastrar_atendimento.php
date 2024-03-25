<?php 
$id_empresa = $_POST['id_empresa'];
$forma_pagamento = $_POST['forma_pagamento'];
$tipo_atendimento = $_POST['tipo_atendimento'];
$tipo_exame = $_POST['tipo_exame'];
$id_medico = $_POST['id_medico'];
// $hora_checkin
// $hora_checkout
$data = $_POST['data_atendimento'];
$nome_paciente =$_POST['nome_paciente'];


$ids_procedimentos=null;
if (isset($_POST['id_procedimento']))
    $ids_procedimentos = $_POST['id_procedimento'];


if ($ids_procedimentos !== null) {
    for ($i=0; $i < count($ids_procedimentos) ; $i++) { 
        echo"<p>{$ids_procedimentos[$i]}</p>";
    }
}





?>