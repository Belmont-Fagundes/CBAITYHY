<?php
$mensagem = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once('conexao.php');
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $confirmar = $_POST['confirmar'] ?? '';

    if ($senha !== $confirmar) {
        $mensagem = "<p class='text-red-500 font-medium'>As senhas não coincidem!</p>";
    } else {
        $stmt = $conexao->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $mensagem = "<p class='text-red-500 font-medium'>Já existe uma conta com este email!</p>";
        } else {
            $stmt = $conexao->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nome, $email, $senha);
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
                        👁️
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
                        👁️
                    </button>
                </div>
            </div>

            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors">
                Cadastrar
            </button>

            <p class="text-center text-sm text-gray-600">
                Já tem uma conta?
                <a href="../../index.php" class="text-blue-600 hover:underline">Faça login</a>
            </p>

            <?php if ($mensagem) echo "<div class='mt-4 text-center'>$mensagem</div>"; ?>
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
                btn.textContent = "👁️";
            }
        }
    </script>
</body>
</html>
