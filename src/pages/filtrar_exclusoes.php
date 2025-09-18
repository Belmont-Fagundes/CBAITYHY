<?php
session_start();
include_once('conexao.php');

if (!isset($_SESSION['usuario'])) {
    die('Usuário não autenticado');
}

$where = [];
$params = [];
$types = '';

if (!empty($_POST['unidade'])) {
    $where[] = "unidade = ?";
    $params[] = $_POST['unidade'];
    $types .= 's';
}

if (!empty($_POST['dataInicio'])) {
    $where[] = "DATE(data_hora) >= ?";
    $params[] = $_POST['dataInicio'];
    $types .= 's';
}

if (!empty($_POST['dataFim'])) {
    $where[] = "DATE(data_hora) <= ?";
    $params[] = $_POST['dataFim'];
    $types .= 's';
}

$sql = "SELECT el.*, e.unidade, e.paciente, e.medico,
        DATE_FORMAT(el.data_hora, '%d/%m/%Y %H:%i') as data_formatada 
        FROM exclusao_logs el
        JOIN exames e ON el.exame_id = e.id";

if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

$sql .= " ORDER BY el.data_hora DESC";

$stmt = $conexao->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr class='border-b hover:bg-gray-50'>";
        echo "<td class='border p-2 text-left'>{$row['data_formatada']}</td>";
        echo "<td class='border p-2 text-left'>{$row['unidade']}</td>";
        echo "<td class='border p-2 text-left'>{$row['paciente']}</td>";
        echo "<td class='border p-2 text-left'>{$row['medico']}</td>";
        echo "<td class='border p-2 text-left'>{$row['usuario']}</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5' class='text-center p-4'>Nenhum registro encontrado.</td></tr>";
}