<?php
$qtdPromo = explode(', ', $campaign['qtd_promo']);
$qtdPrice = explode(', ', $campaign['price_promo']);
?>

<div class="promotions">
    <div class="promotion-single">
        <h3>📣 Promoção</h3>
        <p>Compre mais barato!</p>
    </div>
    <div class="promotion-content">
        <?php if (isset($qtdPromo[0]) && isset($qtdPrice[0])): ?>
        <div class="qtd_n1">
            <span class="qtd_promo_1 st qtd_n1"><?php echo htmlspecialchars($qtdPromo[0]); ?></span> por R$<span class="price_promo_1 sp qtd_n1"><?php echo htmlspecialchars($qtdPrice[0]); ?></span>
        </div>
        <?php endif; ?>

        <?php if (isset($qtdPromo[1]) && isset($qtdPrice[1])): ?>
        <div class="qtd_n2">
            <span class="qtd_promo_2 st qtd_n2"><?php echo htmlspecialchars($qtdPromo[1]); ?></span> por R$<span class="price_promo_2 sp qtd_n2"><?php echo htmlspecialchars($qtdPrice[1]); ?></span>
        </div>
        <?php endif; ?>

        <?php if (isset($qtdPromo[2]) && isset($qtdPrice[2])): ?>
        <div class="qtd_n3">
            <span class="qtd_promo_3 st qtd_n3"><?php echo htmlspecialchars($qtdPromo[2]); ?></span> por R$<span class="price_promo_3 sp qtd_n3"><?php echo htmlspecialchars($qtdPrice[2]); ?></span>
        </div>
        <?php endif; ?>
    </div>
</div>
