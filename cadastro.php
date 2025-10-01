<?php $titulo_pagina = 'Cadastro de Usuário'; ?>
<?php require 'includes/header.php'; ?>

<div class="form-container">
    <h2>Crie sua Conta</h2>
    <p>Preencha os campos para se cadastrar.</p>

    <?php
        // Exibe mensagens de erro ou sucesso
        if (isset($_GET['error'])) {
            echo '<p class="mensagem-erro">' . htmlspecialchars($_GET['error']) . '</p>';
        }
        if (isset($_GET['success'])) {
            echo '<p class="mensagem-sucesso">' . htmlspecialchars($_GET['success']) . '</p>';
        }
    ?>

    <form action="auth/processa_cadastro.php" method="POST">
        <div class="form-group">
            <label for="nome">Nome Completo</label>
            <input type="text" id="nome" name="nome" required>
        </div>
        <div class="form-group">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha" required>
        </div>
        <button type="submit" class="btn">Cadastrar</button>
    </form>
    <p class="text-center">Já tem uma conta? <a href="login.php">Faça o login</a></p>
</div>

<?php require 'includes/footer.php'; ?>