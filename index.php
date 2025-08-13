<?php
session_start();
$erro = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once('./src/pages/conexao.php');
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    // Consulta na tabela cadastros
    $stmt = $conexao->prepare("SELECT * FROM cadastros WHERE email = ? AND senha = ?");
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
    <link rel="stylesheet" href="./src/styles/globalStyles.css" />
</head>

<body>
    <div class="container">
        <div class="illustration"></div>

        <section class="login">
            <h2>Bem vindo!</h2>
            <p>Faça login em sua conta para acessar o sistema.</p>

            <form method="POST" action="">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="usuario@exemplo.com" required />

                <label for="senha">Senha <a href="#">Esqueceu a senha?</a></label>
                <input type="password" id="senha" name="senha" placeholder="........" required />

                <div class="remember">
                    <input type="checkbox" id="lembrar" />
                    <label for="lembrar">Lembrar-me</label>
                </div>

                <div class="register-link">
                    <p>Não tem cadastro? <a href="./src/pages/cadastro.php">Cadastrar</a></p>
                </div>

                <button type="submit">Entrar</button>
                <?php if ($erro): ?>
                    <p style="color:red;"><?= $erro ?></p>
                <?php endif; ?>
            </form>
        </section>
    </div>
</body>

</html>

