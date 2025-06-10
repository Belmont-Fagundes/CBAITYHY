<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/conexao.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CABAITYHY - Worklist</title>
  <link rel="stylesheet" href="../styles/homePage.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>

<body>
  <header>
    <div class="logo">
      <img src="https://img.icons8.com/ios-filled/50/cloud.png" alt="cloud" />
      <h1>CBAITYHY</h1>
    </div>
    <nav>
      <ul>
        <li>Dashboard</li>
        <li>Worklist</li>
        <li>Relatórios</li>
        <li>Exames excluídos</li>
        <li>Médicos solicitantes</li>
        <li>Configurações</li>
      </ul>
    </nav>
    <div>
      <span>Belmont</span><br />
      <small>Administrador</small>
    </div>
  </header>

  <div class="container">
    <h2>Worklist</h2>
    <div class="search-box">
      <input id="nomePaciente" type="text" placeholder="Nome do Paciente">
      <input id="pacId" type="text" placeholder="Pac. ID">
      <input id="modalidade" type="text" placeholder="Pesquise por modalidades">
      <input id="unidade" type="text" placeholder="Pesquise por unidades">
      <input id="dataInicio" type="date">
      <input id="dataFim" type="date">
      <input id="prioridade" type="text" placeholder="Pesquise por prioridade">
      <select id="filtro">
        <option>Filtro</option>
      </select>
      <select id="status">
        <option>Status</option>
      </select>
      <input id="nomeExame" type="text" placeholder="Nome do exame">
      <div class="btn-group">
        <button onclick="filtrar()">Filtrar</button>
        <button onclick="limparFiltros()">Limpar</button>
      </div>
    </div>

    <div class="results-box">
      <div style="margin-bottom: 1rem; display: flex; justify-content: space-between;">
        <button>Exibir Colunas ▾</button>
        <div class="actions">
          <button>Adicionar Exame</button>
          <button>Enviar p/ Horos</button>
          <button>Excluir Exames</button>
        </div>
      </div>
      <table>
        <thead>
          <tr>
            <th></th>
            <th>UNIDADE</th>
            <th>PACIENTE</th>
            <th>PAC. ID</th>
            <th>IDADE</th>
            <th>SEXO</th>
            <th>MOD.</th>
            <th>EXAME</th>
            <th>DT. ESTUDO</th>
            <th>MÉDICO</th>
            <th>STATUS</th>
            <th>SLA</th>
            <th>AÇÕES</th>
          </tr>
        </thead>
        <tbody id="tabelaResultados">
          <?php
          $query = "SELECT * FROM exames ORDER BY data_estudo DESC";
          $result = $conexao->query($query);

          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td><input type='checkbox'></td>";
              echo "<td>{$row['unidade']}</td>";
              echo "<td>{$row['paciente']}</td>";
              echo "<td>{$row['pac_id']}</td>";
              echo "<td>{$row['idade']}</td>";
              echo "<td>{$row['sexo']}</td>";
              echo "<td>{$row['modalidade']}</td>";
              echo "<td>{$row['exame']}</td>";
              echo "<td>{$row['data_estudo']}</td>";
              echo "<td>{$row['medico']}</td>";
              echo "<td>{$row['status']}</td>";
              echo "<td>{$row['sla']}</td>";

              // Ações: links clicáveis com protocolo weasis
              $acoes = '';
              $arquivos = explode(',', $row['acoes']);
              foreach ($arquivos as $arquivo) {
                $arquivo = trim($arquivo);
                if ($arquivo) {
                  // Caminho local para o arquivo DICOM
                  $caminho_local = "C:/xampp/htdocs/CBAITYHY/PacFront/src/images/{$row['pac_id']}/$arquivo";
                  $caminho_local = str_replace('\\', '/', $caminho_local); // Garante barras corretas
                  $caminho_weasis = "weasis://file/$caminho_local";
                  $acoes .= "<a href=\"$caminho_weasis\" target=\"_blank\">$arquivo</a><br>";
                }
              }

              echo "<td>$acoes</td>";
              echo "</tr>";
            }
          } else {
            echo "<tr><td colspan='13' style='text-align:center; padding: 1rem;'>Nenhum registro encontrado</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <footer class="footer">
    COPYRIGHT © 2025 <a href="#">CABAITYHY</a>, Todos os direitos reservados<br>
    Último acesso em: 08/06/2025 às 12:42:43 no ip: 179.190.215.111 - Versão 3.0
  </footer>

  <script src="../Js/homePage.js"></script>
</body>

</html>