<?php 
    include "../bd_connect.php";
    $id_empresa = $_GET['id_empresa'];
    $query = "delete from empresa where id_empresa =".$id_empresa;

    if (mysqli_query($con,$query)) {

        header('location: pagina_principal.php?excluido=true');

    } else {
        echo"erro ao excluir contato";
    }
?>