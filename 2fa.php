<?php
session_start();
require 'config/conexao.php';

// Se não houver um usuário em processo de 2FA, redireciona para o login
if (!isset($_SESSION['2fa_user_id'])) {
    header('Location: login.php');
    exit;
}

// Busca as perguntas de segurança do usuário no banco de dados
$stmt = $pdo->prepare("SELECT pergunta FROM respostas_seguranca WHERE id_usuario = ?");
$stmt->execute([$_SESSION['2fa_user_id']]);
$perguntas = $stmt->fetchAll(PDO::FETCH_COLUMN);

if (empty($perguntas)) {
    // Caso de erro: usuário sem perguntas de segurança cadastradas
    session_destroy();
    header('Location: login.php?error=Erro de configuração de segurança. Contate o suporte.');
    exit;
}

// Sorteia uma pergunta aleatória
$pergunta_sorteada_key = $perguntas[array_rand($perguntas)];
$mapa_perguntas = [
    'pet' => 'Qual o nome do seu pet?',
    'nascimento' => 'Qual a data do seu nascimento?',
    'cep' => 'Qual o CEP do seu endereço?'
];
$pergunta_texto = $mapa_perguntas[$pergunta_sorteada_key];
$tipo_input = ($pergunta_sorteada_key === 'nascimento') ? 'date' : 'text';

$titulo_pagina = 'Verificação de Segurança';
require 'includes/header.php';
?>

<div class="form-container">
    <h2>Verificação de Segurança (2FA)</h2>
    <p>Para sua segurança, responda à pergunta abaixo.</p>

    <?php
    if (isset($_GET['error'])) {
        $tentativas_restantes = 3 - $_SESSION['2fa_attempts'];
        echo '<p class="mensagem-erro">' . htmlspecialchars($_GET['error']) . " ($tentativas_restantes restantes)</p>";
    }
    ?>

    <form action="auth/processa_2fa.php" method="POST">
        <div class="form-group">
            <label for="resposta"><?php echo $pergunta_texto; ?></label>
            <input type="hidden" name="pergunta" value="<?php echo $pergunta_sorteada_key; ?>">
            <input type="<?php echo $tipo_input; ?>" id="resposta" name="resposta" required>
        </div>
        <button type="submit" class="btn">Verificar</button>
    </form>
</div>

<?php require 'includes/footer.php'; ?>