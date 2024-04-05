<?php 
include "../bd_connect.php";

$id_empresa = $_GET['id_empresa'];
$query_empresa_original = "SELECT E.nome_empresa,E.cnpj,E.perfil,E.forma_pagamento,P.nome_procedimento,P.valor 
FROM empresa E
INNER JOIN procedimento P ON P.id_empresa=E.id_empresa
WHERE E.id_empresa=".$id_empresa;
$result_empresa_original = mysqli_query($con,$query_empresa_original);
while($linha_empresa_original = mysqli_fetch_assoc($result_empresa_original)){

}

?>