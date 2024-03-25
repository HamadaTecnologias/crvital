<?php 
    include 'bd_connect.php';
    $id_empresa=$_GET["id_empresa"];
    $id_procedimento = $_GET['id_procedimento'];
    $query = "delete from procedimento where id_procedimento =".$id_procedimento;

    if (mysqli_query($con,$query)) {
        header('location: pagina_principal.php?id_empresa='.$id_empresa);
    } else {
        echo"Erro ao excluir o Procedimento<br>";
        echo mysqli_error($con);
        echo "<br>Contate o Suporte";
    }
?>