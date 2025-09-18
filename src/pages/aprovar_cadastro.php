<?php
session_start();
include_once('conexao.php');

if (!isset($_SESSION['usuario']) || !isset($_SESSION['cargo']) || $_SESSION['cargo'] != 'ADM CBA') {
    die(json_encode(['success' => false, 'message' => 'Não autorizado']));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $cadastro_id = intval($_POST['id']);

    try {
        $conexao->begin_transaction();

        // Atualiza o status para aprovado
        $stmt = $conexao->prepare("UPDATE cadastros SET aprovado = 1 WHERE id = ?");
        $stmt->bind_param("i", $cadastro_id);

        if (!$stmt->execute()) {
            throw new Exception("Erro ao atualizar status: " . $stmt->error);
        }

        // Registra o log de aprovação
        $stmt = $conexao->prepare("INSERT INTO aprovacao_logs (cadastro_id, nome_cadastro, nome_aprovador, data_hora) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("iss", $cadastro_id, $_POST['nome'], $_SESSION['usuario']);

        if (!$stmt->execute()) {
            throw new Exception("Erro ao registrar log: " . $stmt->error);
        }

        $conexao->commit();
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        $conexao->rollback();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Requisição inválida']);
}