<?php
// O header já cuida da sessão e da verificação de login
$titulo_pagina = 'Consulta de Usuários';
require 'includes/header.php';

// VERIFICAÇÃO DE PERFIL DE ACESSO
// Apenas usuários 'master' podem acessar esta página
if (!isset($_SESSION['usuario_perfil']) || $_SESSION['usuario_perfil'] !== 'master') {
    echo '<div class="mensagem-erro">Acesso negado. Você não tem permissão para acessar esta página.</div>';
    require 'includes/footer.php';
    exit; // Encerra a execução do script
}

require 'config/conexao.php';

// LÓGICA PARA EXCLUSÃO DE USUÁRIO
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['excluir_id'])) {
    $id_para_excluir = $_POST['excluir_id'];

    // Para segurança, não permite que o 'master' se autoexclua
    if ($id_para_excluir == $_SESSION['usuario_id']) {
        $mensagem_erro = "Você não pode excluir seu próprio usuário.";
    } else {
        try {
            // A exclusão em cascata (ON DELETE CASCADE) no BD cuidará das respostas de segurança e logs
            $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
            $stmt->execute([$id_para_excluir]);
            $mensagem_sucesso = "Usuário excluído com sucesso!";
        } catch (PDOException $e) {
            $mensagem_erro = "Erro ao excluir usuário: " . $e->getMessage();
        }
    }
}


// LÓGICA PARA BUSCA DE USUÁRIOS
$busca = isset($_GET['busca']) ? trim($_GET['busca']) : '';
$sql = "SELECT id, nome_completo, login, perfil, data_cadastro FROM usuarios";
if (!empty($busca)) {
    // Usando LIKE para buscar por parte do nome ou do login
    $sql .= " WHERE nome_completo LIKE ? OR login LIKE ?";
    $params = ["%$busca%", "%$busca%"];
} else {
    $params = [];
}
$sql .= " ORDER BY nome_completo ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="admin-container">
    <header class="admin-header">
        <h1>Gerenciamento de Usuários</h1>
        <form method="GET" action="consulta_usuarios.php" class="search-form">
            <input type="text" name="busca" placeholder="Buscar por nome ou login..." value="<?php echo htmlspecialchars($busca); ?>">
            <button type="submit" class="btn"><i class="fa-solid fa-search"></i> Buscar</button>
        </form>
    </header>

    <?php if (isset($mensagem_sucesso)): ?>
        <div class="mensagem-sucesso"><?php echo $mensagem_sucesso; ?></div>
    <?php endif; ?>
    <?php if (isset($mensagem_erro)): ?>
        <div class="mensagem-erro"><?php echo $mensagem_erro; ?></div>
    <?php endif; ?>

    <div class="table-wrapper">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome Completo</th>
                    <th>Login</th>
                    <th>Perfil</th>
                    <th>Data de Cadastro</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($usuarios) > 0): ?>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?php echo $usuario['id']; ?></td>
                            <td><?php echo htmlspecialchars($usuario['nome_completo']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['login']); ?></td>
                            <td><?php echo ucfirst($usuario['perfil']); ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($usuario['data_cadastro'])); ?></td>
                            <td class="actions">
                                <form method="POST" action="consulta_usuarios.php" onsubmit="return confirm('Tem certeza que deseja excluir este usuário? Esta ação não pode ser desfeita.');">
                                    <input type="hidden" name="excluir_id" value="<?php echo $usuario['id']; ?>">
                                    <button type="submit" class="btn-action btn-delete" title="Excluir Usuário">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">Nenhum usuário encontrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require 'includes/footer.php'; ?>