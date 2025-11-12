<?php 
$pagina_publica = true; // Informa ao header para não verificar o login
session_start(); 
$titulo_pagina = 'Login'; 
require 'includes/header.php'; 
?>

<div class="form-container">
    <h2>Acesse sua Conta</h2>
    <p>Bem-vindo de volta!</p>

    <?php
    if (isset($_GET['error'])) {
        echo '<p class="mensagem-erro">' . htmlspecialchars($_GET['error']) . '</p>';
    }
    if (isset($_GET['success'])) {
        echo '<p class="mensagem-sucesso">' . htmlspecialchars($_GET['success']) . '</p>';
    }
    ?>

    <form action="auth/processa_login.php" method="POST">
        <div class="form-group">
            <label for="login">Login</label>
            <input type="text" id="login" name="login" required>
        </div>
        <div class="form-group">
            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha" required>
        </div>
        <div class="form-buttons">
            <button type="submit" class="btn">Enviar</button>
            <button type="reset" class="btn btn-secondary">Limpar</button>
        </div>
    </form>
    <p class="text-center">Não tem uma conta? <a href="cadastro.php">Cadastre-se</a></p>
</div>

<?php require 'includes/footer.php'; ?>