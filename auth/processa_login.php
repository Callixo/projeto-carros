<?php
session_start();
require '../config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../login.php');
    exit;
}

$login = trim($_POST['login']);
$senha = trim($_POST['senha']);

if (empty($login) || empty($senha)) {
    header('Location: ../login.php?error=Login e senha são obrigatórios.');
    exit;
}

// Busca o usuário pelo login
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE login = ? AND ativo = 1");
$stmt->execute([$login]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

// Verifica se o usuário existe e se a senha está correta
if ($usuario && password_verify($senha, $usuario['senha'])) {
    // 1ª Fase de autenticação OK.
    // Prepara a sessão para a 2ª Fase (2FA).
    $_SESSION['2fa_user_id'] = $usuario['id']; // Armazena o ID do usuário temporariamente
    $_SESSION['2fa_attempts'] = 0; // Zera o contador de tentativas

    // Redireciona para a tela de desafio 2FA
    header('Location: ../2fa.php');
    exit;
} else {
    // Falha no login (usuário, senha ou status inativo)
    header('Location: ../login.php?error=Login ou senha inválidos.');
    exit;
}
?>