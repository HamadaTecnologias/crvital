<?php 
include "../bd_connect.php";
$filtro_principal = $_POST['filtro_principal'];
$data_inicio = $_POST['data_inicio'];
$data_fim = $_POST['data_fim'];
$id_empresa = $_POST['id_empresa']??null;
$id_medico = $_POST['id_medico']??null;


session_start();

switch ($filtro_principal) {
    case 'empresa':
        header('location:historico-empresa.php?data_inicio='.$data_inicio.'&data_fim='.$data_fim.'&id_empresa='.$id_empresa.'');
        break;
    
    case 'periodo':
        header('location:historico-periodo.php?data_inicio='.$data_inicio.'&data_fim='.$data_fim.'');
        break;      
        
    default:

        header('location:pagina_principal.php');
        break;
}
?>