<?php
session_start();
$erro = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once('./src/pages/conexao.php');
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    // Consulta na tabela usuarios
    $stmt = $conexao->prepare("SELECT * FROM usuarios WHERE email = ? AND senha = ?");
    $stmt->bind_param("ss", $email, $senha);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $_SESSION['usuario'] = $email;
        header("Location: ./src/pages/homePage.php");
        exit();
    } else {
        $erro = "Email ou senha inválidos!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - PACserver</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="bg-white rounded-2xl shadow-lg flex flex-col md:flex-row w-full max-w-4xl overflow-hidden">
        
        <!-- Ilustração -->
        <div class="hidden md:block md:w-1/2 bg-gradient-to-br from-indigo-500 to-blue-600 p-10 text-white flex flex-col justify-center">
            <h1 class="text-4xl font-bold mb-4">Bem-vindo ao PACserver</h1>
            <p class="text-lg">Acesse o sistema para gerenciar seus dados de forma prática e segura.</p>
        </div>

        <!-- Formulário -->
        <section class="w-full md:w-1/2 p-8">
            <h2 class="text-3xl font-bold mb-2 text-gray-800">Bem-vindo!</h2>
            <p class="mb-6 text-gray-600">Faça login em sua conta para acessar o sistema.</p>

            <form method="POST" action="" class="space-y-5">
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" name="email" placeholder="usuario@exemplo.com" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400" />
                </div>

                <div>
                    <label for="senha" class="block text-sm font-medium text-gray-700 mb-1">Senha</label>
                    <div class="relative">
                        <input type="password" id="senha" name="senha" placeholder="********" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 pr-10" />
                        <button type="button" onclick="toggleSenha()" 
                            class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-gray-700">
                            👁
                        </button>
                    </div>
                </div>

                <div class="flex items-center space-x-2">
                    <input type="checkbox" id="lembrar" class="h-4 w-4 text-indigo-500 border-gray-300 rounded">
                    <label for="lembrar" class="text-sm text-gray-600">Lembrar-me</label>
                </div>

                <!-- Cadastrar e Esqueceu senha lado a lado -->
                <div class="flex items-center justify-between text-sm mt-2">
                    <div>
                        Não tem cadastro? 
                        <a href="./src/pages/cadastro.php" class="text-indigo-500 hover:underline">Cadastrar</a>
                    </div>
                    <a href="./src/pages/recuperar_senha.php" class="text-indigo-500 hover:underline">
                        Esqueceu a senha?
                    </a>
                </div>

                <button type="submit" 
                    class="w-full bg-indigo-500 text-white py-2 rounded-lg hover:bg-indigo-600 transition duration-200">
                    Entrar
                </button>

                <?php if ($erro): ?>
                    <p class="text-red-500 text-sm mt-2"><?= $erro ?></p>
                <?php endif; ?>
            </form>
        </section>
    </div>

    <script>
        function toggleSenha() {
            const senhaInput = document.getElementById("senha");
            senhaInput.type = senhaInput.type === "password" ? "text" : "password";
        }
    </script>

</body>
</html>