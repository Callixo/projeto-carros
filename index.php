<?php
    $titulo_pagina = 'Tuned Garage - Seu Sonho Modificado Começa Aqui';
    include 'includes/header.php';
    include 'includes/veiculos_db.php';
?>

<section class="hero">
    <div class="hero-content">
        <h1>CARROS FEITOS PARA ENTUSIASTAS</h1>
        <p>Encontre o projeto dos seus sonhos, pronto para acelerar.</p>
        <a href="estoque.php" class="btn">Ver Estoque</a>
    </div>
</section>

<div class="container section">
    <h2 class="section-title">Destaques</h2>
    <div class="veiculos-grid">
        <?php
            // Pega os 3 primeiros carros do array para destacar
            $destaques = array_slice($veiculos, 0, 3);
            foreach ($destaques as $veiculo) {
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