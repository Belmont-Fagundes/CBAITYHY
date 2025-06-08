function filtrar() {
  const paciente = document.getElementById("nomePaciente").value;
  const unidade = document.getElementById("unidade").value;

  const tbody = document.getElementById("tabelaResultados");
  tbody.innerHTML = "";

  if (paciente || unidade) {
    tbody.innerHTML = `
      <tr>
        <td><input type='checkbox'></td>
        <td>${unidade}</td>
        <td>${paciente}</td>
        <td>001</td>
        <td>45</td>
        <td>M</td>
        <td>RX</td>
        <td>Raio-X Tórax</td>
        <td>08/06/2025</td>
        <td>Dr. Silva</td>
        <td>Em análise</td>
        <td>24h</td>
        <td><button>Editar</button></td>
      </tr>`;
  } else {
    tbody.innerHTML =
      '<tr><td colspan="13" style="text-align:center; padding: 1rem;">Nenhum registro encontrado</td></tr>';
  }
}

function limparFiltros() {
  document
    .querySelectorAll(".search-box input, .search-box select")
    .forEach((el) => (el.value = ""));
  filtrar();
}
