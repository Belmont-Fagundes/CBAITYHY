<?php
$mensagem = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  include_once('conexao.php');
  $nome = $_POST['nome'] ?? '';
  $email = $_POST['email'] ?? '';
  $senha = $_POST['senha'] ?? '';
  $confirmar = $_POST['confirmar'] ?? '';

  if ($senha !== $confirmar) {
    $mensagem = "<span style='color:red;'>As senhas não coincidem!</span>";
  } else {
    // Verifica se já existe o email
    $stmt = $conexao->prepare("SELECT id FROM cadastros WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
      $mensagem = "<span style='color:red;'>Já existe uma conta com este email!</span>";
    } else {
      // Insere novo cadastro
      $stmt = $conexao->prepare("INSERT INTO cadastros (nome, email, senha) VALUES (?, ?, ?)");
      $stmt->bind_param("sss", $nome, $email, $senha);
      if ($stmt->execute()) {
        $mensagem = "<span style='color:green;'>Cadastro realizado com sucesso! <a href='../../index.php'>Faça login</a></span>";
      } else {
        $mensagem = "<span style='color:red;'>Erro ao cadastrar. Tente novamente.</span>";
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
  <link rel="stylesheet" href="../styles/cadastro.css" />
</head>

<body>
  <header></header>

  <div class="container">
    <section class="cadastro">
      <h2>Crie sua conta</h2>
      <p>Preencha os campos abaixo para se cadastrar no sistema.</p>

      <form method="POST" action="">
        <label for="nome">Nome completo</label>
        <input type="text" id="nome" name="nome" placeholder="Seu nome" required />

        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="usuario@exemplo.com.br" required />

        <label for="senha">Senha</label>
        <input type="password" id="senha" name="senha" placeholder="Crie uma senha" required />

        <label for="confirmar">Confirmar senha</label>
        <input type="password" id="confirmar" name="confirmar" placeholder="Repita a senha" required />

        <button type="submit">Cadastrar</button>

        <p class="login-link">Já tem uma conta? <a href="../../index.php">Faça login</a></p>
        <?php if ($mensagem)
          echo "<div style='margin-top:10px;'>$mensagem</div>"; ?>
      </form>
    </section>
  </div>
</body>

</html>