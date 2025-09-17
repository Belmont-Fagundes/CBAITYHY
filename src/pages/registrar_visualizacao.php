<?php
session_start();
include_once('conexao.php');

if (!isset($_SESSION['usuario'])) {
    die(json_encode(['success' => false, 'message' => 'Usuário não autenticado']));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_SESSION['usuario'];
    $exame_id = intval($_POST['exame_id']);
    $unidade = $_POST['unidade'];
    $paciente = $_POST['paciente'];
    $medico = $_POST['medico'];
    $visualizador = $_POST['visualizador'];

    try {
        $stmt = $conexao->prepare("INSERT INTO visualizacao_logs (usuario, exame_id, unidade, paciente, medico, visualizador, data_hora) VALUES (?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("sissss", $usuario, $exame_id, $unidade, $paciente, $medico, $visualizador);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            throw new Exception($stmt->error);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método inválido']);
}