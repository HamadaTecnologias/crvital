<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<?php 
            include "bd_connect.php";
            $query_empresa="select cnpj from empresa where id_empresa=5;";
            $result= mysqli_query($con,$query_empresa);
            $empresa = mysqli_fetch_assoc($result); 
            echo $empresa['cnpj'];
            echo"<br>";
           $teste = formatCnpjCpf($empresa['cnpj']);
           echo $teste;




function formatCnpjCpf($value)
{
  $CPF_LENGTH = 11;
  $cnpj_cpf = preg_replace("/\D/", '', $value);
  
  if (strlen($cnpj_cpf) === $CPF_LENGTH) {
    return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf);
  } 
  
  return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
}
            ?>

</body>
</html>