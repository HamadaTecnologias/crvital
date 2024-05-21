<?php 
include "../bd_connect.php";
$filtro_principal = $_POST['filtro_principal'];
$data_inicio = $_POST['data_inicio'];
$data_fim = $_POST['data_fim'];
$id_empresa = $_POST['id_empresa']??null;
$id_medico = $_POST['id_medico']??null;
$nome_procedimento = $_POST['nome_procedimento']??null;
$tipo_relatorio= $_POST['filtro_relatorio']??null;


session_start();

switch ($filtro_principal) {
    case 'empresa':
        switch ($tipo_relatorio) {
            case 'completo':
                header('location:relatorio_empresa_completo.php?data_inicio='.$data_inicio.'&data_fim='.$data_fim.'&id_empresa='.$id_empresa.'');
                break;
            
            default:
                header('location:relatorio_empresa.php?data_inicio='.$data_inicio.'&data_fim='.$data_fim.'&id_empresa='.$id_empresa.'');
                break;
        }
        break;
    
    case 'periodo':
        switch ($tipo_relatorio) {
            case 'completo':
                header('location:relatorio_periodo_completo.php?data_inicio='.$data_inicio.'&data_fim='.$data_fim.'');
                break;
            
            default:
                header('location:relatorio_periodo.php?data_inicio='.$data_inicio.'&data_fim='.$data_fim.'');
                break;
        }
        break;

    case 'medico':

        header('location:relatorio_medico.php?data_inicio='.$data_inicio.'&data_fim='.$data_fim.'&id_medico='.$id_medico.'');
        break;

    case 'procedimento':

        header('location:relatorio_procedimento.php?data_inicio='.$data_inicio.'&data_fim='.$data_fim.'&nome_procedimento='.$nome_procedimento.'');
        break;        
                  
        
    default:

        header('location:relatorio.php');
        break;
}
?>