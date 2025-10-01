<?php
    include 'includes/veiculos_db.php';

    $veiculo_encontrado = null;
    if (isset($_GET['id'])) {
        $id_veiculo = $_GET['id'];
        foreach ($veiculos as $veiculo) {
            if ($veiculo['id'] == $id_veiculo) {
                $veiculo_encontrado = $veiculo;
                break;
            }
        }
    }

    // Define o título da página
    if ($veiculo_encontrado) {
        $titulo_pagina = $veiculo_encontrado['marca'] . ' ' . $veiculo_encontrado['modelo'];
    } else {
        $titulo_pagina = 'Veículo não encontrado';
    }

    include 'includes/header.php';
?>

<div class="container section">
    <?php if ($veiculo_encontrado): ?>
        <div class="veiculo-detalhe-grid">
            <div class="veiculo-imagem-principal">
                <img src="<?php echo $veiculo_encontrado['imagem_principal']; ?>" alt="<?php echo $veiculo_encontrado['marca'] . ' ' . $veiculo_encontrado['modelo']; ?>">
            </div>
            <div class="veiculo-info">
                <h1><?php echo $veiculo_encontrado['marca'] . ' ' . $veiculo_encontrado['modelo']; ?></h1>
                <p class="preco">R$ <?php echo number_format($veiculo_encontrado['preco'], 2, ',', '.'); ?></p>

                <h3>Especificações</h3>
                <ul>
                    <li><strong>Ano:</strong> <?php echo $veiculo_encontrado['ano']; ?></li>
                    <li><strong>Motor:</strong> <?php echo $veiculo_encontrado['motor']; ?></li>
                    <li><strong>Potência:</strong> <?php echo $veiculo_encontrado['potencia']; ?></li>
                </ul>

                <h3>Modificações</h3>
                <ul>
                    <?php foreach ($veiculo_encontrado['modificacoes'] as $mod): ?>
                        <li><?php echo $mod; ?></li>
                    <?php endforeach; ?>
                </ul>
                <br>
                <a href="contato.php?interesse=<?php echo urlencode($veiculo_encontrado['modelo']); ?>" class="btn">Tenho Interesse</a>
            </div>
        </div>
    <?php else: ?>
        <h2 class="section-title">Veículo não encontrado</h2>
        <p style="text-align: center;">O veículo que você está procurando não existe ou foi removido.</p>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>