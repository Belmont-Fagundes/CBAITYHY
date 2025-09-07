<?php
session_start();
include_once('conexao.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../index.php");
    exit();
}

$usuario_logado = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CBAITYHY - Worklist</title>
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
            <a href="#" class="hover:text-gray-200">Worklist</a>
            <a href="#" class="hover:text-gray-200">Relatórios</a>
            <a href="#" class="hover:text-gray-200">Exames excluídos</a>
            <a href="#" class="hover:text-gray-200">Médicos solicitantes</a>
            <a href="#" class="hover:text-gray-200">Configurações</a>
        </nav>

        <div class="flex flex-col items-end">
            <span class="font-semibold"><?= htmlspecialchars($usuario_logado) ?></span>
            <small>Administrador</small>
            <form method="POST" action="logout.php" class="mt-1">
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1 rounded">
                    Sair
                </button>
            </form>
        </div>
    </header>

    <!-- MAIN CONTAINER -->
    <main class="p-6">
        <h2 class="text-2xl font-bold mb-4">Worklist</h2>

        <!-- SEARCH BOX -->
        <div class="search-box bg-white rounded-lg shadow p-4 mb-6 grid grid-cols-1 md:grid-cols-4 lg:grid-cols-6 gap-3">
            <input id="unidade" type="text" placeholder="Pesquise por unidades" class="border p-2 rounded" />
            <input id="nomePaciente" type="text" placeholder="Nome do Paciente" class="border p-2 rounded" />
            <input id="modalidade" type="text" placeholder="Pesquise por modalidades" class="border p-2 rounded" />
            <input id="dataInicio" type="date" class="border p-2 rounded" />
            <input id="dataFim" type="date" class="border p-2 rounded" />
            <input id="prioridade" type="text" placeholder="Pesquise por prioridade" class="border p-2 rounded" />
            <select id="filtro" class="border p-2 rounded">
                <option value="">Filtro</option>
            </select>
            <select id="status" class="border p-2 rounded">
                <option value="">Status</option>
            </select>
            <input id="nomeExame" type="text" placeholder="Nome do exame" class="border p-2 rounded" />

            <div class="col-span-1 md:col-span-2 lg:col-span-1 flex gap-2">
                <button onclick="filtrar()" type="button" class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded">Filtrar</button>
                <button onclick="limparFiltros()" type="button" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded">Limpar</button>
            </div>
        </div>

        <!-- RESULTS BOX -->
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex justify-between mb-4">
                <button class="bg-gray-200 hover:bg-gray-300 px-3 py-1 rounded">Exibir Colunas ▾</button>
                <div class="flex gap-2 text-center">
                    <button class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded">Adicionar Exame</button>
                    <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">Enviar p/ Horos</button>
                    <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">Excluir Exames</button>
                </div>
            </div>

            <table class="w-full text-center border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border p-2 text-center">Selecionar</th>
                        <th class="border p-2 text-center">Unidade</th>
                        <th class="border p-2 text-center">Paciente</th>
                        <th class="border p-2 text-center">Pac. ID</th>
                        <th class="border p-2 text-center">Idade</th>
                        <th class="border p-2 text-center">Sexo</th>
                        <th class="border p-2 text-center">Modalidade</th>
                        <th class="border p-2 text-center">Exame</th>
                        <th class="border p-2 text-center">Data Estudo</th>
                        <th class="border p-2 text-center">Médico</th>
                        <th class="border p-2 text-center">Status</th>
                        <th class="border p-2 text-center">SLA</th>
                        <th class="border p-2 text-center">Ações</th>
                    </tr>
                </thead>
                <tbody id="tabelaResultados">
                    <tr>
                        <td colspan="13" class="text-center p-4 text-gray-500">Use os filtros acima para pesquisar.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

    <script>
    function filtrar() {
        const dados = new URLSearchParams({
            unidade: document.getElementById("unidade").value,
            paciente: document.getElementById("nomePaciente").value,
            modalidade: document.getElementById("modalidade").value,
            dataInicio: document.getElementById("dataInicio").value,
            dataFim: document.getElementById("dataFim").value,
            prioridade: document.getElementById("prioridade").value,
            filtro: document.getElementById("filtro").value,
            status: document.getElementById("status").value,
            nomeExame: document.getElementById("nomeExame").value
        });

        fetch("buscar.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: dados.toString()
        })
        .then(res => res.text())
        .then(data => {
            document.getElementById("tabelaResultados").innerHTML = data;
        })
        .catch(err => console.error("Erro:", err));
    }

    function limparFiltros() {
        document.querySelectorAll(".search-box input, .search-box select").forEach(el => el.value = "");
        document.getElementById("tabelaResultados").innerHTML =
            "<tr><td colspan='13' class='text-center p-4 text-gray-500'>Use os filtros acima para pesquisar.</td></tr>";
    }
    </script>
</body>
</html>
