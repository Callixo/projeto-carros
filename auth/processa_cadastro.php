<?php
require '../config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    // Validações
    if (empty($nome) || empty($email) || empty($senha)) {
        header('Location: ../cadastro.php?error=Todos os campos são obrigatórios.');
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: ../cadastro.php?error=Formato de e-mail inválido.');
        exit;
    }

    // Verifica se o e-mail já existe
    $sql_check = "SELECT id FROM usuarios WHERE email = ?";
    $stmt_check = $pdo->prepare($sql_check);
    $stmt_check->execute([$email]);
    if ($stmt_check->rowCount() > 0) {
        header('Location: ../cadastro.php?error=Este e-mail já está cadastrado.');
        exit;
    }

    // Criptografa a senha (MUITO IMPORTANTE!)
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Insere o usuário no banco de dados
    try {
        $sql = "INSERT INTO usuarios (nome, email, senha, perfil) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        // Por padrão, todo novo usuário é 'comum'. Apenas um 'master' pode promover outro.
        $stmt->execute([$nome, $email, $senha_hash, 'comum']);

        header('Location: ../login.php?success=Cadastro realizado com sucesso! Faça o login.');
        exit;
    } catch (PDOException $e) {
        header('Location: ../cadastro.php?error=Erro ao cadastrar. Tente novamente.');
        exit;
    }
}
?>