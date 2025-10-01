<?php
    $titulo_pagina = 'Nosso Estoque - Tuned Garage';
    include 'includes/header.php';
    include 'includes/veiculos_db.php';
?>

<div class="container section">
    <h2 class="section-title">Nosso Estoque</h2>
    <div class="veiculos-grid">
        <?php
            foreach ($veiculos as $veiculo) {
                echo '
                <div class="veiculo-card">
                    <a href="veiculo.php?id=' . $veiculo['id'] . '">
                        <img src="' . $veiculo['imagem_principal'] . '" alt="' . $veiculo['marca'] . ' ' . $veiculo['modelo'] . '">
                        <div class="veiculo-card-content">
                            <h3>' . $veiculo['marca'] . ' ' . $veiculo['modelo'] . '</h3>
                            <p class="preco">R$ ' . number_format($veiculo['preco'], 2, ',', '.') . '</p>
                            <p>' . $veiculo['ano'] . ' &middot; ' . $veiculo['potencia'] . '</p>
                            <a href="veiculo.php?id=' . $veiculo['id'] . '" class="btn">Ver Detalhes</a>
                        </div>
                    </a>
                </div>
                ';
            }
        ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>