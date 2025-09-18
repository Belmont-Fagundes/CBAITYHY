<?php
session_start();
include_once('conexao.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../index.php");
    exit();
}

$usuario_logado = $_SESSION['usuario'];
<<<<<<< HEAD
=======

// Buscar o cargo do usuário
$stmt = $conexao->prepare("SELECT cargo FROM cadastros WHERE email = ?");
$stmt->bind_param("s", $usuario_logado);
$stmt->execute();
$result = $stmt->get_result();
$cargo = "Usuário"; // Valor padrão caso não encontre

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $cargo = $row['cargo'];
}
>>>>>>> master
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
<<<<<<< HEAD
            <a href="#" class="hover:text-gray-200">Worklist</a>
            <a href="#" class="hover:text-gray-200">Relatórios</a>
            <a href="#" class="hover:text-gray-200">Exames excluídos</a>
=======
            <a href="#" class="text-yellow-300 hover:text-yellow-200">Worklist</a>
            <a href="#" class="hover:text-gray-200">Relatórios</a>
            <?php if (isset($_SESSION['cargo']) && $_SESSION['cargo'] === 'ADM CBA'): ?>
                <a href="gestao_cadastros.php" class="hover:text-gray-200">Gestão de Cadastros</a>
            <?php endif; ?>
            <a href="registro_excluidos.php" class="hover:text-gray-200">Exames excluídos</a>
>>>>>>> master
            <a href="#" class="hover:text-gray-200">Médicos solicitantes</a>
            <a href="#" class="hover:text-gray-200">Configurações</a>
        </nav>

        <div class="flex flex-col items-end">
            <span class="font-semibold"><?= htmlspecialchars($usuario_logado) ?></span>
<<<<<<< HEAD
            <small>Administrador</small>
=======
            <small><?= htmlspecialchars($cargo) ?></small>
>>>>>>> master
            <form method="POST" action="logout.php" class="mt-1">
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1 rounded">
                    Sair
                </button>
            </form>
        </div>
    </header>
<<<<<<< HEAD

=======
>>>>>>> master
    <!-- MAIN CONTAINER -->
    <main class="p-6">
        <h2 class="text-2xl font-bold mb-4">Worklist</h2>

        <!-- SEARCH BOX -->
<<<<<<< HEAD
        <div class="search-box bg-white rounded-lg shadow p-4 mb-6 grid grid-cols-1 md:grid-cols-4 lg:grid-cols-6 gap-3">
=======
        <div class="bg-white rounded-lg shadow p-4 mb-6 grid grid-cols-1 md:grid-cols-4 lg:grid-cols-6 gap-3">
            <!-- <input id="pacId" type="text" placeholder="Pac. ID" class="border p-2 rounded" /> -->
>>>>>>> master
            <input id="unidade" type="text" placeholder="Pesquise por unidades" class="border p-2 rounded" />
            <input id="nomePaciente" type="text" placeholder="Nome do Paciente" class="border p-2 rounded" />
            <input id="modalidade" type="text" placeholder="Pesquise por modalidades" class="border p-2 rounded" />
            <input id="dataInicio" type="date" class="border p-2 rounded" />
            <input id="dataFim" type="date" class="border p-2 rounded" />
            <input id="prioridade" type="text" placeholder="Pesquise por prioridade" class="border p-2 rounded" />
            <select id="filtro" class="border p-2 rounded">
<<<<<<< HEAD
                <option value="">Filtro</option>
            </select>
            <select id="status" class="border p-2 rounded">
                <option value="">Status</option>
=======
                <option>Filtro</option>
            </select>
            <select id="status" class="border p-2 rounded">
                <option>Status</option>
>>>>>>> master
            </select>
            <input id="nomeExame" type="text" placeholder="Nome do exame" class="border p-2 rounded" />

            <div class="col-span-1 md:col-span-2 lg:col-span-1 flex gap-2">
<<<<<<< HEAD
                <button onclick="filtrar()" type="button" class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded">Filtrar</button>
                <button onclick="limparFiltros()" type="button" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded">Limpar</button>
=======
                <button onclick="filtrar()"
                    class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded">Filtrar</button>
                <button onclick="limparFiltros()"
                    class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded">Limpar</button>
>>>>>>> master
            </div>
        </div>

        <!-- RESULTS BOX -->
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex justify-between mb-4">
                <button class="bg-gray-200 hover:bg-gray-300 px-3 py-1 rounded">Exibir Colunas ▾</button>
