<?php
session_start();
if (!isset($_SESSION['usuario_id'])) { header('Location: login.php'); exit; }
require 'conexao.php';

$busca = isset($_GET['busca']) ? trim($_GET['busca']) : '';

if ($busca !== '') {
    $stmt = $pdo->prepare("SELECT * FROM clientes WHERE nome LIKE ? OR cpf LIKE ?");
    $stmt->execute(["%$busca%", "%$busca%"]);
} else {
    $stmt = $pdo->query("SELECT * FROM clientes");
}
$clientes = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <title>Clientes</title>
</head>
<body>
    <h2>Gestão de Clientes</h2>
    <a href="index.php">Voltar ao Painel</a><br><br>

    <form method="GET">
        <input type="text" name="busca" placeholder="Pesquisar por nome ou CPF" value="<?php echo htmlspecialchars($busca); ?>">
        <button type="submit">Buscar</button>
    </form>

    <table border="1" cellpadding="5" cellspacing="0" style="margin-top: 20px;">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>CPF</th>
            <th>Telefone</th>
            <th>Endereço</th>
        </tr>
        <?php foreach ($clientes as $c): ?>
        <tr>
            <td><?php echo $c['id']; ?></td>
            <td><?php echo htmlspecialchars($c['nome']); ?></td>
            <td><?php echo htmlspecialchars($c['cpf']); ?></td>
            <td><?php echo htmlspecialchars($c['telefone']); ?></td>
            <td><?php echo htmlspecialchars($c['endereco']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>