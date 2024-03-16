<?php 
    include 'bd_connect.php';
    $id_empresa = $_GET['id_empresa'];
    $query = "delete from empresa where id_empresa =".$id_empresa;

    if (mysqli_query($con,$query)) {
        echo"contato excluído";
    } else {
        echo"erro ao excluir contato";
    }
?>