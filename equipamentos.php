<?php
session_start();
if (!isset($_SESSION['usuario_id'])) { header('Location: login.php'); exit; }
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cliente_id = $_POST['cliente_id'];
    $tipo = $_POST['tipo'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $numero_serie = $_POST['numero_serie'];

    $stmt = $pdo->prepare("INSERT INTO equipamentos (cliente_id, tipo, marca, modelo, numero_serie) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$cliente_id, $tipo, $marca, $modelo, $numero_serie]);
    header('Location: equipamentos.php');
    exit;
}

$clientes = $pdo->query("SELECT id, nome FROM clientes")->fetchAll();
$equipamentos = $pdo->query("SELECT e.*, c.nome AS cliente_nome FROM equipamentos e JOIN clientes c ON e.cliente_id = c.id")->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <title>Equipamentos</title>
</head>
<body>
    <h2>Gestão de Equipamentos</h2>
    <a href="index.php">Voltar ao Painel</a><br><br>

    <form method="POST">
        <label>Cliente:</label>
        <select name="cliente_id" required>
            <option value="">Selecione um cliente</option>
            <?php foreach ($clientes as $cli): ?>
                <option value="<?php echo $cli['id']; ?>"><?php echo htmlspecialchars($cli['nome']); ?></option>
            <?php endforeach; ?>
        </select><br><br>
        <label>Tipo:</label> <input type="text" name="tipo" required><br><br>
        <label>Marca:</label> <input type="text" name="marca" required><br><br>
        <label>Modelo:</label> <input type="text" name="modelo" required><br><br>
        <label>Nº de Série:</label> <input type="text" name="numero_serie"><br><br>
        <button type="submit">Cadastrar Equipamento</button>
    </form>

    <h3 style="margin-top: 30px;">Equipamentos Registados</h3>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Tipo</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Nº Série</th>
        </tr>
        <?php foreach ($equipamentos as $eq): ?>
        <tr>
            <td><?php echo $eq['id']; ?></td>
            <td><?php echo htmlspecialchars($eq['cliente_nome']); ?></td>
            <td><?php echo htmlspecialchars($eq['tipo']); ?></td>
            <td><?php echo htmlspecialchars($eq['marca']); ?></td>
            <td><?php echo htmlspecialchars($eq['modelo']); ?></td>
            <td><?php echo htmlspecialchars($eq['numero_serie']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>