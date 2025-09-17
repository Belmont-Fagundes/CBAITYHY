<?php
session_start();
include_once('conexao.php');

if (!isset($_SESSION['usuario'])) {
    die(json_encode(['success' => false, 'message' => 'Usuário não autenticado']));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $usuario = $_SESSION['usuario'];

    // Iniciar transação
    $conexao->begin_transaction();

    try {
        // Atualizar visibilidade do exame
        $stmt = $conexao->prepare("UPDATE exames SET visivel = 1 WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        // Registrar a exclusão
        $stmt = $conexao->prepare("INSERT INTO exclusao_logs (usuario, exame_id, data_hora) VALUES (?, ?, NOW())");
        $stmt->bind_param("si", $usuario, $id);
        $stmt->execute();

        $conexao->commit();
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        $conexao->rollback();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Requisição inválida']);
}