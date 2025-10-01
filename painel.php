<?php
session_start();

// Se o usuário não estiver logado, redireciona para a página de login
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php?error=Você precisa estar logado para acessar esta página.');
    exit;
}

$titulo_pagina = 'Painel de Controle';
require 'includes/header.php';
?>

<div class="container">
    <h1>Bem-vindo ao seu Painel, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>!</h1>
    <p>Esta é uma área protegida do sistema.</p>
    <p>Seu nível de acesso é: <strong><?php echo htmlspecialchars($_SESSION['usuario_perfil']); ?></strong>.</p>
    <br>
    <a href="auth/logout.php" class="btn">Sair (Logout)</a>
</div>

<?php require 'includes/footer.php'; ?>