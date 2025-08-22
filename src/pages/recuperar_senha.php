<?php
session_start();
include_once("conexao.php");

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);

    // Verifica se existe usuário com este email
    $stmt = $conexao->prepare("SELECT id, nome FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();

        // Aqui você poderia enviar um email de recuperação com token
        // Por enquanto vamos só exibir uma mensagem simulando
        $mensagem = "Um link de recuperação foi enviado para o email <b>$email</b> (simulado).";
    } else {
        $mensagem = "Nenhum usuário encontrado com este email.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Recuperar Senha</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="bg-white shadow-lg rounded-2xl p-8 w-full max-w-md">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Recuperar Senha</h2>
        <p class="mb-6 text-gray-600">Digite seu email cadastrado para receber as instruções de recuperação.</p>

        <form method="POST" class="space-y-4">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" id="email" name="email" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400" />
            </div>

            <button type="submit" 
                class="w-full bg-indigo-500 text-white py-2 rounded-lg hover:bg-indigo-600 transition">
                Enviar Link de Recuperação
            </button>
        </form>

        <?php if ($mensagem): ?>
            <p class="mt-4 text-sm text-gray-700"><?= $mensagem ?></p>
        <?php endif; ?>

        <div class="mt-6 text-sm">
            <a href="../../index.php" class="text-indigo-500 hover:underline">Voltar para login</a>
        </div>
    </div>

</body>
</html>
