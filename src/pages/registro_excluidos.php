<?php
session_start();
include_once('conexao.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../index.php");
    exit();
}

$usuario_logado = $_SESSION['usuario'];

// Busca lista distinta de unidades dos exames excluídos
$query_unidades = "SELECT DISTINCT e.unidade 
                   FROM exclusao_logs el
                   JOIN exames e ON el.exame_id = e.id 
                   ORDER BY e.unidade";
$result_unidades = $conexao->query($query_unidades);
$unidades = [];
while ($row = $result_unidades->fetch_assoc()) {
    $unidades[] = $row['unidade'];
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CBAITYHY - Registro de Exclusões</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800 font-sans">
    <!-- HEADER -->
    <header class="bg-indigo-600 text-white shadow-md flex justify-between items-center px-6 py-4">
        <div class="flex items-center gap-3">
            <img src="../images/logo.png" alt="cloud" class="w-10 h-10" />
            <h1 class="text-2xl font-bold">CBAITYHY</h1>
        </div>

        <nav class="hidden md:flex gap-6 text-sm font-medium">
            <a href="#" class="hover:text-gray-200">Dashboard</a>
            <a href="homePage.php" class="hover:text-gray-200">Worklist</a>
            <a href="#" class="hover:text-gray-200">Relatórios</a>
            <a href="registro_excluidos.php" class="text-yellow-300 hover:text-yellow-200">Exames excluídos</a>
            <a href="#" class="hover:text-gray-200">Médicos solicitantes</a>
            <a href="#" class="hover:text-gray-200">Configurações</a>
        </nav>

        <div class="flex flex-col items-end">
            <span class="font-semibold"><?= htmlspecialchars($usuario_logado) ?></span>
            <small>Administrador</small>
            <form method="POST" action="logout.php" class="mt-1">
                <button type="submit"
                    class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1 rounded">Sair</button>
            </form>
        </div>
    </header>

    <!-- MAIN CONTAINER -->
    <main class="p-6">
        <h2 class="text-2xl font-bold mb-4">Registro de Exclusões</h2>

        <!-- SEARCH BOX -->
        <div class="bg-white rounded-lg shadow p-4 mb-6 grid grid-cols-1 md:grid-cols-3 gap-3">
            <select id="unidade" class="border p-2 rounded">
                <option value="">Todas as unidades</option>
                <?php foreach ($unidades as $unidade): ?>
                    <option value="<?= htmlspecialchars($unidade) ?>"><?= htmlspecialchars($unidade) ?></option>
                <?php endforeach; ?>
            </select>
            <input id="dataInicio" type="date" class="border p-2 rounded" />
            <input id="dataFim" type="date" class="border p-2 rounded" />
            <div class="col-span-1 md:col-span-3 flex gap-2">
                <button onclick="filtrar()"
                    class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded">Filtrar</button>
                <button onclick="limparFiltros()"
                    class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded">Limpar</button>
            </div>
        </div>

        <!-- RESULTS BOX -->
        <div class="bg-white rounded-lg shadow p-4">
            <table class="w-full text-sm border-collapse">
                <thead>
                    <tr class="bg-indigo-100 border-b-2 border-indigo-200">
                        <th class="border p-2 text-left">DATA/HORA</th>
                        <th class="border p-2 text-left">UNIDADE</th>
                        <th class="border p-2 text-left">PACIENTE</th>
                        <th class="border p-2 text-left">MÉDICO</th>
                        <th class="border p-2 text-left">EXCLUÍDO POR</th>
                    </tr>
                </thead>
                <tbody id="tabelaResultados">
                    <?php
                    $query = "SELECT el.*, e.unidade, e.paciente, e.medico, 
                              DATE_FORMAT(el.data_hora, '%d/%m/%Y %H:%i') as data_formatada 
                              FROM exclusao_logs el
                              JOIN exames e ON el.exame_id = e.id 
                              ORDER BY el.data_hora DESC";
                    $result = $conexao->query($query);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr class='border-b hover:bg-gray-50'>";
                            echo "<td class='p-2'>{$row['data_formatada']}</td>";
                            echo "<td class='p-2'>{$row['unidade']}</td>";
                            echo "<td class='p-2'>{$row['paciente']}</td>";
                            echo "<td class='p-2'>{$row['medico']}</td>";
                            echo "<td class='p-2'>{$row['usuario']}</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center p-4'>Nenhum registro encontrado.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <script>
        function filtrar() {
            const unidade = document.getElementById('unidade').value;
            const dataInicio = document.getElementById('dataInicio').value;
            const dataFim = document.getElementById('dataFim').value;

            fetch('filtrar_exclusoes.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `unidade=${encodeURIComponent(unidade)}&dataInicio=${dataInicio}&dataFim=${dataFim}`
            })
                .then(response => response.text())
                .then(html => {
                    document.getElementById('tabelaResultados').innerHTML = html;
                });
        }

        function limparFiltros() {
            document.getElementById('unidade').value = '';
            document.getElementById('dataInicio').value = '';
            document.getElementById('dataFim').value = '';
            filtrar();
        }
    </script>
</body>

</html>