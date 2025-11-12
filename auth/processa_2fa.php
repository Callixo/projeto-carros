<?php
session_start();
require '../config/conexao.php';

// Proteções iniciais
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['2fa_user_id'])) {
    header('Location: ../login.php');
    exit;
}

// Coleta os dados
$id_usuario = $_SESSION['2fa_user_id'];
$pergunta_key = $_POST['pergunta'];
$resposta_submetida = strtolower(trim($_POST['resposta']));

// Busca a resposta CORRETA (com hash) no banco de dados
$stmt = $pdo->prepare("SELECT resposta FROM respostas_seguranca WHERE id_usuario = ? AND pergunta = ?");
$stmt->execute([$id_usuario, $pergunta_key]);
$resultado = $stmt->fetch(PDO::FETCH_ASSOC);

if ($resultado && password_verify($resposta_submetida, $resultado['resposta'])) {
    // RESPOSTA CORRETA - 2ª Fase de autenticação OK.

    // Busca os dados completos do usuário para finalizar a sessão
    $stmt_user = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
    $stmt_user->execute([$id_usuario]);
    $usuario = $stmt_user->fetch(PDO::FETCH_ASSOC);

    // Limpa as variáveis temporárias de 2FA
    unset($_SESSION['2fa_user_id']);
    unset($_SESSION['2fa_attempts']);

    // Define as variáveis de sessão permanentes
    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['usuario_nome'] = $usuario['nome_completo'];
    $_SESSION['usuario_perfil'] = $usuario['perfil'];

    // Grava o log de sucesso
    $log_action = "Login 2FA bem-sucedido com a pergunta '$pergunta_key'.";
    $stmt_log = $pdo->prepare("INSERT INTO logs (id_usuario, acao) VALUES (?, ?)");
    $stmt_log->execute([$usuario['id'], $log_action]);

    // Redireciona para o painel principal
    header('Location: ../painel.php');
    exit;

} else {
    // RESPOSTA INCORRETA

    $_SESSION['2fa_attempts']++;

    if ($_SESSION['2fa_attempts'] >= 3) {
        // Limite de tentativas excedido
        $log_action = "Bloqueado por 3 tentativas de 2FA falhas.";
        $stmt_log = $pdo->prepare("INSERT INTO logs (id_usuario, acao) VALUES (?, ?)");
        $stmt_log->execute([$id_usuario, $log_action]);

        session_destroy();
        header('Location: ../login.php?error=3 tentativas sem sucesso! Favor realizar Login novamente.');
        exit;
    } else {
        // Tente novamente
        header('Location: ../2fa.php?error=Resposta incorreta. Tente novamente.');
        exit;
    }
}
?>