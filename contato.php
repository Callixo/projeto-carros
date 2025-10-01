<?php
    $titulo_pagina = 'Contato - Tuned Garage';
    include 'includes/header.php';
    $interesse = isset($_GET['interesse']) ? htmlspecialchars($_GET['interesse']) : '';
?>

<div class="container section">
    <h2 class="section-title">Entre em Contato</h2>
    <form action="enviar_contato.php" method="POST" class="form-contato">
        <div class="form-group">
            <label for="nome">Seu Nome</label>
            <input type="text" id="nome" name="nome" required>
        </div>
        <div class="form-group">
            <label for="email">Seu E-mail</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="assunto">Assunto</label>
            <input type="text" id="assunto" name="assunto" value="Interesse no <?php echo $interesse; ?>" required>
        </div>
        <div class="form-group">
            <label for="mensagem">Sua Mensagem</label>
            <textarea id="mensagem" name="mensagem" rows="7" required></textarea>
        </div>
        <button type="submit" class="btn btn-submit">Enviar Mensagem</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>