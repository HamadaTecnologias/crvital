<?php 

    include 'bd_connect.php';
    $id_empresa = $_GET['id_empresa'];
    $query = "update empresa set status = true where id_empresa =".$id_empresa;

    if(mysqli_query($con,$query)){
        header('location:pagina_principal.php?liberado=true');
    }else{
        echo "Erro ao liberar Emrpresa: <br>";
        echo mysqli_error($con);
        echo "<br>Contate o Suporte";
    }  
?>