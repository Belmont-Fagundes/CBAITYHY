<?php
include_once('conexao.php');

$estado_id = $_GET['estado_id'] ?? 0;
$search = $_GET['search'] ?? '';
$search = "%$search%";

$stmt = $conexao->prepare("SELECT id, nome FROM municipios WHERE estado_id = ? AND nome LIKE ? ORDER BY nome LIMIT 5");
$stmt->bind_param("is", $estado_id, $search);
$stmt->execute();
$result = $stmt->get_result();

$municipios = [];
while ($row = $result->fetch_assoc()) {
    $municipios[] = $row;
}

header('Content-Type: application/json');
echo json_encode($municipios);