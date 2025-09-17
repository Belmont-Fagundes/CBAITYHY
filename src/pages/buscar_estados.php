<?php
include_once('conexao.php');

// Ensure proper error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get and sanitize search parameter
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$search = "%$search%";

try {
    // Prepare and execute query
    $stmt = $conexao->prepare("SELECT id, nome FROM estados WHERE nome LIKE ? ORDER BY nome LIMIT 5");
    if (!$stmt) {
        throw new Exception($conexao->error);
    }

    $stmt->bind_param("s", $search);
    if (!$stmt->execute()) {
        throw new Exception($stmt->error);
    }

    $result = $stmt->get_result();

    // Fetch results
    $estados = [];
    while ($row = $result->fetch_assoc()) {
        $estados[] = $row;
    }

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($estados);

} catch (Exception $e) {
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['error' => $e->getMessage()]);
}