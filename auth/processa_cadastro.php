<?php
require '../config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Se o método não for POST, redireciona
    header('Location: ../cadastro.php');
    exit;
}

// 1. Coleta de dados do formulário
$nome_completo = trim($_POST['nome_completo']);
$data_nascimento = trim($_POST['data_nascimento']);
$sexo = trim($_POST['sexo']);
$nome_materno = trim($_POST['nome_materno']);
$cpf = trim($_POST['cpf']);
$telefone_celular = trim($_POST['telefone_celular']);
$telefone_fixo = trim($_POST['telefone_fixo']);
$endereco_completo = trim($_POST['endereco_completo']);
$login = trim($_POST['login']);
$senha = trim($_POST['senha']);
$confirmar_senha = trim($_POST['confirmar_senha']);
$respostas_seguranca = $_POST['respostas'];

// 2. Validações do Servidor (essencial para segurança)

// Regra: Campos obrigatórios
foreach ($_POST as $key => $value) {
    if (empty($value)) {
        redirectWithError("O campo '$key' é obrigatório.");
    }
}

// Regra: Nome completo (mínimo 15, máximo 80)
if (strlen($nome_completo) < 15 || strlen($nome_completo) > 80) {
    redirectWithError("O nome completo deve ter entre 15 e 80 caracteres.");
}

// Regra: Login (mínimo 6)
if (strlen($login) < 6) {
    redirectWithError("O login deve ter no mínimo 6 caracteres.");
}

// Regra: Senha (mínimo 8, com letra, número e símbolo)
if (strlen($senha) < 8 || !preg_match('/[A-Za-z]/', $senha) || !preg_match('/[0-9]/', $senha) || !preg_match('/[^A-Za-z0-9]/', $senha)) {
    redirectWithError("A senha deve ter no mínimo 8 caracteres e conter letras, números e pelo menos um símbolo.");
}

// Regra: Confirmação de Senha
if ($senha !== $confirmar_senha) {
    redirectWithError("As senhas não coincidem.");
}

// Regra: CPF e Login devem ser únicos
$stmt = $pdo->prepare("SELECT id FROM usuarios WHERE cpf = ? OR login = ?");
$stmt->execute([$cpf, $login]);
if ($stmt->rowCount() > 0) {
    redirectWithError("CPF ou Login já cadastrados no sistema.");
}

// 3. Inserção no Banco de Dados
$pdo->beginTransaction(); // Inicia uma transação para garantir a consistência

try {
    // Criptografa a senha do usuário
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Insere o usuário
    $sql_user = "INSERT INTO usuarios (nome_completo, data_nascimento, sexo, nome_materno, cpf, telefone_celular, telefone_fixo, endereco_completo, login, senha) 
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_user = $pdo->prepare($sql_user);
    $stmt_user->execute([$nome_completo, $data_nascimento, $sexo, $nome_materno, $cpf, $telefone_celular, $telefone_fixo, $endereco_completo, $login, $senha_hash]);
    
    // Pega o ID do usuário recém-criado
    $id_usuario = $pdo->lastInsertId();

    // Insere as respostas de segurança com HASH
    $sql_sec = "INSERT INTO respostas_seguranca (id_usuario, pergunta, resposta) VALUES (?, ?, ?)";
    $stmt_sec = $pdo->prepare($sql_sec);

    foreach ($respostas_seguranca as $pergunta => $resposta) {
        if (empty($resposta)) {
            throw new Exception("Todas as respostas de segurança são obrigatórias.");
        }
        $resposta_hash = password_hash(strtolower(trim($resposta)), PASSWORD_DEFAULT);
        $stmt_sec->execute([$id_usuario, $pergunta, $resposta_hash]);
    }

    $pdo->commit(); // Confirma as operações se tudo deu certo

    // Redireciona para o login com mensagem de sucesso
    header('Location: ../login.php?success=Cadastro realizado com sucesso! Faça o login.');
    exit;

} catch (Exception $e) {
    $pdo->rollBack(); // Desfaz as operações se algo deu errado
    redirectWithError("Erro ao realizar o cadastro: " . $e->getMessage());
}

// Função auxiliar para redirecionar com erro
function redirectWithError($message) {
    header('Location: ../cadastro.php?error=' . urlencode($message));
    exit;
}
?>