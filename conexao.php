<?php
$host = 'localhost;port=3307'; // Porta 3307 do MySQL
$db = 'saep_assistencia';
$user = 'root';
$pass = ''; // Tente sem senha (vazio), pois o 3307 era a porta e não a senha!

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na ligação ao banco de dados: " . $e->getMessage());
}
?>