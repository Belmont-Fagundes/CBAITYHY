<<<<<<< HEAD
// Banco de dados simulado (substitua pelo seu backend real)
const pacientesDatabase = [
  { id: 1, unidade: "Unidade A", paciente: "João Silva", prontuario: "001", idade: 45, sexo: "M", exame: "RX", descricao: "Raio-X Tórax", data: "08/06/2025", medico: "Dr. Silva", status: "Em análise", prazo: "24h" },
  { id: 2, unidade: "Unidade B", paciente: "Maria Souza", prontuario: "002", idade: 32, sexo: "F", exame: "US", descricao: "Ultrassom Abdômen", data: "10/06/2025", medico: "Dr. Oliveira", status: "Concluído", prazo: "48h" },
  { id: 3, unidade: "Unidade A", paciente: "Carlos Ferreira", prontuario: "003", idade: 28, sexo: "M", exame: "RM", descricao: "Ressonância Magnética", data: "12/06/2025", medico: "Dr. Santos", status: "Agendado", prazo: "72h" },
  { id: 4, unidade: "Unidade C", paciente: "Ana Lima", prontuario: "004", idade: 50, sexo: "F", exame: "CT", descricao: "Tomografia Computadorizada", data: "09/06/2025", medico: "Dr. Silva", status: "Em análise", prazo: "24h" }
];

// Função para filtrar os dados
function filtrar() {
  const paciente = document.getElementById("nomePaciente").value.toLowerCase();
  const unidade = document.getElementById("unidade").value.toLowerCase();
=======
function filtrar() {
  const paciente = document.getElementById("nomePaciente").value;
  const unidade = document.getElementById("unidade").value;
>>>>>>> master

  const tbody = document.getElementById("tabelaResultados");
  tbody.innerHTML = "";

<<<<<<< HEAD
  // Se ambos os campos estiverem vazios, mostra mensagem padrão e retorna
  if (!paciente && !unidade) {
    tbody.innerHTML = `
      <tr>
        <td colspan="13" style="text-align:center; padding: 1rem;">
          Digite para pesquisar
        </td>
      </tr>`;
    return;
  }

  const resultados = pacientesDatabase.filter(item => {
    const matchPaciente = paciente ? item.paciente.toLowerCase().includes(paciente) : true;
    const matchUnidade = unidade ? item.unidade.toLowerCase().includes(unidade) : true;
    return matchPaciente && matchUnidade;
  });

  if (resultados.length > 0) {
    resultados.forEach(item => {
      const row = document.createElement("tr");
      row.innerHTML = `
        <td><input type='checkbox'></td>
        <td>${item.unidade}</td>
        <td>${item.paciente}</td>
        <td>${item.prontuario}</td>
        <td>${item.idade}</td>
        <td>${item.sexo}</td>
        <td>${item.exame}</td>
        <td>${item.descricao}</td>
        <td>${item.data}</td>
        <td>${item.medico}</td>
        <td>${item.status}</td>
        <td>${item.prazo}</td>
        <td><button class="btn-editar">Editar</button></td>
      `;
      tbody.appendChild(row);
    });
  } else {
    tbody.innerHTML = `
      <tr>
        <td colspan="13" style="text-align:center; padding: 1rem;">
          Nenhum registro encontrado
        </td>
      </tr>`;
  }
}


function limparFiltros() {
  // Limpar os campos de input e select
  document.querySelectorAll(".search-box input, .search-box select").forEach(el => {
    el.value = "";
  });

  // Esvaziar completamente o tbody e mostrar mensagem padrão
  const tabela = document.getElementById("tabelaResultados");
  if (tabela) {
    tabela.innerHTML = `
      <tr>
        <td colspan="13" style="text-align:center; padding: 1rem;">
          Digite para pesquisar
        </td>
      </tr>`;
  }
}

// Adicionar event listeners para pesquisa dinâmica
document.addEventListener('DOMContentLoaded', function () {
  document.getElementById("nomePaciente").addEventListener('input', debounce(filtrar, 300));
  document.getElementById("unidade").addEventListener('input', debounce(filtrar, 300));

  function debounce(func, wait) {
    let timeout;
    return function () {
      const context = this;
      const args = arguments;
      clearTimeout(timeout);
      timeout = setTimeout(() => func.apply(context, args), wait);
    };
  }

  // Ao carregar a página, mostra mensagem padrão na tabela
  const tabela = document.getElementById("tabelaResultados");
  if (tabela) {
    tabela.innerHTML = `
      <tr>
        <td colspan="13" style="text-align:center; padding: 1rem;">
          Digite para pesquisar
        </td>
      </tr>`;
  }
});
=======
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
>>>>>>> master
