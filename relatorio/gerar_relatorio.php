<?php 
include "../bd_connect.php";
$filtro_principal = $_POST['filtro_principal'];
$data_inicio = $_POST['data_inicio'];
$data_fim = $_POST['data_fim'];
$id_empresa = $_POST['id_empresa']??null;
$id_medico = $_POST['id_medico']??null;




switch ($filtro_principal) {
    case 'empresa':
        $query_empresa="";
        break;
    
    case 'periodo':
        $query_periodo="";
        break;

    case 'medico':
        $query_medico="";
        break;        
        
    default:
        # code...
        break;
}
?>