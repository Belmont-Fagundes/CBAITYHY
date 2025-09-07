<?php
include_once("conexao.php");

$unidade   = $_POST['unidade']   ?? '';
$paciente  = $_POST['paciente']  ?? '';
$modalidade= $_POST['modalidade']?? '';
$dataInicio= $_POST['dataInicio']?? '';
$dataFim   = $_POST['dataFim']   ?? '';
$prioridade= $_POST['prioridade']?? '';
$filtro    = $_POST['filtro']    ?? '';
$status    = $_POST['status']    ?? '';
$nomeExame = $_POST['nomeExame'] ?? '';

// Se todos os campos estiverem vazios, não faz busca e mostra mensagem
if (
    empty($unidade) && empty($paciente) && empty($modalidade) &&
    empty($dataInicio) && empty($dataFim) && empty($prioridade) &&
    empty($filtro) && empty($status) && empty($nomeExame)
) {
    echo "<tr><td colspan='13' class='p-4 text-gray-500 text-center'>Digite para pesquisar.</td></tr>";
    exit;
}

$query = "SELECT * FROM exames WHERE 1=1";

if ($unidade)    $query .= " AND unidade LIKE '%".$conexao->real_escape_string($unidade)."%'";
if ($paciente)   $query .= " AND paciente LIKE '%".$conexao->real_escape_string($paciente)."%'";
if ($modalidade) $query .= " AND modalidade LIKE '%".$conexao->real_escape_string($modalidade)."%'";
if ($dataInicio) $query .= " AND data_estudo >= '".$conexao->real_escape_string($dataInicio)."'";
if ($dataFim)    $query .= " AND data_estudo <= '".$conexao->real_escape_string($dataFim)."'";
if ($prioridade) $query .= " AND prioridade LIKE '%".$conexao->real_escape_string($prioridade)."%'";
if ($status)     $query .= " AND status LIKE '%".$conexao->real_escape_string($status)."%'";
if ($nomeExame)  $query .= " AND exame LIKE '%".$conexao->real_escape_string($nomeExame)."%'";
if ($filtro)     $query .= " AND filtro LIKE '%".$conexao->real_escape_string($filtro)."%'";

$query .= " ORDER BY data_estudo DESC";

$result = $conexao->query($query);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr class='hover:bg-gray-50'>";
        echo "<td class='border p-2'><input type='checkbox'></td>";
        echo "<td class='border p-2'>{$row['unidade']}</td>";
        echo "<td class='border p-2'>{$row['paciente']}</td>";
        echo "<td class='border p-2'>{$row['pac_id']}</td>";
        echo "<td class='border p-2'>{$row['idade']}</td>";
        echo "<td class='border p-2'>{$row['sexo']}</td>";
        echo "<td class='border p-2'>{$row['modalidade']}</td>";
        echo "<td class='border p-2'>{$row['exame']}</td>";
        echo "<td class='border p-2'>{$row['data_estudo']}</td>";
        echo "<td class='border p-2'>{$row['medico']}</td>";
        echo "<td class='border p-2'>{$row['status']}</td>";
        echo "<td class='border p-2'>{$row['sla']}</td>";

        $acoes = '';
        $arquivos = explode(',', $row['acoes']);
        foreach ($arquivos as $arquivo) {
            $arquivo = trim($arquivo);
            if ($arquivo) {
                $url = rtrim($row['caminho'], '/') . '/' . rawurlencode($arquivo);
                $acoes .= "<a class='text-indigo-500 hover:underline' href='weasis://$url'>Abrir</a> | ";
                $acoes .= "<a class='text-green-500 hover:underline' href='$url' download>Baixar</a><br>";
            }
        }
        echo "<td class='border p-2'>$acoes</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='13' class='p-4 text-gray-500 text-center'>Nenhum registro encontrado.</td></tr>";
}
