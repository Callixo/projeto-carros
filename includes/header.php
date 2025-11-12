<?php
// Inicia a sessão em todas as páginas que incluem este header
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo_pagina ?? 'Sistema Web'; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <header class="main-header">
        <div class="container">
            <a href="painel.php" class="logo">MeuSistema</a>

            <nav class="main-nav">
                <ul>
                    <li><a href="index.php">Início</a></li>
                    <?php if (isset($_SESSION['usuario_perfil']) && $_SESSION['usuario_perfil'] === 'master'): ?>
                        <li class="nav-admin-link"><a href="consulta_usuarios.php">Usuários</a></li>
                        <li class="nav-admin-link"><a href="consulta_logs.php">Logs</a></li>
                    <?php endif; ?>
                    </ul>
            </nav>

            <div class="header-right">
                <div class="accessibility-bar">
                    <button id="decrease-font" class="accessibility-btn" title="Diminuir Fonte">A-</button>
                    <button id="increase-font" class="accessibility-btn" title="Aumentar Fonte">A+</button>
                    <button id="toggle-contrast" class="accessibility-btn" title="Alternar Contraste"><i class="fa-solid fa-circle-half-stroke"></i></button>
                </div>

                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <div class="user-dropdown">
                        <span>Olá, <?php echo htmlspecialchars(explode(' ', $_SESSION['usuario_nome'])[0]); ?> <i class="fa-solid fa-caret-down"></i></span>
                        <div class="dropdown-content">
                            <a href="alterar_senha.php">Alterar Senha</a>
                            <a href="auth/logout.php">Sair</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <div class="main-content">
        <div class="container">