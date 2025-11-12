<?php
$titulo_pagina = 'Consulta de Logs';
require 'includes/header.php';

// VERIFICAÇÃO DE PERFIL DE ACESSO
if (!isset($_SESSION['usuario_perfil']) || $_SESSION['usuario_perfil'] !== 'master') {
    echo '<div class="mensagem-erro">Acesso negado. Você não tem permissão para acessar esta página.</div>';
    require 'includes/footer.php';
    exit;
}

require 'config/conexao.php';

// LÓGICA DE PAGINAÇÃO
$pagina_atual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$registros_por_pagina = 15;
$offset = ($pagina_atual - 1) * $registros_por_pagina;

// LÓGICA DE BUSCA
$busca_log = isset($_GET['busca_log']) ? trim($_GET['busca_log']) : '';
$where_clause = '';
$params = [];
if (!empty($busca_log)) {
    $where_clause = "WHERE u.nome_completo LIKE ? OR l.acao LIKE ?";
    $params = ["%$busca_log%", "%$busca_log%"];
}

// Primeiro, conta o total de registros para a paginação
$sql_total = "SELECT COUNT(*) FROM logs l LEFT JOIN usuarios u ON l.id_usuario = u.id " . $where_clause;
$stmt_total = $pdo->prepare($sql_total);
$stmt_total->execute($params);
$total_registros = $stmt_total->fetchColumn();
$total_paginas = ceil($total_registros / $registros_por_pagina);

// Agora, busca os registros da página atual
$sql_logs = "SELECT l.id, l.acao, l.data_hora, u.nome_completo 
             FROM logs l 
             LEFT JOIN usuarios u ON l.id_usuario = u.id 
             $where_clause
             ORDER BY l.data_hora DESC 
             LIMIT $registros_por_pagina OFFSET $offset";
$stmt_logs = $pdo->prepare($sql_logs);
$stmt_logs->execute($params);
$logs = $stmt_logs->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="admin-container">
    <header class="admin-header">
        <h1>Logs do Sistema</h1>
        <form method="GET" action="consulta_logs.php" class="search-form">
            <input type="text" name="busca_log" placeholder="Buscar em logs..." value="<?php echo htmlspecialchars($busca_log); ?>">
            <button type="submit" class="btn"><i class="fa-solid fa-search"></i> Buscar</button>
        </form>
    </header>

    <div class="table-wrapper">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuário</th>
                    <th>Ação</th>
                    <th>Data e Hora</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($logs) > 0): ?>
                    <?php foreach ($logs as $log): ?>
                        <tr>
                            <td><?php echo $log['id']; ?></td>
                            <td><?php echo $log['nome_completo'] ? htmlspecialchars($log['nome_completo']) : 'Sistema'; ?></td>
                            <td><?php echo htmlspecialchars($log['acao']); ?></td>
                            <td><?php echo date('d/m/Y H:i:s', strtotime($log['data_hora'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">Nenhum log encontrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="pagination">
        <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
            <a href="?pagina=<?php echo $i; ?>&busca_log=<?php echo urlencode($busca_log); ?>" class="<?php echo ($i == $pagina_atual) ? 'active' : ''; ?>">
                <?php echo $i; ?>
            </a>
        <?php endfor; ?>
    </div>
</div>

<?php require 'includes/footer.php'; ?>