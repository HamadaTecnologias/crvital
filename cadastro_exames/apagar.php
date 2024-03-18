<?php 
    include 'bd_connect.php';
    $id_procedimento = $_GET['id_procedimento'];
    $query = "delete from procedimento where id_procedimento =".$id_procedimento;

    if (mysqli_query($con,$query)) {
        echo"Procedimento excluído";
    } else {
        echo"erro ao excluir Procedimento";
    }
?>