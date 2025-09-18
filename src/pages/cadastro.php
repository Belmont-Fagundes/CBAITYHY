<?php
$mensagem = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  include_once('conexao.php');
  $nome = $_POST['nome'] ?? '';
  $email = $_POST['email'] ?? '';
  $senha = $_POST['senha'] ?? '';
  $confirmar = $_POST['confirmar'] ?? '';
  $cargo = $_POST['cargo'] ?? ''; // <-- Adicionado
  $estado_id = $_POST['estado_id'] ?? ''; // <-- Adicionado
  $municipio_id = $_POST['municipio_id'] ?? ''; // <-- Adicionado
  $ubs = $_POST['ubs'] ?? ''; // <-- Adicionado

  if ($senha !== $confirmar) {
    $mensagem = "<p class='text-red-500 font-medium'>As senhas não coincidem!</p>";
  } else {
    // Update the SELECT query
    $stmt = $conexao->prepare("SELECT id FROM cadastros WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
      $mensagem = "<p class='text-red-500 font-medium'>Já existe uma conta com este email!</p>";
    } else {
      // Update the INSERT query
      $stmt = $conexao->prepare("INSERT INTO cadastros (nome, email, senha, cargo, estado_id, municipio_id, ubs, aprovado) 
                          VALUES (?, ?, ?, ?, ?, ?, ?, 0)");
      $stmt->bind_param("sssssis", $nome, $email, $senha, $cargo, $estado_id, $municipio_id, $ubs); // <-- Adicionado
      if ($stmt->execute()) {
        $mensagem = "<p class='text-green-500 font-medium'>Cadastro realizado com sucesso! <a href='../../index.php' class='underline text-blue-600'>Faça login</a></p>";
      } else {
        $mensagem = "<p class='text-red-500 font-medium'>Erro ao cadastrar. Tente novamente.</p>";
      }
    }
    $stmt->close();
  }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cadastro - RadCloud</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
  <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-8">
    <h2 class="text-2xl font-bold text-center mb-2">Crie sua conta</h2>
    <p class="text-gray-600 text-center mb-6">Preencha os campos abaixo para se cadastrar no sistema.</p>

    <form method="POST" action="" class="space-y-4">
      <div>
        <label for="nome" class="block text-sm font-medium text-gray-700">Nome completo</label>
        <input type="text" id="nome" name="nome" placeholder="Seu nome"
          class="mt-1 w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
          required />
      </div>

      <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" id="email" name="email" placeholder="usuario@exemplo.com.br"
          class="mt-1 w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
          required />
      </div>

      <div>
        <label for="senha" class="block text-sm font-medium text-gray-700">Senha</label>
        <div class="relative">
          <input type="password" id="senha" name="senha" placeholder="Crie uma senha"
            class="mt-1 w-full border border-gray-300 rounded-lg p-2 pr-10 focus:outline-none focus:ring-2 focus:ring-blue-500"
            required />
          <button type="button" onclick="toggleSenha('senha', this)"
            class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-gray-700">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
          </button>
        </div>
      </div>

      <div>
        <label for="confirmar" class="block text-sm font-medium text-gray-700">Confirmar senha</label>
        <div class="relative">
          <input type="password" id="confirmar" name="confirmar" placeholder="Repita a senha"
            class="mt-1 w-full border border-gray-300 rounded-lg p-2 pr-10 focus:outline-none focus:ring-2 focus:ring-blue-500"
            required />
          <button type="button" onclick="toggleSenha('confirmar', this)"
            class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-gray-700">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
          </button>
        </div>
      </div>

      <div>
        <label for="cargo" class="block text-sm font-medium text-gray-700">Cargo</label>
        <input type="text" id="cargo" name="cargo" placeholder="Ex: Administrador, Médico, Técnico"
          class="mt-1 w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
          required />
      </div>

      <div class="space-y-4">
        <!-- Estado -->
        <div>
          <label for="estado_busca" class="block text-sm font-medium text-gray-700">Estado</label>
          <div class="relative">
            <input type="text" id="estado_busca"
              class="mt-1 w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
              placeholder="Digite para buscar..." autocomplete="off" />
            <input type="hidden" id="estado_id" name="estado_id" required />
            <div id="estado_sugestoes"
              class="absolute z-10 w-full bg-white border rounded-lg mt-1 shadow-lg max-h-48 overflow-y-auto hidden">
            </div>
          </div>
        </div>

        <!-- Município -->
        <div>
          <label for="municipio_busca" class="block text-sm font-medium text-gray-700">Município</label>
          <div class="relative">
            <input type="text" id="municipio_busca"
              class="mt-1 w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
              placeholder="Selecione primeiro o estado" disabled autocomplete="off" />
            <input type="hidden" id="municipio_id" name="municipio_id" required />
            <div id="municipio_sugestoes"
              class="absolute z-10 w-full bg-white border rounded-lg mt-1 shadow-lg max-h-48 overflow-y-auto hidden">
            </div>
          </div>
        </div>
      </div>

      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors">
        Cadastrar
      </button>

      <p class="text-center text-sm text-gray-600">
        Já tem uma conta?
        <a href="../../index.php" class="text-blue-600 hover:underline">Faça login</a>
      </p>

      <?php if ($mensagem)
        echo "<div class='mt-4 text-center'>$mensagem</div>"; ?>
    </form>
  </div>

  <script>
    function toggleSenha(id, btn) {
      const input = document.getElementById(id);
      if (input.type === "password") {
        input.type = "text";
        btn.textContent = "🚫";

      } else {
        input.type = "password";
        btn.innerHTML = `<svg class=\"h-5 w-5\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M15 12a3 3 0 11-6 0 3 3 0 016 0z\" /><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z\" /></svg>`;
      }
    }

    const estadoBusca = document.getElementById('estado_busca');
    const estadoSugestoes = document.getElementById('estado_sugestoes');
    const estadoId = document.getElementById('estado_id');
    const municipioBusca = document.getElementById('municipio_busca');
    const municipioSugestoes = document.getElementById('municipio_sugestoes');
    const municipioId = document.getElementById('municipio_id');

    // Estado search
    estadoBusca.addEventListener('input', async function () {
      const search = this.value.trim();
      if (search.length < 2) {
        estadoSugestoes.classList.add('hidden');
        return;
      }

      const response = await fetch(`buscar_estados.php?search=${encodeURIComponent(search)}`);
      const estados = await response.json();

      estadoSugestoes.innerHTML = estados.map(estado =>
        `<div class="p-2 hover:bg-gray-100 cursor-pointer" 
                  data-id="${estado.id}" 
                  data-nome="${estado.nome}">${estado.nome}</div>`
      ).join('');

      estadoSugestoes.classList.remove('hidden');
    });

    // Município search
    municipioBusca.addEventListener('input', async function () {
      const search = this.value.trim();
      if (search.length < 2) {
        municipioSugestoes.classList.add('hidden');
        return;
      }

      const response = await fetch(`buscar_municipios.php?estado_id=${estadoId.value}&search=${encodeURIComponent(search)}`);
      const municipios = await response.json();

      municipioSugestoes.innerHTML = municipios.map(municipio =>
        `<div class="p-2 hover:bg-gray-100 cursor-pointer" 
                  data-id="${municipio.id}" 
                  data-nome="${municipio.nome}">${municipio.nome}</div>`
      ).join('');

      municipioSugestoes.classList.remove('hidden');
    });

    // Handle estado selection
    estadoSugestoes.addEventListener('click', function (e) {
      const selected = e.target.closest('div[data-id]');
      if (selected) {
        estadoId.value = selected.dataset.id;
        estadoBusca.value = selected.dataset.nome;
        estadoSugestoes.classList.add('hidden');
        municipioBusca.disabled = false;
        municipioBusca.placeholder = 'Digite para buscar...';
        municipioBusca.value = '';
        municipioId.value = '';
      }
    });

    // Handle municipio selection
    municipioSugestoes.addEventListener('click', function (e) {
      const selected = e.target.closest('div[data-id]');
      if (selected) {
        municipioId.value = selected.dataset.id;
        municipioBusca.value = selected.dataset.nome;
        municipioSugestoes.classList.add('hidden');
      }
    });

    // Close suggestions when clicking outside
    document.addEventListener('click', function (e) {
      if (!e.target.closest('#estado_busca')) {
        estadoSugestoes.classList.add('hidden');
      }
      if (!e.target.closest('#municipio_busca')) {
        municipioSugestoes.classList.add('hidden');
      }
    });

    // Password toggle function
    function togglePassword(inputId) {
      const input = document.getElementById(inputId);
      const type = input.type === 'password' ? 'text' : 'password';
      input.type = type;

      // Update icon
      const icon = document.getElementById(inputId + '_icon');
      if (type === 'text') {
        icon.innerHTML = `<path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" /><path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />`;
      } else {
        icon.innerHTML = `<path d="M10 12a2 2 0 100-4 2 2 0 000 4z" /><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />`;
      }
    }
  </script>
</body>

</html>