<<<<<<< HEAD
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
=======
                <div class="flex gap-2">
                    <button class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded">Adicionar
                        Exame</button>
                </div>
            </div>

            <!-- Modal de Confirmação -->
            <div id="modalExcluir"
                class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
                <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                    <div class="mt-3">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 text-center">Confirmar Exclusão</h3>
                        <div class="mt-2 px-7 py-3">
                            <p class="mb-2"><strong>Unidade:</strong> <span id="modalUnidade"></span></p>
                            <p class="mb-2"><strong>Paciente:</strong> <span id="modalPaciente"></span></p>
                            <p class="mb-2"><strong>Médico:</strong> <span id="modalMedico"></span></p>
                        </div>
                        <div class="flex justify-center gap-4 mt-4">
                            <button id="btnConfirmarExclusao"
                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md">
                                Confirmar Exclusão
                            </button>
                            <button onclick="fecharModal()"
                                class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-md">
                                Cancelar
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <table class="w-full text-sm border-collapse">
                <thead>
                    <tr class="bg-indigo-100">
                        <th class="border p-3 text-left">UNIDADE</th>
                        <th class="border p-3 text-left">PACIENTE</th>
                        <th class="border p-3 text-left">IDADE</th>
                        <th class="border p-3 text-left">SEXO</th>
                        <th class="border p-3 text-left">MOD.</th>
                        <th class="border p-3 text-left">EXAME</th>
                        <th class="border p-3 text-left">DATA DO EXAME</th>
                        <th class="border p-3 text-left">MÉDICO</th>
                        <th class="border p-3 text-left">STATUS</th>
                        <th class="border p-3 text-center">AÇÕES</th>
                    </tr>
                </thead>
                <tbody id="tabelaResultados">
                    <?php
                    $query = "SELECT * FROM exames WHERE visivel = 0 ORDER BY data_exame DESC";
                    $result = $conexao->query($query);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $acoes = '<div class="flex items-center justify-center space-x-4">';  // Changed to space-x-4 for consistent spacing
                            $ip = "186.227.199.181"; // IP externo (OHIF, Orthanc e PACS Connector)
                    
                            $studyUID = isset($row['study_uid']) ? trim($row['study_uid']) : null;
                            $link_ohif = "http://$ip:8050/viewer/" . urlencode($studyUID);

                            // OHIF button
                            $acoes .= "<button onclick=\"registrarVisualizacao({$row['id']}, '{$row['unidade']}', '{$row['paciente']}', '{$row['medico']}', 'OHIF', '$link_ohif')\" 
                                class='bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded text-sm w-20'>OHIF</button>";

                            // Weasis button
                            if (!empty($studyUID)) {
                                $manifest_url = "http://$ip:8080/weasis-pacs-connector/manifest?studyUID=" . urlencode($studyUID);
                                $weasis_url = "weasis://$manifest_url";
                                $acoes .= "<button onclick=\"registrarVisualizacao({$row['id']}, '{$row['unidade']}', '{$row['paciente']}', '{$row['medico']}', 'Weasis', '$weasis_url')\" 
                                    class='bg-green-500 hover:bg-green-600 text-white px-3 py-1.5 rounded text-sm w-20'>Weasis</button>";
                            }


                            $acoes .= "<button onclick=\"abrirModalExcluir({$row['id']}, '{$row['unidade']}', '{$row['paciente']}', '{$row['medico']}')\" 
                                class='bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded text-sm w-20'>Excluir</button>";
                            $acoes .= '</div>';

                            echo "<tr class='border-b hover:bg-gray-50 text-base'>";  // increased font size with text-base
                            echo "<td class='p-3 text-left'>{$row['unidade']}</td>";
                            echo "<td class='p-3 text-left'>{$row['paciente']}</td>";
                            echo "<td class='p-3 text-left'>{$row['idade']}</td>";
                            echo "<td class='p-3 text-left'>{$row['sexo']}</td>";
                            echo "<td class='p-3 text-left'>{$row['modalidade']}</td>";
                            echo "<td class='p-3 text-left'>{$row['exame']}</td>";
                            echo "<td class='p-3 text-left'>{$row['data_exame']}</td>";
                            echo "<td class='p-3 text-left'>{$row['medico']}</td>";
                            echo "<td class='p-3 text-left'>{$row['status']}</td>";
                            echo "<td class='p-3'>{$acoes}</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='13'>Nenhum exame encontrado.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <script>
                // Function to register visualization
                function registrarVisualizacao(exameId, unidade, paciente, medico, visualizador, url) {
                    fetch('registrar_visualizacao.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `exame_id=${exameId}&unidade=${encodeURIComponent(unidade)}&paciente=${encodeURIComponent(paciente)}&medico=${encodeURIComponent(medico)}&visualizador=${visualizador}`
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                if (visualizador === 'OHIF') {
                                    window.open(url, '_blank');
                                } else {
                                    window.location.href = url;
                                }
                            } else {
                                console.error('Erro ao registrar visualização');
                            }
                        });
                }

                // Function to open delete modal
                function abrirModalExcluir(id, unidade, paciente, medico) {
                    document.getElementById('modalExcluir').classList.remove('hidden');
                    document.getElementById('modalUnidade').textContent = unidade;
                    document.getElementById('modalPaciente').textContent = paciente;
                    document.getElementById('modalMedico').textContent = medico;

                    document.getElementById('btnConfirmarExclusao').onclick = function () {
                        excluirExame(id);
                    };
                }

                // Function to close modal
                function fecharModal() {
                    document.getElementById('modalExcluir').classList.add('hidden');
                }

                // Function to delete exam
                function excluirExame(id) {
                    fetch('excluir_exame.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'id=' + id
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                location.reload();
                            } else {
                                alert('Erro ao excluir o exame');
                            }
                        });
                }

                // Filter functions
                function filtrar() {
                    // Add your filter logic here
                    console.log('Filtrar');
                }

                function limparFiltros() {
                    // Add your clear filters logic here
                    console.log('Limpar filtros');
                }
            </script>
        </div>
    </main>

    <!-- FOOTER -->
    <!-- <footer class="bg-gray-800 text-gray-300 text-center py-4 mt-6 text-sm">
        COPYRIGHT © 2025 <a href="#" class="text-indigo-400 hover:underline">CBAITYHY</a>, Todos os direitos reservados<br>

    </footer> -->

    <script src="../Js/homePage.js"></script>
</body>

</html>
>>>>>>> master
