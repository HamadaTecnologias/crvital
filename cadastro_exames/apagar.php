<?php 
    include 'bd_connect.php';
    $id_procedimento = $_GET['id_procedimento'];
    $query = "delete from procedimento where id_procedimento =".$id_procedimento;

    if (mysqli_query($con,$query)) {
        header('location: pagina_principal.php?excluido=true');
    } else {
        echo"Erro ao excluir o Procedimento<br>";
        echo mysqli_error($con);
        echo "<br>Contate o Suporte";
    }
?>