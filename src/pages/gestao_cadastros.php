<?php
session_start();
include_once('conexao.php');

// Verifica se é ADM CBA
if (!isset($_SESSION['usuario']) || !isset($_SESSION['cargo']) || $_SESSION['cargo'] != 'ADM CBA') {
    header("Location: ../../index.php");
    exit();
}

// Busca cadastros pendentes
$query = "SELECT * FROM cadastros WHERE aprovado = 0";
$result = $conexao->query($query);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Cadastros - CBAITYHY</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-indigo-600 text-white shadow-md">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <img src="../images/logo.png" alt="cloud" class="w-10 h-10" />
                    <h1 class="text-2xl font-bold">CBAITYHY</h1>
                </div>

                <nav class="hidden md:flex gap-6 text-sm font-medium">
                    <a href="homePage.php" class="hover:text-gray-200">Dashboard</a>
                    <a href="homePage.php" class="hover:text-gray-200">Worklist</a>
                    <a href="#" class="hover:text-gray-200">Relatórios</a>
                    <?php if ($_SESSION['cargo'] === 'ADM CBA'): ?>
                        <a href="gestao_cadastros.php" class="text-yellow-300 hover:text-yellow-200">Gestão de Cadastros</a>
                    <?php endif; ?>
                    <a href="registro_excluidos.php" class="hover:text-gray-200">Exames excluídos</a>
                    <a href="#" class="hover:text-gray-200">Médicos solicitantes</a>
                    <a href="#" class="hover:text-gray-200">Configurações</a>
                </nav>

                <div class="flex flex-col items-end">
                    <span class="font-semibold"><?= htmlspecialchars($_SESSION['usuario']) ?></span>
                    <small><?= htmlspecialchars($_SESSION['cargo']) ?></small>
                    <form method="POST" action="logout.php" class="mt-1">
                        <button type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1 rounded">Sair</button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Gestão de Cadastros Pendentes</h1>
            <a href="homePage.php" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">Voltar</a>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cargo
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">UBS
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4"><?= htmlspecialchars($row['nome']) ?></td>
                                <td class="px-6 py-4"><?= htmlspecialchars($row['email']) ?></td>
                                <td class="px-6 py-4"><?= htmlspecialchars($row['cargo']) ?></td>
                                <td class="px-6 py-4"><?= htmlspecialchars($row['ubs']) ?></td>
                                <td class="px-6 py-4">
                                    <button
                                        onclick="aprovarCadastro(<?= $row['id'] ?>, '<?= htmlspecialchars($row['nome']) ?>')"
                                        class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                                        Aprovar
                                    </button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                Nenhum cadastro pendente encontrado
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <script>
        function aprovarCadastro(id, nome) {
            if (confirm(`Confirma a aprovação do cadastro de ${nome}?`)) {
                fetch('aprovar_cadastro.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id=${id}&nome=${encodeURIComponent(nome)}`
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Cadastro aprovado com sucesso!');
                            location.reload();
                        } else {
                            alert('Erro ao aprovar cadastro: ' + (data.message || 'Erro desconhecido'));
                        }
                    })
                    .catch(error => {
                        console.error('Erro:', error);
                        alert('Erro ao processar a requisição');
                    });
            }
        }
    </script>
</body>

</html>