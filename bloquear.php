<?php 

    include 'bd_connect.php';


    $id_empresa = $_GET['id_empresa'];

    $query = "update empresa set status = false where id_empresa =".$id_empresa;
    if(mysqli_query($con,$query)){
        echo "Empresa bloqueada com sucesso";
    }else{
        echo "Erro ao bloquear Emrpresa: <br>";
        echo mysqli_error($con);
        echo "<br>Contate o Suporte";
    }  


?>