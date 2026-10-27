<?php
session_start();

// Tempo limite de inatividade em segundos (ex: 15 minutos)
$tempo_limite = 900; 

if (isset($_SESSION['ultimo_acesso']) && (time() - $_SESSION['ultimo_acesso'] > $tempo_limite)) {
    session_unset();
    session_destroy();
    header('Location: login.php?expirado=1');
    exit;
}
$_SESSION['ultimo_acesso'] = time();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Painel Principal - Assistência Técnica</title>
</head>
<link rel="stylesheet" href="style.css">
<body>
    <h1>Bem-vindo, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>!</h1>
    <p>Painel de controlo da assistência técnica.</p>
    
    <nav>
        <ul>
            <li><a href="clientes.php">Gerenciar Clientes</a></li>
            <li><a href="equipamentos.php">Gerenciar Equipamentos</a></li>
            <li><a href="ordens_servico.php">Gerenciar Ordens de Serviço</a></li>
            <li><a href="logout.php">Sair do Sistema</a></li>
        </ul>
    </nav>
</body>
</html>