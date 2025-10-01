<?php
session_start();
require '../config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    if (empty($email) || empty($senha)) {
        header('Location: ../login.php?error=Preencha e-mail e senha.');
        exit;
    }

    // Busca o usuário pelo e-mail
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifica se o usuário existe e se a senha está correta
    if ($usuario && password_verify($senha, $usuario['senha'])) {
        // Login bem-sucedido, cria a sessão
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['usuario_perfil'] = $usuario['perfil'];

        // Registrar o log de login
        try {
            $sql_log = "INSERT INTO logs (id_usuario, acao) VALUES (?, ?)";
            $stmt_log = $pdo->prepare($sql_log);
            $stmt_log->execute([$usuario['id'], 'Login realizado com sucesso.']);
        } catch (PDOException $e) {
            // Falha ao gravar log não impede o login, mas pode ser registrado em outro lugar
        }

        header('Location: ../painel.php');
        exit;
    } else {
        // Falha no login
        header('Location: ../login.php?error=E-mail ou senha inválidos.');
        exit;
    }
}
?>