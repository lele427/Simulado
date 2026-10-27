<?php
session_start();
if (!isset($_SESSION['usuario_id'])) { header('Location: login.php'); exit; }
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $equipamento_id = $_POST['equipamento_id'];
    $descricao_problema = $_POST['descricao_problema'];

    $stmt = $pdo->prepare("INSERT INTO ordens_servico (equipamento_id, descricao_problema) VALUES (?, ?)");
    $stmt->execute([$equipamento_id, $descricao_problema]);
    header('Location: ordens_servico.php');
    exit;
}

$equipamentos = $pdo->query("SELECT e.id, e.tipo, e.modelo, c.nome AS cliente_nome FROM equipamentos e JOIN clientes c ON e.cliente_id = c.id")->fetchAll();

// Consulta ordenada pela data de abertura
$os_lista = $pdo->query("
    SELECT os.*, e.tipo, e.modelo, c.nome AS cliente_nome, c.telefone 
    FROM ordens_servico os 
    JOIN equipamentos e ON os.equipamento_id = e.id 
    JOIN clientes c ON e.cliente_id = c.id 
    ORDER BY os.data_abertura DESC
")->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <title>Ordens de Serviço</title>
</head>
<body>
    <h2>Ordens de Serviço</h2>
    <a href="index.php">Voltar ao Painel</a><br><br>

    <form method="POST">
        <label>Equipamento:</label>
        <select name="equipamento_id" required>
            <option value="">Selecione o equipamento</option>
            <?php foreach ($equipamentos as $eq): ?>
                <option value="<?php echo $eq['id']; ?>">
                    <?php echo htmlspecialchars($eq['cliente_nome'] . ' - ' . $eq['tipo'] . ' ' . $eq['modelo']); ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>
        <label>Descrição do Problema:</label><br>
        <textarea name="descricao_problema" rows="4" cols="40" required></textarea><br><br>
        <button type="submit">Abrir Ordem de Serviço</button>
    </form>

    <h3 style="margin-top: 30px;">Lista de Ordens de Serviço (Ordenadas por Data)</h3>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>ID OS</th>
            <th>Data Abertura</th>
            <th>Cliente</th>
            <th>Telefone</th>
            <th>Equipamento</th>
            <th>Problema</th>
            <th>Estado</th>
        </tr>
        <?php foreach ($os_lista as $os): ?>
        <tr>
            <td><?php echo $os['id']; ?></td>
            <td><?php echo $os['data_abertura']; ?></td>
            <td><?php echo htmlspecialchars($os['cliente_nome']); ?></td>
            <td><?php echo htmlspecialchars($os['telefone']); ?></td>
            <td><?php echo htmlspecialchars($os['tipo'] . ' ' . $os['modelo']); ?></td>
            <td><?php echo htmlspecialchars($os['descricao_problema']); ?></td>
            <td><?php echo htmlspecialchars($os['status']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>