<?php
session_start();
require 'conexao.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['ultimo_acesso'] = time();
        header('Location: index.php');
        exit;
    } else {
        $erro = 'E-mail ou palavra-passe inválidos!';
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Login - Assistência Técnica</title>
</head>
<link rel="stylesheet" href="style.css">
<body>
    <h2>Iniciar Sessão</h2>
    <?php if (!empty($erro)): ?>
        <p style="color: red;"><?php echo $erro; ?></p>
    <?php endif; ?>
    <form method="POST">
        <label>E-mail:</label><br>
        <input type="email" name="email" required><br><br>
        <label>Palavra-passe:</label><br>
        <input type="password" name="senha" required><br><br>
        <button type="submit">Entrar</button>
    </form>
</body>
</html>