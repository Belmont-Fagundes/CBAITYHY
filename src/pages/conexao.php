<?php
$conexao = new mysqli("localhost", "root", "", "equipcbaityhy");

if ($conexao->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conexao->connect_error);
}
?>
