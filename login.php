<?php session_start(); ?>
<?php $titulo_pagina = 'Login'; ?>
<?php require 'includes/header.php'; ?>

<div class="form-container">
    <h2>Acesse sua Conta</h2>
    <p>Bem-vindo de volta!</p>

    <?php
        // Exibe mensagens de erro ou sucesso
        if (isset($_GET['error'])) {
            echo '<p class="mensagem-erro">' . htmlspecialchars($_GET['error']) . '</p>';
        }
        if (isset($_GET['success'])) {
            echo '<p class="mensagem-sucesso">' . htmlspecialchars($_GET['success']) . '</p>';
        }
    ?>

    <form action="auth/processa_login.php" method="POST">
        <div class="form-group">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha" required>
        </div>
        <button type="submit" class="btn">Entrar</button>
    </form>
    <p class="text-center">Não tem uma conta? <a href="cadastro.php">Cadastre-se</a></p>
</div>

<?php require 'includes/footer.php'; ?>