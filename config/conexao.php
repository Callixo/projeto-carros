<?php
$host = 'localhost:3307';
$dbname = 'sistema_web';
$user = 'root'; // Usuário padrão do XAMPP
$pass = '';     // Senha padrão do XAMPP é vazia

try {
    // Usando PDO para mais segurança e flexibilidade
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    // Configura o PDO para lançar exceções em caso de erro
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Em um ambiente de produção, você não deveria exibir o erro detalhado
    die("Erro ao conectar com o banco de dados: " . $e->getMessage());
}
?>