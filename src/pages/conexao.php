<?php
$dbHost = 'mysql';
$dbUsername = 'root';
$dbPassword = 'root';
$dbName = 'empresa';

$conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

/* if($conexao->connect_errno)
{
  echo "Erro";
}
else 
{
 echo "Conexão efetuada com sucesso.";
} */
?>