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
        <div class="bg-white rounded-lg shadow p-4 mb-6 grid grid-cols-1 md:grid-cols-4 lg:grid-cols-6 gap-3">
            <!-- <input id="pacId" type="text" placeholder="Pac. ID" class="border p-2 rounded" /> -->
            <input id="unidade" type="text" placeholder="Pesquise por unidades" class="border p-2 rounded" />
            <input id="nomePaciente" type="text" placeholder="Nome do Paciente" class="border p-2 rounded" />
            <input id="modalidade" type="text" placeholder="Pesquise por modalidades" class="border p-2 rounded" />
            <input id="dataInicio" type="date" class="border p-2 rounded" />
            <input id="dataFim" type="date" class="border p-2 rounded" />
            <input id="prioridade" type="text" placeholder="Pesquise por prioridade" class="border p-2 rounded" />
            <select id="filtro" class="border p-2 rounded">
                <option>Filtro</option>
            </select>
            <select id="status" class="border p-2 rounded">
                <option>Status</option>
            </select>
            <input id="nomeExame" type="text" placeholder="Nome do exame" class="border p-2 rounded" />

            <div class="col-span-1 md:col-span-2 lg:col-span-1 flex gap-2">
                <button onclick="filtrar()" class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded">Filtrar</button>
                <button onclick="limparFiltros()" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded">Limpar</button>
            </div>
        </div>

        <!-- RESULTS BOX -->
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex justify-between mb-4">
                <button class="bg-gray-200 hover:bg-gray-300 px-3 py-1 rounded">Exibir Colunas ▾</button>
                <div class="flex gap-2">
                    <button class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded">Adicionar Exame</button>
                    <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">Enviar p/ Horos</button>
                    <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">Excluir Exames</button>
                </div>
            </div>

            <table class="w-full text-sm border-collapse">
                <thead>
                    <tr class="bg-indigo-100">
                        <th class="border p-2"></th>
                        <th class="border p-2">UNIDADE</th>
                        <th class="border p-2">PACIENTE</th>
                        <th class="border p-2">IDADE</th>
                        <th class="border p-2">SEXO</th>
                        <th class="border p-2">MOD.</th>
                        <th class="border p-2">EXAME</th>
                        <th class="border p-2">DATA DO EXAME</th>
                        <th class="border p-2">MÉDICO</th>
                        <th class="border p-2">STATUS</th>
                        <th class="border p-2">AÇÕES</th>
                    </tr>
                </thead>
        <tbody id="tabelaResultados">
          <?php
          $query = "SELECT * FROM exames ORDER BY data_exame DESC";
          $result = $conexao->query($query);

          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              $acoes = '';
              $ip = "186.227.199.181"; // IP externo (OHIF, Orthanc e PACS Connector)

              $studyUID = isset($row['study_uid']) ? trim($row['study_uid']) : null;
              $link_ohif = "http://$ip:8050/viewer/" . urlencode($studyUID);
              $acoes .= "<a href=\"$link_ohif\" target=\"_blank\">Abrir no OHIF</a><br>";

              // Link Weasis via manifest (forma correta)
              if (!empty($studyUID)) {
                $manifest_url = "http://$ip:8080/weasis-pacs-connector/manifest?studyUID=" . urlencode($studyUID);
                $weasis_url = "weasis://$manifest_url";
                $acoes .= "<a href=\"$weasis_url\" class=\"text-blue-600 hover:text-blue-800\">Abrir no Weasis</a><br>";
              }


              echo "<tr>";
              echo "<td><input type='checkbox'></td>";
              echo "<td>{$row['unidade']}</td>";
              echo "<td>{$row['paciente']}</td>";
              echo "<td>{$row['idade']}</td>";
              echo "<td>{$row['sexo']}</td>";
              echo "<td>{$row['modalidade']}</td>";
              echo "<td>{$row['exame']}</td>";
              echo "<td>{$row['data_exame']}</td>";
              echo "<td>{$row['medico']}</td>";
              echo "<td>{$row['status']}</td>";
              echo "<td>$acoes</td>";
              echo "</tr>";
            }
          } else {
            echo "<tr><td colspan='13'>Nenhum exame encontrado.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
    </main>

    <!-- FOOTER -->
    <!-- <footer class="bg-gray-800 text-gray-300 text-center py-4 mt-6 text-sm">
        COPYRIGHT © 2025 <a href="#" class="text-indigo-400 hover:underline">CBAITYHY</a>, Todos os direitos reservados<br>

    </footer> -->

    <script src="../Js/homePage.js"></script>
</body>

</html>

